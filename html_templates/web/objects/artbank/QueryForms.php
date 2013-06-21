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
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					);

}  // end GalleryBasicQueryForm class

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
GalleryDetailedQueryForm extends BaseDetailedQueryForm
{



	var $Hints = array(	
				'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
				'PhyCollectionArea'	=> '[ Select from the list ]',
				'CreSubjectClassification_tab'  => '[ Select from the list ]',
				'PhyMedium'		=> '[ eg. oil, acrylic, paper, canvas ]',
				'CreDateCreated'	=> '[ eg. 1983 ]',

				);


	var $DropDownLists = array(	
					'PhyCollectionArea' => 'eluts:Collection Area[1]',
					'CreSubjectClassification_tab'	=> 'eluts:Subject Classification',
					'TitObjectStatus'	=> 'eluts:Object Status',
				);



} // End GalleryDetailedQueryForm class
?>


