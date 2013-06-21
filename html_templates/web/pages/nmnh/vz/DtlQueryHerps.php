<?php include "header-large-herps.html" ?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Division of Amphibians & Reptiles Collections</title>
</head>

<body bgcolor="#AAC1C0">
	<br>
	<table border="0" width="814" cellspacing="0" cellpadding="8">
		<tr> 
			<td width="10%" nowrap align="center" valign="top" height="180"> 
				<p align="center"><img src="images/Eleutherodactylus_griphus.gif"> 
				</p>
			</td>
			<td width="90%" align="left" valign="top"> 
				<p>
					<font face="Tahoma" color="#013567" size="2">
						<b>Detailed Search of the Amphibians & Reptiles Collection</b><br>
						<br>
						Enter any terms in the boxes below and click on the "Search" button. To return to the Basic Search screen, click on the link beneath the search box.<br>
						<br>
						Please be aware that some searches on single, broad terms may produce very large result sets that require long processing times. Therefore, narrowing searches with additional terms is strongly advised. Currently result lists are sorted by taxonomic group only up to a limit of 5000 records.
					</font>
				</p>
			</td>
		</tr>
	</table>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/vz/QueryForms.php');
			$queryform = new NmnhVzHerpsDetailedQueryForm;
			$queryform->ResultsListPage = 'ResultsListHerps.php';
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
				<a href="QueryHerps.php"><b>Basic Search</b></a>
			</font>
		</p>
	</blockquote>

	<?php include "footerHerps.php" ?>
</body>
</html>
