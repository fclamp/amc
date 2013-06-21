<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
CmccStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'ObjDisplayName',
				'NumCatNo',
				'NumAccessionNo_tab',
				);	

} // end CmccResultsList class


class
CmccContactSheet extends BaseContactSheet
{
	var $Fields = array(	'ObjPopularName',
				'ObjAccessionNumber',
				);	

} // end CmccContactSheet class


?>
