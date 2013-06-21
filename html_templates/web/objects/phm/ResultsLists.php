<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd

Martin Jujou
23/10/2003

*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


// standard catalogue results list 
class
CatalogueResultsList extends BaseStandardResultsList
{
	var $Fields = array(	
				'SummaryData'
				
				);	

} 


// standard accession lots results list 
class
AccessionResultsList extends BaseStandardResultsList
{

	function
	AccessionResultsList()
	{
		$this->BaseStandardResultsList();
		$this->Fields = array('SummaryData');
		$this->Database = 'eaccessionlots';
	}

} 

// thesaurus
class
ThesaurusResultsList extends BaseStandardResultsList
{

	function
	ThesaurusResultsList()
	{
		$this->BaseStandardResultsList();
		$this->Fields = array('SummaryData');
		$this->Database = 'ethesaurus';
	}

} 





// standard accession contact sheet
class
AccessionContactSheet extends BaseContactSheet
{
	function
	AccessionContactSheet()
	{
		$this->BaseContactSheet();
		$this->Fields = array('SummaryData');
		$this->Database = 'eaccessionlots';
	}

} 



class
ThesaurusContactSheet extends BaseContactSheet
{
        function
	ThesaurusContactSheet()
	{
		$this->BaseContactSheet();
		$this->Fields = array('SummaryData');
		$this->Database = 'ethesaurus';
	}
}




// standard catalogue contact sheet
class
CatalogueContactSheet extends BaseContactSheet
{
	var $Fields = array(
				'SummaryData'

				);	

} 



?>
