<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>KE EMu Detailed Taxonomy Search</title>
</head>

<body bgcolor="#FFFFE8">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
	<tr>
		<td width="10%" nowrap>
			<p align="center"><img border="0" src="images/column.jpg" width="84" height="123"></p>
		</td>
		<td width="45%">
			<font face="Tahoma" color="#336699" size="4"><b>Detailed Search<br></b></font>
			<font color="#336699" face="Tahoma">Enter any terms in the boxes below and click on the "Search"
button.&nbsp; For other search types, select one of the options beneath the search
box.</font>
		</td>
		<td width="45%" valign="top">
		<p align="right">
	</tr>
</table>

<div align="center">
	<center>
<!-- ************* Start TaxonomyDetailedQueryForm Object ********************* -->
<?php
	require_once('../../objects/taxonomy/TaxonomyQueryForms.php');

	$queryform = new TaxonomyDetailedQueryForm;

	$queryform->showLevels = array ( 
				'ClaScientificName',
				'ClaPhylum',
				'ClaClass', 
				'ClaOrder',
				'ClaFamily',
				'ClaGenus',
				'ClaSpecies',
				'ComName_tab',
				'SummaryData',);
	$queryform->Fields = array (   
				'ClaScientificName',
				'ClaPhylum',
				'ClaClass', 
				'ClaOrder',
				'ClaFamily',
				'ClaGenus',
				'ClaSpecies',
				'ComName_tab',
				'SummaryData',);
	$queryform->showSummary = 0;
	$queryform->ResultsListPage = "TaxonomyResultsList.php";
	$queryform->DisplayPage = "TaxonomyDisplay.php";
	$queryform->FontFace = 'Tahoma, Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#336699';
	$queryform->Title = "Search For Taxon...";
	$queryform->BorderColor = '#336699';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Language = '0';
	$queryform->Show();
?>
<!-- ************* End TaxonomyDetailedQueryForm Object ********************* -->
	</center>
</div>

<p align="center"><u><a href="TaxonomyQuery.php"><font face="Tahoma">Basic search</font></a></u> <font color="#336699" face="Tahoma"> |
</font><u><a href="TaxonomyAdvQuery.php"><font face="Tahoma">Advanced search</font></a></u></p>

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
