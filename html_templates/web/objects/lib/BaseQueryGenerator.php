<?php

/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'querybuilder.php');
require_once ($LIB_DIR . 'common.php');

/*
** Generate "where" clauses and other search attribuges for "standard" query 
** forms.
*/

/*
** Support class for returning query attributes. 
*/

class
QueryAttributes
{
	var $Where 	= "";
	var $RankOn 	= "";
	var $RankTerm	= "";
}

/* 
** BaseQueryGenerator
**	Each Event Handler is expected to return a TEXQL Where Statement
*/
class
BaseQueryGenerator
{
	var $Null	= 'null';
	var $Database	= 'ecatalogue';
	var $Limit	= 20;


	function
	KeyWord()
	{
		/*
		* The Keyword search should produce a where statment that
		* is appropriate for ALL modules withing EMu.
		*/
		global $ALL_REQUEST;

		$cols = array("AdmWebMetadata", "SummaryData");

		$kw = $ALL_REQUEST['KeyWords'];
		$queryArray = array();
		foreach($cols as $col)
		{
			$qryItem = new QueryItem;
			$qryItem->ColName = $col;
			$qryItem->ColType = 'text';
			$qryItem->QueryTerm = $this->_CleanQueryTerms($kw);
			array_push($queryArray, $qryItem);
		}
		$queryBuilder = new StandardQueryBuilder;
		$queryBuilder->Logic = 'OR';
		$queryBuilder->QueryItems = $queryArray;
		$queryAttrib = new QueryAttributes;
		$queryAttrib->Where = $queryBuilder->Generate();

		if ($ALL_REQUEST['Rank'] == 'true')
		{
			$queryAttrib->RankOn = $ALL_REQUEST['RankOn'];
			// find rank term (get first word)
			$queryAttrib->RankTerm = $this->_firstword($kw);
		}
		return($queryAttrib);
	}
		

	function
	BasicQuery()
	{
		/*
		* A Basic Query HTML Form must contains the following fields:
		*
		*   QueryOption 
		* 	The option selected by the user
		*   {OptionDefinition}
		*	A HTML Field for each option containing the columns 
		*	to query apon.
		*   QueryTerms
		*	Terms entered by the user
		*
		* FIXME: Only supports text fields at the moment
		* luca: - added quick and dirty hack to allow non-text fields
		*	  
		*/

		global $ALL_REQUEST;
		$queryArray = array();

                $collist = $ALL_REQUEST[$ALL_REQUEST['QueryOption']];

                //pull out the string for the calling database
                if (preg_match_all("/$this->Database:([^;]*)/", $collist, $matches))
                        $collist =  $matches[1][0];

                $onCols = split("\|", $collist);

		foreach($onCols as $col)
		{
			$qryItem = new QueryItem;
			if (preg_match("/^(.+)=(.+)$/", $col, $matches))
			{
				$col = $matches[1];
				$qryItem->ColType = $matches[2];
			}
			else
				$qryItem->ColType = 'text';
			$qryItem->ColName = $col;
			$qryItem->QueryTerm = $this->_CleanQueryTerms($ALL_REQUEST['QueryTerms']);
			array_push($queryArray, $qryItem);
		}
		$queryBuilder = new StandardQueryBuilder;
		$queryBuilder->Logic = 'OR';
		$queryBuilder->QueryItems = $queryArray;
		$queryAttrib = new QueryAttributes();
		$queryAttrib->Where = $queryBuilder->Generate();

		if ($ALL_REQUEST['ImagesOnly'] == 'true')
		{
			if ($queryAttrib->Where != '')
				$queryAttrib->Where = "(" . $queryAttrib->Where . ") AND MulHasMultiMedia = 'y'";
		}
		if ($ALL_REQUEST['Rank'] == 'true')
		{
			$queryAttrib->RankOn = $ALL_REQUEST['RankOn'];
			// find rank term (get first word)
			$queryAttrib->RankTerm = $this->_firstword($ALL_REQUEST['QueryTerms']);
		}
		return($queryAttrib);
	}

	function
	AdvancedQuery()
	{
		/*
		* An Advanced Query Form must contains the following HTML fields
		*    QueryOption
		*	The option selected by the user
		*    {OptionDefinition}
		*	A HTML Field for each option containing the columns 
		*	to query on.
		*    TERM_FIELDS
		* 	AllWord, Phrase, AnyWords, WithoutWords, SoundsLike
		*/

		// Construct the Where clause using the Query Builder
		global $ALL_REQUEST;
		$qrybuilder = new AdvancedQueryBuilder;
		$qrybuilder->All	= $this->_CleanQueryTerms($ALL_REQUEST['AllWords']);
		$qrybuilder->Phrase	= $this->_CleanQueryTerms($ALL_REQUEST['Phrase']);
		$qrybuilder->Any	= $this->_CleanQueryTerms($ALL_REQUEST['AnyWords']);
		$qrybuilder->Without	= $this->_CleanQueryTerms($ALL_REQUEST['WithoutWords']);
		$qrybuilder->SoundsLike	= $this->_CleanQueryTerms($ALL_REQUEST['SoundsLikeWords']);

		$onCols = split("\|", 
				$ALL_REQUEST[$ALL_REQUEST['QueryOption']]);
		if (count($onCols) < 1)
		{
			return;
		}
		$qrybuilder->OnFields = $onCols;
		$queryAttrib = new QueryAttributes();
		$queryAttrib->Where = $qrybuilder->Generate();

		if ($ALL_REQUEST['ImagesOnly'] == 'true')
		{
			if ($queryAttrib->Where != '')
				$queryAttrib->Where .= ' AND ';
			$queryAttrib->Where .= " MulHasMultiMedia = 'y'";
		}
		if ($ALL_REQUEST['Rank'] == 'true')
		{
			$queryAttrib->RankOn = $ALL_REQUEST['RankOn'];
			// find rank term (get first word)
			if (!empty($ALL_REQUEST['Phrase']))
				$queryAttrib->RankTerm = $this->_firstword($ALL_REQUEST['Phrase']);
			elseif (!empty($ALL_REQUEST['AllWords']))
				$queryAttrib->RankTerm = $this->_firstword($ALL_REQUEST['AllWords']);
			elseif (!empty($ALL_REQUEST['AnyWords']))
				$queryAttrib->RankTerm = $this->_firstword($ALL_REQUEST['AnyWords']);
			else
				$queryAttrib->RankOn = "";
		}
		return($queryAttrib);
	}

	function
	DetailedQuery ()
	{
		/*
		* An Advanced Query Form contains HTML fields in the form:
		*	col_(ColumnName)
		*	The contents of each field will be used to construct
		*	a query
		*/

                if (count($_POST) > 0)
                        $perams =& $_POST;
                else
                        $perams =& $_GET;

		$i = 1;
		$queryArray = array();
		while(list($key, $val) = each($perams))
		{ 
			$matches = array();
			$islower = $isupper = 0;
			$colname = $coltype = '';

			/*  We pull out _lower_ and _upper_ first.
			*/
			if (preg_match('/(^col_[^_]+_)lower_(.+)$/', $key, $matches))
			{
				$islower = 1;
				$key = $matches[1] . $matches[2];
			}
			elseif (preg_match('/(^col_[^_]+_)upper_(.+)$/', $key, $matches))
			{
				$isupper = 1;
				$key = $matches[1] . $matches[2];
			}

			/*  Now build up the column details.
			*/
			if (preg_match('/^col_date_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'date';
			}
			elseif (preg_match('/^col_float_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'float';
			}
			elseif (preg_match('/^col_int_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'integer';
			}
			elseif (preg_match('/^col_lat_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'latitude';
			}
			elseif (preg_match('/^col_long_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'longitude';
			}
			elseif (preg_match('/^col_str_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'string';
			}
			elseif (preg_match('/^col_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'text';
			}
			else
				continue;

			$qryItem = new QueryItem;
			$qryItem->QueryTerm = $this->_CleanQueryTerms($val);
			$qryItem->ColType = $coltype;
			$qryItem->ColName = $colname;
			$qryItem->IsLower = $islower;
			$qryItem->IsUpper = $isupper;
			array_push($queryArray, $qryItem);
		} 
		$queryBuilder = new StandardQueryBuilder;
		$queryBuilder->Logic = 'AND';
		$queryBuilder->QueryItems = $queryArray;
		$queryBuilder->Intranet = $this->Intranet;
		$where = $queryBuilder->Generate();

		global $ALL_REQUEST;
		if ($ALL_REQUEST['ImagesOnly'] == 'true')
		{
			if ($where != '')
				$where .= ' AND';
			$where .= " MulHasMultiMedia = 'y'";

		}
		$queryAttrib = new QueryAttributes();
		$queryAttrib->Where = $where;
		return($queryAttrib);
	}

	function
	_firstword($words)
	{
		if (preg_match("/^[\\s'\\\"]*(\\w+)/", $words, $matches))
			return $matches[1];
		else
			return "";
	}

	function
	_CleanQueryTerms($queryterms)
	{
		$queryterms = stripslashes($queryterms);
		$queryterms = preg_replace("/'/", "\\\\\\\\\\\\\\'", $queryterms);
		return $queryterms;
	}

	/*
	* Random query logic:
	*	Hit the database looking for matching "public on internet"
	*	records.
	*	The method will try to match $this->Limit records.  
	*	$trycount is the number of attempts to try and 
	*	fill $this->Limit quota.
	*/
	function
	RandomQuery($trycount = 5)
	{
		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['upper']) 
				&& is_numeric($ALL_REQUEST['upper']))
			$upper = $ALL_REQUEST['upper'];
		else
			$upper = 1000;
		if (isset($ALL_REQUEST['lower'])
				&& is_numeric($ALL_REQUEST['lower']))
			$lower = $ALL_REQUEST['lower'];
		else
			$lower = 1;
		if (isset($ALL_REQUEST['restriction'])) 
			$restriction = $ALL_REQUEST['restriction'];

		$limit = $this->Limit;
		$database = $this->Database;

		// PHP recommended method of seeding
		srand ((float) microtime() * 1000000);
		$irnList = array();
		while (count($irnList) < $limit && $trycount > 0)
		{
			$where = "";

                        // see if there is a restriction and add to the front of string
                        if ($restriction != '') 
                                $where = $restriction . " AND ("; 

			// try to grab 75% more assuming not all will match
			for ($i = 0; $i < (int) (1.75 * $limit); $i++)
			{
				if ($i > 0)
					$where .= ' OR ';
				$irn = rand($lower, $upper);
				$where .= "irn=$irn";
			}

                        if ($restriction != '')
                                $where .= ")"; 

			$query = new ConfiguredQuery();
			$query->Select	= array('irn');
			$query->From	= $database;
			$query->Where	= $where;
			$query->Limit	= $limit;
			$query->Intranet= $this->Intranet;
			$r = $query->Fetch();

			foreach ($r as $rec)
			{
				array_push($irnList, $rec->{"irn_1"});
			}
			$trycount--;
		}

		// build Where clause to return
		$i = 0;
		$where = "False";
		foreach ($irnList as $irn)
		{
			if ($i >= $limit)
				break;
			$where .= " or irn=$irn";
			$i++;
		}
		$queryAttrib = new QueryAttributes();
		$queryAttrib->Where = $where;
		return($queryAttrib);
	}
}

?>
