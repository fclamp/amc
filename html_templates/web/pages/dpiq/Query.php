<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection...</title>
</head>

<body bgcolor="#FFFFE8">

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%" nowrap>
      <p align="left" valign="top"><font face="Tahoma"><img border="0" src="images/column.jpg" width="110" height="150"></font></td>
    <td width="60%" valign="top"><font face="Tahoma" size="5" color="#336699">
    <b>QUEENSLAND PLANT DISEASE DATABASE</b></font>
    <!--p><b><font face="Tahoma" size="4" color="#336699">Search Our Collection...</b></font> -->
      <p><font color="#336699" size="2" face="Tahoma">Welcome to our
      collection's live search page.&nbsp; Here you can find out everything you want to
      know about our collection and its contents.</font></p>
      <p><font color="#336699" size="2" face="Tahoma">Popular searches are
      available in the Quick Browse section to the right.</font></p>
      <p><font color="#336699" size="2" face="Tahoma">Key word searches can be
      performed in the main search box below.&nbsp;</font></p>
    </td>

   <!--  bgcolor="#336699"-->
    <!--td width="20%" valign="middle"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick-->

    <td width="10%" valign="middle"><b><font size="2" face="Tahoma" color="#336699">&nbsp;Quick Browse</font>
      </b>
      <table border="1" width="98%" cellspacing="1" cellpadding="3">
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
	  <img border="0" src="images/disk.jpg" width="43" height="44"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font color="#336699" face="Tahoma" size="2">&nbsp;Items
            with <br>&nbsp;images</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 12000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/face.jpg" width="43" height="44"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#336699" size="2">&nbsp;Random
           <br>&nbsp;pieces</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
$pastdate = date("d-m-Y", mktime (0,0,0,1,1,  date("Y")-2));
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "ColCollectionDate > DATE '" . $pastdate . "'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/world.jpg" width="43" height="44"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#336699" size="2">&nbsp;Recent
            <br>&nbsp;acquisitions</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align=right>
<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
$LangSelector->Show();
?>
</div>
<div align="center">
  <center>
<?php
require_once('../../objects/dpiq/QueryForms.php');

//$queryform = new DpiqBasicQueryForm;
$queryform = new DpiqDetailedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#336699';
$queryform->BorderColor = '#336699';
$queryform->BodyColor = '#ffffe8';
$queryform->HelpPage = '/emuweb/examples/shared/help/DpiqBasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<!--p align="center"><font face="Tahoma"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced-->
<!--search</a></font></u><font color="#336699">-->
<!--| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>-->
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
