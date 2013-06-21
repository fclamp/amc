<?php

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');
require_once ($LIB_DIR . 'common.php');

class PhmConfiguredQuery extends ConfiguredQuery
{
	function
	PhmConfiguredQuery()
	{

		// Constructor - setup defaults
		$this->SystemYes = GetLutsEntry("system yes");

		$this->SupportedLanguages = GetRegistryEntry(	
							"system",
							"setting",
							"language", 
							"supported");
		if (isset($GLOBALS['LANGUAGE_DELIMITER']))
		{
			$this->LanguageDelimiter = 
					$GLOBALS['LANGUAGE_DELIMITER'];
		}

		if (isset($GLOBALS['LANGUAGE_SHOW_FIRST_FILLED']))
		{
			$this->LanguageShowFirstFilled = 
				$GLOBALS['LANGUAGE_SHOW_FIRST_FILLED'];
		}
		else
		{
			// else get default out of registry
			$showfirst = GetRegistryEntry(
						"system",
						"setting",
						"language",
						"show first filled");
			$showfirst = strtolower($showfirst);
			$this->LanguageShowFirstFilled = ($showfirst == "true");
		}
		
		// Check to see if "lang" is set in the url
		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['lang']) && is_numeric($ALL_REQUEST['lang']))
		{
			$this->SelectedLanguage = $ALL_REQUEST['lang'];
		}
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
				print "<pre>1 TEXQL STATEMENT: $this->Texql</pre><br />\n";
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
				print "<pre>2 TEXQL STATEMENT: $texql</pre><br />\n";

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
						while ($record->$tabref != '')
						{
							$storename = $tabref. '->' . $table . '->' . $field;

							/*
							$texql = "SELECT $field FROM $table WHERE irn=" 
								. $record->$tabref . $this->_accessPrivileges();
							if ($GLOBALS['DEBUG'] == 1)
								print "<pre>NESTED TEXQL STATEMENT: $texql</pre><br />\n";

							$result = _doQuery($texql,
									   $this->SelectedLanguage, 
									   $this->SupportedLanguages, 
									   $this->LanguageDelimiter,
									   $this->LanguageShowFirstFilled);
								
							$subrecords = $result->Data;
							$this->Data[$j]->$storename = $subrecords[0]->$field;
							*/
							$this->Data[$j]->$storename = $record->$tabref;

							/*
							if (!empty($field2))
							{
								$this->_doDoubleLevelQuery(
										$j,
										$storename,
										$subrecords[0]->$field,
										$table2,
										$field2);
							}
							*/

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
							print "<pre>3 TEXQL STATEMENT: $texql</pre><br />\n";
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
								print "<pre>4 TEXQL STATEMENT: $texql</pre><br />\n";
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

}

class PhmOptimisedQuery extends ConfiguredQuery
{
	function
	PhmOptimisedQuery()
	{

		// Constructor - setup defaults
		$this->SystemYes = GetLutsEntry("system yes");

		$this->SupportedLanguages = GetRegistryEntry(	
							"system",
							"setting",
							"language", 
							"supported");
		if (isset($GLOBALS['LANGUAGE_DELIMITER']))
		{
			$this->LanguageDelimiter = 
					$GLOBALS['LANGUAGE_DELIMITER'];
		}

		if (isset($GLOBALS['LANGUAGE_SHOW_FIRST_FILLED']))
		{
			$this->LanguageShowFirstFilled = 
				$GLOBALS['LANGUAGE_SHOW_FIRST_FILLED'];
		}
		else
		{
			// else get default out of registry
			$showfirst = GetRegistryEntry(
						"system",
						"setting",
						"language",
						"show first filled");
			$showfirst = strtolower($showfirst);
			$this->LanguageShowFirstFilled = ($showfirst == "true");
		}
		
		// Check to see if "lang" is set in the url
		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['lang']) && is_numeric($ALL_REQUEST['lang']))
		{
			$this->SelectedLanguage = $ALL_REQUEST['lang'];
		}
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
				print "<pre>1 OPT TEXQL STATEMENT: $this->Texql</pre><br />\n";
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
			//$texql .= $this->_accessPrivileges();

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
				print "<pre>2 OPT TEXQL STATEMENT: $texql</pre><br />\n";

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
						while ($record->$tabref != '')
						{
							$storename = $tabref. '->' . $table . '->' . $field;

							/*
							$texql = "SELECT $field FROM $table WHERE irn=" 
								. $record->$tabref . $this->_accessPrivileges();
							if ($GLOBALS['DEBUG'] == 1)
								print "<pre>NESTED TEXQL STATEMENT: $texql</pre><br />\n";

							$result = _doQuery($texql,
									   $this->SelectedLanguage, 
									   $this->SupportedLanguages, 
									   $this->LanguageDelimiter,
									   $this->LanguageShowFirstFilled);
								
							$subrecords = $result->Data;
							$this->Data[$j]->$storename = $subrecords[0]->$field;
							*/
							$this->Data[$j]->$storename = $record->$tabref;

							/*
							if (!empty($field2))
							{
								$this->_doDoubleLevelQuery(
										$j,
										$storename,
										$subrecords[0]->$field,
										$table2,
										$field2);
							}
							*/

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
							print "<pre>3 OPT TEXQL STATEMENT: $texql</pre><br />\n";
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
								print "<pre>4 OPT TEXQL STATEMENT: $texql</pre><br />\n";
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

}


?>
