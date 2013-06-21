<?php

/*
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/Provider.php');

/*
** 
** Class DigirRequestParser
**
** this class assists in extracting components of digir query xml and
** converting it to a base xml query format.  It really is meant to be 
** used by DigirProvider class only and should be considered 'private' 
** to that class
**
** @package EMuWebServices
**
*/
class 
DigirParser extends BaseWebServiceObject
{
	###
	### PARSER 
	###
	var $_parser;
	var $_parserMode;
	var $_data;

	function
	DigirParser()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();
	}

	#######################
	### PRIVATE METHODS ###
	#######################

	function 
	_parse(&$xml)
	{
		$status = true;
		$this->_data = '';

		$this->_parser = xml_parser_create('UTF-8');
		xml_set_object($this->_parser, $this);
		xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
		xml_parser_set_option($this->_parser, XML_OPTION_SKIP_WHITE, true);
		xml_set_element_handler($this->_parser, '_open', '_close');
		xml_set_character_data_handler($this->_parser, '_data');

		if (xml_parse($this->_parser, $xml, true) == 0)
		{
			$status = false;
			$error = xml_error_string(xml_get_error_code($this->_parser));
			$line = xml_get_current_line_number($this->_parser);
			$column = xml_get_current_column_number($this->_parser);
			$mesg = "XML parse error '$error' at line $line, column $column while parsing DiGIR request";

			$this->_diagnosticMesg
			(
				'INVALID_QUERY',
				'error',
				$mesg
			);
		}
		xml_parser_free($this->_parser);

		if ($this->_parserMode === 'failed')
			$status = false;

		return $status;
	}	

	function 
	_parseToStruct(&$xml)
	{
		$status = true;
		$this->_data = '';

		$this->_parser = xml_parser_create('UTF-8');
		xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
		xml_parser_set_option($this->_parser, XML_OPTION_SKIP_WHITE, true);

		### PARSE XML - TURNS OUT TO BE A LOT SIMPLER TO PARSE THE REQUEST TO A STRUCT
		### & CONSTRUCT REQUEST DETAILS FROM THERE THAN PARSE IT USING HANDLERS (PHP5 
		### HAS BETTER XML SUPPORT - SimpleXML WOULD BE GOOD FOR THIS JOB I THINK)
		if (xml_parse_into_struct($this->_parser, $xml, $requestElements) == 0)
		{
			$status = false;
			$error = xml_error_string(xml_get_error_code($this->_parser));
			$line = xml_get_current_line_number($this->_parser);
			$column = xml_get_current_column_number($this->_parser);
			$mesg = "XML parse error '$error' at line $line, column $column occured while parsing DiGIR request";

			$this->_diagnosticMesg
			(
				'INVALID_QUERY',
				'error',
				$mesg
			);
		}
		xml_parser_free($this->_parser);

		if ($status === false || $this->_parserMode === 'failed')
			$status = false;

		return $requestElements;
	}

	function 
	_parseError($message)
	{
		$line = xml_get_current_line_number($this->_parser);
		$column = xml_get_current_column_number($this->_parser);
		$message = "$message at line $line, column $column while parsing EMu XML server response";
		if (isset($this->_parserMode))
			$message .= ' [Parser Mode:  ' . $this->_parserMode . ']';

		$this->_diagnosticMesg
		(
			'REQUEST_PARSE_ERROR',
			'error',
			$message
		);

		$this->_parserMode = 'failed';
	}

	function 
	_diagnosticMesg($code, $severity, $message, $line=null)
	{
		if (isset($line))
			$mesg = "$code:$severity:$message in " . __FILE__ . " on line $line";
		else
			$mesg = "$code:$severity:$message";

		trigger_error($mesg, E_USER_NOTICE);
	}
}

class 
DigirHeaderParser extends DigirParser
{
	###
	### REQUEST 
	###
	var $_header = array();

	### CONSTRUCTOR
	function
	DigirHeaderParser()
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();
	}

	######################
	### PUBLIC METHODS ###
	######################

	function 
	parseHeader(&$xml)
	{
        	$this->_parserMode = 'want_request';

		if ($this->_parse($xml) === false)
			return false;

		if ($this->_validateHeader() === false)
			return false;

		return $this->_header;
	}	

	#######################
	### PRIVATE METHODS ###
	#######################

	function 
	_open($parser, $element, $attribute)
	{
		switch ($this->_parserMode)
		{
			case 'want_request':
				if (strtolower($element) === 'request')
				{
					$this->_parserMode = 'want_header';
				}
				else
				{
					$mesg = "[OPEN] expecting 'request' element; got '$element' element";
					$this->_parseError($mesg);
				}
				break;
			case 'want_header':
				if (strtolower($element) === 'header')
				{
					$this->_parserMode = 'want_header_element';
				}
				else
				{
					$mesg = "[OPEN] expecting 'header' element; got '$element' element";
					$this->_parseError($mesg);
				}
				break;
			case 'want_header_element':
				$this->_parserMode = 'reading_data';
				if (isset($attribute))
				{
					foreach ($attribute as $name => $value)
						$this->_header[$name] = $value;
				}
				break;
			case 'finished':
			case 'failed':
				return;
				break;
			default:
				$mesg = "[OPEN] unexpected open content at '$element' element";
				$this->_parseError($mesg);
				break;
		}
	}

	function 
	_close($parser, $element)
	{
		switch ($this->_parserMode)
		{
			case 'reading_data':
				$this->_parserMode = 'want_header_element';
				$this->_header[$element] = trim($this->_data);
				$this->_data = '';
				break;
			case 'want_header_element':
				if (strtolower($element) === 'header')
				{
					$this->_parserMode = 'finished';
				}
				else
				{
					$mesg = "[CLOSE] unexpected close content at '$element'";
					$this->_parseError($mesg);
				}
				break;
			case 'finished':
			case 'failed':
				return;
				break;
			default:
				$mesg = "[CLOSE] unexpected close content at '$element' element";
				$this->_parseError($mesg);
				break;
		}
	}

	function 
	_data($parser, $data)
	{
		switch ($this->_parserMode)
		{
			case 'reading_data':
				$this->_data .= $data;
				break;
			case 'finished':
			case 'failed':
				return;
				break;
			default:
				if (! ctype_space($data))
				{
					$mesg = "[DATA] unexpected data content '$data'";
					$this->_parseError($mesg);
				}
				break;
		}
	}

	function
	_validateHeader()
	{
		$status = true;
		if (! isset($this->_header['type']) || empty($this->_header['type']))
		{
			$status = false;
			$this->_diagnosticMesg
			(
				'INVALID_REQUEST',
				'error',
				'request type missing from header'
			);
		}
		else if ($this->_header['type'] !== 'metadata' && (! isset($this->_header['resource']) || empty($this->_header['resource'])))
		{
			$status = false;
			$this->_diagnosticMesg
			(
				'INVALID_REQUEST',
				'error',
				'destination resource missing from header'
			);
		}
		if (! isset($this->_header['destination']) || empty($this->_header['destination']))
		{
			$status = false;
			$this->_diagnosticMesg
			(
				'INVALID_REQUEST',
				'error',
				'destination missing from header'
			);
		}
		return $status;
	}
}

class 
DigirRequestParser extends DigirParser
{
	###
	### REQUEST 
	###
	var $_requestElements = array();
	var $_gotRecordTag = false;
	var $_header;

	var $_subStructureName;

	### INSTANCE OF FIELD MAPPING OBJECT
	var $_map;

	### LOCATION OF INVENTORY CACHE
	var $_inventoryCacheDir = 'webservices/digir/inventory';

	###
	### NON-NUMERIC RANGE QUERY
	###
	var $_transNonNumRangeQueries = true;
	var $_maxNonNumRangeQueries = 1000;

	###
	### DIGIR TO EMU MAPPINGS
	###
	var $_digirToCopMapping = array
	(
		'EQUALS' 		=> '=',
		'NOTEQUALS' 		=> '<>',
		'LESSTHAN' 		=> '<',
		'LESSTHANOREQUALS' 	=> '<=',
		'GREATERTHAN' 		=> '>',
		'GREATERTHANOREQUALS' 	=> '>=',
		'LIKE' 			=> 'CONTAINS',
		'LIST' 			=> '=',
	);

	var $_digirToLopMapping = array
	(
		'AND'			=> 'AND',
		'OR'                    => 'OR',
		'NOT'                   => 'NOT',
	); 

	var $_digirToLopNegMapping = array
	(
		'ANDNOT'		=> 'AND',
		'ORNOT'			=> 'OR',
	); 

	var $_negationOp = 'NOT';

	var $_multiComparisonOp = 'IN';
	var $_listOp = 'LIST';

	var $_likeOp = 'CONTAINS';
	var $_digirToPatternMatchOp = array
	(
		'%'			=> '*',
	); 

	var $_rangeOps = array
	(
		'<',
		'>',
		'<=',
		'>=',
	); 

	var $_nameSpaces = array
	(
		'darwin',
		'dwc',
		'xsd',
	); 

	### CONSTRUCTOR
	function
	DigirRequestParser(&$map, $inventoryCache)
	{
		### CALL PARENT CONSTRUCTOR
		$this->{get_parent_class(__CLASS__)}();

		$this->_map =& $map;
		$this->_inventoryCacheDir = $inventoryCache;
	}

	######################
	### PUBLIC METHODS ###
	######################

	function 
	parseRequest(&$xml, $header)
	{
		$this->_header = $header;

		if (($requestElements = $this->_parseToStruct($xml)) === false)
			 return false;

		if ($this->_setRequestDetails($requestElements) === false)
			return false;

		return $this->_requestElements;
	}	

	function 
	setNonNumRangeQueries($value)
	{
		$this->_transNonNumRangeQueries = $value;
	}

	function 
	setMaxNonNumRangeQueries($value)
	{
		$this->_maxNonNumRangeQueries = $value;
	}

	#######################
	### PRIVATE METHODS ###
	#######################

	function 
	_setRequestDetails($requestElements)
	{
		$filterElements = array();
		$structureElements = array();

		while (($currentElement = array_shift($requestElements)) !== null)
		{
			if (($tagType = strtolower($currentElement['type'])) == 'close')
				continue;
			$tagName = strtolower($currentElement['tag']);

			switch ($tagName)
			{
				case 'header':
				case 'type':
				case 'version':
				case 'sendtime':
				case 'source':
				case 'destination':
					### DO NOTHING
					break;
				case 'metadata':
				case 'inventory':
				case 'search':
					if ($tagType == 'open')
					{
						if ($this->_header['type'] != $tagName)
						{
							$this->_diagnosticMesg
							(
								'INVALID_QUERY',
								'error',
								"header type '{$this->_header['type']}' does not match request type '$tagName'"
							);
							return false;
						}
						$this->_requestElements['type'] = $tagName;
					}
					else 
					{
						$this->_diagnosticMesg
						(
							'INVALID_QUERY',
							'error',
							"request element '$tagName' cannot be complete"
						);
						return false;
					}
					break;
				case 'filter':
					if ($tagType == 'open')
					{
						$filterElements = $this->_getSubElements($requestElements, $currentElement);
					}
					else
					{
						$this->_diagnosticMesg
						(
							'INVALID_QUERY',
							'error',
							"request element '$tagName' cannot be complete"
						);
						return false;
					}
					break;
				case 'structure':
					if ($tagType == 'open')
					{
						$structureElements = $this->_getSubElements($requestElements, $currentElement);
					}
					else
					{
						if (isset($currentElement['attributes']))
							foreach ($currentElement['attributes'] as $attrName => $attrValue)
								$this->_requestElements[strtolower($attrName)] = $attrValue;
					}
					break;
				case 'records':
					if ($tagType == 'open')
					{
						if (isset($currentElement['attributes']))
							foreach ($currentElement['attributes'] as $attrName => $attrValue)
								$this->_requestElements[strtolower($attrName)] = $attrValue;
					}
					else
					{
						$this->_diagnosticMesg
						(
							'INVALID_QUERY',
							'error',
							"request element '$tagName' cannot be complete"
						);
						return false;
					}
					break;
				case 'count':
					if ($tagType == 'complete')
					{
						if (isset($currentElement['value']) && $currentElement['value'] == 'true')
							$this->_requestElements[$tagName] = true;
						else
							$this->_requestElements[$tagName] = false;
					}
					else
					{
						$this->_diagnosticMesg
						(
							'INVALID_QUERY',
							'error',
							"request element '$tagName' must be complete"
						);
						return false;
					}
					break;
				case 'request':
					if ($tagType == 'open')
					{
						if (isset($currentElement['attributes']))
						{
							foreach (array_keys($currentElement['attributes']) as $key)
							{
								if (preg_match('/^xmlns:(\w+)$/i', $key, $match))
								{
									if (! in_array($match[1], $this->_nameSpaces))
										$this->_nameSpaces[] = strtolower($match[1]);
								}
							}
						}
					}
					else
					{
						$this->_diagnosticMesg
						(
							'INVALID_QUERY',
							'error',
							"request element '$tagName' cannot be complete"
						);
						return false;
					}
					break;
				default:
					if ($tagType == 'complete' && $this->_isDataElement($tagName))
					{
						$inventoryField = $this->_digirToFieldName($currentElement['tag']);
					}
					else
					{
                        			$this->_diagnosticMesg
                        			(
							'INVALID_QUERY',
							'error',
                        			        "unexpected request element '$tagName'"
                        			);
						return false;
					}
					break;
			}

		}
		

		if ($this->_header['type'] == 'metadata')
		{
			return true;
		}
		else if ($this->_header['type'] == 'inventory')
		{
			if (! isset($inventoryField))
			{
                       		$this->_diagnosticMesg
                       		(
					'INVALID_QUERY',
					'error',
                       		        "no field specified for {$this->_header['type']} request"
                       		);
				return false;
			}

			$this->_requestElements['fields'] = $inventoryField;

			if (($columns = $this->_mapGetColumns($inventoryField)) === false)
				return false;
			if (isset($columns))
				$this->_requestElements['structure'] = $columns;

			if (! empty($filterElements))
			{
				if (($this->_requestElements['filter'] = $this->_parseFilter($filterElements)) === false)
					return false;
			}
		}
		else if ($this->_header['type'] == 'search')
		{
			if (($this->_requestElements['structure'] = $this->_parseStructure($structureElements)) === false)
				return false;

			if (($this->_requestElements['filter'] = $this->_parseFilter($filterElements)) === false)
				return false;
		}
		else
		{
			$this->_diagnosticMesg
			(
				'INVALID_QUERY', 
				'error', 
				"unknown request type '{$this->_requestElements['type']}'"
			);
			return false;
		}
		return true;
	}

	function
	_parseStructure($structureElements)
	{
		if (empty($structureElements))
		{
			$schemaLocation = $this->_requestElements['schemalocation'];

			if (! isset($schemaLocation))
			{
				$this->_diagnosticMesg
				(
					'INVALID_QUERY',
					'error',
					'no structure was defined'
				);
				return false;
			}

			if ($this->phpVersionMinimum('4.3.0'))
			{
				$xml = @file_get_contents($schemaLocation);
			}
			else
			{
				$xml = @file($schemaLocation);
				if ($xml !== false)
					$xml = implode('', $xml);
			}

			if ($xml === false)
			{
                        	$this->_diagnosticMesg
                        	(
                        	        'GENERAL_ERROR',
                        	        'error',
                        	        "could not read schemaLocation at $schemaLocation"
                        	);
				return false;
			}

			$parser = xml_parser_create();
			xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
			xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);

			if (xml_parse_into_struct($parser, $xml, $structureElements) == 0)
			{
				$mesg = xml_error_string(xml_get_error_code($parser));
				$this->_diagnosticMesg
				(
					'INVALID_QUERY',
					'error',
					$mesg,
					__LINE__
				);
				return false;
			}
			xml_parser_free($parser);
		}

		$this->_requestElements['fields'] = array();
		$structure = $this->_structureToTexql($structureElements);
		if (empty($structure))
			return null;

		return $structure;
	}

	function
	_structureToTexql($structureElements)
	{
		$structure = '';
		while (($currentElement = array_shift($structureElements)) !== null)
		{
			### WE ONLY CARE ABOUT THE ELEMENT TAGS
			if (preg_match('/:element$/i', $currentElement['tag']))
			{
				if (isset($currentElement['attributes']['name']))
				{
					$currentElementName = $currentElement['attributes']['name'];
					### USE THE FIRST ATTRIBUTE NAME AS THE "RECORD" TAG
					if ($this->_gotRecordTag === false)
					{
						$this->_gotRecordTag = true;
					}
					else ### WE HAVE A SUB-STRUCTURE - REMOVE FROM LIST AND RECURSE TO PARSE IT
					{
						$this->_subStructureName = $currentElementName;
						$subStructureElements = $this->_getSubElements($structureElements, $currentElement);

						if (! empty($structure))
							$structure .= ',';

						$structure .= '(';	
						$structure .= $this->_structureToTexql($subStructureElements);
						$structure .= ')';	
						$structure .= ' AS ' . $currentElementName;

						unset($this->_subStructureName);
					}
				}
				else if ($currentElement['type'] == 'complete' && isset($currentElement['attributes']['ref']))
				{
					### IF WE FIND A ELEMENT WITH A "ref" ATTRIBUTE ADD TO LIST
					$field = $this->_digirToFieldName($currentElement['attributes']['ref']);

					if (($columns = $this->_mapGetColumns($field)) !== false)
					{
						if (isset($columns))
						{
							if (! empty($structure))
								$structure .= ',';
							$structure .= $columns;
						}

						### ADD FIELD TO LIST OF REQUESTED FIELDS
						if (isset($this->_subStructureName))
						{
							if (! isset($this->_requestElements['fields'][$this->_subStructureName]))
							{
								$this->_requestElements['fields'][$this->_subStructureName] = array();
							}
							$this->_requestElements['fields'][$this->_subStructureName][] = $field;
						}
						else
						{
							$this->_requestElements['fields'][] = $field;
						}
					}
				}
			}
		}
		return $structure;
	}

	function
	_parseFilter($filterElements)
	{
		if (empty($filterElements))
			return false;
		if (($filter = $this->_filterToTexql($filterElements)) === false)
			return false;
		if (empty($filter))
			return false;
		return $filter;
	}

	function
	_filterToTexql(&$filterElements, $parentTagName=null)
	{
		$filter = array();
		while (($currentElement = array_shift($filterElements)) !== null)
		{
			$tagName = $currentElement['tag'];
			if ($this->_isLogicalOp($tagName)) ### AND, OR, NOT, ANDNOT & ORNOT
			{
				$subElements = $this->_getSubElements($filterElements, $currentElement);

				if ($this->_validateElements($filterElements, $parentTagName, $currentElement, $subElements) === false)
					return false;

				### RECURSE
				if (($subElements = $this->_filterToTexql($subElements, $tagName)) === false)
					return false;

				### GENERATE THE TEXQL SKIPPING ITEMS THAT HAVE ALREADY BEEN GENERATED
				$texql = array();
				foreach($subElements as $subElement)
					$texql[] = $this->_generateTexql($subElement);

				### HANDLE CRAZY 'ANDNOT' & 'ORNOT' LOGICAL OPERATORS BY PREFIXING 'NOT'
				### IN FRONT OF EACH TERM OF THE QUERY PART AND TRANSFORM THE 'ANDNOT' & 'ORNOT'
				### INTO A REGULAR 'AND' OR 'OR'
				$negation = '';
				if ($this->_isLogicalOpNeg($tagName))
					$negation = "{$this->_negationOp} ";

				$filter[] = '(' . $negation . implode(' ' . $this->_digirToLop($tagName) . ' ' . $negation, $texql) . ')';
			}
			else if ($this->_isMultiComparisonOp($tagName)) ### IN
			{
				$subElements = $this->_getSubElements($filterElements, $currentElement);

				if ($this->_validateElements($filterElements, $parentTagName, $currentElement, $subElements) === false)
					return false;

				### RECURSE
				if (($subElements = $this->_filterToTexql($subElements, $tagName)) === false)
					return false;

				### GENERATE THE TEXQL
				$texql = array();
				foreach($subElements as $subElement)
					$texql[] = $this->_generateTexql($subElement);

				$filter[] = '(' . implode(' OR ', $texql) . ')';
			}
			else if ($this->_isListOp($tagName)) ### LIST
			{
				$subElements = $this->_getSubElements($filterElements, $currentElement);

				if ($this->_validateElements($filterElements, $parentTagName, $currentElement, $subElements) === false)
					return false;

				### RECURSE
				if (($filter = $this->_filterToTexql($subElements, $tagName)) === false)
					return false;
			}
			else if ($this->_isComparisonOp($tagName)) ### EQUALS, NOTEQUALS, LESSTHAN, LESSTHANOREQUALS, 
			{					   ### GREATERTHAN, GREATERTHANOREQUALS & LIKE
				$subElements = $this->_getSubElements($filterElements, $currentElement);

				if ($this->_validateElements($filterElements, $parentTagName, $currentElement, $subElements) === false)
					return false;

				### RECURSE
				if (($filter[] = $this->_filterToTexql($subElements, $tagName)) === false)
					return false;
			}
			else if ($this->_isDataElement($tagName))
			{
				if ($this->_validateElements($filterElements, $parentTagName, $currentElement, null) === false)
					return false;

				$field = $currentElement['tag'];
				$operator = $parentTagName;
				$value = $currentElement['value'];

				### IF THIS IS A LIKE QUERY THEN WE NEED TO TRANSFORM THE DIGIR PATTERN MATCH
				### OPERATOR '%' TO THE TEXQL PATTERN MATCH OPERATOR '*'
				### GENERATE AN ERROR IF THE OPERATOR DOES NOT EXIST IN THE DIGIR QUERY
				if ($this->_isLikeOp($operator))
				{
					if (($value = $this->_digirToPatternMatchOp($value)) === false)
                        			return false;
				}
				
				### BUILD QUERY PART STRUCTURE
				$query = array
				(
					'field' => $this->_digirToFieldName($field),
					'operator' => $this->_digirToCop($operator),
					'value' => $value
				);

				### LIST ELEMENTS CAN HAVE MULTIPLE DATA ELEMENTS INSIDE ONE LIST TAG SO WE
				### NEED TO GATHER THEM 
				### COMPARISON ELEMENTS (THE ONLY OTHER ELEMENT THAT CAN BE A PARENT OF A DATA
				### ELEMENT) MUST HAVE ONE ELEMENT BETWEEN ITS TAGS SO DON'T GATHER IT
				if ($this->_isListOp($parentTagName))
					$filter[] = $query;
				else
					$filter = $query;
			}
		}

		### CHECK FOR NON-NUMERIC RANGE QUERIES
		### IF WE FIND ONE TRY TO TRANSFORM IT TO USE EQUALS USING INVENTORY FILES
		if ($this->_isLogicalOp($parentTagName) || ! isset($parentTagName))
		{
			if (($filter = $this->_transNonNumRangeQueries($filter, $parentTagName)) === false)
			{
				return false;
			}
		}

		### THE FINAL GENERATED TEXQL IS STORED IN THE FIRST POSITION OF THE
		### FILTER ARRAY. IF WE HAVE NO PARENT WE MUST HAVE FINISHED RECURSING
		### SO JUST RETURN THE TEXQL
		if (! isset($parentTagName))
			$filter = $this->_generateTexql($filter[0]);

		return $filter;
	}

	function
	_getSubElements(&$elements, $currentElement)
	{
		$subElements = array();
		while (($subElement = array_shift($elements)) !== null)
		{
			if (strtolower($subElement['tag']) == strtolower($currentElement['tag']) && 
			    $subElement['level'] == $currentElement['level'] && 
		       	    strtolower($subElement['type']) == 'close')
				break;
			$subElements[] = $subElement;
		}
		return $subElements;
	}

	function
	_mapGetColumns($field)
	{
		if (($isMapping = $this->_map->isMapping($field)) !== true)
		{
			if ($isMapping === null)
			{
				$this->_diagnosticMesg
        	       		(
					'INVALID_QUERY_TERM',
					'error',
					"requested field '$field' is not known to this provider"
        	       		);
			}
			else
			{
				$this->_diagnosticMesg
        	       		(
					'GENERAL_WARNING',
					'warning',
					"requested field '$field' is not mapped by this provider"
        	       		);
			}
			return false;
		}
		else
		{
			$columns = $this->_map->getColumns($field);
			if (! isset($columns))
				return null;
			if (empty($columns))
				return false;
			return implode(',', $columns);
		}
	}

	function
	_mapGetTexql($field, $operator, $value)
	{
		if (($isMapping = $this->_map->isMapping($field)) !== true)
		{
			if ($isMapping === null)
			{
				$this->_diagnosticMesg
        	       		(
					'INVALID_QUERY_TERM',
					'error',
					"requested field '$field' in filter is not known to this provider"
        	       		);
			}
			else
			{
				$this->_diagnosticMesg
        	       		(
					'INVALID_QUERY_TERM',
					'error',
					"requested field '$field' in filter is not mapped by this provider"
        	       		);
			}
			return false;
		}
		else
		{
			$texql = $this->_map->generateTexql($field, $operator, $value);

			if (! isset($texql))
			{
				$emuToDigirCopMapping = array_flip($this->_digirToCopMapping);
				$operator = $emuToDigirCopMapping[$operator];
				$this->_diagnosticMesg
        	       		(
					'GENERAL_ERROR',
					'error',
					"comparison operation $operator not supported on field $field"
        	       		);
				return false;
			}
			else if ($texql === false)
			{
				$this->_diagnosticMesg
        	       		(
					'GENERAL_ERROR',
					'error',
					"could not generate TEXQL for field $field",
					__LINE__
        	       		);
				return false;
			}
			return $texql;
		}
	}

	function
	_mapGetFieldName($field)
	{
		if (($field = $this->_map->getField($field)) === false)
		{
			$this->_diagnosticMesg
        	       	(
				'INVALID_QUERY_TERM',
				'error',
				"requested field '$field' is not known to this provider"
        	       	);
			return false;
		}
		return $field;
	}

	function
	_generateTexql($element)
	{
		if (! is_array($element))
			return $element;
		return $this->_mapGetTexql($element['field'], $element['operator'], $element['value']);
	}

	function
	_validateElements(&$filterElements, $parentTagName, $currentElement, $subElements)
	{
		$tagName = $currentElement['tag'];
		$tagType = $currentElement['type'];

		if ($this->_isLogicalOp($tagName))
		{
			if ($tagType != 'open')
			{
				$this->_diagnosticMesg
                       		(
                       		        'INVALID_QUERY',
                       		        'error',
                       		        "logical operator '$tagName' cannot be empty",
					__LINE__
                       		);
                       		return false;
			}
			else if (isset($parentTagName) && ! $this->_isLogicalOp($parentTagName))
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "logical operator '$tagName' cannot be an element of the '$parentTagName' operator",
					__LINE__
                        	);
                        	return false;
			}
			else if ($this->_isNegationOp($tagName) && count($subElements) > 3)
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "logical operator '$tagName' must contain only 1 element",
					__LINE__
                        	);
                        	return false;
			}
			else if (! $this->_isNegationOp($tagName) && count($subElements) < 6)
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "logical operator '$tagName' must contain 2 or more elements",
					__LINE__
                        	);
                        	return false;
			}
		}
		else if ($this->_isMultiComparisonOp($tagName))
		{
			if ($tagType != 'open')
			{
				$this->_diagnosticMesg
                       		(
                       		        'INVALID_QUERY',
                       		        'error',
                       		        "operator '$tagName' cannot be empty",
					__LINE__
                       		);
                       		return false;
			}
			else if (count($subElements) < 3)
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "operator '$tagName' must contain 1 or more elements",
					__LINE__
                        	);
                        	return false;
			}
			else if (isset($parentTagName) && ! $this->_isLogicalOp($parentTagName))
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "operator '$tagName' cannot be an element of the '$parentTagName' operator",
					__LINE__
                        	);
                        	return false;
			}
		}
		else if ($this->_isListOp($tagName))
		{
			if ($tagType != 'open' || count($subElements) < 1)
			{
				$this->_diagnosticMesg
                       		(
                       		        'INVALID_QUERY',
                       		        'error',
                       		        "list operator '$tagName' cannot be empty",
					__LINE__
                       		);
                       		return false;
			}
			else if (isset($parentTagName) && ! $this->_isMultiComparisonOp($parentTagName))
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "list operator '$tagName' cannot be an element of the '$parentTagName' operator",
					__LINE__
                        	);
                        	return false;
			}
		}
		else if ($this->_isComparisonOp($tagName))
		{
			if ($tagType != 'open')
			{
				$this->_diagnosticMesg
                       		(
                       		        'INVALID_QUERY',
                       		        'error',
                       		        "comparison element '$tagName' cannot be empty",
					__LINE__
                       		);
                       		return false;
			}
			else if (count($subElements) < 1)
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "comparison operator '$tagName' cannot be empty",
					__LINE__
                        	);
                        	return false;
			}
			else if (isset($parentTagName) &&
				 ! $this->_isListOp($parentTagName) &&
				 ! $this->_isLogicalOp($parentTagName))
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "comparison operator '$tagName' cannot be an element of the '$parentTagName' operator",
					__LINE__
                        	);
                        	return false;
			}
		}
		else if ($this->_isDataElement($tagName))
		{
			if ($tagType != 'complete')
			{
				$this->_diagnosticMesg
                       		(
                       		        'INVALID_QUERY',
                       		        'error',
                       		        "data element '$tagName' cannot contain other elements",
					__LINE__
                       		);
                       		return false;
			}
			else if (! isset($parentTagName))
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "data element '$tagName' must be an element of another operator",
					__LINE__
                        	);
                        	return false;
			}
			else if (! $this->_isComparisonOp($parentTagName) &&
			         ! $this->_isListOp($parentTagName))
			{
				$this->_diagnosticMesg
                        	(
                        	        'INVALID_QUERY',
                        	        'error',
                        	        "data element '$tagName' cannot be an element of the '$parentTagName' operator",
					__LINE__
                        	);
                        	return false;
			}
		}
		else
		{
			$this->_diagnosticMesg
                       	(
                       	        'INVALID_QUERY',
                       	        'error',
                       	        "unknown filter element '$tagName'",
				__LINE__
                       	);
                       	return false;
		}

		###
		### WE MUST HAVE FINISHED RECURSING BUT WE STILL HAVE FILTER ELEMENTS
		### LEFT. TYPICALLY BECAUSE DIGIR REQUEST IS BADLY FORMATTED 
		### i.e. TWO COMPARISON ELEMENTS NOT NESTED INSIDE A LOGICAL OPERATOR ELEMENT
		###
		if (! isset($parentTagName) &&
		    ! empty($filterElements))
		{
			$this->_diagnosticMesg
                       	(
                       	        'INVALID_QUERY',
                       	        'error',
                       	        'filter elements are improperly nested',
				__LINE__
                       	);
                       	return false;
		}
		return true;
	}

	function
	_transNonNumRangeQueries($elements, $logicalOp)
	{
		### ONLY TRANSLATE IF TRANSLATION IS ENABLED.
		### ALSO DON'T TRANSLATE ANDNOT & ORNOT LOGICAL OPERATIONS AS THE
		### "NOT" IS A PROPERTY OF THE VALUE (NOT THE OPERATOR)
		### WHICH MEANS WE GET CONSTRUCTIONS LIKE "> ! foo" WHICH ARE MEANINGLESS 
		if (! $this->_transNonNumRangeQueries || 
		    strtolower($logicalOp) == 'ornot' ||
		    strtolower($logicalOp) == 'andnot')
			return $elements;

		$mergedQueries = array();

		### FOR EACH NON-NUMERIC RANGE QUERY GET THE QUERY DETAILS AND STORE IN A SINGLE STRUCTURE
		### NOTE THEIR POSITION IN THE ORIGINAL ELEMENTS STRUCTURE
		for($i = 0; $i < count($elements); $i++)
		{
			if ($this->_isNonNumRangeQuery($elements[$i]))
			{
				$field = $elements[$i]['field'];
				$operator = $elements[$i]['operator'];
				$value = $elements[$i]['value'];

				if (! isset($mergedQueries[$field]))
					$mergedQueries[$field] = array();

				if ($operator == '>' || $operator == '>=')
				{
					if (isset($mergedQueries[$field]['greaterThanValue']))
						return $elements;
				
					$mergedQueries[$field]['greaterThanValue'] = $value;
					$mergedQueries[$field]['greaterThanIndex'] = $i;
					$mergedQueries[$field]['greaterThanOp'] = $operator;
				}
				else if ($operator == '<' || $operator == '<=')
				{
					if (isset($mergedQueries[$field]['lessThanValue']))
						return $elements;
				
					$mergedQueries[$field]['lessThanValue'] = $value;
					$mergedQueries[$field]['lessThanIndex'] = $i;
					$mergedQueries[$field]['lessThanOp'] = $operator;
				}
			}
		}

		### RETURN THE ELEMENTS UNCHANGED IF THERE ARE NO NON-NUMERIC RANGE QUERIES
		if (empty($mergedQueries))
			return $elements;

		foreach ($mergedQueries as $field => $range_details)
		{
			$greaterThanValue = $range_details['greaterThanValue'];
			$greaterThanIndex = $range_details['greaterThanIndex'];
			$greaterThanOp = $range_details['greaterThanOp'];

			$lessThanValue = $range_details['lessThanValue'];
			$lessThanIndex = $range_details['lessThanIndex'];
			$lessThanOp = $range_details['lessThanOp'];

			if (isset($greaterThanValue) && isset($lessThanValue))
			{
				if (strtolower($logicalOp) == 'or')
				{
					### e.g. > B || < D == everything
					if (strcmp($greaterThanValue, $lessThanValue) <= 0)
					{
						### DONT BOTHER AS THIS QUERY GETS EVERYTHING
						continue;
					}
					else ### e.g. < B || > D == A,E,F...
					{
						$collect = true;
						$startValue = $greaterThanValue;
						$skipValue = $lessThanValue;
					}
				}
				else if (strtolower($logicalOp) == 'and')
				{
					### e.g. > B && < D == C
					if (strcmp($greaterThanValue, $lessThanValue) <= 0)
					{
						$collect = false;
						$startValue = $greaterThanValue;
						$endValue = $lessThanValue;
					}
					else ### e.g. > D && < B == nothing
					{
						$mesg = "$field $greaterThanOp $greaterThanValue";
						$mesg .= " $logicalOp ";
						$mesg .= "$field $lessThanOp $lessThanValue";

						$this->_diagnosticMesg
                       				(
                       				        'BAD_QUERY',
                       				        'error',
                       				        "no records can match '$mesg'",
							__LINE__
                       				);
						return false;
					}
				}
				else
				{
					continue;
				}
			}
			else if (isset($greaterThanValue))
			{
				$collect = false;
				$startValue = $greaterThanValue;
			}
			else
			{
				$collect = true;
				$endValue = $lessThanValue;
			}

			if (($fieldname = $this->_mapGetFieldName($field)) === false)
				continue;

			$inventoryFile = "$this->webRoot/$this->_inventoryCacheDir/$fieldname.xml";
                        if (($fileHandle = fopen($inventoryFile, 'rb')) === false)
                        {
				$this->_diagnosticMesg
                       		(
                       		        'GENERAL_WARNING',
                       		        'warning',
                       		        "could not open file $inventoryFile for non-numeric range query",
					__LINE__
                       		);
				continue;
                        }

			$nsPattern = implode('|', $this->_nameSpaces);
			$pattern  = "<(?:$nsPattern):$field.*>(.+)<\/(?:$nsPattern):$field>";

			$dataValues = array();
                	while (! feof($fileHandle))
                	{
                        	if (($line = trim(fgets($fileHandle))) === false)
                        	{
					$this->_diagnosticMesg
                       			(
                       			        'GENERAL_WARNING',
                       			        'warning',
                       			        "could not read from file $inventoryFile for non-numeric range query",
						__LINE__
                       			);

                        		if (fclose($fileHandle) === false)
                        		{
						$this->_diagnosticMesg
                       				(
                       				        'GENERAL_WARNING',
                       				        'warning',
                       				        "could not close file $inventoryFile for non-numeric range query (1)",
							__LINE__
                       				);
                        		}
					continue 2;
                        	}

				if (preg_match("/^$pattern$/", $line, $match))
				{
					if ($collect === true)
					{
						$dataValues[] = $match[1];

						if (isset($skipValue) && $skipValue == $match[1])
						{
							$collect = false;
							if ($lessThanOp == '<')
								array_pop($dataValues);
						}
					}
					else if (isset($startValue) && $startValue == $match[1])
					{
							$collect = true;
							if ($greaterThanOp == '>=')
								$dataValues[] = $match[1];
					}

					if (isset($endValue) && $endValue == $match[1])
						break;
				}
			}

                       	if (fclose($fileHandle) === false)
                       	{
				$this->_diagnosticMesg
                       		(
                       		        'GENERAL_WARNING',
                       		        'warning',
                       		        "could not close file $inventoryFile for non-numeric range query (2)",
					__LINE__
                       		);
                       	}

			if (empty($dataValues) || count($dataValues) > $this->_maxNonNumRangeQueries)
				return $elements;

			$newElements = array();
			foreach ($dataValues as $value)
			{
				$element = array
				(
					'field' => $field,
					'operator' => '=',
					'value' => $value
				);
				$newElements[] = $this->_generateTexql($element);
			}
			$newElements = '(' . implode(' OR ', $newElements) . ')';

			if (isset($greaterThanIndex) && isset($lessThanIndex))
			{
				if ($greaterThanIndex > $lessThanIndex)
				{
					$elements[$greaterThanIndex] = $newElements;
					array_splice($elements, $lessThanIndex, 1);
				}
				else
				{
					$elements[$lessThanIndex] = $newElements;
					array_splice($elements, $greaterThanIndex, 1);
				}
			}
			else if (isset($greaterThanIndex))
			{
				$elements[$greaterThanIndex] = $newElements;
			}
			else
			{
				$elements[$lessThanIndex] = $newElements;
			}
		}
		return $elements;
	}

	function 
	_isNonNumRangeQuery($element)
	{
		if (is_array($element) &&
		    $this->_isRangeOp($element['operator']) &&
		    ! is_numeric($element['value']))
			return true;
		return false;
	}

	function 
	_isMultiComparisonOp($element)
        {
                if (preg_match("/^$element$/i", $this->_multiComparisonOp))
                	return true;
                return false;
        }

	function 
	_isListOp($element)
        {
                if (preg_match("/^$element$/i", $this->_listOp))
                	return true;
                return false;
        }

	function 
	_isLikeOp($element)
        {
                if (preg_match("/^$element$/i", $this->_likeOp))
                	return true;
                return false;
        }

	function 
	_isRangeOp($element)
	{
		if (in_array(strtoupper($element), $this->_rangeOps))
			return true;
		return false;
	}

	function 
	_isComparisonOp($element)
	{
		if (array_key_exists(strtoupper($element), $this->_digirToCopMapping))
			return true;
		return false;
	}

	function 
	_isNegationOp($element)
	{
                if (preg_match("/^$element$/i", $this->_negationOp))
			return true;
		return false;
	}

	function 
	_isLogicalOp($element)
	{
		if (array_key_exists(strtoupper($element), $this->_digirToLopMapping) ||
		    array_key_exists(strtoupper($element), $this->_digirToLopNegMapping))
			return true;
		return false;
	}

	function 
	_isLogicalOpNeg($element)
	{
		if (array_key_exists(strtoupper($element), $this->_digirToLopNegMapping))
			return true;
		return false;
	}

	function 
	_isDataElement($element)
	{
		if (preg_match('/^(?:' . implode('|', $this->_nameSpaces) . '):/i', $element))
			return true;
		return false;
	}

	function 
	_digirToCop($operator)
	{
		$operator = strtoupper($this->_digirToCopMapping[strtoupper($operator)]);
		return $operator;
	}

	function 
	_digirToLop($operator)
	{
		if (array_key_exists(strtoupper($operator), $this->_digirToLopMapping))
		{
			$operator = strtoupper($operator);
			$operator = strtoupper($this->_digirToLopMapping[$operator]);
		}
		else if (array_key_exists(strtoupper($operator), $this->_digirToLopNegMapping))
		{
			$operator = strtoupper($operator);
			$operator = strtoupper($this->_digirToLopNegMapping[$operator]);
		}
		return $operator;
	}

	function 
	_digirToPatternMatchOp($value)
	{
		reset($this->_digirToPatternMatchOp);
		list($digirOp, $op) = each($this->_digirToPatternMatchOp);

                $new_value = preg_replace("/$digirOp/", $op, $value);
		if ($new_value == $value)
		{
			$this->_diagnosticMesg
                	(
                       	        'INVALID_QUERY',
                       	        'error',
                       	        "comparison operator '$this->_likeOp' data element must contain the pattern match operator '$digirOp'"
                       	);
			return false;
		}
		return $new_value;
	}

	function 
	_digirToFieldName($field)
	{
                $field = preg_replace('/^(?:' . implode('|', $this->_nameSpaces) . '):/i', '', $field);
		return $field;
	}
}
?>
