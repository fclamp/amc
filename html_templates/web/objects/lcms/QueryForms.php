<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
LcmsBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
//				'taxonomy' => 'TaxTaxonomyLocal|IdeTypeStatus_tab',
//				'notes' => 'NotNotes',
//				'place' => 'SitSiteLocal_tab',
				);

}  // end LcmsBasicQueryForm class

class
LcmsAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
//				'taxonomy' => 'TaxTaxonomyLocal|IdeTypeStatus_tab',
//				'notes' => 'NotNotes',
//				'place' => 'SitSiteLocal_tab',
				);

}  // end LcmsAdvancedQueryForm class
	

class
LcmsDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	LcmsDetailedQueryForm()
	{
		$dateCollectedFrom = new QueryField;
		$dateCollectedFrom->ColName = 'LocDateCollectedFrom';
		$dateCollectedFrom->ColType = 'date';

		$identificationDate = new QueryField;
		$identificationDate->ColName = 'IdeDateIdentified0';
		$identificationDate->ColType = 'date';

		$acqDetails = new QueryField;
		$acqDetails->ColName = 'ColProvenanceRef_tab->eparties->SummaryData|AccAccessionLotLocal';


		$this->Fields = array(	
				//reminder
				//'LocCollectorsRef_tab->eparties->SummaryData',
				//$dateCollectedFrom,


				//Object Name
				'ClaObjectName_tab',
				//Accession Number
				'ColAccessionNumber',
				//Collection Title
				'ColCollectionName_tab',
				//Creator
				//Date Created
				'ProProductionDate',
				//Medium->change to materials??
				'MatPrimaryMaterials_tab',
				'MatSecondaryMaterials_tab',
				//Media Catagory
				//Inscription
				'DesInscriptions',
				//Location
				//Notes
				'NotNotes',
				);

		$this->Hints = array(
				'ClaObjectName_tab' => '[ e.g. An object name  ]',
				'ColAccessionNumber' => '[ e.g. An accession number  ]',
				'IdeIdentifiedByRef_tab->eparties->SummaryData' => '[ e.g. Alan Newton ]',
				);

		$this->DropDownLists = array(	
				//		'CreCountry_tab' => 'eluts:Location',
				//		'IdeTypeStatus_tab' => 'eluts:Type Status',
					);

		$this->LookupLists = array (
			//		'ColCollectionName_tab' => 'Collection Name',
					);

		$this->BaseDetailedQueryForm();
	}

} // End LcmsDetailedQueryForm class
?>
