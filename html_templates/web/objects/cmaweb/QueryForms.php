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

  	var $Options = array(	'any' => 'AdmWebMetadata|CreCreatorLocal_tab',
  					'class' => 'PhyMediumCategory',
  					'title' => 'TitMainTitle|TitTitleNotes',
  					'creator' => 'CreCreatorLocal_tab',
					'desc' => 'PhyMediumComments'
  					);

			
}  // end CmaBasicQueryForm class

class
CmaAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any' => 'AdmWebMetadata|CreCreatorLocal_tab',
					'coll' => 'TitCollectionTitle',
				 	'class' => 'PhyMediumCategory',
					'creator' => 'CreCreatorLocal_tab',
					'nationality' => 'CreCreatorNationalityLocal_tab',
					'title' => 'TitMainTitle|TitTitleNotes',
					'date' => 'CreDateCreated',
					'desc' => 'PhyMediumComments',
					'subjects' => 'CatSubject_tab',
					'style' => 'CatStyle_tab'
					);

}  // end CmaAdvancedQueryForm class
	

class
CmaDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	CmaDetailedQueryForm()
	{
		
		$this->Fields = array(	'TitCollectionTitle',
					'PhyMediumComments',
					'CreCreatorLocal_tab',
					'CreCreatorNationalityLocal_tab',
					'TitMainTitle',
					'CreDateCreated',
					'PhyMediumCategory',
					'CatSubject_tab',
					'CatStyle_tab',
					);

		$this->Hints = array(
					'CreSubjectClassification'=> '[ eg. Music ]',
					'CreCountry:1'		=> '[ eg. USA ]',
					'CreDateCreated'	=> '[ eg. 1983 ]',
					);

		$this->DropDownLists = array(
						'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
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
