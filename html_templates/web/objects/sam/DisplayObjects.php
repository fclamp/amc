<?php

/*
**
**	Copyright (c) 1998-2009 KE Software Pty Ltd
**
**	Template.  Change all reference to "Sam" 
**
**	   **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');
//set local display page
$DEFAULT_DISPLAY_PAGE           = "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/Display.php";


class
SamStandardDisplay extends BaseStandardDisplay
{
        var $mapDisplay = 1;
        var $mapperDataSource = '';
        var $mapUrl = '';

	// Set default in the constructor
	function
	SamStandardDisplay()
	{
		$this->BaseStandardDisplay();
		$this->DisplayImage = 1;
		//$this->HeaderField = "IdeScientificNameLocal:1";


		$this->Fields = array(  'IdeScientificNameLocal_tab',
					//'DetNameNotes_tab',
					'PreKindOfObject',
					'IdeGenusLocal_tab',
					'IdeSpeciesLocal_tab',
					// sites 
					'QuiOceanLocal_tab',
					'QuiCountryLocal_tab',
					'QuiProvinceStateLocal_tab',
					'QuiDistrictLocal_tab',
					'QuiNearestNamedLocal_tab',
					'QuiSpecialGeoUnitLocal_tab',
					'QuiPreciseLocationLocal_tab',
					'QuiLatitude0',
					'QuiLongitude0',
					// accessionlots
					'AccAccessionLotRef_tab->eaccessionlots->SummaryData',
					// taxa
					//'QuiTaxonLocal',
					'NotNotes',

					//'ColLocationNotes',
					//'FeaPlantFungDesc',
					//'HabHabitat',
					//'HabVegetation',
					//'HabSubstrate',
					//'HabHabitatNotes',
					//'SpeDivision',
					//'SpeNatureOfObject',
					//'SpeLocation',
					//'SpeSpecimenStatus',
					//'SpeSpecimenNotes',
					//'LabNumberOfDuplicates',
					//'LabNumberOfLabels',
					//'VerName_tab',
				);
		
		$this->BaseStandardDisplay();
		$this->SuppressEmptyFields = 0;
		$this->Database = 'esam';


	}
	function DisplayMedia()
        {
                /*  We are displaying the start of the page. We show the
                **  media on the left and the title info on the right.
                */
                print "      <table width=\"100%\" height=\"210\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
                print "         <tr align=\"center\" valign=\"middle\">\n";
                print "           <td width=\"35%\">\n";

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
                print "           </td>\n";
                print "           <td valign=\"middle\" width=\"65%\">\n";
                print "             <b>";
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

		/*
                $link = new PreConfiguredQueryLink;
                $link->LimitPerPage = 20;
                $link->LinkText = 'Specimen holdings identified as ' . $this->record->$mainField;
                $link->Where = " exists (IdeTaxonRef_tab[IdeTaxonRef] where IdeTaxonRef = ".
                        $this->record->irn_1 . ")";
                print '<a style="font-weight=bold;" href="' .  $link->generateRef()
                        . '">' . $link->LinkText . '</a>';
		*/

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
                        <input type="hidden" name="query_term_irn" value='$irnList' />
                        <input type="hidden" name='previousUrl' value="$this->QueryPage" />
                </form>
HTML;
		/*
                     //   <input name="showby" value="genus,species"/>
                print <<< HTML
                <form name='listForm' method='post' action='$this->mapperUrl'>
                        $mapButton1
                        <input name="action" value="query"/>
                        <input name="maxcache" value="on" />

                        <input name="URL"
                                value="<dataSource>$this->mapperDataSource</dataSource>"/>
                        <input name="showby" value="genus,species"/>
                        <input name="query_term_irn" value='$irnList' />
                        <input name='previousUrl' value="$this->QueryPage" />
                </form>
HTML;
		*/

                // blank any fields used above if we do not want them displayed
                // elesewhere
                $this->record->NotNotes = '';

                print "             </b>\n";

                /*  Now close off the table.
                */
                print "           </td>\n";
                print "         </tr>\n";
                print "       </table>\n";
        }
	function display()
        {
                global $ALL_REQUEST;

                $irn = $ALL_REQUEST['irn'];

                parent::display();
        }


}

?>
