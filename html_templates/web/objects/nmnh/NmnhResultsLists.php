<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (! isset($WEB_ROOT))
{
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
}
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR  . 'BaseResultsLists.php');

$GLOBALS['STRINGS_DIR'] = $WEB_ROOT . "/objects/" . $GLOBALS['BACKEND_TYPE'] . "/" . $GLOBALS['DEPARTMENT'] . "/strings/";

//=====================================================================================================
//=====================================================================================================
class
NmnhStandardResultsList extends BaseStandardResultsList
{
	function
	NmnhStandardResultsList()
	{
		$this->BaseStandardResultsList();

		$this->Database = 'enmnh';
		$this->DisplayThumbnails = 0;

		$this->mapperInstalled = 0;
		$this->mapperUrl = "../../../webservices/mapper.php";
		$this->mapperStartMapFile = "world.map";
		$this->mapperStylesheet = "mapper/nmnh/style/nmnh.xsl";
		$this->mapperGroupBy = "ScientificName";
		$this->mapperDataSource = "DefaultTexxml";

                $this->OrderLimit = 5000;
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

                                        for(i=0; (input=document.getElementsByTagName("input")[i]); i++)
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
                                                                mapText1.style.color='#013567';
                                                                mapText2.style.cursor='pointer';
                                                                mapText2.style.color='#013567';
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
                                        for(i = 0 ; i < allElements.length; i++)
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
                                                        var st = "irn = " + input.getAttribute("value") + " ";
                                                        search.push(st);
                                                }
                                        }
                                        var searchSt = search.join(" OR ");
                                        searchSt += " AND BioPreferredCentroidLatitude IS NOT NULL AND BioPreferredCentroidLongitude IS NOT NULL";
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
HTML;

                $this->printControls(1);

                print <<< HTML

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
                                PPrint($label,
                                        $this->FontFace,
                                        $this->FontSize,
                                        $this->HeaderTextColor);
                        print "</b></td>\n";
                }

                if ($this->mapperInstalled)
                {
			print "    <td align=\"$this->AlignTitle\"><b>";
                        PPrint("Select Records to Map",
                                $this->FontFace,
                                $this->FontSize,
                                $this->HeaderTextColor);
                        print "</b></td>\n";
		}
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

                	if ($this->mapperInstalled)
                	{
                        	$irn = $rec->irn_1;
                        	print "<td align='center'>
                                	                <input type='checkbox'
                                        	                onClick='AllowMap();'
                                                	        name='EmuOr'
                                                        	value='$irn' />
                                	</td>";
			}
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
                        <input type='hidden' name='texql' value='' />
                        <input type='hidden' name='source[]' value="$this->mapperDataSource" />
                        <input type='hidden' name='sortby' value="$this->mapperGroupBy" />
                        <input type='hidden' name='mapfile' value="$this->mapperStartMapFile" />
                        <input type='hidden' name='stylesheet' value="$this->mapperStylesheet" />
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
		//FIRST, PRINT THE LINK TO GO BACK TO A NEW SEARCH
		$this->printBackLink();

		//SECOND, PRINT THE LINK TO GO TO THE CONTACT SHEET VIEW
		if ($this->ContactSheetPage != '')
		{
			PPrint(' | ', $this->FontFace, $this->FontSize, $this->TextColor);
			$this->printRedisplay($this->ContactSheetPage, $this->_STRINGS["CONTACT_SHEET"]);
		}

                if ($this->mapperInstalled == 1)
                {
			PPrint(' | ', $this->FontFace, $this->FontSize, $this->TextColor);

                        if ($position == 1)
                        {
                                print ("<SPAN id=\"mapText1\">" .
				       "<font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">" .
						"<u>Map Selected Records</u>" .
				       "</font></SPAN>");
                        }
                        else
                        {
                                print ("<SPAN id=\"mapText2\">" .
				       "<font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">" .
						"<u>Map Selected Records</u>" .
				       "</font></SPAN>");
                        }

			PPrint(' | ', $this->FontFace, $this->FontSize, $this->TextColor);

                        print ("<a onClick=\"SetCheckBoxes('checked');\" style=\"cursor: pointer; cursor: hand;\">" .
			       "<font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">" .
					"<u>Select All</u>" .
			       "</font></a>");

			PPrint(' | ', $this->FontFace, $this->FontSize, $this->TextColor);

                        print ("<a onClick=\"SetCheckBoxes(0);\" style=\"cursor: pointer; cursor: hand;\">" .
			       "<font face=\"$this->FontFace\" size=\"$this->FontSize\" color=\"$this->TextColor\">" .
					"<u>Clear All Selection</u>" . 
			       "</font></a>");
                }
        }
}
//=====================================================================================================
//=====================================================================================================
class
NmnhContactSheet extends BaseContactSheet
{
	function
	NmnhContactSheet()
	{
		$this->BaseContactSheet();

        	$this->Database = 'enmnh';
                $this->OrderLimit = 5000;
	}

	function
	doQuery ()
	{
		/*
		*  Dynamicall create the specified QueryGenerator and
		*    call a method corresponding to the QueryName.
		*    Set the results in the $this->records array for
		*    use elsewhere.
		*/

		// only run once
		if ($this->_queryDone)
			return;
		$this->_queryDone = 1;

		// Add mandatory fields to $this->Fields for select
		$select = array();
		if (is_array($this->DisplayPage) && $this->DisplayPage['ConditionField'] != '')
		{
			$select = array('irn', 
					  'MulMultiMediaRef_tab', 
					  'AdmPublishWebNoPasswordLocal_tab', 
					  $this->DisplayPage['ConditionField']);
		}
		else
		{
			if ($this->Database == "emultimedia")
			{
				$select = array('irn');
			}
			else
			{
				$select = array('irn', 'MulMultiMediaRef_tab', 'AdmPublishWebNoPasswordLocal_tab');
			}
		}

		foreach ($this->Fields as $fld)
		{
			if (is_string($fld))
			{
				array_push($select, $fld);
			}
			elseif (strtolower(get_class($fld)) == 'formatfield')
			{
				// format in the form "{ColName1} {ColName2}"
				preg_match_all('/{([^}]*)}/', 
						$fld->Format, 
						$matches);
				foreach ($matches[1] as $colName)
				{
					array_push($select, $colName);
				}
			}
		}

		$where = '';
		if ($this->Where == '')
		{
			$qryGenerator = new $this->QueryGenerator;
			// these properties are used by the RandomQuery
			$qryGenerator->Database = $this->Database;
			$qryGenerator->Limit = $this->LimitPerPage;
			$qryGenerator->Intranet = $this->Intranet;
			// Use reflection to call query method
			$queryAttrib = $qryGenerator->{$this->QueryName}();
			$where = $queryAttrib->Where;
		}
		else
		{
			$where = $this->Where;
		}

		if ($this->Restriction != '')
		{
			if ($where == "")
				$where = "true";
			$where = "($where) AND (" . $this->Restriction . ")";
		}

		$qry = new ConfiguredQuery;
		$qry->SelectedLanguage = $this->LanguageData;
		$qry->Intranet = $this->Intranet;
		$qry->Select = $select;
		$qry->From = $this->Database;
		$qry->Where = $where;
		if (!empty($queryAttrib->RankTerm) || !empty($queryAttrib->RankOn))
		{
			$qry->RankTerm = $queryAttrib->RankTerm;
			$qry->RankOn = $queryAttrib->RankOn;
		}
		// One extra so we know it there are more records
		$qry->Limit = $this->LimitPerPage + 1;	
		$qry->Offset = $this->StartAt;

		$this->records = $qry->Fetch();
		$this->Matches = $qry->Matches;
		if ($qry->Status == 'failed')
		{
			print $qry->Where;
			WebDie ('Query Error - Texxmlserver: ' . 
				$qry->Error , 
				'where: ' . $where);
		}

		/*
		** If $this->Order set, and # matches < OrderLimit, perform the same
		** query again but this time order it.
		*/
		if ($this->Order != "" && $this->Matches <= $this->OrderLimit)
		{
			$orderfields = explode("|", $this->Order);
			foreach ($orderfields as $orderfield)
			{
				if (preg_match("/^[\+-]((.*)_tab)$/", $orderfield, $matches))
					$orderstring .= $matches[1] . "[" . $matches[2] . "], ";
				elseif (preg_match("/^\+(.*)$/", $orderfield, $matches))
					$orderstring .= $matches[1] . " asc, ";
				elseif (preg_match("/^-(.*)$/", $orderfield, $matches))
					$orderstring .= $matches[1] . " desc, ";
				else
					$orderstring .= $orderfield . " asc, ";

				$fieldname = empty($matches[1]) ? $orderfield : $matches[1];

				if (array_search($fieldname, $select) === FALSE)
					array_push($select, $fieldname);
			}
			$orderstring = preg_replace("/,\s$/", "", $orderstring);
			$qry->Select = $select;
			$qry->Order = $orderstring;
			$this->records = $qry->Fetch();

			if ($qry->Status == 'failed')
			{
				print $qry->Where;
				WebDie ('Query Error - Texxmlserver: ' . 
					$qry->Error , 
					'where: ' . $where);
			}
		}
	}

	function
	display()
	{
		$records =& $this->records;

		$widthAttrib = '';
		$backgroundColorAttrib = '';
		$highlightColorAttrib = '';
		$borderColorAttrib = '';
		if ($this->Width != '')
			$widthAttrib 	= 'width="' . $this->Width . '"' ;
		if ($this->BodyColor != '')
			$backgroundColorAttrib	= 'bgcolor="' . $this->BodyColor . '"';
		if ($this->HighlightColor != '')
			$highlightColorAttrib	= 'bgcolor="' . $this->HighlightColor . '"';
		else
			$highlightColorAttrib	= 'bgcolor="' . $this->BodyColor . '"';
		if ($this->BorderColor != '')
			$borderColorAttrib= 'bgcolor="' . $this->BorderColor . '"';

		$colwidth = (int) ((float) 100 / (float) $this->NumColumns);

		//Print Table header
		print "<!--START OBJECT-->\n";
		print "<table $widthAttrib border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->ResultsListPage != '')
		{
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$this->printRedisplay($this->ResultsListPage, 
						$this->_STRINGS["LIST_VIEW"]);
		}
		print "</td>";
		print "<td width=\"75%\" align=\"right\">\n";
		$this->printNavLinks();
		print "</td></tr>";
		print "<tr><td colspan=\"2\">\n";
		print "<table $borderColorAttrib width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\">\n";

		// Loop over the results
		$rownum = 1;
		$recordnum = 0;
		$hasMore = 1;
		while($hasMore)
		{
			if ($rownum % 2 == 0 && $this->HighlightColor != '')
				print "  <tr $highlightColorAttrib>\n";
			else
				print "  <tr $backgroundColorAttrib>\n";

			for($colnum = 1; $colnum <= $this->NumColumns; $colnum++)
			{
				print "    <td align=\"center\" valign=\"top\" width=\"$colwidth%\">\n";
				if (isset($records[$recordnum]) && $recordnum < $this->LimitPerPage)
				{
					$displaylink = $this->displayPageLink($records[$recordnum]);

					// Display the thumbnail image
					print "<table width=\"100%\"><tr><td height=\"120\" align=\"center\" valign=\"middle\">";
					print "<!--START RECORD-->\n";
					$image = new MediaImage();
					if (! $this->ThumbnailsLinkToFullView)
					{
						$image->Link = $displaylink;
					}
					$image->Intranet = $this->Intranet;
					if ($this->Database == "emultimedia")
					{
						$mediairn = $records[$recordnum]->{'irn_1'};
					}
					else
					{
						$i = 1;
                        			$mmField = "MulMultiMediaRef:$i";
                        			$publishField = "AdmPublishWebNoPasswordLocal:$i";
                        			$mediairn = $records[$recordnum]->{$mmField};
                        			$mediairntmp = $mediairn;
                        			$publish = $records[$recordnum]->{$publishField};

                        			while ($mediairntmp != '')
                        			{
                                			if (strtolower($publish) == "yes")
							{
								$mediairn = $mediairntmp;
                                				break;
							}

							$i++;
                                			$mmField = "MulMultiMediaRef:$i";
                                			$publishField = "AdmPublishWebNoPasswordLocal:$i";
                        				$mediairntmp = $records[$recordnum]->{$mmField};
                        				$publish = $records[$recordnum]->{$publishField};
						}
					}

					$image->IRN = $mediairn;
					$image->BorderColor = $this->HeaderColor;
					$image->HighLightColor = $this->HeaderColor;
					$image->Width = 100;
					$image->Height = 100;
					$image->KeepAspectRatio = 1;
					$image->RefIRN = $records[$recordnum]->{'irn_1'};
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

					print "</td></tr><tr><td align=\"center\" valign=\"top\">";

					$fieldnum = 1;
					foreach($this->Fields as $fld)
					{
					
						if (is_string($fld))
						{
							$fieldData = $records[$recordnum]->{"$fld"};
						}
						elseif (strtolower(get_class($fld)) == 'formatfield')
						{
							$field = $fld->Format;
							$fieldData = preg_replace('/{([^}]*)}/e', ' $records[$recordnum]->{"\\1"}', $field);
						}

						if ($fieldData == '')
						{
							$fieldData = $this->_STRINGS['NOT_STATED'];
						}

						if ($fieldnum++ == 1)
						{
							print "<a href=\"$displaylink\">";
							PPrint($fieldData, 
								$this->FontFace,
								$this->FontSize,
								$this->TextColor, 
								$this->HighlightTextColor);
							print '</a><br />';
						}
						else
						{
							PPrint($fieldData, 
								$this->FontFace,
								$this->SmallFontSize, 
								$this->TextColor);
								print "<br />";
						}
					}
					print "</td></tr></table>";

					print "<!--END RECORD-->\n";
				}
				else
					$hasMore = 0;

				$recordnum++;
				print "    </td>\n";
			}
			print "</tr>\n";
			// Display Other Fields
			$rownum++;
		}

		//End Table
		print "</table>\n";
		print "</td></tr>";
		// Nav Links
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->ResultsListPage != '')
		{
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$this->printRedisplay($this->ResultsListPage, 
						$this->_STRINGS["LIST_VIEW"]);
		}
		print "</td>";
		print "<td width=\"75%\" align=\"right\">";
		$this->printNavLinks();
		print "</td></tr>";
		print "</table>\n";
		print "<!--END OBJECT-->\n";

	}
}
//=====================================================================================================
//=====================================================================================================
?>
