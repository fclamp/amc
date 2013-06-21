<?php
/*******************************************************
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 *******************************************************/

/*  
 $Revision: 1.3 $
 $Date: 2009/01/28 22:03:49 $
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/TaxonomyQueryForms.php');
require_once ('DefaultPaths.php');


class AmnhTaxonomyBasicQueryForm  extends TaxonomyBasicQueryForm 
{
	// default levels to show and group by
	//var $showLevels = array ( 'ClaScientificName','ClaPhylum','ClaClass','ClaOrder','ClaFamily' );

	//var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|ComName_tab|ClaScientificName', 'Scientific&nbsp;Name' => 'ClaScientificName',
		'Family' => 'ClaFamily',
		'Order' => 'ClaOrder',
	);
	var $Restriction = "EXISTS (SecDepartment_tab where SecDepartment = 'Mammalogy')";
}  


class AmnhTaxonomyAdvancedQueryForm extends TaxonomyAdvancedQueryForm
{

	var $Options = array(		
				'Anywhere' => 'SummaryData|ComName_tab|ClaScientificName', 
				'Scientific&nbsp;Name' => 'ClaScientificName',
				'Family' => 'ClaFamily',
				'Order' => 'ClaOrder',
	);
	var $Restriction = "EXISTS (SecDepartment_tab where SecDepartment = 'Mammalogy')";
}  

class AmnhTaxonomyDetailedQueryForm extends TaxonomyDetailedQueryForm 
{
	// default levels to show and group by
	//var $showSummary = 0;
	var $Fields = array (   
				'ClaScientificName',
				'ClaOrder',
				'ClaFamily',
				'ClaSubfamily',
				'ClaGenus',
				'ClaSpecies',
				'ClaSubspecies',
				'ComName_tab',
				'SummaryData',);

	var $DropDownLists = array (
				'ClaOrder' => 'eluts:Taxonomy[9]',
				);

	var $LookupLists = array (
				'ClaFamily' => 'Taxonomy[14]',
				'ClaSubfamily' => 'Taxonomy[15]',
				'ClaGenus' => 'Taxonomy[19]',
				'ClaSpecies' => 'Taxonomy[22]',
				'ClaSubspecies' => 'Taxonomy[23]',
				);
	var $LookupRestrictions = array (
				'Taxonomy' => "(Value050='Mammalia')",
				);
	var $Restriction = "EXISTS (SecDepartment_tab where SecDepartment = 'Mammalogy')";
}  
?>
