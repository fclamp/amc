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
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

$DEFAULT_DISPLAY_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Display.php";
$DEFAULT_PARTY_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/PartyDisplay.php";



class
MvStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	MvStandardDisplay()
	{

		//$narratives = new BackReferenceField;
		//$narratives->RefDatabase = "enarratives";
		//$narratives->RefField = "ObjObjectsRef_tab";
		//$narratives->ColName = "SummaryData";
		//$narratives->Label = "Narratives";

		//$creRole = new Field;
		//$creRole->ColName = 'CreRole_tab';
		//$creRole->Italics = 1;
		
		//$creCreatorRef = new Field;
		//$creCreatorRef->ColName = 
		//	'CreCreatorRef_tab->eparties->SummaryData';
		//$creCreatorRef->LinksTo = 
		//	$GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		//$creatorTable = new Table;
		// ->Name is use for lookup in the strings/english.php file
		//$creatorTable->Name = "CREATOR"; 
		//$creatorTable->Columns = array($creRole, $creCreatorRef); 

		//$notNotes = new Field;
		//$notNotes->ColName = 'NotNotes';
		//$notNotes->Filter = '/Public(.*?)(Private|$)/is';

                //$regNumber = new FormatField;
		//$regNumber->Format = "{ColRegPrefix} {ColRegNumber} {ColRegPart}";
		//$regNumber->Label = "Registration Number";

		$this->Fields = array(
					'DesObjectDescription',
					'ColCategory',
		                        'ColScientificGroup',
					'ColDiscipline',
					$regNumber,
				        'ColRecordCategory',
				        'ColCollectionName_tab',

				//'TitMainTitle',
				//'TitCollectionTitle',
				//$creatorTable,
				//'CreDateCreated',
				//'CreTertiaryInscriptions',
				//'AccAccessionLotRef->eaccessionlots->SummaryData',
				//$narratives,
				//$notNotes,
				);
		
		$this->BaseStandardDisplay();
	}
}

class
MvPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	MvPartyDisplay()
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
