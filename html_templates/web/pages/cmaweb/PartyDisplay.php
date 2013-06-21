<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>

<body bgcolor="#b5b6b5">
<img align=left border="0" src="images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#336699">&nbsp;Carnegie Museum of Art</font></h3><br>

<p align=center>
<?php
require_once('../../objects/cmaweb/DisplayObjects.php');
$display = new CmaPartyDisplay;
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
    <td width="40%" valign="middle" align="center"><font color="#336699" size="1" face="Tahoma">Powered
      by: <img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"> 
      © 2000, 2001 KE Software.&nbsp;</font></td>
  </tr>
</table>

</body>

</html>
