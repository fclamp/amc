<?php

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');

/* Parser Tokens.  
 * NB probably best to not define a token == 0 - sometimes issues
 * distinguishing between null and token of value 0
 */
define("TEXQL_ROOT",-1);
define("TEXQL_OPEN_BRACKET",1);
define("TEXQL_CLOSE_BRACKET",2);
define("TEXQL_TEXT",3);
define("TEXQL_LOGICAL_OP",4);
define("TEXQL_COMPARISON_OP",5);


/**
 * Class SqlParser
 *
 * A class to assist in assembling, translating and reaassmbling SQL
 * statements between different formats.
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class SqlParser extends BaseWebServiceObject
{
	var $serviceName = "SqlParser";

	var $position;
	var $lastChar;
	var $lastString;
	var $phrase;


	function parse($phrase)
	{
		$this->position = 0;
		$this->lastChar = '';
		$this->lastString = '';
		$this->phrase = $phrase;
	}

	function describe()
	{
		return	
			"A SQL Parser is a BaseWebServiceObject that assists in\n".
			"parsing 'Generic' SQL statements\n\n".
			parent::describe();
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

				if ($this->lastChar == "'")
				{
					$lastChar = "";
					while ($lastChar != "'")
					{
						$lastChar =
							substr($this->phrase,$this->position++,1);
						$this->lastString .= $lastChar;
					}
					return TEXQL_TEXT;
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

		$postfixStack = array();
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

			// this hack to handle being passed "field CONTAINS ''" clauses
			// from boilerplate forms (that clause is a texql syntax error)
			if (preg_match("/contains\s+'\s*'/i",$item))
			{
				$item = 'FALSE';
			}

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

	function makeTestPage()
	{

		$args = array();
		$args['SQL WHERE'] =  "<textarea cols='80' rows='5' name='where'>".
			"(Foo='bar' AND Fido ='dog') OR (Fish = 'tuna' AND Dog LIKE 'Towser')</textarea>";

		$vars = array();
		$vars['class'] = 'SqlParser';
		$vars['test'] = 'true';
		$vars['testCall'] = 'true';
		$submission = "<input type='submit' name='action' value='parse' />";

		print $this->makeDiagnosticPage(
					"KE EMu ". $this->serviceName,
					"SQL Parser",
					'',
					'./SqlParser.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

	function test()
	{
		if (isset($_REQUEST['testCall']))
		{
			header("Content-type: text/plain",1);
			$this->parse($_REQUEST['where']);
			$postfix = $this->infixWhereToPostfix();
			$where = $this->postfixWhereToInfix($postfix);

			$postfixStack = Array();
			if (get_magic_quotes_gpc())
			{
				$where = stripslashes($where);
				$i = 0;
				foreach ($postfix as $item)
				{
					$postfixStack[] = $i++ .': '. stripslashes($item);
				}
				$_REQUEST['where'] = stripslashes($_REQUEST['where']);
			}
			print "Provided Infix Where:\n\t".$_REQUEST['where'] . "\n\n";
			print "Provided Infix Where To Postfix Stack:\n\t". implode("\n\t",$postfixStack) . "\n\n";
			print "Postfix Stack to Infix Where (should be logically same as Original Where):\n\t". $where . "\n";
		}
		else	
		{
			header("Content-type: text/html",1);
			print $this->makeTestPage();
		}
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "SqlParser.php")
	{
		$webObject = new SqlParser();
		$webObject->test();
	}
}

?>
