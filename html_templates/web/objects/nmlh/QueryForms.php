<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
NmlhBasicQueryForm extends BaseBasicQueryForm
{
	function
	NmlhBasicQueryForm()
	{

		$this->Options = array('Anywhere' => 'SummaryData|AdmWebMetadata',
				);

		$this->BaseBasicQueryForm();
	}

}  // end nmlhBasicQueryForm class

class
NmlhAdvancedQueryForm extends BaseAdvancedQueryForm
{
		function
		NmlhAdvancedQueryForm()
		{
			$this->Options = array('Anywhere' => 'SummaryData|AdmWebMetadata',
						'Title' => 'TitTitle|TitCollectionTitle',
						'KeyWord' => 'TitKeyName_tab',
						'ObjectName' => 'TitObjectName',
					);
			$this->BaseAdvancedQueryForm();
		}
}  // end nmlhAdvancedQueryForm class
	

class
NmlhDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	NmlhDetailedQueryForm()
	{
		
		$this->Fields = array(
				'TitAccessionNo',
				'TitObjectName',
				'TitTitle',
				'TitCollectionTitle',
				'CreSHIC_tab|TitKeyName_tab',
				'AssAssociatedPlaces',
				'AssAssociatedPeople',
				'AssAssociatedEvents',
				'CreDateCreated|AssAssociatedDates',
				'CreCreatorRef_tab->eparties->SummaryData',
				'NotNotes',				
				);

		$this->Hints = array(
				'TitAccessionNo' => "[ e.g. NMLH.2000.10.61]",
				'TitObjectName'	=> '[ e.g. Photograph ]',
				'TitCollectionTitle' => '[ Select from list ]',
				'CreSHIC_tab|TitKeyName_tab' => '[ Select from list ]',
				'AssAssociatedPlaces' => '[ e.g. Paris ]',
				'AssAssociatedPeople' => '[ e.g. Paine ]',
				'AssAssociatedEvents' => '[ e.g. Peterloo ]',
				'CreDateCreated|AssAssociatedDates' => '[ e.g. 1901, 20/01/1901 ]',
				'CreCreatorRef_tab->eparties->SummaryData' => '[ e.g. Cruickshank ]',
					);

		$this->DropDownLists = array(
				'TitObjectName' => '|agenda|badge|banner|card|cartoon|drawing|jug|mug|plate|teapot|saucer|certificate|emblem|leaflet|medal|notice|packaging|painting|photograph|postcard|poster|print|ribbon|sash|sculpture|sign|token',
				'CreSHIC_tab|TitKeyName_tab' => '|Black History|Campaign|Clarion|Communist Party of Great Britain|Conservative Party| Co-operative Wholesale Society|Employment|Friendly Society|Labour Party|Liberal Party|Peace|Spanish Civil War|Socialist Sunday School|Strike|Trade Union|Unemployment|Unionist|War|Women|World War I|World War II',	
				'TitCollectionTitle' => '|Communist Party of Great Britain Picture Collection|Department of Employment|Transport and General Workers Union: 2000|William Crowther Collection|National Banner Survey|CWS Collection| TUC Collection',
				);

		$this->BaseDetailedQueryForm();
	}

} // End nmlhDetailedQueryForm class
?>
