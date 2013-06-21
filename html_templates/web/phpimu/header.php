<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(__FILE__);

if (! isset($pageTitle))
	$pageTitle = "The National Museum";		// default page title

require_once("$WEB_ROOT/globals.php");
$css = "$urlRoot/museum.css";
$home = "$urlRoot/index.php";
$browse = "$urlRoot/narratives/details.php";
$search = "$urlRoot/narratives/search.php";
$collection = "$urlRoot/narratives/collections.php";
$banner = "$urlRoot/banner.gif";
?>
<!-- begin header.php -->
<html>
<head>
<!--
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $pageTitle ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $css ?>" />
<!--
<script type="text/javascript" src="includes/javascript.js"></script>
-->
</head>

<body>
<div class="PageShadow">
	<div class="PageCentre">
		<div class="PageHeader">			
			<div class="PageMenu">
				<a href="<?php echo $home ?>">home</a>
				|
				<a href="<?php echo $browse ?>">browse collection</a>
				|
				<a href="<?php echo $search ?>">search collection</a>
				|
				<a href="<?php echo $collection ?>">my collections</a>
			</div>
			<div class="PageBanner">
				<img border="0" src="<?php echo $banner ?>" >
			</div>
		</div>
<!-- end header.php -->
