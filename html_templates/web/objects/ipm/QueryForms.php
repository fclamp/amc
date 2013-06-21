<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
IpmBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end IpmBasicQueryForm class

class
IpmAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end IpmAdvancedQueryForm class
	

class
IpmDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	IpmDetailedQueryForm()
	{
		$crelatestdate = new QueryField;
		$crelatestdate->ColType = 'date';
		$crelatestdate->ColName = 'CreLatestDate';
		$crelatestdate->IsUpper = 1;
		$creearliestdate = new QueryField;
		$creearliestdate->ColType = 'date';
		$creearliestdate->ColName = 'CreEarliestDate';
		$creearliestdate->IsLower = 1;
	
		$this->Fields = array(	'CreCreatorLocal_tab',
					'TitMainTitle',
					'CreDateCreated',
					$creearliestdate,
					$crelatestdate,
					'CreCountry_tab',
					'PhyCollectionArea',
					//'CreSubjectClassification_tab',
					'TitCollectionTitle',
					'TitAccessionNo',
					);
		$this->Hints = array(	 'TitCollectionTitle' 	=> '[ Select from the list ]',
					'PhyMedium'		=> '[ Select from the list ]',
					'CreCountry_tab'	=> '[ Select from the list ]',
					'CreDateCreated'	=> '[ eg. 1983 ]',
					//'CreSubjectClassification_tab'	=> '[ Select from the list ]',
					'PhyCollectionArea'	=> '[ Select from the list ]',
					);
		$this->DropDownLists = array(	'PhyMedium' => '|Etching|Woodcut|Stone-Flint|Lithograph|Engraving|Steel Engraving|Bone',
						'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
						'CreCountry_tab' => 'eluts:Creator Location',
						'TitCollectionTitle' => 'eluts:Collection Title Web',
						//'CreSubjectClassification_tab' => 'eluts:Subject Classification',
						'PhyCollectionArea' => 'eluts:Collection Area',
					);

		/*
		$this->LookupLists = array (
						'TitCollectionTitle' => 'eluts:Collection Title',
					);
					*/
		$this->BaseDetailedQueryForm();
		}
} // End IpmDetailedQueryForm class
?>
