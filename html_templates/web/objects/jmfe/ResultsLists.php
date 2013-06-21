<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
jmfeStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'irn_1',
				'TitMainTitle',
				'TitItemType',
				);	

} // end jmfeResultsList class

class
jmfeContactSheet extends BaseContactSheet
{
	var $Fields = array(	'irn_1',	
				'TitMainTitle',
				);	

} // end jmfeContactSheetResultsList class

?>
