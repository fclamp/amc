<html>
<body bgcolor="#DDDDDD">
<?php
include("../../../objects/common/ResultsListExtractor.php");

/*
** Make a new results list object and set to extract the two fields
**	we require.
*/
$resultlist = new ResultsListExtractor;
$resultlist->ExtractFields(array(
			"TitMainTitle",
			"TitAccessionNo",
			));
/*
** Setup navigation and defaults
*/
$resultlist->LimitPerPage = 20;
$resultlist->DisplayPage = "pdadisplay.php";

?>

<table align="center" width="95%">
<tr>
<td>

<?php
/*
** Test for not matching records, else display the list.
*/
if (! $resultlist->HasMatches())
{
	print "<p>No Matches Found. Please go back and refine your search.</p>\r\n";
}
else
{
	// Display Navigation
	print "<table width=\"100%\"><tr><td><div align=\"left\">";
	if ($resultlist->HasMoreMatchesBackward())
	{
		print "<font face='helvetica, arial, sans-serif' size='1'>";
		print "<a href=\"";
		print $resultlist->BackUrl();
		print "\">&lt;&lt; Back</a>";
		print "</font>";
	}
	else
	{
		// print gray "inactive" word
		print "<font face='helvetica, arial, sans-serif' size='1' color=\"#999999\">Back</font>";
	}
	print " | ";
	if ($resultlist->HasMoreMatchesForward())
	{
		print "<font face='helvetica, arial, sans-serif' size='1'>";
		print "<a href=\"";
		print $resultlist->NextUrl();
		print "\">Next &gt;&gt;</a>";
		print "</font>";
	}
	else
	{
		// print gray "inactive" word
		print "<font face='helvetica, arial, sans-serif' size='1' color=\"#999999\">Next</font>";
	}
	print "</div></td>";
	print "<td><div align=\"right\">";
	print "<font face='helvetica, arial, sans-serif' size='1'>";
	print $resultlist->LowerRecordNumber();
	print " to ";
	print $resultlist->UpperRecordNumber();
	print " of ";
	print $resultlist->HitCount();
	print "</font></div></td></tr></table>";

	print "<table cellpadding=\"4\" width=\"100%\">\r\n";
	for($i = 0; $i < $resultlist->RecordCount(); $i++)
	{
		
		/*
		** Iterate records, printing out thumbnails and accession number fields that are linked
		** 	to the display page
		*/
		print "<tr>";
		print "<td bgcolor='#FFFFFF' height=61 width=61>";
		$resultlist->PrintLinkedThumbnail($i);
		print "</td>";
		print "<td bgcolor='#EEEEEE' height=61>";
		print "<font face='helvetica, arial, sans-serif' size='1'>";
		$resultlist->PrintField("TitMainTitle", $i);
		print "<br />";
		$resultlist->PrintLinkedField("TitAccessionNo", $i);
		print "</font>";
		print "</td>";
		print "</tr>";
	}
	print "</table>";
}
?>
<br />
<font face="helvetica, arial, sans-serif" size="2">
<a href="index.php">New Search</a>
</font>
</td>
</tr>
</table>
</body>
</html>
