<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(realpath(__FILE__)));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/BaseWebServiceObject.php');



/**
 * Class SourceFactory
 *
 *  A factory to create the correct instance of a Source.  (also provides
 *  method to configure where specific instances of sources are to be placed)
 *
 *
 * @package EMuWebServices
 */
class SourceFactory extends BaseWebServiceObject
{
	var 	$serviceName = "SourceFactory";


	function getSourceDirectory()
	{
		// All actual instances of portal sources will be placed under
		// the directory this method returns

		return $this->webRoot . "/portal/";
	}

	function getInstance($source)
	{
		$sourceDirectory = $this->getSourceDirectory();
		$sourceFile = $sourceDirectory ."/". $source ."/Source.php";

		if ($source && is_file($sourceFile))
		{
			require_once ($sourceFile);
			eval('$instance = new '.  $source .  "Source();");
			if ($instance->enabled)
				return $instance;
			else
				return null;
		}
		else
			return null;
	}
}

?>
