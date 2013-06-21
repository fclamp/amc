<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
MineralogyStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'SummaryData',
				'MinGroup',
				);	

} // end MineralogyResultsList class

class
MineralogyContactSheet extends BaseContactSheet
{
	var $Fields = array(	'SummaryData',
				'MinGroup',
				);	

} // end MineralogyContactSheetResultsList class

?>
