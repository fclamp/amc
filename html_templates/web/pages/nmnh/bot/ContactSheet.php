<?php include "header-small.html" ?>

<body bgcolor="#AAC1C0">
<h4>
	<font face="Tahoma" color="#013567" size="2">
		Search results in our prototype display...<br>
  		Click on "Detailed View" (under the image) for detailed record information or click on the image for a larger version.<br>
		Over time more data and images will be made available.<br>
	</font> 
</h4>

<center>
	<?php
		require_once('../../../objects/nmnh/bot/ResultsLists.php');
	
		$resultlist = new NmnhBotanyContactSheet;
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



<p align="left"><?php include "footer.php" ?></p>
</body>

</html>

