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
<H1><FONT face="tahoma" color="#013567">1830 Warehouse</H1><BR>
Wording to user: To view information on items held in the Power Hall, please click on the map.<BR>

Note to bootroom: Please look at the code to distinguish the Electricity Galleries on the different floors<br> <BR>

<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Basement') ?>">Basement</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Ground Floor') ?>">Ground Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'First Floor') ?>">First Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Second Floor') ?>">Second Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Third Floor') ?>">Third Floor</a></td></tr>

<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Basement','Electricity Gallery') ?>">Electricity Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Ground Floor') ?>">Ground Floor</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Ground Floor','Electricity Gallery') ?>">Electricity Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'First Floor','Electricity Gallery') ?>">Electricity Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Second Floor','Electricity Gallery') ?>">Electricity Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Third Floor','Electricity Gallery') ?>">Electricity Gallery</a></td></tr>
<tr><td><a href="<?php LocationLink('1830 Warehouse', 'Third Floor','Futures Gallery') ?>">Futures Gallery</a></td></tr>


</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



