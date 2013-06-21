<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */

/*************************************************************************
 * This file defines two classes
 * 1. Provider
 *    a base class from which EMu web service providers of various flavours can
 *    be built 
 *
 * 2. SqlParser
 *    a class to assist in assembling, translating and reaassmbling SQL
 *    statements between different formats
 *    used by Provider and descendents
 *************************************************************************/
 
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/WebServiceObject.php');


/**
 *
 * Class Provider
 *
 * Provider is a base class from which EMu web service providers of various
 * flavours can be built 
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class Provider extends WebServiceObject
{
	var $serviceName = "Provider";

	var $errorMessage = array();

	// record components of intermediate SQL request information for
	// potential use during response generation
	var $select;
	var $from;
	var $where;
	var $start;
	var $limit;


	function describe()
	{
		return	
			"A Provider is a system to provide generic web services.\n".
			"It handles requests and returns data using records in\n".
			"the underlying EMu database.\n\n".  
			Parent::describe();
	}

	function configure()
	{
		// method for setting many client specific properties.  
		// This method should be implemented by the
		// client specific object

		$this->_makeThisAbstractMethod('customise');
	}

	function request($doc)
	{
		// take request in 'some' format and act appropriately
		// should be overriden by the service specific child
		// inherited from this (eg DigirProvider.php)
		// return response to request (typically xml)

		$this->_makeThisAbstractMethod('request');
	}

	function generateTexql($field,$operator,$value)
	{
		$this->_makeThisAbstractMethod('generateTexql');
	}

	function _generateTexqlStatement($query)
	{
		// take a 'Query' in whatever form and translate it into a
		// texql statement
		// (a 'Query' typically will not be the whole 'request'  but
		// would be derived from information passed in the request and
		// is just the database access component of a request)

		$sql = $this->generateSqlStatement($query);
		if ($_REQUEST['diagnostics'] == 'showSql')
				$this->errorResponse($sql);
		return $this->_sqlToTexql($sql);
	}

	function generateSqlStatement($doc)
	{
		// This method must be implemented in child that defines the
		// service we are implementing (eg DigirProvider)
		//
		// take some query in the particular service defined format and
		// translate into a simple common 'intermediate' SQL form
		// suitable for translation to Texql.
		//
		// (Having intermediate sql form means we only need to write a
		// translator from the common 'intermediate' SQL  form to our
		// client rather than a different one for each combination of
		// request type and service type)

		$this->_makeThisAbstractMethod('generateSqlStatement');
	}

	function buildQuery($select,$from,$where,$start,$limit)
	{
		// builds intermediate SQL query from components
		// (often these components need to be extracted in complicated
		// ways from a request)

		$this->select = $select;
		$this->from = $from;
		$this->where = $where;
		$this->start = $start;
		$this->limit = $limit;
		$sql =  "SELECT $this->select 
					FROM catalogue 
					WHERE ($this->where)";
		if ($this->limit > 0)
			$sql = "($sql) {". 
				$this->start ." to ".
				$this->limit ."}"; 

		return $sql;	
	}


	function _sqlToTexql($sql)
	{
		// take intermediate sql query and translate into a
		// texql statement

		$range = '';
		if (preg_match('/{([0-9to\s]+)}/',$sql,$match))
		{
			$range = $match[1];
			$sql = preg_replace("/{\s*$range\s*}/",'',$sql);
		}

		list($discard,$select,$from,$where) = 
			preg_split("/SELECT|FROM|WHERE/",$sql,4);

		$selects = array();
		foreach (preg_split("/\s*,\s*/",$select,-1) as $wantedField)
		{
			$wantedField = 
				preg_replace('/^\s+|\s+$/','',$wantedField,-1); 

			$translatedFragment = 
				$this->generateValue($wantedField,NULL);

			if ($translatedFragment)
				$selects[] = $translatedFragment;
		}

		$translatedPostfix = array();
		$sqlParser = new SqlParser($where);
		$postfix = $sqlParser->infixWhereToPostfix();

		foreach ($postfix as $clause)
		{
		 	if (! preg_match('/^\*.+\*/',$clause))
			{
				if (preg_match('/(.+) (=|<=|>=|<|>|CONTAINS|LIKE) (.+)/',$clause,$match))
				{
					$translatedFragment = $this->generateTexql(
							$match[1],
							$match[2],
							$match[3]);
				}
				else
					$translatedFragment = '';

				if ($translatedFragment)
					array_push($translatedPostfix,
						$translatedFragment);
				else		
					array_push($translatedPostfix,'FALSE');
			}
			else
				array_push($translatedPostfix,
					$clause);
		}
		$where = $sqlParser->postfixWhereToInfix($translatedPostfix);

		// now assemble all the subclauses into Texql Statement
		$select = implode($selects,',');
		$select = preg_replace('/^\s*|\s*,\s*|\s*$/',',',$select);

		$wanted = array();
		$table = array();
		foreach (preg_split('/\s*,\s*/',$select) as $field)
		{
			if (preg_match('/(.+)\.(.+)/',$field,$match))
			{
				$wanted[$match[2]]++;
				$table[$match[1]]++;
			}
			else if ($field)
			{
				$wanted[$field]++;
				$table['ecatalogue']++;
			}
		}
		$select = implode(array_keys($wanted),', ');
		$from = implode(array_keys($table),', ');
		if (! $where)
			$where = 'true';

		$texql =  "SELECT $select FROM $from WHERE $where";

		if ($range)
			$texql = "($texql) \{$range}";

		if ($_REQUEST['diagnostics'] == 'showTexql')
				$this->errorResponse($texql);
		return $texql;
	}


	function generateValue($wantedField,$emuRecord)
	{
		// takes EMu record and returns requested service specific
		// Field Value
		$this->_makeThisAbstractMethod('generateValue');
	}

	function search($texql)
	{
		// run query (currently via texxmlserver connection)

		$conn = new TexxmlserverConnection;
		$fd = $conn->Open();
		if (!$fd || $fd < 0)
		{
			$this->_setError(
				"Cannot connect to the KE XML database server.  
					Check if emuweb running");
			return 0;			
		}
		
		$this->addDiagnostic("EMu Query",
			"Information",
			$texql);

		$get = "GET /?texql=" . 
			urlencode($texql) . 
			" HTTP/1.0\r\n\r\n";

		fputs($fd, $get);
		fflush($fd);

		// remove HTTP headers from returned response
		while (!feof($fd))
		{
			$out = trim(fgets($fd, 4096));
			if ($out == '')
				break;
		}


		// read remainder of XML
		$result = "\n<!-- $texql -->\n";
		while (!feof($fd))
		{
			$data = trim(fgets($fd, 4096));
			$data = preg_replace ("/<\?xml.+\?>/",'',$data);
			$result .= $data;
		}

		return($result);
	}

	function getHandle()
	{
		$this->_makeThisAbstractMethod('getHandle');
	}


	function _setError($message)
	{
		$this->errorMessage[] = $message;
	}

	function getError()
	{
		if (! $this->errorMessage)
			return '';

		$message = implode($this->errorMessage,'; ');
		$this->errorMessage = array();
		return $message;
	}

	function errorResponse($msg)
	{
		// simple response and quit
		// use to bail out at low level (ie before you can safely
		// construct a particular implementation of a web service)

		print("<response status='fail'><!-- $msg  --></response>");
		exit(1);
	}

	function requestAndProcess($search)
	{
		$this->_makeThisAbstractMethod('requestAndProcess');
	}

	function DegMinSecToDecimal($dms)
	{
		list($deg,$min,$sec,$hemisphere) = preg_split('/\s+/',$dms,4);
		$deg += ($min / 60) + ($sec / 3600);
		if (preg_match('/W|S/',$hemisphere))
			$deg = - $deg;
		else if (preg_match('/W|S/',$sec))
			$deg = - $deg;
		else if (preg_match('/W|S/',$min))
			$deg = - $deg;
		return $deg;	
	}

}




// Parser Tokens.  
// NB probably best to not define a token == 0 - sometimes issues
// distinguishing between null and token of value 0
define("TEXQL_ROOT",-1);
define("TEXQL_OPEN_BRACKET",1);
define("TEXQL_CLOSE_BRACKET",2);
define("TEXQL_TEXT",3);
define("TEXQL_LOGICAL_OP",4);
define("TEXQL_COMPARISON_OP",5);

/*
 * Class SqlParser
 *
 * A class to assist in assembling, translating and reaassmbling SQL
 * statements between different formats.  Used by Provider and descendents
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class SqlParser
{
	var $position;
	var $lastChar;
	var $lastString;
	var $phrase;

	function SqlParser($phrase)
	{
		$this->position = 0;
		$this->lastChar = '';
		$this->lastString = '';
		$this->phrase = $phrase;
	}

	function parseComplete()
	{
		return ($this->position >= strlen($this->phrase));
	}

	function getToken()
	{
		$this->lastString = '';
		while (! $this->parseComplete())
		{
			$this->lastChar =
				substr($this->phrase,$this->position++,1);

			$this->lastString .= $this->lastChar;
			$this->lastString = 
				preg_replace("/^\s/",'',$this->lastString);

			if ($this->lastString)
			{
				switch($this->lastString)
				{
					case '(':
						return TEXQL_OPEN_BRACKET;
						break;
					case ')':
						return TEXQL_CLOSE_BRACKET;
						break;
					case 'AND ' :
					case 'OR ' :
					case 'NOT ' :
						return TEXQL_LOGICAL_OP;
						break;
					/*case '<'  :
					case '>'  :
					case '<=' :
					case '>=' :
					case '='  :
					case 'LIKE ' :
					case 'CONTAINS ' :
						return TEXQL_COMPARISON_OP;
						break;*/
					default :
						break;
				}

				if (preg_match('/(.+\s*)(\)|AND |OR |NOT )/',
						$this->lastString,$match))
				{
					$this->position -= strlen($match[2]);
					$this->lastString = substr(
						$this->lastString,
							0,
							strlen($match[1]));

					return TEXQL_TEXT;
				}

	
				/*switch($this->lastChar)
				{
					case ' ' :
					case '<'  :
					case '>'  :
					case '='  :
					case ')' :
						$this->position--;
						$this->lastString = substr(
							$this->lastString,
							0,
							-1);

						return TEXQL_TEXT;
						break;
					default :
						break;
				}*/
			}
		}
		return TEXQL_TEXT;
	}
	
	function infixWhereToPostfix()
	{
		/* Used to dissassemble SQL WHERE clauses for easier
		 * translation
		 *
		 * returns a stack in POSTFIX order of atomic clauses and
		 * Logical Operators
		 *
		 * eg if passed:
		 * (Family = Culicidae AND ((State = NSW OR State = Vic) AND
		 *      Institution = NMNH))
		 * would return a list:
		 *   Family = Culicidae 
		 *   State = NSW
		 *   State = Vic
		 *   * OR *
		 *   Institution = NMNH
		 *   * AND *
		 *   * AND *
		 */

		$subSqlWhereParser = '';
		while (! $this->parseComplete())
		{
			$token = $this->getToken();

			switch ($token)
			{
				case TEXQL_TEXT :
					if ($this->lastString)
						$postfixStack[] = 
							$this->lastString;
					break;
				case TEXQL_OPEN_BRACKET :
					$op[] = TEXQL_OPEN_BRACKET;
					break;
				case TEXQL_CLOSE_BRACKET :
					$operator = '';
					while($op && ! $operator == 
						TEXQL_OPEN_BRACKET)
					{
						$operator = array_pop($op);
						if ($operator != 
							TEXQL_OPEN_BRACKET
						)
							$postfixStack[] = 
								$operator;
					}
					break;
				case TEXQL_LOGICAL_OP :
					$operator = '';
					while($op && ! $operator == 
						TEXQL_OPEN_BRACKET)
					{
						$operator = array_pop($op);
						if ($operator != 
							TEXQL_OPEN_BRACKET
						)
							$postfixStack[] = 
								$operator;
					}

					if ($operator == TEXQL_OPEN_BRACKET)
						array_push($op,$operator);

					$op[] = "* ". $this->lastString ."*";
					break;

				default :
					print "Unknown - $token -".
						"$this->lastString\n";
					break;
			}
		}
		foreach ($op as $operator)
			if ($operator != TEXQL_OPEN_BRACKET)
				$postfixStack[] = $operator;


		return $postfixStack;		
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
		 *   * OR *
		 *   Institution = NMNH
		 *   * AND *
		 *   * AND *
		 * would return a string
		 * (Family = Culicidae AND ((State = NSW OR State = Vic) AND
		 *      Institution = NMNH))
		 */
		$stack = array();
		foreach ($postfixStack as $item)
		{
			if (preg_match('/^\*(.+)\*/',$item,$match))
			{
				$operand2 = array_pop($stack);
				$operand1 = array_pop($stack);
				array_push($stack , 
					"($operand1 $match[1] $operand2)");
				
			}
			else
				array_push($stack,$item);
		}
		return implode($stack," $match[1] ");
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "Provider.php")
	{
		$webObject = new Provider();
		$webObject->test();
	}
}

?>
