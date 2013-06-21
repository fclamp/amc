<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
TcmiBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'name' => 'ObjPopularName',
					'notes' => 'NotNotes',
					'maker' => 'CreMakerRef_tab',
					);

}  // end TcmiBasicQueryForm class

class
GalleryBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end GalleryBasicQueryForm class

class
TcmiAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'name' => 'ObjPopularName',
					'notes' => 'NotNotes',
					'maker' => 'CreMakerRef_tab',
					);

}  // end TcmiAdvancedQueryForm class

class
GalleryAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end GalleryAdvancedQueryForm class
	

class
TcmiDetailedQueryForm extends BaseDetailedQueryForm
{
	var $Fields = array(	'ObjPopularName',
				'ClaCollection',
				'ClaClassificationTerm_tab',
				'CreMakerRef_tab',
				'LocCurrentLocationRef->elocations->SummaryData',
				'ObjAccessionNumber',
				'DatDateMade',
				'DesMaterials',
				'NotNotes',
				);

	var $Hints = array(	'ObjPopularName' 		=> '[ eg. The Cat in the hat ]',
				'ClaCollection' 		=> '[ eg. American Experience ]',
				'ClaClassificationTerm_tab'	=> '[ Select from the list ]',
				'DatDateMade'			=> '[ eg. 1983 ]',
				'DesMaterials'		=> '[ eg. ceramic ]',
				);

	var $DropDownLists = array(	#'TitCollectionTitle' => 'eluts:Collection Title',
				);

	var $LookupLists = array (
					'ClaClassificationTerm_tab' => 'Classification Term',
					'DesMaterials' => 'Materials',
				);

} // End TcmiDetailedQueryForm class

class
GalleryDetailedQueryForm extends BaseDetailedQueryForm
{
	var $Fields = array(	'TitMainTitle',
				'TitCollectionTitle',
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

	var $Hints = array(	'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
				'TitCollectionTitle' 	=> '[ eg. Barry Humphries ]',
				'CreSubjectClassification'=> '[ eg. Music ]',
				'PhyMediaCategory'	=> '[ Select from the list ]',
				'PhyMedium'		=> '[ Select from the list ]',
				'CreCountry:1'		=> '[ eg. USA ]',
				'CreDateCreated'	=> '[ eg. 1983 ]',
				'PhyTechnique'		=> '[ eg. Hand Sewn ]',
				);

	var $DropDownLists = array(	'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
					'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					#'TitCollectionTitle' => 'eluts:Collection Title',
					'CreCountry_tab' => 'eluts:Location',
				);

	var $LookupLists = array (
					'TitCollectionTitle' => 'Collection Title',
				);

} // End GalleryDetailedQueryForm class
?>
