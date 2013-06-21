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

<body  bgcolor="#ffffe8"
        onLoad="AllowMap()">

	<img align=left border="0" src="images/column.jpg" width="84" height="120">
	<h3><font face="Arial" color="#336699">&nbsp;Taxonomy Search Results...</font></h3>


<center>

<!--  ******************** TaxonomyBrowserResultsList Object ***************** -->
<?php

	require_once('../../objects/common/TaxonomyBrowserResultsList.php');

	$resultlist = new TaxonomyStandardResultsList();

	$resultlist->allowMapper = 1;
	$resultlist->mapperUrl = '../../objects/common/emuwebmap.php';
	$resultlist->newSearch = 'TaxonomyQuery.php';
	$resultlist->mapperDataSource = 'mv';

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
<!--  ******************** end TaxonomyBrowserResultsList Object ***************** -->

</center>

</body>

<!--*
    *
    * $Revision: 1.2 $
    * $Date: 2004/06/10 04:03:26 $
    *
    *-->


</html>

