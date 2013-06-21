<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



/*  Factory class used to create right instance of client
**  specific objects.
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
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
		return new nmnhPortal($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);
	}
}

class NmnhPortal extends Portal
{
	var $systemName = "default NMNH Portal v2";
	var $queryTerms = Array(
			'darwin:Family',
			'darwin:Genus',
			'darwin:Species',
			'darwin:TypeStatus',
			'darwin:Locality',
	);

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
			"A NMNH Portal is a NMNH client specific portal\n\n".
			Parent::describe();
	}

}


?>
