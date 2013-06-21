<?php

/*
**
**      Copyright (c) 1998-2009 KE Software Pty Ltd
**
**      Template.  Change all reference to "Nybg"
**
**         **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


/*
**
**      Copyright (c) 1998-2009 KE Software Pty Ltd
**
**      Template.  Change all reference to "Nybg"
**
**         **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
NybgStandardResultsList extends BaseStandardResultsList
{
	function
	NybgStandardResultsList()
	{
		$this->Fields = array(	'DetScientificNameLocal:1',
					'DetGenusPrefix:1',
					'DetGenusSuffix:1',
					'DetSpeciesPrefix:1',
					'DetSpeciesSuffix:1',
					'ColLocationNotes',
					'HabHabitatNotes',
					);	

		$this->BaseStandardResultsList();
	}	

}


class
NybgContactSheet extends BaseContactSheet
{
	function
	NybgContactSheet()
	{
		$this->Fields = array(	'DetScientificNameLocal:1',
					'DetGenusPrefix:1',
					'DetGenusSuffix:1',
					'DetSpeciesPrefix:1',
					'DetSpeciesSuffix:1',
					'ColLocationNotes',
					'HabHabitatNotes',
					);	

		$this->BaseContactSheet();
	}

}

?>
