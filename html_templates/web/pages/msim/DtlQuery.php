<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ detailed ]</title>
</head>

<body bgcolor="#E0F5DF">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/column.jpg" width="84" height="123"></td>
    <td width="45%"><font face="Tahoma" color="#013567" size="4"><b>Detailed Search<br>
      </b></font><font color="#013567" face="Tahoma">Enter any terms in the
      boxes below and click on the "Search"
button. You should enter a minimum of one field. &nbsp; For other search types, select one of the options beneath the search
box.</font></td>
    <td width="45%" valign="top">
  </tr>
</table>
<div align="center">
<?php
require_once('../../objects/msim/QueryForms.php');
$queryform = new MsimDetailedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#013567';
$queryform->TitleTextColor = '#013567';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#DFF5E0';
$queryform->Show();
?>
</div>
<p align="center"><font color="#336699" face="Tahoma"><a href="Query.php">Back to Index</a> |
<a href="SimpleQuery.php">
Search</a></font></p>
</body>

</html>
