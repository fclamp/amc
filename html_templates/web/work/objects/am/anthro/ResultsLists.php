<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/*
Created By: Martin Jujou
Date: 23/9/2003
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
		$this->Fields = array('SummaryData');
		$this->Database = 'enarratives';
	}
}

class
AmObjectResultsList extends BaseStandardResultsList
{
	function
	AmObjectResultsList()
	{
		$this->BaseStandardResultsList();
		$this->Fields = array('SumRegNum', 'SumItemName', 
		'ProRegion', 'AcqRegDate');
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
		$this->Fields = array('SummaryData');
		$this->Database = 'enarratives';
	}
} 


class
AmObjectContactSheet extends BaseContactSheet
{
	function
	AmObjectContactSheet()
	{
		$this->BaseContactSheet();
		$this->Fields = array('SumRegNum', 'SumItemName', 
		'ProRegion', 'AcqRegDate');
		$this->Database = 'ecatalogue';
	}
} 


?>
