<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
CmccBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
				);

	var $Lang= array(       '0' => 'English',
                                '1' => 'French',
                                );


}  // end CmccBasicQueryForm class

class
CmccAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'name' => 'ObjPopularName',
					'notes' => 'NotNotes',
					'maker' => 'CreMakerRef_tab',
					);

}  // end CmccAdvancedQueryForm class


class
CmccDetailedQueryForm extends BaseDetailedQueryForm
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

} // End CmccDetailedQueryForm class

?>
