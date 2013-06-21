<?php

//Redirect the user to the Default Query Page

require_once('objects/lib/webinit.php');

$host = isset($HTTP_HOST) ? $HTTP_HOST : $_SERVER['HTTP_HOST'];

Header("Location: http://$host" . $GLOBALS['DEFAULT_QUERY_PAGE']);

?>
