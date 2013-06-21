<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>KE EMu Taxonomy Display</title>
	<style>
 		.linkLikeButton {
 			border: none;
			cursor: pointer;
			cursor: hand;
 			text-decoration: underline;
 			color: rgb(0,0,255);
 			background-color: transparent;
 			font-weight: bold;
			font-family: Arial, sans-serif;
		}
	</style>	
</head>

<body  bgcolor="#ffffe8">
      <h3><font face="Tahoma" color="#336699">&nbsp;Taxonomy Record...</font></h3><br>

<p align=center>

<!--  ******************* TaxonomyDisplay Object ********************************* -->
<?php
	require_once('../../objects/taxonomy/TaxonomyDisplayObjects.php');

	$display = new ModuleStandardDisplay();

	$display->referer = '/pages/taxonomy/TaxonomyQuery.php';	
	$display->mapperUrl = '../../webservices/mapper.php';
	$display->mapperDataSource = 'nmnhweb';
	$display->mapDisplay = 1;
	$display->FontFace = 'Tahoma';
	$display->HeaderFontSize = '4';
	$display->FontSize = '2';
	$display->BodyTextColor = '#336699';
	$display->BorderColor = '#336699';
	$display->HeaderTextColor = '#FFFFFF';
	$display->BodyColor = '#FFFFE8';
	$display->HighlightColor = '#FFFFFF';
	$display->Show();
?>
<!--  ******************* end TaxonomyDisplay Object ********************************* -->

</p>
<br>

</body>

<!--*
    *
    * $Revision: 1.2 $
    * $Date: 2007/03/04 22:32:31 $
    *
    *-->

</html>
