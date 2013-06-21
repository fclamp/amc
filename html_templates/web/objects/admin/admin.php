<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(__FILE__)));
require_once($WEB_ROOT . '/objects/lib/webinit.php');

global $ALL_REQUEST;
if ($ALL_REQUEST['password'] != $GLOBALS['ADMIN_PASSWORD'])
{
	print "<H1>Access Denied</H1>";
	Die();
}
?>

<html>
<head>
<title><?php print $GLOBALS['APPLICATION'] ?> - Admin</title>
</head>
<body>
<table border="0" cellpadding="3" cellspacing="1" width="600" bgcolor="#000000" align="center">
  <tr valign="middle" bgcolor="#9999CC">
    <td align="left"> <a href="http://www.kesoftware.com/"><img src="/<?php print $GLOBALS['WEB_DIR_NAME']?>/objects/images/emusmall.gif" border="0" align="right" alt="KE EMu" /></a>
      <h1><?php print $GLOBALS['APPLICATION'] ?> - Version <?php print $GLOBALS['WEB_VERSION'] ?></h1>
      <h4>&nbsp;&nbsp;&nbsp;System: <?php print strtoupper($GLOBALS['BACKEND_TYPE']) ?></h4>
    </td>
  </tr>
</table>
<br />
<div align="center">
<form method="post" action="initialise.php">
  <b><font face="arial" size="2"> Reload cached system values:&nbsp;</font></b>
  <input type="hidden" name="cryptpasswd" value="<?php print md5($ALL_REQUEST['password'])?>" />
  <input type="submit" name="Submit" value="reload" />
</form>
</div>
<?php

VerifyFiles();

?>
<div align="center">
<form method="post" action="source.php">
  <b><font face="arial" size=2> View Source Code:&nbsp;</font></b>
  <input type="hidden" name="cryptpasswd" value="<?php print md5($ALL_REQUEST['password'])?>" />
  <input type="text" name="file" size="40" value="CONFIG.php" />
  <input type="submit" name="Submit" value="View" />
</form>
</div>
<div align="center">
<form method="get" action="serverquery.php">
  <b><font face="arial" size="2"> Texxmlserver test:&nbsp;</font></b>
  <input type="hidden" name="cryptpasswd" value="<?php print md5($ALL_REQUEST['password'])?>" />
  <input type="text" name="texql" size="60" value="(select * from ecatalogue) {1 to 5}" />
  <input type="submit" name="Submit" value="Query" />
</form>
</div>
<br />
<?php

phpinfo();



function
VerifyFiles()
{
	print "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"600\" bgcolor=\"#000000\" align=\"center\">\n";

	// Load Sigs in hash
	$sigs = array();
	$fdSig = fopen('files.sig', 'r');
	while (!feof($fdSig))
	{
		$line = trim(fgets($fdSig, 4096));
		list($file, $sig) = split('\|', $line);
		$sigs[$file] = $sig;
	}
	fclose($fdSig);

	foreach($sigs as $file => $sig)
	{
		if ($file == '') continue;
		$path = $GLOBALS['WEB_ROOT'] . "/$file";
		$currentSig = FileSigniture($path);

		if ($currentSig != $sig)
		{
			print "  <tr valign=\"baseline\" bgcolor=\"#CCCCCC\"> \n";
			print "    <td bgcolor=\"#CCCCFF\" ><b>$file</b></td>\n";
			print "    <td align=\"left\"><font color=\"#FF0000\"><b>Warning - file has been modified</b></font> ";
			print "<font size=\"1\">($currentSig)</font></td>\n";
			print "  </tr>\n";

		}
		else
		{
			print "  <tr valign=\"baseline\" bgcolor=\"#CCCCCC\"> \n";
			print "    <td bgcolor=\"#CCCCFF\" ><b>$file</b></td>\n";
			print "    <td align=\"left\"><font color=\"#339900\"><b>Valid - file has not been modified</b></font></td>\n";
			print "  </tr>\n";
		}
	}
	print "</table><br />\n";
}


function
FileSigniture($file)
{
	$sig = '';
	if (isset($file) && is_readable($file))
	{
		$fd = fopen($file, 'r');
		$contents = fread($fd, filesize($file));
		fclose($fd);
		$sig = md5($contents);
	}
	return $sig;
}
				
?>
</body>
</html>
