<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');
require_once ('DefaultPaths.php');

class
GalleryBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'Description' => 'PhyDescription',
					'SubjectClassification' => 'CreSubjectClassification_tab',
					'Significance' => 'CreSignificance',
					'Provenance' => 'CreProvenance',
					);

}  // end GalleryBasicQueryForm class

class
GalleryAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'TitMainTitle|TitTitleNotes',
					'Description' => 'PhyDescription',
					'SubjectClassification' => 'CreSubjectClassification_tab',
					'Significance' => 'CreSignificance',
					'Provenance' => 'CreProvenance',
					);

}  // end GalleryAdvancedQueryForm class
	

class
GalleryDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	
				'TitDivision',
				'TitCollection',
				'TitSubCollection',
				'TitAccessionNo',
				'TitObjectStatus',
				'TitMainTitle',
				'CreCreatorLocal_tab',
				'CreDateCreated',
				'PhyDescription',
				'CreSignificance',
				'TitObjectType',
				'CreSubjectClassification_tab',
				'SOURCEVENDOR',
				'LocCurrentLocationRef->elocations->SummaryData',
				'CreProvenance',
				'INTERVIEWED',
				'OraSummary',
				);

	var $DropDownLists = array(	'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					'TitDivision' => 'eluts:Division',
					'TitCollection' => 'eluts:Division[2]',
					'TitSubCollection' => 'eluts:Division[3]',
					'TitObjectStatus' => 'eluts:Object Status',
				);

	var $LookupLists = array (
					'TitPrimaryClassification' => 'Primary Classification',
				);

} // End GalleryDetailedQueryForm class
?>
