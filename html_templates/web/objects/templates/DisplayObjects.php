<?php

/*
**
**	Copyright (c) 1998-2009 KE Software Pty Ltd
**
**	Template.  Change all reference to "Client" 
**
**	   **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');



class
ClientStandardDisplay extends BaseStandardDisplay
{
	// Set default in setupSchema()
	function
	setupSchema()
	{

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "enarratives";
		$narratives->RefField = "ObjObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Narratives";

		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 
			'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = 
			$GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		// ->Name is use for lookup in the strings/english.php file
		$creatorTable->Name = "CREATOR"; 
		$creatorTable->Columns = array($creRole, $creCreatorRef); 

		$notNotes = new Field;
		$notNotes->ColName = 'NotNotes';
		$notNotes->Filter = '/Public(.*?)(Private|$)/is';


		$this->Fields = array(
				'TitMainTitle',
				'TitCollectionTitle',
				$creatorTable,
				'CreDateCreated',
				'CreTertiaryInscriptions',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				$narratives,
				$notNotes,
				);
	}
}

class
ClientPartyDisplay extends BaseStandardDisplay
{

	// Setup default fields in setupSchema()
	function
	setupSchema()
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
		$bioDeathDate->ShowCondition = 'NamPartyType = Person'

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
	}
}

?>
