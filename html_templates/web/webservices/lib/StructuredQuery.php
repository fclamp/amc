<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');

class StructuredQuery extends BaseWebServiceObject
{
	var $serviceName = "StructuredQuery";

	function describe()
	{
		return	
			"A StructuredQuery is a Generic represention ".
			"of a SQL like Query Statement.\n\n".
			parent::describe();
	}

	function operatorToSymbol($operator)
	{
		switch(strtolower($operator))
		{
			case 'equals': 
				$operator = '=';
				break;
			case 'lessThan': 
				$operator = '<';
				break;
			case 'greaterThan': 
				$operator = '>';
				break;
			case 'notEquals': 
				$operator = '!=';
				break;
			case 'greaterThanOrEquals': 
				$operator = '>=';
				break;
			case 'lessThanOrEquals': 
				$operator = '<=';
				break;
			case 'equals': 
				$operator = '=';
				break;
		}
		return $operator;
	}

	function symbolToOperator($symbol)
	{
		switch($symbol)
		{
			case '=': 
				$operator = 'equals';
				break;
			case '<': 
				$operator = 'lessThan';
				break;
			case '>': 
				$operator = 'greaterThan';
				break;
			case '!=': 
				$operator = 'notEquals';
				break;
			case '>=': 
				$operator = 'greaterThanOrEquals';
				break;
			case '<=': 
				$operator = 'lessThanOrEquals';
				break;
			case '=': 
				$operator = 'equals';
				break;
			default: $operator = $symbol;
		}
		return $operator;
	}

	function serialiseSqlStructure(
					$selectArray,
					$fromArray,
					$postfixWhereArray,
					$limits)
	{
		$xml[] = "<query>";
		$xml[] = "\t<select>";
		foreach ($selectArray as $field)
		{
			$xml[] = "\t\t<field>$field</field>";
		}
		$xml[] = "\t</select>";
		$xml[] = "\t<sources>";
		foreach ($fromArray as $source)
		{
			$xml[] = "\t\t<source>$source</source>";
		}
		$xml[] = "\t</sources>";
		$xml[] = "\t<postfixFilterStack>";
		$stackLevel = count($postfixWhereArray);
		foreach ($postfixWhereArray as $clause)
		{
			$stackLevel--;
			$xml[] = "\t\t<stackItem level='$stackLevel'>";
			if (preg_match("/^\*\* (.+) \*\*$/",$clause,$match))
			{
				$xml[] = "\t\t\t<logicalOperator type='$match[1]'/>";
			}
			else if (preg_match("/^(\S+)\s+(\S+)\s+(.+)$/",$clause,$match))
			{
				$field = $match[1];
				$operator = $this->symbolToOperator($match[2]);
				$value = $match[3];
				
				$xml[] = "\t\t\t<comparison type='$operator'>";
				$xml[] = "\t\t\t\t<field>$field</field>";
				$xml[] = "\t\t\t\t<value>$value</value>";
				$xml[] = "\t\t\t</comparison>";
			}
			else
			{
				$xml[] = "\t\t\t<verbatimCriteria>$clause</verbatimCriteria>";
			}
			$xml[] = "\t\t</stackItem>";
		}
		$xml[] = "\t</postfixFilterStack>";
		$xml[] = "\t<limits from='$limits[0]' to='$limits[1]' />";
		$xml[] = "</query>";
		return implode("\n",$xml);
	}

	function startSqlStructureElement($p,$element,$attrib)
	{
	
		switch($this->parserMode)
		{
			case 'wantQuery':
				if ($element == 'query')
					$this->parserMode = 'wantSelect';
				break;
			case 'wantSelect':	
				if ($element == 'select')
					$this->parserMode = 'wantField';
				break;
			case 'wantField':	
				if ($element == 'field')
					$this->parserMode = 'readSelectField';
				break;
			case 'wantSources':	
				if ($element == 'sources')
					$this->parserMode = 'readSource';
				break;
			case 'wantPostfixFilterStack':	
				if ($element == 'postfixFilterStack')
					$this->parserMode = 'wantStackItem';
				break;
			case 'wantStackItem':	
				if ($element == 'stackItem')
				{
					$this->stackLevel = $attrib['level'];
					$this->parserMode = 'readStackItem';
				}
				break;
			case 'readStackItem' :
				$this->stackElement = '';	
				switch ($element)
				{
					case  'comparison' :
						$this->operator = $this->operatorToSymbol($attrib['type']);
						$this->field = '';
						$this->value = '';
						$this->parserMode = 'wantFieldValue';
						break;
					case  'logicalOperator' :
						$this->stackElement = "** " .$attrib['type'] . " **";
						$this->parserMode = 'wantStackItem';
						break;
					case 'verbatimCriteria' :
						$this->parserMode = 'readVerbatimCriteria';
						break;
				}
				break;
			case 'wantFieldValue' :
				switch ($element)
				{
					case  'field' :
						$this->parserMode = 'readFieldName';
						break;
					case  'value' :
						$this->parserMode = 'readFieldValue';
						break;
				}	
				break;
			case 'wantLimits' :
				if ($element == 'limits')
				{
					$this->limits['from'] = $attrib['from'];
					$this->limits['to'] = $attrib['to'];
				}
				break;

			case 'readSelectField' :
				if ($element == 'field')
					break;
				$this->errorResponse("Unexpected parser state: '" . $this->parserMode . "' when handling element '$element'\n");
				break;
			case 'readSource' :
				if ($element == 'source')
					break;
				$this->errorResponse("Unexpected parser state: '" . $this->parserMode . "' when handling element '$element'\n");
				break;

			default	:
				$this->errorResponse("Unexpected parser state: '" . $this->parserMode . "' when handling element '$element'\n");
		}
	}

	function endSqlStructureElement($p,$element)
	{
		switch ($this->parserMode)
		{
			case 'readSelectField' :
				if ($element == 'select')
					$this->parserMode = 'wantSources';
				break;
			case 'readSource' :	
				if ($element == 'sources')
					$this->parserMode = 'wantPostfixFilterStack';
				break;
			case 'wantStackItem' :	
				if ($element == 'stackItem')
					$this->postfixFilterStack[$this->stackLevel] = $this->stackElement;
				else if ($element == 'postfixFilterStack')
					$this->parserMode = 'wantLimits';
				break;
			case 'wantFieldValue' :		
				if ($element == 'comparison')
					$this->parserMode = 'wantStackItem';
				$this->stackElement = $this->field . " " . $this->operator . " " . $this->value;	
				break;
		}
	}

	function sqlStructureCharacterData($p,$data)
	{
		$data = trim($data);
		switch ($this->parserMode)	
		{
			case 'readSelectField':
				if ($data)
					$this->select[] = $data;
				break;
			case 'readSource':	
				if ($data)
					$this->source[] = $data;
				break;
			case 'readFieldName':	
				if ($data)
					$this->field = $data;
				$this->parserMode = 'wantFieldValue';
				break;
			case 'readFieldValue':	
				if ($data)
					$this->value = $data;
				$this->parserMode = 'wantFieldValue';
				break;
			case 'readVerbatimCriteria':	
				if ($data)
					$this->stackElement = $data;
				$this->parserMode = 'wantStackItem';
				break;
			default	:
				if ($data)
					$this->errorResponse("Unexpected parser state: " . $this->parserMode . " when reading data: $data\n");
		}
	}

	function deSerialiseSqlStructure($xml)
	{
		$this->select = Array();
		$this->source = Array();
		$this->postfixFilterStack = Array();
		$this->limits = Array( 'from' => '', 'to' => '');
		$this->parserMode = 'wantQuery';

		$parser = xml_parser_create();

		xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING, false);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_set_object($parser,$this);
		xml_set_element_handler($parser,'startSqlStructureElement','endSqlStructureElement');
		xml_set_character_data_handler($parser,'sqlStructureCharacterData');

		xml_parse($parser,$xml,true);

		xml_parser_free($parser);

		if ($this->select[0] == '*')
			$this->select[0] = 'ALL';

		return Array($this->select,
				$this->source,
				$this->postfixFilterStack,
				$this->limits);
	}

	function getFilterFields($postfixArray)
	{
		/* Return a list of fields in a where stack */
		$wanted = Array();
		foreach ($postfixArray as $item)
		{

			if (preg_match('/^([^\*]\S+) (\S+) (.+)$/',$item,$match))
			{
				$wanted[$match[1]]++;
			}
		}
		return array_keys($wanted);
	}

	function _postfixWhereToInfix($postfixArray,$fieldTypes=null,$translations=null)
	{
		/* Used to reassemble SQL WHERE clauses from a Postfix stack
		 *
		 * eg 
		 * if passed a list:
		 *   Family = Culicidae 
		 *   State = NSW
		 *   State = Vic
		 *   ** OR **
		 *   Institution = NMNH
		 *   ** AND **
		 *   ** AND **
		 * would return a string
		 * (Family = Culicidae AND ((State = NSW OR State = Vic) AND
		 *      Institution = NMNH))
		 *
		 */

		$stack = array();
		foreach ($postfixArray as $item)
		{

			// this hack to handle being passed "field CONTAINS ''" clauses
			// from boilerplate forms (that clause is a texql syntax error)
			if (preg_match("/contains\s+'\s*'/i",$item))
			{
				$item = 'FALSE';
			}

			if (preg_match('/^\** (.+) \**$/',$item,$match))
			{
				$operand2 = array_pop($stack);
				$operand1 = array_pop($stack);
				$stack[] = "($operand1 $match[1] $operand2)";
				
			}
			else if (preg_match('/^(\S+) (\S+) (.+)$/',$item,$match))
			{
				$field = $match[1];
				$operator = $match[2];
				$value = $match[3];

				if (isset($translations[$field]))
					$field = $translations[$field];

				if (isset($fieldTypes[$field]))
				{
					switch($fieldTypes[$field])
					{
						case "integer":
						case "float":
							$stack[] = "$field $operator $value";
							break;
						default	:
							$stack[] = "$field $operator '$value'";
					}
				}
				else
				{
					// if we don't know type assume string/text
					$stack[] = "$field $operator '$value'";
				}
			}
			else if (preg_match('/^(TRUE|FALSE)$/i',$item))
			{
				$stack[] = $item;
			}	
			else
			{
				// stack incorrectly built (parsing error?)
			}
		}
		return implode($stack," $match[1] ");
	}



	function testSerialise($select,$from,$where,$limits)
	{
		$xml = $this->serialiseSqlStructure($select,$from,$where,$limits);
		$this->_debug('serialised data',$xml,1);
	}

	function testDeSerialise($xml)
	{
		if (get_magic_quotes_gpc())
			$xml = stripslashes($xml);
		list ($select,$from,$where,$limits) = $this->deSerialiseSqlStructure($xml);
		$this->_debug('deserialised data',Array('SELECT' => $select, 'FROM' => $from, 'WHERE' => $where, 'LIMITS' => $limits, 'XML' => $xml),1);
	}

	function test($clientSpecific=false,$dir='')
	{
		if (isset($_REQUEST['serialise']))
		{
			$select = $_REQUEST['select'];
			$select = preg_replace("/\s+/"," ",$select);
			$selectA = preg_split("/,/",$select);

			$from[] = $_REQUEST['from'];

			$filter = $_REQUEST['where'];
			$filter = preg_replace("/\r\n+$/","",$filter);
			$filterA = preg_split("/\r\n/",$filter);

			$limits[0] = $_REQUEST['limitFrom'];
			$limits[1] = $_REQUEST['limitTo'];
			$this->testSerialise(
				$selectA,
				$from,
				$filterA,
				$limits
			);
		}
		else if (isset($_REQUEST['deserialise']))
		{
			$this->testDeSerialise($_REQUEST['xml']);
		}
		else	
		{
			header("Content-type: text/html",1);
			print $this->makeTestPage('','');
		}
	}

	function makeTestPage($title,$description)
	{
		$xml = "
<query>
	<select>
		<field>Genus</field>
		<field>Species</field>
		<field>Latitude</field>
		<field>Longitude</field>
	</select>
	<sources>
		<source>EMu</source>
	</sources>
	<postfixFilterStack>
		<stackItem level='6'>
			<comparison type='greaterThan'>
				<field>YearIdentified</field>
				<value>2002</value>
			</comparison>
		</stackItem>
		<stackItem level='5'>
			<comparison type='LIKE'>
				<field>Country</field>
				<value>*Russia*</value>
			</comparison>
		</stackItem>
		<stackItem level='4'>
			<logicalOperator type='AND'/>
		</stackItem>
		<stackItem level='3'>
			<comparison type='LIKE'>
				<field>Species</field>
				<value>pinace*</value>
			</comparison>
		</stackItem>
		<stackItem level='2'>
			<logicalOperator type='OR'/>
		</stackItem>
		<stackItem level='1'>
			<comparison type='LIKE'>
				<field>Genus</field>
				<value>Abies*</value>
			</comparison>
		</stackItem>
		<stackItem level='0'>
			<logicalOperator type='AND'/>
		</stackItem>
	</postfixFilterStack>
	<limits from='1' to='10' />
</query>
";
		$args = array();
		$args["XML"] = "<textarea name='xml' cols='60' rows='30'>$xml</textarea><br/>" .
			"<input type='submit' name='deserialise' value='deserialise'/>";
		$args["Select"] = "<textarea name='select' cols='10' rows='3'>Genus,Species,Latitude,Longitude</textarea>";
		$args["From"] = "<input name='from' size='5' value='EMu' />";
		$args["Where Stack"] = "<textarea name='where' cols='30' rows='6'>".
	 		 "YearIdentified > 2002\n".
	 		 "Country LIKE *Russia*\n".
	 		 "** AND **\n".
	 		 "Species LIKE pinace*\n".
	 		 "** OR **\n".
	 		 "Genus LIKE Abies*\n".
	 		 "** AND **\n".
			"</textarea>";
		$args["Limits From"] = "<input name='limitFrom' size='5' value='1' />";
		$args["Limits To"] = "<input name='limitTo' size='5' value='10' /><br/>".
			"<input type='submit' name='serialise' value='serialise'/>";
		$vars = array();

		print $this->makeDiagnosticPage(
					"KE EMu ". $this->serviceName,
					'Query/Filter DataStructure Handling',
					'',
					'./StructuredQuery.php',
					$args,
					'',
					$vars,
					$this->describe()
				);

	}


}



if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "StructuredQuery.php")
	{
		$webObject = new StructuredQuery();
		$webObject->test();
	}
}

?>
