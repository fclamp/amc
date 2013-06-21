<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>The Children's Museum of Indianapolis - Collections</title>
</head>

<body bgcolor="#FFFFFF">


<table width="650" border="0" align="left" cellpadding="2" cellspacing="0">
  <tr>
    <td colspan="2" valign="top"> <?php require_once('\generalinfo\header.htm'); ?></td>
  </tr>
  <tr>

    <td width="66%" valign="top"><font face="Tahoma" size="5" color="#003399">
     <blockquote><b>Search Our Collection...</b></font>
      <p><font color="#003399" size="2" face="Tahoma">Welcome to The Children's Museum of Indianapolis
      online collection's search page.&nbsp;</p>
      <p>Popular searches are available in the Quick Browse section to the right.</p>
      <p>Key word searches can be performed in the main search box below.&nbsp; Use the <a href="AdvQuery.php">Advanced Query</a> form for boolean searches. The <a href="DtlQuery.php">Detailed Search</a> form provides searching on a field by field basis.</font></p>
      <p>&nbsp;</p>
    </blockquote></td>
    <td width="34%"><table width="231" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#003399">
        <td colspan="2"><div align="center"><b><font size="2" face="Tahoma" color="#FFFFFF">Quick Browse</font></b></div></td>
      </tr>
      <tr>
        <td width="27%" bgcolor="#FFFFFF"><font face="Tahoma"><img border="0" src="images/disk.jpg" width="64" height="62"></font></td>
        <td width="73%" bgcolor="#FFFFFF" nowrap><div align="center"><font color="#003399" face="Tahoma" size="2"><a href="http://172.16.1.39/webtcmi/pages/tcmi/ContactSheet.php?Where=ClaCollection+%3D+%27American+Experience%27&QueryPage=%2Fwebtcmi%2Fpages%2Ftcmi%2FQuery.php&LimitPerPage=20&">American Experience </a></font></div></td>
      </tr>
      <tr>
        <td width="27%" bgcolor="#FFFFFF"><font face="Tahoma"><img border="0" src="images/face.jpg" width="62" height="65"></font></td>
        <td width="73%" bgcolor="#FFFFFF" nowrap><div align="center"><font face="Tahoma" color="#003399" size="2"><a href="http://172.16.1.39/webtcmi/pages/tcmi/ContactSheet.php?Where=ClaCollection+%3D+%27Natural+Science%27&QueryPage=%2Fwebtcmi%2Fpages%2Ftcmi%2FQuery.php&LimitPerPage=20&">Natural Science</a></font></div></td>
      </tr>
      <tr>
        <td width="27%" bgcolor="#FFFFFF"><font face="Tahoma"><img border="0" src="images/world.jpg" width="64" height="63"></font></td>
        <td width="73%" bgcolor="#FFFFFF" nowrap><div align="center"><font face="Tahoma" color="#003399" size="2"><a href="http://172.16.1.39/webtcmi/pages/tcmi/ContactSheet.php?QueryName=DetailedQuery&StartAt=1&QueryPage=%2Fwebtcmi%2Fpages%2Ftcmi%2FDtlQuery.php&col_ClaCollection=world&LimitPerPage=20&Search=Search&">World Cultures</a></font></div></td>
      </tr>
    </table><?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
$LangSelector->Show();
?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><div align="center">
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
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p></td>
  </tr>
  <tr>
    <td colspan="2" valign="top"><?php require_once('\generalinfo\footer.htm'); ?>
  </p>
</div>
<div align="left"></div>
<table width="650" border="0" cellpadding="4" cellspacing="0">
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
</td>
  </tr>
</table>
<P>
<p align="left">
<p align="left">
<p align="left">
<p align="left">
<p align="left">
<p align="left">
<p align="left">
<p align="left">
<p align="left">
<p align="left">
  
 
</body>

</html>
