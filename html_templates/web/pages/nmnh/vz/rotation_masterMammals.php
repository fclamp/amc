<html>

<center>
	<?php include "header-small-mammals.html" ?>
</center>

<head>
	<title>Search the NMNH Division of Mammals Collections</title>
</head>
	<body bgcolor="#AAC1C0">
		<center>
		<br>
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
			<p>
			<td align="left" valign="top" height="200"><img src="rotationMammals/02_Tarsius_bancanus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Tarsius bancanus') ";
					$MediaLink->Where .= "and (CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Mammals')";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Tarsius bancanus</i></font></a><br>
			</td>

			<td nowrap align="left" valign="top" height="200"><img src="rotationMammals/03_Cercopithecus_diana.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Cercopithecus diana') ";
					$MediaLink->Where .= "and (CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Mammals')";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Cercopithecus diana</i></font></a><br><br>
			</td>

			<td valign="top"><img src="rotationMammals/04_Marmota_flaviventris.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Marmota flaviventris') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Marmota flaviventris</i></font></a><br>
			</td>
			</p>
		</tr>

		<tr align="left"> 
			<p>
			<td valign="top"><img src="rotationMammals/05_Kunsia_tomentosus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Kunsia tomentosus') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Kunsia tomentosus</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationMammals/07_Scotonycteris_zenkeri.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Scotonycteris zenkeri') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Scotonycteris zenkeri</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationMammals/08_Pteronotus_parnellii.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Pteronotus parnellii') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Pteronotus parnellii</i></font></a><br>
			</td>

			</p>
    		</tr>

		<tr align="left"> 
			<p>

			<td valign="top"><img src="rotationMammals/09_Paradoxurus_hermaphroditus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Paradoxurus hermaphroditus') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Paradoxurus hermaphroditus</i></font></a><br>
				<br>
			</td>

			<td valign="top"><img src="rotationMammals/10_Ursus_arctos.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Ursus arctos') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Ursus arctos</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationMammals/12_Balaenoptera_acutorostrata.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Balaenoptera acutorostrata') ";
					$MediaLink->ResultsListPage = 'ResultsListMammals.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Balaenoptera acutorostrata</i></font></a><br>
				<br>
			</td>
			</p>
    		</tr>

                <tr>
                        <td align="left" valign="top" height="30" colspan="3">
                                <font face="Tahoma" color="#013567" size="3">
                                        <a href="QueryMammals.php"><b>Basic Search</b></a>
                                </font>
                                <font color="#000000">
                                        &nbsp; |&nbsp;&nbsp;
                                </font>
                                <font face="Tahoma" color="#0000FF">
                                        <a href="DtlQueryMammals.php"><b>Detailed Search</b></a>
                                </font>
                                <br>
                        </td>
                </tr>
		<tr>
                        <td colspan="3"><?php include "footerMammals.php" ?>
                        </td>
                </tr>
		</table>
		</center>
	</body>
</html>
