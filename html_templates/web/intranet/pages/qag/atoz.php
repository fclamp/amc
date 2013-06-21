<?php
require_once('../../objects/qag/QagSessions.php');
$sess = new QagSession;
//$sess->ClearSession();
//$sess->SaveVar("SessionsOn", 1);
$SessionsWorking = $sess->GetVar("SessionsOn");
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once($WEB_ROOT . "/objects/lib/texquery.php");
require_once('../../objects/qag/DefaultPaths.php');
require_once('../../objects/qag/QagAtozQuery.php');

/*
** Clear previous search
*/
//$EMuSession->ClearSession();

$letterRanges = array("[a-e]", "[f-j]", "[k-p]", "[q-u]", "[v-z]");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link rel="stylesheet" type="text/css" href="Query.css" />
	<title>QAG A-Z Creator/Culture list</title>
</head>
<body>
	<table id="HeaderTable">
		<tr>
    			<td id="HeaderCellLeft">
				<a href="http://www.qag.qld.gov.au"><img id="HeaderImage" src="images/qagLogo.gif"></img>
			</td>
			<td id="HeaderCellMiddle">
			</td>
			<td id="HeaderCellRight">
				<p>A-Z Creator/Culture list</p>
			</td>
		</tr>
	</table>
	<br>
	<table id="MainTable">
	<tr>
		<td colspan=10 align=right>
		<p>
		<a href="Query.php">Search</a>
		| <a href="AdvQuery.php">Advanced search</a>
		| <a href="DtlQuery.php">Detailed search</a>
		</p>
		<p></p>
		</td>
	</tr>
		<tr><td>
<?php
//Run
Topbar();
Splitletters();

function Topbar()
{
	//Out put link to top
	?>
	<a name="Top" id="Top"></a>
	<?php
	//Print link for each letters
	foreach (range(A, Z) as $LinkLetter) 
	{
		?>
		<a href="atoz.php?firstletter=<?php print $LinkLetter; ?>"><?php print $LinkLetter; ?></a>
		&nbsp;
		<?php
	}

	//print Link for 'View All'
	?>
	</td>
	<td aligh=right>
	<a href="atoz.php?firstletter=A-Z">View All</a>
	</td>
	<tr>
	<td colspan=10>
	<?php
}

Function Secondbar($firstLetter)
{
	global $letterRanges;

	// print the second bar based on the contents of the letterRanges array
	foreach($letterRanges as $letterRange) 
	{
		$remove = array("[", "-", "]");
		$add = array("$firstLetter", "-$firstLetter", "");
		$FirstThenRange = str_replace($remove, $add, $letterRange);  
		?>
		<a href="#<?php print $letterRange; ?>"><?php print $FirstThenRange; ?></a>
		&nbsp;
		<?php
	}
}


function Splitletters()
{
	global $letterRanges;
	//Get info from URL
	$Letter = $_REQUEST['firstletter'];

	if(preg_match("/-/", $Letter))
	{
		//if its a letter range split the letters. this is for view all
		list($Let1, $Let2) = split('-', $Letter);
	
		foreach (range($Let1, $Let2) as $RangeLetter) 
		{
   			Showlist($RangeLetter, "#");
		}
	}
	else
	{
		if ($Letter == "")
			$Letter = "A";
		//Show secon bar so user can choose letter groupings
		SecondBar($Letter);
		
		//if only one letter given use that, and the second letter grouping
		foreach($letterRanges as $letterRange) 
		{
			Showlist($Letter, $letterRange);
		}
	}
}

function Showlist($startLetter, $secondLetters)
{	
	global $TotalCount;

	if($secondLetters == "#") // is printing the View All
	{
		//Output a heading
		?>
		<h3><?php print $startLetter; ?></h3>
		<?php

		//clear second letter variable
		$secondLetters = "";
	}
	else //is printing individual letter
	{
		//Output link to this part of the page
		?>
		<a name="<?php print $secondLetters; ?>" id="<?php print $secondLetters; ?>"></a>
		<?php

		//Create title for each grouping
		$Title = $secondLetters;
	
		$remove = array("[", "-", "]");
		$add = array("$startLetter", "-$startLetter", "");

		$Title = str_replace($remove, $add, $Title);
	
		//Output a heading
		?>
		<h3><?php print $Title; ?></h3>
		<?php
	}

	//Add a star to the letter for the query
	$startLetter = $startLetter . $secondLetters ."*";
	

	//Run Query to find all terms that begin with that letter
	$qry = new Query();
	$qry->Select = array("Value000", "irn");
	$qry->From = 'eluts';
	$qry->Where = "NameText='Artist Name' and Value000 like '$startLetter'";
	$qry->Order = 'Value000';
	$qry->Internet = 0;
	$qry->Limit = 0;
	$results = $qry->Fetch();

	//Print the results
	for($i = 0; $i < $qry->Matches; $i++)	
	{
	?>
		<a href="
	<?php 
		$artistlink = new QagAtozQueryLink;
		$artistlink->DisplayPage = "ContactSheet.php";
		$artistlink->QueryTerms = array (
					"ArtArtistLocal" => $results[$i]->{'Value000'},
					);
		$artistlink->PrintRef();
		
	?>
		">
	<?php print htmlentities($results[$i]->{'Value000'}); 
	?>
		</a><br />
		<!--<a href="contactsheet.php?ArtArtistLocal=<?php print urlencode($results[$i]->{'Value000'}); ?>"><?php print htmlentities($results[$i]->{'Value000'}); ?></a><br />
		-->
	<?php
	}

	//Add to total count
	$TotalCount = $TotalCount + $qry->Matches;

	//Print the link back to the top of the page
	?>
	<br>
	<a href="#Top">Back to Top</a>
	<?php
	
}
?>

	</td>
	</tr>
	</table>
</body>
</html>
