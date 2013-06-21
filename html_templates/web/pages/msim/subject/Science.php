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
<table width="30%" cellpadding = "5" cellspacing = "5" border = "1">
<tr><td><a href="<?php subjectLink('Calculating and computing equipment') ?>">Calculating and computing equipment</a></td></tr>
<tr><td><a href="<?php subjectLink('Eyesight testing and correction') ?>">Eyesight testing and correction</a></td></tr>
<tr><td><a href="<?php subjectLink('Measuring and observing instruments') 	  ?>">Measuring and observing instruments</a></td></tr>
<tr><td><a href="<?php subjectLink('Scientific research')?>">Scientific research</a></td></tr>
</table>
<br>
<a href="../Query.php">Return to Main Page</a>

</center>

</body>
</html>	



