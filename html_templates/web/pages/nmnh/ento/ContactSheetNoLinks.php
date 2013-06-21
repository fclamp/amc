<?php include "header-small.html" ?>

<body bgcolor="#AAC1C0">
<h4><font face="Arial" color="#013567"><b>Search results </b> in our prototype 
  Contact Sheet display... <br>
  <font face="Arial" color="#013567"><font size="2">Click on the Catalog Number 
  (under the image) for detailed record information,<br>
  </font><font face="Arial" color="#013567"><font size="2">or click on the image 
  for a larger version.</font></font> </font><font size="2"> Over time more data 
  and images will<br>
  be made available.</font></font></h4>
<center>
  <?php
require_once('../../../objects/nmnh/iz/ResultsLists.php');

$resultlist = new NmnhIzContactSheetNoLinks;
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
$resultlist->Show();
?> 
  
</center>



<p align="left"><?php include "footer.php" ?></p>
</body>

</html>

