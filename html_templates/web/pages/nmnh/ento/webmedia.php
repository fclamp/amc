<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'media.php');

global $ALL_REQUEST;

if (isset($ALL_REQUEST["size"]))
        $size = $ALL_REQUEST["size"];

if (isset($ALL_REQUEST["thumb"]) && $ALL_REQUEST["thumb"] == "yes")
{
        $size = "thumb";
}
$mr = new MediaRetriever;
$mr->WebImage = 1;
$mr->ShowImage($ALL_REQUEST['irn'], $size);

?>
