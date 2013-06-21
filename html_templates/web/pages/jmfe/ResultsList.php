<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>JMFE Archives - Search Results</title>
</head>

<body bgcolor="#FFFFFF">
<a href="http://www.jimmoranfoundation.org/"><img border="0" src="images/JimMoranLogo.jpg"></a>
<br>      
<h3><font face="Times New Romans" color="black">Search results...</font></h3>
<align = "left">
<?php
require_once('../../objects/jmfe/ResultsLists.php');

$resultlist = new jmfeStandardResultsList;
$resultlist->BodyColor = 'white';
$resultlist->Width = '700';
$resultlist->HighlightColor = '#FFFFFF';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Times New Romans';
$resultlist->FontSize = '2';
$resultlist->TextColor = 'black';
$resultlist->HeaderColor = 'black';
$resultlist->BorderColor = 'black';
$resultlist->HeaderTextColor = 'white';
$resultlist->KeepImageAspectRatio = 1;
$resultlist->Show();
?>


</body>

</html>

