<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Taxonomy [ detailed ]</title>
</head>

<body bgcolor="#AAC1C0">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/column.jpg" width="84" height="123"></td>
    <td width="45%"><font face="Arial" color="#013567" size="4"><b>Detailed Search<br>
      </b></font><font color="#013567" face="Arial">Enter any terms in the
      boxes below and click on the "Search"
button.&nbsp; For other search types, select one of the options beneath the search
box.</font></td>
    <td width="45%" valign="top">
  </tr>
</table>
<div align="center">
<?php
require_once('../../objects/common/TaxonomyQueryForms.php');
$queryform = new MapperDetailedQueryForm;
$queryform->FontFace = 'Arial';
$queryform->Width = '670';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#013567';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?>
</div>
<p align="center"><font color="#336699" face="Arial"><a href="TaxonQuery.php">Basic search</a> |
<a href="TaxonAdvQuery.php">Advanced
search</a></font></p>
</body>

</html>
