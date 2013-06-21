<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/*
** class OaiProvider :-
**	Provides an OAI-PMH interface as defined by http://www.openarchives.org/OAI/openarchivesprotocol.html
**
** SEE ~emu/master/web/objects/mcag/McagOaiProvider.php FOR A CONFIGURATION EXAMPLE
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . '/texquery.php');
require_once($COMMON_DIR . '/Provider.php');

class
OaiProvider extends Provider
{
	/*
	** Variables providing information on repository.
	**	Must be supplied directly on page.
	*/
	var $RepositoryName	= "";
	var $AdminEmail		= "";
	var $EarliestDatestamp	= "";
	var $MetadataHandlers	= array();
	
	/*
	** Other variables used internally
	*/
	var $version 		= "KE EMu OAI Provider Version 2.0";
	var $protocolVersion	= "2.0";
	var $verb		= "";
	/* 
	** The response eventually contains everything we want to say back
	**	to the Harvestor, and is spat out by $this->ShowResponse(), which
	**	can be thought of as the exit point.
	*/
	var $response 		= "";

	function
	OaiProvider()
	{
		Header("Content-type: text/xml");
		
		/*
		** Standard stuff
		*/
		$this->response = '<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"' . "\n". 
			'	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' . "\n".
			'	xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/' . "\n".
			'	http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">'."\n";

		/*
		** Form standard OAI XML tags
		*/
		$this->response .= $this->responseDateTag();
		$this->response .= $this->responseRequestTag();
	}

	function
	ProcessRequest()
	{
		/*
		** Main switch. Script exists after this.
		**	Die if no valid verb set.
		*/
		if (!isset($_REQUEST['verb']))
		{
			$this->Error("badArgument");
		}
		else
			$this->verb = $_REQUEST['verb'];

		switch ($this->verb)
		{
			case "GetRecord" :
				$this->requestGetRecord();
				break;
			case "Identify" :
				$this->requestIdentify();
				break;
			case "ListIdentifiers" :
				$this->requestListIdentifiers();
				break;
			case "ListMetadataFormats" :
				$this->requestListMetadataFormats();
				break;
			case "ListRecords" :
				$this->requestListRecords();
				break;
			case "ListSets" :
				$this->requestListSets();
				break;
			default:
				$this->Error("badVerb");
		}
	}

	function
	AddHandler(&$handler)
	{
		$format = $handler->Format;
		/*
		** Don't add the Handler if we already have one handling the same format
		*/
		for ($i=0; $i<count($this->MetadataHandlers); $i++)
		{
			if ($this->MetadataHandlers[$i]->Format == $format)
				return 0;
		}
		array_push($this->MetadataHandlers, $handler);
		return 1;
	}

	function
	requestGetRecord()
	{
		/*
		** Check correct arguments
		*/
		if (!isset($_REQUEST['identifier']) || !isset($_REQUEST['metadataPrefix']))
			$this->Error("badArgument");
			
		/* 
		** Choke if we have no handler for the request
	       	*/
		$metadataPrefix = $_REQUEST['metadataPrefix'];
		$metadataHandler = NULL;
		if (!$this->getHandler($metadataHandler, $metadataPrefix))
			$this->Error("cannotDisseminateFormat");

		$response = "";
		if (! $metadataHandler->processGetRecord($response))
			$this->Error($response);
		
		$this->response .= $response;
		$this->ShowResponse();
	}

	function
	requestIdentify()
	{	
		/*
		** Check arguments. Choke if any except for 'verb' set
		*/
		foreach ($_REQUEST as $key => $val)
		{
			if ($key != "verb")
				$this->Error("badArgument");
		}

		/*
		** Form XML and spit out
		*/
		$this->response .= "  <Identify>\n".
			"    <repositoryName>" . $this->RepositoryName . "</repositoryName>\n".
			"    <baseURL>" . $this->BaseURL() . "</baseURL>\n".
			"    <protocolVersion>" . $this->protocolVersion . "</protocolVersion>\n".
			"    <adminEmail>" . $this->AdminEmail . "</adminEmail>\n".
			"    <earliestDatestamp>" . $this->EarliestDatestamp . "</earliestDatestamp>\n".
			"    <deletedRecord>no</deletedRecord>\n".
			"    <granularity>YYYY-MM-DD</granularity>\n".
			"  </Identify>\n";

		$this->ShowResponse();
	}

	function
	requestListIdentifiers()
	{
		/*
		** Check correct arguments
		*/
		$from = "";
		$until = "";
		$startat = 1;
		$metadataPrefix = "";
		/* resumptionToken gives us all we need if it is set */
		if (isset($_REQUEST['resumptionToken']))
		{
			foreach ($_REQUEST as $key => $val)
			{
				if ($key != 'resumptionToken' && $key != 'verb')
					$this->Error('badArgument');
			}

			$this->decodeResumptionToken($startat, $from, $until, $metadataPrefix);
		}
		else
		{
			/* metadataPrefix must be set */
			if (!isset($_REQUEST['metadataPrefix']))
				$this->Error("badArgument");
			$metadataPrefix = $_REQUEST['metadataPrefix'];
			/* we don't support sets */
			if (isset($_REQUEST['set']))
				$this->Error('noSetHierarchy');
			/* if the optional arguments 'from' or 'until' contain time info bail out */
			if (preg_match("/T/", $_REQUEST['from']) || preg_match("/T/", $_REQUEST['until']))
				$this->Error('badArgument');
		}
		
		/* get the right handler */
		$metadataHandler = NULL;
		if (!$this->getHandler($metadataHandler, $metadataPrefix))
		{
			if (isset($_REQUEST['resumptionToken']))
				$this->Error('badResumptionToken');
			else
				$this->Error('cannotDisseminateFormat');
		}
		
		if (isset($_REQUEST['from']))
			$from = $_REQUEST['from'];
		if (isset($_REQUEST['until']))
			$until = $_REQUEST['until'];
		
		$response = "";
		if (! $metadataHandler->processListIdentifiers($startat, $from, $until, $response))
			$this->Error($response);

		$this->response .= $response;
		$this->ShowResponse();
	}

	function
	requestListMetadataFormats()
	{
		/*
		** Check correct arguments
		*/
		if (isset($_REQUEST['identifier']) && !is_numeric($_REQUEST['identifier']))
			$this->Error("badArgument");

		if (isset($_REQUEST['identifier']))
		{
			$qry = new Query();
			$qry->Select = array('irn_1');
			$qry->From = 'ecatalogue';
			$qry->Where = 'irn_1=' . $_REQUEST['identifier'];
			$record = $qry->Fetch();
			if ($qry->Matches != 1)
				$this->Error('idDoesNotExist');
		}

		/*
		** We only support formats defined in $this->MetadataFormats
		*/
		$this->response .= "  <ListMetadataFormats>\n";
		for ($i=0; $i<count($this->MetadataHandlers); $i++)
		{
			$this->response .= $this->MetadataHandlers[$i]->processListMetadataFormats();
		}
		$this->response .= "  </ListMetadataFormats>\n";
			
		$this->ShowResponse();
	}

	function
	requestListRecords()
	{
		/*
		** Check correct arguments
		*/
		$from = "";
		$until = "";
		$startat = 1;
		$metadataPrefix = "";
		/* resumptionToken gives us all we need if it is set */
		if (isset($_REQUEST['resumptionToken']))
		{
			foreach ($_REQUEST as $key => $val)
			{
				if ($key != 'resumptionToken' && $key != 'verb')
				{
					$this->Error('badArgument');
				}
			}

			$this->decodeResumptionToken($startat, $from, $until, $metadataPrefix);
		}
		else
		{
			/* metadataPrefix must be set */
			$metadataPrefix = $_REQUEST['metadataPrefix'];
			if (!isset($metadataPrefix))
				$this->Error("badArgument");
			/* we don't support sets */
			if (isset($_REQUEST['set']))
				$this->Error("noSetHierarchy");
			/* if the optional arguments 'from' or 'until' contain time info bail out */
			if (preg_match("/T/", $_REQUEST['from']) || preg_match("/T/", $_REQUEST['until']))
				$this->Error('badArgument');
		}
		
		/* get the right handler */
		$metadataHandler = NULL;
		if (!$this->getHandler($metadataHandler, $metadataPrefix))
		{
			if (isset($_REQUEST['resumptionToken']))
				$this->Error('badResumptionToken');
			else
				$this->Error('cannotDisseminateFormat');
		}
		
		if (isset($_REQUEST['from']))
			$from = $_REQUEST['from'];
		if (isset($_REQUEST['until']))
			$until = $_REQUEST['until'];

		$response = "";
		if (!$metadataHandler->processListRecords($startat, $from, $until, $response))
			$this->Error($response);

		$this->response .= $response;
		$this->ShowResponse();
	}

	function
	requestListSets()
	{
		/*
		** We don't support sets!
		*/
		$this->Error('noSetHierarchy');
	}

	function
	getHandler(&$handler, $metadataPrefix)
	{
		$found	= 0;
		for($i=0; $i<count($this->MetadataHandlers); $i++)
		{
			if ($this->MetadataHandlers[$i]->Format == $metadataPrefix)
			{
				$handler = $this->MetadataHandlers[$i];
				$found = 1;
				break;
			}
		}

		return $found;
	}

	function
	decodeResumptionToken(&$start, &$from, &$until, &$metadataPrefix)
	{
		$unencoded = base64_decode(urldecode($_REQUEST['resumptionToken']));
		$split = preg_split("/%/", $unencoded, -1);
		$start		= $split[0];
		$from		= $split[1];
		$until		= $split[2];
		$metadataPrefix	= $split[3];
		
		if (isset($split[4]) || !is_numeric($start))
			$this->Error('badResumptionToken');
	}

	function
	responseDateTag()
	{
		$string = "  <responseDate>";

		/*
		** Need to get current date and time in UTC
		*/		
		$time = time();
		$offset = date("Z");
		$time = $time - $offset;
		$formatdate = date("Y-m-d", $time) . "T" . date("H:i:s", $time) . "Z";
		
		$string .= $formatdate . "</responseDate>\n";

		return $string;
	}

	function
	responseRequestTag()
	{
		$string = "  <request";
		foreach ($_REQUEST as $key => $val)
		{
			if ($key != "verb" && $key != "from" && $key != "until" && $key != "identifier"
				&& $key != "metadataPrefix" && key != "set" && $key != "resumptionToken")
			{
				continue;
			}
			if ($key == "from" || $key == "until")
			{
				if (!preg_match("/^\d\d\d\d-\d\d-\d\d$/", $val))
					continue;
			}
			if ($key == "verb")
			{
				if ($val != "Identify" && $val != "GetRecord" && $val != "ListRecords"
					&& $val != "ListSets" && $val != "ListMetadataFormats"
					&& $val != "ListIdentifiers")
				{
					continue;
				}
			}
			if ($key == "identifier")
			{
				if (!is_numeric($val))
					continue;
			}
			$string .= " $key=\"$val\"";
		}
		$string .= ">". $this->baseURL() . "</request>\n";

		return $string;
	}

	function
	baseURL()
	{
		return "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];
	}
	
	function
	Error($errorstring)
	{
		$this->response .= "  <error code=\"$errorstring\" />\n";
		$this->ShowResponse();
		die();
	}		

	function
	ShowResponse()
	{
		$this->response .= "</OAI-PMH>\n";
		print $this->response;
	}
}
?>
