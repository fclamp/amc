<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
?>
<html>
<head>
	<title>View Image</title>
</head>
<body>
	<?php
	$webmedialink = "../../common/" .
		'webmedia.php?irn=' . $_REQUEST['irn'];
	?>
	<img src="<?php print $webmedialink; ?>" />
</body>
</html>
