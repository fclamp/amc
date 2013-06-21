<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(__FILE__)));
require_once($WEB_ROOT . '/objects/lib/webinit.php');

?>

<html>
</html>
<body>

<?php
/*
 <H1><font color="#ff0000">
 	PHP is not configured correctly!
 </font></H1>
*/
?>

<a href="http://www.kesoftware.com/"><img src="/<?php print $GLOBALS['WEB_DIR_NAME']?>/objects/images/emusmall.gif" border="0" alt="KE EMu" /></a>
<br />
<div align="center">
<form method="post" action="admin.php">
  <b><font face="arial" size=3> Admin Password:&nbsp;<font></b>
  <input type="password" name="password" size="20" value="" />
  <input type="submit" name="Submit" value="Login" />
</form>
</div>

</body>
