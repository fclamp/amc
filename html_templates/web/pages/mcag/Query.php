<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection...</title>
</head>

<body bgcolor="#FFFFFF">

<center>
<?php
require_once('../../objects/galleryuk/QueryForms.php');

$queryform = new GalleryUKBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#000000';
$queryform->BorderColor = '#EEEEEE';
$queryform->BodyColor = '#FFFFFF';
$queryform->ResultsListPage = 'ResultsList.php';

//setting query fields
		

$queryform->Options = array(	'Anywhere' =>'SummaryData|AdmWebMetadata',
			'Title' => 'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitAlternateTitles_tab',
			'Keyword' => 'PhyDescription|TitObjectName|TitMainTitle|TitAlternateTitles_tab',
			'Medium' => 'PhyMedium_tab',
			'Material' => 'PhyMaterial_tab',
		);
		
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#000000"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#000000">
| </font><font color="#000000"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
<p align="center">&nbsp;</p>
</body>

</html>
