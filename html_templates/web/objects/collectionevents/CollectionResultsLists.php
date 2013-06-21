<?php
/*****************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *****************************************************/
/*
 $Source: /home/cvs/emu/emu/master/web/objects/collectionevents/CollectionResultsLists.php,v $
 $Revision: 1.5 $
 $Date: 2012/02/08 05:20:53 $
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/ModuleResultsLists.php');


/*******************************************************
 *
 * class ModuleStandardResultsList extends 
 * ModuleBaseStandardResultsList
 *
 ******************************************************/

class
ModuleStandardResultsList extends ModuleBaseStandardResultsList
{
	var $searchColumn = 'SummaryData';
	var $Database = 'ecollectionevents';
	var $referer = '';

	# field(s) that link to record data
	var $linkFields = array( 
				'LocPreciseLocation', );
	
	# any field(s) to be displayed as merged single field
	var $mergedFields = array(
				'LocOcean',
				'LocSeaGulf',
				'LocCountry',
				'LocProvinceStateTerritory',
				'LocDistrictCountyShire', );
	
	var $standAloneFields = array(
			'irn_1',
			'LocOcean',
			'LocCountry', );

	var $Fields = array(
				'irn_1',
				'LocPreciseLocation',
				'LocOcean',
				'LocSeaGulf',
				'LocCountry',
				'LocProvinceStateTerritory',
				'LocDistrictCountyShire',
				);
}

?>
