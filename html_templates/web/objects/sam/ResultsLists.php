<?php
/*
**
**      Copyright (c) 1998-2009 KE Software Pty Ltd
**
**      Template.  Change all reference to "Sam"
**
**         **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
SamStandardResultsList extends BaseStandardResultsList
{
	function
	SamStandardResultsList()
	{
		$this->Fields = array(	'IdeScientificNameLocal:1',
					'IdeGenusLocal:1',
					//'DetGenusSuffix:1',
					'IdeSpeciesLocal:1',
					//'DetSpeciesSuffix:1',
					'LocSiteLocal',
					//'HabHabitatNotes',
					);	

		$this->BaseStandardResultsList();
	}	

}


class
SamContactSheet extends BaseContactSheet
{
	function
	SamContactSheet()
	{
		$this->Fields = array(	'IdeScientificNameLocal:1',
					//'DetGenusPrefix:1',
					'IdeGenusLocal:1',
					//'DetGenusSuffix:1',
					'IdeSpeciesLocal:1',
					//'DetSpeciesSuffix:1',
					'LocSiteLocal',
					//'HabHabitatNotes',
					);	

		$this->BaseContactSheet();
	}

}

?>
