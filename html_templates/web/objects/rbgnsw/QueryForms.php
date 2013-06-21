<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
RbgBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'NSW Number' => 'irn',
					'collector' => 'CorCollectorRef_tab->eparties->SummaryData',
					'plant name' => 'IdePlantNameLocal',
					);

}  // end RbgBasicQueryForm class

class
RbgAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'NSW Number' => 'irn',
					'collector' => 'CorCollectorRef_tab->eparties->SummaryData',
					'plant name' => 'IdePlantNameLocal',
					);

}  // end RbgAdvancedQueryForm class
	

class
RbgDetailedQueryForm extends BaseDetailedQueryForm
{
	var $Fields = array(	'IdePlantNameLocal',
				'irn',
				'IdeDeterminavitRef_nesttab->eparties->SummaryData',
				'CorNative',
				'CorCultivated',
				'CorCollectorRef_tab->eparties->SummaryData',
				'SitSiteRef->eparties->SummaryData',
				'NotNotes',
				);
	var $Hints = array(	'IdePlantNameLocal'	=> '[ eg Acacia blah blah blah ]',
				'irn'		=> '[ for NSW1234, type 1234 ]',
				'CorDonor'	=> '[ Select from list ]',
				'CorCultivated'	=> '[ Select from list ]',
				);

	var $DropDownLists = array(	'CorNative' => 'eluts:Native',
					'CorCultivated' => 'eluts:Cultivated',
				);

} // End RbgDetailedQueryForm class
?>
