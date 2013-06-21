#!/usr/bin/perl

#
#  Copyright (c) 1998-2012 KE Software Pty Ltd
#
use strict;
use warnings;
use ke::texapi;
use POSIX qw(strftime);
use IO::File;
$| = 1;

my $Prog = $0 =~ m:[^/]*$: ? $& : $0;
my $Server;
my $ResourceCode;
my $TimeZoneOffset;
my $NumSort = sub { $a <=> $b };
my $NatSort = sub { lc($a) cmp lc($b) };
my $MatchLimit;

my $client = substr($ENV{'EMUCATALOGUE'}, 1);
my $baseDir = "$ENV{'EMUPATH'}/web/webservices/digir";
my $outputDir = "$baseDir/inventory";
my $clientDir = "$baseDir/$client";

#
# Process command line args
#
while (@ARGV)
{
	$_ = shift;
       if (/^-l(.*)$/)
       {
                if ($1)
                {
			$MatchLimit = $1;
                }
                elsif (@ARGV)
                {
			$MatchLimit = shift;
                }
                else
                {
                	Usage();
                }
                next;
        }
       if (/^-o(.*)$/)
       {
                if ($1)
                {
			$outputDir = $1;
                }
                elsif (@ARGV)
                {
			$outputDir = shift;
                }
                else
                {
                	Usage();
                }
                next;
        }
	if (/^-/)
	{
		Usage();
	}
	unshift(@ARGV, $_);
	last;
}
if (@ARGV)
{
	if (@ARGV > 1)
	{
		Usage();
	}
	$ResourceCode = shift;
}

print "Started: " . localtime() . "\n";

if (defined($MatchLimit) && $MatchLimit !~ /^\d+$/)
{
	die "Error: match limit must be an integer value\n";
}
if (! -d $outputDir && ! mkdir($outputDir))
{
	die "Error: could not create output directory $outputDir: $!\n";
}

LoadSupportModules($clientDir);
my $inventory = GenerateInventory();
WriteInventory($outputDir, $inventory);

print "Finished: " . localtime() . "\n";
exit 0;

sub LoadSupportModules
{
	my $clientDir = shift;

	print "Loading modules...\n";

	use vars qw(%Schema);
	eval
	{
		require 'schema.pl';
	};
	if ($@)
	{
		die "Error: could not load schema.pl: $@\n";
	}

	if (-f "$clientDir/inventory.pl")
	{
		require "$clientDir/inventory.pl";
		if ($@)
		{
			die "Error: could not load client-specific inventory.pl: $@\n";
		}
	}

	eval 'use Sort::Naturally';
	if ($@)
	{
		warn "Warning: could not find Sort::Naturally module, using perl sort\n";
	}
	else
	{
		$NatSort = sub { ncmp($a, $b) };
	}
}

sub GenerateInventory
{
	my $inventory = {};
	print "Generating inventory values...\n";

	my $oldOpts;
	my $database = GetDatabase();
	if (defined($MatchLimit))
	{
		$oldOpts = $ENV{"${database}opts"};
		$ENV{"${database}opts"} .= " matchlimit=$MatchLimit";
	}
	$Server = ke::texapi->new();

	#
	# Setup signals to close down correctly if we are killed
	#
	$SIG{'TERM'} = $SIG{'QUIT'} = $SIG{'INT'} = $SIG{'HUP'} = \&ShutDown;

	my $texql = GetTexql();
	my @fields = GetFieldNames();
	my $cursor;
	my $count = 0;
	eval
	{
		$cursor = $Server->Cursor($texql);
		while (1)
		{
			$cursor->RowNext();
			my $irn = $cursor->ColFetch("irn");

			my $code;
			if (defined($ResourceCode))
			{
				$code = $ResourceCode;
			}
			else
			{
				$code = GetResourceCode($cursor);
				if (! defined($code))
				{
					warn "\tWarning: could not determine resource code for multimedia record irn $irn\n";
					next;
				}
			}
			$code = lc($code);

			foreach my $field (@fields)
			{
				my $value;
				eval
				{
					if (exists(&$field))
					{
						my $sub = \&$field;
						$value = &$sub($cursor, $code);
					}
					else
					{
						my $column = GetColumnName($field);
						#
						# Ignore columns that do not exist in the schema
						#
						if (! exists($Schema{$database}->{'columns'}->{$column}))
						{
							next;
						}
						$value = $cursor->ColFetch($column);
					}
				};
				if ($@)
				{
					chomp($@);
					warn "\tWarning: could not generate $field value for record irn $irn: $@\n";
				}
				if (! exists($inventory->{$code}->{$field}))
				{
					$inventory->{$code}->{$field} = {};
				}
				if (! defined($value) || $value eq "")
				{
					next;
				}
				$value = ModifyValue($value);
				if (! exists($inventory->{$code}->{$field}->{$value}))
				{
					$inventory->{$code}->{$field}->{$value} = 0;
				}
				$inventory->{$code}->{$field}->{$value}++;
			}
			$count++;
			if ($count % 10000 == 0)
			{
				print "\tProcessed $count records\n";
			}
		}
	};
	if ($@ && $@ !~ /^Server error: End of file\./i)
	{
		die "Error: $@\n";
	}
	eval
	{
		$cursor->Close();
        	$Server->Disconnect();
        	$Server = undef;
	};
	if (defined($oldOpts))
	{
		$ENV{"${database}opts"} = $oldOpts;
	}
	#
	# Restore the default signal handlers
	#
	$SIG{'TERM'} = $SIG{'QUIT'} = $SIG{'INT'} = $SIG{'HUP'} = 'DEFAULT';

	print "Processed a total of $count records\n";

	return $inventory;
}

sub GetTexql
{
	my $database = GetDatabase();
	my $texql = "select * from $database where true";
	my @mandatory = GetMandatoryFieldNames();
	foreach my $field (@mandatory)
	{
		my $column = GetColumnName($field);
		$texql .= " and $column is not null";
	}
	my $systemYes = GetSystemYes();
	$texql .= " and AdmPublishWebNoPassword contains '$systemYes'";
	if (defined(&GetRestrictions))
	{
		$texql .= GetRestrictions();
	}
	return $texql;
}

sub GetDatabase
{
	return "ecatalogue";
}

sub GetSystemYes
{
	my $systemYes = `emulutsdump 'System Yes'`;
	if (defined($systemYes))
	{
		chomp($systemYes);
	}
	if (! defined($systemYes) || $systemYes eq "")
	{
		die "Error: could not get System Yes value\n";
	}
	return $systemYes;
}

sub GetMandatoryFieldNames
{
	my @fields = qw
	(
		ScientificName
		CatalogNumber
		CollectionCode
		InstitutionCode
	);
	return @fields;
}

sub GetColumnName
{
	my $field = shift;

	return "Dar$field";
}

sub GetFieldNames
{
	my @fields = qw
	(
		AgeClass
		BasisOfRecord
		BoundingBox
		CatalogNumber
		CatalogNumberNumeric
		CatalogNumberText
		Citation
		Class
		CollectionCode
		Collector
		CollectorNumber
		Continent
		ContinentOcean
		CoordinatePrecision
		CoordinateUncertaintyInMeter
		Country
		County
		DateLastModified
		DayCollected
		DayIdentified
		DecimalLatitude
		DecimalLongitude
		DepthRange
		EndDayCollected
		EndJulianDay
		EndLatitude
		EndLongitude
		EndMonthCollected
		EndTimeOfDay
		EndYearCollected
		Family
		FieldNotes
		FieldNumber
		GMLFeature
		GenBankNum
		Genus
		GeodeticDatum
		GeorefMethod
		GlobalUniqueIdentifier
		HigherGeography
		HigherTaxon
		HorizontalDatum
		IdentificationModifier
		IdentificationQualifier
		IdentifiedBy
		ImageURL
		IndividualCount
		InfraspecificEpithet
		InfraspecificRank
		InstitutionCode
		Island
		IslandGroup
		JulianDay
		Kingdom
		LatLongComments
		Latitude
		LifeStage
		Locality
		Longitude
		MaximumDepth
		MaximumDepthInMeters
		MaximumElevation
		MaximumElevationInMeters
		MinimumDepth
		MinimumDepthInMeters
		MinimumElevation
		MinimumElevationInMeters
		MonthCollected
		MonthIdentified
		Notes
		ObservedIndividualCount
		ObservedWeight
		Order
		OriginalCoordinateSystem
		OtherCatalogNumbers
		Phylum
		PreparationType
		Preparations
		PreviousCatalogNumber
		RecordURL
		RelatedCatalogItem
		RelatedCatalogItems
		RelatedInformation
		RelationshipType
		Remarks
		ScientificName
		ScientificNameAuthor
		ScientificNameAuthorYear
		Sex
		Source
		Species
		SpecificEpithet
		StartDayCollected
		Start_EndCoordinatePrecision
		StartJulianDay
		StartLatitude
		StartLongitude
		StartMonthCollected
		StartTimeOfDay
		StartYearCollected
		StateProvince
		Subgenus
		Subspecies
		Temperature
		TimeCollected
		TimeOfDay
		TimeZone
		Tissues
		TypeStatus
		VerbatimCollectingDate
		VerbatimDepth
		VerbatimElevation
		VerbatimLatitude
		VerbatimLongitude
		WaterBody
		YearCollected
		YearIdentified
	);
	return @fields;
}

sub GetResourceCode
{
	my $cursor = shift;
	die "Error: could not get resource code\n";
}

sub ModifyValue
{
	my $value = shift;
	#
	# Do nothing by default
	#
	return $value;
}

sub WriteInventory
{
	my $outputDir = shift;
	my $inventory = shift;

	print "Writing inventory files...\n";
	foreach my $code (sort(keys(%$inventory)))
	{
		print "\t$code\n";
		if (! -d "$outputDir/$code" && ! mkdir("$outputDir/$code"))
		{
			die "Error: could not create directory $outputDir/$code: $!\n";
		}
		unlink(glob("$outputDir/$code/*.xml"));

		foreach my $field (sort(keys(%{$inventory->{$code}})))
		{
			print "\t\t$field\n";

			my $column = GetColumnName($field);
			my $dataType = lc($Schema{'ecatalogue'}->{'columns'}->{$column}->{'DataType'});

			my $sort;
			if ($dataType eq "integer" || $dataType eq "float")
			{
				$sort = $NumSort;
			}
			else
			{
				$sort = $NatSort;
			}

			my $file = "$outputDir/$code/$field.xml";
			my $fh = new IO::File($file, '>:encoding(utf-8)');
			if (! defined($fh))
			{
				die "Error: could not open file $file: $!\n";
			}
			my $matches = scalar(keys(%{$inventory->{$code}->{$field}}));
			$fh->print("<results status='success' matches='$matches'>\n");
			foreach my $value (sort $sort (keys(%{$inventory->{$code}->{$field}})))
			{
				my $count = $inventory->{$code}->{$field}->{$value};
				$value =~ s/&/\&amp;/g;
				$value =~ s/</\&lt;/g;
				$value =~ s/>/\&gt;/g;
				$value =~ s/'/\&apos;/g;
				$value =~ s/"/\&quot;/g;
				$fh->print("\t<record>\n", "\t\t<darwin:$field count='$count'>", $value, "</darwin:$field>\n", "\t</record>\n");
			}
			$fh->print("</results>\n");
			$fh->close();
		}
	}
}

sub ShutDown
{
        my $signal = shift;

        warn "Caught $signal signal; terminating...\n";
	#
	# Restore the default signal handlers
	#
	$SIG{'TERM'} = $SIG{'QUIT'} = $SIG{'INT'} = $SIG{'HUP'} = 'DEFAULT';
	if (defined($Server))
	{
        	$Server->Disconnect();
        	$Server = undef;
	}
        exit 1;
}

sub Usage
{
        print STDERR <<EOT;
Usage: $Prog [-l limit] [-o directory] [resource code]
Where
	-l limit	Only generate inventory entries for this many records. Primarily for testing.
	-o directory	Override the default output directory.
	resource code	Use this resource code for all records.
EOT
	exit(1);
}

#
# Subroutines to generate DwC values
#
sub DateLastModified
{
	my $cursor = shift;

	my $date = $cursor->ColFetch("AdmDateModified", "YYYY-MM-dd");
	my $time = $cursor->ColFetch("AdmTimeModified", "hh:mm:ss");
	if (! defined($TimeZoneOffset))
	{
		$TimeZoneOffset = GetTimeZoneOffset();
	}
	return "${date}T${time}${TimeZoneOffset}";
}

sub GetTimeZoneOffset
{
	my $offset = strftime("%z", localtime());
	if (! defined($offset))
	{
		$offset = "";
	}
	return $offset;
}
