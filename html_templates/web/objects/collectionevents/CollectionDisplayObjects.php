<?php
/********************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 ********************************************************/

/*  
 $Revision: 1.5 $
 $Date: 2012/02/08 05:20:53 $
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/ModuleDisplayObjects.php');


/*******************************************************
 *
 * class ModuleStandardDisplay extends ModuleBaseStandardDisplay
 *
 *
 ******************************************************/

class ModuleStandardDisplay extends ModuleBaseStandardDisplay
{
	var $Database = 'ecollectionevents';
	var $referer = '';

	var $HeaderField = 'LocPreciseLocation';
	var $mainField = 'LocPreciseLocation';
	var $subField = 'LocOcean';
	var $searchColumn = 'SummaryData';

	var $Fields = array(
			'irn_1',
			'ColCollectionType',
			'ColCollectionMethod',
			'LocOcean',
			'LocSeaGulf',
			'LocBaySound',
			'LocContinentalShelfRegion',
			'LocArchipelago',
			'LocIslandGrouping',
			'LocIslandName',
			'LocContinent',
			'LocCountry',
			'LocProvinceStateTerritory',
			'LocDistrictCountyShire',
			'LocTownship',
			'LocNearestNamedPlace',
			'LocSpecialGeographicUnit',
			'LocPreciseLocation',
		);
}

?>
