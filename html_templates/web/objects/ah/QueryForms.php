<?php

/* Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');



class
AHBasicQueryForm extends BaseBasicQueryForm
{

	function
	AHBasicQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'Object' => 'ObjObjectName',
					'Desciption/Notes' => 'DesDescription|NotNotes',
					'Artist/Manufacturer' => 'IdtArtist',
					'Origin' => 'IdtOrigin',
					);

		$this->BaseBasicQueryForm();
	}
					

}  

class
AHAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	AHAdvancedQueryForm()
	{
		$this->Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'object' => 'ObjObjectName',
					'notes' => 'NotNotes|DesDescription',
					'artist' => 'IdtArtist',
					'place' => 'IdtOrigin',
					);

		$this->BaseAdvancedQueryForm();
	}

}  
	

class
AHDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	AHDetailedQueryForm()
	{
		$catNumber = new QueryField;
		$catNumber->ColName = 'irn';
		$catNumber->ColType = 'integer';

		$this->Fields = 
			array(	
			$catNumber,
			'ObjObjectName',
			'ObjMuseumName',
			'ObjCategory1',
			'ObjCategory2',
			'ObjCategory3',
			'ObjCategory4',
			'IdtArtist',
			'IdtOrigin',
			'IdtPeriod',
			'DesDescription',
			'DesColour',
			'DesMaterial',
			'DesProvenance',
			'DesRelevance',
			'NotNotes',
			);

		$this->Hints = 
			array(	
			'ObjObjectName' 	=> '[ eg. gun, flag, banner, tank ]',
			'ObjMuseumName'		=> '[ select from the list ]',
			'ObjCategory1'		=> '[ select from the list ]',
			'ObjCategory2'		=> '[ select from the list ]',
			'ObjCategory3'		=> '[ select from the list ]',
			'ObjCategory4'		=> '[ select from the list ]',
			);

		$this->DropDownLists = 
			array(	
			'ObjMuseumName' => 'eluts:Museum Name',
			'ObjCategory1'	=> 'eluts:Category[1]',
			'ObjCategory2'	=> 'eluts:Category[2]',
			'ObjCategory3'	=> 'eluts:Category[3]',
			'ObjCategory4'	=> 'eluts:Category[4]',
			'DesRelevance'	=> 'eluts:Relevance',
			);

		$this->LookupLists = 
			array (
			'ObjObjectName' => 'eluts:Object Name',
			'IdtArtist'	=> 'eluts:Artist/Manufacturer',
			);

		$this->BaseDetailedQueryForm();
	}

} 

?>
