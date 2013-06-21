<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
MhsoxStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'TitInventoryNo',
				'TitMainTitle',
				#'CreDateCreated',
				#'CreCreatorRef_tab',
				#'CrePrimaryInscriptions',
				#'CreProvenance',
				//Place
				#'TitAccessionNo',
				#'CreBriefDescription',
				#'TitCollectionGroup_tab',
				#'PhyMaterial_tab',
				#'TitPreviousAccessionNo_tab',
				// Narative
				// Measurment
				#'PhyPartPart_tab',
				#'PhyPartAspect_tab',
				#'PhyPartDescription0',
				);	

} // end GalleryResultsList class

class
MhsoxContactSheet extends BaseContactSheet
{
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				);
} // end GalleryContactSheetResultsList class


?>
