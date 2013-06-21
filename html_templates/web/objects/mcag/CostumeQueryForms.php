<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
CostumeBasicQueryForm extends BaseBasicQueryForm
{
	function
	CostumeBasicQueryForm()
	{
		$this->Options = array(
			"Anywhere" => "SummaryData|AdmWebMetadata",
			);
		$this->BaseBasicQueryForm();
	}

}  // end CostumeBasicQueryForm class

class
CostumeAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	CostumeAdvancedQueryForm()
	{
		$this->Options = array(
			'Anywhere'	=>	'SummaryData|AdmWebMetadata',
			'Object Name'		=>	'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			'Designer'	=>	'CreCreatorLocal_tab'
			);

		$this->BaseAdvancedQueryForm();
	}
}  // end CostumeAdvancedQueryForm class
	
class
CostumeDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	CostumeDetailedQueryForm()
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
			'TitCollectionGroup_tab',
			'TitObjectName',
			'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			'CreCreatorLocal_tab',
			'CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab',
			'CreCulturalOrigin1|CreCulturalOrigin2|CreCulturalOrigin3|CreCulturalOrigin4|CreCulturalOrigin5',
			$creationDateEarly,
			$creationDateLate,
			'PhyMaterial_tab|PhyMedium_tab',
			'PhyTechnique_tab',
			'PhySupport',
			'AccAccessionLotRef->eaccessionlots->AcqCreditLine',
			'TitAccessionNo',
			'CreSubjectClassification_tab',
			);

		$this->Hints = array(
			'TitObjectName' => '[ e.g. chair, painting, dress ]',
			'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab' => '[ e.g. "The Hireling Shepherd" ]',
			'CreCreatorLocal_tab' => '[ including Designer / Manufacturer ]',
			'CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab'	=> '[ e.g. France, Manchester ]',
			'CreCulturalOrigin1|CreCulturalOrigin2|CreCulturalOrigin3|CreCulturalOrigin4|CreCulturalOrigin5'	=> '[ e.g. Greek, Chinese ]',
			'PhyMaterial_tab|PhyMedium_tab' => '[ e.g. silk, acrylic, porcelain ]',
			'PhyTechnique_tab' => '[ e.g. etching, blown, woven ]',
			'PhySupport'	=> '[ e.g. canvas, paper ]',
			'AccAccessionLotRef->eaccessionlots->AcqCreditLine'	=>	'[ e.g. The Friends of Manchester City Galleries ]',
			'TitAccessionNo' => '[ e.g. 1882.1 ]',
			'CreSubjectClassification_tab'	=> '[ e.g. Italian painting, industrial design, women ]',
			);

		$this->DropDownLists = array(
			'TitCollectionGroup_tab' => 'eluts:Collection Group',
			);

		$this->LookupLists = array(
			'CreSubjectClassification_tab'	=> 'Subject Classification'
			);

		$this->BaseDetailedQueryForm();
	}

} // End CostumeDetailedQueryForm class
?>
