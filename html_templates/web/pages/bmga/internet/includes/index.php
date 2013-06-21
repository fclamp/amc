<?php
/*
** Copyright (c) KE Software Pty. Ltd. 2008
*/

require_once('../emuweb/php5/query.php');

//Get eluts data for collection name field

$lutscolnameqry = new Query();
$lutscolnameqry->Select("Value010");
$lutscolnameqry->Table = 'eluts';
$lutscolnameqry->Term("NameText", "Department");
$lutscolnameqry->Order= "Value010";
$lutscolnameqry->Visibility = QUERY::$ALL;
$lutscolnameqryresults = $lutscolnameqry->Fetch();
$lutscolnamecount = $lutscolnameqry->Matches;

$lutscolnamevals = array();
foreach ($lutscolnameqryresults as $lutscolnameval)
{
	array_push($lutscolnamevals, $lutscolnameval->Value010);
}
$lutscolnamevals = array_unique($lutscolnamevals);

//Get eluts data for object status field

$lutsobjsqry = new Query();
$lutsobjsqry->Select ("Value000");
$lutsobjsqry->Table = 'eluts';
$lutsobjsqry->Term("NameText", "Object Status");
$lutsobjsqry->Order= "Value000";
$lutsobjsqry->Visibility = QUERY::$ALL;
$lutsobjsqryresults = $lutsobjsqry->Fetch();
$lutsobjscount = $lutsobjsqry->Matches;

$lutsobjsvals = array();
foreach ($lutsobjsqryresults as $lutsobjsval)
{
	array_push($lutsobjsvals, $lutsobjsval->Value000);
}
$lutsobjsvals = array_unique($lutsobjsvals);

//Get eluts data for loclevel 1
$lutsloc1qry = new Query();
$lutsloc1qry->Select ("Value000");
$lutsloc1qry->Table = 'eluts';
$lutsloc1qry->Term("NameText", "Location Hierarchy");
$lutsloc1qry->Order= "Value000";
$lutsloc1qry->Visibility = QUERY::$ALL;
$lutsloc1qryresults = $lutsloc1qry->Fetch();
$lutsloc1count = $lutsloc1qry->Matches;

$lutsloc1vals = array();
foreach ($lutsloc1qryresults as $lutsloc1val)
{
	array_push($lutsloc1vals, $lutsloc1val->Value000);
}
$lutsloc1vals = array_unique($lutsloc1vals);


//Get eluts data for loclevel 2
$lutsloc2qry = new Query();
$lutsloc2qry->Select ("Value010");
$lutsloc2qry->Table = 'eluts';
$lutsloc2qry->Term("NameText", "Location Hierarchy");
$lutsloc2qry->Order= "Value010";
$lutsloc2qry->Visibility = QUERY::$ALL;
$lutsloc2qryresults = $lutsloc2qry->Fetch();
$lutsloc2count = $lutsloc2qry->Matches;

$lutsloc2vals = array();
foreach ($lutsloc2qryresults as $lutsloc2val)
{
	array_push($lutsloc2vals, $lutsloc2val->Value010);
}
$lutsloc2vals = array_unique($lutsloc2vals);



?>
