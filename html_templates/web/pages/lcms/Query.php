
<html>

<head>
<title>Search Our Collection...</title>
</head>
<?php
require_once('Header.php');
?>
<br/>
<br/>
<br/>
<br/>
Please enter whatever text you require here: This will be the entry text where you can explain the collection, add images and add who they should contact if they have any questions.
<br/>
<br/>


<center>
<?php
require_once('../../objects/mm/QueryForms.php');

$queryform = new LcmsBasicQueryForm;
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->FontFace = 'Arial, Tahoma';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#EEEEEE';
$queryform->BorderColor = '#663399';
$queryform->BodyColor = '#FFFFFF';
$queryform->Show();
?>
</center>

<p align="center"><font face="Ariel, Tahoma"><u><font color="#663399"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#663399">
| </font><font color="#663399"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>

<br/>
<br/>
<br/>
<br/>
<br/>


<?php
require_once('Footer.php');
?>

</html>
