<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
MlisStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'Dc1Title',
				'Dc1CreatorLocal:1',
				'Dc2DateCreated',
				'Dc1Identifier',
				);	

} // end MlisResultsList class

class
MlisContactSheet extends BaseContactSheet
{
	var $Fields = array(	'Dc1Title',
				'Dc1Identifier',
				);	

} // end MlisContactSheetResultsList class

?>
