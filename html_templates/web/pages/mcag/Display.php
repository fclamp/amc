<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Display</title>
</head>

<body bgcolor="#FFFFFF">

<p align=center>
<?php
require_once('../../objects/galleryuk/DisplayObjects.php');
$GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'] = 'PartyDisplay.php';
$display = new GalleryUKStandardDisplay;
$display->FontFace = 'Tahoma';
$display->FontSize = '2';
$display->TitleTextColor = '#000000';
$display->BodyTextColor = '#000000';
$display->BorderColor = '#EEEEEE';
$display->HeaderTextColor = '#000000';
$display->BodyColor = '#FFFFFF';
$display->HighlightColor = '#F7F7F7';
$display->PartyDisplayPage = 'PartyDisplay.php';

// Define Fields

$creCreatorRef = new Field;
$creCreatorRef->ColName = 'CreCreatorRef_tab->eparties->SummaryData';
$creCreatorRef->LinksTo = 'PartyDisplay.php';

$creDateCreated = new Field;
$creDateCreated->ColName = 'CreDateCreated';
$creDateCreated->ColType = 'date';

$display->Fields = array(
		'TitMainTitle',
		'TitSeriesTitle',
		'TitCollectionTitle',
		'TitAlternateTitles_tab',
		'TitObjectName',
		$creCreatorRef,
		$creDateCreated,
		'PhyMedium_tab',
		'PhyMaterial_tab',
		'PhyDescription',
		);

$display->Show();
?>
</p>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#000000" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#000000">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
