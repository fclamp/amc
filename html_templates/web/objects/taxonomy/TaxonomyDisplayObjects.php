<?php
/********************************************************
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 ********************************************************/

/*  
 $Revision: 1.5 $
 $Date: 2012/02/08 05:21:06 $
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
	var $Database = 'etaxonomy';
	var $referer = '';

	var $HeaderField = 'ClaScientificName';
	var $mainField = 'ClaScientificName';
	var $subField = 'ComName:1';
	var $searchColumn = 'DarScientificName';

	var $Fields = array(
			'ClaFamily',
			'ClaOrder',
			'ClaClass',
			'ClaPhylum',
			'ClaHybridType',
			'ClaHybridRank',
			'ClaScientificNameAuto',
			'ClaKingdom',
			'ClaSubphylum',
			'ClaSuperclass',
			'ClaSubclass',
			'ClaInfraclass',
			'ClaSuperorder',
			'ClaSuborder',
			'ClaInfraorder',
			'ClaSuperfamily',
			'ClaFamilyNumber',
			'ClaGenus',
			'ClaGenusNumber',
			'ClaSubgenus',
			'ClaSpecies',
			'ClaSubspecies',
			'ClaOtherRank_tab',
			'ClaOtherValue_tab',
			'ClaRank',
			'ClaGroup',
			'ClaPublicationAuthor',
			'ClaPublicationYear',
			'ClaScientificName',
			'SynKind_tab',
			'AutAuthorString',
			'AutCombAuthorsRole_tab',
			'ClaCurrentlyAccepted',
			'ClaCultivar',
			'ClaCultivarName',
			'ClaApplicableCode',
			'ClaHybrid',
			'CitLocality_tab',
			'CitRemarks_tab',
			'ComName_tab',
			'ComGeographicLocation_tab',
			'ComLanguage_tab',
			'NotNotes',
		);
}

?>
