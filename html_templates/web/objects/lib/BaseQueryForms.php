<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/* This code remains in place only for backward compatability
*  Please use Base*QueryForm.php files directly.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');

require_once ($LIB_DIR . 'BaseBasicQueryForm.php');
require_once ($LIB_DIR . 'BaseAdvancedQueryForm.php');
require_once ($LIB_DIR . 'BaseDetailedQueryForm.php');

?>
