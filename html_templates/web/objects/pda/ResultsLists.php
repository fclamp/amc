<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'PdaBaseResultsLists.php');

class
PdaStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'TitMainTitle',
				'CreCreatorLocal:1',
				);	

} // end PdaResultsList class

class
PdaContactSheet extends BaseContactSheet
{
	var $Fields = array(	'TitMainTitle',
				'CreCreatorLocal:1',
				);	

} // end PdaContactSheetResultsList class

?>
