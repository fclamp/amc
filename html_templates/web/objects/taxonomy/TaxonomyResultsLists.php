<?php
/*****************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *****************************************************/
/*
 $Source: /home/cvs/emu/emu/master/web/objects/taxonomy/TaxonomyResultsLists.php,v $
 $Revision: 1.5 $
 $Date: 2012/02/08 05:21:06 $
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
	var $searchColumn = 'DarScientificName';
	var $Database = 'etaxonomy';
	var $referer = '';

	# field(s) that link to record data
	var $linkFields = array( 
				'ClaScientificName' );
	
	# any field(s) to be displayed as merged single field
	var $mergedFields = array( 
				'ClaPhylum', 
				'ClaClass', 
				'ClaOrder',
				'ClaFamily',); 
	var $standAloneFields = array(
				'ClaCurrentlyAccepted',
				'ComName:1',
				);

	var $Fields = array(
				'irn_1',
				'ClaScientificName',
				'ClaPhylum',
				'ClaClass',
				'ClaOrder',
				'ClaFamily',
				'ClaGenus',
				'ClaSpecies',
				'ComName:1',
				'ClaCurrentlyAccepted',
				'ClaRank',
			);
}

?>
