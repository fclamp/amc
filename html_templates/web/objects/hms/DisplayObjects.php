<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
HMSStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	HMSStandardDisplay()
	{
		$this->BaseStandardDisplay();

		// Narratives Link
		$narratives = new BackReferenceField();
		$narratives->RefDatabase = "enarratives";
		$narratives->RefField = "ObjObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Narratives";
		$narratives->LinksTo = "http://emu.man.ac.uk/wagcustom/NarrativeDisplay.php";

		$creRole = new Field();
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $this->PartyDisplayPage;
		
		$creatorTable = new Table;
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creRole, $creCreatorRef);
		$creatorTable->Headings = array("Role", "Creator");

		// Physical Measurements table
		$physicalTable = new Table();
		$physicalTable->Name = 'Dimensions';
		$physicalTable->Columns = array(
					'PhyType_tab',
					'PhyHeight_tab',
					'PhyWidth_tab',
					'PhyDepth_tab',
					'PhyDiameter_tab',
					'PhyUnitLength_tab',
					'PhyWeight_tab',
					'PhyUnitWeight_tab'
					);
		$physicalTable->Headings = array(
					'Type',
					'Height',
					'Width',
					'Depth',
					'Diameter',
					'Unit (Lengths)',
					'Weight',
					'Unit (Weight)'
					);

		// Creation Dates
		$creationDates = new FormatField();
		$creationDates->ColName = "CreEarliestDate";
		$creationDates->Format = "{CreEarliestDate} - {CreLatestDate}";
		$creationDates->Label = "Creation Date";

		// Creation Place
		$creCreationPlace1 = new Field;
		$creCreationPlace1->ColName = 'CreCreationPlace1_tab';
		$creCreationPlace2 = new Field;
		$creCreationPlace2->ColName = 'CreCreationPlace2_tab';
		$creCreationPlace3 = new Field;
		$creCreationPlace3->ColName = 'CreCreationPlace3_tab';
		$creCreationPlace4 = new Field;
		$creCreationPlace4->ColName = 'CreCreationPlace4_tab';
		$creCreationPlace5 = new Field;
		$creCreationPlace5->ColName = 'CreCreationPlace5_tab';
		$creationPlaceTable = new Table;
		$creationPlaceTable->Name = "Creation Place";
		$creationPlaceTable->Columns = array(	$creCreationPlace1,
							$creCreationPlace2,
							$creCreationPlace3,
							$creCreationPlace4,
							$creCreationPlace5);

		// CreCulturalOrigin
		$creCulturalOrigin1 = new Field;
		$creCulturalOrigin1->ColName = 'CreCulturalOrigin1';
		$creCulturalOrigin2 = new Field;
		$creCulturalOrigin2->ColName = 'CreCulturalOrigin2';
		$creCulturalOrigin3 = new Field;
		$creCulturalOrigin3->ColName = 'CreCulturalOrigin3';
		$creCulturalOrigin4 = new Field;
		$creCulturalOrigin4->ColName = 'CreCulturalOrigin4';
		$creCulturalOrigin5 = new Field;
		$creCulturalOrigin5->ColName = 'CreCulturalOrigin5';
		$culturalOriginTable = new Table;
		$culturalOriginTable->Name = "Cultural Origins";
		$culturalOriginTable->Columns = array(	$creCulturalOrigin1,
							$creCulturalOrigin2,
							$creCulturalOrigin3,
							$creCulturalOrigin4,
							$creCulturalOrigin5);

		$notNotes = new Field;
		$notNotes->ColName = 'NotNotes';
		$notNotes->Filter = '/Public(.*?)(Private|$)/i';

		$this->Fields = array(
				'TitMainTitle',
				'CreBriefDescription',
				'TitCollectionTitle',
				'CreDateCreated',
				'CreCreatorRef_tab->eparties->SummaryData',
				'TitAccessionNo',
				'TitPreviousAccessionNo_tab',
				'LocCurrentLocationRef->elocations->SummaryData',

/*
 *  Old Fields Remove once complete

				'TitSeriesTitle',
				'TitCollectionTitle',
				'TitAlternateTitles_tab',
				'TitObjectName',
				'TitAccessionNo',

				//'TitAccessionDate',
				$creatorTable,
				$culturalOriginTable,
				'CreDateCreated',
				$creationPlaceTable,
				'PhyMedium_tab',
				'PhyMaterial_tab',
				'PhyDescription',
				'PhyTechnique_tab',
				'PhySupport',
				$physicalTable,
				'CrePrimaryInscriptions',
				'CreOtherInscriptions',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				'LocCurrentLocationRef->elocations->SummaryData',
				$narratives,
				$notNotes,
 */
				);
		
	}
}

class
HMSPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	HMSPartyDisplay()
	{
		// Narratives Link
		$narratives = new BackReferenceField();
		$narratives->RefDatabase = "enarratives";
		$narratives->RefField = "ParPartiesRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Narratives";
		$narratives->LinksTo = "NarrativeDisplay.php";
		
		$periodActivity = new FormatField();
		$periodActivity->Format = '{BioCommencementDate} - {BioCompletionDate}';
		$periodActivity->Label = 'Period of Activity';
		
		$bioBirthDate = new Field();
		$bioBirthDate->ColName = "BioBirthDate";
		$bioBirthDate->ShowCondition = 'NamPartyType = Person';

		$bioDeathDate = new Field();
		$bioDeathDate->ColName = "BioDeathDate";
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';
		
		$orgActivity = new FormatField();
		$orgActivity->Format = '{BioBirthDate} to {BioDeathDate}';
		$orgActivity->Label = 'Period of Activity';
		$orgActivity->ShowCondition = "NamPartyType = Organisation";

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
				$periodActivity,
				$orgActivity,
				'BioEthnicity',
				$narratives,
				'NotNotes',
				);

		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
