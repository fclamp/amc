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
NmnhAnthStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhAnthStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		
		// Values used below - we only want to get them once
                $recEx = new RecordExtractor();
                $recEx->ExtractFields
                (
                        array
                        (
				'AccTransactorLocal_tab',
				'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->NamPartyType',
				'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->NamFullName',
				'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->SummaryData',
				'CatBarcode',
				'CatOtherNumbersType_tab',
				'CatOtherNumbersValue_tab',
                                'CulCultureRef_tab->eparties->SummaryData',
                                'CulCultureRef_tab->eparties->CulCulture2',
                                'CulCultureRef_tab->eparties->CulCulture3',
                                'CulCultureRef_tab->eparties->CulCulture4',
                                'CulCultureRef_tab->eparties->CulCulture5',
                                'CulCurrent_tab',
                                'IdeCurrentObjectName',
                       )
               );

		// START other numbers + other numbers type
		$allowedOtherNumTypes = array
		(
			'black\/white',
			'black\/white negative number',
			'color digital',
			'color digital number',
			'color negative',
			'color negative number',
			'color transparency',
			'color transparency number',
			'negative number',
			'slide number',
			'field number'
		);
		$pattern = implode('|', $allowedOtherNumTypes);

		$otherNumValArray = $recEx->MultivalueFieldAsArray('CatOtherNumbersValue_tab');
		$otherNumTypeArray = $recEx->MultivalueFieldAsArray('CatOtherNumbersType_tab');
		$otherNumDisplay = '';

		for ($i = 0; $i < count($otherNumTypeArray); $i++)
		{
			if (preg_match("/^(:?$pattern)$/i", $otherNumTypeArray[$i]))
			{
				$otherNumDisplay .= $otherNumTypeArray[$i] . ": " . $otherNumValArray[$i] . "\n";
			}
		}
		$otherNumbers = new FormatField;
		$otherNumbers->ColName = 'OtherNumbers';
		$otherNumbers->Format = $otherNumDisplay;
		// END other numbers + other numbers type

		// START Site Classification Details
		$arcSiteClass = new FormatField;
		$arcSiteClass->Format = '{ArcClassification1_tab} : {ArcClassification2_tab} : {ArcClassification3_tab} : {ArcClassification4_tab}';

		$objectDateKind = new Field;
		$objectDateKind->ColName = 'ArcObjectDateKind_tab';

		$objectDate = new Field;
		$objectDate->ColName = 'ArcObjectDate_tab';

		$objectDateMethod = new Field;
		$objectDateMethod->ColName = 'ArcObjectDateMethod_tab';

		$arcSiteClassTable = new Table;
		$arcSiteClassTable->Name = 'SiteClassDetails';
		$arcSiteClassTable->Headings = array('Date', 'Date Kind', 'Date Method', 'Classification');
		$arcSiteClassTable->Columns = array($objectDate, $objectDateKind, $objectDateMethod, $arcSiteClass);
		// END Site Classification Details

		// START - Participants 
		$partiesTypeCol = 'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->NamPartyType';
		$partiesNameCol = 'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->NamFullName';
		$partiesSumDataCol = 'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->SummaryData';

		$participantTypeArray = $recEx->MultivalueFieldAsArray($partiesTypeCol);
		$participantPersonArray = $recEx->MultivalueFieldAsArray($partiesNameCol);
		$participantOtherArray = $recEx->MultivalueFieldAsArray($partiesSumDataCol);

		$participantDisplay = '';

                for ($i = 0;$i < count($participantTypeArray); $i++)
                {
			if ($i == 0)
			{
				if (strtolower($participantTypeArray[$i]) == 'person')
				{
					$participantDisplay = $participantPersonArray[$i];
				}
				else
				{
					$participantDisplay = $participantOtherArray[$i];
				}
			}
			elseif ($i == (count($participantTypeArray) -1))
			{
				if (strtolower($participantTypeArray[$i]) == 'person')
				{
                			$participantDisplay .= " & " . $participantPersonArray[$i];
				}
				else
				{
                			$participantDisplay .= " & " . $participantOtherArray[$i];
				}
			}
			else
			{
				if (strtolower($participantTypeArray[$i]) == 'person')
				{
                			$participantDisplay .= ", " . $participantPersonArray[$i];
				}
				else
				{
                			$participantDisplay .= ", " . $participantOtherArray[$i];
				}

			}
		}
		$participant = new FormatField;
		$participant->Name = 'ColParticipants';
		$participant->Format = $participantDisplay;
		// END - Participants

		// START - Acquisition Source
		$donorArray = $recEx->MultivalueFieldAsArray('AccTransactorLocal_tab');
		$donorDisplay = '';

                for ($i = 0;$i < count($donorArray); $i++)
                {
			if (! empty($donorArray[$i]))
			{
				if ($i == 0)
				{
					$donorDisplay = $donorArray[$i];
				}
				elseif ($i == count($donorArray) - 1)
				{
                			$donorDisplay .= " & " . $donorArray[$i];
				}
				else
				{
                			$donorDisplay .= ", " . $donorArray[$i];
				}
			}
		}
		$donor = new FormatField;
		$donor->Name = 'AccTransactorLocal_tab';
		$donor->Format = $donorDisplay;
		// END - Acquisition Source

		// START - Specimen Count 
		$specimenCount = new FormatField;
		$specimenCount->Name = 'SpecimenCount';
		$specimenCount->Format = '{CatSpecimenCount} {CatSpecimenCountModifier}';
		// END - Specimen Count

		// START - Culture
		$currentCultureArray = $recEx->MultivalueFieldAsArray('CulCurrent_tab');
		$culture2Array = $recEx->MultivalueFieldAsArray('CulCultureRef_tab->eparties->CulCulture2');
		$culture3Array = $recEx->MultivalueFieldAsArray('CulCultureRef_tab->eparties->CulCulture3');
		$culture4Array = $recEx->MultivalueFieldAsArray('CulCultureRef_tab->eparties->CulCulture4');
		$culture5Array = $recEx->MultivalueFieldAsArray('CulCultureRef_tab->eparties->CulCulture5');

                $cultureDisplay     = '';

                for ($i = 0;$i < count($culture2Array); $i++)
                {
                        if (strtolower($currentCultureArray[$i]) == "yes")
                        {
                                $cultureDisplay .= $culture2Array[$i];

				if (! empty($culture3Array[$i]))
				{
					$cultureDisplay .= " : " . $culture3Array[$i];
				}
				if (! empty($culture4Array[$i]))
				{
					$cultureDisplay .= " : " . $culture4Array[$i];
				}
				if (! empty($culture5Array[$i]))
				{
					$cultureDisplay .= " : " . $culture5Array[$i];
				}
				$cultureDisplay .= "\n";
                        }
                }

                $culture = new FormatField;
                $culture->Name = 'CulCultureRef_tab->eparties->SummaryData';
                $culture->Format = $cultureDisplay;
		// END - Culture

		// START - Object Type
		$indexTerm = new FormatField;
		$indexTerm->Name = 'IdeCurrentIndexTerm';
		$indexTerm->Format = '';

		if (filled('IdeCurrentClassIndex', 'ecatalogue', $this->IRN))
		{
			$indexTerm->Format = '{IdeCurrentClassIndex}';
		}
		if (filled('IdeCurrentIndexTerm', 'ecatalogue', $this->IRN))
		{
			if (! empty($indexTerm->Format))
				$indexTerm->Format .= ' : {IdeCurrentIndexTerm}';
			else
				$indexTerm->Format = '{IdeCurrentIndexTerm}';
		}
		if (filled('IdeCurrentSubType', 'ecatalogue', $this->IRN))
		{
			if (! empty($indexTerm->Format))
				$indexTerm->Format .= ' : {IdeCurrentSubType}';
			else
				$indexTerm->Format = '{IdeCurrentSubType}';
		}
		if (filled('IdeCurrentVariety', 'ecatalogue', $this->IRN))
		{
			if (! empty($indexTerm->Format))
				$indexTerm->Format .= ' : {IdeCurrentVariety}';
			else
				$indexTerm->Format = '{IdeCurrentVariety}';
		}
		// END - Object Type
			
		// START - Notes
		$restricted_note_types = array
		(
			'asbestos',
			'repatriation'
		);

                $notes = new FormatField;
                $notes->Name = 'NotNmnhText0';
                $notes->Format = $this->BuildNotesFormat(false, NULL, $restricted_note_types);
                // END Notes

		// alternate header - done this way as emuweb can't handle two part
		// headers by default - see subclassed display() method in NmnhStandardDisplay
		$barcode = $recEx->FieldAsValue('CatBarcode');
		$objectName = $recEx->FieldAsValue('IdeCurrentObjectName');

		if ($barcode != '')
		{
			$this->OtherHeader = $barcode;
		}
		if ($objectName != '')
		{
			if ($this->OtherHeader != '')
			{
				$this->OtherHeader .= "; " . $objectName;
			}
			else
			{
				$this->OtherHeader = $objectName;
			}
		}

		$this->Fields = array
		(
			$header,
			'CatBarcode',
			$specimenCount,
			'CatDivision',
			'IdeCurrentObjectName',
			$indexTerm,
			'IdeTerm_tab',
			$culture,
			'BioEventSiteRef->ecollectionevents->LocContinent',
			'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
                        'BioEventSiteRef->ecollectionevents->LocTownship',
			'BioEventSiteRef->ecollectionevents->LocSiteName_tab',
			'BioEventSiteRef->ecollectionevents->LocSiteStationNumber',
			$arcSiteClassTable,
			$participant,
			'BioEventSiteRef->ecollectionevents->ColVerbatimDate',
			'AccAccessionLotRef_tab->eaccessionlots->LotLotNumber',
			$donor,
			'AccAccessionLotRef_tab->eaccessionlots->AcqDateOwnership',
			$otherNumbers,
			$notes,
                        'AdmDateModified',

		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
