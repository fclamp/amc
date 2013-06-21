<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<!-- ********** Generate a useful title using PHP ************** -->
	<title>
		<--?php
		require_once('../../objects/nmnh/TaxonomyResultsLists.php');
		$resultListTitle = new TaxonomyResultsListTitle('Standard Search');
		$resultListTitle->Show();
		?-->
	</title> 
	<!-- ********** end Generate a useful title using PHP ************** -->
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

<body  bgcolor="#ffffe8" 
	onLoad="AllowMap()">
	<h3><font face="Arial" color="#336699">&nbsp;Taxonomy Search Results...</font></h3>


<center>

<!--  ******************** TaxonomyResultsList Object ***************** -->
<?php

	require_once('../../objects/nmnh/TaxonomyResultsLists.php');

	$resultlist = new TaxonomyStandardResultsList();

	$resultlist->allowMapper = 1;
	//$resultlist->mapperUrl = '../../objects/common/emuwebmap.php'; // old mapper
	$resultlist->mapperUrl = '../../webservices/mapper.php'; 
	$resultlist->newSearch = 'TaxonomyQuery.php';
	$resultlist->mapperDataSource = 'webnew';

	$resultlist->DisplayThumbnails = 1;
	$resultlist->DisplayPage = "TaxonomyDisplayPage.php";
	$resultlist->BodyColor = '#FFFFE8';
	$resultlist->Width = '82%';
	$resultlist->HighlightColor = '#FFFFFF';
	$resultlist->HighlightTextColor = '#DDDDDD';
	$resultlist->FontFace = 'Arial';
	$resultlist->FontSize = '2';
	$resultlist->TextColor = '#336699';
	$resultlist->HeaderColor = '#336699';
	$resultlist->BorderColor = '#336699';
	$resultlist->HeaderTextColor = '#FFFFFF';
	$resultlist->NoResultsText = 'Sorry... No Records matched your request';

	$resultlist->Show();

?>
<!--  ******************** end TaxonomyResultsList Object ***************** -->

</center>

</body>

<!--*
    *
    * $Revision: 1.3 $
    * $Date: 2006/10/18 05:20:13 $
    *
    *-->


</html>

