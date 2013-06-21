<?php

/*
**
**	Copyright (c) 1998-2009 KE Software Pty Ltd
**
**	Template.  Change all reference to "Nybg" 
**
**	   **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');



class
NybgStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	NybgStandardDisplay()
	{
		$this->BaseStandardDisplay();
		$this->DisplayImage = 1;
		$this->HeaderField = "DetScientificNameLocal:1";


		$this->Fields = array(  'DetScientificNameLocal_tab',
					'DetScientificNameLocal_tab',
					'DetNameNotes_tab',
					'NybRecordType',
					'DetGenusPrefix_tab',
					'DetGenusSuffix_tab',
					'DetSpeciesPrefix_tab',
					'DetSpeciesSuffix_tab',
					'ColLocationNotes',
					'FeaPlantFungDesc',
					'HabHabitat',
					'HabVegetation',
					'HabSubstrate',
					'HabHabitatNotes',
					'SpeDivision',
					'SpeNatureOfObject',
					'SpeLocation',
					'SpeSpecimenStatus',
					'SpeSpecimenNotes',
					'LabNumberOfDuplicates',
					'LabNumberOfLabels',
					'VerName_tab',
				);
		
		$this->BaseStandardDisplay();
		$this->SuppressEmptyFields = 0;


	function DisplayMedia()
	{
		/*  We are displaying the start of the page. We show the
		**  media on the left and the title info on the right.
		*/
		print "      <table width=\"100%\" height=\"210\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		print " 	<tr align=\"center\" valign=\"middle\">\n"; 
		print "		  <td width=\"35%\">\n";

		/*  Now we have the table set up show the image on the left.  */
		$image = new MediaImage;
		$image->Intranet = $this->Intranet;
		$image->IRN = $this->record->{'MulMultiMediaRef:1'};
		$image->BorderColor = $this->BorderColor;
		$image->HighLightColor = $this->BorderColor;
		$image->RefIRN = $this->IRN;
		$image->RefTable = $this->Database;
		$image->Show();

		/*  The title will appear on the right. The main field is
		**  the first field in the Fields[] array.
		*/
		$mainField = 'DetScientificNameLocal_tab'; // The main field is the first one
		print "		  </td>\n";
		print "		  <td valign=\"middle\" width=\"65%\">\n";
		print "		    <b>";
		PPrint($this->record->$mainField, $this->FontFace, $this->HeaderFontSize, $this->BodyTextColor);
		Print "<br />";
		PPrint($this->record->{'ComName:1'}, $this->FontFace, $this->HeaderFontSize-1, $this->BodyTextColor);
		Print "<br />";
		Print "<br />";
		PPrint($this->record->NotNotes, $this->FontFace, $this->HeaderFontSize-2, $this->BodyTextColor);
		Print "<br />";
		Print "<br />";
		PPrint('IRN: '.$this->record->irn_1, $this->FontFace, $this->FontSize-1, $this->BodyTextColor);
		Print "<br />";
		Print "<br />";

		
		/*  Now close off the table.
		*/
		print "		  </td>\n";
		print "		</tr>\n";
		print "	      </table>\n"; 
	}

	function display()
	{
		global $ALL_REQUEST;

		$irn = $ALL_REQUEST['irn'];

		parent::display();
	}
	}
}

?>
