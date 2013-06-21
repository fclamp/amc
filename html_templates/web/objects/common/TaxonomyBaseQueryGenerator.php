<?php

/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'querybuilder.php');
require_once ($LIB_DIR . 'texquery.php');
require_once ($LIB_DIR . 'BaseQueryGenerator.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'common.php');


// First we Need a modified AdvancedQueryBuilder...
// (rectifies bug when doing 'any query')
// AdvancedQueryBuilder in lib/BaseQueryGenerator.php
class
TaxonomyAdvancedQueryBuilder extends AdvancedQueryBuilder
{
	var $All;
	var $Phrase;
	var $Any;
	var $Without;
	var $SoundsLike;		
	var $OnFields = array();	// Array of strings

	function Generate()
	{
		$contains = $where = '';
		if ($this->All != '')
			$contains .= $this->All . ' ';
		if ($this->Phrase != '')
			$contains .= '"' . $this->Phrase . '" ';
		if ($this->Without != '')
			$contains .= preg_replace('/(\w+)/', '!\\1', $this->Without) . ' ';
		if ($this->SoundsLike != '')
			$contains .= preg_replace('/(\w+)/', '@\\1', $this->SoundsLike) . ' ';
		$contains = trim($contains);

		$this->Any = trim($this->Any);

		if ($this->Any != '')
			$anyArray = split(' +', $this->Any);
		else
			$anyArray = array();

		$fldnum = 1;
		foreach ($this->OnFields as $fld)
		{
			if ($fldnum > 1)
				$where .= ' OR ';

			$fldnum++;
			$anywhere = '';
			$anynum = 1;
			foreach ($anyArray as $word)
			{
				if ($anynum > 1)
					$anywhere .= ' OR ';
				$anywhere .= $this->_makeContains($fld, $word);
				$anynum++;
			}

			if ($contains != '' && $anywhere != '')
				$where .= '(' . $this->_makeContains($fld, $contains) . " AND ($anywhere))"; 
			elseif ($anywhere != '')
				$where .= "($anywhere)"; 
			elseif ($contains != '')
				$where .= $this->_makeContains($fld, $contains);
			else
				$fldnum--;

		}
		if ($where == '')
			return ('');
		else
			return("($where)");
	}

}


// need a modified BaseQueryGenerator 
// This has new method implementations for
// AdvancedQuery and DetailedQuery
class
TaxonomyBaseQueryGenerator extends BaseQueryGenerator
{
	var $Database	= 'etaxonomy';
	var $Limit	= 20;

	function AdvancedQuery()
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
		$qrybuilder = new TaxonomyAdvancedQueryBuilder;
		$qrybuilder->All	= $ALL_REQUEST['AllWords'];
		$qrybuilder->Phrase	= $ALL_REQUEST['Phrase'];
		$qrybuilder->Any	= $ALL_REQUEST['AnyWords'];
		$qrybuilder->Without	= $ALL_REQUEST['WithoutWords'];
		$qrybuilder->SoundsLike	= $ALL_REQUEST['SoundsLikeWords'];
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
 				$queryAttrib->RankTerm = $ALL_REQUEST['Phrase'];
 			elseif (!empty($ALL_REQUEST['AllWords']))
 				$queryAttrib->RankTerm = $this->_firstword($ALL_REQUEST['AllWords']);
 			elseif (!empty($ALL_REQUEST['AnyWords']))
 				$queryAttrib->RankTerm = $this->_firstword($ALL_REQUEST['AnyWords']);
 			else
 				$queryAttrib->RankOn = "";
 		}
 		return($queryAttrib);
	}

	function DetailedQuery ()
	{
		/*
		* An Advanced Query Form contains HTML fields in the form:
		*	col_(ColumnName)
		*	The contents of each field will be used to construct
		*	a query
		*/

		global $ALL_REQUEST;
		#$params = array_merge($ALL_REQUEST['HTTP_GET_VARS'],$ALL_REQUEST['HTTP_POST_VARS']);
		# for some environments change above line to:
		$params = $ALL_REQUEST;

		$i = 1;
		$queryArray = array();
		while(list($key, $val) = each($params))
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
			elseif (preg_match('/^col_int_(.+)$/', $key, $matches) 
				   && trim($val) != '')
			{
				$colname = $matches[1];
				$coltype = 'integer';
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
			$qryItem->QueryTerm = $val;
			$qryItem->ColType = $coltype;
			$qryItem->ColName = $colname;
			$qryItem->IsLower = $islower;
			$qryItem->IsUpper = $isupper;
			array_push($queryArray, $qryItem);
		} 

		$queryBuilder = new StandardQueryBuilder;
		$queryBuilder->Logic = 'AND';
		$queryBuilder->QueryItems = $queryArray;
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


	/*
	* Random query logic:
	*	Hit the database looking for matching "public on internet"
	*	records.
	*	The method will try to match $this->Limit records.  
	*	$trycount is the number of attempts to try and 
	*	fill $this->Limit quota.
	*/
	function RandomQuery($trycount = 5)
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

		$limit = $this->Limit;
		$database = $this->Database;

		// PHP recommended method of seeding
		srand ((float) microtime() * 1000000);
		$irnList = array();
		while (count($irnList) < $limit && $trycount > 0)
		{
			$where = "";
			// try to grab 75% more assuming not all will match
			for ($i = 0; $i < (int) (1.75 * $limit); $i++)
			{
				if ($i > 0)
					$where .= ' OR ';
				$irn = rand($lower, $upper);
				$where .= "irn=$irn";
			}
			$query = new ConfiguredQuery();
			$query->Select	= array('irn');
			$query->From	= $database;
			$query->Where	= $where;
			$query->Limit	= $limit;
			$r = $query->Fetch();
			foreach ($r as $rec)
			{
				array_push($irnList, $rec->{"irn_1"});
			}
			$trycount--;
		}

		// build Where clause to return
		$i = 0;
		$where = "";
		foreach ($irnList as $irn)
		{
			if ($i >= $limit)
				break;
			if ($i > 0)
				$where .= ' OR ';
			$where .= "irn=$irn";
			$i++;
		}
		return $where;
	}

}

?>
