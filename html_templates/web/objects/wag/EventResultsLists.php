<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
GalleryUKEventResultsList extends BaseStandardResultsList
{
	function
	GalleryUKEventResultsList()
	{
		$this->Database = 'eevents';
		$this->Fields = array( 'SummaryData',
					);

		$this->BaseStandardResultsList();
	}

} // end GalleryUKEventResultsList class

class
GalleryUKEventContactSheet extends BaseContactSheet
{
	function
	GalleryUKEventContactSheet()
	{
		$this->Database = 'eevents';
		$this->Fields = array( 'SummaryData',
					);

		$this->BaseContactSheet();
	}
} // end GalleryUKEventContactSheet class

?>
