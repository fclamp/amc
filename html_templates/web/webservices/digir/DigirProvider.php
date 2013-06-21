<?php

/*
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($WEB_ROOT . '/webservices/lib/Provider.php');

require_once($WEB_ROOT . '/webservices/digir/Mapping.php');
require_once($WEB_ROOT . '/webservices/digir/DigirRequestParser.php');
require_once($WEB_ROOT . '/webservices/digir/EMuConverter.php');

/*
**
** DigirProvider is Class for handling GENERIC DiGIR requests.
**
** there will need to be client specific parts so a client specific
** class inheriting from this must be implemented
**
** Copyright (c) 1998-2012 KE Software Pty Ltd
**
** @package EMuWebServices
**
*/

class DigirProvider extends Provider
{
	##############
	### PUBLIC ###
	##############

	var $serviceName = 'DigirProvider';
	var $version = 'KE EMu DiGIR Provider 3.0';

	var $serviceDirectory = 'webservices/digir';
	var $inventoryCacheDir = 'webservices/digir/inventory';
	var $inventoryDir;

	var $standard = 'darwin';
	var $encoding = 'ISO-8859-1';

	var $accessPoint = 'unknown';
	var $metadataFile;

	###
	### POPULATED FROM CLIENT SPECIFIC RESOURCE
	###
	var $resourceRestrictions = array(); 	// used to modify texql based on requested resource
	var $suggestedDarwinQuery = array(); 	// for testing: 'DarwinField = value'

	var $maxSearchResponseRecords = 1000;
	var $maxInventoryResponseRecords = 100000000;

	###############
	### PRIVATE ###
	###############

	var $_maintenance = false;
	var $_texql;

	var $_sourceDatabase = 'ecatalogue';	// DATABASE TO QUERY
	var $_diagnostics = array(); 		// STORES DIGIR DIAGNOSTIC MESSAGES

	###
	### FOR INSTANCES OF HELPER/WORKER OBJECTS
	###
	var $_map; 				// FIELD -> COLUMN NAME MAPPING OBJECT
	var $_requestParser; 			// DIGIR REQUEST PARSING OBJECT
	var $_converter; 			// EMU TO DIGIR RESPONSE CONVERTER OBJECT
	var $_clientResources;

	###
	### POPULATED FROM CLIENT SPECIFIC RESOURCE
	###
	var $_metadataName;
	var $_metadataHost;
	var $_metadataResource;
	var $_dateLastUpdated = 'unknown';
	var $_numberOfRecords = 'unknown';

	###
	### POPULATED FROM REQUEST
	###
	var $_requestType;
	var $_resourceCode;
	var $_resourceRestrictions = array();
	var $_requestElements;

	###
	### USED IN CONSTRUCTING RESPONSE
	###
	var $_responseNamespaces = array
	(
		 'xmlns' => 'http://digir.net/schema/protocol/2003/1.0',
	);
	var $_contentNamespaces = array
	(
		 'xmlns:darwin' => 'http://digir.net/schema/conceptual/darwin/2003/1.0',
		 'xmlns:xsd' => 'http://www.w3.org/2001/XMLSchema',
		 'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
	);

######################
### PUBLIC METHODS ###
######################

	function 
	DigirProvider($backendType='' ,$webRoot='' ,$webDirName='' ,$debugOn=0)
	{
		$this->{get_parent_class(__CLASS__)}($backendType, $webRoot, $webDirName, $debugOn);

		$this->metadataFile = "$this->webRoot/$this->serviceDirectory/$this->backendType/metadata.xml";
		global $DIGIR_ACCESS_POINT;
		if (isset($DIGIR_ACCESS_POINT))
			$this->accessPoint = $DIGIR_ACCESS_POINT;
		else
			$this->accessPoint = "http://{$_SERVER['SERVER_NAME']}{$_SERVER['PHP_SELF']}";

		### SET ERROR HANDLER TO CONVERT ALL ERRORS (WELL, ALL THAT CAN 
		### BE HANDLED BY THE ERROR HANDLER) TO DIGIR DIAGNOSITCS
		set_error_handler(array(&$this, "_errorHandler"));

		register_shutdown_function(array(&$this, 'SHUTDOWN'));
	}

	function
	SHUTDOWN()
	{
		echo "\n";
		flush();
		if (connection_aborted())
			$this->log("End DiGIR Request - connection aborted");
	}

	function 
	describe()
	{
		return	
			'A Digir Provider is a Provider that implements a generic DiGIR data provider service' . "\n\n" .
			parent::describe();
	}

	### SET BASE CONFIGURATION
	function 
	configure()
	{
		$clientResources = "$this->webRoot/webservices/digir/$this->backendType/DigirResources.php";
		if (is_readable($clientResources))
		{
			require_once($clientResources);
			$this->_clientResources = new DigirResources;
			if (method_exists($this->_clientResources, 'getEncoding'))
				$this->encoding = $this->_clientResources->getEncoding();
		}
		$factory = new MappingFactory;
		$this->_map =& $factory->getInstance();
		$this->_converter = new EMuResponseConverter($this->_map, $this->encoding, $this->standard);
	}

	function 
	request()
	{
		isset($_REQUEST['request']) ? $xml = $_REQUEST['request'] : $xml = $_REQUEST['doc'];

		if (! isset($xml) || empty($xml))
		{
			$this->_requestType = 'all_resources_metadata';
			return true;
		}

		if (get_magic_quotes_gpc())
		       $xml = stripslashes($xml);
		$xml = rawurldecode($xml);
		$xml = preg_replace('/^\w+=/', '', $xml);

		$headerParser = new DigirHeaderParser();
		if (($header = $headerParser->parseHeader($xml)) === false)
			return false;
		unset($headerParser);

		$this->DebugMessage("XML Request:\n$xml", 1);

		###
		### METADATA REQUESTS DO NOT HAVE TO DEFINE A RESOURCE BUT ALL OTHER REQUESTS DO (THIS LAST
		### REQUIREMENT IS CHECK WHEN PARSING REQUEST HEADER)
		### IF WE HAVE A METADATA REQUEST WITHOUT A RESOURCE THEN DISPLAY THE METADATA FOR ALL OF THE
		### RESOURCES THAT THIS PROVIDER SERVES
		###
		$this->_requestType = strtolower($header['type']);
		if ($this->_requestType === 'metadata')
		{
			if (! isset($header['resource']) || empty($header['resource']))
			{
				$this->_requestType = 'all_resources_metadata';
				return true;
			}
		}
		else if (! $this->emuwebRunning())
		{
			$this->log('EMuWeb not running?');
			$this->setDiagnostic
			(
				'DATABASE_ERROR',  
				'error', 
				'KE EMu web interface is currently Turned OFF'
			);
			return false;
		}

		###
		### INSTANTIATE CLIENT PROVIDER OBJECT
		###
		if (isset($this->_clientResources))
		{
			if (($clientResource = $this->_clientResources->getResource($header['resource'])) === null)
			{
				$this->setDiagnostic
				(
					'INVALID_QUERY',  
					'error', 
					"resource '{$header['resource']}' is not known to this provider"
				);
				return false;
			}
		}

		###
		### GET RESOURCE CODE
		###
		if (isset($clientResource))
		{
			if (method_exists($clientResource, 'getResourceCode'))
				$resourceCode = $clientResource->getResourceCode();
		}

		if (! isset($resourceCode))
		{
			global $DIGIR_RESOURCE_CODE;
			if (! isset($DIGIR_RESOURCE_CODE))
			{
				$mesg = 'could not determine resource code';
				return $this->setError($mesg, __FILE__, __LINE__);
			}
			if (strtolower($DIGIR_RESOURCE_CODE) != strtolower($header['resource']))
			{
				$this->setDiagnostic
				(
					'INVALID_QUERY',  
					'error', 
					"resource '{$header['resource']}' is not known to this provider"
				);
				return false;
			}
			$resourceCode = $DIGIR_RESOURCE_CODE;
		}
		$this->_resourceCode = $resourceCode;

		###
		### SET THE CORRECT INVENTORY DIRECTORY
		###
		$this->inventoryDir = "$this->inventoryCacheDir/" . strtolower($this->_resourceCode);

		###
		### READ WEB STAMPS FOR THIS RESOURCE
		###
		$this->_readWebStamps();

		if ($this->_maintenance === true && $this->_requestType !== 'metadata')
		{
			$this->log('Maintenance is running');
			$this->setDiagnostic
			(
				'GENERAL_ERROR',  
				'error', 
				'Maintenance is currently in progress on the database. Please try again later'
			);
			return false;
		}

		###
		### GET DATA FROM CLIENT PROVIDER (IF ANY)
		###
		if (isset($clientResource))
		{
			if (method_exists($clientResource, 'getMaxSearchResponseRecords'))
				$this->maxSearchResponseRecords = $clientResource->getMaxSearchResponseRecords();

			if (method_exists($clientResource, 'getMaxInventoryResponseRecords'))
				$this->maxInventoryResponseRecords = $clientResource->getMaxInventoryResponseRecords();

			if (method_exists($clientResource, 'getNumberOfRecords'))
				$this->_numberOfRecords = $clientResource->getNumberOfRecords();

			if (method_exists($clientResource, 'getDateLastUpdated'))
				$this->_dateLastUpdated = $clientResource->getDateLastUpdated();
		}

		if ($this->_requestType === 'metadata')
		{
			if (isset($this->_clientResources))
			{
				if (method_exists($this->_clientResources, 'getMetadataName'))
					$this->_metadataName = $this->_clientResources->getMetadataName();

				if (method_exists($this->_clientResources, 'getMetadataHost'))
					$this->_metadataHost = $this->_clientResources->getMetadataHost();
			}

			if (isset($clientResource))
			{
				if (method_exists($clientResource, 'getMetadataResource'))
				{
					$this->_metadataResource = $clientResource->getMetadataResource
					(
						$this->_numberOfRecords,
						$this->_dateLastUpdated, 
						$this->maxSearchResponseRecords,
						$this->maxInventoryResponseRecords
					);
				}
			}
			return true;
		}
		else
		{
			if (isset($clientResource))
			{
				if (method_exists($clientResource, 'getResourceRestrictions'))
					$this->_resourceRestrictions = $clientResource->getResourceRestrictions();

				if (method_exists($clientResource, 'getMappings'))
					$this->_map = $clientResource->getMappings($this->_map);
			}
		}
	
		if (isset($clientResource))
			unset($clientResource);

		$this->_map->checkColumns($this->_sourceDatabase);

    		### INSTANTIATE THE REQUEST PARSER
		$this->_requestParser = new DigirRequestParser($this->_map, $this->inventoryDir);

    		### PARSE THE WHOLE REQUEST
		if (($this->_requestElements = $this->_requestParser->parseRequest($xml, $header)) === false)
		{
			$this->log('Request has parse errors');
			return false;
		}
		return true;
	}

	function 
	response()
	{
		header('Content-type: text/xml');
		echo $this->_startOutput();
		$this->_content($this->_requestType);
		echo $this->_endOutput();
	}

	function 
	errorResponse()
	{
		header('Content-type: text/xml');
		echo $this->_startOutput();
		echo $this->errorResponseMesg();
		echo $this->_endOutput();
	}

	function 
	errorResponseMesg()
	{
		return "\t\t<!-- error detected -->\n";
	}

	#########################
	### OVERRIDEN METHODS ###
	#########################

	### OVERRIDE LOG FUNCTIONS. STORE ANY ERRORS
	function 
	log($message)
	{
		if (BaseWebServiceObject::log($message) === false)
		{
			if (($errors = $this->getLogErrors()) !== false)
			{
				foreach ($errors as $error)
				{
					$this->setDiagnostic('LOG_ERROR', 'error', $error);
				}
			}
			else
			{
				$this->setDiagnostic('LOG_ERROR', 'error', 'Unknown log error');
			}
			return false;
		}
		return true;
	}

	### OVERRIDE FILE TO LOG FUNCTIONS. STORE ANY ERRORS
	function 
	filesToLog($filePaths)
	{
		if (BaseWebServiceObject::filesToLog($filePaths) === false)
		{
			if (($errors = $this->getLogErrors()) !== false)
			{
				foreach ($errors as $error)
				{
					$this->setDiagnostic('LOG_ERROR', 'error', $error);
				}
			}
			else
			{
				$this->setDiagnostic('LOG_ERROR', 'error', 'Unknown log error');
			}
			return false;
		}
		return true;
	}

	### OVERRIDE SET ERROR FUNCTION. STORE ANY ERRORS
	function
	setError($message, $file=null, $line=null)
	{
		$status = BaseWebServiceObject::setError($message, $file, $line);
		$this->setDiagnostic
		(
			'GENERAL_ERROR', 
			'error', 
			$this->getError()
		);
		return $status;
	}

#######################
### PRIVATE METHODS ###
#######################

	#######################
	### REQUEST METHODS ###
	#######################

	function
	_requestAsTexql()
	{
		###
		### GET BASIC ELEMENTS FROM REQUEST
		###

		if (($select = $this->_requestElements['structure']) === null)
			$select = 'irn_1';

		$where = $this->_requestElements['filter'];
		$start = $this->_requestElements['start'];
		$limit = $this->_requestElements['limit'];
		$type = $this->_requestElements['type'];

		###
		### GET LOCAL OBJECT VALUES INDEPENDANT OF REQUEST
		###
		$from = $this->_sourceDatabase;

		###
		### ADD RESOURCE & HARD-WIRED RESTRICTIONS TO TEXQL WHERE
		###
		$restrictions = implode(' AND ', array_merge($this->_resourceRestrictions, $this->_hardWiredRestrictions));
		if (isset($restrictions) && ! empty($restrictions))
		{
			if (isset($where) && ! empty($where))
				$where = "$where AND ($restrictions)";
			else
				$where = $restrictions;
		}

		###
		### ADD MANDATORY STATEMENT TO TEXQL
		###
		if (($mandatory = $this->_map->getMandatory()) !== false)
		{
			if (isset($where) && ! empty($where))
				$where = "$where AND ($mandatory)";
			else
				$where = $mandatory;
		}

		###
		### SET PROPER RANGE VALUES POSSIBLY BASED ON LOCAL OBJECT VALUES
		###
		if (! isset($start))
			$start = 0;
		else
			$start = abs($start);

		if ($type == 'inventory')
		{
			if (! isset($limit) || $limit == 0 || $limit > $this->maxInventoryResponseRecords)
				$limit = $this->maxInventoryResponseRecords;
		}
		else
		{
			if (! isset($limit) || $limit == 0 || $limit > $this->maxSearchResponseRecords)
				$limit = $this->maxSearchResponseRecords;
		}

		### NEED TO SET THE END VALUE TO BE THE START VALUE + THE LIMIT VALUE
		$end = $start + abs($limit);
			
		### NEED TO INCREMENT THE START VALUE BY 1 AS DIGIR COUNTS RECORDS FROM 0 BUT TEXQL 
		### COUNTS RECORDS FROM 1
		$start++;

		### SET THE TEXQL RANGE VALUES
		$range = '{' . "$start to $end" . '}';

		$texql = "(SELECT $select FROM $from WHERE $where)$range";
		$encoding = mb_detect_encoding($texql);
		if (strtolower($encoding) != strtolower($this->encoding))
			$texql = mb_convert_encoding($texql, $this->encoding, $encoding);
		$this->_texql = $texql;

		return $texql;
	}


	################################
	### CONTENT/OUTPUT FUNCTIONS ###
	################################

	function 
	_startOutput()
	{
		### BEGIN XML HEADERS
		$header = '';
		$header .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		### END XML HEADERS

		### BEGIN RESPONSE
		$header .= '<response';
		if ((list($nameSpace, $uri) = each($this->_responseNamespaces)) !== false)
			$header .= " $nameSpace='$uri'";
		while (list($nameSpace, $uri) = each($this->_responseNamespaces))
			$header .= "\n\t\t $nameSpace='$uri'";
		$header .= ">\n";

		$header .= "\t<header>\n" .
		           "\t\t<version>$this->version</version>\n" .
		           "\t\t<sendTime>" . $this->timeStamp(time()) . "</sendTime>\n";

		$requestType = $this->_requestType;
		if (! isset($requestType))
			$requestType = 'unknown';
		else if ($requestType == 'all_resources_metadata')
			$requestType = 'metadata';

		$header .= "\t\t<source";
		if ($requestType !== 'metadata' && isset($this->_resourceCode) && ! empty($this->_resourceCode))
			$header .= " resource='" . $this->_resourceCode . "'";
		$header .= ">$this->accessPoint</source>\n" .
			   "\t\t<destination>" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "</destination>\n" .
			   "\t\t<type>$requestType</type>\n" .
		      	   "\t</header>\n";

		### BEGIN CONTENT
  		$header .= "\t<content";
		if ((list($nameSpace, $uri) = each($this->_contentNamespaces)) !== false)
			$header .= " $nameSpace='$uri'";
		while (list($nameSpace, $uri) = each($this->_contentNamespaces))
			$header .= "\n\t\t $nameSpace='$uri'";
		$header .= ">\n";

		return $header;
	}

	function 
	_endOutput()
	{
		$footer = '';
  		$footer .= "\t</content>\n";
		### END CONTENT

		### BEGIN DIAGNOSTICS
  		$footer .= "\t<diagnostics>\n";
		foreach ($this->_normaliseDiagnostics() as $diagnostic)
  			$footer .= "\t\t$diagnostic\n";
  		$footer .= "\t</diagnostics>\n";
		### END DIAGNOSTICS

		$footer .= "</response>\n";
		### END RESPONSE
		
		return $footer;
	}

	function 
	_content($type)
	{
		switch ($type)
		{
			case 'search':
				$files = $this->_generateSearchContent();
				break;
			case 'inventory':
				$files = $this->_generateInventoryContent();
				break;
			case 'metadata':
				$files = $this->_generateMetadataContent();
				break;
			case 'all_resources_metadata':
			default:
				$files = $this->_generateAllMetadataContent();
				break;
		}

		if ($this->_debugOn && isset($this->_texql))
		{
			### 
			### REPLACE "--" WITH SOMETHING ELSE AS THEY ARE NOT ALLOWED IN XML COMMENTS.
			### BELIEVE IT OR NOT THEY DO SHOW UP IN TEXQL QUERIES.
			### SEE http://www.w3.org/TR/REC-xml/#sec-comments
			###
			$texql = preg_replace('/--/', '-\-', $this->_texql);
			echo "\t\t<!-- $texql -->\n";
		}

		### IF FILES IS EQUAL TO FALSE THEN 
		### - AN ERROR OCCURRED GENERATING THE CONTENT
		###
		### IF FILES IS EQUAL TO NULL THEN EITHER
		### - WE HAVE ALREADY OUTPUTTED CONTENT I.E. UNFILTERED INVENTORY REQUEST OR METADATA
		### - THERE WAS NO CONTENT E.G. NO RECORDS MATCHED THE QUERY
		if ($files === false)
		{
			echo $this->errorResponseMesg();
		}
		else if ($files !== null)
		{
			if ($this->_outputContent($files) === false)
				echo $this->errorResponseMesg();
		}
	}

	function 
	_generateSearchContent()
	{
		if (($outputFiles = $this->searchToFile($this->_requestAsTexql(), $matchCount)) === false)
			return false;

		if ($matchCount == 0)
		{
			$this->setDiagnostic
			(
				'QUERY_PRODUCED_NO_RESULTS', 
				'warning', 
				'query returned an empty result set'
			);
			return null;
		}

		return $this->_emuToDigirResponse($outputFiles, $matchCount);
	}

	function 
	_generateInventoryContent()
	{
		###
		### INVENTORY REQUEST IS UNFILTERED
		### TRY TO READ DIGIR INVENTORY FILE
		###
		if (! isset($this->_requestElements['filter']) || empty($this->_requestElements['filter']))
		{
			$field = $this->_requestElements['fields'];

			###
			### IF THE MAPPING IS A REFERENCE TO ANOTHER FIELD THEN GET THAT FIELD NAME INSTEAD
			###
			if (($fieldname = $this->_map->getField($field)) === false)
			{
				$this->setDiagnostic
        		       	(
					'INVALID_QUERY_TERM',
					'error',
					"requested field '$field' is not known to this provider"
        		       	);
				return false;
			}

			$mesg = "Unfiltered inventory request for $field";
			if ($field != $fieldname)
				$mesg .= " ($fieldname)";
			$this->log($mesg);

			$inventoryFile = "$this->webRoot/$this->inventoryDir/$fieldname.xml";
			if ($this->_outputInventoryFile($inventoryFile) !== false)
				return null;

			$this->log("Unfiltered inventory request failed for $field; querying for inventory..");
		}

		###
		### INVENTORY REQUEST IS FILTERED OR ERROR OCCURED DISPLAYING INVENTORY FILE
		###
		if (($outputFiles = $this->searchToFile($this->_requestAsTexql(), $matchCount)) === false)
			return false;

		if ($matchCount == 0)
		{
			$this->setDiagnostic
			(
				'QUERY_PRODUCED_NO_RESULTS', 
				'warning', 
				'query returned an empty result set'
			);
			return null;
		}

		return $this->_emuToDigirResponse($outputFiles, $matchCount);
	}

	function 
	_generateMetadataContent()
	{
		if (is_file($this->metadataFile))
		{
			$file = $this->metadataFile;	
		}
		else 
		{
			if (isset($this->_metadataName) &&
			    isset($this->_metadataHost) &&
			    isset($this->_metadataResource))
			{
				
				$this->_metadataName = preg_replace('/^\s+|\s+$/', '', $this->_metadataName);
				$this->_metadataHost = preg_replace('/^\s+|\s+$/', '', $this->_metadataHost);
				$this->_metadataResource = preg_replace('/^\s+|\s+$/', '', $this->_metadataResource);

				echo <<<EOT
		<metadata>
			<provider>
				<name>$this->_metadataName</name>
				<accessPoint>$this->accessPoint</accessPoint>
				<implementation>$this->version</implementation>
				<host>
					$this->_metadataHost
				</host>
				<resource>
					$this->_metadataResource
				</resource>
			</provider>
		</metadata>

EOT;
			}
			else
			{
				$mesg = 'metadata details have not been specified or specification is incomplete';
				return $this->setError($mesg, __FILE__, __LINE__);
			}
		}
		return $file;
	}

	function 
	_generateAllMetadataContent()
	{
		if (is_file($this->metadataFile))
		{
			$file = $this->metadataFile;	
		}
		else 
		{
			if (! isset($this->_clientResources))
			{
				$mesg = 'client resource object has not been specified';
				return $this->setError($mesg, __FILE__, __LINE__);
			}

			if (method_exists($this->_clientResources, 'getMetadataName'))
				$metadataName = $this->_clientResources->getMetadataName();

			if (method_exists($this->_clientResources, 'getMetadataHost'))
				$metadataHost = $this->_clientResources->getMetadataHost();

			if (empty($metadataName) || empty($metadataHost))
			{
				$mesg = 'client metadata details have not been specified or specification is incomplete';
				return $this->setError($mesg, __FILE__, __LINE__);
			}

			if (method_exists($this->_clientResources, 'getResourceCodes'))
				$resourceCodes = $this->_clientResources->getResourceCodes();

			if (empty($resourceCodes))
			{
				$mesg = 'client resource codes have not been specified for this provider';
				return $this->setError($mesg, __FILE__, __LINE__);
			}
			
			$allResourceMetadata = '';
			foreach ($resourceCodes as $resourceCode)
			{
				###
				### INSTANTIATE CLIENT PROVIDER OBJECT
				###
				$clientResource = $this->_clientResources->getResource($resourceCode);

				if (empty($clientResource))
				{
					$this->setDiagnostic
					(
						'GENERAL_ERROR',  
						'error', 
						"resource '$resourceCode' is not known to this provider"
					);
					continue;
				}

				if (method_exists($clientResource, 'getMaxSearchResponseRecords'))
					$this->maxSearchResponseRecords = $clientResource->getMaxSearchResponseRecords();

				if (method_exists($clientResource, 'getMaxInventoryResponseRecords'))
					$this->maxInventoryResponseRecords = $clientResource->getMaxInventoryResponseRecords();

				if (method_exists($clientResource, 'getNumberOfRecords'))
					$this->_numberOfRecords = $clientResource->getNumberOfRecords();
				else
					$this->_numberOfRecords = $this->_getNumberOfRecordsWebStamp($resourceCode);

				if (method_exists($clientResource, 'getDateLastUpdated'))
					$this->_dateLastUpdated = $clientResource->getDateLastUpdated();
				else
					$this->_dateLastUpdated = $this->_getDateLastUpdatedWebStamp();

				if (method_exists($clientResource, 'getMetadataResource'))
				{
					$resourceMetadata = $clientResource->getMetadataResource
					(
						$this->_numberOfRecords,
						$this->_dateLastUpdated, 
						$this->maxSearchResponseRecords,
						$this->maxInventoryResponseRecords
					);
				}

				if (! empty($resourceMetadata))
				{
					$resourceMetadata = preg_replace('/^\s+|\s+$/', '', $resourceMetadata);

					$allResourceMetadata .= <<<EOT
				<resource>
					$resourceMetadata
				</resource>

EOT;
					unset($resourceMetadata);
				}
				else
				{
					$this->setDiagnostic
					(
						'GENERAL_WARNING',  
						'error', 
						"could not generate resource metadata for resource '$resourceCode'"
					);
					continue;
				}
			}

			if (! empty($allResourceMetadata))
			{
				$metadataName = preg_replace('/^\s+|\s+$/', '', $metadataName);
				$metadataHost = preg_replace('/^\s+|\s+$/', '', $metadataHost);
				$allResourceMetadata = preg_replace('/^\s+|\s+$/', '', $allResourceMetadata);

				echo <<<EOT
		<metadata>
			<provider>
				<name>$metadataName</name>
				<accessPoint>$this->accessPoint</accessPoint>
				<implementation>$this->version</implementation>
				<host>
					$metadataHost
				</host>
				$allResourceMetadata
			</provider>
		</metadata>

EOT;
			}
			else
			{
				$mesg = 'no resource metadata could be generated';
				return $this->setError($mesg, __FILE__, __LINE__);
			}
		}

		return $file;
	}

	function 
	_outputContent($files)
	{
		if (isset($files))
		{
			if (! is_array($files))
				$files = array($files);

			foreach ($files as $file)
			{
                		if (($fileHandle = fopen($file, 'rb')) === false)
                		{
                		        $mesg = "could not open file $file for reading";
                		        return $this->setError($mesg, __FILE__, __LINE__);
                		}

                		if (fpassthru($fileHandle) === false)
                		{
                		        fclose($fileHandle);
                		        $mesg = "could not read from file $file";
                		        return $this->setError($mesg, __FILE__, __LINE__);
                		}
                		fclose($fileHandle);
			}
		}
		return true;
	}

	function 
	_outputInventoryFile($file)
	{
		$status = true;
		$matches = 0;
		$count = 0;

		if (! is_file($file))
		{
			$this->log("could not find inventory file $file");
			return false;
		}

		if (($fileHandle = fopen($file, 'rb')) === false)
		{
			$mesg = "could not open inventory file $file for reading";
			return $this->setError($mesg, __FILE__, __LINE__);
		}
		
		if (($results = trim(fgets($fileHandle))) === false)
		{
			$mesg = "could not read from inventory file $file";
			$status = $this->setError($mesg, __FILE__, __LINE__);
		}
		else
		{
			if (preg_match("/matches='(\d+)'/" ,$results, $match))
				$matches = $match[1];

			while (! feof($fileHandle))
			{
				if ($count >= $matches || $count >= $this->maxInventoryResponseRecords)
					break;

				for ($i = 0; $i < 3; $i++)
				{
					if (($line = rtrim(fgets($fileHandle))) === false)
					{
						$mesg = "could not read from inventory file $file";
						$status = $this->setError($mesg, __FILE__, __LINE__);
						break 2;
					}

					if ($i == 1 && $this->_requestElements['count'] !== true)
					{
						echo "\t" . preg_replace("/\s+count='\d+'>/", '>', $line) . "\n";
						continue;
					}
					echo "\t$line\n";
				}
				$count++;
			}
		}
		fclose($fileHandle);

		if ($status === false)
			return false;

		$this->setDiagnostic('RECORD_COUNT', 'info', $matches);
		$this->setDiagnostic('MATCH_COUNT', 'info', $matches);
		$this->setDiagnostic('END_OF_RECORDS', 'info', 'true');
		if ($matches == 0)
			$this->setDiagnostic('QUERY_PRODUCED_NO_RESULTS', 'warning', 'query returned an empty result set');

		return true;
	}


	function 
	_emuToDigirResponse($emuFiles, $matchCount)
	{
		if (($digirFiles = $this->_converter->convert($this->_requestElements, $emuFiles, $recordCount)) === false)
		{
			$this->log('error converting texxmlserver response');
			return false;
		}

		if ($recordCount == 0)
		{
			$this->setDiagnostic('GENERAL_ERROR', 'error', 'could not convert KE EMu XML response to DiGIR XML response');
			return false;
		}
		else
		{
			$this->setDiagnostic('RECORD_COUNT',   'info', $recordCount);
			$this->setDiagnostic('MATCH_COUNT',    'info', $matchCount);

			$start = $this->_requestElements['start'];
			if (! isset($start))
				$start = 0;
			else
				$start = abs($start);

			if (($start + $recordCount) < $matchCount)
				$this->setDiagnostic('END_OF_RECORDS', 'info', 'false');
			else	
				$this->setDiagnostic('END_OF_RECORDS', 'info', 'true');
		}
		return $digirFiles;
	}

	function 
	_readWebStamps()
	{
		$this->_dateLastUpdated = $this->_getDateLastUpdatedWebStamp();
		$this->_numberOfRecords = $this->_getNumberOfRecordsWebStamp($this->_resourceCode);

		if (isset($this->webRoot))
		{
			if (file_exists(realpath("{$this->webRoot}/../.maintenance")))
				$this->_maintenance = true;
		}

	}

	function
	_getDateLastUpdatedWebStamp()
	{
		$dateLastUpdated = 'unknown';
		if (isset($this->webRoot))
		{
			$path = realpath("{$this->webRoot}/..");
			foreach(glob("$path/.emu_web_env*") as $file)
			{
				$file = basename($file);
				if (preg_match('/^\.emu_web_env-(\d{4})-(\d{2})-(\d{2})-(\d{2})-(\d{2})$/i', $file, $match))
					$dateLastUpdated = "$match[1]-$match[2]-$match[3]T$match[4]:$match[5]:00Z";
			}
		}
		return $dateLastUpdated;
	}

	function
	_getNumberOfRecordsWebStamp($resourceCode)
	{
		$numberOfRecords = 'unknown';
		if (isset($this->webRoot))
		{
			$path = realpath("{$this->webRoot}/..");
			foreach(glob("$path/.emu_web_env*") as $file)
			{
				$file = basename($file);
				if (preg_match("/^\.emu_web_env-digir-$resourceCode-(\d+)$/i", $file, $match))
					$numberOfRecords = $match[1];
			}
		}
		return $numberOfRecords;
	}

	###########################
	### DIAGNOSTICS METHODS ###
	###########################

	function 
	setDiagnostic($code, $severity, $message)
	{
		$message = $this->encodeXmlSpecialChars($message);
		$diagnostics = "<diagnostic code='$code' severity='$severity'>$message</diagnostic>";

		if (! isset($this->_diagnostics[$diagnostics]))
			$this->_diagnostics[$diagnostics] = 1;
		else
			$this->_diagnostics[$diagnostics]++;
	}

	function 
	_normaliseDiagnostics()
	{
		$diagnostics = array();
		foreach ($this->_diagnostics as $diagnostic => $count)
		{
			if ($count > 1)
				$diagnostics[] = preg_replace('/(<\/diag)/', " (detected $count times)$1", $diagnostic);
			else
				$diagnostics[] = $diagnostic;
		}
		return $diagnostics;
	}

	function 
	_errorHandler($num, $str, $file, $line)
	{
		### HANDLE USER GENERATED ERROS
		if ($num == E_USER_ERROR || $num == E_USER_WARNING || $num == E_USER_NOTICE)
		{
			list($code, $severity, $message) = preg_split('/:/', $str, 3);
			$this->setDiagnostic($code, $severity, $message);
		}
		else if ($num == E_NOTICE || $num == E_STRICT)
		{
			return false;
		}
		else ### HANDLE PHP GENERATED ERRORS
		{
			$this->setDiagnostic('PHP_ERROR', $num, "$str in $file on line $line");
		}
		return true;
	}


	##########################################
	### DATA FORMATTING/CONVERSION METHODS ###
	##########################################

	function 
	timeStamp($unixTime)
	{
		return strftime('%Y-%m-%d %H:%M:%S.00Z', $unixTime);
	}

	function 
	emuDate2JulianDay($emuDate)
	{
		if (! $emuDate)
			return '' ;

		$months = array
		(
			'Jan' => '1' ,
 			'Feb' => '2',
 			'Mar' => '3',
 			'Apr' => '4',
 			'May' => '5',
			'Jun' => '6',
 			'Jul' => '7',
 			'Aug' => '8',
 			'Sep' => '9',
 			'Oct' => 10,
 			'Nov' => 11,
 			'Dec' => 12
		);
		
		list ($day, $mon, $yr) = preg_split('/\s+|\//', $emuDate);

		$mon = preg_replace('/^0/', '', $mon);
		if (isset($month[$mon]))
			$mon = $months[$mon];

		$jDays = array
		(
			0,
			31,
			59,
			90,
			120,
			151,
			181,
			212,
			243,
			273,
			304, 
			334
		);

		$jd = $jDays[$mon-1] + $day;

		// leap years are divisible by 4 AND ((divisible by 400) or (! divisible by 100))
		if ($yr % 4 == 0 && ($yr % 100 != 0 || $yr % 400 == 0))
		{
			# a leap year - add day if later than feb 28th
			if ($mon > 2 || ($mon == 2 && $day == 29))
				$jd++;
		}
		return $jd;
	}

	function 
	emuDateComponent($emuDate, $wantedComponent)
	{
		if (! $emuDate)
		{
			return '';
		}

		$months = array
		(
			'Jan' => '1' ,
 			'Feb' => '2',
 			'Mar' => '3',
 			'Apr' => '4',
 			'May' => '5',
			'Jun' => '6',
 			'Jul' => '7',
 			'Aug' => '8',
 			'Sep' => '9',
 			'Oct' => 10,
 			'Nov' => 11,
 			'Dec' => 12
		);

		list ($day, $mon, $yr) = preg_split('/\s+|\//', $emuDate);
		$mon = preg_replace('/^0/', '', $mon);

		if (isset($month[$mon]))
		{
			$mon = $month[$mon];
		}

		switch($wantedComponent)
		{
			case 'Day':
				return $day;
				break;
			case 'Month':
				return $mon;
				break;
			case 'Year':
				return $yr;
				break;
			default:
				return false;
				break;
		}
	}

	function 
	emuLatLongToDecimal($emuLatLong)
	{
		if (! $emuLatLong)
			return '';

		$emuLatLong = preg_replace('/^\s+|\s+$/','',$emuLatLong);

		if (! $emuLatLong)
			return '';

		list ($deg,$min,$sec,$hem) = preg_split('/\s+/',$emuLatLong);

	
		$deg = $deg + $min/60 + $sec/3600;

		if (preg_match('/S|W/',$hem))
			$deg = -$deg;

		return sprintf ('%8.5f',$deg);
	}
}
?>
