<?php
/********************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 ********************************************************/

/*  
 $Revision: 1.6 $
 $Date: 2012-02-08 05:20:54 $
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');


class TaxonomyDisplayObjectTitle 
{
	var $info;
	var $suffix;

	function TaxonomyDisplayObjectTitle($suffix)
	{
		global $ALL_REQUEST;

		$this->suffix = $suffix;
		$all = array_merge($ALL_REQUEST['HTTP_GET_VARS'],$ALL_REQUEST['HTTP_POST_VARS']);
		$this->info = $all['name'];
	}

	function Show()
	{
		print 'KE EMu "'. $this->info . '" '. $this->suffix;
	}
}

/*******************************************************
 *
 * class ModuleStandardDisplay extends BaseStandardDisplay
 *
 *  mapperDataSource = name to pass to mapper of data source
 *
 *  mapperUrl = URL of mapping component
 *
 *
 ******************************************************/
class ModuleBaseStandardDisplay extends BaseStandardDisplay
{

	var $mapDisplay = 1;
	// mapper2 args
	var $mapperFetcher = 'DefaultTexxml';
	var $mapDisplayMethod = 'SimpleTransformation';
	var $mapDisplayStylesheet = 'mapper/style/mapdisplay.html';
	var $mapDisplaySortBy = 'ScientificName';
	// old mapper version argument
	var $mapperDataSource = '';
	var $mapperUrl = '';
	var $Fields = array ();
	var $HeaderField = '';
	var $mainField = '';
	var $subField = '';
	var $Database = '';
	var $searchColumn = '';
	var $referer = '';

	// Set default in the constructor
	function
	ModuleStandardDisplay()
	{
		$this->BaseStandardDisplay();

		$this->DisplayImage = 1;

		$this->SuppressEmptyFields = 0;

	}


	function DisplayMedia()
	{
		// build the referer url
		$referer = '/' . $GLOBALS['WEB_DIR_NAME'] . $this->referer;

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
		$mainField = $this->mainField;
		$subField = $this->subField;
		print "		  </td>\n";
		print "		  <td valign=\"middle\" width=\"65%\">\n";
		print "		    <b>";
		PPrint($this->record->$mainField, $this->FontFace, $this->HeaderFontSize, $this->BodyTextColor);
		Print "<br />";
		PPrint($this->record->$subField, $this->FontFace, $this->HeaderFontSize-1, $this->BodyTextColor);
		Print "<br />";
		Print "<br />";
		PPrint($this->record->NotNotes, $this->FontFace, $this->HeaderFontSize-2, $this->BodyTextColor);
		Print "<br />";
		Print "<br />";
		PPrint('IRN: '.$this->record->irn_1, $this->FontFace, $this->FontSize-1, $this->BodyTextColor);
		Print "<br />";
		Print "<br />";

		
		$link = new PreConfiguredQueryLink;
		$link->LimitPerPage = 20;
		$link->LinkText = $this->_STRINGS[DISPLAY_LIST_SPECIMEN_LINK] . ' '. $this->record->$mainField;
		$link->Where = " exists (IdeTaxonRef_tab[IdeTaxonRef] where IdeTaxonRef = ".
			$this->record->irn_1 . ")";
		print '<font size="'. $this->FontSize .'" face="'. $this->FontFace .'"><a href="' .  
				$link->generateRef() 
			. '">' . $link->LinkText . '</a></font>';

		// make system to get to mapper
		$irnList = "&lt;irn&gt;". $this->record->irn_1. "&lt;/irn&gt;";

		$mapButton1 = '<input id="mapButton1" 
				class="linkLikeButton" 
				onMouseOver=""
				onClick="makeMapUrl(this)"
				type="submit" value="'.$this->_STRINGS[MAP_SINGLE_NAME_BUTTON].' '.$this->record->$mainField.'"
				style="font-family: Tahoma; font-size: 13px;"/>';

		print <<< HTML

			<!-- START OBJECT -->
			<script language='javascript'>
			
				function makeMapUrl(button)
				{
					var search = Array();
					var searchColumn =
HTML;
						print"'$this->searchColumn'";
		print <<< HTML
	;
					var searchName =
HTML;
						$currentRecord = $this->record;
						$sciName = $currentRecord->$mainField;
						$sciName = preg_replace("/\s*,\s+/",",",$sciName);
						$nameBits = preg_split("/\s+/",$sciName);
						if (count($nameBits) > 2)
						{
							$authorship = $nameBits[count($nameBits)-1];
							if (preg_match("/^([A-Z]|\()/",$authorship))
							{
								// drop authorship
								array_pop($nameBits);
							}
							$sciName = implode(" ",$nameBits);
						}
						print "'$sciName'";
		print <<< HTML
	;

					document.getElementsByName("EmuOr")[0].setAttribute("value",searchName);

					for(i=0; (input=document.getElementsByTagName("input")[i]); i++)
					{
						if ((input.getAttribute('name') == "EmuOr"))
						{
							var searchSt = searchColumn + " CONTAINS '" + input.getAttribute("value") + "'";
						}	
					}

					searchSt += " AND DarLatitude IS NOT NULL AND DarLongitude IS NOT NULL";
					texql = "SELECT ALL FROM ecatalogue WHERE (" + searchSt + ")"

					document.getElementsByName("texql")[0].setAttribute("value",texql);
					document.forms[0].submit();
				}
			</script>

HTML;
		print <<< HTML

		<input type='hidden' name='EmuOr' value='' />
		$mapButton1
		<form name='mapForm' method="GET" action="$this->mapperUrl">
		<!-- start mapper2 args -->
			<input type='hidden' name='stylesheet' value="$this->mapDisplayStylesheet" />
			<input type='hidden' name='transform' value="$this->mapDisplayMethod" />
			<input type='hidden' name='texql' value='' />
			<input type='hidden' name='source[]' value="$this->mapperFetcher" />
			<input type='hidden' name='sortby' value="$this->mapDisplaySortBy" />
			<input type='hidden' name='referer' value="$referer" />
			<input type='hidden' name='websection' value="$this->websection" />
		<!-- end   mapper2 args -->
		</form>
HTML;

		// blank any fields used above if we do not want them displayed
		// elesewhere
		$this->record->NotNotes = '';

		print "             </b>\n";

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

?>
