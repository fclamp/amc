<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

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
	var $Book;
	var $Page;
	var $IRN;

	// Set via Query page/link properties - or default to:
	var $Database                   = "ecatalogue";
	var $LimitPerPage               = 1;
	var $BookTitleColumn		= "Dc1Title";
	var $BookPageLimitColumn	= "NofNumberOfParts";
	var $BookCurrentPageColumn	= "NofPartNumber";

	// Set locations for arrow images
	var $FirstArrowLoc;
	var $BackArrowLoc;
	var $NextArrowLoc;
	var $LastArrowLoc;
	
	// Set location for 'Go' image
	var $GoImageLoc;
	
	// Set variable to hold maximum no of pages (brought back in same query as irn)
	var $_maxpages;

	// Only Result of only query nessecary - returned by $this->getResult()
	var $_Result;

	function
	BookNavigator()
	{
		//check that a book and page number are set
		//default page to one
		$this->Page = 1;

		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['irn']))
		{
			$this->IRN = $ALL_REQUEST['irn'];
		}
		else
		{	
			if (isset($ALL_REQUEST['book']))
			{
				$this->Book = $ALL_REQUEST['book'];
			}
			if (isset($ALL_REQUEST['page']))
			{
				$this->Page = $ALL_REQUEST['page'];
			}
			else
			{
				$this->Book = 1;
			}
		}
		//Set default values within function	
		$this->FirstArrowLoc = $GLOBALS['WEB_DIR_NAME'] . '/objects/images/firstarrow.gif';
		$this->BackArrowLoc = $GLOBALS['WEB_DIR_NAME'] . '/objects/images/backarrow.gif';
		$this->NextArrowLoc = $GLOBALS['WEB_DIR_NAME'] . '/objects/images/nextarrow.gif';
		$this->LastArrowLoc = $GLOBALS['WEB_DIR_NAME'] . '/objects/images/lastarrow.gif';
		$this->GoImageLoc = $GLOBALS['WEB_DIR_NAME'] . '/objects/images/btn_search_go2.gif';

		$this->BaseWebObject();
	}

	function
	getResult()
	{
		if (!empty($this->_Result))
			return $this->_Result;
		
		if (!empty($this->IRN))
		{
			$where = "irn = " . $this->IRN;
		}
		elseif (!empty($this->Book) && !empty($this->Page))
		{
			if (empty($this->BookTitleColumn) || empty($this->BookCurrentPageColumn))
				WebDie('The columns for BookTitle and PageNumber must be set in BookNavigator!');
				
			$where = $this->BookTitleColumn; 
			$where .= " = '";
			$where .= $this->Book; 
			$where .= "' AND ";
			$where .= $this->BookCurrentPageColumn;
			$where .= " = ";
			$where .= $this->Page;			
		}
		else
		{
			WebDie('The step you have selected is invalid', 'Either IRN, or Book and Page must be set for BookNavigator');
		}
		
		// add debugging for later if required
		if ($GLOBALS['DEBUG'])
		{
			print "WHERE: $where";
		}	
		
		$newquery = new Query;
		$newquery->Select = array("irn", 
					$this->BookPageLimitColumn,
					$this->BookTitleColumn,
					$this->BookCurrentPageColumn);
		$newquery->From = $this->Database;
		$newquery->Where = $where;
		$newquery->Limit = 1;
		$result = $newquery->Fetch();
		$irn = $result[0]->{"irn_1"};
		$this->_maxpages = $result[0]->{$this->BookPageLimitColumn};
		if (! isset($irn) || ! is_numeric($irn))
		{
			if (empty($this->Book))
			{
				WebDie('No matching book', 'Book is empty');
			}
			
			$this->Page = 1;
			
			$where = $this->BookTitleColumn; 
			$where .= " = '";
			$where .= $this->Book; 
			$where .= "' AND ";
			$where .= $this->BookCurrentPageColumn;
			$where .= " = ";
			$where .= $this->Page;

			$backupquery = new Query;
			$backupquery->Select = array("irn", 
					$this->BookPageLimitColumn,
					$this->BookTitleColumn,
					$this->BookCurrentPageColumn);
			$backupquery->From = $this->Database;
			$backupquery->Where = $where;
			$backupquery->Limit = 1;
			$result = $backupquery->Fetch();
			$irn = $result[0]->{"irn_1"};
			$this->_maxpages = $result[0]->{$this->BookPageLimitColumn};
			if (! isset($irn) || ! is_numeric($irn))
			{
				WebDie('No matching book', 'Book not found');
			}
				
		}
		if (!empty($this->IRN))
		{
			$this->Book = $result[0]->{$this->BookTitleColumn};
			$this->Page = $result[0]->{$this->BookCurrentPageColumn};
		}

		$this->_Result = $result[0];
		
		return $this->_Result;
	}
			
	function 
	PageIRN()
	{
		$result = $this->getResult();
		
		return $result->{"irn_1"};
	}

	function
	IsBook()
	{
		$result = $this->getResult();

		if ( $result->{$this->BookPageLimitColumn} > 1 
				&& !empty($result->{$this->BookCurrentPageColumn}) )
			return 1;
		else
			return 0;
	}

	function
	ShowNav()
	{	
		$this->sourceStrings();

		$locationstring = preg_replace("/\{PAGE NO\}/", $this->Page, $this->_STRINGS['PAGE TEXT']);
		$locationstring = preg_replace("/\{NUM PAGES\}/", $this->_maxpages, $locationstring);
				
		$self = WebSelf();
		$urlparams = GetCurrentUrlParams();
		$urlstring = '';
		foreach ($urlparams as $key => $val)
		{
			if (strtolower($key) == 'page' 
					|| strtolower($key) == 'book' 
					|| strtolower($key) == 'irn')
			{
				continue;
			}
			$urlstring .= "&" . $key . "=" . $val;
		}
		$bookname = urlencode($this->Book);

		$firstarrownav = "<a href=\"" . $self . "?page=1&book=$bookname$urlstring\"> <img src =\"/" . $this->FirstArrowLoc . "\" border=\"0\" /></a>";
		$lastarrownav = "<a href=\"" . $self . "?page=". $this->_maxpages . "&book=$bookname$urlstring\"> <img src =\"/" . $this->LastArrowLoc . "\" border=\"0\" /></a>";

		if ($this->Page == $this->_maxpages)
		{
			$nextarrownav = "<a href=\"" . $self . "?page=" . ($this->Page) . "&book=$bookname$urlstring\"> <img src =\"/" . $this->NextArrowLoc . "\" border=\"0\" /></a>";
		}
		else
		{
			$nextarrownav = "<a href=\"" . $self . "?page=" . ($this->Page+1) . "&book=$bookname$urlstring\"> <img src =\"/" . $this->NextArrowLoc . "\" border=\"0\" /></a>";
		}
		
		if ($this->Page == 1)
		{
			$prevarrownav = "<a href=\"" . $self . "?page=" . ($this->Page) . "&book=$bookname$urlstring\"> <img src =\"/" . $this->BackArrowLoc . "\" border=\"0\" /></a>";
		}
		else
		{
			$prevarrownav = "<a href=\"" . $self . "?page=" . ($this->Page-1) . "&book=$bookname$urlstring\"> <img src =\"/" . $this->BackArrowLoc . "\" border=\"0\" /></a>";
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

	function
	ShowPageBox()
	{
		print '<form name="pagesearch" method="post" action="' . WebSelf() . "\">\n";
		
		$urlParams = GetCurrentUrlParams();
		foreach ($urlParams as $key => $val)
		{
			if (strtolower($key) == 'page')
				continue;
			print "\t<input type=\"hidden\" name=\"$key\" value=\"$val\" />\n";
		}

		print '<table border="0" cellspacing="0" cellpadding="0">' . "\n";
                print "\t<tr>\n";
                print "\t\t<td>" . $this->_STRINGS['GO TO PAGE'] . "&nbsp;</td>\n";
                print "\t\t<td><input type=\"text\" size=\"3\" name=\"page\" /></td>\n";
		print "\t\t<td>&nbsp;<a class=\"breadcrumb\" href=\"javascript: document.pagesearch.submit();\">Go</a></td>\n";
                print "\t\t<td><input type=\"image\" src=\"" . $this->GoImageLoc . "\" name=\"submit\" alt=\"Search for page\" value=\"submit\" /></td>\n";
		print "\t</tr>\n</table>\n</form>\n";
	}		
}

	
?>
