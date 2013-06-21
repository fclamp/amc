<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
RamBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(
		'Anywhere' => 'SummaryData|AdmWebMetadata',
		'inSubject' => 'CreSubjectClassification_tab',
			);

}  // end RamBasicQueryForm class

class
RamAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(
		'Anywhere' => 'SummaryData|AdmWebMetadata',
		'inSubject' => 'CreSubjectClassification_tab',
			);

}  // end RamAdvancedQueryForm class
	

class
RamDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	RamDetailedQueryForm()
	{
		$this->Fields = array(	
			'TitBriefDescription',
			'TitObjectType',
			'TitCollection',
			'CreCreatorRef_tab->eparties->SummaryData',
			'CreRole_tab',
			'CreCountry_tab|CreState_tab|CreDistrict_tab|CreCity_tab',
			'PhyClassification',
			'PhyTechnique_tab',
				);

		$this->Hints = array(
			'CreSubjectClassification_tab' => '[ e.g. drawing, painting, violin, playbill, manuscript ]',
			'TitCollection' => '[ e.g. McCann, Spencer ]',
			'CreCreatorRef_tab->eparties->SummaryData' => '[ e.g. Menuhin ]',
			'CreRole_tab' => '[ e.g. publisher, instrument maker, artist, photographer ]',
			'CreDateCreated',
			'CreCountry_tab|CreState_tab|CreDistrict_tab|CreCity_tab' => '[ e.g. Cremona, United Kingdom ]',
			'TitFullDescription',
			'CrePrimaryInscriptions' => '[ e.g. yours sincerely ]',
			'NotNotes',
			'AssRelatedPartiesRef_tab->eparties->SummaryData',
			'AssRelationship_tab',
			'PhyTechnique_tab',
			'PhyMaterials_tab',
			'TitAccessionNo',
			'CreCreatorRef_tab->eparties->BioBirthDate',
			'CreCreatorRef_tab->eparties->BioBirthPlace',
			'CreCreatorRef_tab->eparties->BioDeathDate',
			'CreCreatorRef_tab->eparties->BioDeathPlace',
			'CreCreatorRef_tab->eparties->BioNationality',
			'CreCreatorRef_tab->eparties->NotNotes',
			);

		$this->DropDownLists = array('TitObjectType' => 'eluts:Object Type',);
		$this->MaxDropDownLength = '20';
	}

} // End RamDetailedQueryForm class
?>
