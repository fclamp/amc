<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search Our Collection [ detailed ]</title>
</head>

<body bgcolor="#0080C0">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/Beryl4-small.jpg" width="84" height="123"></td>
    <td width="45%"><font face="Tahoma" color="#FFFF99" size="4"><b>Detailed Search<br>
      </b></font><font color="#FFFF99" face="Tahoma">Enter any terms in the
      boxes below and click on the "Search"
button.&nbsp; For other search types, select one of the options beneath the search
box.</font></td>
  </tr>
</table>
<div align="center">
<?php
require_once('../../objects/nhm/MineralogyQueryForms.php');
$queryform = new MineralogyDetailedQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->Intranet = 1;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#003399';
$queryform->BorderColor = '#003399';
$queryform->BodyColor = '#FFFFCC';
$queryform->Show();
?>
</div>
<p align="center"><font color="#336699" face="Tahoma"><a href="Query.php">Basic search</a> |
<a href="AdvQuery.php">Advanced
search</a></font></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#FFFFFF" size="1">Powered
      by:</font><font size="2">&nbsp;&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#FFFFFF">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
<p align="center">&nbsp;</p>

</body>

</html>
