<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
MsimBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any'		=> 'SummaryData|AdmWebMetadata',
				'objects'	=> 'ClaObjectName|ClaObjectSummary',
				'classification'=> 'ClaPrimaryClassification|ClaSecondaryClassification|ClaTertiaryClassification|SubSubjects_tab|SubThemes_tab',
				'realname'	=> 'AssAssociationNameRef_tab',
				);

}  // end MsimBasicQueryForm class

class
MsimNarrativeQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any'		=> 'SummaryData|AdmWebMetadata|NarTitle|NarNarrative',
				);

}  // end MsimBasicQueryForm class


class
MsimAdvancedQueryForm extends BaseAdvancedQueryForm
{
		var $Options = array(	'any'		=> 'SummaryData|AdmWebMetadata',
					'objects'	=> 'ClaObjectName|ClaObjectSummary',
					'classification'=> 'ClaPrimaryClassification|ClaSecondaryClassification|ClaTertiaryClassification|SubSubjects_tab|SubThemes_tab',
					'realname'	=> 'AssAssociationNameRef_tab',
					);

}  // end MsimAdvancedQueryForm class
	

class
MsimDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	MsimDetailedQueryForm()
	{

		$earliestDate = new QueryField;
		$earliestDate->ColName = 'AssAssociationEarliestDate0';
		$earliestDate->ColType = 'date';

		$latestDate = new QueryField;
		$latestDate->ColName = 'AssAssociationLatestDate0';
		$latestDate->ColType = 'date';

	 	$this->Fields = array(	'ColCategory',
					'SubSubjects_tab',
					'ColTypeOfItem',
					'ColRegNumber',
					'ColCollectionName_tab',
					'ClaObjectName',
					'ClaBrandName',
					'ClaModelNameNo_tab',
					'ClaPatentNumber_tab',
					'ClaDesignRegNo_tab',
					'AssAssociationType_tab',
					'AssAssociationNameRef_tab->eparties->SummaryData',
					'AssAssociationLocality_tab|AssAssociationCountry_tab',
					$earliestDate,
					$latestDate,
					'AssAssociationDate_tab',
					'LocCurrentLocationRef->elocations->SummaryData',
					
					);

		$this->Hints = array(	'ColCategory' => '[ Select from list ]',
					'SubSubjects_tab' => '[ e.g. electricity, Peterloo Massacre]',
					'ColTypeOfItem' => '[ Select from list ]',
					'ColRegNumber' => '[ e.g. "1966.28.6" ]',
					'ColCollectionName_tab' => '[ Select from list ]',
					'ClaObjectName' => '[ e.g. microscope, photograph ]',
					'ClaModelNameNo_tab' => '[ e.g. Brownie (as in Kodak Brownie) ]',
					'ClaBrandName' => '[ Select from list using button ]',
					'AssAssociationNameRef_tab->eparties->SummaryData' => '[ Select from list using button ]',
					'AssAssociationDate' => '[ e.g. 1880 ]',
					'AssAssociationLocality_tab|AssAssociationCountry_tab' => '[ e.g. Name of town/city or country ]',
					'AssAssociationLatestDate0' => '[ e.g. 2002 or <1/1/2000 ]',
					'AssAssociationEarliestDate0' => '[ e.g. 1856 or >1/1/1900 ]',
					'AssAssociationDate_tab' => '[ e.g. 1856 ]',
					'LocCurrentLocationRef->elocations->SummaryData' => '[ Select from list using button ]',
					);

		$this->DropDownLists = array(	'ColCollectionName_tab' => 'eluts:Collection Category[2]',
						'ColCategory' => '|Archive|Object',
						'ColTypeOfItem' => '|Document|Image|Moving image, no sound|Moving image, with sound|Object|Reproduction|Sound|Still image|Virtual',
						'AssAssociationType_tab' => 'eluts:Association Type',
						);

		$this->LookupLists = array(	
						'AssAssociationNameRef_tab->eparties->SummaryData' => 'Association Names',

						'ClaBrandName' => 'Brand Name',
						'LocCurrentLocationRef->elocations->SummaryData' => 'Location Hierarchy[1]',
						//'ColTypeOfItem' => 'Type of item',
						);

		$this->BaseDetailedQueryForm();
	}

} // End MsimDetailedQueryForm class



class
MsimIntranetDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	MsimIntranetDetailedQueryForm()
	{

		$this->Intranet = 1;
		
		$earliestDate = new QueryField;
		$earliestDate->ColName = 'AssAssociationEarliestDate0';
		$earliestDate->ColType = 'date';

		$latestDate = new QueryField;
		$latestDate->ColName = 'AssAssociationLatestDate0';
		$latestdate->ColType = 'date';

	 	$this->Fields = array(	'ColCategory',
					'ColRegNumber',
					'ColCollectionName_tab',
					'ClaObjectName',
					'ClaBrandName',
					'ClaModelNameNo_tab',
					'ClaPatentNumber_tab',
					'ClaDesignRegNo_tab',
					'AssAssociationNameRef_tab->eparties->SummaryData',
					'AssAssociationLocality_tab|AssAssociationCountry_tab',
					$earliestDate,
					$latestDate,
					'AssAssociationDate_tab',
					'LocCurrentLocationRef->elocations->SummaryData',
					);

		$this->Hints = array(	'ColCategory' => '[Select from list using button ]',
					'ColRegNumber' => '[ e.g. "1966.28.6" ]',
					'ColCollectionName_tab' => '[ Select from list ]',
					'ClaObjectName' => '[ e.g. microscope, photograph ]',
					'ClaBrandName' => '[ e.g. Brownie (as in Kodak Brownie) ]',
					'AssAssociationNameRef_tab->eparties->SummaryData' => '[ Select from list using button ]',
					'AssAssociationDate' => '[ e.g. 1880 ]',
					'AssAssociationLocality_tab|AssAssociationCountry_tab' => '[ e.g. Bury ]',
					'AssAssociationLatestDate0' => '[ e.g. 2002 or <1/1/2000 ]',
					'AssAssociationEarliestDate0' => '[ e.g. 1856 or >1/1/1900 ]',
					'AssAssociationDate_tab' => '[ e.g. 1856 ]',
					'LocCurrentLocationRef->elocations->SummaryData' => '[ e.g. Basement, SMH ]',
					);

		$this->DropDownLists = array(	'ColCollectionName_tab' => 'eluts:Collection Name',
						);

		$this->LookupLists = array(	'ColCategory' => 'Collection Category',
						'AssAssociationNameRef_tab->eparties->SummaryData' => 'Association Names',
						);

		$this->BaseDetailedQueryForm();

	}

} // End MsimIntranetDetailedQueryForm class


?>
