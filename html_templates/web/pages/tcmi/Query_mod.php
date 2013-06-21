<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection...</title>
</head>

<body bgcolor="#FFFFFF">
<p align="center">&nbsp;</p>
<table width="650" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr>
    <td nowrap valign="top">
      <p align="center"></td>
    <td width="70%" valign="top"><font face="Tahoma" size="5" color="#003399">
     <blockquote><b>Search Our Collection...</b></font>
      <p><font color="#003399" size="2" face="Tahoma">Welcome to The Children's Museum of Indianapolis
      online collection's search page.&nbsp;</p>
      <p>Popular searches are available in the Quick Browse section to the right.</p>
      <p>Key word searches can be performed in the main search box below.&nbsp; Use the <a href="AdvQuery.php">Advanced Query</a> form for boolean searches. The <a href="DtlQuery.php">Detailed Search</a> form provides searching on a field by field basis.</font></p>
      <p>&nbsp;</p>
    </blockquote></td>
    <td><table width="98" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#003399">
        <td colspan="2"><div align="center"><b><font size="2" face="Tahoma" color="#FFFFFF">Quick Browse</font></b></div></td>
      </tr>
      <tr>
        <td width="50%" bgcolor="#FFFFFF"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  "> <img border="0" src="images/disk.jpg" width="63" height="64"></a></font></td>
        <td width="50%" bgcolor="#FFFFFF" nowrap><font color="#003399" face="Tahoma" size="2">Items with images</font></td>
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
	  "> <img border="0" src="images/face.jpg" width="62" height="65"></a></font></td>
        <td width="50%" bgcolor="#FFFFFF" nowrap><font face="Tahoma" color="#003399" size="2">Random pieces</font></td>
      </tr>
      <tr>
        <td width="50%" bgcolor="#FFFFFF"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  "> <img border="0" src="images/world.jpg" width="64" height="63"></a></font></td>
        <td width="50%" bgcolor="#FFFFFF" nowrap><font face="Tahoma" color="#003399" size="2">Recent acquisitions</font></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- <div align=right>
<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
$LangSelector->Show();
?>
</div>--><P>
<div align="center">
  <center>
    <?php
require_once('../../objects/tcmi/QueryForms.php');

$queryform = new TcmiBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#003399';
$queryform->BodyColor = '#ffffff';
$queryform->HelpPage = '/emuweb/examples/shared/help/GalleryBasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#003399">
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
<p align="center">&nbsp;</p>
<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#003399" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000, 2001 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
</body>

</html>
