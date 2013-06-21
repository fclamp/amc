<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*
*  Chris Dance - 28 Feb 2003
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once($LIB_DIR . 'BaseResultsList2.php');

/*
*  The ResultsListExtractor allows full control over the look of a results list.
*	PHP code (and experience) is required to use.  It's similare to the
*	RecordExtractor.
*
*  The BaseResultsList2 class contains most of the fuctionality we require.
*  	Override this class and provide some additional helper methods
*  
*
*  Important Properties:
*	$object->Database   	(defaults to ecatalogue)
*	$object->DisplayPage   	(set this to control navigation to display page)
*	$object->LimitPerPage 	(override the number of records to return)
*
*  Full Method List:
*
*	HitCount()	
*		- total number of matching records
*
*	RecordCount()	
*		- number of records enumberate in your results list loop
*
*	HasMatches()	
*		- did the query return any results
*
*	LowerRecordNumber()	
*		- record number of first record displayed on this page
*
*	UpperRecordNumber()	
*		- record of last record displyed on this page
*
*	HasMoreMatchesBackward()	
*		- test to see if a Back link is required
*
*	HasMoreMatchesForward()		
*		- test to see if a Next link is required
*
*	ExtractFields(array("field", ...)); 
*		- extract list of fields for use in the results list.
*
*	PrintField($fieldname, $num)	
*		- print a field extracted in the ExtractFields call.  
*
*		  $num is the current record in the list.
*	PrintField($fieldname, $num)	
*		- like PrintField, except the text is marked up as a 
*		  hyper-link to the record's detailed display page
*
*	PrintThumbnail($num)
*		- print the thumbnail associated with the record $num.
*
*	PrintNextURL()
*		- print the url the the next page.
*
*	PrintBackURL()
*		- print the url the the previous page.
*
*	NextUrl()	
*		- return url to next pagination of results list.
*
*	BackUrl()	
*		- return url to previous page of results
*
*	HasSingleMatch()
*		- test to see if only one record matched the given query
*
*	RedirectToFirstRecord()
*		- redirect to the first record.  Must be called before any
*		  screen output.  Use in conjunction with HasSingleMatch.
*
*/

class
ResultsListExtractor extends BaseResultsList2
{

	var $DisplayPage;

	function
	ExtractFields($fields)
	{
		$this->Fields = $fields;
		$this->doQuery();
	}

	function
	FieldAsValue($field, $num)
	{
		return $this->records[$num]->{"$field"};
	}

	function
	PrintField($field, $num)
	{
		print $this->FieldAsValue($field, $num);
	}

	function
	PrintLinkedField($field, $num, $additionalURLParms="")
	{
		$link = $this->DisplayPageLink($num);
		if ($additionalURLParms != "")
		{
			$link .= "&amp;" . $additionalURLParms;
		}
		print "<a href=\"$link\">";
		print $this->FieldAsValue($field, $num);
		print "</a>";
	}

	function
	PrintThumbnail($num, $width=60, $height=60, $keepaspectratio=1, $link="", $showborder=1, $newwindow=0, $cssdimensions=0)
	{
		$image = new MediaImage;
		$image->ShowBorder = $showborder;
		$image->Intranet = $this->Intranet;
		$image->IRN = $this->records[$num]->{'MulMultiMediaRef:1'};
		$image->Width = $width;
		$image->Height = $height;
		$image->Link = $link;
		$image->KeepAspectRatio = $keepaspectratio;
		$image->RefIRN = $this->records[$num]->{'irn_1'};
		$image->RefTable = $this->Database;
		$image->NewWindow = $newwindow;
		$image->StyleSize = $cssdimensions;
		$image->Show();
	}

	function
	PrintLinkedThumbnail($num, $width=60, $height=60, $keepaspectratio=0, $additionalURLParms="", $showborder=1, $newwindow=0, $cssdimensions=0)
	{
		$link = $this->DisplayPageLink($num);
		if ($additionalURLParms != "")
		{
			$link .= "&amp;" . $additionalURLParms;
		}
		$this->PrintThumbnail($num, $width, $height, $keepaspectratio, $link, $showborder, $newwindow, $cssdimensions);
	}

	function
	PrintNextURL()
	{
		print ($this->NextUrl());
	}

	function
	PrintBackURL()
	{
		print ($this->BackUrl());
	}

	function
	HasSingleMatch()
	{
		return($this->RecordCount() == 1);
	}

	function
	RedirectToFirstRecord()
	{
		// TODO: This should be shared with other pages

		$link = $this->DisplayPageLink(0);

		if(! (0 == strpos($link, "http:")))
		{
			global $HTTP_HOST;
			$host = isset($HTTP_HOST) ? $HTTP_HOST 
					: $_SERVER['HTTP_HOST'];

			$self = isset($GLOBALS['PHP_SELF']) ? 
				$GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

			// test for relative or absolute path
			if (0 == strpos($link, "/"))
			{
				$link = "http://$host/$link";
			}
			else
			{
				$link = "http://$host" 
					. dirname($self)
					. "/" . $link;
			}

		}
		header("Location: $link");
	}

	function
	DisplayPageLink($num)
	{
		//TODO:  This should be shared with other results lists
		$link = $this->DisplayPage;

		$link .= '?irn=' . $this->records[$num]->irn_1;
		if ($this->QueryPage != "")
		{
			$link .= "&amp;QueryPage=";
			$link .= urlencode($this->QueryPage);
		}
		return $link;
	}

}


/*
// Test Code Only

$r = new ResultsListExtractor;
$r->Where = "SummaryData contains 'testing'";
$r->ExtractFields(array(
			"Dc1Title",
			"Dc1CreatorLocal:1",
			"Dc2DateCreated",
			));
if (! $r->HasMatches())
{
	print "No Matches Found";
}
else
{

	print "</p>";
	if ($r->HasMoreMatchesBackward())
	{
		print "<a href=\"";
		print $r->BackUrl();
		print "\">Back</a>";
	}
	print " | ";
	if ($r->HasMoreMatchesForward())
	{
		print "<a href=\"";
		print $r->NextUrl();
		print "\">Next</a>";
	}
	print "</p>";

	print "<p>";
	print $r->LowerRecordNumber();
	print " to ";
	print $r->UpperRecordNumber();
	print " of ";
	print $r->HitCount();
	print "</p>";

	for($i = 0; $i < $r->RecordCount(); $i++)
	{
		$r->PrintThumbnail($i);
		$r->PrintLinkedField("Dc1CreatorLocal:1", $i);
		print "&nbsp;";
		$r->PrintField("Dc1Title", $i);
		print "&nbsp;";
		$r->PrintField("Dc2DateCreated", $i);
		print "<br />";
	}
}
*/

?>
