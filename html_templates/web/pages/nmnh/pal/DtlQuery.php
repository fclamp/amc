<?php include "header-large.html" ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Department of Paleobiology Collections</title>
</head>

<body bgcolor="#AAC1C0">
	<br>
	<table border="0" width="63%" cellspacing="0" cellpadding="8">
		<tr> 
			<td width="10%" nowrap align="center" valign="top"> 
			<p align="center">
				<img border="0" src="images/Plantae_Pecopteris_USNM_444624.jpg" width="84" height="123"><br>
			<a href="Display.php?irn=3305710"><font face="Tahoma" size="1"><i>Pecopteris</i></font></a><br>
			<font face="Tahoma" size="1">Fern<br>
			Photograph by<br>
			Chip Clark</font>
			</p>
			</td>
			<td width="90%" align="left" valign="top">
			<p>
				<font face="Tahoma" color="#013567" size="2">
					<p>
						<b>Detailed Search of the Paleobiology Collection</b>
					</p>
					<p>
						Enter any terms in the boxes below and click on the "Search" button. To return to the Basic Search screen, click on the link beneath the search box.
					</p>
					<p>
						Searches will produce a maximum of 5,000 records, sorted by taxonomy. Refining searches with additional terms may be advised. It is possible to create searches which will not return any results, e.g. Dinosaur and Tertiary, or United Kingdom and Montana. Certain fields, such as common name and some taxonomic levels, are not populated for all records. Some specimen records are in a brief format, which excludes locality, stratigraphic, and citation data, and can only be searched using catalog number, taxonomy, or collection name. Precise locality is not available online for all records.
					</p>
				</font>
			</p>
			</td>
		</tr>
	</table>
	<br>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/pal/QueryForms.php');
			$queryform = new NmnhPalDetailedQueryForm;
			$queryform->Title = 'Enter search term(s)...';
			$queryform->ResultsListPage = 'ResultsList.php';
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
		<font color="#336699" face="Tahoma">
			<a href="Query.php"><b>Basic Search</b></a>
		</font>
		</p>
	</blockquote>
	<?php include "footer.php" ?>
</body>
</html>
