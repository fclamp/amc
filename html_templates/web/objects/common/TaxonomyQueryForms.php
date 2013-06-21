<?php
/*******************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *******************************************************/

/*  
 $Revision: 1.7 $
 $Date: 2012-02-08 05:20:55 $
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/TaxonomyBaseQueryForms.php');


class TaxonomyBasicQueryForm extends TaxonomyBaseBasicQueryForm
{
	// default levels to show and group by
	var $showLevels = array ( 'ClaScientificName','ClaPhylum','ClaClass','ClaOrder','ClaFamily' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ClaOrder|ClaFamily|ClaGenus|ClaSpecies|ComName_tab|ClaScientificName',
		'Scientific&nbsp;Name' => 'ClaScientificName|ClaGenus|ClaSpecies',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
}  


class TaxonomyAdvancedQueryForm extends TaxonomyBaseAdvancedQueryForm
{
	// default levels to show and group by
	var $showLevels = array ('ClaScientificName', 'ClaPhylum','ClaClass','ClaOrder', 'ClaFamily' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ClaOrder|ClaFamily|ClaGenus|ClaSpecies|ComName_tab|ClaScientificName',
		'Scientific&nbsp;Name' => 'ClaScientificName|ClaGenus|ClaSpecies',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
}  

class TaxonomyDetailedQueryForm extends TaxonomyBaseDetailedQueryForm
{
	// default levels to show and group by
	var $showLevels = array ( 'ClaScientificName','ClaPhylum','ClaClass','ClaOrder', 'ClaFamily');

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ClaOrder|ClaFamily|ClaGenus|ClaSpecies|ComName_tab|ClaScientificName',
		'Scientific&nbsp;Name' => 'ClaScientificName|ClaGenus|ClaSpecies',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
}  
?>
