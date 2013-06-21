<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results (Natural History)</title>
</head>

<body bgcolor="#FFFFE8">
<img align=left border="0" src="../images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#336699">&nbsp;Tepapa Natural History search results...</font></h3>

<p>&nbsp;</p>

<center>
<?php
require_once('../../../objects/tepapa/natural/ResultsLists.php');

$resultlist = new TePapaStandardResultsList;
$resultlist->ContactSheetPage = "ContactSheet.php";
$resultlist->DisplayPage = "Display.php";
$resultlist->Intranet = 1;
$resultlist->BodyColor = '#FFFFE8';
$resultlist->Width = '80%';
$resultlist->HighlightColor = '#FFFFFF';
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
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="../images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="../images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>

