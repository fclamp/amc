<?php
require_once(dirname(__FILE__) . "/common.php");

// Search terms
$terms = "";
$where = "true";
if (! empty($_REQUEST['audience']))
{
	$value = $_REQUEST['audience'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "audience=$value";
	$where .= " and exists (DesIntendendAudience_tab where DesIntendedAudience contains '$value')";
}
if (! empty($_REQUEST['narrative']))
{
	$value = $_REQUEST['narrative'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "narrative=$value";
	$where .= " and NarNarrative contains '$value'";
}
if (! empty($_REQUEST['title']))
{
	$value = $_REQUEST['title'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "title=$value";
	$where .= " and NarTitle contains '$value'";
}
if (! empty($_REQUEST['subjects']))
{
	$value = $_REQUEST['subjects'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "subjects=$value";
	$where .= " and exists (DesSubjects_tab where DesSubjects contains '$value')";
}

// Record number
$record = 1;
if (! empty($_REQUEST['record']))
	$record = $_REQUEST['record'];
$page = floor(($record - 1) / $pageSize) + 1;
$from = ($page - 1) * $pageSize + 1;
$to = $page * $pageSize;
$offset = $record - $from;
?>
