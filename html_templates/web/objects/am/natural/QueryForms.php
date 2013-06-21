<?php
/*
*  Copyright (c) KE Software Pty Ltd - 2001
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
AmBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'ScientificName' => 'QuiTaxonomyFamily|QuiTaxonomyGenus|QuiTaxonomySpecies',
					);

}  // end AmBasicQueryForm class

class
AmAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
				'title' => 'TitMainTitle|TitTitleNotes',
				'notes' => 'NotNotes|TitTitleNotes',
				'artist' => 'CreCreatorRefLocal_tab',
				'place' => 'CreCountry_tab',
					);

}  // end AmAdvancedQueryForm class
	

class
AmDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	'SummaryData',
				'QuiCountryLocal',
				'QuiNearestNamedLocal',
				'QuiTaxonomyPhylum',
				'QuiTaxonomyClass',
				'QuiTaxonomyOrder',
				'QuiTaxonomyFamily',
				'QuiTaxonomyGenus',
				'QuiTaxonomySpecies',
				);

	var $Hints = array(	'SummaryData' 		=> '[ eg. The Cat in the hat ]',
				'QuiCountryLocal' 	=> '[ eg. Barry Humphries ]',
				'QuiNearestNamedLocal'=> '[ eg. Music ]',
				'QuiTaxonomyPhylum'	=> '[ Select from the list ]',
				'QuiTaxonomyClass'	=> '[ Select from the list ]',
				'QuiTaxonomyOrder'	=> '[ eg. USA ]',
				'QuiTaxonomyFamily'	=> '[ eg. 1983 ]',
				'QuiTaxonomyGenus'	=> '[ eg. Hand Sewn ]',
				'QuiTaxonomySpecies'	=> '[ eg. Hand Sewn ]',
				);

	var $DropDownLists = array(	'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
					'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					'CreCountry_tab' => 'eluts:Location',
				);

	var $LookupLists = array (
					'TitCollectionTitle' => 'Collection Title',
				);

} // End AmDetailedQueryForm class
?>
