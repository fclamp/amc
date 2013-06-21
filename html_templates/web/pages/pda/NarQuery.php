
<html>

<head>
<title>Search Our Narratives...</title>
</head>
<body bgcolor="#E0F5DF">
  <center>
  <p>
  Enter a <b>word or phrase</b> you wish to find in <b>narratives</b>:
  <br><br>
<?php
require_once('../../objects/pda/QueryForms.php');

$queryform = new PdaNarrativeQueryForm;
$queryform->ResultsListPage = 'pdanarresults.php';
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#013567';
$queryform->TitleTextColor = '#DFF5E0';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#DFF5E0';

$queryform->Show();
?>
  <br>
<a href="index.php">Back to Main Page</a>
  </center>

</body>

</html>
