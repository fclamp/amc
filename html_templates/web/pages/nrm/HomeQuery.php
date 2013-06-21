<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Newcastle City Council Collections - Search Our Collection...</title></head>

<body bgcolor="#ffffe8">

<table border="0" cellpadding="2" cellspacing="0" width="650">

	<tr>
    		<td valign="top" width="44%" height="331"><font color="#336699" face="Tahoma" size="5"><b>
		 Search Our Collection ...</b></font>

	      <p>
		<font color="#336699" face="Tahoma" size="2">
		Welcome to the <b>Newcastle City Council's</b> collections live search page. 

		<br><br>From here you can search the collections of the <b>Newcastle Region Art Gallery</b>, the <b>Newcastle Region Library</b> and the <b>Newcastle Regional Museum</b>.<br>
		<br>Indigenous Australians are advised that Newcastle City Council's collection's live search page may include images or names of people now deceased
	      </font>
	      </p>
	      <p><font color="#336699" face="Tahoma" size="2">Key word searches can be
	      performed in the main search box below.&nbsp;</font></p>

		<br>

<form method="post" action="ResultsList.php">
<input name="col_TitObjectType" value="" type="hidden">

	<table border="0" cellpadding="0" cellspacing="4" width="100%">
	<tr align="left">
	<td>
	<?php
require_once('../../objects/nrm/QueryForms.php');

$queryform = new NrmBasicQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#336699';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BodyColor = '#FFFFE8';
$queryform->BorderColor = '#336699';
$queryform->HelpPage = '../shared/help/GalleryBasicQueryHelp.php';
$queryform->Show();
?>
</td>

	
	
	
	
	<!-- <td valign="top">
		<b><font color="#000000" face="Tahoma, Arial" size="2">Find: </font></b>
		<input name="QueryName" value="BasicQuery" type="hidden">
		<input name="QueryPage" value="HomeQuery.php" type="hidden">
		<input name="Restriction" value="" type="hidden">
		<input name="StartAt" value="1" type="hidden">
		<input name="any" value="SummaryData|AdmWebMetadata" type="hidden">
		<input name="title" value="TitMainTitle|TitTitleNotes" type="hidden">
		<input name="notes" value="NotNotes|TitTitleNotes" type="hidden">
		<input name="artist" value="CreCreatorLocal_tab" type="hidden">
		<input name="place" value="CreCountry_tab" type="hidden">
		<input class="WebInput" name="QueryTerms" type="text">
<select name="QueryOption"><option value="any">anywhere</option><option value="title">in title</option><option value="notes">in notes</option><option value="artist">in artist details</option><option value="place">in creation place</option></select>&nbsp;&nbsp;&nbsp;
		<input class="WebInput" name="Submit" value="Search" type="submit">
	</td> -->


	</tr>
	</table>
</form>

<P align=center><FONT face=Tahoma><U><FONT color=#0000ff><A 
href="AdvQuery.php">Advanced 
search</A></FONT></U><FONT color=#003366> | </FONT><FONT color=#0000ff><U><A 
href="DtlQuery.php">Detailed 
search</A></U> | <U><a href="../shared/help/GalleryBasicQueryHelp.php">Help</a></U></FONT></FONT></P>
<P align=center><FONT size=-1><FONT face=Arial>© Newcastle City Council 
2005</FONT></FONT> </P>

		</td>
	</tr>
</table>

</body>
</html>
