<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
McagCostumeNarrativeContactSheet extends BaseContactSheet
{
	function
	McagCostumeNarrativeContactSheet()
	{
		$this->ExtraStrings = array(
			"NEW SEARCH"	=> "Back to Themes",
			);
			
		$this->Database = 'enarratives';
		$this->Fields = array(	'NarTitle',
					);	

		$this->BaseContactSheet();
	}

} // end McagCostumeNarrativeContactSheet


?>
