<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Newcastle City Council Collections - Basic Search - Artsearch</title></head>

<body bgcolor="#ffffe8">

<table border="0" cellpadding="2" cellspacing="0" width="650">

	<tr>
    		<td valign="top" width="44%" height="331"><font color="#336699" face="Tahoma" size="5"><b>
		Basic Search - Artsearch ...</b></font>

	      <p>
		<font color="#336699" face="Tahoma" size="2">
Welcome to the <b>Newcastle City Council's</b> collections live search page. <br><br>
From here you can search the collection of the <b>Newcastle Region Art Gallery</b>.
<br><br>
By utilising the <b>NRAG</b> collection search you agree to accept the conditions of use in relation to the <i>Copyright Act 1968</i>.<br><br>
  
<b>COPYRIGHT STATEMENT</b><br><br>

   

   The Newcastle Region Art Gallery respects the rights of all artists and copyright holders. As a result, only images without copyright restrictions have been included on this website.<br><br>

    

    No image or information displayed on this site may be reproduced, transmitted or copied (other than for the purposes of private research or study) without the Newcastle Region Art Gallery's permission. Requests to view images that do not appear on our online database may be arranged by contacting the <a href="mailto:artgallery@ncc.nsw.gov.au">Newcastle Region Art Gallery</a>.<br><br>

     

     <b>ABORIGINAL AND TORRES STRAIT ISLANDER WARNING</b><br><br>

      

      Indigenous Australians are respectfully advised that Newcastle City Council's collections live search page may include images or names of Aboriginal and Torres Strait Islander peoples now deceased.<br><br>

      Key word searches can be performed in the main search box below. 

	      </font>
	      </p>

		<br>

<form method="post" action="ResultsList.php">

	<table border="0" cellpadding="0" cellspacing="4" width="100%">
	<tr align="left">
	<td>
	<?php
require_once('../../../objects/lib/webinit.php');
require_once('../../../objects/nrm/ngallery/QueryForms.php');

$queryform = new NrmBasicQueryForm;
$queryform->ResultsListPage = "ResultsList.php";
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->BodyTextColor = '#336699';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->Restriction = "TitObjectType = 'Art Search'";
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
