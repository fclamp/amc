<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');
require_once ('DefaultPaths.php');

class
TePapaStandardResultsList extends BaseStandardResultsList
{
	function
	TePapaStandardResultsList()
	{
		//var $KeepImageAspectRatio = 1;
		$this->BaseStandardResultsList();
		$this->Fields = array(	
			'RegRegistrationNumberString',
			'WebClaFamily',
			'IdeScientificNameLocal:1',
			'WebLocCountry',
			'ColCollectionEventRef->ecollectionevents->LocOcean',
			'WebLocProvinceStateTerritory',
		);	
	
		$this->mapperUrl = "../../../webservices/mapper.php";
        	$this->mapperInstalled = 1;
        	$this->referer = "/pages/tepapa/natural/Query.php";
	}		


	function
        display()
        {
		// build the referer url
                $referer = '/' . $GLOBALS['WEB_DIR_NAME'] . $this->referer;

                $records =& $this->records;

                $widthAttrib = '';
                $backgroundColorAttrib = '';
                $highlightColorAttrib = '';
                //Aaron - Added conditional statement to set border attribute
                $borderAttrib = 0;
                if ($this->Border != 0)
                        $borderAttrib = $this->Border;
                if ($this->Width != '')
                        $widthAttrib    = 'width="' . $this->Width . '"' ;
                if ($this->BodyColor != '')
                        $backgroundColorAttrib  = 'bgcolor="' . $this->BodyColor . '"';
                if ($this->HighlightColor != '')
                        $highlightColorAttrib   = 'bgcolor="' . $this->HighlightColor . '"';
                else
                        $highlightColorAttrib   = 'bgcolor="' . $this->BodyColor . '"';
                if ($this->HeaderColor != '')
                        $headerColorAttrib= 'bgcolor="' . $this->HeaderColor . '"';
                if ($this->BorderColor != '')
                        $borderColorAttrib= 'bgcolor="' . $this->BorderColor . '"';

                print <<< HTML
                        <!-- START OBJECT -->
                        <script language='javascript'>

                                function AllowMap()
                                {
                                        var mapText1 = document.getElementById('mapText1');
                                        var mapText2 = document.getElementById('mapText2');

                                        var i,inputs, someChecked;

                                        someChecked = 0;

                                        for(i=0; (input=document.getElementsByTagName("input")[i]);
                                                i++)
                                        {
                                                if (input.type == 'checkbox' && input.checked)
                                                {
                                                        mapText1.removeAttribute('disabled');
                                                        mapText1.setAttribute('class','linkLikeButton');
							mapText1.onclick = function(){makeMapUrl(this);};
                                                        mapText2.removeAttribute('disabled');
                                                        mapText2.setAttribute('class','linkLikeButton');
							mapText2.onclick = function(){makeMapUrl(this);};
                                                        // ie needs this netscape using changed style...
                                                        if (typeof(mapText1.style.cursor) != undefined)
                                                        {
                                                                someChecked++;
                                                                mapText1.style.cursor='pointer';
                                                                mapText1.style.color='#336699';
                                                                mapText2.style.cursor='pointer';
                                                                mapText2.style.color='#336699';
                                                        }
                                                }
                                        }
                                        if (! someChecked)
                                        {
                                                mapText1.setAttribute('disabled','1');
                                                mapText1.setAttribute('class','disabledLinkLikeButton');
                                                mapText2.setAttribute('disabled','1');
                                                mapText2.setAttribute('class','disabledLinkLikeButton');
                                                // ie needs this, netscape OK is using changed style...
                                                if (typeof(mapText1.style.cursor) != undefined)
                                                {
                                                        mapText1.style.cursor='default';
                                                        mapText1.style.color='#7f7f7f';
                                                        mapText2.style.cursor='default';
                                                        mapText2.style.color='#7f7f7f';
                                                }
                                        }
                                }

                                function SetCheckBoxes(val)
                                {
                                        allElements = document.listForm.elements;
                                        var i;
                                        for( i = 0 ; i < allElements.length; i++)
                                        {
                                                if (allElements[i].type == 'checkbox')
                                                        allElements[i].checked = val;
                                        }
                                        AllowMap();
                                }

                                function makeMapUrl(button)
                                {
                                        var search = Array();

                                        for(i=0; (input=document.getElementsByTagName("input")[i]); i++)
                                        {
                                                if ((input.getAttribute('name') == "EmuOr") && input.checked)
                                                {
                                                        var st = "exists (IdeScientificNameLocal_tab where IdeScientificNameLocal CONTAINS '" + input.getAttribute("value") + "')";
                                                        search.push(st);
                                                }
                                        }
                                        var searchSt = search.join(" OR ");
                                        searchSt += " AND exists (LatCentroidLatitude0 where LatCentroidLatitude IS NOT NULL) AND exists (LatCentroidLongitude0 where LatCentroidLongitude IS NOT NULL)";
                                        texql = "SELECT ALL FROM ecatalogue WHERE (" + searchSt + ")";

                                        document.getElementsByName("texql")[0].setAttribute("value",texql);
                                        if (! button.getAttribute('disabled'))
                                                document.forms[1].submit();
                                        else
                                                alert("disabled");

                                }
                        </script>


			<form name='listForm' method="GET" action="$this->mapperUrl">

                        <table $widthAttrib border="0" cellspacing="0" cellpadding="2">
                        <tr>
                          <td width="25%" align="left" nowrap="nowrap">
                            <table width="100%">
                              <tr>
HTML;

                $this->printControls(1);

                print <<< HTML

                              </tr>
                            </table>
                          </td>
                          <td width="75%" align="right">
HTML;
                $this->printNavLinks();

                print <<< HTML
                          </td>
                        </tr>

                        <tr>
                          <td colspan="2">
                        <table $borderColorAttrib width="100%" border="0" cellspacing="1"
                                cellpadding="4">
                        <tr $headerColorAttrib>
HTML;


                $numcol = count($this->Fields) + 1;

                if ($this->DisplayThumbnails)
                {
                        print "    <td width=\"72\" align=\"center\"><b>";
                        PPrint($this->_STRINGS['IMAGE'],
                                $this->FontFace,
                                $this->FontSize,
                                $this->HeaderTextColor);
                        print "</b></td>\n";
                }

                // Loop and display the coloum headings
                for ($i = 0; $i < $numcol - 1; $i++)
                {
                        $label = '';
                        if (is_string($this->Fields[$i]))
                        {
                                $label = $this->_STRINGS[$this->Fields[$i]];
                        }
                        elseif (strtolower(get_class($this->Fields[$i])) == 'formatfield')
                        {
                                $label = $this->Fields[$i]->Label;
                        }
                        print "    <td align=\"$this->AlignTitle\"><b>";
                        if ($label == '')
                                print '&nbsp;';
                        else
                                PPrint( $label,
                                        $this->FontFace,
                                        $this->FontSize,
                                        $this->HeaderTextColor);
                        print "</b></td>\n";
                }

               print "    <td align=\"$this->AlignTitle\"><b>";
                                PPrint( "Select Records to Map",
                                        $this->FontFace,
                                        $this->FontSize,
                                        $this->HeaderTextColor);
                        print "</b></td>\n"; 
		print "</tr>\n";

                // Loop over the results
                $rownum = 1;
                foreach ($records as $rec)
                {
                        if ($rownum > $this->LimitPerPage)
                                break;

                        print "<!--START RECORD-->\n";

                        $displaylink = $this->displayPageLink($rec);

                        if ($rownum % 2 == 0 && $this->HighlightColor != '')
                                print "  <tr $highlightColorAttrib>\n";
                        else
                                print "  <tr $backgroundColorAttrib>\n";

                        if ($this->DisplayThumbnails)
                        {
                                print "    <td width=\"72\" align=\"center\" valign=\"middle\">" . "\n";
                                // Display the thumbnail image
                                $image = new MediaImage();
                                $image->Intranet = $this->Intranet;
                                // if we are on the multimedia module then the image IRN is the
                                //  irn of the current record.
                                if ($this->Database == "emultimedia")
                                {
                                        $mediairn = $rec->{'irn_1'};
                                }
                                else
                                {
                                        $mediairn = $rec->{'MulMultiMediaRef:1'};
                                }
                                $image->IRN = $mediairn;
                                $image->BorderColor = $this->HeaderColor;
                                $image->HighLightColor = $this->HeaderColor;
                                $image->Link = $displaylink;
                                $image->Width = 60;
                                $image->Height = 60;
                                $image->KeepAspectRatio = $this->KeepImageAspectRatio;
                                $image->RefIRN = $rec->{'irn_1'};
                                $image->RefTable = $this->Database;
                                $image->ShowBorder = $this->ShowImageBorders;
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
                                $image->Show();
                                print "    </td>\n";
                        }

                        // Display Other Fields

                        for ($j = 0; $j < $numcol - 1; $j++)
                        {
                                print "    <td align=\"$this->AlignData\">";
                                $fieldData = '';

                                if (is_string($this->Fields[$j]))
                                {
                                        $fieldData = $rec->{$this->Fields[$j]};
                                }
                                elseif (strtolower(get_class($this->Fields[$j])) == 'formatfield')
                                {
                                        $field = $this->Fields[$j]->Format;
                                        $fieldData = preg_replace('/{([^}]*)}/e', ' $rec->{"\\1"}', $field);
                                }
                                $fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

                                if ($fieldData == '')
                                {
                                        $fieldData = $this->_STRINGS['NOT_STATED'];
                                }

                                // First one is a link to display record
                                if ($j == 0)
                                {
                                        print "<a href=\"$displaylink\">";
                                                PPrint($fieldData,
                                                        $this->FontFace,
                                                        $this->FontSize,
                                                        $this->TextColor,
                                                        $this->HighlightTextColor);
                                        print '</a>';
                                }
                                elseif ($fieldData != '')
                                {
                                        PPrint($fieldData,
                                                $this->FontFace,
                                                $this->FontSize,
                                                $this->TextColor);
                                }
                                else
                                {
                                        // field is empty so print space to stop netscape complaining
                                        print '&nbsp;';
                                }
                                print "</td>\n";
                        }
			$sciName = $rec->{$this->Fields[2]};
			print "<td align='center'>";
					if ($sciName != '')
					{
                                        print"        <input type='checkbox'
                                                        onClick='AllowMap();'
                                                        name='EmuOr'
                                                        value='$sciName' />";
					}
                        print  "</td>";
                       
			print "</tr>\n<!--END RECORD-->\n";
                        $rownum++;
                }

                //End Table
                print "</table>\n";
                print "</td></tr>\n";

		print <<< HTML
                <tr>
                  <td width="25%" align="left" nowrap="nowrap">
                    <table width="100%">
                      <tr>
HTML;
                $this->printControls(2);

                print <<< HTML
                      </tr>
                    </table>
                  </td>
                  <td width="75%" align="right">
HTML;

                $this->printNavLinks();

                print <<< HTML
                  </td>
                </tr>
		</table>
		</form>

                <form name='mapForm' method="GET" action="$this->mapperUrl">
                <!-- start mapper2 args -->
                        <input type='hidden' name='stylesheet' value='mapper/style/mapdisplay.html' />
                        <input type='hidden' name='transform' value='SimpleTransformation' />
                        <input type='hidden' name='texql' value='' />
                        <input type='hidden' name='source[]' value='DefaultTexxml' />
                        <input type='hidden' name='sortby' value='ScientificName' />
			<input type='hidden' name='referer' value="$referer" />
                        <input type='hidden' name='websection' value="$this->websection" />
                <!-- end   mapper2 args -->
                </form>
                <script language='javascript'>
                        AllowMap();
                </script>
HTML;
                print "<!--END OBJECT-->\n";

        }

	function printControls($position)
        {
                if ($this->mapperInstalled == 1)
                {
                        //FIRST, PRINT THE LINK TO GO BACK TO A NEW SEARCH
                        print ("<td width=\"25%\" nowrap=\"nowrap\"><a href='".$this->QueryPage ."'><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">". $this->_STRINGS['NEW SEARCH'] ."</font></a></td>");
                        print ("<td width=\"1%\" nowrap=\"nowrap\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">&nbsp;|&nbsp;</font></td>\n");
                        //SECOND, PRINT THE LINK TO GO TO THE CONTACT SHEE VIEW
                        if ($this->ContactSheetPage != '')
                        {
                                print ("<td width=\"25%\" nowrap=\"nowrap\">");
                                $this->printRedisplay($this->ContactSheetPage, $this->_STRINGS["CONTACT_SHEET"]);
                                print ("</td>\n");
                                print ("<td width=\"1%\" nowrap=\"nowrap\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">&nbsp;|&nbsp;</font></td>\n");
                        }

                        if ($position == 1)
                        {
                                print ("<td width=\"25%\" nowrap=\"nowrap\"><div id=\"mapText1\"><font face=\"$this->FontFace\" size=\"$this->FontSize\"><u>Map Selected Records</u></font></div></td>");
                                print ("<td width=\"1%\" nowrap=\"nowrap\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">&nbsp;|&nbsp;</font></td>\n");
                        }
                        else
                        {
                                print ("<td width=\"25%\" nowrap=\"nowrap\"><div id=\"mapText2\"><font face=\"$this->FontFace\" size=\"$this->FontSize\"><u>Map Selected Records</u></font></div></td>");
                                print ("<td width=\"1%\" nowrap=\"nowrap\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">&nbsp;|&nbsp;</font></td>\n");
                        }

                        print ("<td width=\"25%\" nowrap=\"nowrap\"><a onClick=\"SetCheckBoxes('checked');\" style=\"cursor: pointer; cursor: hand;\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\"><u>Select All</u></font></a></td>");
                        print ("<td width=\"1%\" nowrap=\"nowrap\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">&nbsp;|&nbsp;</font></td>\n");
                        print ("<td width=\"25%\" nowrap=\"nowrap\"><a onClick=\"SetCheckBoxes(0);\" style=\"cursor: pointer; cursor: hand;\"><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\"><u>Clear All Selection</u></font></a></td>");
                }
                else
                {
                        print ("&nbsp;<a href='".$this->QueryPage ."'><font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">". $this->_STRINGS['NEW SEARCH'] ."</font></a>");
                }

        }

} // end TePapaResultsList class

class
TePapaContactSheet extends BaseContactSheet
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	
				'WebClaFamily',
				'IdeScientificNameLocal:1',
				'WebLocCountry',
				'ColCollectionEventRef->ecollectionevents->LocOcean',
				'WebLocProvinceStateTerritory',
				);	

} // end TePapaContactSheetResultsList class

?>
