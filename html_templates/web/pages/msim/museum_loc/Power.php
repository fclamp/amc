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
<H1><FONT face="tahoma" color="#013567">Power Hall</H1><BR>
Wording to user: To view information on items held in the Power Hall, please click on the map.<BR>
Note to bootroom:Just the one image here: eg <br> <BR>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td></td><td>Ground Floor</td><td></td></tr>
</table>
<br>
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php LocationLink('Power Hall','Ground Floor') ?>">Ground Floor</a></td></tr>


</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



