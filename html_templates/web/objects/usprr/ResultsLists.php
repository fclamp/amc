<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
UsprrStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'ColIsgnNo',
				'ObjKindOfObject',
				'ObjRockName',
				'LtyMountainNameIslandName',
				'LtyMountainRangeIslandGroup',
				'LtyRegion',
				'ColCollectorRef->eparties->SummaryData'
				);	
	
	var $Order = '+ColIsgnNo';
	var $OrderLimit = 1000;

} // end UsprrResultsList class

class
UsprrContactSheet extends BaseContactSheet
{
	var $Fields = array(	'ColIsgnNo',
				'ObjRockName',
				);	

} // end UsprrContactSheetResultsList class

?>
