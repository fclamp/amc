<?php

/*
**
**      Copyright (c) 1998-2009 KE Software Pty Ltd
**
**      Template.  Change all reference to "Client"
**
**         **Example Only**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');



class
ClientBasicQueryForm extends BaseBasicQueryForm
{

	function
	ClientBasicQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					);

		$this->BaseBasicQueryForm();
	}
					

}  

class
ClientAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	ClientAdvancedQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry_tab',
					);

		$this->BaseAdvancedQueryForm();
	}

}  
	

class
ClientDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	ClientDetailedQueryForm()
	{
		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$this->Fields = 
			array(	
			$catNumber,
			'TitMainTitle',
			'CreCreatorLocal_tab',
			'LocCurrentLocationRef->elocations->SummaryData',
			'PhyMedium',
			);

		$this->Hints = 
			array(	
			'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
			'CreSubjectClassification'=> '[ eg. Music ]',
			'PhyMediaCategory'	=> '[ Select from the list ]',
			'CreCountry:1'		=> '[ eg. USA ]',
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
