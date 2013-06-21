<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<title>KE EMu Taxonomy Search Result</title> 
	<style>
		.linkLikeButton {
			border: none;
			cursor: pointer;
			cursor: hand;
			text-decoration: underline;
			color: rgb(0,0,255);
			background-color: transparent;
			font-size: 90%;
		}
		.disabledLinkLikeButton {
			border: none;
			cursor: default;
			text-decoration: underline;
			color: rgb(127,127,127);
			background-color: transparent;
			font-size: 90%;
		}
	</style>
</head>

<!-- 	*
	* please add javascript onLoad attribute to body as follows:
	* onLoad="AllowMap()"
	*    otherwise map link will not function properly when using 
	* browser 'go back' button
	*  -->

<body bgcolor="#FFFFE8">
<img align=left border="0" src="images/column.jpg" width="84" height="120">
	<h3><font face="Tahoma" color="#336699">&nbsp;Search results...</font></h3>

<p>&nbsp;</p>
<center>

<!--  ******************** TaxonomyResultsList Object ***************** -->
<?php

	require_once('../../objects/taxonomy/TaxonomyResultsLists.php');

	$resultlist = new ModuleStandardResultsList();

	if (file_exists('../../webservices/mapper'))
	{
		$resultlist->mapperInstalled = 1;
	}
	else
	{
		$resultlist->mapperInstalled = 0;
	}

	$resultlist->allowMapper = 1;
	//$resultlist->mapperUrl = '../../objects/common/emuwebmap.php'; // old mapper
	$resultlist->mapperUrl = '../../webservices/mapper.php'; 
	$resultlist->newSearch = 'TaxonomyQuery.php';
	$resultlist->mapperDataSource = 'webnew';

	$resultlist->DisplayThumbnails = 1;
	$resultlist->DisplayPage = "TaxonomyDisplay.php";
	$resultlist->BodyColor = '#FFFFE8';
	$resultlist->Width = '80%';
	$resultlist->HighlightColor = '#FFFFFF';
	$resultlist->HighlightTextColor = '#DDDDDD';
	$resultlist->FontFace = 'Tahoma';
	$resultlist->FontSize = '2';
	$resultlist->TextColor = '#336699';
	$resultlist->HeaderColor = '#336699';
	$resultlist->BorderColor = '#336699';
	$resultlist->HeaderTextColor = '#FFFFE8';
	$resultlist->NoResultsText = 'Sorry... No Records matched your request';

	$resultlist->Show();
?>
<!--  ******************** end TaxonomyResultsList Object ***************** -->

</center>

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

<!--*
    *
    * $Revision: 1.1 $
    * $Date: 2007/02/26 22:55:47 $
    *
    *-->

</html>
