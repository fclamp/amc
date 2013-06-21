<?php include "header-small.html" ?>

<body bgcolor="#AAC1C0">
<h4>
	<font face="Tahoma" color="#013567" size="2">
		Search results in our prototype display...<br>
  		Click on the catalog number (under the image) for detailed record information or click on the image for a larger version.<br>
		Over time more data and images will be made available.<br>
	</font> 
</h4>

<center>

  <?php
	require_once('../../../objects/nmnh/anth/ResultsLists.php');

	$resultlist = new NmnhAnthContactSheet;
	$resultlist->DisplayPage = "Display.php";
	$resultlist->ResultsListPage = "ResultsList.php";
	$resultlist->BodyColor = '#FFF3DE';
	$resultlist->Width = '80%';
	$resultlist->HighlightTextColor = '#DDDDDD';
	$resultlist->FontFace = 'Arial';
	$resultlist->FontSize = '2';
	$resultlist->TextColor = '#013567';
	$resultlist->HeaderColor = '#013567';
	$resultlist->BorderColor = '#013567';
	$resultlist->HeaderTextColor = '#013567';
	if ($ALL_REQUEST['ImagesOnly'] == "true")
        {
               	if ($resultlist->Restriction != '')
               	        $resultlist->Restriction .= " AND MulHasMultimediaInternet = \'y\'";
               	else
               	        $resultlist->Restriction = "MulHasMultimediaInternet = \'y\'";
        }
	$resultlist->Show();
?> 
  
</center>

<div align="left">
	<blockquote>&nbsp;</blockquote>
</div>
<blockquote>
	<p>
		<font face="Tahoma" color="#0000FF">
			<a href="Query.php"><b>Basic Search</b></a>
		</font>
		<font color="#000000">
			&nbsp; |&nbsp;&nbsp;
		</font>
		 <font face="Tahoma" color="#0000FF">
                                <a href="AdvQuery.php"><b><u>Advanced Search</u></b></a>
		</font>
		<font color="#000000">
			&nbsp; |&nbsp;&nbsp;
		</font>
		<font face="Tahoma" color="#0000FF">
			<a href="DtlQuery.php"><b>Detailed Search</b></a>
		</font>
	</p>
</blockquote>



<p align="left"><?php include "footer.php" ?></p>
</body>

</html>

