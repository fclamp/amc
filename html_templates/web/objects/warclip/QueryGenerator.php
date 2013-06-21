<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
	// required the BaseQueryGenerator code (so we can inhert it's existing functionality)
	require_once ($LIB_DIR . 'BaseQueryGenerator.php');
	require_once ($LIB_DIR . 'querybuilder.php');
	require_once ($LIB_DIR . 'configuredquery.php');
	require_once ($WEB_ROOT . '/objects/lib/webinit.php');
	require_once ($LIB_DIR . 'common.php');

class
WarclipQueryGenerator extends BaseQueryGenerator
{
	function WarclipCustomQueryForm()
	{
		// Chris Note: we need to turn the text part of a TEXQL Where
                // see other the BaseQueryGenerator as an example of how
                // to do using the existing *QueryBuilder classes to help with
                // constructing the where

                // ALL_REQUEST is the global variable where all are Post'ed Form
                // variables are kept
                
		global $ALL_REQUEST;

                $Terms = $ALL_REQUEST['SearchWord'];
                $QueryItems = $ALL_REQUEST[$ALL_REQUEST['QueryOption']];
                $Words    = $ALL_REQUEST['QueryWord'];


// Build the custom WHERE clause for the warclip web site
	
		$Terms = str_replace("\'", "\\\'", $Terms);
		$where = $contains =  "";
		if ($Words == 'all' && $Terms != '')
		{ 
			$j = 1;
			
			$anyArray = split (' ', $Terms);
			
			foreach($anyArray as $SingleTerm)
			{
				if ($j ==1)
				{
					$contains = $QueryItems . " " . "contains" . " '" . $Terms . "' ";
                		}
				else
				{
					$contains .= " AND " . "$QueryItems" . " contains " . " '" . $SingleTerm . "' ";
				}
			}
		}
		elseif ($Words == 'exact' && $Terms != '')
			$contains = $QueryItems . " " . "contains" . " '" . '"' . $Terms . '"' . "' ";
		elseif ($Words == 'any' && $Terms != '')
	        {
                        $j = 1;

                        $anyArray = split (' ', $Terms);
                        foreach($anyArray as $SingleTerm)
                        {
        	                if ($j == 1)
                                {
                      		       $contains = "$QueryItems" . " contains " . " '" . $SingleTerm . "' ";
                                }
                                else
                                {
                       	               $contains .= " OR " . "$QueryItems" . " contains " . " '" . $SingleTerm . "' ";
                                }
                                       $j++;
                        }
                }
                else
                {
                	$contains = "";
               	        $anyArray = array();
                }				
		$where = $contains;
		return($where);

	}



/* Create the relevance ranking part of the query for the simple search. */



	function WarclipRelevanceRanking()
	{
		global $ALL_REQUEST;

		$Terms = $ALL_REQUEST['SearchWord'];
		$QueryItems = $ALL_REQUEST[$ALL_REQUEST['QueryOption']];
		$Words    = $ALL_REQUEST['QueryWord'];
			
		$Terms = str_replace("\'", "\\\'", $Terms);

		$counter = 1;
		$rank = "";
						
		if ($Words == 'all' && $Terms != '')
                {
                        $IndTerms = split (' ', $Terms);
                        foreach($IndTerms as $RankTerm)
                        {
                                if ($counter == 1)
				{ $rank = $rank . ","; }
				else
                                { $rank = $rank . " + ";}
				
                                $rank = $rank . "(count(words($QueryItems) WHERE $QueryItems IN ['$RankTerm']))";
                                $counter ++;
                        }
                        $rank = $rank . " AS rank ";
                }	
		elseif ($Words == 'exact' && $Terms != '')
                {
			$rank = ",count(words($QueryItems) WHERE $QueryItems IN ['" . '"' . $Terms 
				. '"' . "']) AS rank ";
                }	
		elseif ($Words == 'any' && $Terms != '')
                {
			$rank = ",count(words($QueryItems) WHERE $QueryItems IN [";
                        $IndTerms = split (' ', $Terms);
                        foreach($IndTerms as $RankTerm)
                        {
                                if ($counter != 1)
                                { $rank = $rank . " | ";}
                                $rank = $rank . "'$RankTerm'";
                                $counter ++;
                        }
                         $rank = $rank . "]) AS rank ";
		}
		else
		{
			$rank = ", 0 as rank";
		}
		return($rank);

	}



/* create the where clause for the advanced seaarch */


	function WarclipAdvancedQuery()
	{	
		global $ALL_REQUEST;
		$Terms1 = $ALL_REQUEST['SearchWord1'];
		$Terms2 = $ALL_REQUEST['SearchWord2'];
		$Terms3 = $ALL_REQUEST['SearchWord3'];
		$QueryItems1 = $ALL_REQUEST[$ALL_REQUEST['QueryOption1']];
		$QueryItems2 = $ALL_REQUEST[$ALL_REQUEST['QueryOption2']];
		$QueryItems3 = $ALL_REQUEST[$ALL_REQUEST['QueryOption3']];
		$Filter1 = $ALL_REQUEST['filter1'];
		$Filter2 = $ALL_REQUEST['filter2'];
		$BYear = $ALL_REQUEST['BeginYear'];	
		$EYear = $ALL_REQUEST['EndYear'];	
		$BMonth = $ALL_REQUEST[$ALL_REQUEST['BeginMonth']];
		$EMonth = $ALL_REQUEST[$ALL_REQUEST['EndMonth']];
		$BDay = $ALL_REQUEST['BeginDay'];
		$EDay = $ALL_REQUEST['EndDay'];

		$Terms1 = str_replace("\'", "\\\'", $Terms1);
		$Terms2 = str_replace("\'", "\\\'", $Terms2);
		$Terms3 = str_replace("\'", "\\\'", $Terms3);

		
		$where = "";
		if ($Terms1 != "")
		{
			$where = $QueryItems1 . " contains " . "'" . $Terms1 . "'";
		}
		if ($Terms2 != "")
		{
			if ($where != "")
			{
				if ($Filter1 == "NOT")
					$where .= " AND (NOT (" . $QueryItems2 . " contains " . "'" . $Terms2 . "'" . "))";
				else
					$where .= " " .  $Filter1  . " " . $QueryItems2 . " contains " . "'" . $Terms2 . "'";
			}
			else
			{
				$where = $QueryItems2 . " contains " . "'" . $Terms2 . "'";
			}
		}
		if ($Terms3 != "")
		{
			if ($where != "")
			{
				if ($Filter2 == "NOT")
			        	$where .= " AND (NOT " . $QueryItems2 . " contains " . "'" . $Terms3 . "'" . ")";
				else
					$where .= " " .  $Filter2  . " " . $QueryItems3 . " contains " . "'" . $Terms3 . "'";
			}
			else
			{	
				$where = $QueryItems3 . " contains " . "'" . $Terms3 . "'";
			}
		}

	
		$BDate = $BYear;
		if ($BDate != "0")
		{
			if ($BMonth == "00")
			{	$BMonth = "01";}
			$BDate .=  $BMonth;

			if ($BDay == "0")
			{	$BDay = "01";}
			elseif ($BDay < 10)
			{	$BDay = "0" . $BDay;}
			elseif ($BDay > 28)
			{
				if ($BMonth == "04" || $BMonth == "06" || $BMonth == "09" || $BMonth == "11")
				{	$BDay = "30";}
				elseif ($BMonth == "02")
				{	$BDay = "28";}
			}
			$BDate .= $BDay;
		}
		$EDate = $EYear;
		if ($EDate != "0")
		{
			if ($EMonth == "00")
			{	$EMonth = "12";}
			
			$EDate .= $EMonth;
			
			if ($EDay == "0")
			{
				if ($EMonth == "04" || $EMonth == "06" || $EMonth == "09" || $EMonth == "11") 
				{	$EDay = "30";}
				elseif ($EMonth == "02")
				{	$EDay = "28";}
				else
				{	$EDay = "31";}
			}
			elseif ($EDay < 10)
			{
				$EDay = "0" . $EDay;
			}
			elseif ($EDay > 28)
			{
				if ($EMonth == "04" || $EMonth == "06" || $EMonth == "09" || $EMonth == "11")
				{       $EDay = "30";}
				elseif ($EMonth == "02")
				{       $EDay = "28";}
			}
			$EDate .= $EDay;
		}
		
		if ($BDate != "0")
		{
			if ($where != "")
			{	$where .= " AND (DatManufacture >= DATE '" . $BDate . "')"; }
			else 
			{	$where = " (DatManufacture >= DATE '" . $BDate . "')"; }
		}
		if ($EDate != "0")
		{
		        if ($where != "")
			{       $where .= " AND (DatManufacture <= DATE '" . $EDate . "')"; }
			else
			{       $where = " (DatManufacture <= DATE '" . $EDate . "')"; }
		}
		return($where);	
	
	}


/* Create the relevance ranking part of the query for the advanced search. */


	function AdvancedRelevanceRanking()
	{
		global $ALL_REQUEST;
		$Terms1 = $ALL_REQUEST['SearchWord1'];
                $Terms2 = $ALL_REQUEST['SearchWord2'];
                $Terms3 = $ALL_REQUEST['SearchWord3'];
                $QueryItems1 = $ALL_REQUEST[$ALL_REQUEST['QueryOption1']];
                $QueryItems2 = $ALL_REQUEST[$ALL_REQUEST['QueryOption2']];
                $QueryItems3 = $ALL_REQUEST[$ALL_REQUEST['QueryOption3']];
		$Filter1 = $ALL_REQUEST['filter1'];
		$Filter2 = $ALL_REQUEST['filter2'];
		
		$BYear = $ALL_REQUEST['BeginYear'];
                $EYear = $ALL_REQUEST['EndYear'];
                $BMonth = $ALL_REQUEST[$ALL_REQUEST['BeginMonth']];
                $EMonth = $ALL_REQUEST[$ALL_REQUEST['EndMonth']];
                $BDay = $ALL_REQUEST['BeginDay'];
                $EDay = $ALL_REQUEST['EndDay'];


	
		$RelRank = "";
		
		$Terms1 = str_replace("\'", "\\\'", $Terms1);
		$Terms2 = str_replace("\'", "\\\'", $Terms2);
		$Terms3 = str_replace("\'", "\\\'", $Terms3);
	
		if ($Terms1 != "")
		{
			$RelRank = "(count(words($QueryItems1) WHERE " . $QueryItems1 . " IN ['" . $Terms1 . "'])";
		}
		if ($Filter1 != "NOT")
		{
			if ($Terms2 != "")
			{
				if ($RelRank != "")
				{	$RelRank .= ") + ";}
				$RelRank .= "(count(words($QueryItems2) WHERE " . $QueryItems2 . " IN ['" . $Terms2 . "'])";
			}
		}
		if ($Filter2 != "NOT")
		{
			if ($Terms3 != "")
			{
		        	if ($RelRank != "")
				{       $RelRank .= ") + ";}
				$RelRank .= "(count(words($QueryItems3) WHERE " . $QueryItems3 . " IN ['" . $Terms3 . "'])";
			}
		}
		if ($RelRank != "")
		{
			$RelRank = ", (" . $RelRank . ")) as rank ";
		}
		else
		{
			$RelRank = ", (0 as rank)";
		}
		
		return ($RelRank);
		
	
	}

/* This function provides the query with the total number of returns */ 

	function WarclipCounter()
	{
	
                $Counter .= ') as Total, 0 AS irn, [0*NULL AS MulMultiMediaRef] AS MultimediaRef_tab, ';
                $Counter .= " '' || NULL AS AdmWebMetadata,";
                $Counter .= " '' || NULL AS WarHeadline,";
                $Counter .= " '' || NULL AS WarSourceNewspaperSummData,";
                $Counter .= " DATE '9999' AS DatManufacture,";
                $Counter .= " '' || NULL AS WarSubjectMetaData,";
                $Counter .= " '' || NULL AS SumSubHeading1,";
                $Counter .= " '' || NULL AS SumSubHeading2,";
                $Counter .= " '' || NULL AS SumSubHeading3,";
                $Counter .= " '' || NULL AS SumSubHeading4,";
                $Counter .= " '' || NULL AS SumSubHeading5,";
                $Counter .= " '' || NULL AS ObjTitle, ";
                $Counter .= " '' || NULL AS MMirn, 0 AS rank ]";
		
		return($Counter);

	
	}

}

