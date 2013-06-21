<html>

<head>
<title>Search results</title>
</head>

<body bgcolor="#FFFFFF">
<?php
require_once('Header.php');
?>

<br/>
<br/>


<center>
<?php
require_once('../../objects/mm/ResultsLists.php');

$resultlist = new LcmsStandardResultsList;
$resultlist->ContactSheetPage = 'ContactSheet.php';
$resultlist->DisplayPage = 'Display.php';
$resultlist->BodyColor = '#FFFFFF';
$resultlist->Width = '80%';
$resultlist->HighlightColor = '#EEEEEE';
$resultlist->HighlightTextColor = '#F7F7F7';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#663399';
$resultlist->HeaderColor = '#663399';
$resultlist->BorderColor = '#663399';
$resultlist->HeaderTextColor = '#EEEEEE';
$resultlist->Show();
?>
</center>


<br/>
<br/>
<br/>

<?php
require_once('Footer.php');
?>
</body>

</html>

