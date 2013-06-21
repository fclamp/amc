<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Recherche SMCC Collection ...</title>
</head>

<body bgcolor="#FFFFE8">
<p align="center"><img border="0" src="images/pi_civilizations.gif" width="270" height="42"></p>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td nowrap valign="top">
      <p align="center"><img border="0" src="images/logo_s.gif" width="88" height="28"></td>
    <td width="70%" valign="top"><font face="Tahoma" size="5" color="#003399">
     <blockquote><b>Recherche SMCC Collection...</b></font>
      <p><font color="#003399" size="2" face="Tahoma">Bienvenue a La Société du Musée canadien des civilisations
      &nbsp;</p>
      <p>Popular searches are available in the Quick Browse section to the right.</p>
      <p> Écrivez un ou des termes dans la case Mot-clé. Cette recherche questionnera 26 zones uniques d'information sur les artefacts</p>
      <p>Pour rechercher un nom d'artiste ou un terme dans son contexte, utilisez l'écran pour une recherche évoluée. <a href="DtlQuery.php">Recherche évoluée</a></p></font></p></blockquote>
    </td>
    <td width="20%" valign="middle" bgcolor="#003399"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Recherch
      Rapid</font>
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
          <td width="50%" bgcolor="#FFFFE8" nowrap><font color="#003399" face="Tahoma" size="2">Objets
            avec images</font></td>
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
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#003399" size="2">Au hazard
            </font></td>
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
          <td width="50%" bgcolor="#FFFFE8" nowrap><font face="Tahoma" color="#003399" size="2">Acquisition
            la plus recente</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div align=right>
<?php
require_once('../../objects/cmcc/CMCCLanguageSelector.php');
$LangSelector = new CmccLanguageSelector;
$LangSelector->Language = "French";
$LangSelector->Show();

?>
</div>

<div align="center">
  <center>
<?php
require_once('../../objects/cmcc/QueryForms.php');
$queryform = new CmccBasicQueryForm;
$queryform->ResultsListPage = "ResultsListFrench.php";
$queryform->LanguageData = "french";
$queryform->LanguagePrompts = "french";
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
| --></font><font color="#0000FF"><u><a href="DtlQuery.php">Recherche évoluée</a></u></font></font></p>
<!--<p align="center">&nbsp;</p>-->
<table border="0">
  <tr>
     <td width="31%" align="center"></td>
     <td>
        <font FACE="Arial, Helvetica" SIZE="1" COLOR="003300">
        Reproduction interdite sans la permission écrite de la Société du Musée canadien des civilisations 
        <BR> Veuillez <a href="">nous contacter</a>pour de plus amples renseignements sur les permissions et reproductions. </font>
     </td>
  </tr>
</table>

<TABLE border="0">
  <TR>
     <td width="45%" align="center"></td>
     <TD>
        <br>
        <FONT FACE="Arial, Helvetica" SIZE="1" COLOR="000000">
                Date de création : 3 octobre 1997. Mise à jour : 27 septembre 2001 
                <BR>© Société du Musée canadien des civilisations 
        </FONT>
     </TD>
  </TR>
</TABLE>




<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#003399" size="1">Faire marcher
      par: &nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
