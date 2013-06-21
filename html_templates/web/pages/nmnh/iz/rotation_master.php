<html>

<center>
	<?php include "header-small.html" ?>
</center>

<head>
	<title>Search the NMNH Department of Invertebrate Zoology</title>
</head>
	<body bgcolor="#AAC1C0">
		<center>
		<br>
		<table width="570" border="0" cellspacing="3" cellpadding="3">
		<tr> 
			<td align="left" valign="top" height="30" colspan="3">
				<font face="Tahoma" color="#013567" font size="2">
				<b>Click on the name for species collection records.</b><br>
				</font>
			</td>
		</tr>
		<tr> 
			<td align="left" valign="top" height="318"><img src="rotation/antipathes.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Antipathes sp.') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Antipathes sp.</i></font></a>
			</td>

			<td align="left" valign="top" height="318"><img src="rotation/australis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Mimachlamys nobilis') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Mimachlamys nobilis</i><br>(Reeve, 1852)</font></a>
			</td>

			<td nowrap align="left" valign="top" height="318"><img src="rotation/balanus_perforatus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Balanus perforatus') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Balanus perforatus</i></font></a><br>
				<font size="1" face="Tahoma">(Balanus barnacles are on the crab.)</font>
			</td>
		</tr>

		<tr align="left"> 
			<td valign="top"><p><img src="rotation/bathynomus_giganteus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Bathynomus giganteus') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Bathynomus giganteus</i></font></a><br>
			</td>

			<td valign="top"><img src="rotation/cop.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Copilia vitrea') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Copilia vitrea</i></font></a> 
			</td>

			<td valign="top"><img src="rotation/rosaster_alexandri_perrier.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Rosaster alexandri') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Rosaster alexandri</i> (Perrier)</font></a><br>
				<br>
			</td>
    		</tr>

		<tr align="left"> 
			<td valign="top"> <img src="rotation/cypraea_tigris.jpg"><br> 
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Cypraea tigris') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Cypraea tigris</i></font></a></td>

			<td valign="top"><img src="rotation/doederleini.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Ophiocoma doederleini') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Ophiocoma doederleini</i></font></a>
			</td>

			<td valign="top"><img src="rotation/etricornis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Excorallana tricornis') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Excorallana tricornis</i></font></a><br>
				<br>
			</td>
		</tr>

		<tr> 
			<td align="left" valign="top"><img src="rotation/gastropod.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Epitonium scalare') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Epitonium scalare</i></font></a>
			</td>

			<td align="left" valign="top"><img src="rotation/homarus_americanus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Homarus americanus') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Homarus americanus</i></font></a>
			</td>

			<td align="left" valign="top"> <img src="rotation/rhynchocinetes_uritai.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Rhynchocinetes uritai') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Rhynchocinetes uritai</i></font></i></a><br>
				<br>
			</td>
		</tr>

		<tr align="left"> 
			<td height="278" valign="top"><img src="rotation/sigsbeia_murrhina.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Sigsbeia murrhina') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
			?>"><font face="Tahoma" size="2"><i>Sigsbeia murrhina</i></font></a>
			</td>

			<td height="278" valign="top"><img src="rotation/spinosa.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Canthyria spinosa') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Canthyria spinosa</i></font></a>
			</td>

			<td height="278" valign="top"><img src="rotation/strombus_sinuatus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Strombus sinuatus') ";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Strombus sinuatus</i></font></a><br>
				<br>
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
			<td colspan="3"><?php include "footer.php" ?>
			</td>
		</tr>
		</table>
		</center>
	</body>
</html>
