<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	 <title>KE EMu Collection Display</title>
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
      <h3><font face="Tahoma" color="#336699">&nbsp;Collection Record...</font></h3><br>

<p align=center>

<!--  ******************* CollectionDisplay Object ********************************* -->
<?php
	require_once('../../objects/collectionevents/CollectionDisplayObjects.php');

	$display = new ModuleStandardDisplay();

	$display->referer = '/pages/collectionevents/CollectionQuery.php';
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
<!--  ******************* end CollectionDisplay Object ********************************* -->

</p>
<br>

</body>

<!--*
    *
    * $Revision: 1.2 $
    * $Date: 2007/03/04 22:35:11 $
    *
    *-->

</html>
