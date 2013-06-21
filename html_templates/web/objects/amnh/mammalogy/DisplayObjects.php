<?php

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once('DefaultPaths.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');



class
AmnhStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	AmnhStandardDisplay()
	{
		$this->BaseStandardDisplay();
		$this->DisplayImage = 1;
		//$this->HeaderField = "DetScientificNameLocal:1";

		$order = new Field;
		$order->ColName = 'IdeOrderLocal_tab';
		$family = new Field;
		$family->ColName = 'IdeFamilyLocal_tab';
		$subfamily = new Field;
		$subfamily->ColName = 'IdeSubfamilyLocal_tab';
		$genus = new Field;
		$genus->ColName = 'IdeGenusLocal_tab';
		$species = new Field;
		$species->ColName = 'IdeSpeciesLocal_tab';
		$subspecies = new Field;
		$subspecies->ColName = 'IdeSubspeciesLocal_tab';

		$taxTable = new Table;
		$taxTable->Name = "TAX";
		$taxTable->Columns = array(	
					$order,
					$family,
					$subfamily,
					$genus,
					$species,
					$subspecies,
					);

		$statusTaxon = new Field;
		$statusTaxon->ColName = 'IdeCitationTaxonRef_tab';
		$statusType = new Field;
		$statusType->ColName = 'IdeCitationTypeStatus_tab';

/*
		$collectorLink = new Field;
		$collectorLink->ColName = 'BioCollectorsRef_tab->eparties->SummaryData';
		$collectorLink->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];

		$collectorTable = new Table;
		$collectorTable->Name = "COLLECTORS";
		$collectorTable->Columns = array ($collectorLink);
*/

		$statusTable = new Table;
		$statusTable->Name = "STATUS";
		$statusTable->Columns = array (
					$statusTaxon,
					$statusType,
					);

		$prepType = new BackReferenceField;
		$prepType->RefDatabase = "ecatalogue";
		$prepType->RefField = 'PreObjectRef';
		$prepType->ColName = 'PrePrepType';
		$prepPart = new BackReferenceField;
		$prepPart->RefDatabase = "ecatalogue";
		$prepPart->RefField = 'PreObjectRef';
		$prepPart->ColName = 'PreKindOfObject';
		$prepDesc = new BackReferenceField;
		$prepDesc->RefDatabase = "ecatalogue";
		$prepDesc->RefField = 'PreObjectRef';
		$prepDesc->ColName = 'PrePrepDescription';

		$prepTable = new Table;
		$prepTable->Name = "PREP";
		$prepTable->Columns = array (
					$prepType,
					$prepPart,
					$prepDesc,
					);


		$this->Fields = array(	'SummaryData',
					'CatNumber',
					$taxTable,
					'BioSiteCountryLocal',
					'BioSiteStateLocal',
					'BioSiteCountyLocal',
					'BioSitePreciseLocalityLocal',
					'BioDateVisitedFrom',
					'BioCollectorsLocal_tab',
					//$collectorLink,
					//$collectorTable,
					'BioPrimaryCollNumber',
					'ZooSex:1',
					$statusTable,
					$prepTable,
					);

		$this->SuppressEmptyFields = 0;
		$this->BaseStandardDisplay();
	}
}

class
AmnhPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	AmnhPartyDisplay()
	{
		$this->BaseStandardDisplay();

		// Setup Birth and Death Date fields to be shown on
		//      Party records
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

	}
}


?>
