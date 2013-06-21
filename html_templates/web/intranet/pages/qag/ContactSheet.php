<?php
require_once('../../objects/qag/QagSessions.php');
$sess = new QagSession;
$SessionsWorking = $sess->GetVar("SessionsOn");
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link rel="stylesheet" type="text/css" href="Query.css">
	<title>QAG Search Results</title>
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
				<p>Collection<b>Search</b></p>
			</td>
		</tr>
	</table>

	<br>

	<table id="MainTable">
		<tr>
			<td>
				<center>
	<?php
		require_once('../../objects/qag/ResultsLists.php');

		$resultlist = new QagContactSheet;
		//$resultlist->QueryPage = preg_replace('/atoz/', 'Query', $resultlist->QueryPage);
		$resultlist->Intranet = 1;
		$resultlist->BodyColor = '#E9E9E9';
		$resultlist->Width = '80%';
		$resultlist->HighlightTextColor = '#E9E9E9';
		$resultlist->FontFace = 'Tahoma';
		$resultlist->FontSize = '2';
		//$resultlist->TextColor = '#000000';
		$resultlist->HeaderColor = '#E9E9E9';
		$resultlist->BorderColor = '#E9E9E9';
		$resultlist->HeaderTextColor = '#000000';
		$resultlist->Show();

		// Get the current page url with all values
		$RList = "";
		$perams = $_REQUEST;
		if(empty($perams))
		{
			$perams = array_merge($GLOBALS['HTTP_POST_VARS'],
				$GLOBALS['HTTP_GET_VARS']);
		}
		while(list($key, $val) = each($perams))
		{ 
			// Don't pass through empty vars 
			// try to keep url length down
			if ($val == '')
				continue;
			$key = urlencode(stripslashes($key)); 
			$val = urlencode(stripslashes($val)); 
			$getString .= "$key=$val&amp;"; 
		} 
		$thisPage = isset($GLOBALS['PHP_SELF'])
			? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		if ($SessionsWorking == 1 && $getString != "")
			$RList = "$thisPage?$getString";

		// Get list of IRNs for the display
		$IrnList = array();
		if ($resultlist->BackLink != "")
			array_push($IrnList, $resultlist->BackLink);
		$recNum = count($resultlist->records);
		if ($recNum > $_REQUEST["LimitPerPage"])
			$recNum = $recNum - 1;
		if ($SessionsWorking == 1 && $resultlist->Matches > 0)
		{
			for ($i = 0; $i < $recNum; $i++)
			{
				$irn = $resultlist->records[$i]->irn_1;
				array_push($IrnList, $irn);
			}
		}
		if ($resultlist->NextLink != "")
			array_push($IrnList, $resultlist->NextLink);
		if ($SessionsWorking)
		{
			$sess->SaveVar("IrnList", $IrnList);
			$sess->SaveVar("RList", $RList);
		}
//var_dump($IrnList);
	?>
				</center>
			</td>
		</tr>
	</table>

</body>

</html>
