<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
NmcPensacolaWebStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	NmcPensacolaWebStandardDisplay()
	{
		$creRole = new Field();
		$creRole->ColName = 'CreCreatorRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field();
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table();
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creCreatorRef, $creRole);

		$this->Fields = array(
				'NamObjectTitle',
				'ObjAccessionNumber',
				'ObjAccessionDate',
				'ClaCollectionTitle',
				$creatorTable,
				'DatDateCreated',
				'DesObjectDescription',
				'DesObjectNotes',
				'CrePlaceOfOrigin',
				'DesMedium_tab',
				#'PhyTechnique',
				#'PhySupport',
				#'PhyMediaCategory',
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
NmcPensacolaWebPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	NmcPensacolaWebPartyDisplay()
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
