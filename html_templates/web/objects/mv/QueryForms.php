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
MvBasicQueryForm extends BaseBasicQueryForm
{

	function
	MvBasicQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'collection' => 'ColCategory|ColScientificGroup|ColDiscipline|ColCollectionName_tab',
					//'notes' => 'NotNotes|TitTitleNotes',
					//'artist' => 'CreCreatorLocal_tab',
					//'place' => 'CreCountry_tab',
					);

		 //var $Restriction = "ColRecordCategory = 'Registered'";


		$this->BaseBasicQueryForm();
	}
					

}  

class
MvAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	MvAdvancedQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'collection' => 'ColCategory|ColScientificGroup|ColDiscipline|ColCollectionName_tab',
					//'title' => 'TitMainTitle|TitTitleNotes',
					//'notes' => 'NotNotes|TitTitleNotes',
					//'artist' => 'CreCreatorRefLocal_tab',
					//'place' => 'CreCountry_tab',
					);
		// var $Restriction = "ColRecordCategory = 'Registered'";

		$this->BaseAdvancedQueryForm();
	}

}  
	

class
MvDetailedQueryForm extends BaseDetailedQueryForm
{


	function
	MvDetailedQueryForm()
	{
	//var $Restriction = "ColRecordCategory = 'Registered'";
		//$catNumber = new QueryField;
		//$catNumber->ColName = 'CatNumber';
		//$catNumber->ColType = 'integer';

		$this->Fields = 
			array(	
			'ColCategory',
			'ColScientificGroup',
			'ColDiscipline',
			'ColRegPrefix',
			'ColRegNumber',
			'ColRegPart',
			//'ColRecordCategory',
			'ColCollectionName_tab',


			//$catNumber,
			//'TitMainTitle',
			//'CreCreatorLocal_tab',
			//'LocCurrentLocationRef->elocations->SummaryData',
			//'PhyMedium',
			);

		$this->Hints = 
			array(	
			'ColCategory'		=> '[ eg. Natural Sciences ]',
			'ColScientificGroup'	=> '[ eg. Zoology ]',
			'ColDiscipline'		=> '[ eg. Anthropology ]',
			'ColRegPrefix' 		=> '[ eg. x ]',
			'ColRegNumber' 		=> '[ eg. A number ]',
			'ColRegPart' 		=> '[ eg. A number ]',
			//'ColRecordCategory'	=> '[ eg. Registered ]',
			'ColCollectionName_tab'	=> '[ Select from the list ]',
			);

		$this->DropDownLists = 
			array(	
			//'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
			//'CreCountry_tab' => 'eluts:Location',
			'ColCollectionName_tab'	=> 'eluts:Collection Name',
			);

		$this->LookupLists = 
			array (
			//'TitCollectionTitle' => 'Collection Title',
			);

		$this->BaseDetailedQueryForm();
	}

} 

?>
