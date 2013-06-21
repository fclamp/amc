<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ detailed ]</title>
</head>

<body bgcolor="#FFFFFF">

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="left"><img border="0" src="images/mag.gif" width="165"></td>
    
</table>
<div align="center">
<?php
require_once('../../objects/galleryuk/QueryForms.php');
$queryform = new GalleryUKDetailedQueryForm;
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->Width = '50%';
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#000000';
$queryform->TitleTextColor = '#000000';
$queryform->BorderColor = '#EEEEEE';
$queryform->BodyColor = '#FFFFFF';

//setting query fields

		
$queryform->Fields = array(
	'TitCollectionGroup_tab',
	'CreCreatorLocal_tab',
	'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
	'PhyDescription|TitObjectName|TitMainTitle|TitAlternateTitles_tab',
	'CreDateCreated',
	'PhyMedium_tab',
	'PhyMaterial_tab',
	);

$queryform->Hints = array(
	'TitCollectionGroup_tab'	=> '[ Select from List ]',
	'PhyMaterial_tab'	=> '[ e.g. Glass ]',
	'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab'	=> '[ e.g. At the Golden Gate ]',
	'CreCreatorLocal_tab'	=> '[ e.g. William Blake ]',
	'PhyDescription|TitObjectName|TitMainTitle|TitAlternateTitles_tab'	=> '[ e.g. Flower ]',
	'CreDateCreated'	=> '[ e.g. 1825 ]',
	);

$queryform->DropDownLists = array(
	'TitCollectionGroup_tab' => '|Fine Art|Decorative Art',
	);

$queryform->LookupLists = array(
	'PhyMaterial_tab' => 'Material',
	'PhyMedium_tab' => 'Medium',
	);

$queryform->Show();
?>


</div>
<p align="center"><font color="#000000" face="Tahoma"><a href="mag_home.php">Back to Main page</a> |
<a href="AdvQuery.php">Advanced
search</a></font></p>
<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#000000" size="1">Powered
      by:</font><font size="2">&nbsp;&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#000000">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>
<p align="center">&nbsp;</p>

</body>

</html>
