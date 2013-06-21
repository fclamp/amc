<?php
$WEB_ROOT = dirname(__FILE__);

$urlHost = "http://" . $_SERVER['HTTP_HOST'];
$urlSelf = $_SERVER['PHP_SELF'];
$urlTop = preg_replace('/^(\/[^\/]*)\/.*$/', '$1', $urlSelf);
$urlRoot = "$urlTop/phpimu";
$urlMedia = "$urlTop/php5/media";

// Have no idea if this is correct but it is needed to stop
// PHP whinging when the date() function is used. I think it
// could be set to any value
date_default_timezone_set("Australia/Melbourne");

// Number of records per page in summary view
$pageSize = 10;
?>
