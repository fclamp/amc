<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>
</head>

<body bgcolor="#FFFFE8">
<a href="http://www.art-museum.unimelb.edu.au">
<img align=left border="0" src="images/potterlogo.gif" width="125" height="125"></a>
      <h3><font face="Tahoma" color="#336699">&nbsp;Search results...</font></h3>

<center>
<?php
require_once('../../objects/ipm/ResultsLists.php');

$resultlist = new IpmContactSheet;
$resultlist->BodyColor = '#FFFFE8';
$resultlist->Width = '80%';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#336699';
$resultlist->HeaderColor = '#336699';
$resultlist->BorderColor = '#336699';
$resultlist->HeaderTextColor = '#FFFFE8';
$resultlist->Show();
?>
</center>
<br><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="15%" align="right"></td>
  </tr>
</table>

</body>

</html>

