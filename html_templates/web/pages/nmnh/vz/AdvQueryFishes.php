<?php include "header-large-fishes.html" ?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Division of Fishes Collections</title>
</head>

<body bgcolor="#AAC1C0">
<br>
<table border="0" width="814" cellspacing="0" cellpadding="8">
	<tr> 
		<td width="12%" nowrap align="center" valign="top"> 
			<p align="center"><img border="0" src="images/sponge.jpg" width="90" height="150">
		</td>
		<td width="88%" align="left" valign="top">
			<font face="Tahoma" color="#013567" size="2"> 
				<b>Advanced Search of the Vertebrate Collections</b><br>
			</font>
			<font face="Tahoma" color="#013567" size="2">
				Enter any terms in the boxes below as instructed, select an area of the database to search, 
				then click the "Search" button.<br>
				<br>
				Please note: These searches may take a while, please be patient.
			</font>
		</td>
	</tr>
</table>


<div align="left">
<?php
	require_once('../../../objects/nmnh/vz/QueryForms.php');
	$queryform = new NmnhVzFishesAdvancedQueryForm;
	$queryform->Title = 'Enter search term(s)...';
	$queryform->ResultsListPage = 'ResultsListFishes.php';
	$queryform->Width = '814';
	$queryform->FontFace = 'Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#003063';
	$queryform->BorderColor = '#013567';
	$queryform->BodyColor = '#FFF3DE';
	$queryform->Show();
?>
</div>

<BLOCKQUOTE> 
	<p align="left"> 
		<a href="QueryFishes.php"><font face="Tahoma"><u>Basic search</u></font></a>
		<font color="#336699" face="Tahoma"> | </font>
		<a href="DtlQueryFishes.php"><font face="Tahoma"><u>Detailed search</u></font></a>
	</p>
	<p align="left">
		&nbsp;
	</p>
</BLOCKQUOTE>

<?php include "footerFishes.php"?>

</body>

</html>

