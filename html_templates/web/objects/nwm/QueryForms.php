<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
GalleryBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'ObjObjectName|ObjBriefDescription',
					'notes' => 'NotNotes|ObjBriefDescription',
					//'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry',
					);

}  // end GalleryBasicQueryForm class

class
GalleryAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'ObjObjectName|ObjBriefDescription',
					'notes' => 'NotNotes|ObjBriefDescription',
					//'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry',
					);

}  // end GalleryAdvancedQueryForm class
	

class
GalleryDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	'ObjObjectName',
				'ObjBriefDescription',
				'ObjObjectType',
				'ObjPrimaryClassification',
				'ObjCollectionType',
				'ObjCollectionName',
				//'CreCreatorLocal_tab',
				//'LocCurrentLocationRef->elocations->SummaryData',
				'AccLotNumberLocal',
				'CreDateOfObject',
				'CreCountry',
				'CreMethod_tab',
				'NotNotes',
				'CreMaterials',
				);

	var $Hints = array(	'ObjObjectName' 		=> '[ eg. Press ]',
				'ObjBriefDescription' 	=> '[ eg. Press ]',
				'ObjPrimaryClassification'=> '[ eg.  ]',
				//'PhyMediaCategory'	=> '[ Select from the list ]',
				//'PhyMedium'		=> '[ Select from the list ]',
				'CreCountry'		=> '[ eg. USA ]',
				'CreDateOfObject'	=> '[ eg. 1983 ]',
				'CreMaterials'		=> '[ eg. Hand Sewn ]',
				);

	var $DropDownLists = array(	//'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					//'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
					//'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					//#'ObjBriefDescription' => 'eluts:Collection Title',
					'CreCountry' => 'eluts:Location',
				);

	var $LookupLists = array (
					'ObjObjectType' => 'Object Type',
				);

} // End GalleryDetailedQueryForm class
?>
