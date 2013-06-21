<?php

/*
**
**      Copyright (c) 1998-2009 KE Software Pty Ltd
**
**      Template.  Change all reference to "Client"
**
**         **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
ClientStandardResultsList extends BaseStandardResultsList
{
	function
	ClientStandardResultsList()
	{
		$this->Fields = array(	'TitMainTitle',
					'TitAccessionNo',
					'CreCreatorLocal:1',
					'CreDateCreated'
					);	

		$this->BaseStandardResultsList();
	}	

}


class
ClientContactSheet extends BaseContactSheet
{
	function
	ClientContactSheet()
	{
		$this->Fields = array(	'TitMainTitle',
					'TitAccessionNo',
					);	

		$this->BaseContactSheet();
	}

}

?>
