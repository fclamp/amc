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

<body bgcolor="#ffffef">
	<img align=left border="0" src="images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#336699">&nbsp;Taxonomy Record...</font></h3><br>

<p align=center>

<!--  ******************* TaxonomyDisplay Object ********************************* -->
<?php
	require_once('../../objects/common/TaxonomyDisplayObjects.php');

	$display = new TaxonomyStandardDisplay();
	
	$display->mapperUrl = '../../objects/common/emuwebmap.php';
	$display->mapperDataSource = 'mv';
	$display->mapDisplay = 1;
	$display->FontFace = 'Arial';
	$display->HeaderFontSize = '4';
	$display->FontSize = '2';
	$display->BodyTextColor = '#013567';
	$display->BorderColor = '#336699';
	$display->HeaderTextColor = '#FFFFE8';
	$display->BodyColor = '#FFFFE8';
	$display->HighlightColor = '#FFFFE8';
	$display->Show();
?>
<!--  ******************* end TaxonomyDisplay Object ********************************* -->

</p>
<br>

</body>

<!--*
    *
    * $Revision: 1.2 $
    * $Date: 2004/06/10 04:03:26 $
    *
    *-->

</html>
