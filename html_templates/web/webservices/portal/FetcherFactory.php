<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');



/**
 * Class FetcherFactory
 *
 *  A factory to create the correct instance of a Fetcher.  (also provides
 *  method to configure where specific instances of sources are to be placed)
 *
 *
 * @package EMuWebServices
 */
class FetcherFactory extends BaseWebServiceObject
{
	var 	$serviceName = "FetcherFactory";

	function getInstance($source)
	{
		if ($source)
		{
			$sourceFile = $this->webRoot . "/webservices/portal/". $this->backendType ."/fetchers/$source.php";
			if (! is_file($sourceFile))
				$sourceFile = $this->webRoot . "/webservices/portal/fetchers/$source.php";
			if (is_file($sourceFile))
			{
				require_once ($sourceFile);
				eval('$instance = new '.  $source .  "Fetcher();");

				if ($instance->enabled)
				{
					$this->_log("Fetcher: ".$source." requested and available - USING");
					return $instance;
				}
				else
				{
					$this->_log("Fetcher: ".$source." requested but is disabled");
					return null;
				}
			}
			else
			{
				$this->_log("Fetcher: ".$source." requested but not found");
				return null;
			}
		}
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "FetcherFactory.php")
	{
		$factory = new FetcherFactory();
		if (isset ($_REQUEST['fetcher']))
			$fetcherName = $_REQUEST['fetcher'];
		else
			$fetcherName = 'Digir';

		$fetcher = $factory->getInstance($fetcherName);
		if ($fetcher)
			print $fetcher->test(true);
		else
			$factory->errorResponse("Cannot make fetcher='". $_REQUEST['fetcher'] ."' instance in FetcherFactory.php (assume a $fetcherName)");
	}
}




?>
