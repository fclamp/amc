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
<H1><FONT face="tahoma" color="#013567">Collonade</H1><BR>
Wording to user: To view information on items held in the Collonade please click on the map.<BR>

Note to bootroom: All of the locations here are in the main building to be depicted graphically as a hierarchy: eg <br> <BR>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td></td><td>Basement</td><td></td></tr>
<tr><td></td> <td>Collections Centre</td></tr>
<tr><td>Store 2</td><td>Store 3</td><td>Store 4</td></tr>
</table>
<br>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement') ?>">Basement</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Photography Studio') ?>">Photography Studio</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Workshop') ?>">Workshop</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Collections Centre') ?>">Collections Centre</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Collections Centre','Store 2') ?>">Store 2</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Collections Centre','Store 3') ?>">Store 3</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Collections Centre','Store 4') ?>">Store 4</a></td></tr>
<tr><td><a href="<?php LocationLink('Colonnade', 'Basement','Collections Centre','Collections Reception') ?>">Collections Reception</a></td></tr>


</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



