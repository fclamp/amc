<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
NmlhStandardResultsList extends BaseStandardResultsList
{	
	function
	NmlhStandardResultsList()
	{
		$this->Fields = array(	'TitAccessionNo',
					'TitObjectName',
					'TitTitle',
					);

		$this->BaseStandardResultsList();
	}

} // end nmlhResultsList class

class
NmlhContactSheet extends BaseContactSheet
{
	function
	NmlhContactSheet()
	{
		$this->Fields = array(	'TitTitle',
					'TitAccessionNo',
					);
		$this->BaseContactSheet();
	}

} // end nmlhContactSheetResultsList class


?>
