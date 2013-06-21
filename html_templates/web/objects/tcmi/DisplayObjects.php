<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
TcmiStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	TcmiStandardDisplay()
	{
		$creMakerRef = new Field();
		$creMakerRef->ColName = 'CreMakerRef_tab->eparties->SummaryData';
		$creMakerRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table();
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creMakerRef);

		$this->Fields = array(
				'ObjPopularName',
				'ClaCollection',
				'SigSignificance',
				'CreCulture_tab',
				'ObjAccessionNumber',
				'ObjDateAcquired',
				$creatorTable,
				'DatDateMade',
				'DesMaterials_tab',
				'DesInscriptionType_tab',
				'DesInscription_tab',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				'LocCurrentLocationRef->elocations->SummaryData',
				'NotNotes',
				);
		
		$this->BaseStandardDisplay();
	}
}

class
GalleryStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	GalleryStandardDisplay()
	{
		$creRole = new Field();
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field();
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table();
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
				'NotNotes',
				);
		
		$this->BaseStandardDisplay();
	}
}

class
TcmiPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	TcmiPartyDisplay()
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
GalleryPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	GalleryPartyDisplay()
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
