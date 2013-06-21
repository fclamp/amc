<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'PdaBaseDisplayObjects.php');

class
PdaStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	PdaStandardDisplay()
	{

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "enarratives";
		$narratives->RefField = "ObjObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Narratives";
		//$narratives->LinksTo = "Narratives.php";

		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creRole, $creCreatorRef);

		$this->Fields = array(
				'TitMainTitle',
				'TitAccessionNo',
				'TitAccessionDate',
				'TitCollectionTitle',
				$creatorTable,
				'CreDateCreated',
				'TitTitleNotes',
				'CreCountry_tab',
				'PhyMedium',
				'PhyTechnique',
				'PhySupport',
				'PhyMediaCategory',
				'CrePrimaryInscriptions',
				'CreTertiaryInscriptions',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				'LocCurrentLocationRef->elocations->SummaryData',
				$narratives,
				'NotNotes',
				);
		
		$this->BaseStandardDisplay();
	}
}

class
PdaPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	PdaPartyDisplay()
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
?>
