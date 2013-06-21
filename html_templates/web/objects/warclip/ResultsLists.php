<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/warclip/BaseResultsLists.php');
require_once ($WEB_ROOT . '/objects/warclip/QueryGenerator.php');

class
WarclipStandardResultsList extends BaseStandardResultsList
{
	function
	WarclipStandardResultsList()
	{
	
		$this->BaseStandardResultsList();
		$this->Fields = array(
				'AdmWebMetadata',
				'WarHeadline',
                                'WarSourceNewspaperSummData',
                                'DatManufacture',
				'WarSubjectMetaData',
				'SumSubHeading1',
				'SumSubHeading2',
				'SumSubHeading3',
				'SumSubHeading4',
				'SumSubHeading5',
				'ObjTitle',
				'MMirn',
				);

		$this->Order = 'rank desc';
		$this->Database = 'warclip';
		$this->QueryGenerator = 'WarclipQueryGenerator';
	}
} // end WarclipResultsList class

class
WarclipContactSheet extends BaseContactSheet
{
	function
	WarclipContactSheet()
	{
		$this->BaseContactSheet();
		$this->Fields = array(	'ObjTitle',
				'NumCatNo',
				);	
		$this->Database = 'warclip';
		$this->QueryGenerator = 'WarclipCustomQueryGenerator';
		$this->Order = 'rank desc';
	}
} // end WarclipContactSheet class


?>
