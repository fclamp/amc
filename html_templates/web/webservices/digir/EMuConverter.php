<?php
/*
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/Provider.php');
require_once ($WEB_ROOT . '/webservices/lib/FileOutput.php');

/*
** 
** Class EMuResponseConverter
**
** class provides parsing methods to assist in taking an EMu Response and
** translating it into Darwin Core XML.
** NB it is NOT a EMuWebService 'translator'
**
** @package EMuWebServices
**
*/

class 
EMuResponseConverter extends BaseWebServiceObject
{
        var $_map;
        var $_parser;
	var $_encoding;
	var $_standard;

	### want_record
	### want_results
	### results_found
	### want_element
	### reading_element
	### failed
        var $_parserMode;

	var $_fileOutput;

	var $_requestElements;
	var $_recordFuction;

	var $_record;
	var $_recordCount;
	var $_tableData = array();
	var $_data = '';

	var $_column;
	var $_subElementTag;
	var $_table = false;
	var $_inventory = array();

        function 
	EMuResponseConverter(&$map, $encoding, $standard)
        {
		$this->{get_parent_class(__CLASS__)}();

                $this->_map =& $map;
		$this->_encoding = $encoding;
		$this->_standard = $standard;
        }

	function 
	describe()
	{
		return	"A EMuToDarwin Converter is a tool to convert EMu XML response files into DiGIR XML files\n\n" .  parent::describe();
	}

	function 
	_parse($files)
	{
		$status = true;

		$this->_parser = xml_parser_create('UTF-8');
		xml_set_object($this->_parser, $this);
		xml_parser_set_option($this->_parser, XML_OPTION_CASE_FOLDING, false);
		xml_parser_set_option($this->_parser, XML_OPTION_SKIP_WHITE, true);
		xml_set_element_handler($this->_parser, '_open', '_close');
		xml_set_character_data_handler($this->_parser, '_data');

        	$this->_parserMode = 'want_results';
		unset($this->_recordCount);

		while (($file = array_shift($files)) !== NULL)
		{
                	if (($fileHandle = fopen($file, 'rb')) === false)
                	{
				$status = false;
                	  	$this->_diagnosticMesg
				(
					'GENERAL_ERROR', 
					'error', 
					"could not open EMu response file $file for reading",
					__LINE__
				);
				break;
                	}

			while (! feof($fileHandle))
			{
				if (($data = fread($fileHandle, 8192)) === false)
				{
					$status = false;
                	  		$this->_diagnosticMesg
					(
						'GENERAL_ERROR', 
						'error', 
						"could not read from EMu XML server response file $file",
						__LINE__
					);
					fclose($fileHandle);
					break 2;
				}

				if (xml_parse($this->_parser, $data, (feof($fileHandle) && empty($files))) == 0)
				{
					$status = false;
					$error = xml_error_string(xml_get_error_code($this->_parser));
					$line = xml_get_current_line_number($this->_parser);
					$column = xml_get_current_column_number($this->_parser);
					$mesg = "$error at line $line, column $column while parsing EMu XML server response";
					$this->_diagnosticMesg
					(
						'INVALID_QUERY',
						'error',
						$mesg
					);
					fclose($fileHandle);
					break 2;
				}
			}

			if (fclose($fileHandle) === false)
			{
				$status = false;
                	  	$this->_diagnosticMesg
				(
					'GENERAL_ERROR', 
					'error', 
					"could close EMu XML server response file $file",
					__LINE__
				);
				break;
			}
		}
		xml_parser_free($this->_parser);
		return $status;
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
			'PARSE_ERROR',
			'error',
			$message
		);

		$this->_parserMode = 'failed';
	}

	function 
	_diagnosticMesg($code, $severity, $message, $line=null)
	{
		if (isset($line))
			$mesg = "$code:$severity:$message in " . __FILE__ . " on  line $line";
		else
			$mesg = "$code:$severity:$message";

		trigger_error($mesg, E_USER_NOTICE);
	}

	function
	_mapGetValue($field, &$record)
	{
		if (($value = $this->_map->generateValue($field, $record)) === false)
		{
			$this->_diagnosticMesg
        	       	(
				'GENERAL_ERROR',
				'error',
				"could not generate value for field '$field'"
        	       	);
			return null;
		}
		return $value;
	}

	function 
	convert($requestElements, $files, &$recordCount)
	{
		$this->_requestElements = $requestElements;
		$this->_fileOutput =& new FileOutput();

		if ($requestElements['type'] == 'search')
		{
			$this->_recordFuction = '_searchRecord';
			if ($this->_parse($files) === false)
				return false;
		}
		else if ($requestElements['type'] == 'inventory')
		{
			$this->_recordFuction = '_inventoryRecord';
			if ($this->_parse($files) === false)
				return false;
			if ($this->_writeInventory() === false)
				return false;
		}
		else
		{
			$this->_diagnosticMesg
        	       	(
				'GENERAL_ERROR',
				'error',
				"unsupported request type '{$requestElements['type']}'",
				__LINE__
        	       	);
			return false;
		}

		### SET PASS THROUGH ARG
		$recordCount = $this->_recordCount;

		### RETURN THE OUTPUT FILES USED
		$files = $this->_fileOutput->finish();
		$this->debugFile($files, 4, 'digir response:');

		return $files;
	}

	function 
	_open($parser, $element, $attribute)
	{
		switch ($this->_parserMode)
		{
			case 'want_element':
				### KINDA NASTY 
				if (preg_match('/(:?_tab|0)$/', $element))
				{
					$this->_parserMode = 'want_table_element';
				}
				else
				{
					$this->_parserMode = 'reading_element';
				}
				$this->_column = $element;
				break;
			case 'want_table_element':
				$this->_parserMode = 'reading_table_element';
				break;
			case 'want_record':
				if ($element === 'record')
				{
					$this->_parserMode = 'want_element';
					$this->_record = array();
				}
				else
				{
					$this->_parseError("expecting 'record' element; got '$element' element");
				}
				break;
			case 'reading_element':
				### WE SPECIFIED e.g "select (foo,bar) as blah" IN THE TEXQL SELECT STATEMENT
				$this->_parserMode = 'reading_element';
				$this->_subElementTag = $this->_column;
				$this->_column = $element;
				$this->_record[$this->_subElementTag] = array();
				break;
			case 'want_results':
				if ($element === 'results')
				{
					$this->_parserMode = 'want_record';
				}
				else
				{
					$this->_parseError("expecting 'results' element; got '$element' element");
				}
				break;
			case 'results_found':
				$this->_parseError("unexpected start content at '$element'");
				break;
			case 'failed':
				return;
				break;
			default:
				$this->_parseError("unimplemented Parser Mode '$this->_parserMode' at start element $element");
				break;
		}
	}

	function 
	_close($parser, $element)
	{
		switch ($this->_parserMode)
		{
			case 'reading_element':
				if ($element === $this->_column)
				{
					$this->_parserMode = 'want_element';
					$data = trim($this->_data);
					if (! empty($data))
					{
						$data = preg_replace("/\n\n+/", "\n", $data);
						$data = $this->encodeXmlSpecialChars($data);
						if (! isset($this->_subElementTag))
						{
							$this->_record[$this->_column] = $data;
						}
						else
						{
							$this->_record[$this->_subElementTag][$this->_column] = $data;
						}
					}
					$this->_data = '';
				}
				else if ($element === $this->_subElementTag)
				{
					$this->_parserMode = 'want_element';
					unset($this->_subElementTag);
				}
				else
				{
					$mesg = "[CLOSE] expecting '$this->_column' or '$this->_subElementTag' element; got '$element' element";
				}
				break;
			case 'want_element':
				if ($element === 'record')
				{
					$this->_parserMode = 'want_record';
					if (! empty($this->_record))
					{
						if (! isset($this->_recordCount))
						{
							$this->_recordCount = 1;
						}
						else
						{
							$this->_recordCount++;
						}
						$this->{$this->_recordFuction}($this->_record);
					}
				}
				break;
			case 'want_record':
				if ($element === 'results')
				{
					$this->_parserMode = 'results_found';
				}
				else if ($element === 'record')
				{
					 $this->_parserMode = 'want_record';
				}
				else
				{
					$mesg = "[CLOSE] expecting 'results' or 'record' element; got '$element' element";
					$this->_parseError($mesg);
				}
				break;
			case 'reading_table_element':
				$this->_parserMode = 'want_table_element';
				$data = trim($this->_data);
				if (! empty($data))
				{
					$data = preg_replace("/\n\n+/", "\n", $data);
					$data = $this->encodeXmlSpecialChars($data);
					$this->_tableData[] = $data;
				}
				$this->_data = '';
				break;
			case 'want_table_element':
				if ($element === $this->_column)
				{
					$this->_parserMode = 'want_element';
					### HANDLE TABLE DATA
					if (! empty($this->_tableData))
					{
						$data = implode('; ', $this->_tableData);

						if (! isset($this->_subElementTag))
						{
							$this->_record[$this->_column] = $data;
						}
						else
						{
							$this->_record[$this->_subElementTag][$this->_column] = $data;
						}
						$this->_tableData = array();
					}
				}
				else
				{
					$mesg = "[CLOSE] expecting '$this->_column' element; got '$element' element";
					$this->_parseError($mesg);
				}
				break;
			case 'results_found':
				$mesg = "[CLOSE] unexpected content at '$element'";
				$this->_parseError($mesg);
				break;
			case 'failed':
				return;
				break;
			default:
				$mesg = "[CLOSE] unimplemented parser mode at end element $element";
				$this->_parseError($mesg);
				break;
		}
	}

	function 
	_data($parser, $data)
	{
		switch ($this->_parserMode)
		{
			case 'reading_element':
			case 'reading_table_element':
				$this->_data .= $data;
				break;
			case 'want_results':
			case 'want_record':
			case 'want_element':
			case 'want_table_element':
			case 'results_found':
				if (! ctype_space($data))
				{
					$mesg = "[DATA] unexpected content '$data'";
					$this->_parseError($mesg);
				}
				break;
			case 'failed':
				return;
				break;
			default:
				$mesg = "[DATA] unimplemented parser mode at character data for element $element";
				$this->_parseError($mesg);
				break;
		}
	}
	
	########################################
	### RECORD BUILDING/OUTPUT FUNCTIONS ###
	########################################

	function
	_searchRecord(&$record)
	{
		$data = $this->_buildSearchRecord($record, $this->_requestElements['fields'], "\t\t\t");	
		if (! empty($data))
		{
			$output = "\t\t" . '<record>' . "\n" . $data . "\t\t" . '</record>' . "\n";
			if ($this->_fileOutput->write($output) === false)
			{
				$this->_parserMode = 'failed';
				foreach ($this->_fileOutput->errors as $error)
				{
					$this->_diagnosticMesg
					(
						'GENERAL_ERROR', 
						'error', 
						$error,
						__LINE__
					);
				}
			}
		}
	}

	function
	_buildSearchRecord(&$record, $fields, $indent)
	{
		$response = '';
		if (empty($record))
			return $response;

		foreach (array_keys($fields) as $key)
		{
			$element = $fields[$key];
			if (! is_array($element))
			{
				if (($value = $this->_mapGetValue($element, $record)) !== null && $value != '')
				{
					$field = $this->_map->getField($element);
					$response .= $indent . '<' . $this->_standard . ':' . $field . '>';
					$response .= $value;
					$response .= '</' . $this->_standard . ':' . $field . ">\n";
				}
			}
			else
			{
				$subResponse = $this->_buildSearchRecord($record[$key], $element, $indent . "\t");
				if (! empty($subResponse))
				{
					$response .= $indent . '<' . $this->_standard . ':' . $key . '>' . "\n";
					$response .= $subResponse;
					$response .= $indent . '</' . $this->_standard . ':' . $key . ">\n";
				}
			}
		}
		return $response;
	}

	function
	_inventoryRecord(&$record)
	{
		$field = $this->_requestElements['fields'];
		$field = $this->_map->getField($field);

		if (($value = $this->_mapGetValue($field, $record)) !== null && $value != '')
		{
                	if (! isset($this->_inventory[$value]))
                	{
                		$this->_inventory[$value] = 1;
                	}
                	else
                	{
                		$this->_inventory[$value]++;
                	}
		}
	}
	
        function
        _writeInventory()
        {
                $field = $this->_requestElements['fields'];
		$field = $this->_map->getField($field);
                $showCount = $this->_requestElements['count'];

                $open = "\t\t" . '<record>' . "\n" . "\t\t\t" . '<' . $this->_standard . ':' . $field;
                $close = '</' . $this->_standard . ':' . $field . '>' . "\n" . "\t\t" . '</record>' . "\n";

                uksort($this->_inventory, 'strcasecmp');
                foreach ($this->_inventory as $value => $count)
                {
			$output = $open;
                        if ($showCount === true)
                        	$output .= " count='$count'";
			$output .= '>';
			$output .= $value;
			$output .= $close;
	
			if ($this->_fileOutput->write($output) === false)
			{
				foreach ($this->_fileOutput->errors as $error)
				{
					$this->_diagnosticMesg
					(
						'GENERAL_ERROR',
						'error',
						$error,
						__LINE__
					);
				}
				return false;
			}
		}
	}
}
?>
