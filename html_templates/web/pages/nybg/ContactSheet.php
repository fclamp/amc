<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>
</head>

<body background="images/nybgbackground.jpg" bgcolor="#ffffff">
<div align="center"><img border="0" src="images/nybglogo.gif" width="499" height="30"></div>
      <h3><font face="Tahoma" color="#006400">&nbsp;Search results...</font></h3>

<center>
<?php
require_once('../../objects/nybg/ResultsLists.php');

$resultlist = new NybgContactSheet;
$resultlist->BodyColor = '#FFFFFF';
$resultlist->Width = '80%';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#006400';
$resultlist->HeaderColor = '#006400';
$resultlist->BorderColor = '#006400';
$resultlist->HeaderTextColor = '#FFFFFF';
$resultlist->Show();
?>
</center>
<br><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>

