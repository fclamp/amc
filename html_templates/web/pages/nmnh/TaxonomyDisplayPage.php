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

<body  bgcolor="#ffffe8">
      <h3><font face="Tahoma" color="#336699">&nbsp;Taxonomy Record...</font></h3><br>

<p align=center>

<!--  ******************* TaxonomyDisplay Object ********************************* -->
<?php
	require_once('../../objects/common/TaxonomyDisplayObjects.php');

	$display = new TaxonomyStandardDisplay();
	
	$display->mapperUrl = '../../objects/common/emuwebmap.php';
	$display->mapperDataSource = 'nmnhweb';
	$display->mapDisplay = 1;
	$display->FontFace = 'Arial';
	$display->HeaderFontSize = '4';
	$display->FontSize = '2';
	$display->BodyTextColor = '#013567';
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
    * $Date: 2004/07/22 06:04:57 $
    *
    *-->

</html>
