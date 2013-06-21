<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');

/*
*  Make a link/href url that returns a random set of records
*/
class RandomQuery extends BaseWebObject
{
	var $LowerIRN		= 1;
	var $UpperIRN 		= 1000;
	var $LimitPerPage 	= 20;
	var $LinkText 		= 'Click Here For A Random Item';
	var $Restriction 	= ''; // eg: "TitObjectType = 'Art Search'"

	// Not Yet Implimented (need to put in QueryGenerator object)
	var $ImagesOnly 	= 0;

	// Depricated
	var $MaxNumberToReturn;

	function
	generateRef()
	{
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

		$page = urlencode($self);
		$getString = "QueryName=RandomQuery";
		$getString .= "&amp;upper={$this->UpperIRN}";
		$getString .= "&amp;lower={$this->LowerIRN}";
		$getString .= "&amp;LimitPerPage={$this->LimitPerPage}";
		$getString .= "&amp;QueryPage=$page";
		
		if ($this->Restriction != '')
		{
                        $this->Restriction = preg_replace('/\\r?\\n/', 
                                                ' ', $this->Restriction);
                        $this->Restriction = preg_replace('/\\t/',
                                                ' ', $this->Restriction);
                        $this->Restriction = preg_replace('/\\s\\s+/',
                                                ' ', $this->Restriction);
                        $restriction = urlencode($this->Restriction); 
                        $getString .= 
                                "&amp;restriction=$restriction"; 
		}

		// TODO - Add code to handle here and in QueryGenerator.php
		if ($this->ImagesOnly == 1)
		{
			WebDie("ImagesOnly - No Yet Implimented", 
				"Random Query");
		}
		return ($this->ResultsListPage . "?$getString");
	}

	function
	PrintRef()
	{
		print $this->generateRef();
	}

	function
	Show()
	{
		print '<a href="' .  $this->generateRef() . '">' 
			. $this->LinkText . '</a>';
	}
}

/* TEST
$qry = new RandomQuery();
$qry->UpperIRN = 1000;
$qry->LowerIRN = 10;
$qry->MaxNumberToReturn = 9;
$qry->LimitPerPage 	= 2;
$qry->Show();
*/
?>
