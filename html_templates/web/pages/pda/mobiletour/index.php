<html>



<body bgcolor="#EOF5DF">
<center><b><h1><FONT face="tahoma" color="#013567">EMu PDA Interface</font></h1></b></center>

<!-- Begin simple query form - query forms are very basic HTML forms so no need for PHP.  Just use static html -->


<form method="post" action="pdaresults.php">
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr align="center"><td valign="top">
		<b>Enter your search terms:</b></td></tr>
		<tr align="center"><td valign="top">

		<input type="hidden" name="QueryName" value="BasicQuery" />
		<input type="hidden" name="QueryPage" value="/web/pages/pda/mobiletour/Query.php" />
		<input type="hidden" name="Restriction" value="" />

		<input type="hidden" name="StartAt" value="1" />
		<input type="hidden" name="any" value="SummaryData|AdmWebMetadata|NarTitle|NarNarrative" />
		<input type="hidden" name="title" value="NarTitle" />
		<input type="hidden" name="narrative" value="NarNarrative" />

		<input class="WebInput" type="text" name="QueryTerms" /></td></tr>
		<tr align="center"><td valign="top">
<select name="QueryOption">			<option value="any">anywhere</option>

			<option value="title">in title</option>
			<option value="narrative">in narrative</option>
</select></td></tr>
		<tr align="center"><td valign="top">
		<input class="WebInput" type="submit" name="Submit" value="Search" />
	</td></tr>

	</table>
</form>


<!-- End simple query form -->

<div align="center">


<!-- Begin PreConfiguredQueryLink's - use standard PreConfiguredQueryLink object -->
<b>Or select to browse:</b><br />

<a href=<?php
	require_once("../../../objects/common/PreConfiguredQuery.php");
	$MediaLink = new PreConfiguredQueryLink();
	$MediaLink->ResultsListPage = "pdaresults.php";
	$MediaLink->Where = "MulHasMultiMedia = 'y'";
	$MediaLink->PrintRef();
	?>
	>Narratives with Multimedia</a><br />

<a href=<?php
	require_once("../../../objects/common/PreConfiguredQuery.php");
	$MediaLink = new PreConfiguredQueryLink();
	$MediaLink->ResultsListPage = "pdamediaresults.php";
	$MediaLink->Where = 
	"(MulMimeFormat = 'x-ms-wma') or (MulMimeFormat = 'x-ms-wmv')";
	$MediaLink->PrintRef();
	?>
	>Windows Streaming Media</a><br />

<a href="NarHighlights.php">Narrative Highlights</a><br />
<a href="reader.php">KE Mobile Tour</a><br />

<!-- End PreConfiguredQueryLink's -->

<br />
<br />
<font face="helvetica, arial, sans-serif" size="1">(C) KE Software 2000-04</font>
</body>
</html>
