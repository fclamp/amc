<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<link REL="stylesheet" TYPE="text/css" href="amnh.css">
<title>Search Our AMNH Mammalogy Collection [ detailed ]</title>
</head>

<body bgcolor="#F1EFE2">
<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/bear.jpg" width="84"><!-- height="123"-->
    </td>
    <td width="45%"><font face="Arial" color="#660000" size="4"><b>Detailed Search<br>
      </b></font><font color="#660000" face="Arial">Enter any terms in the
      boxes below and click on the "Search"
button.&nbsp; For other search types, select one of the options beneath the search
box.</font></td>
    <td width="45%">
      <p align="right">
      	 <img border="0" src="images/boxbox2.jpg" width="100">
      </td>
    <td width="45%" valign="top">
      <p align="right">
<?php
require_once('../../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#660000';
$LangSelector->Show();
?>
</p></td>
  </tr>
</table>
<div align="center">
<?php
require_once('../../../objects/amnh/mammalogy/QueryForms.php');
$queryform = new AmnhDetailedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#660000';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#660000';
$queryform->BodyColor = '#F1EFE2';
$queryform->Show();
?>
</div>
<p align="center"><font color="#660000" face="Arial"><a href="Query.php">Basic search</a> |
<a href="AdvQuery.php">Advanced
search</a></font></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Arial"><font color="#660000" size="1">Powered
      by:</font><font size="2">&nbsp;&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Arial"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#660000">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
<p align="center">&nbsp;</p>

</body>

</html>
