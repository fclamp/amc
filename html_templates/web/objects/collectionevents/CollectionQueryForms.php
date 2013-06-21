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


class CollectionBasicQueryForm extends ModuleBaseBasicQueryForm
{
	var $phpSelf = 'CollectionQuery.php';

	// default levels to show and group by
	var $showLevels = array ( 'LocCountry','LocOcean','LocPreciseLocation','LocSeaGulf','LocProvinceStateTerritory','LocDistrictCountyShire' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|LocCountry|LocOcean|LocPreciseLocation|LocSeaGulf|LocProvinceStateTerritory|LocDistrictCountyShire',
		'Country' => 'LocCountry',
		'Ocean' => 'LocOcean',
		'Location' => 'LocPreciseLocation',
	);
}  


class CollectionAdvancedQueryForm extends ModuleBaseAdvancedQueryForm
{
	var $phpSelf = 'CollectionQuery.php';

	// default levels to show and group by
	var $showLevels = array ( 'LocCountry','LocOcean','LocPreciseLocation','LocSeaGulf','LocProvinceStateTerritory','LocDistrictCountyShire' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|LocCountry|LocOcean|LocPreciseLocation|LocSeaGulf|LocProvinceStateTerritory|LocDistrictCountyShire',
		'Country' => 'LocCountry',
		'Ocean' => 'LocOcean',
		'Location' => 'LocPreciseLocation',
	);
}  

class CollectionDetailedQueryForm extends ModuleBaseDetailedQueryForm
{
	var $phpSelf = 'CollectionQuery.php';

	// default levels to show and group by
	var $showLevels = array ( 'LocCountry','LocOcean','LocPreciseLocation','LocSeaGulf','LocProvinceStateTerritory','LocDistrictCountyShire' );

	var $showSummary = 0;

	var $Options = array(		
		'Anywhere' => 'SummaryData|LocCountry|LocOcean|LocPreciseLocation|LocSeaGulf|LocProvinceStateTerritory|LocDistrictCountyShire',
		'Country' => 'LocCountry',
		'Ocean' => 'LocOcean',
		'Location' => 'LocPreciseLocation',
	);
} 

?>
