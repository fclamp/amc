<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search results</title>
</head>

<body bgcolor="#FFFFFF">
<h3><font face="Tahoma" color="#000000">&nbsp;Search results...</font></h3>

<center>
<?php
require_once('../../objects/galleryuk/ResultsLists.php');

$resultlist = new GalleryUKContactSheet;
$resultlist->ResultsListPage = 'ResultsList.php';
$resultlist->DisplayPage = 'Display.php';
$resultlist->BodyColor = '#FFFFFF';
$resultlist->Width = '80%';
$resultlist->HighlightTextColor = '#EEEEEE';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#000000';
$resultlist->HeaderColor = '#FFFFFF';
$resultlist->BorderColor = '#EEEEEE';
$resultlist->HeaderTextColor = '#000000';
$resultlist->DisplayPage = 'Display.php';
$resultlist->ResultsListPage = 'ResultsList.php';
$resultlist->Show();
?>
</center>
<br><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#000000" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#000000">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>

