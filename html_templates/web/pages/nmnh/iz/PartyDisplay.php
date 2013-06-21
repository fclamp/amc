<?php include "header-small.html" ?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Search the NMNH Department of Invertebrate Zoology</title>
</head>

<body bgcolor="#AAC1C0">
<h4><font face="Tahoma" color="#013567"><b>Search results</b> in our prototype display... <br>
<font size="2">Over time more data and images will be made available.</font></font></h4>
<br>

<p align=center>
	<?php
		require_once('../../../objects/nmnh/iz/DisplayObjects.php');
		$display = new NmnhIzPartyDisplay;
		$display->FontFace = 'Arial';
		$display->FontSize = '2';
		$display->BodyTextColor = '#013567';
		$display->BorderColor = '#013567';
		$display->HeaderTextColor = '#FFFFFF';
		$display->BodyColor = '#FFF3DE';
		$display->HighlightColor = '#FFFFFF';
		$display->Show();
	?>
</p>
<br>

<?php include "footer.php" ?>

</body>
</html>
