<?php

/*
**
**      Copyright (c) 1998-2009 KE Software Pty Ltd
**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
AHStandardResultsList extends BaseStandardResultsList
{
	function
	AHStandardResultsList()
	{
		$this->Fields = array(	'ObjObjectName',
					'ObjMuseumName',
					'ObjCategory1',
					);	

		$this->BaseStandardResultsList();
	}	

}


class
AHContactSheet extends BaseContactSheet
{
	function
	AHContactSheet()
	{
		$this->Fields = array(	'ObjObjectName',
					'irn',
					);	

		$this->BaseContactSheet();
	}

}

?>
