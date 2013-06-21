<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
NpgBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					//'location' => 'elocations:SummaryData',
					);

}  // end NpgBasicQueryForm class

class
NpgAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry_tab',
					//'location' => 'LocCurrentLocationRef',
					//'location' => 'LocCurrentLocationRef->elocations->SummaryData',
					);

}  // end NpgAdvancedQueryForm class
	

class
NpgDetailedQueryForm extends BaseDetailedQueryForm
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

	var $Hints = array(	#'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
				#'TitCollectionTitle' 	=> '[ eg. Barry Humphries ]',
				#'CreSubjectClassification'=> '[ eg. Music ]',
				'PhyMediaCategory'	=> '[ Select from the list ]',
				'PhyMedium'		=> '[ Select from the list ]',
				#'CreCountry_tab'		=> '[ eg. USA ]',
				'CreDateCreated'	=> '[ eg. 1983 ]',
				#'PhyTechnique'		=> '[ eg. Hand Sewn ]',
				);

	var $DropDownLists = array(	'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
					'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					#'TitCollectionTitle' => 'eluts:Collection Title',
					'CreCountry_tab' => 'eluts:Creator Location',
				);

	var $LookupLists = array (
					'TitCollectionTitle' => 'Collection Title',
				);

} // End NpgDetailedQueryForm class
?>
