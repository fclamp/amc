<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>KE EMu Standard Collection Search</title>
</head>

<body bgcolor="#FFFFE8">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<td width="10%" nowrap>
			<p align="center"><font face="Tahoma"><img border="0" src="images/column.jpg" width="171" height="242"></font></td>	
		<td width="70%" valign="top"><font face="Tahoma" size="5" color="#336699"><b>Search
			Collection Database...</b></font>
			<p><font color="#336699" size="2" face="Tahoma">Welcome to the KE Software live 
			Collection search page. </font></p>
			<p><font color="#336699" size="2" face="Tahoma">Key word searches can be
			performed in the main search box below.&nbsp;</font></p>
		</td>
		<td width="20%" valign="middle" bgcolor="#FFFFE8">
		</td>
	</tr>
</table>

<div align="center">
	<center>

<!-- ************* Start BasicQueryForm Object ********************* -->
<?php
      require_once('../../objects/collectionevents/CollectionQueryForms.php');

	$queryform = new CollectionBasicQueryForm;
	$queryform->ResultsListPage = "CollectionResultsList.php";
	$queryform->DisplayPage = "CollectionDisplay.php";
	$queryform->FontFace = 'Tahoma, Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#336699';
	$queryform->Title = "Search For Localities...";
	$queryform->BorderColor = '#336699';
	// $queryform->BodyColor = '#FFF3DE';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Language = '0';
	$queryform->Show();
?>
<!-- ************* End BasicQueryForm Object ********************* -->

	</center>
</div>

<p align="center"><u><a href="CollectionAdvQuery.php"><font face="Tahoma">Advanced search</font></a></u> <font color="#336699" face="Tahoma"> |
</font><u><a href="CollectionDtlQuery.php"><font face="Tahoma">Detailed search</font></a></u></p>

<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
	<tr>
		<td width="10%" align="center"></td>
		<td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
		<td width="40%" valign="middle">
			<p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2007 KE Software.&nbsp;</font></font></td>
		<td width="10%"></td>
	</tr>
</table>

</body>

</html>
