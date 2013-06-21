<center>
	<?php include "header-small.html" ?>
</center>
<html>
	<head>
		<title>Search the NMNH Department of Botany</title>
	</head>
	<body bgcolor="#AAC1C0">
		<center>
		<br>
		<br>
		<table width="570" border="0" cellspacing="3" cellpadding="3">
			<tr>
				<td align="left" valign="top" height="30" colspan="3">
					<font face="Tahoma" color="#013567" size="3">
						<a href="Query.php"><b>Basic Search</b></a>
					</font>
			                <font color="#000000">
                        			&nbsp; |&nbsp;&nbsp;
                			</font>
                			<font face="Tahoma" color="#0000FF">
                        			<a href="DtlQuery.php"><b>Detailed Search</b></a>
                			</font>
					<br>
				</td>
			</tr>
			<tr> 
				<td align="left" valign="top" height="30" colspan="3">
					<font face="Tahoma" color="#013567" size="3">
					Click on the name for species collection records.
					</font>
				</td>
			</tr>
			<tr align="left"> 
				<td valign="top" height="318"><img src="rotation/Asclepias_curassavica.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Asclepias curassavica') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Asclepias curassavica</i></font></a><br>
				</td>

				<td valign="top" height="318"><img src="rotation/Asclepias_tuberosa.jpg"><br>
		       		<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Asclepias tuberosa') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Asclepias tuberosa</i></font></a>
				</td>

				<td nowrap valign="top" height="318"><img src="rotation/Bocconia_macbrideana.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Bocconia macbrideana') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font size="2" face="Tahoma"><i>Bocconia macbrideana</i></font></a>
				</td>
			</tr>

			<tr align="left"> 
				<td valign="top" height="318"><img src="rotation/Calycanthus_floridus.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Calycanthus floridus') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font size="2" face="Tahoma"><i>Calycanthus floridus</i></font></a><br>
				</td>

				<td valign="top" height="318"><img src="rotation/Chrysopsis_mariana.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Chrysopsis mariana') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Chrysopsis mariana</i></font></a><br>
				</td>

				<td nowrap valign="top" height="318"><img src="rotation/Columnea_arguta.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Columnea arguta') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Columnea arguta</i></font></a><br>
				</td>
			</tr>

			<tr align="left"> 
				<td valign="top" height="318"> <img src="rotation/Kaempferia_rotunda.jpg"><br> 
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Kaempferia rotunda') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Kaempferia rotunda</i></font></a>
				</td>
      
				<td valign="top" height="318"><img src="rotation/Lebronnecia_kokioides.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Lebronnecia kokioides') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Lebronnecia kokioides</i></font></a>
				</td>
				
				<td nowrap valign="top" height="318"><img src="rotation/Schiedea_hookeri.jpg"><br>
				<a href="
					<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Schiedea hookeri') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
					?>"><font face="Tahoma" size="2"><i>Schiedea hookeri</i></font></a><br>
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" height="30" colspan="3">
					<font face="Tahoma" color="#013567" size="3">
						<a href="Query.php"><b>Basic Search</b></a>
					</font>
			                <font color="#000000">
                        			&nbsp; |&nbsp;&nbsp;
                			</font>
                			<font face="Tahoma" color="#0000FF">
                        			<a href="DtlQuery.php"><b>Detailed Search</b></a>
                			</font>
					<br>
				</td>
			</tr>
			<tr> 
				<td colspan="3"><?php include "footer.php" ?></td>
			</tr>
		</table>
		</center>
	</body>
