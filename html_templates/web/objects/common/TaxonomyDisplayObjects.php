<?php
/********************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 ********************************************************/

/*  
 $Revision: 1.6 $
 $Date: 2012-02-08 05:20:55 $
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

		// Type Status

		$citTypeStatus = new field;
		$citTypeStatus->ColName = 'CitTypeStatus_tab';

		$citTaxonRefLocal = new field;
		$citTaxonRefLocal->ColName = 'IdeScientificNameLocal_tab';

		$typeCitations = new table;
		$typeCitations->Name = 'TypeCitations';
		$typeCitations->Columns = array($citTypeStatus, $citTaxonRefLocal);

		// Other identifications name
		$ideOtherQualifiedName = new Field;
		$ideOtherQualifiedName->ColName = 'IdeOtherQualifiedName_tab';

		$ideDateIdentified = new Field;
		$ideDateIdentified->ColName = 'IdeOtherDateIdentified0';

		$ideIdentifiedBy = new Field;
		$ideIdentifiedBy->ColName = 'IdeOtherIdentifiedByRef_tab->eparties->NamBriefName';

		$otherIdentTable = new Table;
		$otherIdentTable->Name = 'IdeOtherQualifiedName_tab';
		$otherIdentTable->Headings = array('Identification', 'Date Identified', 'Identified By');
		$otherIdentTable->Columns = array($ideOtherQualifiedName, $ideDateIdentified, $ideIdentifiedBy);

		$this->Fields = array(
			'irn_1',
			'ClaFamily',
			'ClaOrder',
			'ClaClass',
			'ClaPhylum',
			'ClaHybridType',
			'ClaHybridRank',
			'ClaScientificNameAuto',
			'ClaKingdom',
			'ClaSubphylum',
			'ClaSuperclass',
			'ClaSubclass',
			'ClaInfraclass',
			'ClaSuperorder',
			'ClaSuborder',
			'ClaInfraorder',
			'ClaSuperfamily',
			'ClaFamilyNumber',
			'ClaGenus',
			'ClaGenusNumber',
			'ClaSubgenus',
			'ClaSpecies',
			'ClaSubspecies',
			'ClaOtherRank_tab',
			'ClaOtherValue_tab',
			'ClaRank',
			'ClaGroup',
			'ClaPublicationAuthor',
			'ClaPublicationYear',
			'ClaScientificName',
			'SynKind_tab',
			'AutAuthorString',
			'AutCombAuthorsRole_tab',
			'ClaCurrentlyAccepted',
			'ClaCultivar',
			'ClaCultivarName',
			'ClaApplicableCode',
			'ClaHybrid',
			'CitLocality_tab',
			'CitRemarks_tab',
			//'SynKind_tab',
			'ComName_tab',
			'ComGeographicLocation_tab',
			'ComLanguage_tab',
			'NotNotes',
				);


		$this->Database = 'etaxonomy';

		$this->SuppressEmptyFields = 0;

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
		$link->LinkText = $this->_STRINGS[DISPLAY_LIST_SPECIMEN_LINK] . ' '. $this->record->$mainField;
		$link->Where = " exists (IdeTaxonRef_tab[IdeTaxonRef] where IdeTaxonRef = ".
			$this->record->irn_1 . ")";
		print '<font size="'. $this->FontSize .'" face="'. $this->FontFace .'"><a style="font-weight=bold;" href="' .  
				$link->generateRef() 
			. '">' . $link->LinkText . '</a></font>';

		// make system to get to mapper
		$irnList = "&lt;irn&gt;". $this->record->irn_1. "&lt;/irn&gt;";

		$mapButton1 = '<font size="'. $this->FontSize .'" face="'. $this->FontFace .'"><input id="mapButton1" 
				class="linkLikeButton" 
				onMouseOver=""
				type="submit" value="'.$this->_STRINGS[MAP_SINGLE_NAME_BUTTON].' '.$this->record->$mainField.'"/></font>';

		print <<< HTML
		<form name='listForm' method='post' action='$this->mapperUrl'>
			$mapButton1
			<input type="hidden" name="action" value="query"/>
			<input type="hidden" name="maxcache" value="on" />

			<input type="hidden" name="URL"
				value="<dataSource>$this->mapperDataSource</dataSource>"/>
      			<input type="hidden" name="showby" value="genus,species"/>
			<input type="hidden" name="query_term_irn" value='$irnList' />
			<input type="hidden" name='previousUrl' value="$this->QueryPage" />
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
