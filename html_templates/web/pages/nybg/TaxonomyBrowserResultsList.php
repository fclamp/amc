<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<!-- ********** Generate a useful title using PHP ************** -->
	<title>
		<?php
		require_once('../../objects/common/TaxonomyBrowserResultsList.php');
		$resultListTitle = new TaxonomyBrowserResultsListTitle('Standard Search');
		$resultListTitle->Show();
		?>
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

<!--	*
	* please add javascript onLoad attribute to body as follows:
	* onLoad="AllowMap()"
	*    otherwise map link will not function properly when using
	* browser 'go back' button
	*  -->

<body background="images/nybgbackground.jpg" bgcolor="#ffffff"
        onLoad="AllowMap()">

	<img align=left border="0" src="images/nybg.jpg" width="84" height="120">
	<h3><font face="Arial" color="#006400">&nbsp;Taxonomy Search Results...</font></h3>


<center>

<!--  ******************** TaxonomyBrowserResultsList Object ***************** -->
<?php

	require_once('../../objects/common/TaxonomyBrowserResultsList.php');

	$resultlist = new TaxonomyStandardResultsList();

	$resultlist->allowMapper = 1;
	$resultlist->mapperUrl = '../../objects/common/emuwebmap.php';
	$resultlist->newSearch = 'TaxonomyQuery.php';
	$resultlist->mapperDataSource = 'nybg';

	$resultlist->DisplayThumbnails = 1;
	$resultlist->DisplayPage = "TaxonomyDisplayPage.php";
	$resultlist->BodyColor = '#FFFFE8';
	$resultlist->Width = '82%';
	$resultlist->HighlightColor = '#FFFFFF';
	$resultlist->HighlightTextColor = '#DDDDDD';
	$resultlist->FontFace = 'Arial';
	$resultlist->FontSize = '2';
	$resultlist->TextColor = '#006400';
	$resultlist->HeaderColor = '#006400';
	$resultlist->BorderColor = '#006400';
	$resultlist->HeaderTextColor = '#FFFFFF';
	$resultlist->NoResultsText = 'Sorry... No Records matched your request';

	$resultlist->Show();

?>
<!--  ******************** end TaxonomyBrowserResultsList Object ***************** -->

</center>

</body>

<!--*
    *
    * $Revision: 1.1 $
    * $Date: 2004/02/12 07:07:12 $
    *
    *-->


</html>

