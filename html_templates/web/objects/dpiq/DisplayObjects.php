<?php

/* Copyright (c) 1998-2009 KE Software Pty Ltd
**
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ($WEB_ROOT . '/objects/dpiq/MapEnabledBaseDisplayObjects.php');




class
DpiqStandardDisplay extends MapEnabledBaseStandardDisplay
{
	var $SuppressEmptyFields = 0;  //Show empty fields
	//var $FontSize = '2';
	// Set default in the constructor
	function
	DpiqStandardDisplay()
	{
		// Examples of backreference, new table, new field definitions
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


		$catNumber = new FormatField;
                $catNumber->Format = "{TaxAccNo1} {TaxAccNo2} {TaxAccNo3}";
                $catNumber->Name = "TaxAccNo";

		$hostname = new FormatField;
                $hostname->Format = "{HosHostGenus} {HosHostSpecies} {HosHostAuthority}";
                $hostname->Name = "HostName";
		
		// use Validation field as a dummy to put in Headings
		$blankline = new Field;
                $blankline->ColName = "Validation";
                $blankline->Name = "blank";

		//$header0 = new Field;
                //$header0->ColName = "Validation";
                //$header0->Name = "WSHEADER";

		$header1 = new Field;
                $header1->ColName = "Validation";
                $header1->Name = "ORG";

		$header2 = new Field;
                $header2->ColName = "Validation";
                $header2->Name = "HOST";

		$header3 = new Field;
                $header3->ColName = "Validation";
                $header3->Name = "COLL";

		$header4 = new Field;
                $header4->ColName = "Validation";
                $header4->Name = "LOCALITY";

		$header5 = new Field;
                $header5->ColName = "Validation";
                $header5->Name = "VERI";

		$header6 = new Field;
                $header6->ColName = "Validation";
                $header6->Name = "SPECTYPE";

		$header7 = new Field;
                $header7->ColName = "Validation";
                $header7->Name = "ADDCOMMENTS";

		//$hc = new Field;
		//$hc->ColName = 'HosCommonName';

		//$hostTable1 = new Table;
		//$hostTable1->Name = "ssisisis"; 
		//$hostTable1->Headings = array('Common Name','Host Family'); 
		//$hostTable1->Columns = array($hc, HosHostFamily); 

		$this->Fields = array
				(
					$blankline,
					$catNumber,
					'TaxDuplicates_tab',
					'TaxOtherTaxaRef_tab->ecatalogue->SummaryData',
					$header1,
					'WebName',
					$header2,
					$hostname,
					'HosCommonName',
					'HosHostFamily',
					'HosOrganSubstrate_tab',
					'HosSymptom_tab',
					'HosDiseaseName',
					$header3,
					'ColPrimaryCollectorLocal',
					'ColOtherCollectorsRef_tab->eparties->SummaryData',
					'ColCollectionDate',
					'ColCollectionNumber',
					$header4,
					'LocPreciseLocation',
					'LocPlace',
					'LocState',
					'LocCountry',
					'LocLatitude',
					'LocLongitude',
					'LocGrowerRef->eparties->SummaryData',
					$header5,
					'ColTypeStatus1_tab',
					'ColTypeStatus2_tab',
					'ColDeterminerLocal_tab',
					'ColDate0',
					$header6,
					'SpeSpecimenType_tab',
					'SpeLivingCulture',
					'SpeLCStatus',
					'SpeLCStatusDate',
					'SpeLCPreservation_tab',
					$header7,
					'SpeAdditionalComments',
				);
		$this->HeaderField = 'SummaryData';
		$this->Database = 'edpiq';
		//$this->BaseStandardDisplay();
		$this->MapEnabledBaseStandardDisplay();
	}
}

class
DpiqPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	DpiqPartyDisplay()
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
