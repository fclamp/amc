<html>
<body bgcolor="#DDDDDD">
<img align=middle src="images/productlogo.gif">
<font face="Helvetica, Arial, sans-serif" size="3" color="#000000"><b> for PDA's</b></font>
<br />
<br />

<!-- Begin simple query form - query forms are very basic HTML forms so no need for PHP.  Just use static html -->
<form method="post" action="pdaresults.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="4">
	<tr align="center"><td valign="top">
		<b><font face="Helvetica, Arial, sans-serif" size="3" color="#000000">Enter your search terms:</font></b></td></tr>
		<tr align="center"><td valign="top">
		<input type="hidden" name="QueryName" value="BasicQuery" />
		<input type="hidden" name="QueryPage" value="/web/pages/gallery/Query.php" />
		<input type="hidden" name="Restriction" value="" />

		<input type="hidden" name="StartAt" value="1" />
		<input type="hidden" name="any" value="SummaryData|AdmWebMetadata" />
		<input type="hidden" name="title" value="TitMainTitle|TitTitleNotes" />
		<input type="hidden" name="notes" value="NotNotes|TitTitleNotes" />
		<input type="hidden" name="artist" value="CreCreatorLocal_tab" />
		<input type="hidden" name="place" value="CreCountry_tab" />
		<input class="WebInput" type="text" name="QueryTerms" /></td></tr>
		<tr align="center"><td valign="top">
<select name="QueryOption">			<option value="any">anywhere</option>

			<option value="title">in title</option>
			<option value="notes">in notes</option>
			<option value="artist">in artist details</option>
			<option value="place">in creation place</option>
</select></td></tr>
		<tr align="center"><td valign="top">
		<input class="WebInput" type="submit" name="Submit" value="Search" />
	</td></tr>

	</table>
</form>
<!-- End simple query form -->

<div align="center">
<br />
<font face="Helvetica, Arial, sans-serif" size="3" color="#000000">

<!-- Begin PreConfiguredQueryLink's - use standard PreConfiguredQueryLink object -->
<b>Or select to browse:</b><br />
<a href=<?php
	require_once("../../../objects/common/PreConfiguredQuery.php");
	$AllLink = new PreConfiguredQueryLink();
	$AllLink->ResultsListPage = "pdaresults.php";
	$AllLink->Where = "TRUE";
	$AllLink->PrintRef();
	?>
	>All Records</a><br />
<a href=<?php
	$MediaLink = new PreConfiguredQueryLink();
	$MediaLink->ResultsListPage = "pdaresults.php";
	$MediaLink->Where = "MulHasMultiMedia = 'y'";
	$MediaLink->PrintRef();
	?>
	>Records with Multimedia</a><br />
<!-- End PreConfiguredQueryLink's -->

<br />
<br />
<font face="helvetica, arial, sans-serif" size="1">All content (C) KE Software</font>
</body>
</html>
