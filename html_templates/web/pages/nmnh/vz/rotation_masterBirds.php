<html>

<center>
	<?php include "header-small-birds.html" ?>
</center>

<head>
	<title>Search the NMNH Division of Birds Collections</title>
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
			<td align="left" valign="top" height="200"><img src="rotationBirds/01_Sula_dactylatra.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Sula dactylatra') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Sula dactylatra</i></font></a><br>
			</td>

			<td align="left" valign="top" height="200"><img src="rotationBirds/02_Lagopus_mutus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Lagopus mutus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Lagopus mutus</i></font></a><br>
			</td>

			<td nowrap align="left" valign="top" height="200"><img src="rotationBirds/03_Gallinago_gallinago.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeGenusLocal_tab where IdeGenusLocal contains 'Gallinago') and";
					$MediaLink->Where = "exists(IdeSpeciesLocal_tab where IdeSpeciesLocal contains 'gallinago') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Gallinago gallinago</i></font></a><br><br>
			</td>
		</tr>

		<tr align="left"> 
			<td valign="top"><p><img src="rotationBirds/04_Larosterna_inca.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Larosterna inca') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Larosterna inca</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationBirds/05_Conuropsis_carolinensis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Conuropsis carolinensis') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Conuropsis carolinensis</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationBirds/06_Glaucidium_sjostedti.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Glaucidium sjostedti') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Glaucidium sjostedti</i></font></a><br>
				<br>
			</td>
    		</tr>
		<tr align="left"> 
			<td valign="top"><p><img src="rotationBirds/07_Alcedo_leucogaster.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Alcedo leucogaster') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Alcedo leucogaster</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationBirds/08_Bucco_capensis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Bucco capensis') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Bucco capensis</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationBirds/09_Dryocopus_pileatus_and_Campephilus_principalis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Dryocopus pileatus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Dryocopus pileatus</i> (left)</font></a><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Campephilus principalis') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Campephilus principalis</i> (right)</font></a><br>
				<br>
			</td>
    		</tr>
		<tr align="left"> 
			<td valign="top"><p><img src="rotationBirds/10_Hylexetastes_perrotii.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Hylexetastes perrotii') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Hylexetastes perrotii</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationBirds/11_Onychorhynchus_coronatus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Onychorhynchus coronatus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Onychorhynchus coronatus</i></font></a><br>
			</td>

			<td valign="top"><img src="rotationBirds/12_Pyrenestes_ostrinus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Pyrenestes ostrinus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds')";
					$MediaLink->ResultsListPage = 'ResultsListBirds.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Pyrenestes ostrinus</i></font></a><br>
				<br>
			</td>
    		</tr>
                <tr>
                        <td align="left" valign="top" height="30" colspan="3">
                                <font face="Tahoma" color="#013567" size="3">
                                        <a href="QueryBirds.php"><b>Basic Search</b></a>
                                </font>
                                <font color="#000000">
                                        &nbsp; |&nbsp;&nbsp;
                                </font>
                                <font face="Tahoma" color="#0000FF">
                                        <a href="DtlQueryBirds.php"><b>Detailed Search</b></a>
                                </font>
                                <br>
                        </td>
                </tr>
		<tr>
                        <td colspan="3"><?php include "footerBirds.php" ?>
                        </td>
                </tr>
		</table>
		</center>
	</body>
</html>
