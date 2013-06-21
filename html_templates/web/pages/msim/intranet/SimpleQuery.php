<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search Our Collection [ detailed ]</title>
</head>
<body bgcolor="#FFFFFF">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="../images/column.jpg" width="84" height="123"></td>
    <td width="45%"><font face="Tahoma" color="#013567" size="4"><b>Simple Search<br>
      </b></font><font color="#013567" face="Tahoma">Enter any terms in the
      boxes below and click on the "Search"
button.&nbsp; For other search types, select one of the options beneath the search
box.</font></td>
    <td width="45%" valign="top">
  </tr>
</table>
<div align="center">
<?php
require_once('../../../objects/msim/SimpleQueryForm.php');
$queryform = new MsimIntranetSimpleQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#013567';
$queryform->TitleTextColor = '#DFF5E0';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#DFF5E0';
$queryform->Show();
?>
</div>
<p align="center"><font color="#336699" face="Tahoma"><a href="../Query.php">Back to Index</a> |
<a href="DtlQuery.php">
Research</a></font></p>
</body>

</html>
