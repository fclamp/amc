<html>

<head>
<title>Search Our Collection [ detailed ]</title>
</head>

<body bgcolor="#FFFFFF">

<?php
require_once('Header.php');
?>
<br/>
<br/>
<br/>
<br/>

<div align="center">
<?php
require_once('../../objects/mm/QueryForms.php');
$queryform = new LcmsDetailedQueryForm;
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->Width = "750";
$queryform->FontFace = 'Arial, Tahoma';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#663399';
$queryform->TitleTextColor = '#EEEEEE';
$queryform->BorderColor = '#663399';
$queryform->BodyColor = '#FFFFFF';
$queryform->Show();
?>
</div>
<p align="center"><font face="Ariel, Tahoma"><u><font color="#663399"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#663399">
| </font><font color="#663399"><u><a href="Query.php">Keyword search</a></u></font></font></p>

<br/>
<br/>
<br/>
<br/>
<br/>


<?php
require_once('Footer.php');
?>
</body>

</html>
