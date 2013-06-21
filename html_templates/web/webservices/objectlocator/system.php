<?php

/***********************************************************
**
**      Administrator Config for KE Object Locator. Modify with care.
**	This file will generally not need to be touched 
**	(if it is modified, then it's usually just the version number).
**	This file should not be modified by the user.
**
************************************************************/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

// get the globals from the EMu web system
require_once ($WEB_ROOT . '/objects/lib/' . 'common.php');

// get record extractor which will be used for reporting
require_once ($WEB_ROOT . '/objects/common/' . 'RecordExtractor.php');

// locator version number 
// (this number needs to be changed each time a mod has been made otherwise the cached version will be used on the clients box) 
if (!isset($LOCATOR_VERSION))
	$LOCATOR_VERSION = "1.2.6.7";

// locator web service name (location of web service file)
if (!isset($LOCATOR_WEB_SERVICE))
	$LOCATOR_WEB_SERVICE = "/" . $WEB_DIR_NAME . "/webservices/objectlocator.php";

// set up images to be viewed in the pane
if (!isset($MEDIA_SERVICE))
	$MEDIA_SERVICE = "/" . $WEB_DIR_NAME . "/objects/common/webmedia.php";

// set up the images link 
if (!isset($MEDIA_LINK))
	$MEDIA_LINK = "/" . $WEB_DIR_NAME . "/pages/common/imagedisplay.php";

// where is the jar file
if (!isset($ARCHIVE))
	$ARCHIVE = "objectlocator.jar";

// where is the main class file
if (!isset($CODE))
	$CODE = "ObjectLocator.class";

// directory location of images (plans)
if (!isset($PLANS_DIR_NAME))
	$PLANS_DIR_NAME = "plans";

// directory location of standard applet images
if (!isset($IMAGE_DIR_NAME))
	$IMAGE_DIR_NAME = "images";

// directory location of standard web server images
if (!isset($IMAGE_WEB_DIR_NAME))
	$IMAGE_WEB_DIR_NAME = "/" . $WEB_DIR_NAME . "/webservices/images";


?>
