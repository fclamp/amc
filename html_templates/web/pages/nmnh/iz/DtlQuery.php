<?php include "header-large.html" ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
	<meta name="ProgId" content="FrontPage.Editor.Document">
	<title>Search the NMNH Department of Invertebrate Zoology</title>
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
			<p>
				<font face="Tahoma" color="#013567" size="2">
					<b>Detailed Search of the Invertebrate Collections</b><br>
					<br>
					Enter any terms in the boxes below and click on the "Search" button. 
					For other search types, select one of the options beneath the search box.
				</font>
			</p>
			<p>
				<font face="Tahoma" color="#003366" size="2">
					Partial words may be entered using an asterisk (*) for a wildcard. 
					If you choose to enter more than one term in a field, only records with both terms will be returned.
				</font>
			</p>
			<p>
				<font face="Tahoma" color="#003366" size="2">
					Wildcard searches may be quite slow, please be patient.<br>
				</font>
			</p>
			</td>
		</tr>
	</table>
	<br>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/iz/QueryForms.php');
			$queryform = new NmnhIzDetailedQueryForm;
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
