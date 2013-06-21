
<html>

<head>
<title>Search Our Narratives...</title>
</head>

<body bgcolor="#E0F5DF">

  <center>
  <p>
  <br>
  Enter a word or phrase you wish to find in narratives:
  <br>
  If you are not sure what kind of search you would like to do, why not try clicking <a href="narrative/NarHighlights.php">here</a> to see our Narrative Highlights.
  </p>
  <p>&nbsp;</p>
<?php
require_once('../../objects/msim/QueryForms.php');

$queryform = new MsimNarrativeQueryForm;
$queryform->ResultsListPage = 'NarResultsList.php';
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#013567';
$queryform->TitleTextColor = '#DFF5E0';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#DFF5E0';

$queryform->Show();
?>
<br>
<a href="Query.php">Back to Main Page</a>
  </center>

</body>

</html>
