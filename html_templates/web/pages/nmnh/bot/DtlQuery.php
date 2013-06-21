<?php include "header-large.html" ?>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Department of Botany</title>
</head>

<body bgcolor="#AAC1C0">
	<br>
	<table border="0" width="814" cellspacing="0" cellpadding="8">
		<tr> 
			<td width="10%" nowrap align="center" valign="top"> 
				<p align="center"><img border="0" src="images/Cyanotis.jpg" width="84" height="123">
			</td>
			<td width="90%" align="left" valign="top">
				<p>
					<font color="#013567" size="2" face="Tahoma">
						<b>Detailed Search of the Botany Collections</b><br>
						<br>
						Enter any terms in the boxes below and click on the "Search" button. 
						For other search types, select one of the options beneath the search box.
					</font>
				</p>
				<p>
					<font color="#013567" size="2" face="Tahoma">
						Please be aware that some searches on single, broad terms may produce very large result sets 
						that require long processing times. Therefore, narrowing searches with additional terms should be considered.
						Searches will return a maximum of 2000 records and the results are sorted by taxonomic group. 
						If you need to retrieve a larger record set, contact the Department of Botany's 
						<a href="mailto:russellr@si.edu">Collections Manager</a>.
					</font>
				</p>
			</td>
		</tr>
	</table>
	<br>
	
	<div align="left">
	<?php
		require_once('../../../objects/nmnh/bot/QueryForms.php');
		$queryform = new NmnhBotanyDetailedQueryForm;
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
		<p align="left"><font color="#336699" face="Tahoma"><a href="Query.php"><b>Basic Search</b></a></font></p>
	</blockquote>

	<?php include "footer.php" ?>

</body>
</html>
