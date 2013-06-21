<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search AMNH Mammalogy Collection...</title>
<link REL="stylesheet" TYPE="text/css" href="amnh.css">
</head>

<body>
<!--
<body bgcolor="#F1EFE2">
-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <table>
      <tr> <td><img border="0" src="images/boxbox2.jpg" width="171"> </td> </tr>
      <tr> <td><img border="0" src="images/bear.jpg" width="171"><!--height="242"--> </td> </tr>
      </table>
      </td>
    <td width="70%" valign="top"><font face="Arial" size="5" color="#660000"><b>Search
      AMNH Mammalogy Collection...</b></font>
      <p><font color="#660000" size="2" face="Arial">Welcome to our
      collection's live search page.&nbsp; Here you can find out everything you want to
      know our collection and its contents.</font></p>
      <p><font color="#660000" size="2" face="Arial">Popular searches are
      available in the Quick Browse section to the right.</font></p>
      <p><font color="#660000" size="2" face="Arial">Key word searches can be
      performed in the main search box below.&nbsp;</font></p>
    </td>
    <td width="20%" valign="middle" bgcolor="#660000"><b><font size="2" face="Arial" color="#FFFFFF">&nbsp;Quick
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#F1EFE2"><font face="Arial"><a href="<?php
require_once('../../../objects/common/PreConfiguredQuery.php');
require_once('../../../objects/amnh/mammalogy/DefaultPaths.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y' AND CatPrefix = 'M'";
$MediaLink->PrintRef();
?>">
	  <img border="0" src="images/koala.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#F1EFE2" nowrap><font color="#660000" face="Arial" size="2">Items
            with images</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#F1EFE2"><font face="Arial"><a href="
<?php
require_once('../../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 747656;
$RandomQry->Restriction = "CatPrefix = 'M'";
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/bone.jpg" width="62" height="65"></a></font></td>
          <td width="50%" bgcolor="#F1EFE2" nowrap><font face="Arial" color="#660000" size="2">Random pieces</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#F1EFE2"><font face="Arial"><a href="
<?php
/* Build up the a query string for the $where, as the $QueryTerm does not support
** non text field search.
*/
$numDays = 7;
$conJun = " OR ";
$queryString = "";
$field = "AdmDateModified=date'"; // so can change to other fields easier.
$fEnd = "'";		// if field not date, should be empty string.
for($i = 0; $i < $numDays; $i++)
{
	$date=date('m/d/Y', strtotime('-' . $i . 'days'));
	if ($queryString == "")
		$queryString = $field . $date . $fEnd;
	else
		$queryString = $queryString . $conJun . $field . $date . $fEnd;
}
$queryString = "(" . $queryString . ") AND CatPrefix = 'M'";
$PreConfQry = new PreConfiguredQueryLink;
$PreConfQry->Where = $queryString;
$PreConfQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/phyllostomus1.jpeg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#F1EFE2" nowrap><font face="Arial" color="#660000" size="2">Records modified <br>in the last 7 days</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align=right>
<?php
require_once('../../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
//$LangSelector->FontColor = '#660000';
$LangSelector->Show();
?>
</div>
<div align="center">
  <center>
<?php
require_once('../../../objects/amnh/mammalogy/QueryForms.php');
$queryform = new AmnhBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
/*
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#660000';
$queryform->BodyColor = '#F1EFE2';
*/
$queryform->HelpPage = 'AmnhBasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Arial"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#660000">
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Arial"><font color="#660000" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Arial"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#660000">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
