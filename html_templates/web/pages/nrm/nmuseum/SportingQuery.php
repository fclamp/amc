<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Newcastle City Council Collections - Basic Search - Sporting Hall of Fame</title></head>

<body bgcolor="#ffffe8">

<table border="0" cellpadding="2" cellspacing="0" width="650">

	<tr>
    		<td valign="top" width="44%" height="331"><font color="#336699" face="Tahoma" size="5"><b>
		Basic Search - Sporting Hall of Fame ...
		</b></font>

	      <p>
		<font color="#336699" face="Tahoma" size="2">

		Welcome to the <b>Newcastle City Council's</b> collections live search page. <br><br>

		The <b>Newcastle Regional Museum</b> is committed to the presentation and preservation of social & community history, science and the natural environment. The Museum tells the stories of both ordinary and extraordinary Newcastle.<br><br>

		 

		 We preserve and display our collection of some 10,000 social, Indigenous, technological and natural history objects, which covers the broad spectrum of Newcastle's story.<br><br>

		  

		  The Newcastle Regional Museum is responsible for the Museum Collection, Digger's Database and the Sporting Hall of Fame Database.<br><br>

		   

		   <b>Sporting Person Database</b><br><br>

		    

		    The Hunter Sports Database and the Hunter Region Sporting Hall of Fame document the sporting achievements of the regions best sports people.<br><br>

		     

		     From here you can search for pen portraits, images and the records of over 800 champions from the Hunter area in all fields of sporting endeavour.<br><br>

		      

		      Indigenous Australians are advised that the Sporting Person Database may include images or names of people now deceased.<br><br>


	      </font>
	      </p>
	      <p><font color="#336699" face="Tahoma" size="2">Key word searches can be
	      performed in the main search box below.&nbsp;</font></p>

		<br>

<form method="post" action="ResultsList.php">
<input name="col_TitObjectType" value="Sporting Person" type="hidden">

	<table border="0" cellpadding="0" cellspacing="4" width="100%">
	<tr align="left">
	<td>
	<?php
require_once('../../../objects/lib/webinit.php');
require_once('../../../objects/nrm/nmuseum/QueryForms.php');

$queryform = new NrmBasicQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#336699';
$queryform->Restriction = "TitObjectType = 'Sporting Person'";
$queryform->TitleTextColor = '#FFFFFF';
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
<P align=center><FONT size=-1><FONT face=Arial>� Newcastle City Council 
2005</FONT></FONT> </P>

		</td>
	</tr>
</table>

</body>
</html>
