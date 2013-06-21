<?php
require_once('../../../objects/common/PreConfiguredQuery.php');

function 
LocationLink($level1, $level2='', $level3='', $level4='')
{
	$LocQuery = new PreConfiguredQueryLink;
	$LocQuery->ResultsListPage = '../ResultsList.php';
	$LocQuery->QueryTerms = array(
				"LocCurrentLocationRef->elocations->LocLevel1"=> "$level1",
				"LocCurrentLocationRef->elocations->LocLevel2"=> "$level2",
				"LocCurrentLocationRef->elocations->LocLevel3"=> "$level3",
				"LocCurrentLocationRef->elocations->LocLevel4"=> "$level4",
				);
	$LocQuery->PrintRef();
}
?>
<html>
<body bgcolor="#E0F5DF">

<center>  
<h1><font face="tahoma" color="#013567">Air and Space Hall</h1><br>
wording to user: to view information on items held in the Air and Space Hall, please click on the map.<br>
note to bootroom:as with theother pages<br>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php LocationLink('Air & Space Hall', 'Ground Floor') ?>">Ground Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('Air & Space Hall', 'Mezzanine Floor') ?>">Mezzanine Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('Air & Space Hall', 'Mezzanine Floor','Out of This World Gallery') ?>">Out of This World Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('Air & Space Hall', 'Mezzanine Floor','Plane Station Gallery') ?>">Plane Station Gallery</a></td></tr>


</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



