<html>

<body bgcolor="#EOF5DF">

<?php
require_once("../../../objects/common/RecordExtractor.php");

/*
** Extract data from record using the RecordExtractor object, and specify fields to be retrieved
*/
$extractor = new RecordExtractor;
$extractor->Database = "emultimedia";
$extractor->NullFieldHolder = "-";
$extractor->ExtractFields(array(
		"SummaryData",
		"Multimedia",
		));

if (! $extractor->HasValidRecord())
{
	die ("Invalid Request");
}
/*
** Print main image
*/
?>
<center><?php 


print "This page is under construction";

/*
print "<OBJECT ID=\"PlayerOCX\" WIDTH=\"200\" HEIGHT=\"200\"
CLASSID=\"CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95\"
STANDBY=\"Loading Windows Media Player components...\"
TYPE=\"application/x-oleobject\">
<PARAM NAME=\"FileName\" VALUE=\"http://bondi.syd.kesoftware.com/artbankmedia/";
$extractor->PrintField("Multimedia", 1);
print "\">
<PARAM NAME=\"AutoStart\" VALUE=\"False\">
</OBJECT>";
*/


?>


<br /><br />


</center>
<font face="helvetica, arial, sans-serif" size="2">
<div align="left"><a href="index.php">New Search</a></div>
</font>
</body>

</html>
