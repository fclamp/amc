<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
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
	var $RelevanceRanking;
	var $WarclipCounter;
	var $StartAt;
	var $QueryPage;
	var $LanguageType;
	
	// Functional 
	var $QueryGenerator 		= "BaseQueryGenerator";
	var $Database 			= "ecatalogue";
	var $RelevanceRank		= "";
	var $DisplayPage 		= "";
	var $LimitPerPage 		= 20;
	var $Where 			= "";
	var $Restriction 		= "";
	var $NoResultsText 		= "";
	var $NoResultsTextFromFile 	= "";
	var $ShowLanguageNavigation	= 0;
	var $IsMultimediaModule		= 0;	// set this if the table is in multimedia module

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
		$this->DisplayPage	= $GLOBALS['DEFAULT_DISPLAY_PAGE'];
		$this->QueryName	= $ALL_REQUEST['QueryName'];
		$this->QueryPage	= $ALL_REQUEST['QueryPage'];
		$this->RelevanceRanking = $ALL_REQUEST['RelevanceRanking'];
		$this->WarclipCounter 	= $ALL_REQUEST['WarclipCounter'];
		$this->Where		= $ALL_REQUEST['Where'];
		$this->Restriction	= $ALL_REQUEST['Restriction'];
		$this->lang		= $ALL_REQUEST['lang'];

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
				if ($key == 'lang' && $this->LangType == '0,1')
				{
					if ($val == '0'){$langval = 1;}
					if ($val == '1'){$langval = 0;}
					//$ShowLanguageNavigation = 1;
				}
				$getLangString .= "$key=$val&amp;";

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
		//if ($this->ShowLanguageNavigation && ($this->lang == 1 || $this->lang == 0))
		//if (($this->lang == 1 || $this->lang == 0))
		if ($this->LangType != '')
		{
			list($QueryName, $QueryPage, $RelevanceRank, $VarLang) = split ("[&&]",$getLangString);
			$getLangString = str_replace($VarLang, "lang=$langval", $getLangString);
			$langlink .= "$thisPage?$getLangString" .
				     'StartAt=' .
				      $this->StartAt;
			print "<div align=\"right\">";
			print "<p>";
			PPrint($this->_STRINGS['THIS PAGE IN'],
				$this->FontFace,
				$this->FontSize,
				$this->TextColor);
			PPrint('',
				$this->FontFace,
				$this->FontSize,
				$this->TextColor);
			print "&nbsp;<a href=\"$langlink\">";
			PPrint($this->_STRINGS['LANGUAGE'],
				$this->FontFace,
				$this->FontSize,
				$this->TextColor);
			print "</a>&nbsp";

			print "</div>";

		}
	}
	
	function
	printWarclipExcededLimit($records)
	{
		foreach ($records as $rec)
		{
			if ($rec->Total >= 1000)
			{
				print '<b>' . $this->_STRINGS['THOUSAND RETURNS'] . '</b><br>';
				print $this->_STRINGS['RETURN_MESSAGE_1'];
				print '<a class="seealso" href =' . $this->_STRINGS['QUERY_RETURN'] . '>';
				print $this->_STRINGS['RETURN_MESSAGE_2'];
				print '</a>' . $this->_STRINGS['RETURN_MESSAGE_3'] . '<br><br>';
				break;		
			}
		}
	}
	
	function
	printWarclipLinks($records)
	{
		
		print "<b>";
		foreach ($records as $rec)
                {
			if ($rec->Total > 1)
			{
                        	if ($rec->Total < $this->LimitPerPage)
                        	{
					$summary = sprintf($this->_STRINGS['RESULTS SUMMARY'], $this->StartAt, $rec->Total, $rec->Total);
        	                        print $summary;
					break;
                        	}
	                        else
        	                {
					$TopLimit = $this->StartAt + $this->LimitPerPage -1;
					if ($TopLimit <= $rec->Total)
					{
						$summary = sprintf($this->_STRINGS['RESULTS SUMMARY'], $this->StartAt, $TopLimit, $rec->Total);
						print $summary;
						print '<br>';
					}
					else
					{
						$summary = sprintf($this->_STRINGS['RESULTS SUMMARY'], $this->StartAt, $rec->Total, $rec->Total);
						print $summary;
						print '<br>';
					}				
	                                break;
        	                }
        	        }
		}
		print "</b>";
		
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
				if ($key == 'lang' && $this->LangType == '0,1')
				{
					if ($val == '0'){$langval = 1;}
					if ($val == '1'){$langval = 0;}
					//$ShowLanguageNavigation = 1;
				}
				$getLangString .= "$key=$val&amp;";

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
			if ($this->lang != '' && $this->LangType == '0,1')
			{
				list($querypage, $lang, $langval) = split ("[?=]", $this->QueryPage);
				if ($this->lang == 1)
				{
					$querypage = str_replace ("Query.php", "QueryF.php", $querypage);
					$link = $querypage . 
						"?lang=" .
						$this->lang;
				}
				if ($this->lang == 0)
				{
					$querypage = str_replace ("QueryF.php", "Query.php", $querypage);
					$link = $querypage . 
						"?lang=" .
						$this->lang;
				}
			}
			else
			{
				$link = $this->QueryPage;
			}
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
	displayWarclipNoResults()
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
			print "<left><p><strong>";
			print $this->_STRINGS['NO RESULTS'];
			print "</strong><br><br>";
			print $this->_STRINGS['NO RESULTS 2'];
			print "<ul><li>";
			print $this->_STRINGS['NO RESULTS 3'];
			print "</li><li>";
			print $this->_STRINGS['NO RESULTS 4'];
			print "</li><li>";
			print $this->_STRINGS['NO RESULTS 5'];
			print "</li></ul><br>";
			print $this->_STRINGS['NO RESULTS 6'];
			print"</p>";
			print "<br /></left>";
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
	printRedisplay($page, $linktext, $newLimit=0)
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
		$displaylink .= "&amp;lang=" . $this->lang;
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
				$select = array('0 as Total', 'irn_1 as irn', 'MulMultiMediaRef_tab');
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

		if ($this->RelevanceRanking != '')
		{
			$qryGenerator = new $this->QueryGenerator;
			$qryGenerator->Database = $this->Database;
			$rank = $qryGenerator->{$this->RelevanceRanking}();
		}
		
		if ($this->WarclipCounter != '')
		{
			$qryGenerator = new $this->QueryGenerator;
			$counter = $qryGenerator->{$this->WarclipCounter}();	
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
		$qry->Order = $this->Order;
		$qry->RelevanceRank = $rank;
		$qry->WarclipCounter = $counter;
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
		print "<table $widthAttrib $backgroundColorAttrib border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
		print "<tr><td colspan = \"2\"><h1>";
		print $this->_STRINGS['RESULT_TITLE'];
		print "</h1></td></tr>";
		print "<tr><td width=\"25%\" align=\"left\" nowrap=\"nowrap\">";
		print "</td>";
		print "<td width=\"75%\" align=\"right\">\n";
		$this->printWarclipExcededLimit($records);
		$this->printWarclipLinks($records);
		print "</td></tr>";
		print "<tr><td colspan=\"2\">\n";
		// Loop over the results
		$rownum = 1;
		$i = 0;
		$count = 0;
		foreach ($records as $rec)
		{
			if ($count == 0)
			{
				$count = 1;
				if ($rec->Total == 0)
                        	{
                                	$this->displayWarclipNoResults();
                                	break;
                        	}
			}
			else
			{
			if ($rownum > $this->LimitPerPage)
				break;

			print "<!--START RECORD-->";
			
			$displaylink = $this->displayPageLink($rec);

/* Display the results of the search in a custom format for warclip only */

			print "<tr><td colspan = \"2\">";
			print '<p><A TARGET = BLANK HRef = "../../objects/common/webmedia.php?irn=' . $rec->MMirn . '"><b>';
			print $rec->WarHeadline;
			print '</b></p></A></td></tr>';
				
			if ($rec->WarSourceNewspaperSummData != "")
			{
				print '<tr><td colspan = "2">';
				print $rec->WarSourceNewspaperSummData;
				if ($rec->DatManufacture != "")
				{
					print ', ' . $rec->DatManufacture;
					
				}
			}
			print '</td></tr><tr><td valign = top><b>' . $this->_STRINGS['SUBJECT'] . ' :</b></td><td>';
			if ($rec->SumSubHeading1 != "")
			{
				print $rec->SumSubHeading1;
				print "<br>";
			}
			if ($rec->SumSubHeading2 != "")
			{ 
                               	print $rec->SumSubHeading2;
				print "<br>";
                        }
			if ($rec->SumSubHeading3 != "")
			{
                                print $rec->SumSubHeading3;
				print "<br>";
			}
			if ($rec->SumSubHeading4 != "")
			{
                              	print $rec->SumSubHeading4;
				print "<br>";
                        }
			if ($rec->SumSubHeading5 != "")
			{
                              	print $rec->SumSubHeading5;
				print "<br>";
			}
			print '</td></tr><tr><td><b>' . $this->_STRINGS['CATEGORY'] . ' :</b>';
			print '</td><td>';
			print $rec->ObjTitle;
			print '</td></tr>';
			print '<tr><td colspan = 2>';
			print '<p><A TARGET = "blank" HREF = ';
			print $WEB_ROOT;
			print '"/warclip/objects/common/webmedia.php?irn=' . $rec->MMirn . '">http://collections.civilisations.ca/warclip/objects/common/webmedia.php?irn=' . $rec->MMirn . '</A></p>';
			print '</td></tr><tr><td colspan =2><hr></td></tr>';	
			$i++;
			print "  <!--END RECORD-->\n";
			$rownum++;
			}
		}

		//End Table
		print "</table>\n";
		print "</td></tr>";
		// Nav Links
		print "<tr><td colspan = \"2\" align=\"right\">";
		$this->printWarclipLinks($records);
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
	var $FontSize = '2';
	var $SmallFontSize = '1';
	var $TextColor = '';
	var $BodyColor = '';
	var $BorderColor = '';
	var $HighlightColor = '';
	var $NumColumns = 5;
	var $LimitPerPage = 20;
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
