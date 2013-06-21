<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
ArtDemoStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'TitMainTitle',
				'CreCreatorLocal:1',
				'CreCreationPlace1:1',
				'CreDateCreated',
				'TitAccessionNo',
				);	

} // end ArtDemoResultsList class

class
ArtDemoContactSheet extends BaseContactSheet
{
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				);	

} // end ArtDemoContactSheetResultsList class


?>
