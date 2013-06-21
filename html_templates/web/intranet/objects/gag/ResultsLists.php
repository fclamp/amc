<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

$BACKEND_TYPE = "gag";

$DEFAULT_DISPLAY_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Display.php";
$DEFAULT_PARTY_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/PartyDisplay.php";
$DEFAULT_CONTACT_SHEET_PAGE     = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/ContactSheet.php";
$DEFAULT_QUERY_PAGE             = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/Query.php";
$DEFAULT_RESULTS_PAGE           = "/$WEB_DIR_NAME/intranet/pages/$BACKEND_TYPE/ResultsList.php";
$DEFAULT_IMAGE_DISPLAY_PAGE     = "/$WEB_DIR_NAME/intranet/pages/common/imagedisplay.php";
$STRINGS_DIR            = "$WEB_ROOT/intranet/objects/$BACKEND_TYPE/strings/";


class
GalleryStandardResultsList extends BaseStandardResultsList
{
	var $Intranet = 1;
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				'CreCreatorLocal:1',
				'CreDateCreated'
				);	


} // end GalleryResultsList class

class
GalleryContactSheet extends BaseContactSheet
{
	var $Intranet = 1;
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				);	

} // end GalleryContactSheetResultsList class

?>
