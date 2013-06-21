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
		require_once('../../objects/qag/DisplayObjects.php');
		$display = new QagStandardDisplay;
		$display->Intranet = 1;
		$display->FontFace = 'Tahoma';
		$display->FontSize = '2';
		#$display->BodyTextColor = '#000000';
		$display->BorderColor = '#E9E9E9';
		$display->HeaderTextColor = '#000000';
		$display->BodyColor = '#E9E9E9';
		$display->HighlightColor = '#E9E9E9';
		//var_dump($_REQUEST);
		$display->Show();
?>
				</center>
			</td>
		</tr>
	</table>

</body>

</html>
