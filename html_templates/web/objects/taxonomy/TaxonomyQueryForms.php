<?php
/*******************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *******************************************************/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/ModuleBasicQueryForm.php');
require_once ($WEB_ROOT . '/objects/common/ModuleAdvancedQueryForm.php');
require_once ($WEB_ROOT . '/objects/common/ModuleDetailedQueryForm.php');


class TaxonomyBasicQueryForm extends ModuleBaseBasicQueryForm
{
	var $phpSelf = 'TaxonomyQuery.php';

	// default levels to show and group by
	var $showLevels = array ( 'ClaScientificName','ClaPhylum','ClaClass','ClaOrder','ClaFamily', 'ClaGenus', 'ClaSpecies' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ClaOrder|ClaFamily|ClaGenus|ClaSpecies|ComName_tab|ClaScientificName',
		'Scientific&nbsp;Name' => 'ClaScientificName|ClaGenus|ClaSpecies',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
}  


class TaxonomyAdvancedQueryForm extends ModuleBaseAdvancedQueryForm
{
	var $phpSelf = 'TaxonomyQuery.php';

	// default levels to show and group by
	var $showLevels = array ('ClaScientificName', 'ClaPhylum','ClaClass','ClaOrder', 'ClaFamily', 'ClaGenus', 'ClaSpecies' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ClaOrder|ClaFamily|ClaGenus|ClaSpecies|ComName_tab|ClaScientificName',
		'Scientific&nbsp;Name' => 'ClaScientificName|ClaGenus|ClaSpecies',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
}  

class TaxonomyDetailedQueryForm extends ModuleBaseDetailedQueryForm
{
	var $phpSelf = 'TaxonomyQuery.php';

	// default levels to show and group by
	var $showLevels = array ( 'ClaScientificName','ClaPhylum','ClaClass','ClaOrder', 'ClaFamily', 'ClaGenus', 'ClaSpecies');
	var $Fields = array ( 	'ClaPhylum',
				'ClaClass',
				'ClaOrder',
				'ClaFamily',
				'ClaGenus',
				'ClaSpecies',
				'ComName_tab',
				'ClaScientificName',);
	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ClaOrder|ClaFamily|ClaGenus|ClaSpecies|ComName_tab|ClaScientificName',
		'Scientific&nbsp;Name' => 'ClaScientificName|ClaGenus|ClaSpecies',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
} 

?>
