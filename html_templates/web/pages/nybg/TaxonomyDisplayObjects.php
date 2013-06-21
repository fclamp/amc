<?php
/********************************************************
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 ********************************************************/

/*  
 $Revision: 1.2 $
 $Date: 2009/01/28 22:04:03 $
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
 * class TaxonomyStandardDisplay extends BaseStandardDisplay
 *
 *  mapperDataSource = name to pass to mapper of data source
 *
 *  mapUrl = URL of mapping component
 *
 *
 ******************************************************/

class TaxonomyStandardDisplay extends BaseStandardDisplay
{

	var $mapDisplay = 1;
	var $mapperDataSource = '';
	var $mapUrl = '';

	// Set default in the constructor
	function
	TaxonomyStandardDisplay()
	{
		$this->BaseStandardDisplay();

		$this->DisplayImage = 1;

		$this->HeaderField = 'ClaScientificName';

		$this->Fields = array(
			'irn_1',
			'ClaKingdom',
			'ClaPhylum',
			'ClaSubphylum',
			'ClaSuperclass',
			'ClaClass',
			'ClaSubclass',
			'ClaInfraclass',
			'ClaSuperorder',
			'ClaOrder',
			'ClaSuborder',
			'ClaInfraorder',
			'ClaSuperfamily',
			'ClaFamily',
			'ClaFamilyNumber',
			'ClaSubfamily',
			'ClaTribe',
			'ClaGenus',
			'ClaGenusNumber',
			'ClaSubgenus',
			'ClaSpecies',
			'ClaSubspecies',
			'ClaOtherRank_tab',
			'ClaOtherValue_tab',
			'ClaRank',
			'ClaGroup',
			'ClaHybridType',
			'ClaHybridRank',
			'ClaPublicationAuthor',
			'ClaPublicationYear',
			'ClaScientificNameAuto',
			'ClaScientificName',
			'SynValid',
			'SynType_tab',
			'SynDate0',
			'BibCommonName_tab',
			'BibLanguage_tab',
			'BibType_tab',
			'IdeBy',
			'IdeDate',
			'IdeCode',
			'IdeLocality_tab',
			'IdeLocalityStatus_tab',
			'IdeLocalityAuthority_tab',
			'IdeConservationStatus_tab',
			'IdeConservationRegion_tab',
			'IdeConservationAuthority_tab',
			'DesGeneral',
			'DesScientific',
			'DesBiology',
			'DesReproduction',
			'NotNotes',
			'ClaQualifierRank_tab',
			'ClaQualifierValue_tab',
			'AutAuthorString',
			'AutCombAuthorsRole_tab',
			'HomKind_tab',
			'ClaCurrentlyAccepted',
			'ClaCultivar',
			'ClaCultivarName',
			'ClaApplicableCode',
			'ClaHybrid',
			'CitVerifiedDate0',
			'PriIllegitimate',
			'PriNomenNudum',
			'PriNomenConservandum',
			'PriInvalid',
			'PriMisspelling',
			'PriNomenDubium',
			'CitLocality_tab',
			'CitRemarks_tab',
			'SynNameRef_tab',
			'SynKind_tab',
			'SynLaterHomonym_tab',
			'SynNomenOblitum_tab',
			'SynSuperfluous_tab',
			'SynMisapplied_tab',
			'SynRejected_tab',
			'SynUncertain_tab',
			'ComName_tab',
			'ComGeographicLocation_tab',
			'ComLanguage_tab',
			'GeoAreaRef_tab',
			'GeoAuthorityRef_tab',
			'GeoStatus_tab',
			'GeoStatusType_tab',
			'GeoStatusComments_tab',
			'ClaIncertaeSedis',
			'ClaIncertaeSedisAuthorityRef',
			'ClaSubtribe',
			'AutCombAuthorsRefLocal0',
			'AutBasionymAuthorsRefLocal0',
			'NotNotes',
				);


		$this->Database = 'etaxonomy';

		$this->SuppressEmptyFields = 1;

	}




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
		$mainField = 'ClaScientificName'; // The main field is the first one
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

		
		$link = new PreConfiguredQueryLink;
		$link->LimitPerPage = 20;
		$link->LinkText = 'Specimen holdings identified as ' . $this->record->$mainField;
		$link->Where = " exists (DetTaxonRef_tab[DetTaxonRef] where DetTaxonRef = ".
			$this->record->irn_1 . ")";
		print '<a style="font-weight=bold;" href="' .  $link->generateRef() 
			. '">' . $link->LinkText . '</a>';

		// make system to get to mapper
		$irnList = "&lt;irn&gt;". $this->record->irn_1. "&lt;/irn&gt;";

		$mapButton1 = '<span font-weight="bolder"><input id="mapButton1" 
				class="linkLikeButton" 
				onMouseOver=""
				type="submit" value="Map"/></span>';

		print <<< HTML
		<form name='listForm' method='post' action='$this->mapperUrl'>
			$mapButton1
			<input type="hidden" name="action" value="query"/>
			<input type="hidden" name="maxcache" value="on" />

			<input type="hidden" name="URL"
				value="<dataSource>$this->mapperDataSource</dataSource>"/>
      			<input type="hidden" name="showby" value="genus,species"/>
			<input type="hidden" name="query_term_irn" value='$irnList' />
			<input type='hidden' name='previousUrl' value="$this->QueryPage" />
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
