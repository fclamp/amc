<html>

<body bgcolor="#EOF5DF">

<?php
require_once("../../objects/common/RecordExtractor.php");

/*
** Extract data from record using the RecordExtractor object, and specify fields to be retrieved
*/
$extractor = new RecordExtractor;
$extractor->Database = "enarratives";
$extractor->NullFieldHolder = "-";
$extractor->ExtractFields(array(
		"NarTitle", 
		"NarNarrative", 
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
<table width="97%" cellspacing="2" cellpadding="1" border="0" class="item2">
<tr><td bgcolor="#EEEEEE"><font face="helvetica, arial, sans-serif" size="2"><b>Title</b></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("NarTitle");?></font></td></tr>
<tr><td bgcolor="#FFFFFF">&nbsp;&nbsp;&nbsp;<font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("NarNarrative");?></font></td></tr>
</tr>
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
