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
	var $Columns = 'CreCreatorLocal_tab|TitObjectName|TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab';

// added line to drop menu 

	var $Options = array('all' => 'SummaryData|AdmWebMetadata',
			);

}  // end GalleryUKSimpleQueryForm class

class
GalleryUKAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Fields = array(	'Who' => 'CreCreatorLocal_tab|CreCulturalOriginSummary',
				'What' => 'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitTitleNotes',
				'How' => 'PhyTechnique_tab',
				'Place' => 'CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab',
				'When' => 'CreDateCreated',
				);
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

		$this->Fields = array(
				'TitObjectName',
				'TitCollectionGroup_tab',
				'CreCreatorLocal_tab',
				'AssOtherAssociationNotes0',
				'CreCreationPlace1_tab',
				'CreCulturalOrigin1',
				'CreDateCreated',
				'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
				'PhyTechnique_tab',
				'PhyMaterial_tab',
				'PhyMedium_tab',
				'PhySupport',
				'CrePrimaryInscriptions|CreOtherInscriptions',
				'PhyDescription',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				$accessionDate,
				'TitAccessionNo',
				'LocCurrentLocationRef->elocations->SummaryData',
				'NotNotes',
				);

		$this->Hints = array(
				'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab' => "[ e.g. 'The Ancient of Days']",
				'PhySupport'	=> '[ e.g. Paper ]',
				'TitObjectName' => '[ e.g. print or sampler ]',
				'CreCreatorLocal_tab' => '[ e.g. Hockney ]',
				'AssOtherAssociationNotes0' => '[ e.g. after Hogarth ]',
				'CreCreationPlace1_tab' => '[ e.g. Manchester, Russia ]',
				'CreDateCreated' => '[ e.g. Note: Not all works have dates ]',
				'PhyTechnique_tab' => '[ e.g. lithograph ]',
				'CreCulturalOrigin1' => '[ e.g. French School ]',
				'PhyMaterial_tab' => '[ e.g. silk ]',
				'PhyMedium_tab' => '[ e.g. acrylic ]',
				'PhySupport' => '[ e.g. canvas ]',
				'TitAccessionNo' => '[ our unique number e.g. T.1995.10 ]',
				);

		$this->DropDownLists = array(
				'TitCollectionGroup_tab' => 'eluts:Collection Group',
				);

		$this->BaseDetailedQueryForm();
	}

} // End GalleryUKDetailedQueryForm class
?>


<?php
// NofDigiDetailedQueryForm


class
NofDigiDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	NofDigiDetailedQueryForm()
	{
		$RegisterDate = new QueryField;
		$RegisterDate->ColName = 'TitRegisterDate';
		$RegisterDate->ColType = 'date';

		$this->Fields = array(
				'Dc1Title',
				$RegisterDate,
				
				);
		$this->DropDownLists = array(
				TitRegisterDate => '|1990|1991|1992|1993|1994',
				);

		$this->BaseDetailedQueryForm();
	}

} // End NofDigiDetailedQueryForm class
?>
