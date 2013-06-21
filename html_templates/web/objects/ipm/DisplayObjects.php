<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
IpmStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	IpmStandardDisplay()
	{
		$this->HeaderFontSize = "+1";

		$narratives = new BackReferenceField;
		$narratives->RefDatabase = "enarratives";
		$narratives->RefField = "ObjObjectsRef_tab";
		$narratives->ColName = "SummaryData";
		$narratives->Label = "Narratives";
		//$narratives->LinksTo = "Narratives.php";

		$creRole = new Field;
		$creRole->ColName = 'CreRole_tab';
		//$creRole->Italics = 1;

		$creCreator = new Field;
		$creCreator->ColName = 'CreCreatorLocal_tab';

		$rigAcknowledgement = new Field;
		$rigAcknowledgement->ColName = 'RigRightsRef_tab->erights->RigAcknowledgement';
		$rigAcknowledgement->Label = "Copyright";
		$rigAcknowledgement->ValidUsers = "none";
		
		$creCreatorRef = new Field;
		$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
		$creCreatorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$creatorTable = new Table;
		$creatorTable->Name = "Artist/Creator";
		$creatorTable->Headings = array('', '');
		$creatorTable->Columns = array($creCreator, $creRole);

		//Dimensions table

		$phyHeight = new Field;
		$phyHeight->ColName = 'PhyHeight_tab';

		$phyWidth = new Field;
		$phyWidth->ColName = 'PhyWidth_tab';

		$phyDepth = new Field;
		$phyDepth->ColName = 'PhyDepth_tab';

		$phyUnit = new Field;
		$phyUnit->ColName = 'PhyUnitLength_tab';

		$phyType = new Field;
		$phyType->ColName = 'PhyType_tab';


		$sizeTable = new Table;
		$sizeTable->Name = 'Dimensions';
		$sizeTable->Headings = array('Height', 'Width', 'Depth', 'Unit', 'Type');
		$sizeTable->Columns = array($phyHeight, $phyWidth, $phyDepth, $phyUnit, $phyType);


		$this->Fields = array(
				'TitMainTitle',
				'TitMainTitle',
				$creatorTable,
				//'CreCreatorLocal:1',
				'CreDateCreated',
				'CreCountry_tab',
				'PhyCollectionArea',
				'PhyMedium',
				//'CreSubjectClassification_tab',
				$sizeTable,
				//'PhyType_tab',
				//'PhyHeight_tab',
				//'PhyWidth_tab',
				//'PhyDepth_tab',
				//'PhyDiameter_tab',
				//'PhyUnitLength_tab',
				//'PhyWeight_tab',
				//'PhyUnitWeight_tab',
				'CrePrimaryInscriptions',
				'CreSecondaryInscriptions',
				//'TitCollectionTitle',
				'AccCreditLineLocal',
				'TitAccessionNo',
				'ExhExtendedWallLabel',
				//'AccAccessionLotRef->eaccessionlots->SummaryData',
				//'LocCurrentLocationRef->elocations->SummaryData',
				$narratives,
				$rigAcknowledgement,
				);
		
		$this->BaseStandardDisplay();
	}

	function
	DisplayMedia()
	{
		/*  We are displaying the start of the page. We show the
		**  media on the left and the title info on the right.
		*/
		print "      <table width=\"100%\" height=210 border=0 cellspacing=0 cellpadding=2>\n";
		print " 	<tr align=center valign=middle>\n"; 
		print "		  <td width=\"35%\">\n";

		/*  Now we have the table set up show the image on the left.
		*/
		$image = new MediaImage;
		$image->Intranet = $this->Intranet;
		$image->IRN = $this->record->{'MulMultiMediaRef:1'};
		$image->BorderColor = $this->BorderColor;
		$image->HighLightColor = $this->BorderColor;
		$image->RefIRN = $this->IRN;
		$image->RefTable = $this->Database;
		$image->Show();

		if ($this->record->{'MulMultiMediaRef:1'} != "")
		{
			/*  We want to show the erights Acknowledgement line.
			*/
			if ($this->record->{'RigRightsRef:1->erights->RigAcknowledgement'} != "")
			{
				/*  go through each reference and show the
				**  acknowledgement line
				*/
				$index = 1;
				$creditline = '';
				while (isset($this->record->{'RigRightsRef:' . $index}))
				{
					$reference = 'RigRightsRef:' . $index . '->erights';
					if ($creditline != '')
						$creditline .= "<br>\n" . ' &copy';
					$creditline .= $this->record->{$reference . '->RigAcknowledgement'};
					$index++;
				}
				PPrint($creditline, $this->FontFace, '1', $this->BodyTextColor, '', 1);
			}
		}


		/*  The title will appear on the right. The main field is
		**  the first field in the Fields[] array.
		*/
		$mainField = $this->Fields[0]; // The main field is the first one
		print "		  </td>\n";
		print "		  <td valign=middle width=\"65%\">\n";
		print "		    <b>";
		PPrint($this->record->$mainField, $this->FontFace, $this->HeaderFontSize, $this->BodyTextColor);
		print "             </b>\n";

		/*  Now close off the table.
		*/
		print "		  </td>\n";
		print "		</tr>\n";
		print "	      </table>\n"; 
	}
}

class
IpmPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	IpmPartyDisplay()
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
