<?php
require_once('emuweb/php5/query.php');

function
GetLookup($LookupName, $Level = 0)
{
	$LevelName = "Value0" . $Level . "0";
	
	$qry = new Query;
	$EMU_GLOBALS['DEBUG'] = 1;
	$qry->Visibility = QUERY::$ALL;
	$qry->Select("$LevelName");
	$qry->Table = "eluts";
	$qry->Term("NameText", "\"$LookupName\"");
	$qry->Term("Levels", $Level + 1, "int");
	$results = $qry->Fetch();


	$values = array();

	foreach ($results as $result)
	{
		array_push($values, $result->{"$LevelName"});
	}
	//print_r($values);

	return $values;
}
?>


