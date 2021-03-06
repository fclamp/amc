<?php
/* Copyright (c) 2009 - KE Software Pty. Ltd. */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($WEB_ROOT . '/objects/am/media.php');

global $ALL_REQUEST;

if (isset($ALL_REQUEST["size"]))
	$size = $ALL_REQUEST["size"];

if (isset($ALL_REQUEST["thumb"]) && $ALL_REQUEST["thumb"] == "yes")
{
	$size = "thumb";
}
$mr = new AmMediaRetriever;

# override some globals

$GLOBALS['WEB_NOIMAGE_THUMB_FILE'] = "$WEB_ROOT/objects/am/images/noimage.gif";
$GLOBALS['WEB_NOIMAGE_GRAPHIC_FILE'] = "$WEB_ROOT/objects/am/images/noimage.gif";

$mr->ShowImage($ALL_REQUEST['irn'], $size);

?>

