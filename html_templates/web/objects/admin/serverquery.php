<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*	RAW XML Query
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(__FILE__)));
require_once($WEB_ROOT . '/objects/lib/webinit.php');

global $ALL_REQUEST;
if (! ($ALL_REQUEST['cryptpasswd'] == md5($GLOBALS['ADMIN_PASSWORD']) ||
	$ALL_REQUEST['cryptpasswd'] == md5($GLOBALS['REMOTE_PASSWORD']) ))
{
	Die("<H1>Access Denied</H1>");
}

$fd = fsockopen ($GLOBALS['XML_SERVER_HOST'], $GLOBALS['XML_SERVER_PORT'], $errno, $errstr, 30);
// Grab the data
if (!$fd || $fd < 0)
{
	Die('Cannot connect to the KE Texpress database server.');
}
$get = "GET /?texql=" . urlencode(stripslashes($texql)) . " HTTP/1.0\r\n\r\n";

fputs($fd, $get);

$matches = array();
while (!feof($fd))
{
	$out = trim(fgets($fd, 4096));
	if ($out == '')
		break;
	Header($out);
}
while (!feof($fd))
{
	print fgets($fd, 4096);
}

fclose($fd);

?>
