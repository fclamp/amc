<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ advanced ]</title>
</head>

<body bgcolor="#FFFFFF">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="left"><img border="0" src="images/mag.gif" width="165" ></td>
     </tr>
</table>
<div align="center">
<?php
require_once('../../objects/galleryuk/QueryForms.php');
$queryform = new GalleryUKAdvancedQueryForm;
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#000000';
$queryform->BodyTextColor = '#000000';
$queryform->BorderColor = '#EEEEEE';
$queryform->BodyColor = '#FFFFFF';
$queryform->ResultsListPage = 'ResultsList.php';


$queryform->Options = array(	'Anywhere' =>'SummaryData|AdmWebMetadata',
			'Title' => 'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			'Keyword' => 'PhyDescription|TitObjectName|TitMainTitle|TitAlternateTitles_tab',
			'Medium' => 'PhyMedium_tab',
			'Material' => 'PhyMaterial_tab',
		);


$queryform->Show();
?>

</div>
<p align="center"><u><a href="mag_home.php"><font face="Tahoma">Back to Main page</font></a></u> <font color="#000000" face="Tahoma"> |
</font><u><a href="DtlQuery.php"><font face="Tahoma">Detailed search</font></a></u></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#000000" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#000000">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
<p align="center">&nbsp;</p>

</body>

</html>
