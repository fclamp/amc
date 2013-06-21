<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
NmcPensacolaWebStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'NamObjectTitle',
				'ObjAccessionNumber',
				'CreCreatorSummaryData:1',
				'DatDateCreated'
				);	

} // end NmcMiramarResultsList class

class
NmcPensacolaWebContactSheet extends BaseContactSheet
{
	var $Fields = array(	'NamObjectTitle',
				'ObjAccessionNumber',
				);	

} // end NmcMiramarContactSheetResultsList class


?>
