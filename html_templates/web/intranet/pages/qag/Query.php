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
				<p>Collection<b>Search</b></p>
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

		$queryform = new QagBasicQueryForm;
		$queryform->ResultsListPage = 'ResultsList.php';
		$queryform->FontFace = 'Tahoma, Arial';
		$queryform->FontSize = '2';
		$queryform->TitleTextColor = '#E9E9E9';
		$queryform->BorderColor = '#E9E9E9';
		$queryform->BodyColor = '#E9E9E9';
		$queryform->BodyTextColor = '#696969';
		$queryform->Border = 0;
		$queryform->Show();
	?>
	By using the QAG|GoMA Collection Search you agree to accept the conditions of use as stated below.
					</center>
				</div>

				<table id="BrowseTable">
					<tr>
						<td id="BrowseCell">
							<a href="atoz.php">A-Z Creator/Culture list</a>
						</td>
						<td id="BrowseCell">
							<a href="
	<?php
		require_once('../../../objects/common/PreConfiguredQuery.php');
		$pastdate = date("d-m-Y", mktime (0,0,0,date("m"),date("d"),  date("Y")-1));
		$MediaLink = new PreConfiguredQueryLink;
		$MediaLink->Where = "ArtDateOfAcquisition > DATE '" . $pastdate . "'";
		//$MediaLink->Where = "AdmDateModified > DATE '" . $pastdate . "'";
		$MediaLink->PrintRef();
	?>
	">Recent acquisitions</a>
						</td>
					</tr>
			</table>
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
			<p id="TextHeading">Images</p>
			<p id="Text"> Images are added as they become available. These images are for reference and research by Gallery staff only. They may not be reproduced, transmitted or copied for the public or other third party without first obtaining permission. A request for a high-resolution image for publication can be made through a link when the full-screen image is displayed.</p>
			<br>
</table>
<br>
<table id="MainTable">
	<tr>
		<td>
			<br>
			<p id="TextHeading">Copyright Statement</p>
			<p id="Text"> The Queensland Art Gallery respects the rights of all artists and copyright holders. No image may be reproduced, transmitted or copied without permission. Contravention is an infringement of Australia's  <i> Copyright Act 1968</i>. Requests from external sources for reproductions of the Gallery's artworks should be referred to <a href="mailto:publications@qag.qld.gov.au">Publications</a>.</p>
			<br>
			<p id="TextHeading">Warning to Aboriginal and Torres Strait Islander people</p>
			<p id="Text">We respectfully advise Aboriginal and Torres Strait Islander people that this site may include images or intellectual property that may be of a sensitive nature.</p>
			<br>
</table>
</body>

</html>
