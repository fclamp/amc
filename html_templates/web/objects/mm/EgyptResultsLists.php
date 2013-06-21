<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
MmStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'ColAccessionNumber',
				'DesPhysicalDescription',
				);	

} // end MmResultsList class

class
MmContactSheet extends BaseContactSheet
{
	var $Fields = array(	'SummaryData',
				);	

} // end MmContactSheetResultsList class


?>
