<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');
require_once ('DefaultPaths.php');

class
QagStandardResultsList extends BaseStandardResultsList
{

	function
	QagStandardResultsList()
	{
		$this->BaseStandardResultsList();

	       	$imgtype = new FormatField;
		$imgtype->Format = "{MulMultiMediaRef:1->emultimedia->MulMimeType}";
		$imgtype->Label = "IMAGE";

	       	$creator = new FormatField;
		$creator->Format = "{ArtArtistLocal}";
		$creator->Label = "CREATOR/CULTURE";

	       	$born = new FormatField;
	       	//$born->Format = "{ArtArtistRef:1->eparties->BioBirthDate}";
	       	$born->Format = "{ArtBirthDateLocal}";
		$born->Label = "BORN";

	       	$died = new FormatField;
		//$died->Format = "{ArtArtistRef:1->eparties->BioDeathDate}";
		$died->Format = "{ArtDeathDateLocal}";
		$died->Label = "DIED";

		$title = new FormatField;
		$title->Format = "{SumTitle}";
		$title->Label = "TITLE";

	      	$date = new FormatField;
	       	$date->Format = "{SumDate}";
		$date->Label = "DATE";

		$media = new FormatField;
		$media->Format = "{ArtMediaCategory}";
		$media->Label = "MEDIA";
	
		$department = new FormatField;
		$department->Format = "{SumDepartment}";
		$department->Label = "DEPT";

	 	$accession = new FormatField;
		$accession->Format = "{SumAccessionNumber}";
		$accession->Label = "ACC. NO.";

		$this->Fields = array(	$imgtype,
					$creator,
					$born,
					$died,
					$title,
					$date,
					$media,
					$department,
					$accession,
			);
		if ($_REQUEST['SortBy'] == '')
		{
			$this->Order = "+ArtArtistLocal|+SumTitle";
		}
		elseif ($_REQUEST['SortBy'] == 'Title')
		{
			$this->Order = "+SumTitle";
		}
		elseif ($_REQUEST['SortBy'] == 'Date')
		{
			$this->Order = "+SumDate";
		}
		elseif ($_REQUEST['SortBy'] == 'Department')
		{
			$this->Order = "+SumDepartment";
		}
		elseif ($_REQUEST['SortBy'] == 'MediaCategory')
		{
			$this->Order = "+ArtMediaCategory";
		}
		elseif ($_REQUEST['SortBy'] == 'PrincipalCountry')
		{
			$this->Order = "+ArtPrincipalCountryLocal";
		}
		elseif ($_REQUEST['SortBy'] == 'State')
		{
			$this->Order = "+ArtStateLocal";
		}
		elseif ($_REQUEST['SortBy'] == 'MF')
		{
			$this->Order = "+ArtGenderLocal";
		}
		elseif ($_REQUEST['SortBy'] == 'AccNo')
		{
			$this->Order = "+SumAccessionNumber";
		}
		$this->OrderLimit = 20000;
		$this->DisplayThumbnails = 0;
	}

	// Not used for the time being. This was going to join BioBirthDate and BioDeathDate into one column, but they will be
	// in seperate columns for now. Kim
	/*function
	adjustData($field, $rec, $fieldData)
	{*/
		/*  Build up a list of the type status values.
		*/
		/*if ($field == 'ArtArtistRef_tab->eparties->BioBirthDates')
		{
			$fieldData = "";
			$fieldBirth = $rec->{"ArtArtistRef:1->eparties->BioBirthDate"};
			$fieldDeath = $rec->{"ArtArtistRef:1->eparties->BioDeathDate"};
			if (!($fieldBirth == "" && $fieldDeath == ""))
			{
				if ($fieldBirth == "")
				{
					$fieldData = "? - " . $fieldDeath;	
				}
				else if ($fieldDeath == "")
				{
					$fieldData =  $fieldBirth . " - ?";
				}	
				else
				{
					$fieldData = $fieldBirth . " - " . $fieldDeath;
				}
			}
		}

		return $fieldData;
	}*/
	/*
        function
        printRedisplay($page, $linktext, $newLimit=0)
        {
                $getString = $this->RedirectLink($page, $newLimit);
                print "<a href=\"$getString\">";
                PPrint($linktext,
                        $this->FontFace,
                        $this->FontSize,
                        $this->TextColor);
                print "</a>";
        }
	*/


	function
	display()
	{
		$records =& $this->records;

		$widthAttrib = '';
		$backgroundColorAttrib = '';
		$highlightColorAttrib = '';
		//Aaron - Added conditional statement to set border attribute
		$borderAttrib = 0;
		if ($this->Border != 0)
			$borderAttrib = $this->Border;
		if ($this->Width != '')
			$widthAttrib 	= 'width="' . $this->Width . '"' ;
		if ($this->BodyColor != '')
			$backgroundColorAttrib	= 'bgcolor="' . $this->BodyColor . '"';
		if ($this->HighlightColor != '')
			$highlightColorAttrib	= 'bgcolor="' . $this->HighlightColor . '"';
		else
			$highlightColorAttrib	= 'bgcolor="' . $this->BodyColor . '"';
		if ($this->HeaderColor != '')
			$headerColorAttrib= 'bgcolor="' . $this->HeaderColor . '"';
		if ($this->BorderColor != '')
			$borderColorAttrib= 'bgcolor="' . $this->BorderColor . '"';

		// Find out how many coloums (one extra for image coloum)
		$numcol = count($this->Fields) + 1;

		//Print Table header
		print "<!--START OBJECT-->\n";
		print "<table $widthAttrib border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->ContactSheetPage != '')
		{
			if ($this->QueryPage != '')
			{
				PPrint(' | ', 
					$this->FontFace, 
					$this->FontSize, 
					$this->TextColor);
			}
			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$this->printRedisplay($this->ContactSheetPage, 
				$this->_STRINGS["CONTACT_SHEET"]);
		}
		print "</td>";
		print "<td width=\"75%\" align=\"right\">\n";
		$this->printNavLinks();
		print "</td></tr>";
		print "<tr><td colspan=\"2\">\n";
		//Aaron - any changes to border size set here
		print "<table $borderColorAttrib width=\"100%\" border=\"$borderAttrib\" cellspacing=\"1\" cellpadding=\"4\">\n";
		// Print the Header Row
		print "  <tr $headerColorAttrib>\n";
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
				PPrint(	$label, 
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
					$fieldData = preg_replace('/{([^{}]*)}/e', ' $rec->{"\\1"}', $field);
				}
				$fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

					
				// First one is a link to display record
				//if ($j == 4)
				if (preg_match('/SumTitle/', $this->Fields[$j]->Format) == 1)
				{
					// If there is no title, no link can be
					// created. So must have some text to
					// enable the link to record
					if ($fieldData == '')
					{
						$fieldData = $this->_STRINGS['NOT_STATED'];
					}
					else
					{ 
						$fieldData = substr($fieldData, 0, 40);
					}
					print "<a href=\"$displaylink\">";
						PPrint($fieldData, 
							$this->FontFace, 
							$this->FontSize,
							$this->TextColor, 
							$this->HighlightTextColor);
					print '</a>';
				}
				elseif (preg_match('/MulMimeType/', $this->Fields[$j]->Format) == 1)
				{
					print '<table class="HasImage"><tr class="';
					if ($fieldData == 'image')
					{
						print 'ImageYes"><td class="ImageYes"';
					}
					else
					{
						print 'ImageNo"><td';
					}
					print '></td></table>';
				}
				elseif ($fieldData != '')
				{
					if (preg_match('/ArtArtistLocal/', $this->Fields[$j]->Format) == 1)
						$fieldData = substr($fieldData, 0, 40);

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

			print "  </tr>\n<!--END RECORD-->\n";
			$rownum++;
		}

		//End Table
		print "</table>\n";
		print "</td></tr>";
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->ContactSheetPage != '')
		{
			if ($this->QueryPage != '')
			{
				PPrint(' | ', 
					$this->FontFace, 
					$this->FontSize, 
					$this->TextColor);
			}
			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);

			$this->printRedisplay($this->ContactSheetPage, $this->_STRINGS["CONTACT_SHEET"]);
		}
		
		print "</td>";
		print "<td width=\"75%\" align=\"right\">\n";
		$this->printNavLinks();
		print "</td></tr>";
		print "</table>\n";
		print "<!--END OBJECT-->\n";
		$GLOBALS['REC_LIST'] = $this->records;
	}
	function
	printNavLinks()
	{
		$nextlink = "";
		$backlink = "";
		// Print summary (i.e 10 to 20 of 234)
		if ($this->Matches > 0)
		{
			$onpage = count($this->records);
			if ($onpage > $this->LimitPerPage)
				$onpage = $this->LimitPerPage;

			$upper = $this->StartAt + $onpage - 1;

			$matches = $this->Matches;
			if ($onpage < $this->LimitPerPage
					&& $matches > $upper)
				$matches = $upper;

			$summary = sprintf($this->_STRINGS['RESULTS SUMMARY'], 
					$this->StartAt, 
					$upper,
					$matches);
		}
		else
		{
			$summary = sprintf(
				$this->_STRINGS['BRIEF RESULTS SUMMARY'], 
				$this->StartAt, 
				$this->StartAt + $this->LimitPerPage -1);
		}
		PPrint( $summary, 
			$this->FontFace, 
			$this->FontSize, 
			$this->TextColor);

		print '&nbsp;&nbsp;';

		// Pass all post/get vars through except 'StartAt'
		// increment 'StartAt' by the page limit ($this->LimitPerPage)

		// Note: This should be phased out in the future and changed to:
		//	array_merge($_POST', $_GET);
		$perams = $_REQUEST;
		if(empty($perams))
		{
			$perams = array_merge($GLOBALS['HTTP_POST_VARS'],
				$GLOBALS['HTTP_GET_VARS']);
		}

		while(list($key, $val) = each($perams))
		{ 
			// Don't pass through empty vars 
			// try to keep url length down
			if ($val == '')
				continue;
			if ($key != 'StartAt')
			{
				$key = urlencode(stripslashes($key)); 
				$val = urlencode(stripslashes($val)); 
				$getString .= "$key=$val&amp;"; 
			}
		} 

		$thisPage = isset($GLOBALS['PHP_SELF'])
			? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$numresults = $this->LimitPerPage;

		// Print the Back button if required
		if ($this->StartAt > 1)
		{
			$backlink = "$thisPage?$getString" . 
				'StartAt=' . 
				($this->StartAt - $this->LimitPerPage);

			PPrint('<< ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "<a href=\"$backlink\">";
			PPrint($this->_STRINGS['PREVIOUS'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "</a>&nbsp;";
			PPrint('|', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
		}

		// Print the Next button if required
		if (count($this->records) > $this->LimitPerPage)
		{
			$nextlink .= "$thisPage?$getString" . 
				'StartAt=' . 
				($this->StartAt + $this->LimitPerPage);
			print "&nbsp;<a href=\"$nextlink\">";
			PPrint($this->_STRINGS['NEXT'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "</a>&nbsp;";
			PPrint(' >>', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
		}
		$this->NextLink = $nextlink;
		$this->BackLink = $backlink;
	}


} // end QagResultsList class

class
QagContactSheet extends BaseContactSheet
{
	function
	QagContactSheet()
	{
		$this->BaseResultsList();
		$this->Fields = array(	'ArtArtistLocal',
					'ArtBirthDateLocal',
					'ArtDeathDateLocal',
					'SumTitle',
					'SumDate',
					'ArtMediaCategory',
					'SumAccessionNumber',
				);

		if ($_REQUEST['SortBy'] == '')
		{
			$this->Order = "+ArtArtistLocal|+SumTitle";
		}
		elseif ($_REQUEST['SortBy'] == 'Title')
		{
			$this->Order = "+SumTitle";
		}
		elseif ($_REQUEST['SortBy'] == 'Date')
		{
			$this->Order = "+SumDate";
		}
		elseif ($_REQUEST['SortBy'] == 'Department')
		{
			$this->Order = "+SumDepartment";
		}
		elseif ($_REQUEST['SortBy'] == 'MediaCategory')
		{
			$this->Order = "+ArtMediaCategory";
		}
		elseif ($_REQUEST['SortBy'] == 'PrincipalCountry')
		{
			$this->Order = "+ArtPrincipalCountryLocal";
		}
		elseif ($_REQUEST['SortBy'] == 'State')
		{
			$this->Order = "+ArtStateLocal";
		}
		elseif ($_REQUEST['SortBy'] == 'MF')
		{
			$this->Order = "+ArtGenderLocal";
		}
		elseif ($_REQUEST['SortBy'] == 'AccNo')
		{
			$this->Order = "+SumAccessionNumber";
		}
		$this->OrderLimit = 20000;
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
				if (isset($records[$recordnum]) 
					&& $recordnum < $this->LimitPerPage)
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
						$mediairn = $records[$recordnum]->{'MulMultiMediaRef:1'};
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
						$image->ImageDisplayPage = 'QagImageDisplay.php';
					}
					elseif($this->Intranet)
					{
						$image->ImageDisplayPage = 'QagImageDisplay.php';
					}	
					else
					{
						$image->ImageDisplayPage = 'QagImageDisplay.php';
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
							$fieldData = preg_replace('/{([{^}]*)}/e', ' $records[$recordnum]->{"\\1"}', $field);
						}

						if ($fieldData == '')
						{
							//$fieldData = $this->_STRINGS['NOT_STATED'];
						}

						if ($fieldnum++ == 4)
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
	function
	printNavLinks()
	{
		$nextlink = "";
		$backlink = "";
		// Print summary (i.e 10 to 20 of 234)
		if ($this->Matches > 0)
		{
			$onpage = count($this->records);
			if ($onpage > $this->LimitPerPage)
				$onpage = $this->LimitPerPage;

			$upper = $this->StartAt + $onpage - 1;

			$matches = $this->Matches;
			if ($onpage < $this->LimitPerPage
					&& $matches > $upper)
				$matches = $upper;

			$summary = sprintf($this->_STRINGS['RESULTS SUMMARY'], 
					$this->StartAt, 
					$upper,
					$matches);
		}
		else
		{
			$summary = sprintf(
				$this->_STRINGS['BRIEF RESULTS SUMMARY'], 
				$this->StartAt, 
				$this->StartAt + $this->LimitPerPage -1);
		}
		PPrint( $summary, 
			$this->FontFace, 
			$this->FontSize, 
			$this->TextColor);

		print '&nbsp;&nbsp;';

		// Pass all post/get vars through except 'StartAt'
		// increment 'StartAt' by the page limit ($this->LimitPerPage)

		// Note: This should be phased out in the future and changed to:
		//	array_merge($_POST', $_GET);
		$perams = $_REQUEST;
		if(empty($perams))
		{
			$perams = array_merge($GLOBALS['HTTP_POST_VARS'],
				$GLOBALS['HTTP_GET_VARS']);
		}

		while(list($key, $val) = each($perams))
		{ 
			// Don't pass through empty vars 
			// try to keep url length down
			if ($val == '')
				continue;
			if ($key != 'StartAt')
			{
				$key = urlencode(stripslashes($key)); 
				$val = urlencode(stripslashes($val)); 
				$getString .= "$key=$val&amp;"; 
			}
		} 

		$thisPage = isset($GLOBALS['PHP_SELF'])
			? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$numresults = $this->LimitPerPage;

		// Print the Back button if required
		if ($this->StartAt > 1)
		{
			$backlink = "$thisPage?$getString" . 
				'StartAt=' . 
				($this->StartAt - $this->LimitPerPage);

			PPrint('<< ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "<a href=\"$backlink\">";
			PPrint($this->_STRINGS['PREVIOUS'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "</a>&nbsp;";
			PPrint('|', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
		}

		// Print the Next button if required
		if (count($this->records) > $this->LimitPerPage)
		{
			$nextlink .= "$thisPage?$getString" . 
				'StartAt=' . 
				($this->StartAt + $this->LimitPerPage);
			print "&nbsp;<a href=\"$nextlink\">";
			PPrint($this->_STRINGS['NEXT'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "</a>&nbsp;";
			PPrint(' >>', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
		}
		$this->NextLink = $nextlink;
		$this->BackLink = $backlink;
	}

} // end QagContactSheetResultsList class


class
QagReport4ResultsList extends QagStandardResultsList
{

	function
	QagReport4ResultsList()
	{
		$this->QagStandardResultsList();
		for($i=1; $i<21; $i++)
		{

			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamFirst';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamLast';
			$fldarr[] = 'ArtArtistRole:' . $i; 
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioEthnicity';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioNationality';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioBirthDate';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioDeathDate';
		}
		$arr = array_push (	$fldarr,
					'SumTitle',
					'SumDate',
					'SumMedium',
					'SumSupport',
					'ArtEdition',
					'ArtDimensionsA',
					'ArtDimensionsB',
					'SumAccessionNumber',
					'ArtCreditLine'
				);
		$this->Fields = $fldarr;
	}


	/*report 4*/
	function
	display()
	{
		$records =& $this->records;

		// Find out how many coloums (one extra for image coloum)
		$numcol = count($this->Fields) + 1;

		//Print Table header
		print "<!--START OBJECT-->\n";


		// Loop over the results
		$rownum = 1;
		$ethn = '';
		$born = '';
		$death = '';
		foreach ($records as $rec)
		{
			if ($rownum > $this->LimitPerPage)
				break;

			print "<!--START RECORD-->\n";


			// Display Other Fields
			for ($j = 0; $j < $numcol - 1; $j++)
			{
				$fieldData = '';

				if (is_string($this->Fields[$j]))
				{
					$fieldData = $rec->{$this->Fields[$j]};
				}
				elseif (strtolower(get_class($this->Fields[$j])) == 'formatfield')
				{
					$field = $this->Fields[$j]->Format;
					$fieldData = preg_replace('/{([{^}]*)}/e', ' $rec->{"\\1"}', $field);
				}
				$fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

				$printstring = '';
				if (preg_match('/NamLast/', $this->Fields[$j]) == 1)
				{
					$last = $j;
					$first = $j-1;
					$printstring = $rec->{$this->Fields[$last]};
					if ($rec->{$this->Fields[$first]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= ', ';
						}
						$printstring .= $rec->{$this->Fields[$first]};
					}
					$fieldData = $printstring;
				}
				elseif (preg_match('/BioDeathDate/', $this->Fields[$j]) == 1)
				{
					$deathdate = $j;
					$birthdate = $j-1;
					$nationality = $j-2;

					if ($rec->{$this->Fields[$nationality]} != '')
					{
						$printstring = $rec->{$this->Fields[$nationality]} . '&nbsp;';
					}
					if ($rec->{$this->Fields[$birthdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;';
						}
						$printstring .= 'b.' . $rec->{$this->Fields[$birthdate]};
					}
					if ($rec->{$this->Fields[$deathdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;';
						}
						$printstring .= 'd.' . $rec->{$this->Fields[$deathdate]};
					}
					$fieldData = $printstring;
				}
				elseif ($fieldData == '' 
					|| (preg_match('/BioNationality/', $this->Fields[$j]) == 1) 
					|| (preg_match('/NamFirst/', $this->Fields[$j]) == 1) 
					|| (preg_match('/BioBirthDate/', $this->Fields[$j]) == 1))
				{
					continue;
				}
				if ($fieldData != '')
				{
					$fieldData = preg_replace('/\\r?\\n/', "<br />\n", $fieldData);
					if (preg_match('/SumAccessionNumber/', $this->Fields[$j]) == 1)
					{
						print "Acc. $fieldData";
						
					}
					elseif (preg_match('/SumTitle/', $this->Fields[$j]) == 1)
					{
						print "<i>$fieldData</i>";
					}
					else
					{
						print "$fieldData";
					}
					print "<br \>\n";
				}
			}
			print "<br \>\n";

			print "  <!--END RECORD-->\n";
			$rownum++;
		}
		print "<!--END OBJECT-->\n";
	}

} // end QagReport4ResultsList class

class
QagEssayResultsList extends QagStandardResultsList
{

	function
	QagEssayResultsList()
	{
		$this->QagStandardResultsList();
		for($i=1; $i<6; $i++)
		{

			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamFirst';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamLast';
			$fldarr[] = 'ArtArtistRole:' . $i; 
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioEthnicity';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioNationality';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioBirthDate';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioDeathDate';
		}
		$arr = array_push (	$fldarr,
					'SumTitle',
					'SumDate',
					'SumMedium',
					'SumSupport',
					'ArtEdition',
					'ArtDimensionsA',
					'ArtDimensionsB',
					'SumAccessionNumber',
					'ArtCreditLine',
					'RefExhibitionHistory',
					'RefReferences',
					'RefReproductions',
					'RefAdditionalInformation'
				);
		$this->Fields = $fldarr;
	}


	/*report 4*/
	function
	display()
	{
		$records =& $this->records;

		// Find out how many coloums (one extra for image coloum)
		$numcol = count($this->Fields) + 1;

		//Print Table header
		print "<!--START OBJECT-->\n";


		// Loop over the results
		$rownum = 1;
		$ethn = '';
		$born = '';
		$death = '';
		foreach ($records as $rec)
		{
			if ($rownum > $this->LimitPerPage)
				break;

			print "<!--START RECORD-->\n";


			// Display Other Fields
			for ($j = 0; $j < $numcol - 1; $j++)
			{
				$fieldData = '';

				if (is_string($this->Fields[$j]))
				{
					$fieldData = $rec->{$this->Fields[$j]};
				}
				elseif (strtolower(get_class($this->Fields[$j])) == 'formatfield')
				{
					$field = $this->Fields[$j]->Format;
					$fieldData = preg_replace('/{([{^}]*)}/e', ' $rec->{"\\1"}', $field);
				}
				$fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

				$printstring = '';
				if (preg_match('/NamLast/', $this->Fields[$j]) == 1)
				{
					$last = $j;
					$first = $j-1;
					$printstring = $rec->{$this->Fields[$last]};
					if ($rec->{$this->Fields[$first]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= ', ';
						}
						$printstring .= $rec->{$this->Fields[$first]};
					}
					$fieldData = $printstring;
				}
				elseif (preg_match('/BioDeathDate/', $this->Fields[$j]) == 1)
				{
					$deathdate = $j;
					$birthdate = $j-1;
					$nationality = $j-2;

					if ($rec->{$this->Fields[$nationality]} != '')
					{
						$printstring = $rec->{$this->Fields[$nationality]};
					}
					if ($rec->{$this->Fields[$birthdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= ' ';
						}
						$printstring .= 'b.' . $rec->{$this->Fields[$birthdate]};
					}
					if ($rec->{$this->Fields[$deathdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= ' ';
						}
						$printstring .= 'd.' . $rec->{$this->Fields[$deathdate]};
					}
					$fieldData = $printstring;
				}
				elseif ($fieldData == '' 
					|| (preg_match('/BioNationality/', $this->Fields[$j]) == 1) 
					|| (preg_match('/NamFirst/', $this->Fields[$j]) == 1) 
					|| (preg_match('/BioBirthDate/', $this->Fields[$j]) == 1))
				{
					continue;
				}
				if ($fieldData != '')
				{
					$fieldData = preg_replace('/\\r?\\n/', "<br />\n", $fieldData);
					if (preg_match('/SumTitle/', $this->Fields[$j]) == 1)
					{
						print "<i>$fieldData</i>";
					}
					else
					{
						if (preg_match('/SumAccessionNumber/', $this->Fields[$j]) == 1)
						{
							print "Acc. ";
						}
						elseif (preg_match('/RefExhibitionHistory/', $this->Fields[$j]) == 1)
						{
							print "<b>Exhibition history</b><br>";
						}
						elseif (preg_match('/RefReferences/', $this->Fields[$j]) == 1)
						{
							print "<b>References</b><br>";
						}
						elseif (preg_match('/RefReproductions/', $this->Fields[$j]) == 1)
						{
							print "<b>Reproductions</b><br>";
						}
						elseif (preg_match('/RefAdditionalInformation/', $this->Fields[$j]) == 1)
						{
							print "<b>Additional information (including Note on art work and artist)</b><br>";
						}
						print "$fieldData";
					}
					print "<br \>\n";
				}
			}
			print "<br \>\n";

			print "  <!--END RECORD-->\n";
			$rownum++;
		}
		print "<!--END OBJECT-->\n";
	}

} // end QagEssayResultsList class

class
QagExhLabelResultsList extends QagStandardResultsList
{

	function
	QagExhLabelResultsList()
	{
		$this->QagStandardResultsList();
		for($i=1; $i<21; $i++)
		{

			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamFirst';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->NamLast';
			$fldarr[] = 'ArtArtistRole:' . $i; 
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioNationality';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioState';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioBirthDate';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioDeathDate';
			$fldarr[] = 'ArtArtistRef:' . $i . '->eparties->BioEthnicity';
		}
		$arr = array_push (	$fldarr,
					'SumTitle',
					'SumDate',
					'SumMedium',
					'SumSupport',
					'ArtCreditLine'
				);
		$this->Fields = $fldarr;
	}

	function
	display()
	{
		$records =& $this->records;

		// Find out how many coloums (one extra for image coloum)
		$numcol = count($this->Fields) + 1;

		//Print Table header
		print "<!--START OBJECT-->\n";


		// Loop over the results
		$rownum = 1;
		$ethn = '';
		$born = '';
		$death = '';
		foreach ($records as $rec)
		{
			if ($rownum > $this->LimitPerPage)
				break;

			print "<!--START RECORD-->\n";


			// Display Other Fields
			for ($j = 0; $j < $numcol - 1; $j++)
			{
				$fieldData = '';

				if (is_string($this->Fields[$j]))
				{
					$fieldData = $rec->{$this->Fields[$j]};
				}
				elseif (strtolower(get_class($this->Fields[$j])) == 'formatfield')
				{
					$field = $this->Fields[$j]->Format;
					$fieldData = preg_replace('/{({[^}]*)}/e', ' $rec->{"\\1"}', $field);
				}
				$fieldData = $this->adjustData($this->Fields[$j], $rec, $fieldData);

				$printstring = '';
				if (preg_match('/NamLast/', $this->Fields[$j]) == 1)
				{
					$last = $j;
					$first = $j-1;
					$printstring = $rec->{$this->Fields[$first]};
					if ($rec->{$this->Fields[$last]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= ' ';
						}
						$printstring .= $rec->{$this->Fields[$last]};
					}
					$fieldData = $printstring;
				}
				elseif (preg_match('/BioDeathDate/', $this->Fields[$j]) == 1)
				{
					$deathdate = $j;
					$birthdate = $j-1;
					$state = $j-2;
					$nationality = $j-3;

					if ($rec->{$this->Fields[$nationality]} != '')
					{
						$printstring = $rec->{$this->Fields[$nationality]};
					}
					if ($rec->{$this->Fields[$state]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;&nbsp;&nbsp;';
						}
						$printstring .= $rec->{$this->Fields[$state]};
					}
					if ($rec->{$this->Fields[$birthdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;&nbsp;&nbsp;';
						}
						$printstring .= 'b.' . $rec->{$this->Fields[$birthdate]};
					}
					if ($rec->{$this->Fields[$deathdate]} != '')
					{
						if ($printstring != '')
						{
							$printstring .= '&nbsp;&nbsp;&nbsp;';
						}
						$printstring .= 'd.' . $rec->{$this->Fields[$deathdate]};
					}
					$fieldData = $printstring;
				}
				elseif ($fieldData == '' 
					|| (preg_match('/BioNationality/', $this->Fields[$j]) == 1) 
					|| (preg_match('/NamFirst/', $this->Fields[$j]) == 1) 
					|| (preg_match('/BioState/', $this->Fields[$j]) == 1) 
					|| (preg_match('/BioBirthDate/', $this->Fields[$j]) == 1))
				{
					continue;
				}
				if ($fieldData != '')
				{
					$fieldData = preg_replace('/\\r?\\n/', "<br />\n", $fieldData);
					if (preg_match('/SumTitle/', $this->Fields[$j]) == 1)
					{
						print "<i>$fieldData</i>";
					}
					else
					{
						print "$fieldData";
					}
					print "<br \>\n";
				}
			}
			print "<br \>\n";

			print "  <!--END RECORD-->\n";
			$rownum++;
		}
		print "<!--END OBJECT-->\n";
	}

} // end QagExhLabelResultsList class
?>
