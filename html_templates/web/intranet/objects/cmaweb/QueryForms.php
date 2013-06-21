<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
CmaBasicQueryForm extends BaseBasicQueryForm
{

  	var $Options = array(	'any' => 'AdmWebMetadata|TitAccessionNo|CreCreatorLocal_tab',
  					'accession' => 'TitAccessionNo',
  					'dept' => 'CatDepartment',
  					'class' => 'PhyMediumCategory',
  					'title' => 'TitMainTitle|TitTitleNotes',
  					'creator' => 'CreCreatorLocal_tab',
  					'credit' => 'AcqCreditLine',
  					'type' => 'CatType',
  					);
}  // end CmaBasicQueryForm class

class
CmaAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any' => 'AdmWebMetadata|TitAccessionNo|CreCreatorLocal_tab',
					'type' => 'CatType',
					'coll' => 'TitCollectionTitle',
					'accession' => 'TitAccessionNo',
					'dept' => 'CatDepartment',
				 	'class' => 'PhyMediumCategory',
					'creator' => 'CreCreatorLocal_tab',
					'title' => 'TitMainTitle|TitTitleNotes',
					'credit' => 'AcqCreditLine',
					'date' => 'CreDateCreated',
					'early' => 'CreEarliestDate',
					'late' => 'CreLatestDate',
					'century' => 'CreCentury',
					'loc' => 'LocCurrentLocationLocal',
					'media' => 'PhyMedium_tab',
					'process' => 'PhyTechnique',
					'subjects' => 'CatSubject',
					'style' => 'CatStyle',
					);

}  // end CmaAdvancedQueryForm class
	

class
CmaDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	CmaDetailedQueryForm()
	{
		$earliest = new QueryField;
		$earliest->ColName = 'CreEarliestDate';
		$earliest->ColType = 'date';

		$latest = new QueryField;
		$latest->ColName = 'CreLatestDate';
		$latest->ColType = 'date';
		
		$this->Fields = array(	'CatType',
					'TitCollectionTitle',
					'TitAccessionNo',
					'CatDepartment',
					'PhyMediumCategory',
					'CreCreatorLocal_tab',
					'TitMainTitle',
					'AcqCreditLine',
					'CreDateCreated',
					$earliest,
					$latest,
					'CreCentury',
					'LocCurrentLocationLocal',
					'PhyMedium_tab',
					'PhyTechnique',
					'CatSubject',
					'CatStyle',
					);

		$this->Hints = array(	$earliest->ColName	=> '[ e.g. 1900; <1900 (before 1900); >1900 (after 1900); >1900<1910 (between 1900 and 1910) ]',
					$latest->ColName	=> '[ e.g. 1900; <1900 (before 1900); >1900 (after 1900); >1900<1910 (between 1900 and 1910) ]',
					'CreSubjectClassification'=> '[ eg. Music ]',
					'CreCountry:1'		=> '[ eg. USA ]',
					'CreDateCreated'	=> '[ eg. 1983 ]',
					);

		$this->DropDownLists = array(
						'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
						'CreCentury'	=> ' |21|20|19|18|17|16|15|14|13|12|11|10|9|8|7|6|5|4|3|2|1|BCE',
						'CatDepartment' => 'eluts:Department',
						'CatType' => 'eluts:Type',
						'PhyMediumCategory' => 'eluts:MediumCategory',
						'CreCountry_tab' => 'eluts:Location',
					);

		$this->LookupLists = array (
						'TitCollectionTitle' => 'Collection Title',
					);

		$this->BaseDetailedQueryForm();
	}		

} // End CmaDetailedQueryForm class
?>
