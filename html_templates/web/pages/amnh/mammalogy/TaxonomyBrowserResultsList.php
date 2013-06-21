<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" href="amnh.css">
	<!-- ********** Generate a useful title using PHP ************** -->
	<title>
		<?php
		require_once('../../../objects/common/TaxonomyBrowserResultsList.php');
		$resultListTitle = new TaxonomyBrowserResultsListTitle('Standard Search');
		$resultListTitle->Show();
		?>
	</title> 
</head>

<!--	*
	* please add javascript onLoad attribute to body as follows:
	* onLoad="AllowMap()"
	*    otherwise map link will not function properly when using
	* browser 'go back' button
	*  -->

<body bgcolor="#F1EFE2">
<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/molossus1.jpeg" width="84"><!-- height="123"-->
    </td>
    <td width="45%">
      <h3><font color="#660000" face="Arial">&nbsp;Taxonomy Search Results...</font>
      </h3>
    </td>
    <td width="45%">
      <p align="right">
      	 <img border="0" src="images/boxbox2.jpg" width="100">
    </td>
  </tr>
</table>



<center>

<!--  ******************** TaxonomyBrowserResultsList Object ***************** -->
<?php

	require_once('../../../objects/amnh/mammalogy/TaxonomyResultsLists.php');

	$resultlist = new AmnhTaxonomyStandardResultsList();
	$resultlist->DisplayThumbnails = 0;
	$resultlist->Database = 'etaxonomy';
	$resultlist->DisplayPage = "TaxonomyDisplayPage.php";
	$resultlist->QueryPage = "TaxonomyQuery.php";
	$resultlist->BodyColor = '#F1EFE2';
	$resultlist->Width = '82%';
	$resultlist->HighlightColor = '#FFFFFF';
	$resultlist->HighlightTextColor = '#DDDDDD';
	$resultlist->FontFace = 'Arial';
	$resultlist->FontSize = '2';
	$resultlist->TextColor = '#660000';
	$resultlist->HeaderColor = '#660000';
	$resultlist->BorderColor = '#660000';
	$resultlist->HeaderTextColor = '#FFFFFF';
	$resultlist->ContactSheetPage = '';
	$resultlist->AlignData= 'center';
	$resultlist->NoResultsText = 'No speciments matched your search';

	$resultlist->Show();

?>
<!--  ******************** end TaxonomyBrowserResultsList Object ***************** -->

</center>

<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Arial"><font
color="#660000" size="1" face="Arial">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle"
width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Arial"><a
href="http://www.kesoftware.com/"><img alt="KE Software"
src="images/companylogo.gif" border="0" align="absmiddle" width="60"
height="50"></a><font size="1" color="#660000">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
</body>

</html>

