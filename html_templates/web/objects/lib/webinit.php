<?php
/*
* Copyright (c) 1998-2012 KE Software Pty Ltd
*
* Global bootstrap of for definitions and environment settings.
*
* 	WANNING:  Keep this code light & fast.
*/

// Set the required error_reporting()
if (defined('E_DEPRECATED')) 
{
	// this constant not defined until PHP 5.3
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
}
else
{
	error_reporting(E_ALL & ~E_NOTICE);
}

//ini_set('display_errors', false);

// Merge the new 4.2 global "_REQUEST" array with the global
// variables for legacy support.  All KE code should use the 
// ALL_REQUEST global for access to CGI vars.
if (isset($_REQUEST))
	$GLOBALS['ALL_REQUEST'] = $_REQUEST;
else
	$GLOBALS['ALL_REQUEST'] = $GLOBALS;

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
$WEB_DIR_NAME = basename($WEB_ROOT);

// Version Information
$WEB_VERSION = '1.4.002';

// Default Debug to off
$DEBUG = 0;

// Require local config settings 
require_once($WEB_ROOT . '/CONFIG.php');

// Setup image locations if not already set
if (!isset($WEB_NOIMAGE_THUMB))
	$WEB_NOIMAGE_THUMB 
		= "/$WEB_DIR_NAME/objects/images/noimage_small.jpg";
if (!isset($WEB_NOIMAGE_GRAPHIC))
	$WEB_NOIMAGE_GRAPHIC 
		= "/$WEB_DIR_NAME/objects/images/noimage_large.jpg";
if (!isset($WEB_NOIMAGE_THUMB_FILE))
	$WEB_NOIMAGE_THUMB_FILE 
		= "$WEB_ROOT/objects/images/noimage_small.jpg";
if (!isset($WEB_NOIMAGE_GRAPHIC_FILE))
	$WEB_NOIMAGE_GRAPHIC_FILE 
		= "$WEB_ROOT/objects/images/noimage_large.jpg";
if (!isset($WEB_PICKLIST_GRAPHIC))
	$WEB_PICKLIST_GRAPHIC = "/$WEB_DIR_NAME/objects/images/picklist.gif";

// Set IMAGE_TEMP_DIR if not defined in CONFIG.php
if (!isset($IMAGE_TEMP_DIR))
	$IMAGE_TEMP_DIR = "/tmp";

// Set SUB_QUERY_LIMIT if not set in CONFIG.php
if (!isset($SUB_QUERY_LIMIT))
	$SUB_QUERY_LIMIT = 0;

// Setup useful global directory & file definitions
$OBJECTS_DIR		= $WEB_ROOT . '/objects/';
$LIB_DIR 		= $WEB_ROOT . '/objects/lib/';
if (!isset($IMAGE_DIR))
	$IMAGE_DIR 		= $WEB_ROOT . '/objects/images/';
$COMMON_DIR 		= $WEB_ROOT . '/objects/common/';
$CACHE_DIR 		= $WEB_ROOT . '/objects/cache/';
$REPORT_DIR 		= $WEB_ROOT . '/objects/cache/reports';

if (!isset($MEDIA_URL))
	$MEDIA_URL	= "/$WEB_DIR_NAME/objects/common/webmedia.php";
if (!isset($INTRANET_MEDIA_URL))
	$INTRANET_MEDIA_URL = "/$WEB_DIR_NAME/intranet/objects/common/webmedia.php";
if (!isset($DEFAULT_IMAGE_DISPLAY_PAGE))
	$DEFAULT_IMAGE_DISPLAY_PAGE = "/$WEB_DIR_NAME/pages/common/imagedisplay.php";
if (!isset($INTRANET_DEFAULT_IMAGE_DISPLAY_PAGE))
	$INTRANET_DEFAULT_IMAGE_DISPLAY_PAGE = "/$WEB_DIR_NAME/intranet/pages/common/imagedisplay.php";
if (!isset($LOOKUPLIST_URL))
	$LOOKUPLIST_URL	= "/$WEB_DIR_NAME/objects/common/lookup.php";
if (!isset($CSVEXPORT_URL))
	$CSVEXPORT_URL	= "/$WEB_DIR_NAME/objects/common/csvexport.php";

if (function_exists("date_default_timezone_set"))
{
        if (isset($TIMEZONE))
                date_default_timezone_set($TIMEZONE);
}


$BACKEND_TYPE	 	= strtolower($BACKEND_TYPE);
$STRINGS_DIR 		= "$WEB_ROOT/objects/$BACKEND_TYPE/strings/";

// Default pages
// Set DEFAULT_QUERY_PAGE if not set in CONFIG.php
if (!isset($DEFAULT_QUERY_PAGE))
	$DEFAULT_QUERY_PAGE		= "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/Query.php";
$DEFAULT_RESULTS_PAGE		= "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/ResultsList.php";
$DEFAULT_CONTACT_SHEET_PAGE	= "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/ContactSheet.php";
if (!isset($DEFAULT_DISPLAY_PAGE)) 
	$DEFAULT_DISPLAY_PAGE	= "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/Display.php";
$DEFAULT_PARTY_DISPLAY_PAGE	= "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/PartyDisplay.php";
$DEFAULT_NARRATIVES_DISPLAY_PAGE = "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/NarDisplay.php";
$DEFAULT_NARRATIVES_RESULTS_LIST = "/$WEB_DIR_NAME/pages/$BACKEND_TYPE/NarResultsList.php";

// Require Cached settings
$syscache = $CACHE_DIR . 'system.php';
if (is_readable($syscache))
	include_once($syscache);

// Language Map - Bi Directional
// Following standard defined at:
//	http://emudev.kesoftware.com/Developers/FAQ/Design/multilang.html
$LANGUAGE_MAP[0] 		= "english";
$LANGUAGE_MAP[1] 		= "french";
$LANGUAGE_MAP[2] 		= "english-us";
$LANGUAGE_MAP[3] 		= "spanish";
$LANGUAGE_MAP[4] 		= "german";
$LANGUAGE_MAP["english"] 	= "0";
$LANGUAGE_MAP["french"] 	= "1";
$LANGUAGE_MAP["english-us"] 	= "2";
$LANGUAGE_MAP["spanish"] 	= "3";
$LANGUAGE_MAP["german"] 	= "4";

?>
