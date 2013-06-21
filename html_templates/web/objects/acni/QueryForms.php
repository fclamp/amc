<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
AcniBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle',
					'artist' => 'CreCreatorLocal_tab',
					);

}  // end AcniBasicQueryForm class

class
AcniAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle',
					'artist' => 'CreCreatorRefLocal_tab',
					);

}  // end AcniAdvancedQueryForm class
	

class
AcniDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	'TitMainTitle',
				'CreDateCreated',
				'TitAccessionDate',
				'PhyMedium_tab',
				'PhyMaterial_tab',
				'CreCreatorLocal_tab',
				);

	/*var $Hints = array(	'TitMainTitle' 		=> '[ eg. The Cat in the hat ]',
				'TitCollectionTitle' 	=> '[ eg. Barry Humphries ]',
				'CreSubjectClassification_tab'=> '[ eg. Music ]',
				'PhyMedium_tab'		=> '[ Select from the list ]',
				'CreDateCreated'	=> '[ eg. 1983 ]',
				'PhyTechnique_tab'		=> '[ eg. Hand Sewn ]',
				);

	var $DropDownLists = array(	'PhyMedium_tab' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					'PhyTechnique_tab' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					#'TitCollectionTitle' => 'eluts:Collection Title',
				);

	var $LookupLists = array (
					'TitCollectionTitle' => 'Collection Title',
				);*/

} // End AcniDetailedQueryForm class
?>
