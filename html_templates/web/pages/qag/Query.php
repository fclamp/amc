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
			</td>
			<td id="HeaderCellMiddle">
				<a href="http://www.qag.qld.gov.au"><img id="HeaderImage" src="images/qagLogo.gif"></img>
			</td>
			<td id="HeaderCellRight">
			</td>
		</tr>
	</table>

	<br>
	<center>
		<p id="HeaderCellRight">Asia Pacific Collection Online</p>
	</center>
	<br>

	<table id="MainTable">
		<tr>
			<td>
				<div id="QueryForm">
					<center>
	<?php
		require_once('../../objects/qag/QueryForms.php');

		$queryform = new QagBasicQueryForm;
		$queryform->ResultsListPage = 'ResultsList.php';
		$queryform->FontFace = 'Verdana';
		$queryform->FontSize = '2';
		$queryform->TitleTextColor = '#E9E9E9';
		$queryform->BorderColor = '#E9E9E9';
		$queryform->BodyColor = '#E9E9E9';
		$queryform->BodyTextColor = '#696969';
		$queryform->Border = 0;
		$queryform->Show();
	?>
	By using the QAG | GoMA Asia Pacific Collection Online search you agree to accept the conditions of use as per the Copyright Statement.
					</center>
				</div>

				<!--<table id="BrowseTable">
					<tr>
						<td id="BrowseCell">
							<a href="atoz.php">A-Z Creator/Culture list</a>
						</td>
						<td id="BrowseCell">
							<a href="
	<?php
		require_once('../../objects/common/PreConfiguredQuery.php');
		$pastdate = date("d-m-Y", mktime (0,0,0,date("m"),date("d"),  date("Y")-1));
		$MediaLink = new PreConfiguredQueryLink;
		$MediaLink->Where = "ArtDateOfAcquisition > DATE '" . $pastdate . "'";
		//$MediaLink->Where = "AdmDateModified > DATE '" . $pastdate . "'";
		$MediaLink->PrintRef();
	?>
	">Recent acquisitions</a>
						</td>
					</tr>
			</table>-->
			<table id="ViewTable">
				<tr>
					<td>
						<p id=SearchView>
							<a href="AdvQuery.php">Advanced search</a>
							| <a href="DtlQuery.php">Detailed search</a>
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>
<table id="MainTable">
	<tr>
		<td>
			<br>
			<p id="TextHeading"><b>Copyright Statement</b></p>
			<p id="Text"> The Queensland Art Gallery respects the rights of all artists and copyright holders. No image may be reproduced, transmitted or copied without permission. Contravention is an infringement of Australia's  <i> Copyright Act 1968</i>. Requests for reproduction and pulication of the Gallery's art works should be referred to <a href="mailto:publications@qag.qld.gov.au">Publications</a>.</p>
			<br>
</table>
<br>
<table id="MainTable">
	<tr>
		<td>
			<br>
			<center>
				<img id="FooterImage" src="images/gdfLogo.gif"></img>
				<p>Supported by the Gordon Darling Foundation</p>
			</center>
			<br>
</table>

</body>

</html>
