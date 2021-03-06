<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ('DefaultPaths.php');

class
GalleryStandardDisplay extends BaseStandardDisplay
{
	//var $DisplayAllMedia = 0;
	var $DisplayImage = 1;

	// Set default in the constructor
	function
	GalleryStandardDisplay()
	{

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "eevents";
		$narratives->RefField = "ObjAttachedObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Events";
		$narratives->LinksTo = $GLOBALS['DEFAULT_EXHIBITION_PAGE'];


		// Creator

		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		$creRole->Italics = 1;
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		$creatorTable = new Table;
		$creatorTable->Name = "CREATOR";
		$creatorTable->Columns = array($creCreatorRef, $creRole);



		//Person Interviewed

		$oraPersonInterviewedRef = new Field;
		$oraPersonInterviewedRef->ColName = 'OraPersonInterviewedRef_tab->eparties->SummaryData';
		$oraPersonInterviewedRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];

		$PersonInterviewedTable = new Table;
		$PersonInterviewedTable->Name = "INTERVIEWED";
		$PersonInterviewedTable->Columns = array($oraPersonInterviewedRef);
		
		//Source/Vendor

		$sourcevendor = new Field;
		$sourcevendor->ColName = 'AccAccessionLotRef->eaccessionlots->AcqSourceRef_tab->eparties->SummaryData';
		$sourcevendor->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];

		$SourceVendorTable = new Table;
		$SourceVendorTable->Name = "SOURCEVENDOR";
		$SourceVendorTable->Columns = array($sourcevendor);
		

		$AssRef2 = new Field;
		$AssRef2->ColName = 'MulMultiMediaRef:1->ecatalogue->SummaryData';

                                //$image = new MediaImage;
                                //$image->Intranet = $this->Intranet;
                                //$image->IRN = $imgirn;
                                //$image->IRN = $this->IRN;
                                //$image->BorderColor = $this->BorderColor;
                                //$image->HighLightColor = $this->BorderColor;
                                //$image->RefIRN = $this->IRN;
                                //$image->RefIRN = 24813;
                                //$image->RefTable = "emultimedia";
                                //$image->UseAbsoluteLinks = $this->UseAbsoluteLinks;
                                //$image->KeepAspectRatio = $this->KeepAssociatedImagesAspectRatio;
                                //$image->Width = 90;
                                //$image->Height = 90;
                                //$lastimage = $image->Show();

		$AssRef = new Field;
		$AssRef->ColName = 'AssRelatedObjectsRef_tab->ecatalogue->SummaryData';
		$AssRef->LinksTo = $GLOBALS['DEFAULT_DISPLAY_PAGE'];


		$AssRef3 = new Table;
		$AssRef3->Name = "TEST";
		$AssRef3->Columns = array($AssRef, $AssRef);

		$this->Fields = array(
				'TitMainTitle',
				'TitDivision',
				'TitCollection',
				'TitSubCollection',
				'TitAccessionNo',
				'TitObjectStatus',
				'TitAlternateTitles_tab',
				$creatorTable,
				'CreDateCreated',
				'PhyDescription',
				'CreSignificance',
				'TitObjectType',
				'CreSubjectClassification_tab',
				'PhyMaterial_tab',
				$SourceVendorTable,
				'CreProvenance',
				$PersonInterviewedTable,
				'LocCurrentLocationRef->elocations->SummaryData',
				'NmmKeyNo',
				'OraSummary',
				);
		
		$this->BaseStandardDisplay();
	}
}


class
GalleryPartyDisplay extends BaseStandardDisplay
{

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
