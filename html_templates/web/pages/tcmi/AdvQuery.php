<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>The Children's Museum of Indianapolis - Collections</title>
</head>

<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


<table width="580"  border="0" align="left" cellpadding="5" cellspacing="0">
  <tr>
    <td><div align="left"><?php require_once('\generalinfo\header.htm'); ?></div></td>
  </tr>
  <tr>
    <th scope="col"><p align="left"><font face="Arial,Tahoma" color="#003399" size="4"><b><br>
      Advanced Search<br>
                </b></font><font color="#336699" size="2" face="Arial, Helvetica, sans-serif">Enter any terms in the boxes below, select an area to search, then click the "Search" button.</font> <br>
<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial'; 
$LangSelector->FontSize = '2'; 
$LangSelector->FontColor = '#003399'; 
$LangSelector->Show(); ?>
          
         <br>
              <?php
require_once('../../objects/tcmi/QueryForms.php');
$queryform = new TcmiAdvancedQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyTextColor = '#003399';
$queryform->BorderColor = '#003399';
$queryform->BodyColor = '#FFFFFF';
$queryform->Show();
?>
                </p>
      <p><u><a href="Query.php"><font face="Tahoma">Basic search</font></a></u> <font color="#003399" face="Tahoma"> | </font><u><a href="DtlQuery.php"><font face="Tahoma">Detailed search</font></a></u>
      </p>            
        </p>
      </p></th>
  </tr>
  <tr>
    <th scope="col"><div align="left">
      <?php require_once('\generalinfo\footer.htm'); ?>
    <table width="650" border="0" align="center" cellpadding="4" cellspacing="0">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000, 2001 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table></div></th>
  </tr>
</table>

</body>

</html>
