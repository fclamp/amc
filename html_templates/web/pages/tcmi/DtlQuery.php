<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ detailed ]</title>
</head>

<body bgcolor="#FFFFFF">
<table width="580"  border="0" align="left" cellpadding="5" cellspacing="0">
  <tr>
    <td><div align="left"><?php require_once('\generalinfo\header.htm'); ?></div></td>
  </tr>
  <tr>
    <th scope="col">
	<table width="650" border="0" align="center" cellpadding="10" cellspacing="0">
  <tr>
    <td scope="col"><div align="left"><font face="Tahoma" color="#003399" size="4"><b>Detailed Search<br>
        </b></font><strong><font color="#003399" size="2" face="Arial, Helvetica, sans-serif">Enter any terms in the
        boxes below and click on the "Search"
  button.&nbsp; For other search types, select one of the options beneath the search
  box.</font></strong></div></td>
  </tr>
  <tr>
    <td><!-- <?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
    $LangSelector->FontSize = '2';
    $LangSelector->FontColor = '#003399';
    $LangSelector->Show();
    ?>-->

<div align="center">
<?php
require_once('../../objects/tcmi/QueryForms.php');
$queryform = new TcmiDetailedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#003399';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#003399';
$queryform->BodyColor = '#FFFFFF';
$queryform->Show();
?>
</div></td>
  </tr>
</table>
<p align="center"><font color="#003399" face="Tahoma"><a href="Query.php">Basic search</a> |
  <a href="AdvQuery.php">Advanced
  search</a></font></p>
	</th>
  </tr>
  <tr>
    <th scope="col"><div align="left">
      <?php require_once('\generalinfo\footer.htm'); ?>
    </div>
<p align="center">&nbsp;</p>
<table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:</font><font size="2">&nbsp;&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000, 2001 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table></th>
  </tr>
</table>


</body>

</html>
