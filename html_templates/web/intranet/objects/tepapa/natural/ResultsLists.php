<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(dirname(realpath(__FILE__))))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');
require_once ('DefaultPaths.php');

class
TePapaStandardResultsList extends BaseStandardResultsList
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	
				'RegRegistrationNumberString',
				'IntClaFamily',
				'IdeScientificNameLocal:1',
				);	


} // end TePapaResultsList class

class
TePapaContactSheet extends BaseContactSheet
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	
				'IntClaFamily',
				'IdeScientificNameLocal:1',
				);	

} // end TePapaContactSheetResultsList class

?>
