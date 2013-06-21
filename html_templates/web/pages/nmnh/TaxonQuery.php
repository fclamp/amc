<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Taxonomy...</title>
</head>

<body bgcolor="#AAC1C0">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><font face="Tahoma"><img border="0" src="images/column.jpg" width="171" height="242"></font></td>
    <td width="70%" valign="top"><font face="Tahoma" size="5" color="#003063"><b>Search Taxonomy...</b></font>
      <p><font color="#013567" size="2" face="Tahoma">Welcome to our
      collection's live search page.&nbsp;</font></p>
      <p><font color="#013567" size="2" face="Tahoma">Popular searches are
      available in the Quick Browse section to the right.</font></p>
      <p><font color="#013567" size="2" face="Tahoma">Key word searches can be
      performed in the main search box below.&nbsp;</font></p>
    </td>
    <td width="20%" valign="middle" bgcolor="#013567"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#FFF3DE"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/disk.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#FFF3DE" nowrap><font color="#336699" face="Tahoma" size="2">Items
            with images</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFF3DE"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 12000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/face.jpg" width="62" height="65"></a></font></td>
          <td width="50%" bgcolor="#FFF3DE" nowrap><font face="Tahoma" color="#336699" size="2">Random
            items</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFF3DE"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/world.jpg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#FFF3DE" nowrap><font face="Tahoma" color="#336699" size="2">Recent
            additions</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<br>
<br>
<div align="center">
  <center>
<?php
require_once('../../objects/common/TaxonomyQueryForms.php');

$queryform = new MapperBasicQueryForm;
$queryform->FontFace = 'Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#0000FF"><a href="TaxonAdvQuery.php">Advanced
search</a></font></u><font color="#336699">
| </font><font color="#0000FF"><u><a href="TaxonDtlQuery.php">Detailed search</a></u></font></font></p>

</body>

</html>
