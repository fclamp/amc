<?php
/* Copyright (c) KE Software 2002 */
/*
**  This file contains a basic example on how table access can be granted to a
**  third party via the web.  The XMLQueryDisplay object provides a method for
**  displaying XML results from a given query.  The object allows the site 
**  administrator to control access on:
**	- fields in the table avaliable for query
**	- fields in the table displayed in the XML results
**	- restrict queries to a subset of results
**   
*/

/* Delete (comment out) the "die" line below to try this example.
*	Access using a url like:
*	 http://server/web/webservices/tableaccessexample.php?NamLast=Smith
*/
die("Disabled: This file is an example only");

require_once("../objects/common/XMLQueryDisplay.php");


$xmldisplay = new XMLQueryDisplay;

/* Query on eparties table
*/
$xmldisplay->Database 		= "eparties";

/* Restrict queries to people in the Sales department only
*/
$xmldisplay->Restriction = "NamDepartment contains 'Sales'";

/* Define list of fields that can be used in a query
*/
$xmldisplay->QueryTextFields 	= array(
					"NamFirst",
					"NamLast",
					"NamSex",
					"NamPosition",
					);

/* Define a list of fields to be displayed in query results
*/
$xmldisplay->SelectFields
	 = "NamFirst, NamLast, NamSex, NamPosition, NamOrganisation";

/* Call the Show method to display the xml.
*/
$xmldisplay->Show();


?>
