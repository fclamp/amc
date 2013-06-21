<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
DpgBasicQueryForm extends BaseBasicQueryForm
{
	function
	DpgBasicQueryForm()
	{
		$this->Options = array(
			'Anywhere'	=> 'SummaryData|AdmWebMetadata',
			'Title'		=> 'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			'Artist/Maker'	=> 'CreCreatorLocal_tab'
			);
	
		$this->BaseBasicQueryForm();
	}

}  // end DpgBasicQueryForm class

class
DpgAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	DpgAdvancedQueryForm()
	{
		$this->Options = array(
			'Anywhere'	=>	'SummaryData|AdmWebMetadata',
			'Title'		=>	'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			'Artist/Maker'	=>	'CreCreatorLocal_tab'
			);

		$this->BaseAdvancedQueryForm();
	}
}  // end DpgAdvancedQueryForm class
	
class
DpgDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	DpgDetailedQueryForm()
	{
		$creationDateEarly = new QueryField;
		$creationDateEarly->ColName = 'CreEarliestDate';
		$creationDateEarly->ColType = 'date';
		$creationDateEarly->IsLower = 1;
		
		$creationDateLate = new QueryField;
		$creationDateLate->ColName = 'CreLatestDate';
		$creationDateLate->ColType = 'date';
		$creationDateLate->IsUpper = 1;		

		$this->Fields = array(
			'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			$creationDateEarly,
			$creationDateLate,
			'CreCreatorLocal_tab',
			'CreCreatorRef_tab->eparties->BioNationality',
			'CreSubjectClassification_tab',
			'TitAccessionNo',
			'AccAccessionLotRef->eaccessionlots->SummaryData',
			'AdoAdoptionStatus',
			);

		$this->Hints = array(
			'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab' => '[ e.g. Girl at a Window ]',
			'CreCreatorLocal_tab' => '[ e.g. Rembrandt ]',
			'AccAccessionLotRef->eaccessionlots->SummaryData'	=>	'[ e.g. Bourgeois bequest ]',
			'TitAccessionNo' => '[ e.g. DPG.163 ]',
			'CreSubjectClassification_tab'	=> '[ choose from list ]',
			'CreCreatorRef_tab->eparties->BioNationality' => '[ e.g. Dutch ]',
			'AdoAdoptionStatus' => '[ e.g. for adoption ]',
			);

		$this->DropDownLists = array(
			'CreSubjectClassification_tab' => 'eluts:Subject Classification',
			'AdoAdoptionStatus' => 'eluts:Adoption Status',
			);

		$this->BaseDetailedQueryForm();
	}

} // End DpgDetailedQueryForm class
?>
