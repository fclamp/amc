<?php
/*
*  Copyright (c) KE Software Pty Ltd - 2003
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
AmStandardResultsList extends BaseStandardResultsList
{
	function
	AmStandardResultsList()
	{
		$this->BaseStandardResultsList();
		$this->Fields = array('irn_1', 'SummaryData');
		$this->Database = 'ecatalogue';
	}
}


class
AmContactSheet extends BaseContactSheet
{
	function
	AmContactSheet()
	{

		$this->BaseContactSheet();
		$this->Fields = array('irn_1','SummaryData');
		$this->Database = 'ecatalogue';
	}
} 


?>
