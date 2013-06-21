<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/nmnh/NmnhDisplayObjects.php');

//=====================================================================================================
//=====================================================================================================
class
NmnhPalStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhPalStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsRef->etaxonomy->SummaryData';

		// START - Catalog Number
		$catNumber = new FormatField;
		$catNumber->Name = 'CatNumber';
		$catNumber->Format = $this->BuildCatalogNumberFormat(' ', '.');
		// END - Catalog Number 

		// START common name
                $commonName = new FormatField;
                $commonName->Name = 'IdeCommonNameLocal_tab';
                $commonName->Format = $this->BuildCommonNameFormat();
		// END common name

		// START - Identification
		$filedAsQualifiedName = new Field;
		$filedAsQualifiedName->ColName = 'IdeFiledAsQualifiedNameWeb';
		
		$filedAsIdentifiedBy = new Field;
		$filedAsIdentifiedBy->ColName = 'IdeFiledAsIdentifiedByRef->eparties->SummaryData';
		
		$filedAsQualifiedNameTable = new Table;
		$filedAsQualifiedNameTable->Name = 'IdeFiledAsQualifiedNameWeb';
		$filedAsQualifiedNameTable->Headings = array('', 'Identified By');
		$filedAsQualifiedNameTable->Columns = array($filedAsQualifiedName, $filedAsIdentifiedBy);
		// END - Identification

                // START - Type Citations
                $typeCitations = new FormatField;
                $typeCitations->Name = 'TypeCitations';
                $typeCitationFormat = $this->BuildRawTypeCitationFormat();

                if (! empty($typeCitationFormat))
                {
                        $typeCitations->RawDisplay = 1;
                        $typeCitations->Format     = $typeCitationFormat;
                }
                else
                {
                        $typeCitations->Format = '';
                }
                // END - Type Citations

		// START - Other Identifications
		$otherQualifiedName = new Field;
		$otherQualifiedName->ColName = 'IdeOtherQualifiedNameWeb_tab';
		
		$otherIdentifiedBy = new Field;
		$otherIdentifiedBy->ColName = 'IdeOtherIdentifiedByWebRef_tab->eparties->SummaryData';
		
		$otherQualifiedNameTable = new Table;
		$otherQualifiedNameTable->Name = 'IdeOtherQualifiedNameWeb_tab';
		$otherQualifiedNameTable->Headings = array('', 'Identified By');
		$otherQualifiedNameTable->Columns = array($otherQualifiedName, $otherIdentifiedBy);
		// END - Other Identifications

		// START - Geologic Age
		$era = new Field;
		$era->ColName = 'AgeGeologicAgeEra_tab';
		
		$system = new Field;
		$system->ColName = 'AgeGeologicAgeSystem_tab';

		$series = new Field;
		$series->ColName = 'AgeGeologicAgeSeries_tab';
		
		$stage = new Field;
		$stage->ColName = 'AgeGeologicAgeStage_tab';
		
		$geologicAge = new Table;
		$geologicAge->Name = 'AgeGeologicAge';
		$geologicAge->Headings = array('Era', 'System', 'Series', 'Stage');
		$geologicAge->Columns = array($era, $system, $series, $stage);
		// END - Geologic Age

		// START - Stratigraphy
		$group = new Field;
		$group->ColName = 'AgeStratigraphyGroup_tab';
		
		$formation = new Field;
		$formation->ColName = 'AgeStratigraphyFormation_tab';

		$member = new Field;
		$member->ColName = 'AgeStratigraphyMember_tab';
		
		$stratigraphy = new Table;
		$stratigraphy->Name = 'AgeStratigraphy';
		$stratigraphy->Headings = array('Group', 'Formation', 'Member');
		$stratigraphy->Columns = array($group, $formation, $member);
		// END - Stratigraphy

		// START - site source, site/station number
                $siteSourceNumber = new FormatField;
                $siteSourceNumber->Name = 'BioEventSiteRef->ecollectionevents->LocSiteStationNumber';
                $siteSourceNumber->Format = '{BioEventSiteRef->ecollectionevents->LocSiteNumberSource}'; 
                $siteSourceNumber->Format = ' {BioEventSiteRef->ecollectionevents->LocSiteStationNumber}';
		// END - site source, site/station number

		$this->Fields = array
		(
			'IdeFiledAsRef->etaxonomy->SummaryData',
			$catNumber,
			'CatCollectionName_tab',
			'IdeTaxonRef_tab->etaxonomy->ClaKingdom', 		
			'IdeTaxonRef_tab->etaxonomy->ClaPhylum', 		
			'IdeTaxonRef_tab->etaxonomy->ClaClass', 		
			'IdeTaxonRef_tab->etaxonomy->ClaOrder', 		
			'IdeTaxonRef_tab->etaxonomy->ClaFamily', 		
			$commonName,
			$filedAsQualifiedNameTable,
			$otherQualifiedNameTable,
			$typeCitations,
                        'BioEventSiteRef->ecollectionevents->ColParticipantString',
			'BioEventSiteRef->ecollectionevents->ColDateVisitedFrom', 		
			'BioEventSiteRef->ecollectionevents->LocOcean',
			'BioEventSiteRef->ecollectionevents->LocSeaGulf',
			'BioEventSiteRef->ecollectionevents->LocBaySound',
			'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
			'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude',
                        'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude',
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'BioEventSiteRef->ecollectionevents->AquVesselName',
			'BioEventSiteRef->ecollectionevents->AquCruiseNumber',
			$siteSourceNumber,
			$geologicAge,
			$stratigraphy,
			'PalMorphologyCodes', 		
			'CatSpecimenCount', 		
                        'AdmDateModified',
		);
	}

	function
	BuildRawTypeCitationFormat()
	{
                $recordExtractor = new RecordExtractor();
                $recordExtractor->ExtractFields(array('WebTaxonRef_tab', 'WebTypeStatus_tab', 'WebVoucher_tab'));

                $webTaxRef = $recordExtractor->MultivalueFieldAsArray('WebTaxonRef_tab');
		$webTypeStatus = $recordExtractor->MultivalueFieldAsArray('WebTypeStatus_tab');
		$webVoucher = $recordExtractor->MultivalueFieldAsArray('WebVoucher_tab');

		$font = "font face=Arial size=2 color=#013567";

		$formatArray = array();
		for ($i = 0;$i < count($webTaxRef); $i++)
		{
			$scientificName = get('ClaScientificName', 'etaxonomy', $webTaxRef[$i]);
			$typeStatus = $webTypeStatus[$i];
			$voucher = $webVoucher[$i];

			if (! isset($typeStatus))
				$typeStatus = '';
			if (! isset($voucher))
				$voucher = '';

			$citedInArray = getColArray('CitCitedInRef_tab', 'etaxonomy', $webTaxRef[$i]);
			$specimenRefNesttab = getColArray('CitSpecimenRef_nesttab', 'etaxonomy', $webTaxRef[$i]);
			$typeStatusNesttab = getColArray('CitTypeStatus_nesttab', 'etaxonomy', $webTaxRef[$i]);
			$voucherNesttab = getColArray('CitVoucher_nesttab', 'etaxonomy', $webTaxRef[$i]);

			$citationArray = array();
			
			while(list($citedInRow, $citedInRef) = each($citedInArray))
			{
				if (preg_match("/^CitCitedInRef:(\d+)$/", $citedInRow, $match))
					$outerTableIndex = $match[1];	
				else
					continue;

				while(list($specimenRow, $specimenRef) = each($specimenRefNesttab))
				{
					if (preg_match("/^CitSpecimenRef:$outerTableIndex:(\d+)$/", $specimenRow, $match))
						$innerTableIndex = $match[1];	
					else
						continue;

					if ($specimenRef == $this->IRN)
					{
						$currentTypeStatus = $typeStatusNesttab->{"CitTypeStatus:$outerTableIndex:$innerTableIndex"};
						$currentVoucher = $voucherNesttab->{"CitVoucher:$outerTableIndex:$innerTableIndex"};

						if (! isset($currentTypeStatus))
							$currentTypeStatus = '';
						if (! isset($currentVoucher))
							$currentVoucher = '';

						if ($currentTypeStatus == $typeStatus &&
						    $currentVoucher == $voucher)
						{
							$citedInSumData = get('SummaryData', 'ebibliography', $citedInRef);

							if (! empty($citedInSumData))
							{
								array_push($citationArray, $citedInSumData);
							}
						}
					}
				}
				reset($specimenRefNesttab);
			}

			if (! empty ($citationArray) || ! empty ($typeStatus) || ! empty ($voucher))
			{
				$row = "\n\t<td><$font>$scientificName</font></td>";
				$row .= "\n\t<td><$font>$typeStatus</font></td>";
				$row .= "\n\t<td><$font>$voucher</font></td>";
				if (empty($citationArray))
				{
					$row .= "\n\t<td><$font></font></td>";
				}
				else
				{
					for ($j = 0; $j < count($citationArray); $j++)
					{
						if ($j < 1)
						{
							$row .= "\n\t<td><$font>$citationArray[$j]</font></td>";
						}
						else
						{
							$row .= "\n</tr>";
							$row .= "\n<tr>";
							$row .= "\n\t<td><$font></font></td>";
							$row .= "\n\t<td><$font></font></td>";
							$row .= "\n\t<td><$font></font></td>";
							$row .= "\n\t<td><$font>$citationArray[$j]</font></td>";
						}
					}
				}
				array_push($formatArray, $row);
			}
		}

		$format = '';
		if (! empty($formatArray))
		{
			$format .= "\n<!-- Start Sub Table -->\n";
			$format .= "<table border=0 cellpadding=1 cellspacing=0 width=100%>\n";
			$format .= "<tr>\n";
			$format .= "\t<td><b><$font>Published Name</font></b>&nbsp;&nbsp;</td>\n";
			$format .= "\t<td><b><$font>Primary Type Status</font></b>&nbsp;&nbsp;</td>\n";
			$format .= "\t<td><b><$font>Secondary Type Status</font></b>&nbsp;&nbsp;</td>\n";
			$format .= "\t<td><b><$font>Bibliographic Citations</font></b></td>\n";
			$format .= "</tr>\n";
			foreach ($formatArray as $cit)
			{
				$format .= "<tr>$cit\n</tr>\n";
			}
			$format .= "</table>\n";
			$format .= "<!-- End Sub Table -->\n";
		}
		return $format;
	}
}
//=====================================================================================================
//=====================================================================================================
?>
