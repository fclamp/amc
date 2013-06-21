<html>

<head>
<title>Display</title>
</head>

<body bgcolor="#E0F5DF">
<font face="Tahoma" color="#336699"><p align="center">Narratives</p></font><br>

<p align=center>
<?php
	require_once("../../objects/common/NarrativeBestBets.php");
	$bestbet = new NarrativeBestBets;
	$bestbet->NarrativeDisplayPage = "pdanardisplay.php";
	$bestbet->FontFace = "Arial";
	$bestbet->FontSize = "2";
	$bestbet->TextColor = "#336699";
	$bestbet->HighlightTextColor = "#DDDDDD";
	if ($bestbet->HasMatches())
	{
		print "Try these narratives first:";
		/*
		** Loop over the matches printing out in required style
		*/
		$n = $bestbet->NumberOfMatches();
		for ($i = 0; $i < $n; $i++)
		{
			print "<b><a href=\"";
			// print href to display page
			print $bestbet->PrintDisplayPageLink($i);
			print '">';
			// show the title of the narrative
			$bestbet->ShowNarrativeTitle($i);
			print "</a>";
			print "</b><br />";
			print "<font size=-1>&nbsp;&nbsp;";
			// show a summary of the narrative
			$bestbet->ShowNarrativeSummary($i);
			//example with more summary text (100 characters)
			//$bestbet->ShowNarrativeSummary($i, 100);
			print "</font>";
			print "<br />";
		}
		print "<p>&nbsp;</p>";
	}
?>
</p>
</body>
</html>

