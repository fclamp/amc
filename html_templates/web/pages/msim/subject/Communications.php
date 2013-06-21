<?php
require_once('../../../objects/common/PreConfiguredQuery.php');

function 
subjectLink($subject)
{
	$SubjQuery = new PreConfiguredQueryLink;
	$SubjQuery->ResultsListPage = '../ResultsList.php';
	$SubjQuery->LimitPerPage = 20;
	$SubjQuery->Where = "exists(SubSubjects_tab where SubSubjects contains '$subject')";
	$SubjQuery->PrintRef();
}
?>
<html>
<body bgcolor="#E0F5DF">

<center>  
<H1><FONT face="tahoma" color="#013567">Subject Query</H1><BR>
<table width="15%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php subjectLink('Papermaking') ?>">Papermaking</a></td></tr>
<tr><td><a href="<?php subjectLink('Photography') ?>">Photography</a></td></tr>
<tr><td><a href="<?php subjectLink('Printing') 	  ?>">Printing</a></td></tr>
<tr><td><a href="<?php subjectLink('Sound recording')?>">Sound recording</a></td></tr>
<tr><td><a href="<?php subjectLink('Telecommunications')   ?>">Telecommunications</a></td></tr>
</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	

