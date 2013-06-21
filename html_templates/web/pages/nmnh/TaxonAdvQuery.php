<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Taxonomy [ advanced ]</title>
</head>

<body bgcolor="#AAC1C0">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/column.jpg" width="84" height="123"></td>
    <td width="45%"><font face="Arial" color="#013567" size="4"><b>Advanced Search<br>
      </b></font><font color="#013567" face="Arial">Enter any terms in the
      boxes below, select an area to search, then click the "Search"
button.&nbsp;</font></td>
    <td width="45%">
      <p align="right"></td>
  </tr>
</table>

<div align="center">
<?php
require_once('../../objects/common/TaxonomyQueryForms.php');
$queryform = new MapperAdvancedQueryForm;
$queryform->FontFace = 'Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#003063';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?>
</div>

<p align="center"><u><a href="TaxonQuery.php"><font face="Arial">Basic search</font></a></u> <font color="#336699" face="Arial"> |
</font><u><a href="TaxonDtlQuery.php"><font face="Arial">Detailed search</font></a></u></p>

</body>

</html>
