<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ advanced ]</title>
</head>

<body bgcolor="#FFFFE8">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/column.jpg" width="84" height="123"></td>
    <td width="45%"><font face="Tahoma" color="#336699" size="4"><b>Advanced Search<br>
      </b></font><font color="#336699" face="Tahoma">Enter any terms in the
      boxes below, select an area to search, then click the "Search"
button.&nbsp;</font></td>
    <td width="45%">
      <p align="right"></td>
  </tr>
</table>
<div align=right>
<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
$LangSelector->Show();
?>
</div>

<div align="center">
<?php
require_once('../../objects/gallery/QueryForms.php');
$queryform = new GalleryAdvancedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#336699';
$queryform->BorderColor = '#336699';
$queryform->BodyColor = '#FFFFE8';
$queryform->Show();
?>

</div>
<p align="center"><u><a href="Query.php"><font face="Tahoma">Basic search</font></a></u> <font color="#336699" face="Tahoma"> |
</font><u><a href="DtlQuery.php"><font face="Tahoma">Detailed search</font></a></u></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      � 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
<p align="center">&nbsp;</p>

</body>

</html>
