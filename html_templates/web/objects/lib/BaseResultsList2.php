<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*
*  This is a cleaner rewrite of BaseResultsLists for future use.
*
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'BaseQueryGenerator.php');


/*
* This class contains only query logic for results lists.
* It must not contains any presentation logic.  Add these to sub classes.
*/

class
BaseResultsList2 extends BaseWebObject
{
	var $Fields = array(); 	// Override
	
	var $QueryGenerator;
	var $Database;
	var $DisplayPage;
	var $LimitPerPage;
	var $Where;
	var $Restriction;
	var $Order = "";
	var $OrderLimit = 100;

	// Set Via GET/POST 
	var $QueryName;
	var $StartAt;

	// Protected
	var $records;
	var $matches;

	// Private
	var $_queryDone = 0;

	// Constructor - set defaults
	function
	BaseResultsList2()
	{
		$this->BaseWebObject();

		// Set properties from the base class
		global $ALL_REQUEST;
		$this->QueryGenerator	= "BaseQueryGenerator";
		$this->QueryName	= htmlentities($ALL_REQUEST['QueryName']);
		$this->Where		= htmlentities($ALL_REQUEST['Where']);
		$this->Restriction	= $ALL_REQUEST['Restriction'];
		$this->Database		= "ecatalogue";	// default

		if (isset($ALL_REQUEST['LimitPerPage']) &&
				preg_match('/\d+/', 
					$ALL_REQUEST['LimitPerPage'], $matches))
		{
			$this->LimitPerPage = $matches[0];
		}
		else
		{
			$this->LimitPerPage = 20;  //default to 20
		}

		if (isset($ALL_REQUEST['StartAt']) 
				&& $ALL_REQUEST['StartAt'] != '')
		{
			$this->StartAt = $ALL_REQUEST['StartAt'];
		}
		else
		{
			$this->StartAt = 1;
		}
	}

	function
	navUrl($move)
	{
		// Pass all post/get vars through except 'StartAt'
		// increment 'StartAt' by the page limit ($this->LimitPerPage)

		// Note: This should be phased out in the future and changed to:
		//	array_merge($_POST', $_GET);
		$perams = array_merge($GLOBALS['HTTP_POST_VARS'], 
			$GLOBALS['HTTP_GET_VARS']);
		while(list($key, $val) = each($perams))
		{ 
			// Don't pass through empty vars 
			// try to keep url length down
			if ($val == "")
				continue;
			if ($key != "StartAt")
			{
				$key = urlencode(stripslashes($key)); 
				$val = urlencode(stripslashes($val)); 
				$getString .= "$key=$val&amp;"; 
			}
		} 

		$newstart = $this->StartAt + $move;
		if ($newstart < 0)
			$newstart = 0;

		$thisPage = isset($GLOBALS['PHP_SELF'])
			? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];

		$r = "$thisPage?$getString" . 
				'StartAt=' . $newstart;
		return($r);
	}

	function
	NextUrl()
	{
		return($this->navUrl($this->LimitPerPage));
	}

	function
	BackUrl()
	{
		return($this->navUrl(-1 * $this->LimitPerPage));
	}

	function
	GetSelectArray()
	{
		// Add mandatory fields to $this->Fields for select
		$select = array();
		if (is_array($this->DisplayPage) && 
				$this->DisplayPage['ConditionField'] != '')
		{
			$select = array('irn', 
					  'MulMultiMediaRef_tab', 
					  $this->DisplayPage['ConditionField']);
		}
		else
		{
			if ($this->Database == "emultimedia")
				$select = array('irn');
			else
				$select = array('irn', 'MulMultiMediaRef_tab');
		}

		foreach ($this->Fields as $fld)
		{
			if (is_string($fld))
			{
				array_push($select, $fld);
			}
			elseif (strtolower(get_class($fld)) == 'formatfield')
			{
				// format in the form "{ColName1} {ColName2}"
				preg_match_all('/{([^}]*)}/', 
						$fld->Format, 
						$matches);
				foreach ($matches[1] as $colName)
				{
					array_push($select, $colName);
				}
			}
		}

		return $select;
	}

	function
	GetWhereArray()
	{
		$where = '';
		if ($this->Where == '')
		{
			$qryGenerator = new $this->QueryGenerator;
			// these properties are used by the RandomQuery
			$qryGenerator->Database = $this->Database;
			$qryGenerator->Limit = $this->LimitPerPage;
			// Use reflection to call query method
			$qryAttrib = $qryGenerator->{$this->QueryName}();
			$where = $qryAttrib->Where;
		}
		else
		{
			$where = $this->Where;
		}

		if ($this->Restriction != '')
			$where = "($where) AND (" . $this->Restriction . ")";

		return $where;
	}

	function
	doQuery ()
	{
		/*
		*  Dynamically create the specified QueryGenerator and
		*    call a method corresponding to the QueryName.
		*    Set the results in the $this->records array for
		*    use elsewhere.
		*/

		// only run once
		if ($this->_queryDone)
			return;
		$this->_queryDone = 1;

		$select = $this->GetSelectArray();	
		$where = $this->GetWhereArray();

		$qry = new ConfiguredQuery;
		$qry->SelectedLanguage = $this->LanguageData;
		$qry->Intranet = $this->Intranet;
		$qry->Select = $select;
		$qry->From = $this->Database;
		$qry->Where = $where;
		// One extra so we know if there are more records
		$qry->Limit = $this->LimitPerPage + 1;	
		$qry->Offset = $this->StartAt;

		$this->records = $qry->Fetch();
		$this->matches = $qry->Matches;

		if ($qry->Status == 'failed')
		{
			print $qry->Where;
			WebDie ('Query Error - Texxmlserver: ' . 
				htmlentities($qry->Error) , 
				'where: ' . htmlentities($where));
		}
		/*
		** If $this->Order set, and # matches < OrderLimit, perform the same
		** query again but this time order it.
		*/
		if ($this->Order != "" && $this->matches <= $this->OrderLimit)
		{
			$orderfields = explode("|", $this->Order);
			foreach ($orderfields as $orderfield)
			{
				if (preg_match("/^[\+-]((.*)_tab)$/", $orderfield, $matches))
					$orderstring .= $matches[1] . "[" . $matches[2] . "], ";
				elseif (preg_match("/^\+(.*)$/", $orderfield, $matches))
					$orderstring .= $matches[1] . " asc, ";
				elseif (preg_match("/^-(.*)$/", $orderfield, $matches))
					$orderstring .= $matches[1] . " desc, ";
				else
					$orderstring .= $orderfield . " asc, ";

				$fieldname = empty($matches[1]) ? $orderfield : $matches[1];

				if (array_search($fieldname, $select) === FALSE)
					array_push($select, $fieldname);
			}
			$orderstring = preg_replace("/,\s$/", "", $orderstring);
			$qry->Select = $select;
			$qry->Order = $orderstring;
			$this->records = $qry->Fetch();

			if ($qry->Status == 'failed')
			{
				print $qry->Where;
				WebDie ('Query Error - Texxmlserver: ' . 
					htmlentities($qry->Error) , 
					'where: ' . htmlentities($where));
			}
		}
	}

	function
	HitCount()
	{
		$this->doQuery();
		if ($this->HasMoreMatchesForward())
			return($this->matches);
		else
			return($this->UpperRecordNumber());
	}

	function
	RecordCount()
	{
		$this->doQuery();
		$i = count($this->records);
		if ($i > $this->LimitPerPage)
			return($this->LimitPerPage);
		else
			return($i);
	}

	function
	HasMatches()
	{
		$this->doQuery();
		return(count($this->records) > 0);
	}

	function
	LowerRecordNumber()
	{
		return($this->StartAt);
	}

	function
	UpperRecordNumber()
	{
		$this->doQuery();
		$i = count($this->records);
		if ($i > $this->LimitPerPage)
		{
			return($this->StartAt + $this->LimitPerPage - 1);
		}
		else
		{
			return($this->StartAt + $i - 1);
		}
	}

	function
	HasMoreMatchesBackward()
	{
		return($this->LowerRecordNumber() > 1);
	}

	function
	HasMoreMatchesForward()
	{
		$i = count($this->records);
		return($i > $this->LimitPerPage);
	}

} // end BaseResultsList class

?>
