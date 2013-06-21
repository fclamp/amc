<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection...</title>
</head>

<body bgcolor="#b5b6b5">
<img border="0" src="images/cma.jpg" width="575" height="67">
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/column.jpg" width="171" height="215"></td>
    <td width="70%" valign="top"><font face="Tahoma" size="5"><b>Search The CMA Collection...</b></font>
      <blockquote><font size="2" face="Tahoma">Welcome to the Carnegie Museum of Art
      search page.&nbsp; Search for and view details on items in our collection.</font></p>
      <p><font size="2" face="Tahoma">Popular searches are available in the Quick Browse section to the right.</font></p>
      <p><font size="2" face="Tahoma">Key word searches can be
      performed in the main search box below.&nbsp;</font></blockquotep>
    </td>
    <td width="20%" valign="middle" bgcolor="#336699"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/disk.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font color="#336699" face="Tahoma" size="2"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  Items with images</a></font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1000000;
$RandomQry->UpperIRN = 1500000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/face.jpg" width="62" height="65"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#336699" size="2">
	  <a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1000000;
$RandomQry->UpperIRN = 1040000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  Random pieces</a></font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "AcqDateAuthorised like DATE '2001' or AcqDateAuthorised like DATE '2002' or AcqDateAuthorised like DATE '2003' or AcqDateAuthorised like DATE '2004'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/world.jpg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#336699" size="2"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "AcqDateAuthorised like DATE '2001' or AcqDateAuthorised like DATE '2002' or AcqDateAuthorised like DATE '2003' or AcqDateAuthorised like DATE '2004'";
$MediaLink->PrintRef();
?>
	  ">
	  Recent acquisitions</a></font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "LocLocationPublishWebNoPass = 'Yes'"; 
$MediaLink->PrintRef();
?>
          ">
          <img border="0" src="images/view.gif" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#336699" size="2"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "LocLocationPublishWebNoPass = 'Yes'";
$MediaLink->PrintRef();
?>
          ">
          What's On View</a></font></td>
       </tr>
      </table>
    </td>
  </tr>
</table>
<!--
<div align=right>
<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
$LangSelector->Show();
?>
</div>-->
<div align="center">
  <center>
<?php
require_once('../../objects/cmaweb/QueryForms.php');

$queryform = new CmaBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#336699';
$queryform->BodyColor = '#ffffe8';
$queryform->HelpPage = '/emuweb/examples/shared/help/CmaBasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#336699">
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
<p align="center">
    <font face="Tahoma"><font color="#336699" size="1">Powered by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font>
</p>
</body>

</html>
