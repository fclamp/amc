<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');
require_once ($WEB_ROOT . '/webservices/lib/DataCacher.php');
require_once ($WEB_ROOT . '/webservices/lib/Transformation.php');

/**
 * Class WebServiceObject
 *
 * Use as the base of complicated services that require data caching and
 * transformation operations
 *
 * @package EMuWebServices
 */
class WebServiceObject extends BaseWebServiceObject
{

	var $serviceName = "WebServiceObject";
	var $serviceDirectory = "";

	/**
	 * default stylesheet
	 *
	 *   if default is  stylesheet.xsl 
	 *   it will first look for
	 *    webservices/SERVICE/BACKEND/style/stylesheet.xsl
	 *   (eg webservices/mapper/nmnh/style/stylesheet.xsl)
	 *  then
	 *    webservices/SERVICE/style/stylesheet.xsl 
	 *
	 * @var string
	 */
	var $defaultStylesheet = '';

	/**
	 * query_string used to generate this object
	 * @var string[]
	 */
	var $generatingParameters = 'Cooooeeee !!!';

	/**
	 * a list of arguments that the webservice accepts of 'standard' arguments.
	 * Others may be passed but will be saved in a list of
	 * 'additionalRequestArguments' and they should only have significance
	 * for localised customisations
	 *
	 */
	var $standardArguments = Array();

	/**
	 * a hash of passed parameters that are not in the recognised set of
	 * standard 'allowed' arguments for a service
	 *
	 */
	var $additionalRequestArguments = Array();
	
	/**
	 * list of HTTP headers to send with results
	 * @var string[]
	 */
	var $_headers = array();

	/**
	 * objects cacher
	 * @var object DataCacher
	 */
	var $_cacher = null;


	function WebServiceObject($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		parent::BaseWebServiceObject($backendType,$webRoot,$webDirName,$debugOn);

		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);


		$this->generatingParameters = preg_replace("/&/","&amp;",$_SERVER['QUERY_STRING']);
		$this->generatingParameters = preg_replace("/</","&lt;",$this->generatingParameters);
		$this->generatingParameters = preg_replace("/>/","&gt;",$this->generatingParameters);
		$this->generatingParameters = preg_replace("/%20/"," ",$this->generatingParameters);

		if ($this->serviceDirectory == '')
		{
			$this->serviceDirectory = "webservices/lib";
			//$this->errorResponse("You need to specify the 'serviceDirectory' property of the Object","config error");
		}

		$this->configureInterfaces();
		$this->_recordAdditionalArguments();
	}

	function configureInterfaces()
	{
		$this->setStandardArgument("test","run test interface");
		$this->setStandardArgument("describe","show information about service");
		$this->setStandardArgument("transform","[simpleTransformation|xslt|raw]");
		$this->setStandardArgument("stylesheet","XSLT page or HTML template (to use with transform method)");
	}	

	function setStandardArgument($param,$description="no information")
	{
		$this->standardArguments[$param] = $description;
	}
	
	function _recordAdditionalArguments()
	{
		foreach ($_REQUEST as $param => $value)
		{
			if (! isset($this->standardArguments[$param]))
			{
				if (is_array($value))
				{
					$this->additionalRequestArguments[$param] = Array();
					foreach ($value as $item)
					{
						$this->additionalRequestArguments[$param][] = urldecode($item);
					}
				}
				else
				{
					$this->additionalRequestArguments[$param] = urldecode($value);
				}
			}
		}
	}

	function describe()
	{
		return	
			"A WebService Object is a BaseWebServiceObject that has\n".
			"caching and response formatting ability\n\n".  
			parent::describe();
	}

	/**
	 * Display how a service can be called - experimental - may drop
	 */
	function useage($service='UNDEFINED',$useage=Array(),$msg='')
	{
		foreach ($useage as $argument => $explanation)
			$options[] = "\t\t<option form='$argument'>$explanation</option>";
		$useage = implode("\n",$options);

		header("Content-type: text/xml");
		print <<<XML
<emuWebServiceDescription>
	<service>$service</service>	
	<emuweb>$this->webDirName</emuweb>
	<description>
$msg
	</description>
	<useage>
$useage
	</useage>
</emuWebServiceDescription>
XML;
	}


	/**
	 * System to save request hash.  This can be retrieved at later time
	 * using identifier as a key.  Uses DataCacher
	 */
	function saveCallingParameters($identifier,$request)
	{
		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName);
		if (! isset($request['cacheReadOnly']))
		{
			$status = Array();

			if (count($request))
				ksort($request);
			foreach ($request as $param => $value)
			{

				if (is_array($value))
					foreach ($value as $multiValue)
					{
						if ((PHP_OS == "WINNT" || PHP_OS == "WIN32") && ! is_array($value))
							if (preg_match("/^[A-Z]:/",$value ))
								$value = preg_replace("/\\\/","/",$value);
	
						if (get_magic_quotes_gpc())
						{
							$multiValue = stripslashes($multiValue);
							$param = stripslashes($param);
						}
						$status[] = "${param}[] = $multiValue";
					}	
				else	
				{
					if (PHP_OS == "WINNT" || PHP_OS == "WIN32")
						if (preg_match("/^[A-Z]:/",$value ))
							$value = preg_replace("/\\\/","/",$value);
	
					if (get_magic_quotes_gpc())
					{
						$value = stripslashes($value);
						$param = stripslashes($param);
					}
					$status[] = "$param = $value";
				}
			}
			$this->_cacher->save($identifier,implode("\n",$status));
		}
		else
		{
			if (! $this->_cacher->exists($identifier))
			{
				$this->_log("Warning - request for readonly access to non existent cacher : $identifier");
			}
		}

		return $this->_cacher->getUrlOfIndex($identifier);

	}

	/**
	 * passed hash of parameter/values return as XML
	 */
	function argumentsAsXml($arguments)
	{
		$argumentsXml = "";
		foreach ($arguments as $param => $value)
		{
			// XML won't allow non alphanumeric tags
			$param = preg_replace("/\W/","_",$param);
			$param = preg_replace("/^(\d+)/","Digit_$1",$param);

			if (is_array($value))
			{
				$i = 0;
				$argumentsXml .= "\t<$param>\n";
				foreach ($value as $item)
				{
					$argumentsXml .= "\t\t<item>" . urlencode($item) . "</item>\n";
					$i++;
				}
				$argumentsXml .= "\t</$param>\n";
			}
			else
			{
				$argumentsXml .= "\t<$param>" . urlencode($value) . "</$param>\n";
			}
		}
		return $argumentsXml;
	}

	function cacheExists($identifier)
	{
		return  $this->_cacher->exists($identifier);
	}

	/**
	 * retrieve saved hash data.  Existing parameters in passed hash will
	 * override those retrieved from cache.  Uses DataCacher
	 */
	function retrieveCallingParameters($identifier,$currentParameters)
	{
		$request = array();
		if ($this->_cacher->exists($identifier))
		{
			$state = $this->_cacher->retrieve($identifier);
			foreach (preg_split('/\n/',$state) as $args)
			{
				preg_match('/^(.+?)\s*=\s*(.*)$/',$args,$match);
				if (! isset($ignores[$match[1]]))
					if (preg_match('/(.+)\[\]$/',$match[1],$name))
						$request[$name[1]][] = $match[2];
					else
						$request[$match[1]] = $match[2];
			}

			// override any parameters cached if new values passed
			if ($currentParameters)
			{
				foreach ($currentParameters as $param => $value)
				{
					if (get_magic_quotes_gpc())
					{
						$param = stripslashes($param);
						if (! is_array($value))
							$value = stripslashes($value);
					}
					// '0' may be treated as NULL...
					if ($value != NULL || $value == '0')
						$request[$param] = $value;
				}
			}
			return $request;
		}
		return null;
	}

	/**
	 * Generate a map and send back Mapper XML.  Not implemented yet
	*/
	function sendMap($data)
	{
		return  "<xml><!--Cannot do sendMap yet ! (see sendMap in WebServices.php) --></xml>";
	}

	/**
	 * returns either client specific or default transformation sheet
	 *
	 * returns the style sheet prefixed by client type or if not
	 * found returns default stylesheet
	 *
	 * @return string
	 */
	function findStylesheet($stylesheet="")
	{
		$defaultHome = "/". $this->serviceDirectory;
		$localisedHome = $defaultHome ."/". $this->backendType;

		if (! $stylesheet)
			$stylesheet = $this->defaultStylesheet;

		if (file_exists($this->webRoot . "$localisedHome/style/$stylesheet"))
			return "/". $this->webDirName ."$localisedHome/style/$stylesheet";

		if (file_exists($this->webRoot . "$defaultHome/style/$stylesheet"))
			return "/". $this->webDirName ."$defaultHome/style/$stylesheet";
		return $stylesheet;
	}
	
	/**
	 * Send a result set to the client with the supplied styelsheet
	 * linked in.
	 */
	function sendClientXslt($stylesheet,$data)
	{

		$stylesheet = urldecode($stylesheet);
		if (! $stylesheet)
		{
			$this->_headers[] = "Content-type: text/xml";
			return  "<?xml version='1.0' encoding='ISO-8859-1' ?>\n".
				"<!-- WARNING - Client side styling requested but stylesheet not set -->\n".
				$data;
		}

		# make stlesheet URI unique to prevent browser caching an old
		# one (caching probably not a drama unless stylesheets are being
		# debugged - when it becaomes a big pain)
		$stylesheet .= "?cacheFooler=". time();

		return  "<?xml version='1.0' encoding='ISO-8859-1' ?>\n".
                        "<?xml-stylesheet type='text/xsl' ".
                        " href='$stylesheet'?>\n$data";
	}

	/**
	 * Send the generated results back to the client.
	 */
	function sendResults()
	{
		return "<xml/>";
	}

	/**
	 * calls appropriate data massaging process
	 *
	 * Used to call any Transformation operations on data generated by the
	 * service
	 *
	 * @return string
	 */
	function formatOutput($request,$rawData=false,$setHeaders=true)
	{
		$this->_headers[] = "Cache-Control: no-cache";
		$this->_headers[] = "Pragma: no-cache";
		#$this->_headers[] = "Expires: 0";

		$xmlResults = $this->sendResults();

		if ($rawData)
			return $xmlResults;

		if (isset($request['transform']) && $request['transform'] == 'raw')
		{
			$this->_headers[] = "Content-type: text/xml";
			return "<?xml version='1.0' encoding='ISO-8859-1' ?>\n".$xmlResults;
		}
		
		if (isset($request['map']))
			return $this->sendMap($xmlResults);
		
		$stylesheet = $this->defaultStylesheet;
		if (isset($request['stylesheet']) && $request['stylesheet'])
			$stylesheet = $request['stylesheet'];
		// get path details of stylesheet passed without full path	
		$stylesheet = $this->findStylesheet($stylesheet);

		if (isset($request['transform']))
		{
			// transform SERVER SIDE using template or xslt
			$factory = new TransformationFactory();
			$transform = $factory->getInstance($request['transform']);
			if ($transform)
				return $transform->transform($xmlResults, $stylesheet, $setHeaders);
		}

		if (isset($request['stylesheet']) && preg_match("/\.html$/",$request['stylesheet']))
		{
			// no transform specified.  HTML template specified so assume
			// simple styling (done server side)
			$factory = new TransformationFactory();
			$transform = $factory->getInstance('SimpleTransformation');
			if ($transform)
				return $transform->transform($xmlResults, $stylesheet, $setHeaders);
		}


		// try client side XSLT (or XML)
		$this->_headers[] = "Content-type: text/xml";
		return  $this->sendClientXslt($request['stylesheet'],$xmlResults);
	}

}


if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "WebServiceObject.php")
	{
		$webObject = new WebServiceObject();
		$webObject->test();
	}
}

?>
