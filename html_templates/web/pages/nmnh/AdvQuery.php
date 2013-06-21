<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ advanced ]</title>
</head>

<body bgcolor="#AAC1C0">
<? include "nmnh_mcs_header.html" ?><br>
<table border="0" width="67%" cellspacing="0" cellpadding="8">
  <tr> 
    <td width="20%" nowrap> 
      <p align="center"><img src="images/secondary_nmnh_mall.jpg" width="127" height="169"> 
    </td>
    <td width="80%" valign="top"><font face="Arial" color="#013567" size="4"><b>Advanced 
      Search of the Collections<br>
      </b></font><font color="#013567" face="Arial"><br>
      Enter any terms in the boxes below as instructed, select an <br>
      area of the database to search, then click the "Search" button. <br>
      <br>
      Please note: These searches may take a while, please be patient.</font></td>
  </tr>
</table>

<blockquote> 
  <blockquote>
    <div align="left"><br>
      <?php
require_once('../../objects/nmnh/QueryForms.php');
$queryform = new NmnhAdvancedQueryForm;
$queryform->Title = 'Enter search term(s)...';
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->FontFace = 'Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#003063';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?> </div>
    <p><u><a href="Query.php"><font face="Arial">Basic search</font></a></u> <font color="#336699" face="Arial"> 
      | </font><u><a href="DtlQuery.php"><font face="Arial">Detailed search</font></a></u></p>
    <p><? include "nmnh_mcs_footer.html" ?></p>
  </blockquote>
</blockquote>
</body>

</html>
