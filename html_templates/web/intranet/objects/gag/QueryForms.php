<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

$BACKEND_TYPE = "gag";

$DEFAULT_DISPLAY_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Display.php";
$DEFAULT_PARTY_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/PartyDisplay.php";
$DEFAULT_CONTACT_SHEET_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/ContactSheet.php";
$DEFAULT_QUERY_PAGE             = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Query.php";
$DEFAULT_RESULTS_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/ResultsList.php";
$DEFAULT_IMAGE_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/common/imagedisplay.php";
$STRINGS_DIR            = "$WEB_ROOT/intranet/objects/$BACKEND_TYPE/strings/";


class
GalleryEventBasicQueryForm extends BaseBasicQueryForm
{
	var $Options = array(	'any' => 'SummaryData'
					#'title' => 'TitMainTitle|TitTitleNotes',
					#'notes' => 'NotNotes|TitTitleNotes',
					#'artist' => 'CreCreatorLocal_tab',
					#'place' => 'CreCountry_tab',
					);

}  // end GalleryBasicQueryForm class
class
GalleryBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					#'exhibitions' => 'eevents:SummaryData',
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

	var $Fields = array(	
				'CreCreatorLocal_tab',
				'TitMainTitle',
				'CreDateCreated',
				'CreCountry_tab|CreState_tab|CreDistrict_tab|CreCity_tab',
				'PhyCollectionArea',
				'PhyMedium',
				'PhyMediaCategory',
				'TitAccessionNo',
				'CreSubjectClassification_tab',
				'LocCurrentLocationRef->elocations->SummaryData',
				'AccCreditLineLocal',

				//'TitCollectionTitle',
				//'TitTitleNotes',
				//'CreCountry_tab',
				//'PhyTechnique',
				//'NotNotes',
				);

	var $Hints = array(	'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
				'TitCollectionTitle' 	=> '[ eg. Barry Humphries ]',
				'CreCreatorLocal_tab' 	=> '[ eg. Florence Royce ]',
				'CreSubjectClassification_tab'=> '[ eg. Music ]',
				'PhyMedium'	=> '[ eg. gouache, linout ]',
				'PhyCollectionArea'	=> '[ Select from the list ]',
				'PhyMediaCategory'	=> '[ Select from the list ]',
				'CreCountry_tab|CreState_tab|CreDistrict_tab|CreCity_tab'	=> '[ Select from the list ]',
				//'PhyMedium'		=> '[ Select from the list ]',
				'CreCountry:1'		=> '[ eg. USA ]',
				'CreDateCreated'	=> '[ eg. 1983 ]',
				'PhyTechnique'		=> '[ eg. Hand Sewn ]',
				);

	var $DropDownLists = array(	//'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					//'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
					'PhyMediaCategory' => 'eluts:Collection Area[2]',
					'PhyCollectionArea' => 'eluts:Collection Area[1]',
					'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					//'TitCollectionTitle' => 'eluts:Collection Title',
					'CreCountry_tab|CreState_tab|CreDistrict_tab|CreCity_tab' => 'eluts:Location',
					//'CreSubjectClassification_tab' => 'eluts:Subject Classification',
				);

	var $LookupLists = array (
					//'TitCollectionTitle' => 'Collection Title',
				);

} // End GalleryDetailedQueryForm class
?>
