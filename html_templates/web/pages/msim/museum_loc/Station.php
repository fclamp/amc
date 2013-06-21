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
<H1><FONT face="tahoma" color="#013567">Station Building</H1><BR>
Wording to user: To view information on items held in the Station Building, please click on the map.<BR>

Note to bootroom:see other examples of hierarchy<br> <BR>

<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php LocationLink('Station Building', 'Basement') ?>">Basement</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor') ?>">Ground Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'First Floor') ?>">First Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Basement','Small Object Store') ?>">Small Object Store</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Basement','Small Object Store','Room 1') ?>">Room 1</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Basement','Small Object Store','Room 2') ?>">Room 2</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Basement','Small Object Store','Room 3') ?>">Room 3</a></td></tr>

<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor','Orientation Area') ?>">Orientation Area</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor','Orientation Area','Room 1') ?>">Room 1</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor','The Making Of Manchester Gallery') ?>">The Making Of Manchester Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor','The Making Of Manchester Gallery','Room 2-8') ?>">Room 2-8</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor','Liverpool and Manchester Railway Exhibition') ?>">Liverpool and Manchester Railway Exhibition</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'Ground Floor','First Class Booking Hall') ?>">First Class Booking Hall</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'First Floor','Measuring Up Gallery') ?>">Measuring Up Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'First Floor','Collected Cameras Gallery') ?>">Collected Cameras Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'First Floor','Design Studio') ?>">Design Studio</a></td></tr>
<tr><td><a href="<?php LocationLink('Station Building', 'First Floor','Picnic Area') ?>">Picnic Area</a></td></tr>
</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



