<?php
require_once('../../objects/qag/QagSessions.php');
$sess = new QagSession;
$sess->CacheLimitPublic = 1;
$sess->ClearSession();
$sess->SaveVar("SessionsOn", 1);
?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link rel="stylesheet" type="text/css" href="Query.css">
	<title>QAG Collection Search</title>
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
				<p>Asia Pacific Collection Online</p>
			</td>
		</tr>
	</table>

	<br>

	<table id="MainTable">
		<tr>
			<td>
				<div id="QueryForm">
					<center>
	<?php

		require_once('../../objects/qag/QueryForms.php');
		$queryform = new QagDetailedQueryForm;
		$queryform->ResultsListPage = "ResultsList.php";
		$queryform->FontFace = 'Verdana';
		$queryform->FontSize = '2';
		$queryform->TitleTextColor = '#E9E9E9';
		$queryform->BorderColor = '#E9E9E9';
		$queryform->BodyColor = '#E9E9E9';
		$queryform->BodyTextColor = '#696969';
		$queryform->Show();
	?>
	By using the QAG | GoMA Asia Pacific Collection Online search you agree to accept the conditions of use as per the Copyright Statement.
					</center>
				</div>

				<table id="ViewTable">
					<tr>
						<td>
							<p id=SearchView>
								<a href="Query.php">Basic search</a>
								| <a href="AdvQuery.php">Advanced search</a>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
