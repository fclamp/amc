<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>La Search Our Collection...</title>
</head>

<body bgcolor="#FFFFE8">
<p align="center"><img border="0" src="images/pi_civilization.gif" width="270" height="42"></p>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td nowrap valign="top">
      <p align="center"><img border="0" src="images/logo_s.gif" width="88" height="28"></td>
    <td width="70%" valign="top"><font face="Tahoma" size="5" color="#003399">
     <blockquote><b>Search Our Collection...</b></font>
      <p><font color="#003399" size="2" face="Tahoma">Welcome to Canadian Museum of Civilizations 
      online collection's search page.&nbsp;</p>
      <p>Popular searches are available in the Quick Browse section to the right.</p>
      <p>Enter a term or terms into the keywords text box. This search will query 26 unique fields of artifact information.</p>
      <p>To search for an artist's name or to search in context you must use the advanced search option. <a href="DtlQuery.php">Detailed Search</a></p></font></p></blockquote>
    </td>
    <td width="20%" valign="middle" bgcolor="#003399"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick
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
          <td width="50%" bgcolor="#FFFFE8" nowrap><font color="#003399" face="Tahoma" size="2">Items
            with images</font></td>
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
	  <img border="0" src="images/face.jpg" width="62" height="65"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#003399" size="2">Random
            pieces</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/world.jpg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#003399" size="2">Recent
            acquisitions</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div align=right>
<?php
require_once('../../objects/cmcc/CMCCLanguageSelector.php');
$LangSelector = new CmccLanguageSelector;
$LangSelector->Language = "English";
$LangSelector->Show();

?>
</div>

<div align="center">
  <center>
<?php
require_once('../../objects/cmcc/QueryForms.php');
$queryform = new CmccBasicQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->LanguageData = "english";
$queryform->LanguagePrompts = "english";
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#003399';
$queryform->BodyColor = '#ffffe8';
$queryform->HelpPage = '/emuweb/examples/shared/help/CmccBasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><!--<font face="Tahoma"><u><font color="#0000FF"><a href="AdvQueryFrench.php">Advanced
search</a></font></u><font color="#003399">
| --></font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
<!--<p align="center">&nbsp;</p>-->
<table border="0">
  <tr>
     <td width="31%" align="center"></td>
     <td>
        <font FACE="Arial, Helvetica" SIZE="1" COLOR="003300">
        Reproduction prohibited without the written permission of the Canadian Museum of Civilization Corporation  
        <BR> Please <a href="">contact us</a> for more information on the reproductions and permissions.</font>
     </td>
  </tr>
</table>

<TABLE border="0">
  <TR>
     <td width="45%" align="center"></td>
     <TD>
        <br>
        <FONT FACE="Arial, Helvetica" SIZE="1" COLOR="000000">
                Created: October 3 1997. Last update: September 27 2001 
                <BR>© Canadian Museum of Civilization Corporation 
        </FONT>
     </TD>
  </TR>
</TABLE>




<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#003399" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
