<?php

/*
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal

/**
*
* FetcherDriverFactory class
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
require_once ($WEB_ROOT . '/webservices/portal/FetcherDriver.php');


class FetcherDriverFactory
{

	var $backendType;
	var $webRoot;
	var $webDirName;
	var $debugOn;

	function FetcherDriverFactory($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->backendType = $backendType;
		$this->webRoot = $webRoot;
		$this->webDirName = $webDirName;
		$this->debugOn = $debugOn;
	}
	function getInstance()
	{
		return new UsprrFetcherDriver($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
	}
}

class UsprrFetcherDriver extends FetcherDriver
{
	var $systemName = "USPRR FetcherDriver Portal v2";


	function configureInterfaces()
	{
		parent::configureInterfaces();
		$this->setQueryableConcept("IRN");
		$this->setQueryableConcept("RockName");
		$this->setQueryableConcept("RockType");
		$this->setQueryableConcept("Latitude");
		$this->setQueryableConcept("Longitude");
		$this->setQueryableConcept("Summary");
	}

	function describe()
	{
		return	
			"A USPRR FetcherDriver is a USPRR client specific Fetcher Driver\n\n".
			Parent::describe();
	}
}


if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'FetcherDriverFactory.php')
	{
		$factory = new FetcherDriverFactory;
		if ($webservice = $factory->getInstance())
		{
			$webservice->test(true);
		}
	}
}


?>
