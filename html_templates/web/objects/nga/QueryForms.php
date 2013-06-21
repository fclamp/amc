<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
NgaBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end NgaBasicQueryForm class

class
NgaAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end NgaAdvancedQueryForm class
	

class
NgaDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	NgaDetailedQueryForm()
	{


		$titAccessionNo = new QueryField;
		$titAccessionNo->ColType = 'string';
		$titAccessionNo->ColName = 'TitAccessionNo';

		$this->Fields = array(	'TitMainTitle',
					'TitCollectionTitle',
					$titAccessionNo,
					'TitTitleNotes',
					'CreSubjectClassification',
					'CreCreatorLocal_tab',
					'LocCurrentLocationRef->elocations->SummaryData',
					'TitAccessionNo',
					'CreDateCreated',
					'CreCountry_tab',
					'PhyTechnique',
					'NotNotes',
					'PhyMediaCategory',
					'PhyMedium',
					);

		$this->Hints = array(	'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
					'TitCollectionTitle' 	=> '[ Select from list ]',
					'CreSubjectClassification'=> '[ eg. Music ]',
					'PhyMediaCategory'	=> '[ Select from list ]',
					'PhyMedium'		=> '[ Select from list ]',
					'CreCountry_tab'	=> '[ Select from list ]',
					'CreDateCreated'	=> '[ eg. 1983 ]',
					);

		$this->DropDownLists = array(	'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
						'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
						'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					);

		$this->LookupLists = array(	'TitCollectionTitle' => 'Collection Title',
						'CreCountry_tab' => 'Location',
						);

		$this->BaseDetailedQueryForm();
	}

} // End NgaDetailedQueryForm class
?>
