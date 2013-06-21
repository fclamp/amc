<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
>Search the NYBG Collection...</title>
</head>

<body background="images/nybgbackground.jpg" bgcolor="#ffffff">
<div align="center"><img border="0" src="images/nybglogo.gif" width="499" height="30"></div>
<p>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
<td width="10%" nowrap><p align="center"><img border="0" src="images/nybg.jpg" width="387" height="276"></td>
   <td width="70%" valign="top"><font face="Tahoma"><b>Search The NYBG Collection...</b></font>

      <blockquote><font face="Tahoma">Welcome to the New York Botanical Gardens. </font></p>
  <p><font face="Tahoma">Use the Browse section to the right for a quick look at some of the specimens.</font></p>
    <p><font face="Tahoma">Key word searches can be performed in the main search box below.&nbsp;</font></blockquotep>
      </td>

    <td width="20%" valign="middle" align="center" bgcolor="#006400"><b><font size="3" face="Tahoma" color="#FFFFFF">&nbsp;
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
         <td width="50%" bgcolor="#FFFFFF"><font face="Tahoma" ><a href="<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>">
	  <img border="0" src="images/nybgweb1.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font color="#006400" face="Tahoma" size="2">Items
            with images</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFFF"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 12000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/nybgweb2.jpg" width="62" height="65"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#006400" size="2">Random
            pieces</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFFF"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/nybgweb3.jpg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#006400" size="2">Recent
            acquisitions</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</div>
<div align="center">
  <center>
<?php
require_once('../../objects/sam/QueryForms.php');

$queryform = new SamBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#006400';
$queryform->BodyColor = '#FFFFE8';
$queryform->HelpPage = '/emuwebnybg/pages/shared/help/BasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#336699">
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
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
