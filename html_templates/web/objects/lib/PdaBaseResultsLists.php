<?php
/*
*  Copyright (c) 2001 - KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'BaseQueryGenerator.php');

/*
** This is low level base class.
** It provides pagination and query code for the results list
** 
** Extend this class and provide:
**	$this->Fields
**		Set the fields to display in the results list
**	$this->display()
**		Visually output code
*/

class
FormatField 
{
	var $Label = '';
	var $Format = '';
}

class
BaseResultsList extends BaseWebObject
{
	// Set Via GET/POST 
	var $QueryName;
	var $StartAt;
	var $QueryPage;
	var $LanguageType;
	
	// Functional 
	var $QueryGenerator 		= "BaseQueryGenerator";
	var $Database 			= "ecatalogue";
	var $DisplayPage 		= "";
	var $LimitPerPage 		= 10;
	var $Where 			= "";
	var $Restriction 		= "";
	var $NoResultsText 		= "";
	var $NoResultsTextFromFile 	= "";
	var $ShowLanguageNavigation	= 0;
	var $IsMultimediaModule		= 0;	// set this if the table is in multimedia module
	var $AdditionalTransferVariables = array();

	var $Fields = array(); 	// Override

	// Private
	var $records;
	var $_queryDone = 0;

	// Constructor
	function
	BaseResultsList ()
	{
		$this->BaseWebObject();
		// Set properties from the base class
		global $ALL_REQUEST;
		$this->DisplayPage	= $GLOBALS['PDA_DEFAULT_DISPLAY_PAGE'];
		$this->QueryName	= $ALL_REQUEST['QueryName'];
		$this->QueryPage	= $ALL_REQUEST['QueryPage'];
		$this->Where		= $ALL_REQUEST['Where'];
		$this->Restriction	= $ALL_REQUEST['Restriction'];

		// NOTE:  Any other query types are to be placed in a sub class

		if (isset($ALL_REQUEST['StartAt']) 
				&& $ALL_REQUEST['StartAt'] != '')
			$this->StartAt = $ALL_REQUEST['StartAt'];
		else
			$this->StartAt = 1;

		if (isset($ALL_REQUEST['LimitPerPage']))
		{
			if (preg_match('/\d+/', 
				$ALL_REQUEST['LimitPerPage'], $matches))
			{
				$this->LimitPerPage = $matches[0];
			}
		}
	}

	function
	printNavLinks()
	{
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
		$perams = array_merge($GLOBALS['HTTP_POST_VARS'], 
			$GLOBALS['HTTP_GET_VARS']);
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
	}

	function
	printBackLink()
	{
		if ($this->QueryPage != '')
		{
			$link = $this->QueryPage;
			print "&nbsp;<a href=\"$link\">";
			PPrint($this->_STRINGS['NEW SEARCH'], 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			print "</a>";
			PPrint(' | ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
		}
	}
	
	function
	displayNoResults()
	{
		if ($this->NoResultsText != "")
		{
			print $this->NoResultsText;
		}
		elseif ($this->NoResultsTextFromFile != "")
		{
			if (! file_exists($this->NoResultsTextFromFile))
			{
				WebDie("Can't open NoResultsTextFromFile: " . 
					$this->NoResultsTextFromFile,
					"BaseDisplayObject - displayNoResults");
			}
			require($this->NoResultsTextFromFile);
		}
		else
		{
			print "<center><h2>";
			PPrint($this->_STRINGS['NO RESULTS'], 
				$this->FontFace, '', 
				$this->TextColor);
			print"</h2>\n";
			print "<h3>";
			print '<a href="#" onclick="javascript:history.back()">';
			PPrint($this->_STRINGS['GO BACK'], 
				$this->FontFace, '', 
				$this->TextColor);
			print "</a>";
			print "</h3>\n";
			print "<br /></center>";
		}
	}

	function
	RedirectLink($page, $newLimit=0)
	{
		$getString = "$page?";
		$perams = array_merge($GLOBALS['HTTP_POST_VARS'], 
			$GLOBALS['HTTP_GET_VARS']);
		while(list($key, $val) = each($perams))
		{ 
			if ($key == "LimitPerPage" && $newLimit > 0)
			{
				$val = (string) ($newLimit);
			}
			// Don't pass through empty vars
			// try to keep url length down
			if ($val == '')
				continue;
			$key = urlencode(stripslashes($key)); 
			$val = urlencode(stripslashes($val)); 
			$getString .= "$key=$val&amp;"; 
		} 
		return($getString);
	}

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

	function
	displayPageLink($record)
	{
		// This private method generates the link for the display page 
		// for each record.  It $this->DisplayPage is a string, then it just
		// uses that page
		// If it's an associate array, it expects the following format.
		//	$this->DisplayPage = array(
		//			'ConditionField' => 'WebGroup',
		//			'Minsci'=> '/my/display/page2.php',
		//			'IZ' 	=> '/my/display/page.php',);
		//			'Default'=> '/my/display/default.php',);

		$displaylink = '';
		if (is_string($this->DisplayPage))
		{
			$displaylink = $this->DisplayPage;
		}
		elseif (is_array($this->DisplayPage))
		{
			if ($this->DisplayPage['ConditionField'] == '')
			{
				WebDie('Invalid DisplayPage property set (no ConditionField)', 'getDisplayPageLink');
			}
			else
				$field = $this->DisplayPage['ConditionField'];
				
			$displaylink = $this->DisplayPage[$record->{$field}];
			
			if ($displaylink == '')
				$displaylink = $this->DisplayPage['Default'];

			if ($displaylink == '')
				WebDie('Invalid DisplayPage property set', 'getDisplayPageLink');
		}
		else
		{
			WebDie('Invalid Display Page', 'getDisplayPageLink');
		}
		$displaylink .= '?irn=' . $record->irn_1;
		$displaylink .= "&amp;QueryPage=" . urlencode($this->QueryPage);
		foreach ($this->AdditionalTransferVariables as $k => $v)
		{
			$displaylink .= "&amp;" . urlencode($k) . "=" . urlencode($v);
		}
		return $displaylink;
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
		if (is_array($this->DisplayPage) && 
				$this->DisplayPage['ConditionField'] != '')
		{
			$select = array('irn', 
					  'MulMultiMediaRef_tab', 
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
				$select = array('irn', 'MulMultiMediaRef_tab');
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
			// Use reflection to call query method
			$where = $qryGenerator->{$this->QueryName}();
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
	}

	/*
	*  This method can be called prior to show to test if
	*  only a single match has been returned.  It allows for
	*  the possibility of a redirect direct to the display 
	*  page.  (See RedirectToFirstRecord)
	*/
	function
	HasSingleMatch()
	{
		$this->doQuery();
		return(count($this->records) == 1);
	}

	/*
	*  This method will redirect the user to the first record.
	*  It uses HTTP Location header redirect.
	*  Note:  This must be called before any page output (ie.
	*  in the header.
	*/
	function
	RedirectToFirstRecord()
	{
		$this->doQuery();
		// Redirect first record irn

		$displaypage = $this->displayPageLink(
					$this->records[0]
					);

		if(! (0 == strpos($displaypage, "http:")))
		{
			global $HTTP_HOST;
			$host = isset($HTTP_HOST) ? $HTTP_HOST 
					: $_SERVER['HTTP_HOST'];

			$self = isset($GLOBALS['PHP_SELF']) ? 
				$GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

			// test for relative or absolute path
			if (0 == strpos($displaypage, "/"))
			{
				$displaypage = "http://$host/$displaypage";
			}
			else
			{
				$displaypage = "http://$host" 
					. dirname($self)
					. "/" . $displaypage;
			}

		}
		header("Location: $displaypage");
	}

	function
	Show ()
	{
		$this->sourceStrings();

		if ($this->Where == '' && $this->QueryName == '')
		{
			WebDie('QueryName is not set', 
				'base_results_list - Show()');
		}

		// Query and display
		$this->doQuery();
		$test = count($this->records);

		if (count($this->records) < 1)
		{
			$this->displayNoResults();
		}
		else
		{
			$this->display();
		}
	}
} // end BaseResultsList class


/*
** This is an abstract base class.
** It provides GUI for the results list
** 
** Extend this class and provide:
**	$this->Fields
**		Set the fields to display in the results list
*/
class
BaseStandardResultsList extends BaseResultsList
{
	// Public (User Defined)
	var $DisplayThumbnails = 1;
	var $Width = '95%';
	var $FontFace = '';
	var $FontSize = '';
	var $TextColor = '';
	var $BodyColor = '';
	var $HeaderColor = '';
	var $HeaderTextColor = '';
	var $BorderColor = '';
	var $HighlightColor = '';
	var $HighlightTextColor = '';
	var $KeepImageAspectRatio = 0;
	var $AlignTitle = "center";
	var $AlignData = "left";

	function
	display()
	{
		$records =& $this->records;

		$widthAttrib = '';
		$backgroundColorAttrib = '';
		$highlightColorAttrib = '';
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
		if ($this->PdaContactSheetPage != '')
		{
			$this->printRedisplay($this->PdaContactSheetPage, 
				$this->_STRINGS["CONTACT_SHEET"]);
		}
		print "</td>";
		print "<td width=\"75%\" align=\"right\">\n";
		$this->printNavLinks();
		print "</td></tr>";
		print "<tr><td colspan=\"2\">\n";
		print "<table $borderColorAttrib width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\">\n";
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
				$image->Width = 55;
				$image->Height = 60;
				$image->KeepAspectRatio = $this->KeepImageAspectRatio;
				$image->RefIRN = $rec->{'irn_1'};
				$image->RefTable = $this->Database;
				$image->ShowBorder = "";
				$image->Show();
				print "    </td>\n";
			}

			// Display Other Fields

			for ($j = 0; $j < $numcol - 1; $j++)
			{
				print "    <td align = \"$this->AlignData\">";
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

			print "  </tr>\n<!--END RECORD-->\n";
			$rownum++;
		}

		//End Table
		print "</table>\n";
		print "</td></tr>";
		// Nav Links
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		$this->printBackLink();
		if ($this->PdaContactSheetPage != '')
		{
			PPrint(' ', 
				$this->FontFace, 
				$this->FontSize, 
				$this->TextColor);
			$this->printRedisplay($this->PdaContactSheetPage, $this->_STRINGS["CONTACT_SHEET"]);
		}
		print "</td>";
		print "<td width=\"75%\" align=\"right\">";
		$this->printNavLinks();
		print "</td></tr>";
		print "</table>\n";
		print "<!--END OBJECT-->\n";

	}

} // end BaseStandardResultsList class


/*
** This is an abstract base class.
** It provides GUI for the results list
** 
** Extend this class and provide:
**	$this->Fields
**		Set the fields to display
**		Keep to a maximum of 3
*/
class
BaseContactSheet extends BaseResultsList
{
	// Public (User Defined)
	var $Width = '80%';
	var $FontFace = '';
	var $FontSize = '1';
	var $SmallFontSize = '1';
	var $TextColor = '';
	var $BodyColor = '';
	var $BorderColor = '';
	var $HighlightColor = '';
	var $NumColumns = 1;
	var $LimitPerPage = 10;
	var $ThumbnailsLinkToFullView = 1;
	var $ResultsListPage = "";
	
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
					$image->Width = 110;
					$image->Height = 110;
					$image->KeepAspectRatio = 1;
					$image->RefIRN = $records[$recordnum]->{'irn_1'};
					$image->RefTable = $this->Database;
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

} // end BaseContactSheet class


?>