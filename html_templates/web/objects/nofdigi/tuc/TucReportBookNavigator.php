<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once($LIB_DIR . 'texquery.php');

/*
** This object provides a Book navigation
** Use:
*/

class
BookNavigator extends BaseWebObject
{
	// Set via GET/POST
	var $Book ;
	var $Page ;

	// Set via Query page/link properties - or default to:
	var $Database                   = "ecatalogue";
	var $LimitPerPage               = 1;
	var $BookTitleColumn		= "Dc1Title";
	var $BookPageLimitColumn	= "NofNumberOfParts";
	var $BookCurrentPageColumn	= "NofPartNumber";
	
	// Set locations for arrow images
	var $firstArrowLoc;
	var $backarrowloc;
	var $nextarrowloc;
	var $lastarrowloc;

	
	// Set variable to hold maximum no of pages (brought back in same query as irn)
	var $_maxpages;


	function
	BookNavigator()
	{
		//check that a book and page number are set
		//default page to one
		$this->Page = 1;

		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['Book']))
		{
			$this->Book = $ALL_REQUEST['Book'];
		}
		if (isset($ALL_REQUEST['Page']))
		{
			$this->Page = $ALL_REQUEST['Page'];
		}
		else
		{
			$this->Book = 1;
		}
		//Set default values within function	
		$this->FirstArrowLoc = $GLOBALS['IMAGE_DIR'] . 'firstarrow.gif';
		$this->BackArrowLoc = $GLOBALS['IMAGE_DIR'] . 'backarrow.gif';
		$this->NextArrowLoc = $GLOBALS['IMAGE_DIR'] . 'nextarrow.gif';
		$this->LastArrowLoc = $GLOBALS['IMAGE_DIR'] . 'lastarrow.gif';


		$this->BaseWebObject();
	}
		
	function 
	PageIRN()
	{
		
		
		if ($this->Book != "" || $this->Page != "") 
		{
			// select irn from catalogue were Title contains 'bookname' and PageNo = 1;

			$where = $this->BookTitleColumn; 
			$where .= " = '";
			$where .= $this->Book; 
			$where .= "' AND ";
			$where .= $this->BookCurrentPageColumn;
			$where .= " = ";
			$where .= $this->Page;
			
			

			// add debugging for later if required
			if ($GLOBALS['DEBUG'])
			{
				print $where;
			}
			

			// use Query in texquery.php
			$newquery = new Query;
			$newquery->Select = array("irn", $this->BookPageLimitColumn);
			$newquery->From = $this->Database;
			$newquery->Where = $where;
			$newquery->Limit = 1;
			$result = $newquery->Fetch();
			$irn = $result[0]->{"irn_1"};
			$a = $this->BookPageLimitColumn;
			$this->_maxpages = $result[0]->{$this->BookPageLimitColumn};
			if (! isset($irn) || ! is_numeric($irn))
			{
				WebDie('No matching book');
			}
		}
		else
		{
			WebDie('The Book Title needs to be set on the URL');
		}
		return $irn;
	}

	function Show()
	{	


		// go to page section

// this section is available in common/BookNavigatorFull.php

		// print 1 of 34 pages

		$locationstring  = "Page ";
		$locationstring .= $this->Page;
		$locationstring .= " of ";
		$locationstring .= $this->_maxpages;
		
		// work out what arrows to display - done above
	
		
		// construct links for arrows - I would like to declare a display pg variable so user can define
		 $self = isset($GLOBALS['PHP_SELF'])
		 		? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

		$bookname = urlencode($this->Book);

		$firstarrownav = "<a href=\"" . $self . "?Page=1&Book=$bookname\"> <img src ='/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/firstarrow.gif' border=\"0\" alt=\"First\"/></a>";
		$lastarrownav = "<a href=\"" . $self . "?Page=". $this->_maxpages . "&Book=$bookname\"> <img src ='/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/lastarrow.gif' border=\"0\" alt=\"Last\"/></a>";

		if ($this->Page == $this->_maxpages)
			
		{
		$nextarrownav = "<a href=\"" . $self . "?Page=" . ($this->Page) . "&Book=$bookname\"> <img src ='/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/nextarrow.gif' border=\"0\" alt=\"Next\"/></a>";
		}
		else
		{
		$nextarrownav = "<a href=\"" . $self . "?Page=" . ($this->Page+1) . "&Book=$bookname\"> <img src ='/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/nextarrow.gif' border=\"0\" alt=\"Next\"/></a>";
		}
		
		
		if ($this->Page == 1)
		{
		$prevarrownav = "<a href=\"" . $self . "?Page=" . ($this->Page) . "&Book=$bookname\"> <img src ='/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/backarrow.gif' border=\"0\" alt=\"Previous\"/></a>";
		}
		else
		{
		$prevarrownav = "<a href=\"" . $self . "?Page=" . ($this->Page-1) . "&Book=$bookname\"> <img src ='/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images/backarrow.gif' border=\"0\" alt=\"Previous\" /></a>";
		}
		// print all of it out in a nice format
		print "<table>
			<tr><td>" . 
			$firstarrownav . 
			"</td><td>" . 
			$prevarrownav . 
			"</td><td>" . 
			$locationstring . 
			"</td><td>" .
			$nextarrownav . 
			"</td><td>" . 
			$lastarrownav . 
			
			"</td></tr></table>";

		
	}
}

	
?>
