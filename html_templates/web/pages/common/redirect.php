<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*
*  Redirect using HTTP Location header to the page specified by 'url'.
*/

require("../../objects/lib/webinit.php");
header("Location: " . $ALL_REQUEST["url"]);

?>
