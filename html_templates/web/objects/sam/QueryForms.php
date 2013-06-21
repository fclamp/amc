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
require_once ($LIB_DIR . 'BaseQueryForms.php');



class
SamBasicQueryForm extends BaseBasicQueryForm
{

	function
	SamBasicQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					);

		$this->BaseBasicQueryForm();
	}
					

}  

class
SamAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	SamAdvancedQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					);

		$this->BaseAdvancedQueryForm();
	}

}  
	

class
SamDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	SamDetailedQueryForm()
	{
		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$this->Fields = 
			array(		'DetScientificNameLocal_tab',
					'DetGenusPrefix_tab',
					'DetGenusSuffix_tab',
					'DetSpeciesPrefix_tab',
					'DetSpeciesSuffix_tab',
					'ColLocationNotes',
					'HabHabitatNotes',
			);

		$this->Hints = 
			array(		'DetScientificNameLocal_tab' => "[ie. Psammisia columbiensis]",
					'DetGenusPrefix_tab',
					'DetGenusSuffix_tab',
					'DetSpeciesPrefix_tab',
					'DetSpeciesSuffix_tab',
					'ColLocationNotes',
					'HabHabitatNotes',	
			);

		$this->DropDownLists = 
			array(	
			'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
			'CreCountry_tab' => 'eluts:Location',
			);

		$this->LookupLists = 
			array (
			'TitCollectionTitle' => 'Collection Title',
			);

		$this->BaseDetailedQueryForm();
	}

} 

?>
