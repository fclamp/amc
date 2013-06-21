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
		$type = 'standard';
		if (isset($_REQUEST['type']))
			$type = $_REQUEST['type'];

		switch (strtoupper($type))
		{
			case 'GARDEN' :
				return new RbgnswGardenPortal($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
			case 'STANDARD' :
			default :
				return new RbgnswPortal($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
				break;
		}
	}
}

class RbgnswPortal extends Portal
{
	var $systemName = "default RBGNSW Portal v2";
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
			"An RBGNSW Portal is a RBGNSW client specific portal\n\n".
			Parent::describe();
	}

}

class RbgnswGardenPortal extends Portal
{
	var $systemName = "RBGNSW Garden Portal v2";
	var $queryScreen = Array(
		'standardTimeout' => 25,
		'orRows' => 5,
		'maxPerFetcher' => 50,
		'showTransformOption' => false,
		'diagnostics' => false,
	);

	function RbgnswGardenPortal($backendType='',$webRoot='',$webDirName='',$debugOn='')
	{
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->defaultStylesheet = 'portal/rbgnsw/style/garden.xsl';
		$this->provideStatusMap(151.212,-33.871,151.223,-33.856,"garden.map");
	}


	function describe()
	{
		return	
			"An RBGNSW Garden Portal is a RBGNSW client specific portal\n\n".
			Parent::describe();
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
