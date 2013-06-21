<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
MsimSimpleQueryForm extends BaseDetailedQueryForm
{
	function
	MsimSimpleQueryForm()
	{
		$earliestDate = new QueryField;
		$earliestDate->ColName = 'AssAssociationEarliestDate0';
		$earliestDate->ColType = 'date';

		$latestDate = new QueryField;
		$latestDate->ColName = 'AssAssociationLatestDate0';
		$latestdate->ColType = 'date';

	 	$this->Fields = array(	'ColCategory',
					'SubSubjects_tab|SubThemes_tab',
					'AssAssociationNameRef_tab->eparties->SummaryData',
					$earliestDate,
					$latestDate,
					'AssAssociationLocality_tab',
					//'LocCurrentLocationRef->elocations->SummaryData',
					);

		$this->Hints = array(	'ColCategory' => '[ Select from list using button ]',
					'AssAssociationNameRef_tab->eparties->SummaryData' => '[ Select from list using button ]',
					'SubSubjects_tab|SubThemes_tab' => '[ e.g. SCHIC: 4.4524 ]',
					'AssAssociationLocality_tab' => '[ e.g. Bury ]',
					'AssAssociationLatestDate0' => '[ e.g. 2002 or <1/1/2000 ]',
					'AssAssociationEarliestDate0' => '[ e.g. 1856 or >1/1/1900 ]',
					//'LocCurrentLocationRef->elocations->SummaryData' => '[ e.g. Basement, SMH ]',
					);


		$this->LookupLists = array(	
						'AssAssociationNameRef_tab->eparties->SummaryData' => 'Association Names',
						);

		$this->DropDownLists = array(
						'ColCategory' => 'eluts:Collection Category',
						);

		$this->BaseDetailedQueryForm();
	}

} // End MsimSimpleQueryForm class


class
MsimIntranetSimpleQueryForm extends BaseDetailedQueryForm
{
	function
	MsimIntranetSimpleQueryForm()
	{
		$earliestDate = new QueryField;
		$earliestDate->ColName = 'AssAssociationEarliestDate0';
		$earliestDate->ColType = 'date';

		$latestDate = new QueryField;
		$latestDate->ColName = 'AssAssociationLatestDate0';
		$latestdate->ColType = 'date';

	 	$this->Fields = array(	'ColCategory',
					'SubSubjects_tab|SubThemes_tab',
					'AssAssociationNameRef_tab->eparties->SummaryData',
					$earliestDate,
					$latestDate,
					'AssAssociationLocality_tab',
					'LocCurrentLocationRef->elocations->SummaryData',
					);

		$this->Hints = array(	'ColCategory' => '[ Select from list using button ]',
					'AssAssociationNameRef_tab->eparties->SummaryData' => '[ Select from list using button ]',
					'SubSubjects_tab|SubThemes_tab' => '[ e.g. SCHIC: 4.4524 ]',
					'AssAssociationLocality_tab' => '[ e.g. Bury ]',
					'AssAssociationLatestDate0' => '[ e.g. 2002 or <1/1/2000 ]',
					'AssAssociationEarliestDate0' => '[ e.g. 1856 or >1/1/1900 ]',
					'LocCurrentLocationRef->elocations->SummaryData' => '[ e.g. Basement, SMH ]',
					);


		$this->LookupLists = array(	
						'AssAssociationNameRef_tab->eparties->SummaryData' => 'Association Names',
						);

		$this->DropDownLists = array(
						'ColCategory' => 'eluts:Collection Category',
						);


		$this->BaseDetailedQueryForm();
	}

} // End MsimIntranetSimpleQueryForm class

?>
