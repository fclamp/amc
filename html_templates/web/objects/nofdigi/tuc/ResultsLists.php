<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
NofdigiStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'Dc1Title',
				);	

} // end NofdigiStandardResultsList class

class
NofdigiContactSheet extends BaseContactSheet
{
	var $Fields = array(	'Dc1Title',
				);	

} // end NofdigiContactSheetResultsList class


?>
