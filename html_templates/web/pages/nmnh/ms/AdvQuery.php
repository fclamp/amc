<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>NMNH Mineral Sciences -  Advanced Collections Search</title>
</head>

<body bgcolor="#AAC1C0">


<table width="560" border="0" cellspacing="0" cellpadding="0">
  <tr align="left" valign="top" bgcolor="#FFFFFF"> 
    <td colspan="2" height="45"> <img src="images/minsci_cat_banner_sm.jpg" width="527" height="44"></td>
  </tr>
  </table>






<table border="0" width="59%" cellspacing="0" cellpadding="8">
  <tr> 
    <td width="12%" nowrap align="center" valign="top"> 
      <p align="center"><img src="images/mexian_fire_opal_sm.jpg" width="120" height="157"> 
    </td>
    <td width="88%" align="left" valign="top"><font face="Arial" color="#013567" size="4"> 
      <b>Advanced Search of the <br>
      Mineral Science Collections<br>
      </b></font><font color="#013567" face="Arial"><br>
      Enter any terms in the boxes below as instructed, select an area of the 
      database to search, then click the "Search" button.<br>
      <br>
      Please note: These searches may take a while, please be patient.</font></td>
  </tr>
</table>


<div align="left">

<?php
require_once('../../../objects/nmnh/ms/QueryForms.php');
$queryform = new NmnhMinsciAdvancedQueryForm;
$queryform->Title = 'Enter search term(s)...';
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->FontFace = 'Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#003063';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?>




</div>


<BLOCKQUOTE> 
  <p align="left"> <u><a href="Query.php"><font face="Arial">Basic search</font></a></u> 
    <font color="#336699" face="Arial"> | </font><u><a href="DtlQuery.php"><font face="Arial">Detailed 
    search</font></a></u></p>
</BLOCKQUOTE>

<?php 
include "minscifooter.php" 
?>










</body>

</html>
