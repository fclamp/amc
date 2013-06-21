<html>

<head>
<title>Search Our Collection</title>
</head>

<body bgcolor="#FFFFFF">

<?php
require_once('Header.php');
?>
<br/>
<br/>
<br/>

<div align="center">
<?php
require_once('../../objects/mm/QueryForms.php');
$queryform = new LcmsAdvancedQueryForm;
$queryform->ResultsListPage='ResultsList.php';
$queryform->Width = "50%";
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#EEEEEE';
$queryform->BodyTextColor = '#663399';
$queryform->BorderColor = '#663399';
$queryform->BodyColor = '#FFFFFF';
$queryform->Show();
?>

</div>


<p align="center"><font face="Ariel, Tahoma"><u><font color="#663399"><a href="Query.php">Keyword
search</a></font></u><font color="#663399">
| </font><font color="#663399"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>


<br/>
<br/>
<br/>

<?php
require_once('Footer.php');
?>

</body>

</html>
