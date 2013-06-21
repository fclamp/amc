<html>

<body bgcolor="#DDDDDD">

<?php
require_once("../../../objects/common/RecordExtractor.php");

/*
** Extract data from record using the RecordExtractor object, and specify fields to be retrieved
*/
$extractor = new RecordExtractor;
$extractor->Database = "ecatalogue";
$extractor->NullFieldHolder = "-";
$extractor->ExtractFields(array(
		"TitMainTitle", 
		"TitAccessionNo",
		"LocCurrentLocationRef->elocations->LocLocationName",
		"TitObjectStatus",
		"ConConditionStatus"
		));

if (! $extractor->HasValidRecord())
{
	die ("Invalid Request");
}
/*
** Print main image
*/
?>
<center><?php $extractor->PrintImage(100, 100, 1); ?>
<br /><br />
</div></td>

<!-- Begin Main Display Table - Print alternating columns of field heading and field contents -->
<table width="95%" cellspacing="2" cellpadding="1" border="0" class="item2">
<tr><td bgcolor="#EEEEEE"><font face="helvetica, arial, sans-serif" size="2"><b>Title</b></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("TitMainTitle");?></font></td></tr>
<tr><td bgcolor="#EEEEEE"><font face="helvetica, arial, sans-serif" size="2"><b>Accession No.</b></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("TitAccessionNo"); ?></font></td></tr>
<tr><td bgcolor="#EEEEEE"><font face="helvetica, arial, sans-serif" size="2"><b>Current Location</b></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("LocCurrentLocationRef->elocations->LocLocationName")?></font></td></tr>
<tr><td bgcolor="#EEEEEE"><font face="helvetica, arial, sans-serif" size="2"><b>Object Status</b></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("TitObjectStatus"); ?></font></td></tr>
<tr><td bgcolor="#EEEEEE"><font face="helvetica, arial, sans-serif" size="2"><b>Object Condition</b></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("ConConditionStatus"); ?></font></td></tr>
</table>
<!-- End Main Display Table -->

<br />
<?php
/*
** Iterate attached multimedia if there is any and display outside of any table to allow browser
**	to wrap if required
*/
$count = $extractor->MediaCount();
if ($count > 1)
{
	for($i = 2; $i <= $count; $i++)
	{
		$extractor->PrintImage(60, 60, $i);
		print '&nbsp;';
	}
}
?>

</center>
<font face="helvetica, arial, sans-serif" size="2">
<div align="left"><a href="index.php">New Search</a></div>
</font>
</body>

</html>
