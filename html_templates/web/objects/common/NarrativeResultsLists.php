<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
NarrativeResultsList extends BaseStandardResultsList
{
	function
	NarrativeResultsList()
	{
		$this->Database = 'enarratives';

		$this->Fields = array(	'NarTitle',
					'NarAuthorsRef_tab',
					);	
		$this->BaseStandardResultsList();
	}
} // end ResultsList class

class
NarrativeContactSheet extends BaseContactSheet
{
	function
	NarrativeContactSheet()
	{
		$this->Fields = array(	'NarTitle',
					);	
		$this->BaseContactSheet();
	}
} // end NarrativeContactSheetResultsList class

?>
