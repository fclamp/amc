<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
MlisBasicQueryForm extends BaseBasicQueryForm
{
	function
	MlisBasicQueryForm()
	{
		$this->Options = array(
			'Anywhere'	=> 'SummaryData|AdmWebMetadata',
			);
	
		$this->BaseBasicQueryForm();
	}

}  // end MlisBasicQueryForm class

class
MlisAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	MlisAdvancedQueryForm()
	{
		$this->Options = array(
			'Anywhere'	=>	'SummaryData|AdmWebMetadata',
			'Title'		=>	'Dc1Title',
			);

		$this->BaseAdvancedQueryForm();
	}
}  // end MlisAdvancedQueryForm class
	
class
MlisDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	MlisDetailedQueryForm()
	{
		// Start without these. Left commented because MLIS may
		//	decide they want them.
		//$creationDateEarly = new QueryField;
		//$creationDateEarly->ColName = 'CreEarliestDate';
		//$creationDateEarly->ColType = 'date';
		//$creationDateEarly->IsLower = 1;
		
		//$creationDateLate = new QueryField;
		//$creationDateLate->ColName = 'CreLatestDate';
		//$creationDateLate->ColType = 'date';
		//$creationDateLate->IsUpper = 1;		

		$this->Fields = array(
			'Dc1Identifier',
			'Dc1Title',
			'Dc1CreatorRef_tab->eparties->SummaryData',
			'Dc2DateCreated',
			'Dc1Subject_tab',
			);

		$this->Hints = array(
			'Dc1Identifier' => '[ e.g. m25631 ]',
			'Dc1Title' => '[ e.g. "Albert Square" ]',
			'Dc1CreatorRef_tab->eparties->SummaryData' => '[ e.g. "Milligan, H" ]',
			'Dc2DateCreated' => '[ e.g. 1969 ]',
			'Dc1Subject_tab' => '[ e.g. Longsight, Transport, Bus ]',
			);

		$this->BaseDetailedQueryForm();
	}

} // End MlisDetailedQueryForm class
?>
