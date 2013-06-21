<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection [ detailed ]</title>
</head>

<body bgcolor="#AAC1C0">
<? include "nmnh_mcs_header.html" ?><br>
<table border="0" width="72%" cellspacing="0" cellpadding="8">
  <tr> 
    <td width="11%" nowrap valign="top"> 
      <p align="center"><img src="images/secondary_nmnh_mall.jpg" width="127" height="169"> 
    </td>
    <td width="89%"><font face="Arial" color="#013567" size="4"><b>Detailed Search 
      of the Collections<br>
      </b></font><font color="#013567" face="Arial"><br>
      Enter any terms in the boxes below and click on the "Search" button. For 
      other search types, select one of the options beneath the search box. <br>
      <br>
      Partial words may be entered using an asterisk (*) for a wildcard (e.g., 
      ). If you choose to enter more than one term in a field, only records with 
      both terms will be returned. <br>
      <br>
      Wildcard searches may be quite slow, please be patient. .</font></td>
  </tr>
</table>
<Br>
<blockquote> 
  <blockquote> 
<?php
require_once('../../objects/nmnh/QueryForms.php');
$queryform = new NmnhDetailedQueryForm;
$queryform->Title = 'Enter search term(s)...';

// override some of the default labels
$queryform->ExtraStrings = array(
	'MinCut' => 'Cut (gems only)',
	'MinColor' => 'Color (gems only)',
	'MinWeight' => 'Weight (gems only)',
	'MinWeight' => 'Weight (gems only)',
	'MinSynonyms_tab' => 'Mineral Synonyms',
	);

$queryform->ResultsListPage = 'ResultsList.php';
$queryform->FontFace = 'Arial';
$queryform->Width = '670';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#013567';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?> 
<p>&nbsp;</p>
    <p><font color="#336699" face="Arial"><a href="Query.php">Basic search</a> 
      | <a href="AdvQuery.php">Advanced search</a></font></p>
    <p><? include "nmnh_mcs_footer.html" ?></p>
  </blockquote>
</blockquote>
</body>

</html>
