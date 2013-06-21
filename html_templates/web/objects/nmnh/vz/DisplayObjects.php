<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
** This file contains the following classes.
**	NmnhVzHerpDisplay - For Herps records
**	NmnhVzBirdDisplay - For Bird records
**	NmnhVzFishDisplay - For Fish records
**	NmnhVzMammalDisplay - For Mammal records
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/nmnh/NmnhDisplayObjects.php');

$GLOBALS['STRINGS_DIR'] = $WEB_ROOT . "/objects/" . $GLOBALS['BACKEND_TYPE'] . "/" . $GLOBALS['DEPARTMENT'] . "/strings/" . $GLOBALS['BACKEND_ENV'] . "/";

//===================================================================================================================================
//===================================================================================================================================
class
NmnhVzFishesDisplay extends NmnhStandardDisplay
{
	function
	NmnhVzFishesDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsQualifiedNameWeb';

		// START - Catalog Number
                $catNumber = new FormatField;
                $catNumber->Name = 'CatNumber';
                $catNumber->Format = $this->BuildCatalogNumberFormat();
		// END - Catalog Number

		// START - Identification
		$qualifiedName = new Field;
		$qualifiedName->ColName = 'IdeFiledAsQualifiedNameWeb';

		$typeStatus = new Field;
		$typeStatus->ColName = 'IdeFiledAsTypeStatus';

		$identification = new Table;
		$identification->Name = 'ID';
		$identification->Headings = array('', 'Type Status');
		$identification->Columns = array($qualifiedName, $typeStatus);
		// END - Identification
		
		// START - Date Collected
                $dateCollected = new FormatField;
                $dateCollected->Name = 'Date Collected (dd/mm/yyyy)';
		$dateCollected->Format = $this->BuildDateCollectedFormat();
		// END - Date Collected

		// START - Depth
		$aquDepth = new FormatField;
                $aquDepth->Name = 'Depth (m)';
                $aquDepth->Format = $this->BuildDepthFormat();
		// END - Depth

		// START - Preparation Details
		$preparation = new Field;
		$preparation->ColName = 'ZooPreparation_tab';

		$preparationLocation = new Field;
		$preparationLocation->ColName = 'ZooPrepLocationRef_tab->elocations->SummaryData';

		$preparationCount = new Field;
		$preparationCount->ColName = 'ZooPreparationCount_tab';

		$zooPrepDetails = new Table;
		$zooPrepDetails->Name = 'Zoology Prep Details';
		$zooPrepDetails->Headings = array('Preparation', 'Location', 'Count');
		$zooPrepDetails->Columns = array($preparation, $preparationLocation, $preparationCount);
		// END - Preparation Details

		// START - Measurements
		$measurementType = new Field;
		$measurementType->ColName = 'MeaType_tab';

		$measurementValue = new Field;
		$measurementValue->ColName = 'MeaVerbatimValue_tab';

		$measurementUnit = new Field;
		$measurementUnit->ColName = 'MeaVerbatimUnit_tab';

		$measurements = new Table;
		$measurements->Name = 'Measurements';
		$measurements->Headings = array('Values', 'Units', 'Type');
		$measurements->Columns = array($measurementType, $measurementValue);
		// END - Measurements

		$this->Fields = array
		(
			'IdeFiledAsQualifiedNameWeb',
			$catNumber,
			'CatCollectionName_tab',
			'CatSpecimenCount',
			'IdeFiledAsRef->etaxonomy->ClaOrder', 	
			'IdeFiledAsRef->etaxonomy->ClaFamily', 
			'IdeFiledAsRef->etaxonomy->ClaSubfamily', 
			$identification,
			'IdeFiledAsRef->etaxonomy->CitCitedInRef_tab->ebibliography->SummaryData', 
			$dateCollected,
			'BioEventSiteRef->ecollectionevents->LocOcean',
                        'BioEventSiteRef->ecollectionevents->LocSeaGulf',
                        'BioEventSiteRef->ecollectionevents->LocArchipelago',
                        'BioEventSiteRef->ecollectionevents->LocIslandGrouping',
                        'BioEventSiteRef->ecollectionevents->LocIslandName',
			'BioEventSiteRef->ecollectionevents->LocContinent',
			'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude',
                        'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude',
			'BioEventSiteRef->ecollectionevents->ColParticipantString',
			'BioEventSiteRef->ecollectionevents->ColSiteVisitNumbers_tab',
			'BioEventSiteRef->ecollectionevents->AquVesselName',
			'BioEventSiteRef->ecollectionevents->AquCruiseNumber',
			'BioEventSiteRef->ecollectionevents->LocSiteStationNumber',
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'BioEventSiteRef->ecollectionevents->ColCollectionMethod',
			$aquDepth,
			'BioEventSiteRef->ecollectionevents->DepSourceOfSample',
			$zooPrepDetails,
			$measurements,
			'NotNmnhText0',
			'AccAccessionLotRef_tab->eaccessionlots->LotLotNumber',
                        'AdmDateModified',
		);
	}
}
//===================================================================================================================================
//===================================================================================================================================

class
NmnhVzHerpsDisplay extends NmnhStandardDisplay
{
	function
	NmnhVzHerpsDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsQualifiedNameWeb';

		// START - Catalog Number
		$catNumber = new FormatField;
		$catNumber->Name = 'CatNumber';
		$catNumber->Format = '{CatPrefix} {CatNumber} {CatSuffix}';
		// END - Catalog Number

		// START - Type Citations
		$typeCitations = new FormatField;
		$typeCitations->Name = 'TypeCitations';
		$typeCitationFormat = $this->BuildRawTypeCitationFormat();

		if (! empty($typeCitationFormat))
		{
			$typeCitations->RawDisplay = 1;
			$typeCitations->Format = $typeCitationFormat;
		}
		else
		{
			$typeCitations->Format = '';
		}
		// END - Type Citations
		
		// START - Notes
                $taxonomicNotes = new FormatField;
                $taxonomicNotes->Name = 'TaxononomyNotes';
                $taxonomicNotes->Format = $this->BuildNotesFormat(false, array('taxonomic remarks'), NULL);

                $statusNotes = new FormatField;
                $statusNotes->Name = 'StatusNotes';
                $statusNotes->Format = $this->BuildNotesFormat(false, array('status remarks', 'exchange remarks'), NULL);
		// END - Notes

                // START - Elevation
                $elevation = new FormatField;
                $elevation->Name = 'Elevation';
                $elevation->Format = $this->BuildElevationFormat();
		// END - Elevation

		// START - Prep Details
		$zooPrep = new Field;
		$zooPrep->ColName = 'ZooPreparation_tab';

		$zooPrepRem = new Field;
		$zooPrepRem->ColName = 'ZooPreparationRemarks_tab';

		$zooPrepDetails = new Table;
		$zooPrepDetails->Name = 'ZooPrepDetails';
		$zooPrepDetails->Headings = array('Preparation', 'Remarks');
		$zooPrepDetails->Columns = array($zooPrep, $zooPrepRem);
		// END - Prep Details

		// START - Field Number
                $fieldNumber = new FormatField;
                $fieldNumber->Name = 'Field Number(s)';
               	$fieldNumber->Format = $this->BuildFieldNumberFormat();
		// END - Field Number

		$this->Fields = array
		(
			'IdeFiledAsQualifiedNameWeb',
			$catNumber,
			'IdeFiledAsRef->etaxonomy->ClaClass', 		
			'IdeFiledAsRef->etaxonomy->ClaOrder', 	
			'IdeFiledAsRef->etaxonomy->ClaFamily', 
			'IdeFiledAsQualifiedNameWeb',
			'IdeOtherQualifiedNameWeb_tab',
			$typeCitations,
			$taxonomicNotes,
			'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude',
                        'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude',
			$elevation,
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->SummaryData',
			$fieldNumber,
			'BioEventSiteRef->ecollectionevents->ColVerbatimDate',
			$zooPrepDetails,
			'StaInventoryStatus_tab',
			$statusNotes,
                        'AdmDateModified',
		);
	}
}

//===================================================================================================================================
//===================================================================================================================================

class
NmnhVzBirdsDisplay extends NmnhStandardDisplay
{
	function
	NmnhVzBirdsDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsName';

		$recEx = new RecordExtractor();
                $recEx->ExtractFields
		(
			array
			(
				'MeaType_tab',
				'MeaVerbatimValue_tab',
				'MeaVerbatimUnit_tab',
			)
		);

		// START - Catalog Number
                $catNumber = new FormatField;
                $catNumber->Name = 'CatNumber';
                $catNumber->Format = $this->BuildCatalogNumberFormat();
		// END - Catalog Number

		// START - Type Citations
		$typeCitations = new FormatField;
		$typeCitations->Name = 'TypeCitations';
		$typeCitationFormat = $this->BuildRawTypeCitationFormat();

		if (! empty($typeCitationFormat))
		{
			$typeCitations->RawDisplay = 1;
			$typeCitations->Format = $typeCitationFormat;
		}
		else
		{
			$typeCitations->Format = '';
		}
		// END - Type Citations
		
		// START - Common Name
                $commonName = new FormatField;
                $commonName->Name = 'IdeCommonNameLocal_tab';
                $commonName->Format = $this->BuildCommonNameFormat();
		// END Common Name

		// START date visited from and date visited to 
                $dateCollected = new FormatField;
                $dateCollected->Name = 'Date Collected (dd/mm/yyyy)';
		$dateCollected->Format = $this->BuildDateCollectedFormat();
		// END date visited from and date visited to 

                // START - Elevation
                $elevation = new FormatField;
                $elevation->Name = "Elevation";
                $elevation->Format = $this->BuildElevationFormat();
                // END - Elevation

		// START - Field Number
                $fieldNumber = new FormatField;
                $fieldNumber->Name = 'Field Number(s)';
               	$fieldNumber->Format = $this->BuildFieldNumberFormat();
		// END - Field Number

		// START - Sex/Stage
		$zooSex = new Field;
		$zooSex->ColName = 'ZooSex_tab';

		$zooStage = new Field;
		$zooStage->ColName = 'ZooStage_tab';

		$zooRemarks = new Field;
		$zooRemarks->ColName = 'ZooSexStageRemarks_tab';

		$zooSexStageTable = new Table;
		$zooSexStageTable->Name = 'SexAndStage';
		$zooSexStageTable->Headings = array('Sex', 'Stage', 'Remarks');
		$zooSexStageTable->Columns = array($zooSex, $zooStage, $zooRemarks);
		// END - Sex/Stage

		// START - Preparations
		$zooPrep = new Field;
		$zooPrep->ColName = 'ZooPreparation_tab';

		$zooPrepRem = new Field;
		$zooPrepRem->ColName = 'ZooPreparationRemarks_tab';

		$zooPrepDetails = new Table;
		$zooPrepDetails->Name = 'ZooPrepDetails';
		$zooPrepDetails->Headings = array('Preparation', 'Remarks');
		$zooPrepDetails->Columns = array($zooPrep, $zooPrepRem);
		// END - Preparations

		// START - Weight Measurement 
                $measurementKind = $recEx->MultivalueFieldAsArray('MeaType_tab');
                $verbatimValue = $recEx->MultivalueFieldAsArray('MeaVerbatimValue_tab');
                $verbatimUnit = $recEx->MultivalueFieldAsArray('MeaVerbatimUnit_tab');
                $measurements = new FormatField;
                $measurements->Name = 'Measurements';
               	$measurements->Format = '';

                for ($i = 0;$i < count($measurementKind); $i++)
                {
                        if (strtolower($measurementKind[$i]) == "weight") 
                        {
                		$measurements->Format = $measurementKind[$i] . ': ' . $verbatimValue[$i] . ' ' . $verbatimUnit[$i];
				break;
                        }
                }
		// END - Weight Measurement

		$this->Fields = array
		(
			'IdeFiledAsName',
			$catNumber,
			'CatCollectionName_tab',
			'CatSpecimenCount',
			'IdeFiledAsQualifiedNameWeb',
			'IdeOtherQualifiedNameWeb_tab',
			$typeCitations,
			$commonName,
			$dateCollected,
			'BioEventSiteRef->ecollectionevents->LocOcean',
                        'BioEventSiteRef->ecollectionevents->LocSeaGulf',
			'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude',
                        'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude',
			$elevation,
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->SummaryData',
			$fieldNumber,
			$zooSexStageTable,
			$zooPrepDetails,
			$measurements,
			'NotNmnhText0',
                        'AdmDateModified',
		);
	}
}
//===================================================================================================================================
//===================================================================================================================================

class
NmnhVzMammalsDisplay extends NmnhStandardDisplay
{
	function
	NmnhVzMammalsDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsName';

		// START - Catalog Number
                $catNumber = new FormatField;
                $catNumber->Name = 'CatNumber';
                $catNumber->Format = $this->BuildFieldNumberFormat();
		// END - Catalog Number

		// START - Specimen Count
                $specimenCount = new FormatField;
                $specimenCount->Name = 'CatSpecimenCount';
                $specimenCount->Format = '{CatSpecimenCount} {CatSpecimenCountModifier}';
		// END - Specimen Count

		// START type citations
		$typeCitations = new FormatField;
		$typeCitations->Name = 'TypeCitations';
		$typeCitationFormat = $this->BuildRawTypeCitationFormat();

		if (! empty($typeCitationFormat))
		{
			$typeCitations->RawDisplay = 1;
			$typeCitations->Format = $typeCitationFormat;
		}
		else
		{
			$typeCitations->Format = '';
		}
		// END type citations
		
		// START date visited from and date visited to 
                $dateCollected = new FormatField;
                $dateCollected->Name = 'Date Collected (dd/mm/yyyy)';
		$dateCollected->Format = $this->BuildDateCollectedFormat();
		// END date visited from and date visited to 

                // START - Elevation
                $elevation = new FormatField;
                $elevation->Name = 'Elevation';
                $elevation->Format = $this->BuildElevationFormat();
		// END - Elevation

		// START - Other Numbers
		$otherNumbersType = new Field;
		$otherNumbersType->ColName = 'CatOtherNumbersType_tab';

		$otherNumbersValue = new Field;
		$otherNumbersValue->ColName = 'CatOtherNumbersValue_tab';

		$otherNumbers = new Table;
		$otherNumbers->Name = 'OtherNumbers';
		$otherNumbers->Headings = array('Type', 'Value');
		$otherNumbers->Columns = array($otherNumbersType, $otherNumbersValue);
		// END - Other Numbers

		// START - Sex/Stage
		$zooSex = new Field;
		$zooSex->ColName = 'ZooSex_tab';

		$zooStage = new Field;
		$zooStage->ColName = 'ZooStage_tab';

		$zooRemarks = new Field;
		$zooRemarks->ColName = 'ZooSexStageRemarks_tab';

		$zooSexStageTable = new Table;
		$zooSexStageTable->Name = 'SexAndStage';
		$zooSexStageTable->Headings = array('Sex', 'Stage', 'Remarks');
		$zooSexStageTable->Columns = array($zooSex, $zooStage, $zooRemarks);
		// END - Sex/Stage

		// START - Preparation
		$zooPrep = new Field;
		$zooPrep->ColName = 'ZooPreparation_tab';

		$zooPrepRem = new Field;
		$zooPrepRem->ColName = 'ZooPreparationRemarks_tab';

		$zooPrepDetails = new Table;
		$zooPrepDetails->Name = 'ZooPrepDetails';
		$zooPrepDetails->Headings = array('Preparation', 'Remarks');
		$zooPrepDetails->Columns = array($zooPrep, $zooPrepRem);
		// END - Preparation

		// START - Reproductive Condition
		$ReproductiveCondPart = new Field;
		$ReproductiveCondPart->ColName = 'VerReprodCondPart_tab';

		$ReproductiveCondLength = new Field;
		$ReproductiveCondLength->ColName = 'VerReprodCondLength_tab';

		$ReproductiveCondWidth = new Field;
		$ReproductiveCondWidth->ColName = 'VerReprodCondWidth_tab';

		$ReproductiveCondUnit = new Field;
		$ReproductiveCondUnit->ColName = 'VerReprodCondUnit_tab';

		$ReproductiveCondRemarks = new Field;
		$ReproductiveCondRemarks->ColName = 'VerReprodCondRemarks_tab';

		$ReproductiveCondition = new Table;
		$ReproductiveCondition->Name = 'ReproductiveCondition';
		$ReproductiveCondition->Headings = array('Part', 'Length', 'Width', 'Unit', 'Remarks');
		$ReproductiveCondition->Columns = array
		(
			$ReproductiveCondPart, 
			$ReproductiveCondLength, 
			$ReproductiveCondWidth, 
			$ReproductiveCondUnit, 
			$ReproductiveCondRemarks
		);
		// END - Reproductive Condition Table 

		// START - Progeny
		$ProgenyDetailsCount = new Field;
		$ProgenyDetailsCount->ColName = 'MamProgenyCount_tab';

		$ProgenyDetailsPart = new Field;
		$ProgenyDetailsPart->ColName = 'MamProgenyPart_tab';

		$ProgenyDetailsCrownRump = new Field;
		$ProgenyDetailsCrownRump->ColName = 'MamProgenyCrownRump_tab';

		$ProgenyDetailsUnit = new Field;
		$ProgenyDetailsUnit->ColName = 'MamProgenyUnit_tab';

		$ProgenyDetailsRemarks = new Field;
		$ProgenyDetailsRemarks->ColName = 'MamProgenyRemarks_tab';

		$ProgenyDetails = new Table;
		$ProgenyDetails->Name = 'ProgenyDetails';
		$ProgenyDetails->Headings = array('Count', 'Part', 'Crown Rump', 'Unit', 'Remarks');
		$ProgenyDetails->Columns = array
		(
			$ProgenyDetailsCount, 
			$ProgenyDetailsPart, 
			$ProgenyDetailsCrownRump, 
			$ProgenyDetailsUnit, 
			$ProgenyDetailsRemarks
		);
		// END - Progeny

		// START - Measurement 
		$measurementOf = new Field;
		$measurementOf->ColName = 'MeaOf_tab';

		$measurementType = new Field;
		$measurementType->ColName = 'MeaType_tab';

		$measurementValue = new Field;
		$measurementValue->ColName = 'MeaVerbatimValue_tab';

		$measurementUnit = new Field;
		$measurementUnit->ColName = 'MeaVerbatimUnit_tab';

		$measurementRemarks = new Field;
		$measurementRemarks->ColName = 'MeaRemarks_tab';

		$measurements = new Table;
		$measurements->Name = 'Measurements';
		$measurements->Headings = array
		(
			'Measurement of', 
			'Kind', 
			'Verbatim Measurement Value', 
			'Unit', 
			'Remarks'
		);
		$measurements->Columns = array
		(
			$measurementOf, 
			$measurementType, 
			$measurementValue, 
			$measurementUnit, 
			$measurementRemarks
		);
		// END - Measurement

		$this->Fields = array
		(
			'IdeFiledAsName',
			'CatMuseum',
			'CatPrefix',
			$catNumber,
			'CatCollectionName_tab',
			'CatObjectType',
			$specimenCount,
			'IdeFiledAsQualifiedNameWeb',
			'IdeOtherQualifiedNameWeb_tab',
			$typeCitations,
			$dateCollected,
			'BioEventSiteRef->ecollectionevents->LocOcean',
                        'BioEventSiteRef->ecollectionevents->LocSeaGulf',
                        'BioEventSiteRef->ecollectionevents->LocBaySound',
			'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocIslandName',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude',
                        'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude',
			$elevation,
			'BioEventSiteRef->ecollectionevents->ColParticipantRef_tab->eparties->SummaryData',
			$otherNumbers,
			$zooSexStageTable,
			$zooPrepDetails,
			'BioMicrohabitatDescription',
			$ReproductiveCondition,
			$ProgenyDetails,
			$measurements,
			'VerStomachContents',
			'VerCollectionMethod',
			'MamSexualMaturity',
			'MamPhysicalMaturity',
			'MamSpecimenCondition',
			'MamInjury',
			'MamParasite',
			'BibBibliographyRef_tab->ebibliography->SummaryData',
			'NotNmnhText0',
                        'AdmDateModified',
		);
	}
}
//===================================================================================================================================
//===================================================================================================================================
?>
