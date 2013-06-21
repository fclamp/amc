<?php include "header-large-mammals.html" ?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Division of Mammals Collections</title>
</head>

<body bgcolor="#AAC1C0">
	<br>
	<table border="0" width="814" cellspacing="0" cellpadding="8">
		<tr> 
			<td width="10%" nowrap align="center" valign="top" height="180"> 
				<p align="center"><img src="images/detailed_search_mammals.jpg"> 
				</p>
			</td>
			<td width="90%" align="left" valign="top"> 
				<p>
					<font face="Tahoma" color="#013567" size="2">
						<b>Detailed Search of the Mammal Collection</b><br>
						<br>
						Enter any terms in the boxes below and click on the "Search" button. 
						Clear the Museum field to blank and select Whale Collection in the Special Collections field to 
						search for whale event and observation (non-specimen) records. 
						To return to the Basic Search screen, click on the link beneath the search box.<br>
						<br>
						Currently results are truncated at a limit of 5000 records, sorted by taxonomic group. 
						Please be aware that some searches on single, broad terms may correspond to a far greater number 
						of records, therefore narrowing searches with additional terms is strongly advised.
					</font>
				</p>
			</td>
		</tr>
	</table>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/vz/QueryForms.php');
			$queryform = new NmnhVzMammalsDetailedQueryForm;
			$queryform->ResultsListPage = 'ResultsListMammals.php';
			$queryform->Title = 'Enter search term(s)...';
			$queryform->FontFace = 'Arial';
			$queryform->Width = '814';
			$queryform->FontSize = '2';
			$queryform->BodyTextColor = '#013567';
			$queryform->TitleTextColor = '#FFFFFF';
			$queryform->BorderColor = '#013567';
			$queryform->BodyColor = '#FFF3DE';
			$queryform->SecondSearch = 1;
			$queryform->Show();
		?>
	</div>

	<blockquote>
		<p align="left">
			<font color="#336699" face="Tahoma" size="3">
				<a href="QueryMammals.php"><b>Basic Search</b></a>
			</font>
		</p>
	</blockquote>

	<?php include "footerMammals.php" ?>
</body>
</html>
