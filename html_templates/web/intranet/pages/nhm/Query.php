<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search Our Collection...</title>
</head>

<body bgcolor="#0080C0">
<?php
require_once('../../objects/nhm/MineralogyQueryForms.php');
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><font face="Tahoma"><img border="0" src="images/Beryl4-small.jpg" width="171" height="242"></font></td>
    <td width="70%" valign="top"><font face="Tahoma" size="5" color="#FFFF99"><b>Search
      Our Collection...</b></font>
      <p><font color="#FFFF99" size="3" face="Tahoma"><strong>Welcome to the Department of Mineralogy's live search page.</strong></font.</p>
      <p><font color="#FFFF99" size="3" face="Tahoma">Here you can find out everything you want to know about the contents of our collection.</font></p>
      <p><font color="#FFFF99" size="3" face="Tahoma">Popular searches are available in the Quick Browse section to the right.</font></p>
      <p><font color="#FFFF99" size="3" face="Tahoma">Key word searches can be performed in the main search box below. Advanced searches and searches on values in specific fields are available on the links below.</font></p>
      <p><font color="#FFFF99" size="3" face="Tahoma">Our aim is to deliver accurate data, so if you see an error please let us know.</font></p>
    </td>
    <td width="20%" valign="middle"><b><font size="2" face="Tahoma" color="#FFCC00">&nbsp;Quick
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
<?php
$self = WebSelf();
?>
        <tr>
<td width="50%" bgcolor="#003399"><font face="Tahoma"><a href="ResultsList.php?preconf=buildingwithimage&QueryPage=<?php print $self; ?>">
	  <img border="0" src="images/arabescatto.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#003399" nowrap><font color="#FFFFE8" face="Tahoma" size="2">Building Stones with images</font></td>
        </tr>
        <tr>
<td width="50%" bgcolor="#003399"><font face="Tahoma"><a href="ResultsList.php?preconf=kimberlites&QueryPage=<?php print $self; ?>">
	  <img border="0" src="images/xenolith_small.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#003399" nowrap><font color="#FFFFE8" face="Tahoma" size="2">Kimberlites</font></td>
        </tr>
        <tr>
<td width="50%" bgcolor="#003399"><font face="Tahoma"><a href="ResultsList.php?preconf=minondisplay&QueryPage=<?php print $self; ?>">
	  <img border="0" src="images/mingal_small.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#003399" nowrap><font color="#FFFFE8" face="Tahoma" size="2">Minerals on display</font></td>
        </tr>
        <tr>
<td width="50%" bgcolor="#003399"><font face="Tahoma"><a href="ResultsList.php?preconf=carbonatites&QueryPage=<?php print $self; ?>">
	  <img border="0" src="images/oldoinyo_ripped_off.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#003399" nowrap><font color="#FFFFE8" face="Tahoma" size="2">Carbonatites</font></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<div align="center">
  <center>
<?php

$queryform = new MineralogyBasicQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->Intranet = 1;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#003399';
$queryform->BodyColor = '#FFFFCC';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#FFCC00"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#FFCC00">
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#FFFFFF" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#FFFFFF">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
