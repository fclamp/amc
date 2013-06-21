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
				<img border="0" src="images/GV_Beetle000083sm.jpg" width="84" height="123">
			</p>
			</td>

			<td width="90%" align="left" valign="top">
			<p>
				<font face="Tahoma" color="#013567" size="2">
					<b>Detailed Search of the Department of Entomology Collections</b><br>
					<br>
					Enter or select appropriate terms in the boxes below and click on the "Search" button. To return to the Basic Search screen, select the link beneath the search form.
				</font>
			</p>
			<p>
				<font face="Tahoma" color="#003366" size="2">
					Please be aware that searches on a single, broad term may produce very large result sets following long processing times. Therefore, narrowing searches with additional terms is strongly advised.  It is also possible to create searches that will produce no results, e.g. "Canada" and "Montana" or "Odonata" and "Apidae".  Partial words may be entered using an asterisk (*) wildcard, however such searches may be quite slow; please be patient. If you choose to enter more than one term in a field, only records including both terms will be returned.
				</font>
			</p>
			<p>
				<font face="Tahoma" color="#003366" size="2">
					Currently results lists are sorted by taxonomic group and limited to 2000 records.
				</font>
			</p>
			</td>
		</tr>
	</table>
	<br>

	<div align="left">
		<?php
			require_once('../../../objects/nmnh/ento/QueryForms.php');
			$queryform = new NmnhEntoDetailedQueryForm;
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
			<font color="#000000">
				&nbsp; |&nbsp;&nbsp;
			</font>
			<font face="Tahoma" color="#0000FF">
				<a href="DtlQueryIA.php"><b>Illustration Archive</b></a>
			</font>
		</p>
	</blockquote>
	<?php include "footer.php" ?>
</body>
</html>
