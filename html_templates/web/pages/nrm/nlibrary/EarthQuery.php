<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Newcastle City Council Collections - Basic Search - Earthquake Database</title></head>

<body bgcolor="#ffffe8">

<table border="0" cellpadding="2" cellspacing="0" width="650">

	<tr>
    		<td valign="top" width="44%" height="331"><font color="#336699" face="Tahoma" size="5"><b>
		Basic Search - Earthquake Database ...
		</b></font>

	      <p>
		<font color="#336699" face="Tahoma" size="2">
		The Newcastle Earthquake Database is a comprehensive collection of published and unpublished records, photographs, audio and video information on the 1989 Newcastle Earthquake. There are  3600 bibliographical records with abstracts available on the database. Of these, 2800 records are available as electronic full text records and there are digitised images, sound and video files.<br><br>

		Have an enquiry?  Contact the <a href="mailto:sryan@ncc.nsw.gov.au">Local Studies Library</a>.

	      </font>
	      </p>
	      <p><font color="#336699" face="Tahoma" size="2">Key word searches can be
	      performed in the main search box below.&nbsp;</font></p>

		<br>

<form method="post" action="ResultsList.php">

	<table border="0" cellpadding="0" cellspacing="4" width="100%">
	<tr align="left">
	<td>
	<?php
require_once('../../../objects/lib/webinit.php');
require_once('../../../objects/nrm/nlibrary/QueryForms.php');

$queryform = new NrmBasicQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#336699';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->Restriction = "TitObjectType = 'Earthquake'";
$queryform->BodyColor = '#FFFFE8';
$queryform->BorderColor = '#336699';
$queryform->Show();
?>
</td>


	</tr>
	</table>
</form>

<P align=center><FONT face=Tahoma><U><FONT color=#0000ff><A 
href="AdvQuery.php">Advanced 
search</A></FONT></U><FONT color=#003366> | </FONT><FONT color=#0000ff><U><A 
href="DtlQuery.php">Detailed 
search</A></U> | <U><a href="../../shared/help/GalleryBasicQueryHelp.php">Help</a></U></FONT></FONT></P>
<P align=center><FONT size=-1><FONT face=Arial>© Newcastle City Council 
2005</FONT></FONT> </P>

		</td>
	</tr>
</table>

</body>
</html>
