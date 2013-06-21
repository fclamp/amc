<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>

<body bgcolor="#FFFFE8">
<a href="http://www.art-museum.unimelb.edu.au">
<img align=left border="0" src="images/potterlogo.gif" width="125" height="125"></a>
      <h3><font face="Tahoma" color="#336699">&nbsp;Our Collection...</font></h3><br>

<p align=center>
<?php
require_once('../../objects/ipm/DisplayObjects.php');
$display = new IpmStandardDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#336699';
$display->BorderColor = '#336699';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFFFE8';
$display->HighlightColor = '#FFFFFF';

$display->Show();
?>
</p>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="15%" align="right"></td>
  </tr>
</table>

</body>

</html>
