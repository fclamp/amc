<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');


class
RamStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	RamStandardDisplay()
	{
		$creatorTable = new Table();

		$creatorLink = new Field();
		$creatorLink->ColName = "CreCreatorRef_tab->eparties->SummaryData";
		$creatorLink->LinksTo = "PartyDisplay.php";

		$creatorTable->Label = "Creator/Artist/Maker";
		$creatorTable->Columns = array($creatorLink, "CreRole_tab");
		$creatorTable->Headings = array("Name", "Role");

		$relationshipTable = new Table();

		$relatedLink = new Field();
		$relatedLink->ColName = "AssRelatedPartiesRef_tab->eparties->SummaryData";
		$relatedLink->LinksTo = "PartyDisplay.php";

		$fullDescription = new Field();
		$fullDescription->ColName = "TitFullDescription";
		$fullDescription->RawDisplay = "1";

		$briefDescription = new Field();
		$briefDescription->ColName = "TitBriefDescription";
		$briefDescription->RawDisplay = "1";

		$relationshipTable->Label = "People";
		$relationshipTable->Columns = array($relatedLink, "AssPartiesRelationship_tab");
		$relationshipTable->Headings = array("Related Person", "Relationship");

		$measurementTable = new Table();
		$measurementTable->Label = 'Measurements';
		$measurementTable->Columns = array("PhyType_tab", "PhyLength_tab", "PhyWidth_tab", "PhyHeight_tab", "PhyDiameter_tab", "PhyUnitLength_tab");
		$measurementTable->Headings = array("Type", "Length", "Width", "Height", "Diameter", "Unit (Length)");

		$this->Fields = array(
			$briefDescription,
			'RigRightsRef_tab->erights->SummaryData',
			'TitObjectType',
			'TitCollection',
			//'CreCountry_tab|CreState_tab|CreDistrict_tab|CreCity_tab',
			//'TitFullDescription',
			$fullDescription,
			'CrePrimaryInscriptions',
			$creatorTable,
			'CreDateCreated',
			'NotNotes',
			'PhyTechnique_tab',
			'PhyMaterials_tab',
			$measurementTable,
			'TitAccessionNo',
			$relationshipTable,
			);


		$this->HeaderField = "SummaryData";
		$this->BaseStandardDisplay();
	}
}


class
RamPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	RamPartyDisplay()
	{
		// Setup Birth and Death Date fields to be shown on
		//	Party records
		$bioBirthDate = new Field;
		$bioBirthDate->ColName = 'BioBirthDate';

		$bioDeathDate = new Field;
		$bioDeathDate->ColName = 'BioDeathDate';

		$biography = new Field();
		$biography->ColName = "NotNotes";
		$biography->Label = "Biography";
		
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				$bioBirthDate,
				'BioBirthPlace',
				$bioDeathDate,
				'BioDeathPlace',
				$biography,
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
