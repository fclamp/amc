<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/
require_once(dirname(realpath(__FILE__)) . "/config.php");
require_once(dirname(realpath(__FILE__)) . "/serverconnection.php");

class
Query
{	
	public function
	__construct()
	{
		global $EMU_GLOBALS;

		$visi = $EMU_GLOBALS['DEFAULT_VISIBILITY'];
		if ($visi == self::$INTERNET || $visi == self::$INTRANET || $visi == self::$ALL)
		{
			$this->Visibility = $visi;
		}
		else
			$this->Visibility = self::$INTERNET;

		if (isset($EMU_GLOBALS['SYSTEM_YES']))
			$this->SystemYes = $EMU_GLOBALS['SYSTEM_YES'];

		if (isset($EMU_GLOBALS['CACHE']) && is_numeric($EMU_GLOBALS['CACHE']))
		{
			$this->Cache = $EMU_GLOBALS['CACHE'];

			if (isset($EMU_GLOBALS['CACHETMP']))
				$this->CacheTmp = $EMU_GLOBALS['CACHETMP'];
		}

		/* 
		 * Set up variables to be stored in the cache
		 */
		$this->ToCache = array(
			&$this->Results,
			&$this->Status,
			&$this->Matches
		);

		$this->Fields = array();
		$this->Results = array();
		$this->WhereAnd = array();
		$this->WhereOr = array();
		$this->WhereTexqls = array();
	}

	/*
	 * These variable used to form the texql
	 */
	public static $INTERNET = 1;
	public static $INTRANET = 2;
	public static $ALL = 3;
	public $Visibility;
	public $SystemYes = "Yes";
	public $Table = "ecatalogue";
	public $Where = "";
	public $StartRec;
	public $EndRec;
	public $Order;

	/*
	 * Caching
	 */
        public $Cache = "";
	public $CacheTmp = "/tmp";
	private $ToCache;

	/*
	 * These variables used for results
	 */
	public $Results;
	public $Status;
	public $Matches;

	private $Fields;
	private $WhereAnd;
	private $WhereOr;
	private $WhereTexqls;
	
	public function
	Fetch()
	{
		global $EMU_GLOBALS;

		/* 
		 * Add irn_1 as column if not already selected
		*/
		if (!isset($this->Fields['irn_1']))
		{
			$this->Fields['irn_1'] = new QueryField();
			$this->Fields['irn_1']->Name = "irn_1";
		}

		$select = "";
		foreach($this->Fields as $selectfield)
		{
			if ($select != "")
				$select .= ", ";
			$select .= $selectfield->Name;
		}

		if (empty($this->Where))
			$this->BuildWhereString();
		if (empty($this->Where))
			$this->Where = "true";

		$texql = "SELECT " . $select . " FROM " . $this->Table .
			" WHERE (" . $this->Where . ")";

		if ($this->Visibility == Query::$INTERNET)
			$texql .= " AND AdmPublishWebNoPassword contains '" . $this->SystemYes . "'";
		else if ($this->Visibility == Query::$INTRANET)
			$texql .= " AND AdmPublishWebPassword contains '" . $this->SystemYes . "'";

		if (isset($this->Order))
		{
			$texql = 'order(' . $texql . ') on ' . $this->Order;
		}

		if (is_numeric($this->StartRec) && is_numeric($this->EndRec))
		{
			$texql = "(" . $texql . ") {" . $this->StartRec . " to " . $this->EndRec . "}";
		}

		if ($EMU_GLOBALS['DEBUG'] == 1)
			print "TEXQL: $texql\n";

		if ($this->Cache != "")
                {
			$this->CleanupCache();

			/*
			 *  Get a unique queryid from the texql. 
			 */
			$texqlhash = md5($texql . $EMU_GLOBALS['TEXXMLSERVER_PORT']);
			$cachename = "$this->CacheTmp/emuwebcache_$texqlhash";
                        if (file_exists($cachename))
                        {
				/* 
				 * We return the cached version
				 */
				// update time
				touch($cachename);
				$cached = unserialize(file_get_contents($cachename));
				for ($i=0; $i<count($this->ToCache); $i++)
				{
					$this->ToCache[$i] = $cached[$i];
				}
                                return $this->Results;
                        }
		}

		$xml = $this->Command($texql);

		$this->GetQueryStatus($xml);
		$this->ResultsFromXml($xml, $this->Results);
		if (!is_array($this->Results) && !empty($this->Results))
		{
			$tmp = $this->Results;
			$this->Results = array($tmp);
		}

		$this->ProcessNestedTables();
		$this->DoSubQueries();
		if ($this->Cache > 0)
                {
                        $texqlhash = md5($texql . $EMU_GLOBALS['TEXXMLSERVER_PORT']);
                        $openedfile = fopen("$this->CacheTmp/emuwebcache_$texqlhash", "wb");
			if (fwrite($openedfile, serialize($this->ToCache)) === FALSE)
			{
				/*
				 * Turn Caching time to 0 because the write failed
				 *  and there is a chance this will remove any other files if the 
				 *  disk is full
				 */
				$this->Cache = 0;
				$this->CleanupCache();
			}
			fclose($openedfile);
                }
		return $this->Results;
	}

	public function
	Term($column, $value, $coltype="text")
	{		
		if (is_array($value) || is_object($value))
		{
			throw new Exception("NASTY: Shouldn't get here");
		}
		if (empty($value))
		{
			return;
		}

		$term = "";
		if (preg_match("/^irn(_1)?$/", $column))
		{
			$column = "irn_1";
			$coltype = "int";
		}

		switch ($coltype)
		{
			case "int" :
			case "float" :
				$term = "=$value";
				break;
			case "string" :
				$term = "= '$value'";
				break;
			case "date" :
				$term = "LIKE DATE '$value'";
				break;
			case "latitude" :
				$term = "LIKE LATITUDE '$value'";
				break;
			case "longitude" :
				$term = "LIKE LONGITUDE '$value'";
				break;
			case "time" :
				$term = "= TIME '$value'";
				break;
			case "text" :
			default :
				$term = "contains '$value'";
				break;
		}

		if (strpos($column, "_tab"))
		{
			$single = preg_replace("/_tab/", "", $column);
			$term = "EXISTS($column WHERE $single $term)";
		}
		else
			$term = $column . " " . $term;

		if (!isset($this->WhereAnd["$column"]) && !isset($this->WhereOr["$column"]))
			$this->WhereAnd["$column"] = $term;
		else
		{
			if (!isset($this->WhereOr["$column"]))
				$this->WhereOr["$column"] = array();
				
			array_push($this->WhereOr["$column"], $term);

			if (isset($this->WhereAnd["$column"]))
			{
				$temp = $this->WhereAnd["$column"];
				unset($this->WhereAnd["$column"]);
				array_push($this->WhereOr["$column"], $temp);
			}
		}
	}

	public function
	TexqlTerm($texql)
	{
		/*
		 * Used to supply term for the Where clause directly in texql, e.g.:
		 * TermTerm("SummaryData contains 'coin' OR AdmWebMetaData contains 'coin');
		 */
		array_push($this->WhereTexqls, $texql);
	}

	public function
	Select($fieldstring)
	{
		if (preg_match("/^(.*?)->(.*?)->/", $fieldstring, $matches))
		{
			$field = NULL;
			if (isset($this->Fields[$matches[1]]))
				$field = $this->Fields[$matches[1]];

			if ($field == NULL)
			{
				$field = new QueryField;
				$field->Name = $matches[1];
				$this->Fields[$matches[1]] = $field;
			}

			if (empty($field->Queries))
			{
				$field->Queries[0] = new Query;
				$field->Queries[0]->Visibility = $this->Visibility;
				$field->Queries[0]->Table = $matches[2];
			}
			$field->Queries[0]->Select(substr($fieldstring, strlen($matches[0])));
		}
		elseif(strpos($fieldstring, "<-"))
		{
		}
		else
		{
			$field = NULL;
			if (isset($this->Fields[$fieldstring]))
				$field = $this->Fields[$fieldstring];
			if ($field == NULL)
			{
				$field = new QueryField;
				$field->Name = $fieldstring;
				$this->Fields[$fieldstring] = $field;
			}
		}
	}

	public function
	ClearResults()
	{
		unset($this->Results);
		$this->Results = array();
	}

	public function
	ClearTerms()
	{
		unset($this->WhereAnd);
		unset($this->WhereOr);
		unset($this->Where);
		$this->WhereAnd = array();
		$this->WhereOr = array();
	}

	public function
	ClearSelect()
	{
		unset($this->Fields);
		$this->Fields = array();
	}

	public function
	Command($texql)
	{
		$connection = new ServerConnection;
		$fd = $connection->Open();
		$get = "GET /?texql=" . urlencode($texql) . " HTTP/1.0\r\n\r\n";
		fputs($fd, $get);
		fflush($fd);
		
		$header = "";
		do
		{
			$line = fgets($fd, 4096);
			$header .= $line;
			if ($line == "\r\n")
				break;
		}
		while (!feof($fd));

		if (strpos($header, "HTTP/1.0 200 OK") === FALSE)
		{
			/*
			** We've got something other than an OK response from texxmlserver
			*/
			$errmsg = "Unexpected HTTP response from Texxmlserver: " . nl2br($header);
		 
			/* Give up */
			throw new Exception($errmsg);
		}

		$xml = "";
		do
		{
			$xml .= fread($fd, 4096);
		}
		while (!feof($fd));

		$xml = simplexml_load_string($xml);
		
		fclose($fd);

		return $xml;
	}

	private function
	GetQueryStatus($simplexmlobj)
	{
		$attribs = $simplexmlobj->Attributes();
		if (isset($attribs['status']))
			$this->Status = (string) $attribs['status'];
		if (isset($attribs['matches']))
			$this->Matches = (string) $attribs['matches'];
		elseif ($this->Status == "success")
			$this->Matches = 0;

		if (isset($attribs['error']))
		{
			$errmsg = (string) $attribs['error'];
			throw new Exception("Texxmlserver error: $errmsg");
		}
	}

	private function
	ResultsFromXml($simplexmlobj, &$results)
	{
		/*
		** Deconstruct the simplexml object and map it to our preferred format
		*/
		if (is_object($simplexmlobj))
		{
			$vars = get_object_vars($simplexmlobj);
			$keys = array_keys($vars);
			$vals = array_values($vars);

			/*
			** Have to code for special case of _tab fields and flatten their xml structure
			**	- also have to make a further special case for irn_1, as this is the
			**	  only column that can exist in the query on its own as all others
			**	  are accompanied by irn_1 automatically
			*/
			if (count($vars) == 1 && $keys[0] != "irn_1" && $keys[0] != "@attributes")
			{
				$results = array();
				$passedxml = array_shift($vars);
				if (!is_array($passedxml))
				{
					$passedxml = array($passedxml);
				}
				$this->ResultsFromXml($passedxml, $results);
				return;
			}

			if (empty($vars) || (count($vars) == 1 && ($keys[0] == "@attributes")) )
				return;

			$results = new Record;
			for ($i=0; $i<count($vars); $i++)
			{
				if ($keys[$i] == "@attributes")
					continue;
				if ($keys[$i] == "record")
				{
					$this->ResultsFromXml($vals[$i], $results);
				}
				else
				{
					$results->{$keys[$i]} = NULL;
					$this->ResultsFromXml($vals[$i], $results->{$keys[$i]});
				}
			}
		}
		else if (is_array($simplexmlobj))
		{
			$results = array();
			$keys = array_keys($simplexmlobj);
			$vals = array_values($simplexmlobj);
			for ($i=0; $i<count($keys); $i++)
			{
				$results[$i] = NULL;
				$this->ResultsFromXml($vals[$i], $results[$i]);
			}
		}
		else
		{
			$results = (string) $simplexmlobj;
		}
	}

	private function
	DoSubQueries()
	{
		foreach($this->Fields as $field)
		{
			if (empty($field->Queries))
				continue;

			$res = 0;
			foreach($this->Results as $result)
			{
				$res++;
				/* If irn is not set this is a phantom result */
				if (!isset($result->irn) && !isset($result->irn_1))
					continue;

				$fieldname = $field->Name;
				
				for ($i=0; $i<count($field->Queries); $i++)
				{
					$c = count($field->Queries);
					$field->Queries[$i]->ClearTerms();
					$field->Queries[$i]->ClearResults();
					
					if (is_array($result->{$fieldname}))
					{
						if (isset($result->{$fieldname}[$i]) &&
							is_array($result->{$fieldname}[$i]))
						{
							foreach($result->{$fieldname}[$i] as $value)
							{
								$irn = "";
								if (is_string($value))
									$irn = $value;
								elseif (isset($value->irn_1))
									$irn = $value->irn_1;
							
								//$field->Queries[$i]->Term("irn_1", $value);
								$field->Queries[$i]->Term("irn_1", $irn);
							}
						}
						elseif (!is_array($result->{$fieldname}[0]))
						{
							foreach($result->{$fieldname} as $value)
							{
								$field->Queries[$i]->Term("irn_1", $value);
							}
						}
						 
					}
					else if (!empty($result->{$fieldname}) && is_numeric($result->{$fieldname}))
						$field->Queries[$i]->Term("irn_1", $result->{$fieldname});
					else
						continue;

					$results = $field->Queries[$i]->Fetch();
					if (empty($results))
						continue;

					/*
					if (is_array($result->{$fieldname}))
					{
						if (is_array($result->{$fieldname}[$i]))
						{
							$result->{$fieldname}[$i] = array();
							$result->{$fieldname}[$i] = $results;
						}
						else
						{
							$result->{$fieldname} = array();
							$result->{$fieldname} = $results;
						}
					}
					else if (get_class($result->{$fieldname}) == "Record")
					{
						$result->{$fieldname} = new Record;
						$result->{$fieldname} = $results[0];
					}
					else if (is_array($results) && !is_array($result->{$fieldname}))
					{
						if (count($results) == 1)
							$result->{$fieldname} = $results[0];
						else
							$result->{$fieldname} = $results;
					}
					else
					{
						$result->{$fieldname} = $results;
					}
					*/

					/*
					 * Now remap any results to the correct place in the array
					 *  -	needed because the nesttab may be (1, 2, 3), but the query
					 *  	may return in order (3, 1, 2,)
					 */
					if (is_array($result->{$fieldname}))
					{
						for ($j=0; $j<count($result->{$fieldname}); $j++)
						{
							if (is_array($result->{$fieldname}[$j]))
							{
								/*
								** Nested Table
								*/
								for ($k=0; $k<count($result->{$fieldname}[$j]); $k++)
								{
									foreach ($results as $r)
									{
										if ($r->irn_1 != $result->{$fieldname}[$j][$k])
											continue;
										$result->{$fieldname}[$j][$k] = $r;
									}
								}
							}
							else
							{
								foreach ($results as $r)
								{
									/* If irn is not set this is a ghost match */
									if (!isset($r->irn_1))
										continue;
									if ($r->irn_1 != $result->{$fieldname}[$j])
										continue;
									$result->{$fieldname}[$j] = $r;
								}
							}
						}
					}
					else if (count($results) == 1)
						$result->{$fieldname} = $results[0];
					else
						/*  NASTY
						**  Would only happen if TexQL key queries are busted
						*/
						throw new Exception("Texql is busted");
				}
			}
		}
	}

	private function
	ProcessNestedTables()
	{
		foreach($this->Fields as $field)
		{
			if (empty($field->Queries))
				continue;
			
			$fieldname = $field->Name;
			foreach($this->Results as $result)
			{
				/* if irn is not set this is a phantom result */
				if (!isset($result->irn) && !isset($result->irn_1))
					continue;

				if (is_array($result->{$fieldname}) && is_array($result->{$fieldname}[0]))
				{
					/* This is a nested table, so we need to duplicate the query */
					for ($i=1; $i < (count($result->{$fieldname})); $i++)
					{
						$copy = $field->Queries[0];
						array_push($field->Queries, $copy);
					}
				}
			}
		}
	}

	private function
	BuildWhereString()
	{
		$this->Where = "";

		/*
		** Do all AND columns first, then do the OR's
		*/
		foreach($this->WhereAnd as $column => $term)
		{
			if ($this->Where != "")
				$this->Where .= " AND ";

			$this->Where .= $term;
		}

		/*
		 * AND together all the texql terms
		 */
		foreach($this->WhereTexqls as $texterm)
		{
			if (!empty($this->Where))
				$this->Where .= " AND ";

			$this->Where .= "($texterm)";
		}

		/*
		** Now do the OR's
		*/
		foreach($this->WhereOr as $column => $term)
		{
			$or = "";
			foreach($this->WhereOr["$column"] as $single)
			{
				if ($or != "")
					$or .= " OR ";

				$or .= $single;
			}

			if (!empty($this->Where))
				$or = " AND ($or)";
			else
				$or = "($or)";

			$this->Where .= $or;
		}	
	}
	
	private function
	CleanupCache()
	{
		/*
		 * Remove any expired cache.
		 *
		 * This checks all files to ensure we don't get a build up.
		 */
		$cached_files = (glob("$this->CacheTmp/emuwebcache*"));
		foreach($cached_files as $file)
		{
			$cacheseconds = $this->Cache * 60 * 60;
			$expiretime = filemtime($file) + $cacheseconds;
			if (time() >= $expiretime)
			{
				/*
				 *  Remove the file
				 */
				unlink($file);
			}
		}

	}
}


class
QueryField
{
	public $Name;
	public $Results;
	public $Queries = array();
}

class
Record
{
	/* No declared members as they will all be created dynamically */	
}
?>
