<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
cmhcBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata'
					);

}  // end GalleryBasicQueryForm class

class
cmhcAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'Title' => 'ObjTitle',
					'Description' => 'ObjDescription_tab',
					'Photograhper' => 'ObjPhotographerRef_tab->eparties->SummaryData',
					'City' => 'ObjLocation_tab',
					);

}  // end cmhcAdvancedQueryForm class
	

class
cmhcDetailedQueryForm extends BaseDetailedQueryForm
{


	var $Fields = array(	'ObjTitle',
				'ObjDescription_tab',
				'ObjPhotographerRef_tab->eparties->SummaryData',
				'ObjAccessionNumber',
				'ObjDateOfObject',
				);

	var $Hints = array(	'ObjTitle' 		=> '[ eq. Camrose ]',
				'ObjDescription_tab' 	=> '[ eg. diagrams ]',
				'ObjPhotographerRef_tab->eparties->SummaryData'	=> '[ eg. John Smith ]',
				'ObjAccessionNumber'	=> '[ Any Numeric Value ]',
				'ObjDateOfObject'	=> '[ eg. 1983 ]',
				);

	var $DropDownLists = array(
				);

	var $LookupLists = array (
				);

} // End cmhcDetailedQueryForm class
?>
