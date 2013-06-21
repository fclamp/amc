<?php
ob_start();
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/*
* Number of records to return each time
*/
$RecordsPerPage = 100;
$QueryTable = "ecollectionevents";

// Fishes Localities

	$fieldlist = array('irn_1',
			'SummaryData',						
			'ColSiteRef->esites->SitSiteNumber',
			'ColSiteRef->esites->SitRecordClassification',
			'ColSiteRef->esites->SitSiteName_tab',
			'ColSiteRef->esites->SitJurisdiction',
			'ColSiteRef->esites->LocContinent_tab',
			'ColSiteRef->esites->LocCountry_tab',
			'ColSiteRef->esites->LocProvinceStateTerritory_tab',
			'ColSiteRef->esites->LocDistrictCountyShire_tab',
			'ColSiteRef->esites->LocTownship_tab',
			'ColSiteRef->esites->LocOceanMain',
			'ColSiteRef->esites->LocSeaGulfMain',
			'ColSiteRef->esites->LocBaySoundMain',
			'ColSiteRef->esites->LocIslandGrouping',
			'ColSiteRef->esites->LocIslandName',
			'ColSiteRef->esites->LocNearestNamedPlace_tab',
			'ColSiteRef->esites->LocPreciseLocation',
			'ColSiteRef->esites->LocSpecialGeographicUnit_tab',
			'ColSiteRef->esites->LocVerbatimLocality',
			'ColSiteRef->esites->LocElevationASLFromMt',
			'ColSiteRef->esites->LocElevationASLToMt',
			'ColSiteRef->esites->LatLatitudeFmnhWeb',
			'ColSiteRef->esites->LatLongitudeFmnhWeb',
			'ColSiteRef->esites->LatCentroidLatitude0',
			'ColSiteRef->esites->LatCentroidLongitude0',
			'ColSiteRef->esites->LatLatLongDetermination_tab',
			'ColSiteRef->esites->LocDrainageBasin',
			'ColSiteRef->esites->AquDrainageDivision',
			'ColSiteRef->esites->AquRiverBasin',
			'ColSiteRef->esites->AquHabitat_tab',
			'ColSiteRef->esites->AquSubstrateType_tab',
			'ColSiteRef->esites->TerVegetation',
			'ColSiteRef->esites->TerEcologicalZone',
			'ColSiteRef->esites->TerSiteCondition',
			'ColSiteRef->esites->TerSedimentType',
			//'NotNotes',
	);
require_once(dirname(__FILE__) . "/query.php");
require_once('../../web/objects/fmnh/strings/english.php');

/*
* Print out the field headings
*/

header("Content-type: text/csv");
header("Content-disposition: attachment; filename=FMNH-FishesLocal-Internet-Export.csv");


$buf = "";
foreach ($fieldlist as $field)
{
	if(!empty($buf))
		$buf .= ",";

	if (!isset($STRINGS[$field]))
		$buf .= preg_replace('/->/', '_', $field);
	else
		$buf .= $STRINGS[$field];
}
print "$buf\n";
ob_flush();
flush();

/*
* Do the query
*/
$query = new Query;
$query->StartRec = 1;
$query->EndRec = $RecordsPerPage;
$query->Table = $QueryTable;
$where = "";
$Restriction = "";
$QueryName = "";
$QueryTerms = "";
$AllWords = array();
$Phrase = "";
$AnyWords = array();
$WithoutWords = array();
$SoundsLikeWords = array();

//print_r($_REQUEST);
foreach ($_REQUEST as $reqkey => $val)
{
	$keys = explode("|", $reqkey);
	if (count($keys) > 1)
	{
		for ($i = 1; $i < count($keys); $i++)
		{
			$keys[$i] = "col_" . $keys[$i];
		}
	}
	foreach ($keys as $key)
	{
		if (empty($val))
		continue;
		if (preg_match("/Where/", $key))
		{
			$val = preg_replace('/\%5C\%27/', '%27', $val);
			$val = urldecode($val);
			$query->TexqlTerm($val);
		}
		elseif (preg_match("/QueryName/", $key))
		{
			$QueryName = $val;
		}
		elseif (preg_match("/Restriction/", $key))
		{
			$Restriction = preg_replace('/\%5C\%27/', '%27', $val);
			$Restriction = urldecode($Restriction);
			$query->TexqlTerm($Restriction);
		}
		elseif (preg_match("/QueryTerms/", $key))
		{
			$val = urldecode($val);
			$AllWords = split('[, ]',$val);
		}
		elseif (preg_match("/AllWords/", $key))
		{
			$val = urldecode($val);
			$AllWords = split('[, ]',$val);
		}
		elseif (preg_match("/Phrase/", $key))
		{
			$Phrase = urldecode($val);
		}
		elseif (preg_match("/AnyWords/", $key))
		{
			$val = urldecode($val);
			$AnyWords = split('[ ,]',$val);
		}
		elseif (preg_match("/WithoutWords/", $key))
		{
			$val = urldecode($val);
			$WithoutWords = split('[ ,]',$val);
		}
		elseif (preg_match("/SoundsLikeWords/", $key))
		{
			$val = urldecode($val);
			$SoundsLikeWords = split('[ ,]',$val);
		}
		elseif ( (preg_match("/QueryOption/", $key)) && ($QueryName == "BasicQuery") )
		{
			$str = "";
			if (!empty($AllWords))
			{
				foreach($AllWords as $word)
				{
					if($str != "")
						$str .= " AND ";
					$str .= $_REQUEST[$val] . " contains '" . $word . "'";
				}
				$query->TexqlTerm($str);
				$str = "";
			}
		}
		elseif ( (preg_match("/QueryOption/", $key)) && ($QueryName == "AdvancedQuery") )
		{
			$str = "";
			if (!empty($AllWords))
			{
				foreach($AllWords as $word)
				{
					if($str != "")
						$str .= " AND ";
					$str .= $_REQUEST[$val] . " contains '" . $word . "'";
				}
				$query->TexqlTerm($str);
				$str = "";
			}
			if ($Phrase != "")
			{
				$query->Term($_REQUEST[$val], $Phrase);
			}
			foreach($AnyWords as $word)
			{
				$query->Term($_REQUEST[$val], $word);
			}
			if (!empty($WithoutWords))
			{
				foreach($WithoutWords as $word)
				{
					if($str != "")
						$str .= " AND ";
					$str .= "NOT (" . $_REQUEST[$val] . " contains '" . $word . "')";
				}
				$query->TexqlTerm($str);
				$str = "";
			}
			if (!empty($SoundsLikeWords))
			{
				foreach($SoundsLikeWords as $word)
				{
					if($str != "")
						$str .= " AND ";
					$str .= $_REQUEST[$val] . " contains '@" . $word . "'";
				}
				$query->TexqlTerm($str);
				$str = "";
			}
		}
		elseif (preg_match('/^col_date_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'date';
			$val = urldecode($val);
			$query->Term($colname, $val, $coltype);
		}
		elseif (preg_match('/^col_float_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'float';
			$val = urldecode($val);
			$query->Term($colname, $val, $coltype);
		}
		elseif (preg_match('/^col_int_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'int';
			$val = urldecode($val);
			$query->Term($colname, $val, $coltype);
		}
		elseif (preg_match('/^col_lat_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'latitude';
			$val = urldecode($val);
			$query->Term($colname, $val, $coltype);
		}
		elseif (preg_match('/^col_long_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'longitude';
			$val = urldecode($val);
			$query->Term($colname, $val, $coltype);
		}
		elseif (preg_match('/^col_str_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'string';
			$val = urldecode($val);
			$query->Term($colname, $val, $coltype);
		}
		elseif (preg_match('/^col_(.+)$/', $key, $matches) && (trim($val) != '') && ($QueryName = "DetailedQuery") )
		{
			$colname = $matches[1];
			$coltype = 'text';
			$val = urldecode($val);
			if (preg_match('/^(.+?)->(e.+?)->(.+)$/',$colname,$matches))
			{
				$pq = array('target' => $matches[3], 'val' => $val);
				if (!isset($PreQueries[$matches[2]][$matches[1]]))
				{
					$PreQueries[$matches[2]][$matches[1]] = array();
					array_push($PreQueries[$matches[2]][$matches[1]], $pq);
				}
				else
				{
					array_push($PreQueries[$matches[2]][$matches[1]], $pq);
				}
			}
			else
			{
				$query->Term($colname, $val, $coltype);
			}
		}
		else
			continue;
	}
}

foreach($fieldlist as $field)
{
	$query->Select("$field");
}

//Run the PreQuery
$prequery = new Query;
foreach ($PreQueries as $table => $refcols)
{
	$prequery->Table = $table;
	foreach($refcols as $refcol => $queries)
	{
		$prequery->Select('irn_1');
		foreach ($queries as $querydetails)
		{
			$prequery->Term($querydetails['target'], $querydetails['val']);
		}
		$prequery->TexqlTerm("AdmPublishWebNoPassword contains 'Yes'");
		$preresults = $prequery->Fetch();
		$term = "";
		foreach ($preresults as $record)
		{
			$val = $record->{'irn_1'};
			if ($term == "")
			{
				$term = "$refcol = $val";
			}
			else
			{
				$term .= " OR $refcol = $val";
			}
		}
		$query->TexqlTerm($term);
	}
}

$query->TexqlTerm("AdmPublishWebNoPassword contains 'Yes'");
$results = $query->Fetch();

/*
* Print out the data
*/
printresults($results, $fieldlist);
ob_flush();
flush();

/*
* Now loop through remaining results and query for next set to return
*/
$ProcessedRecords = $RecordsPerPage;
$TotalRecords = $query->Matches;
while ($ProcessedRecords < $TotalRecords)
{
	$query->ClearResults();
	$query->StartRec += $RecordsPerPage;
	$query->EndRec += $RecordsPerPage;
	$results = $query->Fetch();
	printresults($results, $fieldlist);
	ob_flush();
	flush();
	$ProcessedRecords += $RecordsPerPage;
}


/*
* Function to print out results
*/
function
printresults(&$results, &$fieldlist)
{
	foreach ($results as $record)
	{
		$buf = "";
		$irnfield = "irn_1";
		foreach ($fieldlist as $field)
		{
			if (preg_match("/^(.*?)->(.*?)->(.*?)$/", $field, $matches))
			{
				$field = $matches[1];

				if (!isset($record->$field))
				{
                                        $buf .= ",";
					continue;
				}

				$reftable = $matches[2];
				$secondfield = $matches[3];
				if ( (preg_match("/_tab/",$field)) || (preg_match("/_nesttab/",$field)) )
				{
					$val = array();
					$multiref = $record->$field;
					foreach ($multiref as $ref)
					{
						if (is_array($ref))
						{
							$inval = array();
							foreach ($ref as $unit)
							{
								array_push($inval, $unit->$secondfield);
							}
							array_push($val, $inval);
						}
						else
						{
							array_push($val, $ref->$secondfield);
						}
					}
				}
				else
				{
					$ref = $record->$field;
					$val = $ref->$secondfield;
				}
			}
			else if (preg_match("/^(.*?)<-(.*?)<-(.*?)$/", $field, $matches))
			{
				$datafield = $matches[1];
				$reftable = $matches[2];
				$field = $matches[3];
				if ( preg_match("/_nesttab/",$field) )
				{
					$val = array();
					$shortfield = substr($field, 0, -8);
					$refquery = new Query;
					$refquery->Table = $reftable;
					$refquery->Select($datafield);
					$command = "exists (" . $field . " where exists (" . $shortfield . "_tab where " . $shortfield . " = " . $record->$irnfield . "))";
					$refquery->TexqlTerm($command);
					$refresults = $refquery->Fetch();

					foreach($refresults as $refresult)
					{
						$inval = array();
						foreach($refresult as $ref)
						{
							array_push($inval, $ref->$datafield);
						}
						array_push($val, $inval);
					}
				}
				else if ( (preg_match("/_tab/",$field)) )
				{
					$val = array();
					$shortfield = substr($field, 0, -4);
					$refquery = new Query;
					$refquery->Table = $reftable;
					$refquery->Select($datafield);
					$command = "exists (" . $field . " where (" . $shortfield . " = " . $record->$irnfield . "))";
					$refquery->TexqlTerm($command);
					$refresults = $refquery->Fetch();

					foreach($refresults as $refresult)
					{
						array_push($val, $refresult->$datafield);
					}
				}
				else
				{
					$refquery = new Query;
					$refquery->Table = $reftable;
					$refquery->Select($datafield);
					$command = $field . " = " . $record->$irnfield;
					$refquery->TexqlTerm($command);
					$refresults = $refquery->Fetch();
					$val = $refresults[0]->$datafield;
				}
			}
			else
			{
				$val = $record->$field;
			}

			if (is_array($val))
			{
				$outval = "";
				foreach ($val as $single)
				{		
					if (is_array($single))
					{
						if (!empty($outval))
							$outval .= "\n";
						$outval	.= "[";
						$inval = "";
						foreach ($single as $unit)
						{
							if (!empty($inval))
								$inval .= "|";
							$inval .= $unit;
						}
						$outval .= $inval . "]";
					}
					else
					{
						if (!empty($outval))
							$outval .= "\n";
						$outval	.= $single;
					}
				}
				$val = $outval;
			}

			if (strpos($val, '"') !== FALSE)
				$val = preg_replace('/"/', '""', $val);

			if (strpos($val, ',') !== FALSE
				|| strpos($val, "\n") !== FALSE)
			{
				$val = '"' . $val . '"';
			}

			# we use utf8_decode because the
			# simplexml_load_string function 
			# in query.php may have converted
			# the xml results to UTF-8
			$buf .= utf8_decode($val);
			$buf .= ',';
		}
		preg_replace('/,$/', '', $buf);
		print $buf . "\n";
	}
}
?>
