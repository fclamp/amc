<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
GalleryUKBasicQueryForm extends BaseBasicQueryForm
{
	function
	GalleryUKBasicQueryForm()
	{
		// Commented out as should have no effect
		//$this->$Columns = 'CreCreatorLocal_tab|TitObjectName|TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab';
		
		$this->$Options = array('all' => 'SummaryData|AdmWebMetadata',);

		$this->BaseBasicQueryForm();
	}

 
}  // end GalleryUKSimpleQueryForm class

class
GalleryUKAdvancedQueryForm extends BaseAdvancedQueryForm
{
	function
	GalleryUKAdvancedQueryForm()
	{
		$this->$Fields = array(	
				'Who' => 'CreCreatorLocal_tab|CreCulturalOriginSummary',
				'What' => 'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitTitleNotes',
				'How' => 'PhyTechnique_tab',
				'Place' => 'CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab',
				'When' => 'CreDateCreated',
				);

		$this->BaseAdvancedQueryForm();
	}
}  // end GalleryUKAdvancedQueryForm class
	

class
GalleryUKDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	GalleryUKDetailedQueryForm()
	{
		$accessionDate = new QueryField;
		$accessionDate->ColName = 'TitAccessionDate';
		$accessionDate->ColType = 'date';

		$creationDateEarly = new QueryField;
		$creationDateEarly->ColName = 'CreEarliestDate';
		$creationDateEarly->ColType = 'date';
		$creationDateEarly->IsLower = 1;

		$creationDateLate = new QueryField;
		$creationDateLate->ColName = 'CreLatestDate';
		$creationDateLate->ColType = 'date';
		$creationDateLate->IsUpper = 1;
		

		$this->Fields = array(
				'TitObjectName',
				'TitCollectionGroup_tab',
				'CreCreatorLocal_tab',
				'AssOtherAssociationNotes0',
				'CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab',
				'CreSubjectClassification_tab',
				'CreCulturalOrigin1|CreCulturalOrigin2|CreCulturalOrigin3|CreCulturalOrigin4|CreCulturalOrigin5',
				$creationDateEarly,
				$creationDateLate,
				'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
				'PhyTechnique_tab',
				'PhyMaterial_tab',
				'PhyMedium_tab',
				'PhySupport',
				//'CrePrimaryInscriptions|CreOtherInscriptions',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				'TitAccessionNo',
				'LocCurrentLocationRef->elocations->SummaryData',
				);

		$this->Hints = array(
				'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab' => "[ eg 'The Ancient of Days']",
				'PhySupport'	=> '[ eg Paper ]',
				'TitObjectName' => '[ eg print, sampler ]',
				'CreCreatorLocal_tab' => '[ eg Hockney ]',
				'AssOtherAssociationNotes0' => '[ eg after Hogarth ]',
				'CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab' => '[ eg Manchester, Russia ]',
				'CreEarliestDate' => '[ note: not all works have dates ]',
				'PhyTechnique_tab' => '[ eg lithography ]',
				'CreCulturalOrigin1|CreCulturalOrigin2|CreCulturalOrigin3|CreCulturalOrigin4|CreCulturalOrigin5' => '[ eg French School ]',
				'PhyMaterial_tab' => '[ eg silk ]',
				'PhyMedium_tab' => '[ eg acrylic ]',
				'PhySupport' => '[ eg canvas ]',
				'TitAccessionNo' => '[ our unique number eg T.1995.10 ]',
				'LocCurrentLocationRef->elocations->SummaryData' => '[ note: only works for some gallery locations ]' ,
				);

		$this->DropDownLists = array(
				'TitCollectionGroup_tab' => 'eluts:Collection Group',
				'CreSubjectClassification_tab' => 'eluts:Subject Classification',
				);

		$this->BaseDetailedQueryForm();
	}

} // End GalleryUKDetailedQueryForm class
?>
