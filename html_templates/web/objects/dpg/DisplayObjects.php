<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
DpgStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	DpgStandardDisplay()
	{
		$accfield = new FormatField();
		$accfield->Format = '{TitAccessionNo} / {AccAccessionLotRef->eaccessionlots->SummaryData} / {TitAccessionDate}';
		$accfield->Label = 'Accession';
		
		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';

		$creDOB = new Field;
		$creDOB->ColName = 'CreCreatorRef_tab->eparties->BioBirthDate';

		$creDOD = new Field;
		$creDOD->ColName = 'CreCreatorRef_tab->eparties->BioDeathDate';
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creCreatorNationality = new Field;
		$creCreatorNationality->ColName = 'CreCreatorRef_tab->eparties->BioNationality';
		
		$creatorTable = new Table;
		$creatorTable->Name = "Creator";
		$creatorTable->Columns = array($creRole, $creCreatorRef, $creDOB, $creDOD, $creCreatorNationality);
		$creatorTable->Headings = array("","","","","");

		// Physical Measurements table
		$physicalfield = new FormatField();
		$physicalfield->Label = 'Size';
		$physicalfield->Format = '{PhyHeight:1} x {PhyWidth:1} {PhyUnitLength:1}';
		
		$this->Fields = array(
				'TitMainTitle',
				'AdoAdoptionStatus',
				'CreDateCreated',
				$creatorTable,
				'CreSubjectClassification_tab',
				'PhyMedium_tab',
				'PhySupport',
				$physicalfield,
				$accfield,
				'PhyDescription',
				'CreProvenance',
				'BibBibliographyRef_tab->ebibliography->SummaryData',
				'AdoAdoptionNotes',
				);

		$this->BaseStandardDisplay();
	}
}

class
DpgPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	DpgPartyDisplay()
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
				'BioLabel',
				);

		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
