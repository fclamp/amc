<html>
<body bgcolor="#EOF5DF">


<?php


//narrative results
require_once('../../../objects/common/NarrativeBestBets.php');
$bestbet = new NarrativeBestBets;
$bestbet->NarrativeDisplayPage = 'pdadisplay.php';
$bestbet->FontFace = 'Helvetica, Arial, Times New Roman';
$bestbet->FontSize = '2';
$bestbet->TextColor = '#00496E';
$bestbet->HighlightTextColor = '#ffffff';

if ($bestbet->HasMatches())

{
	$n = $bestbet->NumberOfMatches();
	if ($n == 1)
	{
		print "<p><b>Try this $n narrative first:</b></p>";
	}
	else
	{
		print "<p><b>Try these $n narratives first:</b></p>";
	}
	print '<table cellpadding="2" cellspacing="1" width="97%" border="0" class="item4">';
	for ($i = 0; $i < $n; $i++)

	{
		print '<tr>';
		print '<td valign="top"  class="itemcontent3">';
		print '<a href="';

		// print href to display page

		$link = $bestbet->DisplayPageLink($i);
		print $link;

		print '">';

		// show the title of the narrative

		$bestbet->ShowNarrativeTitle($i);

		print '</a>';

		print '<br />&nbsp;&nbsp;';

		// show a summary of the narrative
		$bestbet->ShowNarrativeSummary($i, 50);

		print '</td>';
		print '<td>';
		print '<table width="60" border="0" cellspacing="0" cellpadding="3">';
		print '<tr align="center" valign="middle">';
		print '<td onmouseover="this.style.background=\'#588AA4\'" onmouseout="this.style.background=\'#ffffff\'">';

print '<a href="';



		// print href to display page

		print $bestbet->PrintDisplayPageLink($i);

		print '">';

				$image = new MediaImage();
				$image->Intranet = $bestbet->Intranet;
				$image->IRN = $records[$recordnum]->{'MulMultiMediaRef:1'};
				$image->ShowBorder = 0;
				$image->Width = 60;
				$image->Height = 60;
				$image->KeepAspectRatio = 0;
				$image->RefIRN = $records[$recordnum]->{'irn_1'};
				$image->RefTable = $bestbet->Database;
				$image->Show();

		print '</a>';
		print '</td></tr></table>';
		print '</td>';
		print '</tr>';

}
print '</table>';
}

?>

<?php
include("../../../objects/common/ResultsListExtractor.php");

/*
** Make a new results list object and set to extract the two fields
**	we require.
*/
$resultlist = new ResultsListExtractor;
$resultlist->Database = "enarratives";

$resultlist->ExtractFields(array(
			"SummaryData"
			));

/*
** Setup navigation and defaults
*/
$resultlist->LimitPerPage = 3;
$resultlist->DisplayPage = "pdadisplay.php";

?>

<table align="center" width="97%">
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


	// fixes big where ranges for records printed are wrong
	if($resultlist->HasMoreMatchesForward()){

		print $resultlist->UpperRecordNumber()-1;
	}
	else{
		$stuff = $resultlist->UpperRecordNumber();
		print $stuff;
	}


	print " of ";
	print $resultlist->HitCount();
	print "</font></div></td></tr></table>";

	print "<table cellpadding=\"2\" width=\"100%\">\r\n";
	for($i = 0; $i < $resultlist->RecordCount(); $i++)
	{
		
		/*
		** Iterate records, printing out thumbnails and accession number fields that are linked	to the display page
		*/
		print "<tr>";
		print "<td bgcolor='#CDD8DO' width=61>";
		$resultlist->PrintLinkedThumbnail($i);
		print "</td>";
		print "<td bgcolor='#CDD8DO'>";
		print "<font face='helvetica, arial, sans-serif' size='2'>";
		$resultlist->PrintField("SummaryData", $i);
		print "<br />";
		$resultlist->PrintLinkedField("TitAccessionNo", $i);
		print "</font>";
		print "</td>";
		print "</tr>";
	}
	print "</table>";
}
?>
<font face="helvetica, arial, sans-serif" size="2">
<a href="index.php">New Search</a>
</font>
</td>
</tr>
</table>
</body>
</html>
