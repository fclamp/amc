<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



/* Implements a Generic DiGIR provider service */


/* This file defines three classes
 * 
 * 1. DigirProvider extends Provider
 *    a base Digir Class inherited from a Provider class
 *    client specific Digir Providers inherit from this class
 *
 * 2. _DigirRequestParser
 *    class used by DigirProvider to assist DigirProvider in extracting
 *    and interpreting components of a digir request
 *    This class should be considered private to DigirProvider
 *
 * 3. _EmuToDarwinTranslator
 *    class used by DigirProvider to assst in taking an EMu xml
 *    and translating it into Darwin Core
 *    This class should be considered private to DigirProvider
 */

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once ($WEB_ROOT . '/objects/common/Provider.php');



/**
 *
 * DigirProvider is Class for handling GENERIC DiGIR requests.
 *
 * there will need to be client specific parts so a client specific
 * class inheriting from this must be implemented
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class DigirProvider extends Provider
{
	var $serviceName = "DigirProvider";

	var $version = "KE EMu DiGIR Interface version 1.0a";

	// structure to hold DiGIR diagnostic messages
	var $diagnostics = array();


	// instance of digir parsing object
	var $digirQueryParser;

	// array to hold any fields that have simple 1:1 EMu:Darwin mapping
	// and require no assembly/dissassembly
	var $simpleMappings = array();

	function describe()
	{
		return	
			"A Digir Provider is a Provider that implements a generic\n".
			"DiGIR data provider service\n\n".
			Parent::describe();
	}

	function configure()
	{
		/**************************************************************
		 * need to set properties for
		 * - provider info
		 * - one host (with one or more host contacts) 
		 * and 
		 * - one or more resources (with each resource having one or
		 * more contacts)
		 **************************************************************/
		// below is skeleton of what you should do... 
		// See an existing client for more detailed example

		$this->setMetaData('provider', array());
		$this->setMetaData('host', array());

		/* can have multiple repeats of next line in child object */
		$this->setMetaData('host contact', array()); 

		/* can have multiple repeats of next 2 lines in child object */
		$this->setMetadata('resource', array());
		$this->setMetaData('resource contact', array());

		/**************************************************************/
		/* To handle a Darwin Field, it must have an entry here       */
		/**************************************************************/


		// break this routine to make sure it is done in client specific service
		// (remove this line in client specific implementation !)
		$this->_makeThisAbstractMethod('customise','DigirProvider');
	}


	function request($doc)
	{
		// request handling start point - take raw request, parse it
		// and act
		 if (get_magic_quotes_gpc())
		       $doc=stripslashes($doc);

		$doc = urldecode($doc);
		$this->digirQueryParser = new _DigirRequestParser($this);

		$doc = preg_replace('/^doc=/','',$doc);

		if (! $doc)
			return $this->digirMetaDataResponse();
		else
		{
			$type = $this->digirQueryParser->getDigirType($doc);
			switch($type)
			{
				case 'metadata' :
					return $this->digirMetaDataResponse();
					break;
				case 'inventory' :
					$texql = $this->_generateTexqlStatement($doc);

					if (! $error = $this->getError())
					{
						$results = $this->search($texql);

						if (! $error = $this->getError())
						{
							// translate EMu xml response into DiGIR response
							$emuToDarwinTranslator = new _EmuToDarwinTranslator($this);
							return $this->digirStandardResponse(
								$this->_inventory(
									$emuToDarwinTranslator->emuResponseToDarwin($results)),
									$doc);
						}

						$this->addDiagnostic( 'System','Error',$error);
						return $this->digirStandardResponse(
							'<!-- error detected running search -->');
					}

					$this->addDiagnostic("System", "Error", "'$error'");
					return $this->digirStandardResponse(
						'<!-- error detected generating texql -->');
					break;

				case 'search' :
					$texql = $this->_generateTexqlStatement($doc); 

					if (! $error = $this->getError())
					{
						$results = $this->search( $texql);

						if (! $error = $this->getError())
						{
							// translate EMu xml response into DiGIR response
							$emuToDarwinTranslator = new _EmuToDarwinTranslator($this);
							return $this->digirStandardResponse(
									$emuToDarwinTranslator->emuResponseToDarwin($results)
								);
						}

						$this->addDiagnostic( 'System','Error',$error);
						return $this->digirStandardResponse(
							'<!-- error detected running search -->');
					}

					$this->addDiagnostic("System", "Error", "'$error'");
					return $this->digirStandardResponse(
						'<!-- error detected generating texql -->');
					break;

				default :
					$this->addDiagnostic("Request",
						"Error",
						"Unrecognised request type: '$type'");
					return $this->digirStandardResponse('<!-- error detected -->');
					break;
			}

			return parent::request($doc);
		}
	}



	function _inventory($darwinResult,$doc)
	{

		$element = $this->select;
		if (preg_match_all("/<$element>(.+?)<\/$element>/",$darwinResult,$match))
		{
			foreach ($match[1] as $name)
			{
				$names[$name]++;
			}
			foreach ($names as $name => $count)
			{
				$result[] = "<record><$element count='$count'>$name</$element></record>";
			}
		}
		return implode($result,'');
	}



	function generateSqlStatement($doc)
	{
		// take DiGIR XML search request and translate
		// into a simple common 'intermediate' SQL form suitable for
		// translation to Texql.

		$where = 
			$this->digirQueryParser->filterToWhere(
				$this->digirQueryParser->getDigirFilter($doc));

		$select = $this->digirQueryParser->recordsToSelect(
			$this->digirQueryParser->getDigirRecords($doc));

		$count = $this->digirQueryParser->getDigirCount($doc);

		list($start,$limit) = $this->digirQueryParser->getDigirRecordLimit($doc);

		return $this->buildQuery($select,'catalogue',$where,$start,$limit);
	}


	function generateTexql($field,$operator,$value)
	{
		if ($this->simpleMappings[$field])
		{
			$tuple = $this->simpleMappings[$field];
			if (preg_match('/(.+)_tab/',$tuple,$matches))
			{
				$fieldEntry = $matches[1];
				return "(EXISTS (${tuple}[$fieldEntry] WHERE $fieldEntry $operator $value))";
			}

			return "$tuple $operator $value";
		}
		else
			return '';
	}

	function generateValue($field,$record)
	{
		// NB if record passed as NULL assume this a call to find what EMu
		// fields need to be selected in a query for use in
		// translation.

		if (isset($this->simpleMappings[$field]))
		{
			if ($record == NULL)
				return "ecatalogue.". $this->simpleMappings[$field];
			else
				return($record[$this->simpleMappings[$field]]);
		}
		else
			return '';
	}


	function setSimpleMapping($darwin,$emu)
	{
		$this->simpleMappings[$darwin] = $emu;
	}

	function _emuRecordToDarwin($record)
	{
		// take emu record fields and translate into darwin core fields
		// assumes record passed as hash of field=>value and returns similar hash

		$fields = array();
		
		if ($record)
		{
			foreach (preg_split('/\s*,\s*/',$this->select,-1) as $darwinField)
			{
				$fields[$darwinField] = $this->generateValue($darwinField,$record);
			}
		}
		return $fields;
	}

	// methods to assemble metadata settings
	function _addResourceContact($settings)
	{
		if (count($this->resources))
		{
			$this->resources[count($this->resources)-1][contact][] = $settings;
		}
		else
		{
			$this->addDiagnostic("Configuration Setting",
					"Information",
					"cannot add contact to non existent resource");
		}
	}

	function _checkRequiredMetadataSettings($settings,$required)
	{
		// checks passed associative array to see it has all the
		// declared parameters (as asked for in the passed $required
		// array)
		//
		// if parameter ends with a '+' it must have a value

		foreach ($required as $param)
		{
			if ($required = preg_match('/\+$/',$param))
				$param = preg_replace('/\+$/','',$param);

			if (! isset($settings[$param]))
				$this->addDiagnostic("Configuration Setting",
					"Information",
					"a missing required parameter '$param' in metadata");
			
			else if ($required && preg_match ('/^\s*$/',$settings[$param]))
				$this->addDiagnostic("Configuration Setting",
					"Information",
					"a parameter '$param' in metadata requires a value");
		}
	}

	function setMetaData($type,$settings)
	{
		switch($type)
		{
			case 'provider' :
				$this->metadata = $settings;
				$this->_checkRequiredMetadataSettings(
						$settings,
						array(
							'Name+',
							'Implementation',
							'AccessPoint',
						)
					);
				break;
			case 'host' :
				$this->host = $settings;
				$this->_checkRequiredMetadataSettings(
						$settings,
						array(
							'Name+',
							'Code+',
							'RelatedInformation',
							'Abstract',
						)
					);
				break;
			case 'host contact' :
				$this->host[contact][] = $settings;
				$this->_checkRequiredMetadataSettings(
						$settings,
						array(
							'Type+',
							'Name+',
							'Title',
							'Email',
							'Phone',
						)
					);
				break;
			case 'resource' :
				$this->resources[] = $settings;
				$this->_checkRequiredMetadataSettings(
						$settings,
						array(
							'Name+',        
							'Code+',        
							'RelatedInformation',
							'Abstract',    
							'Keywords',    
							'Citation',    
							'UseRestrictions',   
							'ConceptualSchema',  
							'SchemaLocation',    
							'RecordIdentifier',  
							'RecordBasis',       
							'NumberOfRecords',   
							'DateLastUpdated',   
							'MinQueryTermLength',
							'MaxSearchResponseRecords',
							'MaxInventoryResponseRecords',
						)
					);
				break;
			case 'resource contact' :
				$this->_addResourceContact($settings);
				$this->_checkRequiredMetadataSettings(
						$settings,
						array(
							'Type+',
							'Name+',
							'Title',
							'Email',
							'Phone',
						)
					);
				break;
			default:
				$this->addDiagnostic("Configuration Setting",
					"Information",
					"cannot add metadata - unrecognised type '$type'");
				break;

		}
	}

	// methods to create diagnostic messages in response
	function sayNoMapping($field)
	{
				$this->addDiagnostic("Configuration",
							"Information",
							"field $field requested but no mapping ".
								"for it in this configuration");
				return '';
	}
	function sayNotQueryable($field)
	{
				$this->addDiagnostic("Configuration",
					"Information",
					"$field cannot be queried on");
				return '';
	}
	function sayMissingRule($field)
	{
				$this->addDiagnostic("Configuration",
					"Information",
					"missing texql translation code for $field");
				return '';
	}

	function addDiagnostic($code,$severity,$message)
	{
		$this->diagnostics[
			"<diagnostic code='$code' severity='$severity'>".
			"$message</diagnostic>"]++;
	}

	function _normaliseDiagnostics()
	{
		$diags = array();
		foreach ($this->diagnostics as $diag => $count)
		{
			if ($count > 1)
				$diags[] = preg_replace('/(<\/diag)/',
					" (detected $count times)$1",$diag);
			else
				$diags[] = $diag;
		}
		return implode($diags,"\n\t");
	}

	// methods to generate proerly formatted DiGIR responses

	function timeStamp($unixTime)
	{
		return strftime("%Y-%m-%d %H:%M:%S.00Z",$unixTime);
	}


	function digirStandardResponse($content)
	{
		$time = $this->timeStamp(time());
		if ((! $this->metadata['AccessPoint']) || 
					$this->metadata['AccessPoint'] == 'default')
			$this->metadata['AccessPoint'] = 
				"http://$_SERVER[SERVER_NAME]$_SERVER[PHP_SELF]";

		$header = 
			"<header>\n".
    			" <version>$this->version</version>\n".
    			" <sendTime>$time</sendTime>\n".
    			" <source resource='".  
						$this->resource['name'] ."'>". 
						$this->metadata["AccessPoint"] ."</source>\n".
    			" <destination>$_SERVER[SERVER_NAME]</destination>\n".
  			"</header>";

		$diagnostics = $this->_normaliseDiagnostics();
		
		$response = "<?xml version='1.0'?>\n".
				" <response>\n".
				"   $header\n".
  				"   <content>\n".
				"   $content\n".	
  				"   </content>\n".
  				"   <diagnostics>".  
						$diagnostics .
				"	 </diagnostics>\n".
				" </response>";

		return $response;
	}

	function digirMetaDataResponse()
	{
		$time = $this->timeStamp(time());
		if ((! $this->metadata['AccessPoint']) || 
					$this->metadata['AccessPoint'] == 'default')
			$this->metadata['AccessPoint'] = 
					"http://$_SERVER[SERVER_NAME]$_SERVER[PHP_SELF]";

		$header = 
			"<header>\n".
    			" <version>$this->version</version>\n".
    			" <sendTime>$time</sendTime>\n".
    			" <source resource='".  
						$this->resource['name'] ."'>". 
						$this->metadata["AccessPoint"] ."</source>\n".
    			" <destination>$_SERVER[SERVER_NAME]</destination>\n".
  			"</header>";

		foreach ($this->host['contact'] as $contact)
		{
			$contactList[] = 
				"<contact type='". $contact[Type] ."'>\n". 
             			" <name>". $contact['Name'] ."</name>\n".
             			" <title>". $contact['Title'] ."</title>\n".
             			" <emailAddress>". $contact['Email'] ."</emailAddress>\n".
             			" <phone>". $contact['Phone'] ."</phone>\n".
           			"</contact>";
		}

  		$host = 
			"<host>\n".
          		" <name>". $this->host['Name'] ."</name>\n".
           		" <code>". $this->host['Code'] ."</code>\n".
           		" <relatedInformation>". 
				$this->host['RelatedInformation'] .
			" </relatedInformation>\n".
	   		  implode($contactList,"\t\t\n"). "\n".
           		" <abstract>". $this->host['abstract'] ."</abstract> \n".
        		"</host>";



		foreach ($this->resources as $resource)
		{
			$contactList = array();
			foreach ($resource[contact] as $contact)
			{
				$contactList[] = 
					"<contact type='". $contact[Type] ."'>\n". 
             				" <name>". $contact['Name'] ."</name>\n".
             				" <title>". $contact['Title'] ."</title>\n".
             				" <emailAddress>". $contact['Email'] .
									"</emailAddress>\n".
             				" <phone>". $contact['Phone'] ."</phone>\n".
           				"</contact>";
			}

			$resources[] = 
				"<resource>\n".
				" <name>". $resource["Name"] ."</name>\n".
				" <code>". $resource["Code"] ."</code>\n".
				" <relatedInformation>". 
					$resource["RelatedInformation"] ."</relatedInformation>\n".
	   			implode($contactList,"\n"). "\n".
				" <abstract>". $resource["Abstract"] ."</abstract>\n".
				" <keywords>". $resource["Keywords"] ."</keywords>\n".
				" <citation>". $resource["Citation"] ."</citation>\n".
				" <useRestrictions>". $resource["UseRestrictions"] .
						"</useRestrictions>\n".
				" <conceptualSchema schemaLocation='". 
					$resource["SchemaLocation"] ."'>". 
					$resource["ConceptualSchema"] ."</conceptualSchema>\n".
				" <recordIdentifier>". $resource["RecordIdentifier"] ."</recordIdentifier>\n".
				" <recordBasis>". $resource["RecordBasis"] ."</recordBasis>\n".
				" <numberOfRecords>". $resource["NumberOfRecords"] .  "</numberOfRecords>\n".
				" <dateLastUpdated>". $resource["DateLastUpdated"] .  "</dateLastUpdated>\n".
				" <minQueryTermLength>". $resource["MinQueryTermLength"] . "</minQueryTermLength>\n".
				" <maxSearchResponseRecords>". 
					$resource["MaxSearchResponseRecords"] .
				" </maxSearchResponseRecords>\n".
				" <maxInventoryResponseRecords>". 
					$resource["MaxInventoryResponseRecords"] .
				" </maxInventoryResponseRecords>\n".
				" </resource>";
		}

		$resourceData = implode ($resources,"\n");
		$diagnostics = $this->_normaliseDiagnostics();
		
		$response = "<?xml version='1.0'?>\n".
				" <response>\n".
				"   $header\n".
  				"   <content>\n".
    				"     <metadata>\n".
      				"       <provider>\n".
        			"         <name>". $this->metadata['Name'] ."</name>\n".
        			"         <accessPoint>". $this->metadata["AccessPoint"] .  "</accessPoint>\n".
        			"         <implementation>". 
							$this->metadata['Implementation'] 
							." ".  
							$this->version ."\n".
				"         </implementation>\n".
				"         $host\n".
				"         $resourceData\n".
      				"         </provider>\n".
    				"     </metadata>\n".
  				"   </content>\n".
  				"   <diagnostics>".  $diagnostics ."</diagnostics>\n".
				" </response>";

		return $response;
	}


	// following several methods are available to assist translating data
	// and typically called from the local generateValue method

	function emuDate2Iso8601Time($emuDate,$emuTime)
	{
		if (! $emuDate)
			return '';

		$months = array('Jan' => '1' ,
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
 				'Dec' => 12);

 		if (! $emuTime)
 			$emuTime = '00:00:00';

		list ($day,$mon,$yr) = preg_split('/\s+|\//', $emuDate);
		$mon = preg_replace('/^0/','',$mon);

		if (isset($month[$mon]))
			$mon = $month[$mon];

		list ($hr,$min,$sec) = preg_split('/:/', $emuTime);

		return sprintf("%4.4d-%02.2d-%02.2d %02.2d:%02.2d:%02.2d.00Z",
			$yr,$mon,$day,$hr,$min,$sec);
	}

	function emuDate2JulianDay($emuDate)
	{
		if (! $emuDate)
			return '' ;

		$months = array('Jan' => '1' ,
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
 				'Dec' => 12);
		

		list ($day,$mon,$yr) = preg_split('/\s+|\//',$emuDate);

		$mon = preg_replace('/^0/','',$mon);
		if (isset($month[$mon]))
			$mon = $month[$mon];


		$jDays = array (0,31,59,90,120,151,181,212,243,273,304, 334);

		$jd = $jDays[$mon-1] + $day;

		// leap years are divisible by 4 AND ((divisible by 400) or (!
		// divisible by 100) )
       		if ( ($yr % 4) && (($yr % 400) || (!($yr % 100)) )
		)
		{
			# a leap year - add day if later than feb 28th
			if (($mon > 2) or ($mon ==2 and $day == 29))
				$jd++;
	
		}
		return $jd;
	}

	function emuDateComponent($emuDate,$wantedComponent)
	{
		if (! $emuDate)
			return '';

		$months = array('Jan' => '1' ,
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
 				'Dec' => 12);
		

		list ($day,$mon,$yr) = preg_split('/\s+|\//',$emuDate);
		$mon = preg_replace('/^0/','',$mon);

		if (isset($month[$mon]))
			$mon = $month[$mon];

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
				$this->addDiagnostic("Configuration Setting",
					"Information","Request for date component
					$wantedComponent not recognised");
					return "";
				break;
		}
	}
	function emuLatLongToDecimal($emuLatLong)
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

	function requestAndProcess($search)
	{
		// this for testing system

		$time = $this->timeStamp($unixTime);	
		$host = $_SERVER['SERVER_NAME'];
		$resource = $this->backendType;

		$source = $this->webDirName .'/webservices/digir.php';
		$doc =
				"<request xmlns='http://www.namespaceTBD.org/digir'\n".
				"	xmlns:xsd='http://www.w3.org/2001/XMLSchema'\n".
				"	xmlns:darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'\n".
				"	xmlns:dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>\n".
				"	<header>\n".
				"		<version>1.0.0</version>\n".
				"		<sendTime>$time</sendTime>\n".
				"		<source>$host</source>\n".
				"		<destination resource='$resource'>http://$host/$source</destination>\n".
				"		<type>search</type>\n".
				"	</header>\n".
				"	<search> $search </search>\n".
				"	</request>";
		print $this->request($doc);
	}			

	function makeTestPage()
	{

		$args = array();
		$args['DiGIR Request'] =  "<textarea cols='120' rows='15' name='doc'>".
			"<request xmlns='http://www.namespaceTBD.org/digir'\n".
			"	xmlns=xsd='http://www.w3.org/2001/XMLSchema'\n".
			"	xmlns=darwin='http://digir.net/schema/conceptual/darwin/2003/1.0'\n".
			"	xmlns=dwc='http://digir.net/schema/conceptual/darwin/2003/1.0'>\n".
			"<header>\n".
			"	<version>1.0.0</version>\n".
			"	<sendTime>1970-01-01 10:00:00.00Z</sendTime>\n".
			"	<source>syd.kesoftware.com</source>\n".
			"	<destination resource='AM_EMu'>http://syd.kesoftware.com/emuwebamdigir/webservices/digir.php</destination>\n".
			"	<type>search</type>\n".
			"</header>\n".
			"<search>\n".
			$this->testQueryTerms() .
			"</search>\n".
			"</request>\n".
			"</textarea>";
		$args["diagnostics"] =
			"<div style='text-align: left'>\n".
			"<input type='radio' name='diagnostics'  value='' checked='true' /> Run Normally<br/>\n".
			"<input type='radio' name='diagnostics'  value='showSql' /> Show Generic SQL<br/>\n".
			"<input type='radio' name='diagnostics'  value='showTexql' /> Show Texql<br/>\n".
			"</div>\n";

		$vars = array();
		$vars['class'] = 'SimpleTransformation';
		$vars['test'] = 'true';
		$vars['testCall'] = 'true';
		$submission = "<input type='submit' name='action' value='search' />";

		print $this->makeDiagnosticPage(
					"KE EMu ". $this->serviceName,
					"EMu-DiGIR Provider Test",
					$js,
					'./Digir.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

	function test($serviceSpecific=false)
	{
		if (! $serviceSpecific)
			parent::test();
		else	
		{
			if (isset($_REQUEST['testCall']))
			{
				header("Content-type: text/xml",1);
				print $this->request($_REQUEST['doc']);
			}
			else	
			{
				header("Content-type: text/html",1);
				print $this->makeTestPage();
			}
		}
	}
} // -------------- end class DigirProvider --------------------




/**
 * 
 * Class _DigirRequestParser
 *
 * this class assists in extracting components of digir query xml and
 * converting it to SQL.  It really is meant to be used by DigirProvider class
 * only and should be considered 'private' to that class
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class _DigirRequestParser extends BaseWebServiceObject
{
	// this class assists in extracting components of digir query xml and
	// converting it to SQL

	var $parser;
	var $parserMode;
	var $stack = array();
	var $clauseStack = array();
	var $statement = array();
	var $digirProvider;

	function _DigirRequestParser(&$digirProvider)
	{
		$this->digirProvider =& $digirProvider;
	}

	/********* DiGIR Request Parsing Stuff *****************************/
	function getDigirType($doc)
	{
		if (preg_match('/<search>/',$doc))
			return 'search';
		if (preg_match('/<type>metadata<\/type>/',$doc))
			return 'metadata';
		if (preg_match('/<inventory>/',$doc))
			return 'inventory';
		$this->digirProvider->addDiagnostic("Request",
					"error",
					"cannot determine request type, assuming metadata");
		return 'metadata';	
	}
	function getDigirFilter($doc)
	{
		if (preg_match('/<filter(.*)<\/filter>/s',$doc,$match))
				return $match[1];
		
		$this->digirProvider->addDiagnostic("Request",
						"error",
						"cannot determine filter");
		return '';
	}

	function getDigirRecords($doc)
	{
		// why could they not have a consistent request structure between
		// inventory and search ???

		if ($this->getDigirType($doc) == 'inventory')
		{
			if (preg_match('/<\/filter>(.*)(<count|<inventory)/s',$doc,$match))
				return $match[1];
			if (preg_match('/<inventory>(.*)(<count|<inventory)/s',$doc,$match))
				return $match[1];
		}
		else
		{
			if (preg_match('/<records\b(.*?)<\/records>/s',$doc,$match))
				return $match[1];
		}
		$this->digirProvider->addDiagnostic("Request", 
			"error", 
			"cannot determine records structure in digir request");
		return '';
	}

	function getDigirCount($doc)
	{
		if (preg_match('/<count\b(.*)<\/count>/s',$doc,$match))
			return $match[1];
		return '';
	}

	function getDigirRecordLimit($doc)
	{
		$start = 0;
		$limit = '';
		if (preg_match('/<records[^>]+limit=.(\d+)\D/s',$doc,$match))
			$limit = $match[1];
		if (preg_match('/<records[^>]+start=.(\d+)\D/s',$doc,$match))
			$start = $match[1];
		return array($start,$limit);
	}

	/********* Filter Parsing Stuff **********************************************
	 * 
	 * compare ::= equals | notEquals | lessThan | lessThanOrEquals | greaterThan
	 *                    | greaterThanOrEquals | like | in
	 * 
	 * logical ::= and | andNot | or | orNot 
	 *
	 * DATA ::= dataElement
	 *
	 * COP ::= compare DATA DATA*
	 *
	 * LOP ::= logical COP COP* | LOP 
	 * 
	 * FILTER ::= COP | LOP
	 * 
	 *****************************************************************************/

	function _IsComparisonOp($element)
	{
		switch (strtoupper($element))
		{
			case 'EQUALS' : 
			case 'NOTEQUALS' :
			case 'LESSTHAN' :
			case 'LESSTHANOREQUALS' :
			case 'GREATERTHAN' : 
			case 'GREATERTHANOREQUALS' : 
			case 'LIKE' : 
			case 'IN' : 
				return true;
				break;
			default:
				return false;
				break;
		}
		return false;
	}
	function _IsLogicalOp($element)
	{
		switch (strtoupper($element))
		{
			case 'AND' : 
			case 'ANDNOT' :
			case 'OR' :
			case 'ORNOT' :
				return true;
				break;
			default:
				return false;
				break;
		}
		return false;
	}
	function _IsDataElement($element)
	{
		return preg_match('/darwin:/i',$element);
	}

	function startDigirElement($p,$element,$attrib)
	{

		switch ($this->parserMode)
		{
			case 'wantCopOrLop' :
				if ($this->_IsComparisonOp($element))
				{
					return;
				}
				else if ($this->_IsLogicalOp($element))
				{
					return;
				}
				if ($this->_IsDataElement($element))
				{
					$this->stack[] = $element;
					return;
				}
				else
				{
					$this->parserMode = 'failed';
					$this->digirProvider->addDiagnostic("Request",
						"error",
						"cannot parse filter. Expecting comparison operator, 
						gical operator or darwin element, got
						logical operator or darwin element, got '$element'");
				}
				break;
			case 'failed':
				break;
			default :
				$this->digirProvider->addDiagnostic("Request",
						"error",
						"Cannot parse xml. Unimplemented Parser Mode 
						'$this->parserMode' at start element $element");
				$this->parserMode = 'failed';
				break;
	
		}
	}
	function endDigirElement($p,$element)
	{
		switch($this->parserMode)
		{
			case 'wantCopOrLop':
				if ($this->_IsComparisonOp($element))
				{
					$this->compClause = Array();
					while(count($this->stack))
					{
						$value = array_pop($this->stack);
						$field = array_pop($this->stack);
						$field = preg_replace('/DARWIN:/i','',$field); 
						$opTrans = array(
							'EQUALS' => '=',
							'NOTEQUALS' => '!=',
							'LESSTHAN' => '<',
							'LESSTHANOREQUALS' => '<=',
							'GREATERTHAN' => '>',
							'GREATERTHANOREQUALS' => '>=',
							'LIKE' => 'LIKE',
							'IN' => 'CONTAINS',
						);
						$clause = "( $field ". 
							strtoupper($opTrans[strtoupper($element)]) ." '$value' )";
						$this->clauseStack[] = $clause;
					}
					return;
				}
				else if ($this->_IsLogicalOp($element))
				{
					$element = strtoupper($element);
					$this->clauseStack[] = $element;
					return;
				}
				if ($this->_IsDataElement($element))
				{
					return;
				}
				else
				{
					$this->parserMode = 'failed';
					$this->digirProvider->addDiagnostic("Request",
						"error",
						"cannot parse filter. Expecting comparison 
						operator, logical operator or darwin element, 
						got '$element'");
				}
				break;
			case 'failed':
				break;
			default:
				$this->digirProvider->addDiagnostic("Request",
						"error",
						"Cannot parse xml. Unimplemented Parser Mode 
						'$this->parserMode' at end element $element");
				$this->parserMode = 'failed';
				break;
		}
	}
	function digirCharacterData($p,$data)
	{
		switch($this->parserMode)
		{
			case 'wantCopOrLop':
				$data = preg_replace('/^\s+|\s+$/','',$data);
				if ($data)
					$this->stack[] = $data;
				break;
			case 'failed':
				break;
			default:
				$this->digirProvider->addDiagnostic("Request",
						"error",
						"Cannot parse xml. Unimplemented Parser Mode 
						'$this->parserMode' whilst reading character data");
				$this->parserMode = 'failed';
				break;
		}
	}

	function postfixWhereToInfix($postfixStack)
	{
		/* Used to reassemble SQL WHERE clauses from a Postfix stack
		 *
		 * eg 
		 * if passed a list:
		 *   Family = Culicidae 
		 *   State = NSW
		 *   State = Vic
		 *   OR
		 *   Institution = NMNH
		 *   AND
		 *   AND
		 * would return a string
		 * (Family = Culicidae AND ((State = NSW OR State = Vic) AND
		 *      Institution = NMNH))
		 */
		 
		$stack = array();
		foreach ($postfixStack as $item)
		{
			if ($this->_IsLogicalOp($item))
			{
				$operand2 = array_pop($stack);
				$operand1 = array_pop($stack);
				array_push($stack , 
					"($operand1 $item $operand2)");
				
			}
			else
			{
				array_push($stack,$item);
			}
		}
		return implode($stack," $item ");
	}

	function filterToWhere($filter)
	{

		if (! $filter)
			return '';

		list($attributes,$filter) = preg_split('/>/',$filter,2);

		$this->parserMode = 'wantCopOrLop';

		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->parser,$this);
		xml_set_element_handler($this->parser,'startDigirElement','endDigirElement');
		xml_set_character_data_handler($this->parser,'digirCharacterData');

		xml_parse($this->parser,$filter);

		xml_parser_free($this->parser);

		return $this->postfixWhereToInfix($this->clauseStack);
	}

	function _simpleRecordsToSelect($schemaXml)
	{
		preg_replace('/^.*(<xsd:element name="record">)/',"$1",$schemaXml);
       		preg_replace("/<\/xsd:schema>.*/","",$schemaXml);
						
		$selects = array();
		foreach (preg_split("/\n/",$schemaXml) as $line)
		{
			if (preg_match("/<xsd:element ref=('|\")(.+)('|\")/s",$line,$match))
			{
				$match[2] = preg_replace("/.+:/",'',$match[2]);
				$selects[] = $match[2];
			}
		}
		return implode($selects,',');
	}

	function recordsToSelect($records)
	{
		// why could they not have a consistent request structure between
		// inventory and search ???

		$records = preg_replace('/^\s*|\s*$/','',$records);

		if (preg_match('/^[^<]/',$records))
			list($attributes,$records) = preg_split('/>/',$records,2);

		if (preg_match('/<structure>/',$records))
			return $this->_simpleRecordsToSelect($records);
		else 
			if (preg_match("/schemaLocation=('|\")(.+)('|\")/",$records,$match))
			{
				// file_get_contents more memory/speed
				// efficient but not on all php versions
				if ($this->phpVersionMinimum('4.3.0'))
					$schemaXml = file_get_contents($match[2]);
				else
					$schemaXml = implode("",file($match[2]));

				if (! $schemaXml)
					$this->digirProvider->addDiagnostic("Request",
							"error", "cannot retrieve record schema from $match[2]");
				else
					return $this->_simpleRecordsToSelect($schemaXml);
			}
			else
				if (preg_match("/<(.+:)*(.+)\/>/",$records,$match))
					return $match[2];

		return "NONE";
	}

}



/**
 * 
 * Class _EmuToDarwinTranslator
 *
 * class provides parsing methods to assist in taking an EMu xml
 * and translating it into Darwin Core XML.  It really is meant to be used by
 * DigirProvider class only and should be considered 'private' to that class
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class _EmuToDarwinTranslator extends BaseWebServiceObject
{

	// this class provides parsing methods to assist in taking an EMu xml
	// response and translating it into Darwin Core XML

	var $provider;

	var $emuResponse = array();
	var $emuRecord = array();
	var $emuField;
	var $multiValue = false;

	function _EmuToDarwinTranslator($provider)
	{
		$this->provider = $provider;
	}

	function startEmuElement($p,$element,$attrib)
	{
		switch ($this->parserMode)
		{
			case 'wantResults' :
				if ($element == 'results')
				{
					$this->resultsAttrib = $attrib;
					$this->parserMode = 'wantRecord';
					$this->emuResponse = array();
					$this->emuRecord = array();
				}
				else
				{
					$this->parserMode = 'failed';
					$this->addDiagnostic("EMu response",
						"Error","expecting 'results' element got '$element'");
				}
				break;
			case 'wantRecord' :
				if ($element == 'record')
				{
					$this->parserMode = 'wantElement';
				}
				else
				{
					$this->parserMode = 'failed';
					$this->addDiagnostic("EMu response",
						"Error","expecting 'record' element got '$element'");
				}
				break;
			case 'wantElement' :
				$this->multiValue = false;
				$this->parserMode = 'readingElement';
				$this->emuField = $element;
				$this->emuRecord[$element] = '';
				break;
			case 'readingElement' :
				// new element found when reading anothers element data
				// eg occurs with something like
				//	<ZooSex_tab><ZooSex>Male</ZooSex></ZooSex_tab>
				// treat new element as parent element but keep
				// a note the parent element is a multivalue
				// item
				$this->multiValue = true;
				break;
			case 'resultsFound' :
				$this->addDiagnostic("EMu response",
						"Error",
						"Cannot parse xml. Unexpected content at '$element'" );
				$this->parserMode = 'failed';
				break;
			case 'failed' :
				break;
			default:
				$this->addDiagnostic("EMu response",
						"Error",
						"Cannot parse xml. Unimplemented Parser Mode 
							'$this->parserMode' at start element $element");
				$this->parserMode = 'failed';
				break;
		}
	}

	function endEmuElement($p,$element)
	{
		switch ($this->parserMode)
		{
			case 'wantRecord' :
				switch($element)
				{
					case 'results':
						//$this->emuResponse[] = 
					//		$this->provider->_emuRecordToDarwin($this->emuRecord);
						$this->parserMode = 'resultsFound';
						break;
					case 'record':
						$this->parserMode = 'wantRecord';
						break;
					default:
						$this->addDiagnostic("EMu response",
								"Error",
								"Cannot parse xml. unexpected end of '$element'");
						$this->parserMode = 'failed';
					break;	
				}
				break;
			case 'readingElement' :
				if ($element == $this->emuField)
					$this->parserMode = 'wantElement';
				break;
			case 'wantElement' :
				if ($element == 'record')
				{
					$this->parserMode = 'wantRecord';
					$this->emuResponse[] = 
						$this->provider->_emuRecordToDarwin($this->emuRecord);
				}
				break;
			case 'resultsFound' :
				$this->addDiagnostic("EMu response",
						"Error",
						"Cannot parse xml. Unexpected content at '$element'" );
				$this->parserMode = 'failed';
				break;
				
			case 'failed' :
				break;
			default:
				$this->addDiagnostic("EMu response",
						"Error",
						"Cannot parse xml. Unimplemented Parser Mode 
							'$this->parserMode' at end element $element");
				$this->parserMode = 'failed';
				break;
		}
	}
	function emuCharacterData($p,$data)
	{
		switch ($this->parserMode)
		{
			case 'readingElement' :
				if ($this->emuRecord[$this->emuField])
				{
					if ($this->multiValue )
						$join = ' : ';
					else
						$join = ' ';
					$this->emuRecord[$this->emuField] .= $join.$data;
				}
				else
					$this->emuRecord[$this->emuField] = $join.$data;
				break;
			case 'wantRecord' :
			case 'wantElement' :
			case 'resultsFound' :
				$this->addDiagnostic("EMu response",
						"Error",
						"Cannot parse xml. Unexpected content (mode $this->parserMode)
							'$data'" );
				$this->parserMode = 'failed';
				break;
			case 'failed' :
				break;
			default:
				$this->addDiagnostic("EMu response",
						"Error",
						"Cannot parse xml. Unimplemented Parser Mode 
							'$this->parserMode' at end element $element");
				$this->parserMode = 'failed';
				break;
		}
	}

	function emuResponseToDarwin($xml)
	{
		// take emu xml records and translate into darwin core records
		$this->parserMode = 'wantResults';

		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->parser,$this);
		xml_set_element_handler($this->parser,'startEmuElement','endEmuElement');
		xml_set_character_data_handler($this->parser,'emuCharacterData');

		xml_parse($this->parser,$xml);

		xml_parser_free($this->parser);

		$records = '';
		foreach ($this->emuResponse as $record)
		{

			$records .= "<record>\n";
			foreach ($record as $field => $value)
			{
				$value = preg_replace('/& /','&amp;',$value);
				$records .= "\t<$field>$value</$field>\n";
				
			}
			$records .= "</record>\n";
		}
		return $records;

		/*$records = array();
		foreach ($this->emuResponse as $record)
		{
			$records[] = "<record>";
			foreach ($record as $field => $value)
			{
				$value = preg_replace('/& /','&amp;',$value);
				$records[] = "\t<$field>$value</$field>";
				
			}
			$records[] = "</record>";
		}
		return implode($records,"\n");	*/
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "DigirProvider.php")
	{
		$webObject = new DigirProvider();
		$webObject->test();
	}
}


?>
