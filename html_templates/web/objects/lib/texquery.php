<?php
/*
*	Copyright (c) 1998-2012 KE Software Pty Ltd
*    texquery.php - Query texpress database via texmlserver
*	this is an enhanced texquery.php with some EMu/Lifedata smarts.
*
*	TODO - This needs a rewite.  It's been patched up a number of
*		time to quickly add functionality.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'xmlparser.php');
require_once ($LIB_DIR . 'serverconnection.php');
require_once ($LIB_DIR . 'common.php');

class Record {}
class xmlHandler
{

	var $Data = array();
	var $Matches = -1;
	var $Status = '';
	var $Error = '';

	// Language - FIXME - this is a hack and needs fixing!
	var $SelectedLanguage;
	var $SupportedLanguages;
	var $LanguageDelimiter;
	var $LanguageShowFirstFilled;
	
	// Private
	var $recordno = 0;
	var $currentField = '';
	var $tabno = 0;
	var $nesttabno = 0;

	function startElement($name, $attr)
	{
		$Record =& $this->Data;
		if ($name == 'record')
		{
			$Record[$this->recordno] = new Record;
			$this->tabno = 0;
			$this->nesttabno = 0;
			return;
		}
		elseif ($name == 'results')
		{
			$this->Status = $attr['status'];
			if (isset($attr['error']))
				$this->Error = $attr['error'];
			if (isset($attr['matches']))
				$this->Matches = $attr['matches'];
			else
				$this->Matches = -1;
			return;
		}
		$this->currentField = $name;

		//
		// if the field is nested then suffix with a number
		//
		if (strpos($name, '_tab') > 1 || preg_match('/[^:\d]0$/', $name))
		{
			$this->tabno++;
		}
		elseif (strpos($name, '_nesttab') > 1)
		{
			$this->nesttabno++;
		}
		elseif($this->nesttabno > 0)
		{
			$this->currentField = $name . ':' . $this->tabno . ':' . $this->nesttabno;
			$this->nesttabno++;
		}
		elseif($this->tabno > 0)
		{
			$this->currentField = $name . ':' . $this->tabno;
			$this->tabno++;
		}
	}

	function endElement($name)
	{
		$this->currentField = '';

		if ($name == 'record')
		{
			$this->recordno++;
		}
		elseif (strpos($name, '_tab') > 1 || preg_match('/[^:\d]0$/', $name))
		{
			if ($this->nesttabno < 1)
				$this->tabno = 0;
			if ($this->nesttabno > 1)
				$this->nesttabno = 1;
		}
		elseif (strpos($name, '_nesttab') > 1)
		{
			$this->nesttabno = 0;
			$this->tabno = 0;
		}

	}
	
	function cData($data)
	{
		$Record =& $this->Data;
		if ($this->currentField == "irn_1")
		{
			$Record[$this->recordno]->{$this->currentField} 
					= $data;
		}
		elseif ($this->currentField != "")
		{
			$Record[$this->recordno]->{$this->currentField} 
					= $this->_filterLanguages($data);
		}
	}

	function
	_filterLanguages($data)
	{
		if ($this->SelectedLanguage == "")
		{
			// Return all
			return $data;
		}
		elseif ($data == "")
		{
			return $data;
		}
		elseif (! $this->LanguageShowFirstFilled)
		{
			// Don't filter number and date fields
			// TODO - should modify texxmlserver so it passes through
			// basic type information.
			if ( is_numeric($data) || preg_match("/^\d*\/*\d*\/*\d*$/", $data) )
			{
				return $data;
			}
		}

		$splitdata = explode($this->LanguageDelimiter, $data);

		// find location of selected languages
		$languages = explode(";", $this->SelectedLanguage);
		$lall = explode(";", $this->SupportedLanguages);
		for ($i = 0; $i < count($lall); $i++)
		{
			$lpos[$lall[$i]] = $i; 
		}

		$r = "";
		foreach ($languages as $lang)
		{
			if ($r != "")
				$r .= $this->LanguageDelimiter;
			$r .= $splitdata[$lpos[$lang]];
		}
		
		if ($this->LanguageShowFirstFilled && $r == "")
		{
			foreach ($splitdata as $d)
			{
				if ($d != "")
					$r = $d;
			}
		}
		return $r;
	}
}

class QueryResult
{
	var $Data = array();
	var $Matches = 0;
	var $Status = '';
}

/*
** Returns a _QueryResult object
*/
function
_doQuery($texql, $lang, $supportedLang, $langDelim, $firstFilled)
{
	$handler = new xmlHandler;
	$handler->SelectedLanguage = $lang;
	$handler->SupportedLanguages = $supportedLang;
	$handler->LanguageDelimiter = $langDelim;
	$handler->LanguageShowFirstFilled = $firstFilled;

	$xmlparser = new xmlParser;
	$xmlparser->handler =& $handler;

	// Open connection to texxmlserver
	$conn = new TexxmlserverConnection;
	$fd = $conn->Open();
	if (!$fd || $fd < 0)
	{
		WebDie('Cannot connect to the KE XML database server.', 'Query - _doQuery()');
	}

	$get = "GET /?texql=" . urlencode($texql) . " HTTP/1.0\r\n\r\n";
	fputs($fd, $get);
	fflush($fd);
	$xmlparser->parseFD($fd);
	fclose($fd);

	$ret = new QueryResult;
	$ret->Data = $handler->Data;
	$ret->Matches = $handler->Matches;
	$ret->Status = $handler->Status;
	$ret->Error = $handler->Error;

	return $ret;
}


class
Query
{

	var $Select = array();
	var $From;
	var $Where;
	var $Texql = '';
	var $Order = '';
	// default limit
	var $Limit = 20;
	var $Offset = 1;
	// Access restrictions (default to web)
	var $Internet = 1;
	var $Intranet = 0;
	var $All = 0;
	// Language
	var $SelectedLanguage = "";		// default to all
	var $SupportedLanguages = "0";		// default to english only
	var $LanguageDelimiter = ";:;";		// default to standard EMu
	var $LanguageShowFirstFilled = 1;

	// Set after a fetch call
	var $Data = array();
	var $Matches = -1;
	var $Status = '';
	var $Error = '';

	var $SystemYes = "Yes";

	// Used for relevance ranking
	var $RankOn; 			// Note that both of these must be set to correctly activate relevance ranking.
	var $RankTerm;			// RankOn is field on which to rank, RankTerm is the term to search for.
					// Note also that RankOn must be one of the fields in the WHERE statement of
					// 	query, or a syntax error can be caused (as the RankOn field can never
					//	be NULL is a results set).
					// Set RankOn as a paramter on the URL of the results list to be ranked.

	function
	_accessPrivileges()
	{
		// Construct with access privilages
		if ($this->All)
			return '';

		if ($this->Intranet)
		{
			return (' and AdmPublishWebPassword contains \''
				. $this->SystemYes . '\'');
		}
		elseif ($this->Internet)
		{
			return (' and AdmPublishWebNoPassword contains \''
				. $this->SystemYes . '\'');
		}
		return '';
	}


	function
	Fetch()
	{

		// verify selected language
		if ($this->SelectedLanguage != "" && !is_numeric($this->SelectedLanguage))
		{
			$map["english"] 	= "0";
			$map["french"] 		= "1";
			$map["english-us"] 	= "2";
			$map["spanish"] 	= "3";
			$map["german"] 		= "4";
			$n = $map[strtolower($this->SelectedLanguage)];
			if (is_numeric($n))
				$this->SelectedLanguage = $n;
		}
		
		$nested = array();
		if ($this->Texql != '')
		{
			if ($GLOBALS['DEBUG'] == 1)
				print "<pre>TEXQL STATEMENT: $this->Texql</pre><br />\n";
			$result = _doQuery($this->Texql, 
					   $this->SelectedLanguage, 
					   $this->SupportedLanguages, 
					   $this->LanguageDelimiter,
					   $this->LanguageShowFirstFilled);
			$this->Data = $result->Data;
			$this->Matches = $result->Matches;
			$this->Status = $result->Status;
		}
		else
		{
			$texql = 'SELECT';
			$select = array();
			foreach($this->Select as $name)
			{
				//
				// If the format is CurCreatorRef1->eparties->NamFirst then do
				// a nested query
				//
				if (preg_match('/->/', $name))
				{
					// Need to perform a nested query, only grab ref field for now
					$sections = split('->', $name);
					$name = $sections[0];
					array_push($nested, $sections);
				}

				// if format is ColumnID:2 then sub for ColumnID_tab
				if (preg_match('/^(.*?):\d+$/', $name, $matches))
				{
					$name = $matches[1] . "_tab";
				}
				$select[$name]++;
			}

			if ( !empty($this->RankOn) )
			{
				if (empty($this->RankTerm))
				{
					WebDie('RankTerm and RankOn must both be set for relevance ranking',
						'In texquery.php:Query::Fetch()');
				}

				$select[$this->RankOn]++;
			}

			$num = 1;
			$selectfields = "";
			while (list($name, $null) = each($select))
			{
				$num == 1 ? $selectfields .= " $name" : $selectfields .= ", $name";
				$num++;
			}
			$texql .= $selectfields;	
			$texql .= ' FROM ' . $this->From . ' WHERE true ';

			// Construct WHERE if given
			if ($this->Where != '')
			{
				$texql .= ' and (' . $this->Where . ') ';
			}

			// Construct with access privilages
			$texql .= $this->_accessPrivileges();

			// Construct 'order' or rank if required
			if ($this->Order != '')
			{
				$texql = 'order(' . $texql . ') on ' . $this->Order;
			}
			elseif ($this->RankOn != "")
			{
				$texql = 'order ( (' . $texql . ') ['. $selectfields .', count(words(' . $this->RankOn . ') WHERE ' .
					$this->RankOn . " IN ['" . $this->RankTerm . "']) AS rank] ) ON rank desc";
			}

			// Limit results
			if ($this->Limit != '' && $this->Limit > 0)
			{
				$upper = $this->Offset + $this->Limit - 1;
				$texql = '(' . $texql . '){' . $this->Offset . ' to ' . $upper . '}';
			}

			$texql = stripslashes($texql);
			if ($GLOBALS['DEBUG'] == 1)
				print "<pre>TEXQL STATEMENT: $texql</pre><br />\n";

			$result = _doQuery($texql,
					   $this->SelectedLanguage, 
					   $this->SupportedLanguages, 
					   $this->LanguageDelimiter,
					   $this->LanguageShowFirstFilled);
			$this->Data = $result->Data;
			$this->Matches = $result->Matches;
			$this->Status = $result->Status;
			$this->Error = $result->Error;

			// Now get any links via a 2nd nested query
			foreach($nested as $sections)
			{
				list($ref, $table, $field, $table2, $field2) = $sections;
				while (list($j, $record) = each($this->Data))
				{
					// if refereance field is multi-value, then roll over references
					if (preg_match('/(.*)_tab/', $ref, $matches))
					{
						$suffix = 1;
						$col = $matches[1];
						$tabref = $col . ":$suffix";
						while (isset($record->$tabref))
						{
							$storename = $tabref. '->' . $table . '->' . $field;
							$texql = "SELECT $field FROM $table WHERE irn=" 
								. $record->$tabref . $this->_accessPrivileges();
							if ($GLOBALS['DEBUG'] == 1)
								print "<pre>TEXQL STATEMENT: $texql</pre><br />\n";
							$result = _doQuery($texql,
									   $this->SelectedLanguage, 
									   $this->SupportedLanguages, 
									   $this->LanguageDelimiter,
									   $this->LanguageShowFirstFilled);
							$subrecords = $result->Data;
							$this->Data[$j]->$storename = $subrecords[0]->$field;
							if (!empty($field2))
							{
								$this->_doDoubleLevelQuery(
										$j,
										$storename,
										$subrecords[0]->$field,
										$table2,
										$field2);
							}
							$suffix++;
							$tabref = $col . ":$suffix";
						}
					}
					if (preg_match('/(.*[^:\d])(_tab|0)$/', $field, $matches))
					{
						// the field in the referenced table is multi-value, so roll over values
						$texql = "SELECT $field FROM $table WHERE irn=" 
								. $record->$ref . $this->_accessPrivileges();
						if ($GLOBALS['DEBUG'] == 1)
							print "<pre>TEXQL STATEMENT: $texql</pre><br />\n";
						$result = _doQuery($texql,
								   $this->SelectedLanguage, 
								   $this->SupportedLanguages, 
								   $this->LanguageDelimiter,
								   $this->LanguageShowFirstFilled);
						$subrecords = $result->Data;
						
						$suffix = 1;
						$col = $matches[1];
						$tabref = $col . ":$suffix";
						while ($subrecords[0]->$tabref != '')
						{
							
							$storename = $ref. '->' . $table . '->' . $tabref;
							$this->Data[$j]->$storename = $subrecords[0]->$tabref;
							if (!empty($field2))
							{
								$this->_doDoubleLevelQuery(
										$j,
										$storename,
										$subrecords[0]->$tabref,
										$table2,
										$field2);
							}
							$suffix++;
							$tabref = $col . ":$suffix";
						}
					}
					else
					{
						$storename = $ref. '->' . $table . '->' . $field;
						if ($record->$ref != '')
						{
							$texql = "SELECT $field FROM $table WHERE irn=" 
								. $record->$ref . $this->_accessPrivileges();
							if ($GLOBALS['DEBUG'] == 1)
								print "<pre>TEXQL STATEMENT: $texql</pre><br />\n";
							$result = _doQuery($texql,
									   $this->SelectedLanguage, 
									   $this->SupportedLanguages, 
									   $this->LanguageDelimiter,
									   $this->LanguageShowFirstFilled);
							$subrecords = $result->Data;
							$this->Data[$j]->$storename = $subrecords[0]->$field;
							if (!empty($field2))
							{
								$this->_doDoubleLevelQuery(
										$j,
										$storename,
										$subrecords[0]->$field,
										$table2,
										$field2);
							}
						}
						else
							$this->Data[$j]->$storename = '';
					}
				}
				reset($this->Data);
			}
		}
		return $this->Data;

	} //End fetch()

	/* Following function added to allow double level query functionality,
	*	i.e. TaxTaxonomyRef->etaxonomy->IdeIdentifiedByRef->eparties->SummaryData
	*/
	function
	_doDoubleLevelQuery($qryindex, $storename, $sourceirn, $table, $field)
	{
		$texql = "SELECT $field FROM $table WHERE irn=$sourceirn" . $this->_accessPrivileges();
		if ($GLOBALS['DEBUG'] == 1)
			print "<pre>TEXQL STATEMENT: $texql</pre><br />\n";
		$result = _doQuery(
				$texql,
				$this->SelectedLanguage,
				$this->SupportedLanguages,
				$this->LanguageDelimiter,
				$this->LanguageShowFirstFilled);
		$subrecords = $result->Data;

		if (preg_match('/(.*)_tab/', $field, $matches))
		{
			$suffix = 1;
			$col = $matches[1];
			$tabref = $col . ":$suffix";
			while ($subrecords[0]->$tabref != '')
			{
				$newstorename = $storename . "->" . $table . "->" . $tabref;
				$this->Data[$qryindex]->$newstorename = $subrecords[0]->$tabref;
				$suffix++;
				$tabref = $col . ":$suffix";
			}
		}
		else
		{
			$newstorename = $storename . "->" . $table . "->" . $field;
			$this->Data[$qryindex]->$newstorename = $subrecords[0]->$field;
		}
	}

	/*
	** Take a texql statement and print out the RAW XML returned
	**	from texxmlserver
	*/
	function
	PrintXML($texql="")
	{
		if ($texql != "")
			$this->Texql = $texql;

		if ($this->Texql == "")
		{
			WebDie("Texql must be set for XMLPrint", "Query - Print XML");
		}

		// Open connection to texxmlserver
		$conn = new TexxmlserverConnection;
		$fd = $conn->Open();
		if (!$fd || $fd < 0)
		{
			WebDie('Cannot connect to the KE XML database server.', 'Query - _printRawXML()');
		}

		$get = "GET /?texql=" . urlencode($this->Texql) 
				. " HTTP/1.0\r\n\r\n";
		fputs($fd, $get);
		fflush($fd);

		/* Strip returned header from texxmlserver and output 
		** as PHP HTTP header
		*/
		while (!feof($fd))
		{
			$out = trim(fgets($fd, 4096));
			// break on an empty link (end of HTTP header) 
			if ($out == '')
				break;
			Header($out);
		}

		// cat remainder of XML to output
		while (!feof($fd))
		{
			print fgets($fd, 4096);
		}
		fclose($fd);
	}

} // End Query Class

?>
