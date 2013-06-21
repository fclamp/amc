<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
MsimStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	MsimStandardDisplay()
	{

		// $SuppressEmptyFields = 0;


		$assAssociationType = new Field();
		$assAssociationType->ColName = 'AssAssociationType_tab';

		$assAssociationDate = new Field();
		$assAssociationDate->ColName = 'AssAssociationDate_tab';
		
		$assAssociationNameRef = new Field();
		$assAssociationNameRef->ColName = 'AssAssociationNameRef_tab->eparties->SummaryData';
		$assAssociationNameRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$associationTable = new Table();
		$associationTable->Name = "ASSOCIATION";
		$associationTable->Headings = array("Type", "Name", "Date");
		$associationTable->Columns = array($assAssociationType, $assAssociationNameRef, $assAssociationDate);

		//$matPrimaryMaterials = new Field();
		//$matPrimaryMaterials->ColName = 'MatPrimaryMaterials_tab';
		//$matSecondaryMaterials = new Field();
		//$matSecondaryMaterials->ColName = 'MatSecondaryMaterials_tab';
		//$matTertiaryMaterials = new Field();
		//$matTertiaryMaterials->ColName = 'MatTertiaryMaterials_tab';

		//$materialsTable = new Table();
		//$materialsTable->Name = "MATERIALS";
		//$materialsTable->Headings = array("Primary", "Secondary", "Tertiary");
		//$materialsTable->Columns = array($matPrimaryMaterials, $matSecondaryMaterials, $matTertiaryMaterials);

		$earliestDate = new Field();
		$earliestDate->ColName = 'AssAssociationEarliestDate0';
		$earliestDate->ColType = 'date';

		$latestDate = new Field();
		$latestDate->ColName = 'AssAssociationLatestDate0';
		$latestdate->ColType = 'date';

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = 'enarratives';
		$narratives->RefField = 'ObjObjectsRef_tab';
		$narratives->ColName = 'NarTitle';
		$narratives->LinksTo = 'NarDisplay.php';
		$narratives->Label = "Narratives";

		$this->Fields = array(
				'ClaObjectName',
				'ColCategory',
				'ColRegNumber',
				'ColTypeOfItem',
				$associationTable,
				$earliestDate,
				$latestDate,
			//	'AssAssociationSource_tab',
				'AssAssociationLocality_tab',
				'AssAssociationRegion_tab',
			//	'AssAssociationComments0',
				'ColCollectionName_tab',
			//	$materialsTable,
			//	'DesPhysicalDescription',
			//	'DesInscriptions',
			//	'ClaPrimaryClassification',
			//	'ClaSecondaryClassification',
			//	'ClaTertiaryClassification',
				'ClaObjectName',
			//	'ClaObjectSummary',
			//	'SubThemes_tab',
			//	'SubSubjects_tab',
			//	'SubHistoryTechSignificance',
				'LocCurrentLocationRef->elocations->SummaryData',
				'ClaSerialNumber',
				'ClaPatentNumber_tab',
				'ClaBrandName',
				'ClaModelNameNo_tab',
				'ClaDesignRegNo_tab',
			//	'MatMaterialsNotes',
			//	'NotNotes',
			//	$narratives,
				);
		
		$this->BaseStandardDisplay();
	}
}

class
MsimPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	MsimPartyDisplay()
	{
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}

class
LabelDisplay extends BaseStandardDisplay
{
        // Set default in the constructor
	   function 
	   LabelDisplay()
	   
	   {
	   
	   $narratives = new BackReferenceField;
	   $narratives->RefDatabase = 'enarratives';
	   $narratives->RefField = 'ObjObjectsRef_tab';
	   $narratives->ColName = 'NarNarrative';
	   $narratives->LinksTo = 'NarDisplay.php';
	   $narratives->MarkupKeywords = 1;

	 // $narTitle = new BackReferenceField;
	 // $narTitle->RefDatabase = 'enarratives';
	 // $narTitle->RefField = 'ObjObjectsRef_tab';
	 // $narTitle->ColName = 'NarTitle';
	 // $narTitle->LinksTo = 'NarDisplay.php';
	 // $narTitle->MarkupKeywords = 1;

	   
	   
	//   $NarNarrative = new Field();
	//   $NarNarrative->ColName = 'NarNarrative';
	//   $NarNarrative->MarkupKeywords = 1;

	   $this->DisplayLabels = 0;

	   $this->Fields = array(
	   			'ClaObjectSummary',
	//			$narTitle,
	   			$narratives,
				);
				
	   $this->BaseStandardDisplay();
	   }
}


?>
