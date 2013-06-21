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
					'title' => 'ObjTitle',
					'briefdescription' => 'ObjBriefDescription',
					'itemhistory' => 'ObjBriefHistory',
					'creator' => 'CreArtistsDetailsRef_tab->eparties->SummaryData',
					//'location' => 'elocations:SummaryData',
					);
}  // end GalleryBasicQueryForm class

class
GalleryAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'ObjTitle',
					'briefdescription' => 'ObjBriefDescription',
					'itemhistory' => 'ObjBriefHistory',
					'creator' => 'CreArtistsDetailsRef_tab->eparties->SummaryData',
					//'location' => 'LocCurrentLocationRef',
					//'location' => 'LocCurrentLocationRef->elocations->SummaryData',
					);

}  // end GalleryAdvancedQueryForm class
	

class
GalleryDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	'ObjTitle',
				'ObjRegistrationNumber',
				'ObjClassification',
				'ObjBriefDescription',
				'ObjInscriptions',
				'ObjBriefHistory',
				'CreDateOfObject',
				'CreArtistsDetailsRef_tab->eparties->SummaryData',
				'ObjCreditLine',
				'CreKeywords_tab',
#				'LocCurrentLocationRef->elocations->SummaryData',
				);

	var $Hints = array(	'ObjCollectionName' 		=> '[ eg. Barry Humphries Collection ]',
				'ObjCollectionName' 	=> '[ eg. Barry Humphries ]',
				'CreSubject'=> '	    [ eg. Theatre - Australian ]',
				);

	var $DropDownLists = array(	
				);

	var $LookupLists = array (
					'ObjCollectionName' => 'Collection Name',
				);

} // End GalleryDetailedQueryForm class
?>
