<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
jmfeBasicQueryForm extends BaseBasicQueryForm
{
	function jmfeBasicQueryForm()
	{
		//$irnQueryField = new QueryField();
		//$irnQueryField->ColName = 'irn_1';
		//$irnQueryField->ColType = 'integer';
		
		$this->Options = array('AdmWebMetadata|SumAssocPartyLocal_tab',);
		
		$this->BaseBasicQueryForm();
	}
}  // end jmfeBasicQueryForm class

class
jmfeDetailedQueryForm extends BaseDetailedQueryForm
{
	function jmfeDetailedQueryForm()
	{
		$irnQueryField = new QueryField();
		$irnQueryField->ColName = 'irn_1';
		$irnQueryField->ColType = 'integer';
	
	
		$this->Fields = array(	$irnQueryField,	
					'TitMainTitle',
					'SumAssocPartyLocal_tab',
					'CreDateCreated',
					'SumItemClass',
					'TitItemDescription',
					);	
		$this->Hints = array(	'irn_1' => '[ eg. 123]',	
					'TitMainTitle' 	=> '[ eg. Holy Cross Photograph]',
					'SumAssocPartyLocal_tab' =>'[ eg. Holy Cross Hospital]',
					'CreDateCreated'	=> '[ eg. 1983 ]',
					'SumItemClass' => '[ eg. Advertising]',
					'TitItemDescription' => '[ eg. Photograph of President of Holy Cross]',
					);
		$this->DropDownLists = array();
		$this->LookupLists = array ();
		$this->BaseDetailedQueryForm();
	}
} // End jmfeDetailedQueryForm class
?>
