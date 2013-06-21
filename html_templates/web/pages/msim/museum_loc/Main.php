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
<H1><FONT face="tahoma" color="#013567">Main Building</H1><BR>
Wording to user: To view information on items held in the Main building, please click on the map.<BR>
Note to bootroom: All of the locations here are in the main building to be depicted graphically as a hierarchy: eg <br> <BR>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td></td><td>Basement</td><td></td></tr>
<tr><td></td> <td>Collections Centre</td></tr>
<tr><td>Object Cabinets</td><td>Store 1</td><td>Study Room</td></tr>
</table>
<br>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php LocationLink('Main Building', 'Basement') ?>">Basement</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Ground Floor') ?>">Ground Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'First Floor') ?>">First Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Second Floor') ?>">Second Floor</a></td></tr>


<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre') ?>">Collections Centre</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Ground Floor', 'Fibres, Fabrics & Fashion Gallery') ?>">Fibres, Fabrics & Fashion Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Ground Floor', 'Changing Exhibition Gallery') ?>">Changing Exhibition Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Ground Floor','Orientation Area') ?>">Orientation Area</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'First Floor','Learning Centre') ?>">Learning Centre</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'First Floor','Conference Suite') ?>">Conference Suite</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Second Floor','Restaurant') ?>">Restaurant</a></td></tr>
<tr><td><a href="<?php LocationLink('Object Cabinets') ?>">Object Cabinets</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre','Store 1') ?>">Store 1</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre','Archive Strong Room') ?>">Archive Strong Room</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre','Photographic Store') ?>">Photographic Store</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre','Reference Library') ?>">Reference Library</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre','Cataloguing Room') ?>">Cataloguing Room</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'Basement', 'Collections Centre','Study Room') ?>">Study Room</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'First Floor','Learning Centre','Classroom 1') ?>">Classroom 1</a></td></tr>
<tr><td><a href="<?php LocationLink('Main Building', 'First Floor','Learning Centre','Store') ?>">Store</a></td></tr>
</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



