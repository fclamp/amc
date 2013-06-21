<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

$DEFAULT_DISPLAY_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Display.php";
$DEFAULT_PARTY_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/PartyDisplay.php";

class
CmaStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	CmaStandardDisplay()
	{
		
		$creCreatorRef = new Field();
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table();
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creCreatorRef);
	
		$child = new BackReferenceField;
		$child->RefDatabase = "ecatalogue";
		$child->RefField = "AssParentObjectRef";
		$child->ColName = "SummaryData";
		$child->Label = "Child Objects";
		$child->LinksTo = $GLOBALS['DEFAULT_DISPLAY_PAGE'];

		$relParent = new Field();
		$relParent->ColName = 'AssParentObjectRef->ecatalogue->SummaryData';
                $relParent->LinksTo = $GLOBALS['DEFAULT_DISPLAY_PAGE'];

		$relRelatedObjects = new Field();
		$relRelatedObjects->ColName = 'AssRelatedObjectsRef_tab->ecatalogue->SummaryData';	
		$relRelatedObjects->LinksTo = $GLOBALS['DEFAULT_DISPLAY_PAGE'];	

		$relRelation = new Field();
		$relRelation->ColName = 'AssRelationship_tab';

		$relTable = new Table();
		$relTable->Name = "RELATION";
		$relTable->Columns = array($relRelatedObjects,$relRelation);

		$mesType = new Field();
		$mesType->ColName = 'MesMeasurementType_tab';

		$mesTotHeight = new Field();
		$mesTotHeight->ColName = 'MesTotalInchFrac_tab';

		$mesTotWidth = new Field();
		$mesTotWidth->ColName = 'MesTotWidthInchFrac_tab';

		$mesTotDepth = new Field();
		$mesTotDepth->ColName = 'MesTotDepthInchFrac_tab';

		$mesTotDiam = new Field();
		$mesTotDiam->ColName = 'MesTotDiamInchFrac_tab';

		$mesTable = new Table();
		$mesTable->Name = "MEASUREMENTS";
		$mesTable->Columns = array($mesType,$mesTotHeight,$mesTotWidth,$mesTotDepth,$mesTotDiam);
		
		$events = new BackReferenceField;
		$events->RefDatabase = "eevents";
		$events->RefField = "ObjAttachedObjectsRef_tab";
		$events->ColName = "SummaryData";
		$events->Label = "Events";

                $this->Fields = array(
					'SummaryData',
					'TitAccessionNo',
					'TitMainTitle',
					$creatorTable,
					'EdiEdition',
					'CreDateCreated',
					'PhyMediumComments',
					'AcqCreditLine',
					$mesTable,
					$events,
					'LocCurrentLocationLocal',
					$child,
					$relParent,
					$relTable,
				);

		$this->BaseStandardDisplay();
	}
}

class
CmaPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	CmaPartyDisplay()
	{
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthDate',
				'BioBirthPlace',
				'BioDeathDate',
				'BioDeathPlace',
				'BioNationality',
				'BioCommencementDate',
				'BioCompletionDate',
				'BioCommencementNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
