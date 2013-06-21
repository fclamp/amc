#!/usr/bin/perl -w 

#
#  Copyright (c) 1998-2009 KE Software Pty Ltd
#

use strict;
no warnings 'redefine';

sub
BuildData
{
	my %data;
	my $replication_date;

	if (! opendir(DIR, $ENV{'EMUPATH'}))
	{
		die "Error: could not open directory $ENV{'EMUPATH'}: $!";
	}
	foreach my $file (readdir(DIR))
	{
		if ($file =~ /^\.emuweb-env-(\d{4})-(\d{2})-(\d{2})-\d{2}-\d{2}$/)
		{
			$replication_date = "$2/$3/$1";
		}
	}
	if (! closedir(DIR))
	{
		die "Error: could not close directory $ENV{'EMUPATH'}: $!";
	}

	%data =
	(
		'nmnh-botany' =>
		{
			BasisOfRecord => 
			{
				S =>
				{
                       			'bulky fruit' => 1, 
                       			'bulky specimen' => 1,
                       			'discarded bulky specimen' => 1,
                       			'leaf' => 1,
                       			'liquid preserved' => 1,
                       			'microslide' => 1,
                       			'packet' => 1,
                       			'part bulky specimen' => 1,
                       			'part discarded bulky specimen' => 1,
                       			'specimen' => 1,
                       			'pressed specimen' => 1,
                       			'seed' => 1,
                       			'seedlings' => 1,
                       			'sem stub' => 1,
                       			'tissue culture' => 1,
                       			'unknown part' => 1,
        		               	'unknown whole' => 1,
		                       	'unmounted  material' => 1,
		                       	'wet lot' => 1,
		                       	'wood specimen' => 1
				},
				P =>
				{
                       			'mounted literature' => 1
				},
				I =>
				{
                       			'photo' => 1,
                       			'sem micrograph' => 1
				},
				L =>
				{
		                       	'bulb' => 1,
               		        	'cutting & seed' => 1,
		                       	'cutting; seed' => 1,
               		        	'cutting' => 1,
               		        	'plant' => 1,
               		        	'propagules' => 1,
               		        	'rhizome; seed' => 1,
               		        	'rhizome' => 1,
               		        	'rhizomes' => 1,
               		        	'seed' => 1,
               		        	'seeds' => 1,
               		        	'tuber' => 1,
				},
			},
			Citation => 'Department of Botany, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Botany:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebbotweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebbotweb/pages/nmnh/bot/Display.php?irn='
		},
		'nmnh-entomology' =>
		{
			BasisOfRecord =>
			{
			},
			Citation => 'Department of Entomology, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Entomology:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebentoweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebentoweb/pages/nmnh/ento/Display.php?irn='

		},
		'nmnh-iz' =>
		{
			BasisOfRecord =>
			{
				S =>
				{
					'specimen/lot' => 1
				},
				I =>
				{
					'image' => 1
				}
			},
			Citation => 'Department of Invertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Invertebrate_Zoology:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebizweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebizweb/pages/nmnh/iz/Display.php?irn='

		},
		'nmnh-vzbirds' =>
		{
			BasisOfRecord =>
			{
				S => 
				{
					'specimen/lot' => 1
				}
			},
			Citation => 'Department of Vertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Birds:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzbirdsweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzbirdsweb/pages/nmnh/vz/DisplayBirds.php?irn='
		},
		'nmnh-vzfishes'	=>
		{
			BasisOfRecord =>
			{
				S =>
				{
					'specimen/lot' => 1
				},
			},
			Citation => 'Department of Vertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Fishes:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzfishesweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzfishesweb/pages/nmnh/vz/DisplayFishes.php?irn='
		},
		'nmnh-vzherps' =>
		{
			BasisOfRecord =>
			{
				S =>
				{
					'specimen/lot' => 1,
					'specimen' => 1,
					'lot' => 1
				},
			},
			Citation => 'Department of Vertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Herps:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzherpsweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzherpsweb/pages/nmnh/vz/DisplayHerps.php?irn='
		},
		'nmnh-vzmammals' =>
		{
			BasisOfRecord =>
			{
				S =>
				{
					'specimen/lot' => 1,
					'uncataloged specimen' => 1,
					'vertebrate paleontology specimen' => 1
				},
				P =>
				{
					'literature of file reference' => 1
				},
				O =>
				{
					'observation' => 1
				}

			},
			Citation => 'Department of Vertebrate Zoology, Research and Collections Information System, NMNH, Smithsonian Institution',
			GlobalUniqueIdentifier => 'urn:lsid:nmnh.si.edu:Vertebrate_Zoology.Mammals:',
			ImageURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzmammalsweb/objects/common/webmedia.php?irn=',
			RecordURL => 'http://' . $ENV{'EMUWEBHOST'} . '.si.edu/emuwebvzmammalsweb/pages/nmnh/vz/DisplayMammals.php?irn='
		}
	);

	if (defined($replication_date))
	{
		$data{'nmnh-botany'}->{'Citation'} .= ', ' . $replication_date;
		$data{'nmnh-iz'}->{'Citation'} .= ', ' . $replication_date;
		$data{'nmnh-vzbirds'}->{'Citation'} .= ', ' . $replication_date;
		$data{'nmnh-vzfishes'}->{'Citation'} .= ', ' . $replication_date;
		$data{'nmnh-vzherps'}->{'Citation'} .= ', ' . $replication_date;
		$data{'nmnh-vzmammals'}->{'Citation'} .= ', ' . $replication_date;
	}

	###
	### THE HASH REFERENCE RETURNED HERE IS USED LATER AS THE 4TH ARGUMENT TO GetData() BELOW
	###
	return \%data;
}
#==============================================================================================================
#==============================================================================================================
sub
GetData
{
	my $record = shift;
	my $field = shift;
	my $column = shift;
	my $resourceCode = shift;
	my $data = shift;

	my $resourceData = $data->{$resourceCode};
	my $returnData;

	if ($field eq 'BasisOfRecord')
	{
		if (defined($record->{'CatObjectType'}) && $record->{'CatObjectType'} ne '')
		{
			$returnData = lc($record->{'CatObjectType'});
			if (exists($resourceData->{$field}->{'S'}->{"$returnData"}))
			{
				$returnData = 'S';
			}
			elsif (exists($resourceData->{$field}->{'P'}->{"$returnData"}))
			{
				$returnData = 'P';
			}
			elsif (exists($resourceData->{$field}->{'I'}->{"$returnData"}))
			{
				$returnData = 'I';
			}
			elsif (exists($resourceData->{$field}->{'L'}->{"$returnData"}))
			{
				$returnData = 'L';
			}
			elsif (exists($resourceData->{$field}->{'O'}->{"$returnData"}))
			{
				$returnData = 'O';
			}
			else
			{
				$returnData = 'unknown';
			}
		}
	}
	elsif ($field eq 'Citation')
	{
		$returnData = $resourceData->{$field};
	}
	elsif ($field eq 'DateLastModified')
	{
		my $date = $record->{'AdmDateModified'};
		my $time = $record->{'AdmTimeModified'};
		$returnData = GetDateLastModified($date, $time);
	}
	elsif ($field eq 'GlobalUniqueIdentifier')
	{
		if (defined($record->{$column}) && $record->{$column} ne '')
		{
			$returnData = $resourceData->{$field} . $record->{$column};
		}
	}
	elsif ($field eq 'ImageURL')
	{
		if (defined($record->{$column}) && $record->{$column} ne '')
		{
			$returnData = '';
			my @IRNS = split(/;/, $record->{$column});
			foreach my $irn (@IRNS)
			{
				$irn =~ s/^\s+|\s+$//g;
				$returnData .= '; ' if ($returnData ne '');
				$returnData .= $resourceData->{$field} . $irn;
			}
		}
	}
	elsif ($field eq 'RecordURL')
	{
		if (defined($record->{'irn'}) && $record->{'irn'} ne '')
		{
			$returnData = $resourceData->{$field} . $record->{'irn'};
		}
	}
	elsif ($field eq 'RelatedCatalogedItems')
	{
		if (defined($record->{'RelRelatedObjectGUIDLocal'}) && $record->{'RelRelatedObjectGUIDLocal'} ne '')
		{
			$returnData = '';
			my @GUIDS = split(/;/, $record->{'RelRelatedObjectGUIDLocal'});
			foreach my $guid (@GUIDS)
			{
				$guid =~ s/^\s+|\s+$//g;

				$returnData .= '; ' if ($returnData ne '');
				$returnData .= $resourceData->{$field} . $guid;
			}
		}
	}
	else
	{
		$returnData = $record->{$column};
	}

	return $returnData;
}
#==============================================================================================================
#==============================================================================================================
sub
GetResourceCode
{
	my $record = shift;
	my $resourceCode;
	my $department;
	my $division;

	$department = $record->{'CatDepartment'};

	if (defined($department) && $department ne '')
	{
		if (lc($department) eq 'botany')
		{
			$resourceCode = 'nmnh-botany';
		}
		elsif (lc($department) eq 'entomology')
		{
			$resourceCode = 'nmnh-entomology';
		}
		elsif (lc($department) eq 'invertebrate zoology')
		{
			$resourceCode = 'nmnh-iz';
		}
		elsif (lc($department) eq 'vertebrate zoology')
		{
			$division = $record->{'CatDivision'};

			if (defined($division) && $division ne '')
			{
				if (lc($division) eq 'birds')
				{
					$resourceCode = 'nmnh-vzbirds';
				}
				elsif (lc($division) eq 'fishes')
				{
					$resourceCode = 'nmnh-vzfishes';
				}
				elsif (lc($division) eq 'amphibians & reptiles')
				{
					$resourceCode = 'nmnh-vzherps';
				}
				elsif (lc($division) eq 'mammals')
				{
					$resourceCode = 'nmnh-vzmammals';
				}
			}
		}
	}
	return $resourceCode;
}
#==============================================================================================================
#==============================================================================================================
1;
