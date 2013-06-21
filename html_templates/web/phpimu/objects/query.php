<?php
require_once(dirname(__FILE__) . "/common.php");

// Search terms
$terms = "";
$where = "true";
if (! empty($_REQUEST['category']))
{
	$value = $_REQUEST['category'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "category=$value";
	$where .= " and TitObjectCategory contains '$value'";
}
if (! empty($_REQUEST['description']))
{
	$value = $_REQUEST['description'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "description=$value";
	$where .= " and PhyDescription contains '$value'";
}
if (! empty($_REQUEST['keywords']))
{
	$value = $_REQUEST['keywords'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "keywords=$value";
	$where .= " and SummaryData contains '$value'";
}
if (! empty($_REQUEST['medium']))
{
	$value = $_REQUEST['medium'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "medium=$value";
	$where .= " and exists (PhyMedium_tab where PhyMedium contains '$value')";
}
if (! empty($_REQUEST['technique']))
{
	$value = $_REQUEST['technique'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "technique=$value";
	$where .= " and exists (PhyTechnique_tab where PhyTechnique contains '$value')";
}
if (! empty($_REQUEST['title']))
{
	$value = $_REQUEST['title'];
	if ($terms != "")
		$terms .= "&";
	$terms .= "title=$value";
	$where .= " and TitMainTitle contains '$value'";
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
