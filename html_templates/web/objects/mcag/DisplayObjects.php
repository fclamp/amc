<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
McagStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	McagStandardDisplay()
	{
		// Acknowledgement
		$acknowledge = new Field;
		$acknowledge->Name = "Copyright";
		$acknowledge->ColName = 'RigRightsRef_tab->erights->RigAcknowledgement';
		
		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;

		$creDOB = new Field;
		$creDOB->ColName = 'CreCreatorRef_tab->eparties->BioBirthDate';

		$creDOD = new Field;
		$creDOD->ColName = 'CreCreatorRef_tab->eparties->BioDeathDate';
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		#$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		$creatorTable->Name = "Artist / Maker";
		$creatorTable->Headings = array('Role', 'Name', 'Born', 'Died');
		$creatorTable->Columns = array($creRole, $creCreatorRef, $creDOB, $creDOD);

		// Physical Measurements table
		$physicalTable = new Table();
		$physicalTable->Name = 'Size';
		$physicalTable->Columns = array(
					'PhyType_tab',
					'PhyHeight_tab',
					'PhyWidth_tab',
					'PhyDepth_tab',
					'PhyDiameter_tab',
					'PhyUnitLength_tab',
					);
		$physicalTable->Headings = array(
					'Type',
					'Height',
					'Width',
					'Depth',
					'Diameter',
					'Unit',
					);


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
		$creationPlaceTable->Name = "Place Made";
		$creationPlaceTable->Headings = array("");
		$creationPlaceTable->Columns = array(	$creCreationPlace1,
							$creCreationPlace2,
							$creCreationPlace3,
							$creCreationPlace4,
							$creCreationPlace5);

		// CreCulturalOrigin
		$creCulturalOrigin1 = new Field;
		$creCulturalOrigin1->ColName = 'CreCulturalOrigin1';
		$creCulturalOrigiphyn2 = new Field;
		$creCulturalOrigin2->ColName = 'CreCulturalOrigin2';
		$creCulturalOrigin3 = new Field;
		$creCulturalOrigin3->ColName = 'CreCulturalOrigin3';
		$creCulturalOrigin4 = new Field;
		$creCulturalOrigin4->ColName = 'CreCulturalOrigin4';
		$creCulturalOrigin5 = new Field;
		$creCulturalOrigin5->ColName = 'CreCulturalOrigin5';
		$culturalOriginTable = new Table;
		$culturalOriginTable->Name = "Cultural Origin";
		$culturalOriginTable->Columns = array(	$creCulturalOrigin1,
							$creCulturalOrigin2,
							$creCulturalOrigin3,
							$creCulturalOrigin4,
							$creCulturalOrigin5);
		
		// Title Notes - To be shown in place of a description
		//	only if the description field is blank
		$titleNotes = new Field;
		$titleNotes->ColName = 'TitTitleNotes';
		$titleNotes->Label = 'Description';
		$titleNotes->ShowCondition = "PhyDescription = /^$/";

		$descriptionField = new Field;
		$descriptionField->ColName = "PhyDescription";
		$descriptionField->EnablePublicPrivate = 1;
		
		$this->Fields = array(
				'TitMainTitle',
				'RigRightsRef_tab->erights->RigAcknowledgement',
				'TitAlternateTitles_tab',
				'TitObjectName',
				$creatorTable,
				'TitCollectionGroup_tab',
				'CreEarliestDate',
				'CreLatestDate',
				'CreDateCreated',
				$creationPlaceTable,
				$culturalOriginTable,
				'CreSubjectClassification_tab',
				$descriptionField,
				$titleNotes,
				'PhyMaterial_tab',
				'PhyMedium_tab',
				'PhyTechnique_tab',
				'PhySupport',
				$physicalTable,
				'AccAccessionLotRef->eaccessionlots->AcqCreditLine',
				'TitAccessionNo',
				'LocCurrentLocationRef->elocations->SummaryData'
				);
		
		$this->BaseStandardDisplay();
	}
}

class
McagPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	McagPartyDisplay()
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
