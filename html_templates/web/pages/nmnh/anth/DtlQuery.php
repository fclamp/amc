<?php include "header-large.html" ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Department of Anthropology Collections</title>
</head>

<body bgcolor="#AAC1C0">
	<br>
	<table border="0" width="63%" cellspacing="0" cellpadding="8">
		<tr> 
			<td width="10%" nowrap align="center" valign="top"> 
			<p align="center">
				<img border="0" src="images/gastropod.jpg" width="84" height="123">
			</p>
			</td>

			<td width="90%" align="left" valign="top">
			<font face="Tahoma" color="#013567" size="2">
				<p>
					<b>Detailed Search of the Anthropology Collections</b><br>
					<br>
					Enter your search terms in the boxes below and click on the "Search" button. Please note the <a href="searchcharacters.html" target="_blank">special characters</a> that can help refine your search. Additional search tips are found in the <a href="http://acsmith.si.edu/anthroDBintro.html">Introduction</a>.
				</p>
				<p>
					Searches will return a maximum of 5000 records. Larger datasets process more slowly, so consider using additional search terms to narrow the results.
				</p>
			</font>
			</td>
		</tr>
	</table>
	<br>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/anth/QueryForms.php');
			$queryform = new NmnhAnthDetailedQueryForm;
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
