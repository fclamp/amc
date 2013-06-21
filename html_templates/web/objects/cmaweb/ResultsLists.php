<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
CmaStandardResultsList extends BaseStandardResultsList
{

//	var $Fields = array(	'TitAccessionNo',
//				'CreCreatorLocal:1',
//				'TitMainTitle',
//				);	

	function
	cmaStandardResultsList()
	{
		$this->BaseStandardResultsList();

		$this->Fields = array(	'TitAccessionNo',
					'CreCreatorLocal:1',
					'TitMainTitle',
					);
		
		$this->Database = 'ecatalogue';

	}

} // end CmaResultsList class

class
CmaContactSheet extends BaseContactSheet
{
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				);	

} // end CmaContactSheetResultsList class


?>
