
<?php include "header-large.html" ?>

<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Department of Invertebrate Zoology</title>
</head>

<body bgcolor="#AAC1C0">
<br>
<table border="0" width="59%" cellspacing="0" cellpadding="8">
	<tr> 
		<td width="12%" nowrap align="center" valign="top"> 
			<p align="center"><img border="0" src="images/sponge.jpg" width="90" height="150">
		</td>
		<td width="88%" align="left" valign="top">
			<font face="Tahoma" color="#013567" size="2"> 
				<b>Advanced Search of the Invertebrate Collections</b><br>
			</font>
			<font face="Tahoma" color="#013567" size="2">
				Enter any terms in the boxes below as instructed, select an area of the database to search, then click the "Search" button.<br>
			<br>
				Please note: These searches may take a while, please be patient.
			</font>
		</td>
	</tr>
</table>
<br>

<div align="left">
<?php
	require_once('../../../objects/nmnh/iz/QueryForms.php');
	$queryform = new NmnhIzAdvancedQueryForm;
	$queryform->Title = 'Enter search term(s)...';
	$queryform->ResultsListPage = 'ResultsList.php';
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
		<a href="Query.php"><font face="Tahoma"><b>Basic Search</b></font></a>
		<font color="#000000" face="Tahoma">&nbsp; |&nbsp;&nbsp;</font>
		<a href="DtlQuery.php"><font face="Tahoma"><b>Detailed Search</b></font></a>
	</p>
</BLOCKQUOTE>

<?php include "footer.php"?>

</body>

</html>

