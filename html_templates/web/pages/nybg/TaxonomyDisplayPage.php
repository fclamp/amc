<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<!-- **************** Generate a useful title using PHP *************  -->
	<title>
		<?php
		require_once('../../objects/common/TaxonomyDisplayObjects.php');
		$resultListTitle = new TaxonomyDisplayObjectTitle('Taxonomy Display');
		$resultListTitle->Show();
		?>
	</title> 
	<!-- **************** end Generate a useful title using PHP *************  -->
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

<body background="images/nybgbackground.jpg" bgcolor="#ffffff">
	<img align=left border="0" src="images/nybg.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#006400">&nbsp;Taxonomy Record...</font></h3><br>

<p align=center>

<!--  ******************* TaxonomyDisplay Object ********************************* -->
<?php
	require_once('../../objects/common/TaxonomyDisplayObjects.php');

	$display = new TaxonomyStandardDisplay();
	
	$display->mapperUrl = '../../objects/common/emuwebmap.php';
	$display->mapperDataSource = 'nybg';
	$display->mapDisplay = 1;
	$display->FontFace = 'Arial';
	$display->HeaderFontSize = '4';
	$display->FontSize = '2';
	$display->BodyTextColor = '#013567';
	$display->BorderColor = '#006400';
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
    * $Revision: 1.1 $
    * $Date: 2004/02/12 07:07:12 $
    *
    *-->

</html>
