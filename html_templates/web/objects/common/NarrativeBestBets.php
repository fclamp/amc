<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once($LIB_DIR . 'BaseQueryGenerator.php');

/*
* Inheriate from BaseResultsList
*/

class NarrativeBestBets extends BaseWebObject
{
	var $Database = "enarratives";
	var $QueryGenerator = "BaseQueryGenerator";

	var $LimitPerPage = 5;
	var $FontFace;
	var $FontSize;
	var $TextColor;
	var $HighlightTextColor;
	var $TitleFontFace;
	var $TitleFontSize;
	var $TitleTextColor;
	var $Width = "";
	var $Restriction = "";

	var $TitleText	= "Best Bets:";

	var $_querydone = 0;
	var $_records = array();
	
	// Constructor
	function
	NarrativeBestBets()
	{
		$this->BaseWebObject();
	}

	function
	CheckForNarrativeMatches()
	{
		$this->doQuery();
	}

	function
	HasMatches()
	{
		$this->doQuery();
		return (count($this->_records) > 0);

	}

	function
	NumberOfMatches()
	{
		$this->doQuery();
		return (count($this->_records));
	}

	function
	ShowNarrativeTitle($n)
	{
		if (! $this->_querydone)
			WebDie("Must call the CheckForNarrativeMatches first");
		print $this->_records[$n]->{"NarTitle"};
	}

	function
	ShowNarrativeSummary($n, $charCount=80)
	{
		if (! $this->_querydone)
			WebDie("Must call the CheckForNarrativeMatches first");
		// walk through the narrative grabbing first x chars
		$s = substr($this->_records[$n]->{"NarNarrative"}, 
					0, $charCount);

		// bold keyword matches if found in entry
		global $ALL_REQUEST;
		$keyword = $ALL_REQUEST['KeyWords'];
		$s = preg_replace("/($keyword)/i", "<b>\\1</b>", $s);
		print $s;
		print " ...";
	}

	function
	PrintDisplayPageLink($n)
	{
		print $this->DisplayPageLink($n);
	}

	function
	DisplayPageLink($n)
	{
		return $this->makeDisplayPageLink($this->_records[$n]);
	}
	

	/*
	** Display with default style
	*/
	function
	Show()
	{
		$this->sourceStrings();
		$this->TitleText = $this->_STRINGS['BEST BETS'];
		$this->display();
	}

	function
	doQuery()
	{
		if ($this->_querydone)
			return;
		$this->_querydone = 1;
			
		global $ALL_REQUEST;
		$where = "";
		$results = array();

		if ($ALL_REQUEST['QueryName'] == "BasicQuery")
		{
			// extract keywords from QueryTerms fields
			$ALL_REQUEST['KeyWords'] = $ALL_REQUEST['QueryTerms'];
		}

		if (! isset($ALL_REQUEST['KeyWords']) 
			|| $ALL_REQUEST['KeyWords'] == "")
		{
			return(array());
		}

		$qryGenerator = new $this->QueryGenerator;
		$qryAttrib = $qryGenerator->KeyWord();
		$where = $qryAttrib->Where;

		if (!empty($this->Restriction))
			$where = "(" . $where . ") AND (" . $this->Restriction . ")";

		$qry = new ConfiguredQuery;
		$qry->SelectedLanguage = $this->LanguageData;
		$qry->Intranet = $this->Intranet;
		$qry->Select = array("NarTitle", "NarNarrative" ,"irn");
		$qry->From = $this->Database;
		$qry->Where = $where;
		$qry->Limit = $this->LimitPerPage + 1;	
		$qry->Offset = 1;

		$this->_records = $qry->Fetch();
	}

	function
	makeDisplayPageLink($record)
	{
		$displaylink = $this->NarrativeDisplayPage;
		$displaylink .= '?irn=' . $record->{"irn_1"};
		$displaylink .= "&amp;QueryPage=" . urlencode($this->QueryPage);
		$displaylink .= "&amp;lang=" . $this->lang;
		return $displaylink;
	}
		

	function
	display()
	{
		$this->doQuery();

		$records =& $this->_records;

		if (count($records) > 0)
		{

			print "<!-- Start NarraitiveBestBets Web Object -->\n";
			$width = ($this->Width == "") ? "" : "width=\"" . $this->Width . "\"";
			print "<table cellpadding=\"1\" cellspacing=\"1\" border=\"0\" $width>\n";
			print "<tr><td colspan=\"2\"><b>";
			PPrint($this->TitleText, 
				$this->TitleFontFace, 
				$this->TitleFontSize,
				$this->TitleTextColor);
			print "</b></td></tr>\n";
			for ($i = 0; $i < count($records); $i++)
			{
				$r = $records[$i];
				print "<tr>\n";
				print "<td width=\"30\">&nbsp;</td>";
				print "<td>";
				$fieldData = $r->{'NarTitle'};

				$displaylink = $this->makeDisplayPageLink($r);
				if ($i < $this->LimitPerPage - 2)
				{
					print "<a href=\"$displaylink\">";
					PPrint($fieldData, 
						$this->FontFace, 
						$this->FontSize,
						$this->TextColor, 
						$this->HighlightTextColor);
					print '</a>';
				}
				else
				{
					global $ALL_REQUEST;
					$link = $this->NarrativeResultsList;
					$link .= "?Keywords=";
					$link .= urlencode($ALL_REQUEST['Keywords']);
					$link .= "QueryPage=";
					$link .= urlencode($ALL_REQUEST['QueryPage']);
					print "<a href=\"$link\">";
					PPrint($this->_STRINGS['MORE'], 
						$this->FontFace, 
						$this->FontSize,
						$this->TextColor, 
						$this->HighlightTextColor);
					print '</a>';
				}
				print "</td></tr>\n";
			}
			print "</table>\n";
			print "<!-- End NarraitiveBestBets Web Object -->\n";
		}
	}
}

// Test Code
/*
$o = new NarrativeBestBets;
$o->FontFace = "Arial";
$o->FontSize = "2";
$o->TextColor = "#ff00ff";
$o->HighlightTextColor = "#ffff00";
$o->Show();
*/
?>
