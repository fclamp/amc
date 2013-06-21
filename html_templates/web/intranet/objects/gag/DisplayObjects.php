<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

$BACKEND_TYPE = "gag";

$DEFAULT_DISPLAY_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Display.php";
$DEFAULT_PARTY_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/PartyDisplay.php";
$DEFAULT_CONTACT_SHEET_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/ContactSheet.php";
$DEFAULT_QUERY_PAGE             = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Query.php";
$DEFAULT_RESULTS_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/ResultsList.php";
$DEFAULT_IMAGE_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/common/imagedisplay.php";
$STRINGS_DIR            = "$WEB_ROOT/intranet/objects/$BACKEND_TYPE/strings/";



class
GalleryStandardDisplay extends BaseStandardDisplay
{
	var $DisplayAllMedia = 1;
	var $DisplayImage = 1;
	var $KeepImageAspectRatio = 1;
	var $KeepAssociatedImagesAspectRatio = 1;
	var $SuppressEmptyFields = 1;

	// Set default in the constructor
	function
	GalleryStandardDisplay()
	{
                $phyType = new Field;
                $phyType->ColName = 'PhyType_tab';

                $phyHeight = new Field;
                $phyHeight->ColName = 'PhyHeight_tab';

                $phyWidth = new Field;
                $phyWidth->ColName = 'PhyWidth_tab';

                $phyDepth = new Field;
                $phyDepth->ColName = 'PhyDepth_tab';

                $phyDiameter = new Field;
                $phyDiameter->ColName = 'PhyDiameter_tab';

                $phyDimUnits = new Field;
                $phyDimUnits->ColName = 'PhyUnitLength_tab';

                $phyWeight = new Field;
                $phyWeight->ColName = 'PhyWeight_tab';

                $phyDimWeight = new Field;
                $phyDimWeight->ColName = 'PhyUnitWeight_tab';

                $sizeTable = new Table;
                $sizeTable->Name = 'Dimensions';
                $sizeTable->Headings = array('Height', 'Width', 'Depth', 'Diam', 'Unit', 'Type');
                $sizeTable->Columns = array($phyHeight, $phyWidth, $phyDepth, $phyDiameter, $phyDimUnits, $phyType);

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "eevents";
		$narratives->RefField = "ObjAttachedObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Events";
		$narratives->LinksTo = $GLOBALS['DEFAULT_EXHIBITION_PAGE'];

		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		$creatorTable->Name = "CreCreatorRef_tab";
		$creatorTable->Columns = array($creCreatorRef, $creRole);

		$this->Fields = array(
                                'TitMainTitle',
                                'TitAccessionNo',
				$creatorTable,
                                'TitMainTitle',
                                'CreDateCreated',
                                'PhyMediaCategory',
                                'PhyMedium',
				$sizeTable,

				'CrePrimaryInscriptions',
				'CreSecondaryInscriptions',
                                'AccCreditLineLocal',
                                'LocCurrentLocationRef->elocations->SummaryData',

				//'TitAccessionNo',
				//'TitMainTitle',
				//'TitAccessionDate',
				//'TitCollectionTitle',
				//'CreDateCreated',
				//'TitTitleNotes',
				//'CreCountry_tab',
				//'PhyMedium',
				//'PhyTechnique',
				//'PhySupport',
				//'PhyMediaCategory',
				//'LocCurrentLocationRef->elocations->SummaryData',
				//'NotNotes',
				//'MulMultiMediaRef:1->emultimedia->MulIdentifier',
				//'AssRelatedObjectsRef_tab->ecatalogue->SummaryData',
				//$AssRef,
				);
		
		$this->BaseStandardDisplay();
	}
}


class
GalleryPartyDisplay extends BaseStandardDisplay
{
	var $SuppressEmptyFields = 1;

	// Set default field in the constructor
	function
	GalleryPartyDisplay()
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
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';
		
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'NamOrganisation',
				'BioBirthPlace',
				'BioDeathPlace',
				$bioBirthDate,
				$bioDeathDate,
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
