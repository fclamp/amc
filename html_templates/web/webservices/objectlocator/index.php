<?php

/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/*
*
*  The Index Page for the KE Object Locator. 
*	This file should not be modified. 
*
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once($WEB_ROOT . '/objects/lib/webinit.php');

require_once($WEB_ROOT . "/webservices/objectlocator/config.php");

if (file_exists($WEB_ROOT . "/webservices/objectlocator/$BACKEND_TYPE/pageview.php"))
	require_once($WEB_ROOT . "/webservices/objectlocator/$BACKEND_TYPE/pageview.php");
else
	require_once($WEB_ROOT . "/webservices/objectlocator/pageview.php");
?>
