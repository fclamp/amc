<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
MsimStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'ClaObjectName',
				'ColRegNumber',
				'ColCollectionName:1',
				);	

} // end MsimResultsList class

class
MsimArchiveResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'ColCollectionName:1',
				'ClaObjectSummary',
				'ColRegNumber',
				);	

} // end MsimResultsList class

class
MsimContactSheet extends BaseContactSheet
{
	var $Fields = array(	'ClaObjectName',
				'ColRegNumber',
				);	

} // end MsimContactSheetResultsList class


?>
