<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/WebServiceObject.php');
require_once ($WEB_ROOT . '/objects/common/DataCacher.php');
require_once ($WEB_ROOT . '/objects/common/SourceFactory.php');
require_once ($WEB_ROOT . '/objects/'. $GLOBALS[BACKEND_TYPE] .'/TranslatorFactory.php');

// status conditions
define('st_OK',0);
define('st_Unread',1);
define('st_Reading',2);
define('st_Completed',3);
define('st_TimeOutNoResponse',4);
define('st_TimeOutPartialResponse',5);
define('st_Unknown',6);
define('st_Warn',7);
define('st_UsingCachedData',8);

/**
 * Class PortalSource
 *
 * A Portal source is an interface to a WebService data provider that can be
 * used by the portal to get data
 *
 * PortalSource is an abstract base class that defines the behaviour of a
 * portal source. 
 *
 * Actual source implementations should inherit from this 
 *
 * Typically there will be a 'Type' Source class derived from this class (eg
 * DiGIR,OAI etc) and from these actual Source connectors will be created
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class PortalSource extends WebServiceObject
{

	var $serviceName = "PortalSource";
	var $sourceName = "generic Portal Source";
	var $hostname = "localhost";
	var $port = 80;
	var $timeout = 30;
	var $enabled = true; 	// set to false to make it not participate in a
				// portal system

	var $cacheIsOn = true;

	var $preferredRGB = '#ffffff';
	var $preferredFgRGB = '#000000';
	var $preferredIcon = '';

	var $translatorType = '';

	// these provided as guide - override in children
	var $exampleQueryTerms = Array(
		"field0" => "value0",
		"field1" => "value1",
	);

	var $_translator = null;
	var $_cacher = null;
	var $_isCached = false;
	var $_index = '';

	var $instanceDir = '';

	var $_parameters = array();
	var $_data = array();

	var $_blockSize = 4096;
	var $_socket = null;
	var $_startTime = 0;  // time of first communication
	var $_status = st_Unread;

	function PortalSource($instanceDir='',$backendType='',$webRoot='',$webDirName='',$debugOn='')
	{
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);

		if ($this->translatorType)
			if ($translatorFactory = new TranslatorFactory($backendType,$webRoot,$webDirName,$debugOn))
				$this->_translator = $translatorFactory->getInstance($this->translatorType);

		$this->_cacher = new DataCacher($this->backendType,$this->webRoot,$this->webDirName,$this->debugOn);

		if (! $instanceDir)
		{
			$fac = new SourceFactory('');
			$instanceDir = $fac->getSourceDirectory();
		}
		$this->instanceDir = $instanceDir;
	}

	function setCacheOn($bool)
	{
		$this->cacheIsOn = $bool;
	}

	function makeUrl()
	{
		$this->_makeThisAbstractMethod('makeUrl');
	}

	function exampleQueryTerms()
	{
		return $this->exampleQueryTerms;
	}

	function testQueryTerms()
	{
		foreach ($this->exampleQueryTerms as $field => $value)
		{
			$terms[] = "$field = <input type='text' name='qry_$field' value='$value' />";
		}
		return implode($terms,"\nOR<br/>");
	}

	function makeIndex()
	{
		// mechanism for making an index for caching lookup of a
		// request.
		$this->_makeThisAbstractMethod('makeIndex');
	}

	function makeGetHeader($page,$remote,$port,$authent)	
	{
		return "GET http://$remote:$port/$page HTTP/1.0\r\n".
		"Accept: text/html, text/plain, text/sgml, */*;q=0.01\r\n".
		"User-Agent: KE Software EMu2-Portal\r\n\r\n";
	}
	function makePostHeader($page,$remote,$port,$authent,$params)	
	{
		$postVars = array();
		foreach ($params as $arg => $value)
		{
			$postVars[] = $arg . "=" . urlencode($value);
		}
		$post = implode($postVars,'&');

		$length = strlen($post);
		if ($authent)
			$authent .= "\r\n";

		return "POST /$page HTTP/1.0\r\n".
		"Host: $remote:$port\r\n".
		$authent.
		"Accept: text/html, text/plain, text/sgml, */*;q=0.01\r\n".
		"Accept-Encoding:\r\n".
		"Accept-Language:\r\n".
		"Pragma: no-cache\r\n".
		"Cache-Control: no-cache\r\n".
		"User-Agent: KE Software EMu2-Portal\r\n".
		"Content-type: application/x-www-form-urlencoded\r\n".
		"Content-length: $length\r\n\r\n".
		$post;
	}

	function request($timeout,$parameters=null)
	{
		/*  Build the query and connect using a non-blocking
		**  socket, then return.
		*/

		// need to tidy this up so sources can independently get
		// customised cgi parameters rather than always using _REQUEST
		// more elegantly than clobbering _REQUEST

		if ($parameters)
			$_REQUEST = $parameters;

		$this->_index = $this->makeIndex();
		if ($this->cacheIsOn && $this->_cacher->exists($this->_index))
		{
			$this->_isCached = true;
			$this->_log("<action>skipping connection as data is cached locally</action>");
			$this->setStatus(st_Reading);
			$this->_startTime = time();
		}
		else
		{
			list($page,$host,$port,$authentication,$this->parameters) = $this->makeUrl();

			$this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

			if ($timeout)
				$this->timeout = $timeout;

			if (! $this->_socket )
    				$this->errorResponse("Error creating socket to $url: $errstr ($errno)\n");
			else if (@socket_connect($this->_socket, $this->hostname, $this->port))
			{
				if ($this->parameters)
					$post = $this->makePostHeader($page,$host,$port,$authentication,$this->parameters)	;
				else	
					$post = $this->makeGetHeader($page,$host,$port,$authentication)	;

		       		socket_write($this->_socket, $post, strlen($post));
				$this->_startTime = time();
				$this->setStatus(st_Reading);
				$this->_log("<action>POSTing to $host:$port /$page</action>");
				//$this->_log(urldecode($post));
			}
			else
    				$this->errorResponse("Error connecting socket to $this->hostname:$this->port (". 
					socket_last_error() .", ".  socket_strerror(socket_last_error()) .  ")\n");
		}	

		return 0;
	}

	function process()
	{
		/* see if any to be processed. Return true if still not
		 * finished querying data source and retrieving results.
		 * Note a 'Finite State Machine' needs to be used here
		 * to control flow.
		 */

		$elapsed = time() - $this->_startTime;

		if ($this->cacheIsOn && $this->_isCached)
		{
			if ($this->_cacher->exists($this->_index))
			{
				$this->_data[] = $this->_cacher->retrieve($this->_index);
				$this->setStatus(st_UsingCachedData);
				$this->_log("returned locally cached data: Time elapsed: $elapsed secs");
				return false;
			}
			else
			{
				$this->errorResponse("Index ".$this->_index ." dont exist");
			}
		}
		else if ($this->_socket != null)
		{
			/*  Perform a non-blocking select to see if there is
			 *  something to be processed.
			 */

			if ($elapsed > $this->timeout)
			{
				socket_shutdown($this->_socket);
				socket_close($this->_socket);
				$this->_socket = null;
				if (count($this->_data) > 0)
				{
					$this->setStatus(st_TimeOutPartialResponse);
					$this->_data = array();
				}
				else	
					$this->setStatus(st_TimeOutNoResponse);

				$this->_log("Connection closed by source due to timeout: Time elapsed: $elapsed secs");
				return false;
			}

			socket_set_nonblock($this->_socket);
			$sockets = array($this->_socket);

			if (socket_select($sockets,$w=null,$e=null,0,10))
			{
				$data = '';
				$status = socket_recv($this->_socket, $data, $this->_blockSize,0);
				if ($status > 0)
				{
					// Got data
					if (count($this->_data) == 0)
					{
						$data =	preg_replace('/^HTTP.+?</is','<',$data);
						$data = preg_replace('/<\?xml.*?\?>/','',$data);
					}
					$data = preg_replace('/& /','&amp; ',$data);
					$this->_data[] = $data;
					return true;
				}
				else if ($status == false)
				{
					// socket closed at other end
					$this->setStatus(st_Completed);
					socket_shutdown($this->_socket);
					socket_close($this->_socket);
					$this->_socket = null;
					$this->_log("Connection closed by provider: Time elapsed: $elapsed secs");
					return false;
				}
				else
				{
					// ?? should not come here - select
					// shouldn't have triggered if nothing
					// to read.  Assume it means eof
					$this->setStatus(st_Completed);
					socket_shutdown($this->_socket);
					socket_close($this->_socket);
					$this->_socket = null;
					$this->_log("time elapsed getting response: $elapsed");
					return false;
				}
			}
			else
			{
				// nothing heard yet - keep connection alive
				return true;
			}
		}
		else
			return false;
	}

	function setWantedGroups()
	{
		// use the source's _translator property's addPotentialGroups()
		// method to set the fields that will be extracted from
		// returned data.  This will be specific to both the source
		// flavour (eg DiGIR) and the requirements of the portal

		$this->_makeThisAbstractMethod('setWantedGroups');
	}

	function metaData()
	{
		$status = $this->statusAsString();
		$found = count($this->_translator->records);
		return "<source name='".  $this->sourceName .
			"' translator='".  $this->translatorType .
			"' recordsTranslated='$found' status='$status'".
			" preferredRGB='".  $this->preferredRGB .
			"' preferredFgRGB='".  $this->preferredFgRGB .
			"' preferredIcon='".  $this->preferredIcon ."' />";
	}

	function requestAndProcess($timeout)
	{
		// this method normally only used for testing only

		$this->request($timeOut);
		$handling = true;
		while ($handling)
		{
			$handling = false;

			if ($this->getStatus() == st_Reading)
				if ($this->process())
					$handling = true;
		}

		$translator = $this->getData();

		if (isset($_REQUEST['map']))
		{
			$this->sendMap();
			return;
		}
		if (isset($_REQUEST['stylesheet']) && ! isset($_REQUEST['transform']))
		{
			// client side XSLT
			header("Content-type: text/xml",1);
			print $this->sendClientXslt($_REQUEST['stylesheet']);
			return;
		}

		if (isset($_REQUEST['source']) && isset($_REQUEST['transform']))
		{
			// transform using template or server side xslt
			$transform = TransformationFactory($_REQUEST['transform']);
			$transform->transform($resultsFile, $_REQUEST['source']);
			return;
		}

		// no processing requested - spit back raw xml

		return $this->sendResults();
	}

	function getData($cacheTranslation = true)
	{
		/*  Retrieve the results of the query. Used to merge
		**  results.
		**  Returns a translator object.
		*/

		$index = 'cacheTranslation:' . $this->makeIndex();
		if ($cacheTranslation)
			if ($this->_translator->retrieveState($index,$this->_cacher))
				return $this->_translator;

		$data =	implode($this->_data,"");

		if (! $this->_isCached)
		{
			$this->_cacher->save($this->_index,$data);
			$this->_isCached = true;
		}

		$this->setWantedGroups();

		$this->_translator->translate($data);

		if ($cacheTranslation)
			$this->_translator->saveState($index,$this->_cacher);

		return $this->_translator;

	}

	function sendMap()
	{
		/*  Generate a map and send back Mapper XML with
		**  embedded <data> tag containing results filename.
		*/
		return  "<xml><!--Cannot do sendMap yet ! (see sendMap in PortalSource.php) --></xml>";
	}

	function sendClientXslt($stylesheet)
	{
		/*  Send the result set to the client with the supplied
		**  styelsheet linked in.
		*/
		return  "<?xml version='1.0' encoding='ISO-8859-1' ?>\n".
                        "<?xml-stylesheet type='text/xsl' ".
                        " href='$stylesheet'?>\n".
			$this->sendResults();
	}

	function sendResults($start=0,$limit=-1)
	{
		/*  Send the generated results back to the client.  */
		$groups = $this->_translator->getGroups();

		$current = 0;
		$found = 0;

		$records = array();

		while ($this->_translator->nextRecord())
		{
			if ($limit != -1 && $found >= $limit)
				break;

			$translated = '';
			if ($current >= $start)
			{
				$found++;
				$translated .= "\t<record index='$current'>\n";
				$translated .= "\t\t<description>".  $this->_translator->getDescription() ."</description>\n";

				$translated .= "\t\t<recordSource>". $this->sourceName ."</recordSource>\n";
				foreach ($groups as $group)
				{
					if ($value =  $this->_translator->getGroup($group))
						$translated .= "\t\t<group name='$group'>$value</group>\n";
				}
				$translated .= "\t</record>\n";
			}
			$current++;
			$records[] = $translated;
		}

		$metaData = array();
		$metaData[] = "<translation source='". $this->sourceName ."' ".
					"translator='".  $this->translatorType .
					"' recordsTranslated='$found'>";
		$metaData[] = "<groups>";
		foreach ($groups as $group)
		{
			$metaData[] = "\t<group>$group</group>";
		}
		$metaData[] = "</groups>";
		$metaData[] = "</translation>";

		return "<xml>\n". 
			implode("\n",$metaData) ."\n" .
			implode("\n",$records) ."\n" .
			"</xml>";
	}

	function timeStamp($unixTime)
	{
		return strftime("%Y-%m-%d %H:%M:%S.00Z",$unixTime);
	}

	function statusAsString()
	{
		switch($this->getStatus())
		{
			case st_OK:
				return 'OK';
				break;
			case st_Unread:
				return 'unread';
				break;
			case st_Reading:
				return 'reading';
				break;
			case st_Completed:
				return 'completed';
				break;
			case st_TimeOutNoResponse:
				return 'timeout no response';
				break;
			case st_TimeOutPartialResponse:
				return 'timeout partial response';
				break;
			case st_Warn:
				return 'Warning';
				break;
			case st_UsingCachedData:
				return 'using cached data';
			case st_Unknown:
			default:	
				return 'unknown';
				break;
		}	
	}

	function setStatus($status)
	{
		$this->_status = $status;
	}

	function getStatus()
	{
		return $this->_status;
	}

	function describe()
	{
		return
			"A Portal Source is a generic system that knows\n".
			" how to talk with a data provider\n\n".
			Parent::describe();
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "PortalSource.php")
	{
		$webObject = new PortalSource();
		$webObject->test();
	}
}

?>
