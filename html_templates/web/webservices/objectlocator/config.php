<?php

/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/*
* 
*  Master User Config for KE Object Locator.
*  This file should not be modified but can be overwritten
*  in a client specific backendtype/config.php.
*
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

// get the globals from the EMu web system
require_once($WEB_ROOT . '/objects/lib/' . 'common.php');

// get record extractor which will be used for reporting
require_once($WEB_ROOT . '/objects/common/' . 'RecordExtractor.php');

// page title
$PAGE_TITLE = "The National Museum Object Locator";

// page description
$PAGE_DESCRIPTION = "";

// applet width
$PAGE_WIDTH = "96%";

// applet height
$PAGE_HEIGHT = "620";

// applet plans 
$PLANS = 
	"Site Map       ^SitePlan.gif       ^-147^1453^-644^616 ^-1000^3000 ^TOP|
	Basement        ^Basement.gif       ^0^588^0^480    ^-1000^499  ^TOP|
	Ground Floor    ^GroundFloor.gif    ^0^588^0^480    ^500^1499       ^TOP|
	First Floor     ^FirstFloor.gif     ^0^588^0^480    ^1500^2500  ^TOP|
	View From South ^NorthElevation.gif ^-76^647^-46^468    ^-300^2660  ^SOUTH|
	View From West  ^EastElevation.gif  ^-76^647^-46^468    ^-300^2660  ^WEST";

// name of the data 
$DATA_NAME = "KE EMu Object Data";

// return field names - what fields you want to display when an object is clicked - these are catalogue fields 
// if you use the Internal Record Number please use field name "irn"
$CATALOGUE_RETURN_FIELDS = "SummaryData, irn";

// return field names from elocations 
// if you use the Internal Record Number please use field name "irn"
$LOCATION_RETURN_FIELDS = "PhyLocationX, PhyLocationY, PhyLocationZ, irn";

// decimal places 
$DECIMAL_PLACES = "0.00";

// dotsize
$DOT_SIZE = "12";

// dotshape
// square or circle or triangle or cross 
$DOT_SHAPE = "circle";

// zoomStep = 1-100 (ie a percentage but do not include '%' sign)
$ZOOM_STEP = "20";

// location range query
$LOC_RANGE_QUERY = "1500";	
	
// auto popup of combo box? "true" or "false" 
$AUTO_POPUP = "true";

// pointer color
$POINTER_COLOR = "#000000";

// pointer border color
$POINTER_BORDER_COLOR = "#FFA0A0";

// dot fill color
$DOT_FILL_COLOR = "#00FF00";

// dot border color 
$DOT_BORDER_COLOR = "#336699";

// dot hightlight fill color
$DOT_HIGHLIGHT_FILL_COLOR = "#FF7F7F";

// dot highlight border color
$DOT_HIGHLIGHT_BORDER_COLOR = "#99CCFF";

// location fill color
$LOC_DOT_FILL_COLOR = "#CC33CC";

// location border color 
$LOC_DOT_BORDER_COLOR = "#336699";

// location hightlight fill color
$LOC_DOT_HIGHLIGHT_FILL_COLOR = "#0066CC";

// location highlight border color
$LOC_DOT_HIGHLIGHT_BORDER_COLOR = "#99CCFF";

// normal background color of applet
$BACKGROUND_COLOR = "#e0e0e0";

// faded text color (faded map labels)
$FADED_TEXT_COLOR = "#7F7F7F";

// highlight text color (highlighted map labels)
$HIGHLIGHT_TEXT_COLOR = "#000000";

// object display page = url of the php object display page
$PHP_DISPLAY_PAGE = "/" . $WEB_DIR_NAME . "/pages/" . $BACKEND_TYPE . "/Display.php";

// EMu web link field
$LINK_FIELD = "SummaryData"; 

// search media? "true" or "false" 
$SEARCH_MEDIA = "true";

// disable updates (would be used for security reasons - this disables the update tool items)
$DISABLE_UPDATE = "false";

// the table name of where the coordinates lie 
$LOCATION_TABLE = "elocations";

// the reference link to the locations table 
$LOCATION_FIELD = "LocCurrentLocationRef";

// the internet/intranet field (leave blank if you dont want this check to be done)
$WEB_STATUS_FIELD = "AdmPublishWebNoPassword";

// locator version number
// (this number needs to be changed each time a mod has been made otherwise the cached version will be used on the clients box)
$LOCATOR_VERSION = "1.2.6.7";

// locator web service name (location of web service file)
$LOCATOR_WEB_SERVICE = "/" . $WEB_DIR_NAME . "/webservices/objectlocator.php";

// set up images to be viewed in the pane
$MEDIA_SERVICE = "/" . $WEB_DIR_NAME . "/objects/common/webmedia.php";

// set up the images link
$MEDIA_LINK = "/" . $WEB_DIR_NAME . "/pages/common/imagedisplay.php";

// objectlocator jar file name
$ARCHIVE = "objectlocator.jar";

// objectlocator main class file name
$CODE = "ObjectLocator.class";

// directory name of images (plans)
if (file_exists($WEB_ROOT . "/webservices/objectlocator/$BACKEND_TYPE/plans"))
	$PLANS_DIR_NAME = "$BACKEND_TYPE/plans";
else
	$PLANS_DIR_NAME =  "plans";

// directory name of standard applet images
if (file_exists($WEB_ROOT . "/webservices/objectlocator/$BACKEND_TYPE/images"))
	$IMAGE_DIR_NAME = "$BACKEND_TYPE/images";
else
	$IMAGE_DIR_NAME = "images";	

// directory location of standard web server images
$IMAGE_WEB_DIR_NAME = "/" . $WEB_DIR_NAME . "/webservices/images";

// overwrite with client specific config.php if available
if (file_exists($WEB_ROOT . "/webservices/objectlocator/$BACKEND_TYPE/config.php"))
    require_once($WEB_ROOT . "/webservices/objectlocator/$BACKEND_TYPE/config.php");
?>
