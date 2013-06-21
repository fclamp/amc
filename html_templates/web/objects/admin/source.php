<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(__FILE__)));
require_once($WEB_ROOT . '/objects/lib/webinit.php');

global $ALL_REQUEST;
if ($ALL_REQUEST['cryptpasswd'] != md5($GLOBALS['ADMIN_PASSWORD']))
{
	Die("<H1>Access Denied</H1>");
}


if (!isset($file))
{
	Die("No page specified.");
}
?>

<h2>Source of: <?php print $file; ?></h2><BR>

<?

$path = "$WEB_ROOT/$file";

echo("<!-- $path -->\n");

if (file_exists($path) && !is_dir($path))
{
	show_source($path);
}
elseif (is_dir($path))
{
	print "<P>No file specified.  Can't show source for a directory.</P>\n";
}
else
{
	print "<P>No file specified.</P>\n";
}

?>
