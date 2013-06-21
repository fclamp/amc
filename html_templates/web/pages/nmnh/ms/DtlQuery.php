<?php include "header-large.html" ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Department of Mineral Sciences</title>
</head>

<body bgcolor="#AAC1C0">
	<br>
	<table border="0" width="63%" cellspacing="0" cellpadding="8">
		<tr> 
			<td width="10%" nowrap align="center" valign="top"> 
			<p align="center">
				<img border="0" src="images/pearson_diamond.jpg">
			</p>
			</td>

			<td width="90%" align="left" valign="top">
			<p>
				<font face="Tahoma" color="#013567" size="2">
					<b>Detailed Search of the Mineral Sciences Collections</b><br>
					<br>
					Enter any terms in the boxes below and click on the "Search" button. 
					For other search types, select one of the options beneath the search box.
			</p>
			<p>
					Partial words may be entered using an asterisk (*) for a wildcard. Wildcard searches may be quite slow, please be patient.
					If you choose to enter more than one term in a field, only records with both terms will be returned.
			</p>
			<p>
					 Please be aware that some searches on single, broad terms may produce very large result sets that require long processing times. Therefore, narrowing searches with additional terms should be considered. Searches will return a maximum of 5000 records, and the results are sorted by Meteorite Name (when present) and Catalog Number.<br>
					 <br>
					 Please note: we have electronic records for more than 90% of our collections, but images for less than 10%. We constantly add new data and correct records. If searches do not return expected data users are welcome to <a href="http://www.mineralsciences.si.edu/contact.htm">contact Department of Mineral Sciences collection managers</a>.<br>
				</font>
			</p>
			</td>
		</tr>
	</table>
	<br>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/ms/QueryForms.php');
			$queryform = new NmnhMsDetailedQueryForm;
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
