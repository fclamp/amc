<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Display</title>
</head>
<body bgcolor="#0080C0">
<img align=left border="0" src="images/Beryl4-small.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#FFFF99">&nbsp;Our Collection...</font></h3><br>

<p align=center>
<?php
require_once('../../objects/nhm/MineralogyDisplayObjects.php');
$display = new MineralogyStandardDisplay;
$display->Intranet = 1;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#003399';
$display->BorderColor = '#003399';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#FFFFCC';
$display->HighlightColor = '#FFFFFF';
$display->Show();
?>
</p>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#FFFFFF" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#FFFFFF">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
