<?php

/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/



if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


// search narrative via basic query form 
class
NarPhmDetailedNarrativeQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(
			'NarTitle',
			);

} 



// search objects via detailed query form 
class
NarPhmDetailedObjectQueryForm extends BaseDetailedQueryForm 
{
	// this is set in the pages directory


} 



?>
