<?php

/*
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal

/**
*
* Portal Factory class
*
* used to create right instance of client
* specific Portal from common program
* interface
*
* Copyright (c) 1998-2009 KE Software Pty Ltd
*
* @package EMuWebServices
*
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/portal/Portal.php');


class PortalFactory
{

	var $backendType;
	var $webRoot;
	var $webDirName;
	var $debugOn;

	function PortalFactory($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->backendType = $backendType;
		$this->webRoot = $webRoot;
		$this->webDirName = $webDirName;
		$this->debugOn = $debugOn;
	}
	function getInstance()
	{
		return new NhdemoPortal($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
	}
}

class NhdemoPortal extends Portal
{
	var $systemName = "default NHDEMO Portal v2";
	var $queryScreen = Array(
		'standardTimeout' => 25,
		'orRows' => 5,
		'maxPerFetcher' => 50,
		'showTransformOption' => false,
		'diagnostics' => false,
	);


	function describe()
	{
		return	
			"A NHDEMO Portal is a NHDEMO client specific portal\n\n".
			parent::describe();
	}

}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'PortalFactory.php')
	{
		$factory = new PortalFactory;
		if ($webservice = $factory->getInstance())
		{
			$webservice->test(true);
		}
	}
}


?>
