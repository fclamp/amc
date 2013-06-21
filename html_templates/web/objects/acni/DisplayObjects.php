<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
AcniStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	AcniStandardDisplay()
	{
		$mediummattable = new Table;
		$mediummattable->Name = "Medium / Materials used";
		$mediummattable->Columns = array("PhyMedium_tab", "PhyMaterial_tab");
		$mediummattable->Headings = array("Medium", "Material");

		$creator = new Field;
		$creator->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		$creator->ColName = "CreCreatorRef_tab->eparties->SummaryData";
		$creator->Label = "Artist";

		$physicalTable = new Table();
                $physicalTable->Name = 'Dimensions';
                $physicalTable->Columns = array(
                                        'PhyHeight_tab',
                                        'PhyWidth_tab',
                                        'PhyDepth_tab',
                                        'PhyUnitLength_tab',
                                        );
                $physicalTable->Headings = array(
                                        'Height',
                                        'Width',
                                        'Depth',
                                        'Unit',
                                        );

		$this->Fields = array(
				'TitMainTitle',
				'CreDateCreated',
				'TitAccessionDate',
				'AccAccessionLotRef->eaccessionlots->AcqDateOwnership',
				$mediummattable,
				$physicalTable,
				$creator,
				);
		
		$this->BaseStandardDisplay();
	}
}


class
AcniPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	AcniPartyDisplay()
	{
		// Setup Birth and Death Date fields to be shown on
		//	Party records
		$bioBirthDate = new Field;
		$bioBirthDate->ColName = 'BioBirthDate';
		$bioBirthDate->Label = 'Date of birth';
		$bioBirthDate->ShowCondition = 'NamPartyType = Person';

		$bioDeathDate = new Field;
		$bioDeathDate->ColName = 'BioDeathDate';
		$bioDeathDate->Label = 'Date of death';
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';

		$this->Fields = array(
				'NamFullName',
				$bioBirthDate,
				'BioBirthPlace',
				$bioDeathDate,
				'BioDeathPlace',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
