<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<link REL="stylesheet" TYPE="text/css" href="amnh.css">
<title>Display</title>
</head>

<body bgcolor="#F1EFE2">
<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/bear.jpg" width="84"><!-- height="123"-->
    </td>
    <td width="45%"><font face="Arial" color="#660000" size="4"><b>Detailed Search<br>
      </b></font><font color="#660000" face="Arial">&nbsp;Our Collection...</font></td>
    <td width="45%">
      <p align="right">
      	 <img border="0" src="images/boxbox2.jpg" width="100">
    </td>
  </tr>
</table>

<p align=center>
<?php
require_once('../../../objects/amnh/mammalogy/DisplayObjects.php');
$display = new AmnhPartyDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#660000';
$display->BorderColor = '#660000';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#F1EFE2';
$display->HighlightColor = '#FFFFFF';
$display->Show();
?>
</p>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Arial"><font color="#660000" size="1" face="Arial">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Arial"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#660000">Copyright
      � 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
