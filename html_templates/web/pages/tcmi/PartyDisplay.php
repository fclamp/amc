<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>

<body bgcolor="#FFFFFF">
<table width="650" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <th scope="col"><div align="left"><font face="Arial, Helvetica, sans-serif" color="#003399">Our Collection...</font></div></th>
  </tr>
  <tr>
    <td><?php
require_once('../../objects/tcmi/DisplayObjects.php');
$display = new TcmiPartyDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->BodyTextColor = '#003399';
$display->BorderColor = '#003399';
$display->HeaderTextColor = '#FFFFFF';
$display->BodyColor = '#CFE6F5';
$display->HighlightColor = '#FFFFFF';
$display->Show();
?></td>
  </tr>
</table>

<br><br>
<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000, 2001 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
