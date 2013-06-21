<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
GalleryStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	GalleryStandardDisplay()
	{

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "eevents";
		$narratives->RefField = "ObjAttachedObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Events";
		$narratives->LinksTo = $GLOBALS['DEFAULT_EXHIBITION_PAGE'];

		$creRole = new Field;
		$creRole->ColName = 'CreArtistsRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreArtistsDetailsRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creRole, $creCreatorRef);


		$this->Fields = array(
				'ObjObjectName',
				'AccLotNumberLocal',
				'ObjAccessionDate',
				'ObjCollectionName',
				$creatorTable,
				'CreDateOfObject',
				'ObjBriefDescription',
				'CreCountry',
				'CreMethod_tab',
				'CreMaterial_tab',
				'ObjInscriptionWording_tab',
				'ObjInscriptionMethod_tab',
				'ObjInscriptionLocation_tab',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				'LocCurrentLocationRef->elocations->SummaryData',
				'NotNotes',
				//$AssRef,
				//'TitMainTitle',
				//'TitAccessionNo',
				//'TitAccessionDate',
				//'TitCollectionTitle',
				//$creatorTable,
				//'CreDateCreated',
				//'TitTitleNotes',
				//'CreCountry_tab',
				//'PhyMedium',
				//'PhyTechnique',
				//'PhySupport',
				//'PhyMediaCategory',
				//'CrePrimaryInscriptions',
				//'CreTertiaryInscriptions',
				//'AccAccessionLotRef->eaccessionlots->SummaryData',
				//'LocCurrentLocationRef->elocations->SummaryData',
				//'NotNotes',
				//$AssRef,
				);
		
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
		// Setup Birth and Death Date fields to be shown on
		//	Party records
		$bioBirthDate = new Field;
		$bioBirthDate->ColName = 'BioBirthDate';
		$bioBirthDate->Label = 'Born';
		$bioBirthDate->ShowCondition = 'NamPartyType = Person';

		$bioDeathDate = new Field;
		$bioDeathDate->ColName = 'BioDeathDate';
		$bioDeathDate->Label = 'Died';
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';
		
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				$bioBirthDate,
				$bioDeathDate,
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
