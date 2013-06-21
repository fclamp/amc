<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

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
                                //'LocCurrentLocationRef->elocations->SummaryData',

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
				//'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}

	function
        DisplayMedia()
        {
                /*  We are displaying teh start of the page. We show the
                **  media on the left and the title info on the right.
                */
                print "      <table width=\"100%\" height=\"210\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
                print "         <tr align=\"center\" valign=\"middle\">\n";
                print "           <td width=\"4%\">\n";

                /*  Now we have the table set up show the image on the left.
                */
                $image = new MediaImage;
                $image->Intranet = $this->Intranet;
                if ($this->Database == "emultimedia")
                {
                        $image->IRN = $this->record->{'irn_1'};
                }
                else
                {
                        $image->IRN = $this->record->{'MulMultiMediaRef:1'};
                }
                if ($this->SuppressImageBorders)
                        $image->ShowBorder = 0;
                $image->BorderColor = $this->BorderColor;
                $image->HighLightColor = $this->BorderColor;
                $image->RefIRN = $this->IRN;
                $image->RefTable = $this->Database;
                $image->UseAbsoluteLinks = $this->UseAbsoluteLinks;
                if ($this->ImageDisplayPage != "")
                {
                        $image->ImageDisplayPage = $this->ImageDisplayPage;
                }
                elseif($this->Intranet)
                {
                        $image->ImageDisplayPage = $GLOBALS['INTRANET_DEFAULT_IMAGE_DISPLAY_PAGE'];
                }
                else
                {
                        $image->ImageDisplayPage = $GLOBALS['DEFAULT_IMAGE_DISPLAY_PAGE'];
                }
                //$image->Show();

                /*  The title will appear on the right. The main field is
                **  the first field in the Fields[] array.
                */
                $mainField = $this->Fields[0]; // The main field is the first one
                print "           </td>\n";
                print "           <td align=\"left\" valign=\"middle\" width=\"65%\">\n";
                print "             <b>";
                PPrint($this->record->$mainField, $this->FontFace, $this->HeaderFontSize, $this->BodyTextColor);
                print "             </b>\n";

                /*  Now close off the table.
                */
                print "           </td>\n";
                print "         </tr>\n";
                print "       </table>\n";
        }

}
?>
