<html>

<center>
	<?php include "header-small-fishes.html" ?>
</center>

<head>
	<title>Search the NMNH Division of Fishes Collections</title>
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
			<td align="left" valign="top" height="200"><img src="rotationFishes/Alticus_montanoi.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Alticus montanoi') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Alticus montanoi</i></a><br>
					Photograph by J.T. Williams
				    </font>
			</td>

			<td align="left" valign="top" height="200"><img src="rotationFishes/Antennarius_coccineus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Antennarius coccineus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Antennarius coccineus</i></a><br>
					Photograph by J.T. Williams
				    </font>
			</td>

			<td nowrap align="left" valign="top" height="200"><img src="rotationFishes/Argyropelecus_lychnus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Argyropelecus lychnus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Argyropelecus lychnus</i></a><br>
					Photograph by S.J. Raredon
				    </font>
				<br>
				<br>
			</td>
		</tr>

		<tr align="left"> 
			<td valign="top"><p><img src="rotationFishes/Ateleopus_plicatellus_by_R_L_Hudson.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Ateleopus plicatellus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Ateleopus plicatellus</i></a><br>
					Illustration by R.L. Hudson
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Carassius_auratus_by_Ito.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Carassius auratus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Carassius auratus</i></a><br>
					Illustration by Ito
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Chaetodon_ornatissimus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Chaetodon ornatissimus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Chaetodon ornatissimus</i></a><br>
					Photograph by J.T. Williams
				    </font>
				<br>
				<br>
			</td>
    		</tr>
		<tr align="left"> 
			<td valign="top"><p><img src="rotationFishes/Chlorurus_bowersi.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Chlorurus bowersi') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Chlorurus bowersi</i></a><br>
					Photograph by J.T. Williams
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Dendrochirus_by_Kako_Morita.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeGenusLocal_tab where IdeGenusLocal contains 'Dendrochirus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Dendrochirus</i></a><br>
					Illustration by Kako Morita
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Heteroconger_hassi.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Heteroconger hassi') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Heteroconger hassi</i></a><br>
					Photograph by J.T. Williams
				    </font>
				<br>
				<br>
			</td>
    		</tr>
		<tr align="left"> 
			<td valign="top"><p><img src="rotationFishes/Ictalurus_serracanthus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Ictalurus serracanthus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Ictalurus serracanthus</i></a><br>
					Photograph by S.J. Raredon
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Lactoria_cornuta.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Lactoria cornuta') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Lactoria cornuta</i></a><br>
					Photograph by J.T. Williams
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Macolor_macularis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Macolor macularis') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Macolor macularis</i></a><br>
					Photograph by J.T. Williams
				    </font>
				<br>
				<br>
			</td>
    		</tr>
		<tr align="left"> 
			<td valign="top"><p><img src="rotationFishes/Mene_maculata.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Mene maculata') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Mene maculata</i></a><br>
					Radiograph by S.J. Raredon
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Poecilopsetta_hawaiiensis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Poecilopsetta hawaiiensis') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Poecilopsetta hawaiiensis</i></a><br>
					Radiograph by S.J. Raredon
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Rhinecanthus_verrucosus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Rhinecanthus verrucosus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Rhinecanthus verrucosus</i></a><br>
					Photograph by J.T. Williams
				    </font>
				<br>
				<br>
			</td>
    		</tr>
		<tr align="left"> 
			<td valign="top"><p><img src="rotationFishes/Samariscus_triocellatus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Samariscus triocellatus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font size="2" face="Tahoma"><i>Samariscus triocellatus</i></a><br>
					Photograph by J.T. Williams
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Sargocentron_cornutum.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Sargocentron cornutum') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Sargocentron cornutum</i></a><br>
					Photograph by J.T. Williams
				    </font>
			</td>

			<td valign="top"><img src="rotationFishes/Solenostomus_paradoxus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Solenostomus paradoxus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND ";
					$MediaLink->Where .= "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes')";
					$MediaLink->ResultsListPage = 'ResultsListFishes.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Solenostomus paradoxus</i></a><br>
					Photograph by J.T. Williams
				    </font>
				<br>
				<br>
			</td>
    		</tr>
                <tr>
                        <td align="left" valign="top" height="30" colspan="3">
                                <font face="Tahoma" color="#013567" size="3">
                                        <a href="QueryFishes.php"><b>Basic Search</b></a>
                                </font>
                                <font color="#000000">
                                        &nbsp; |&nbsp;&nbsp;
                                </font>
                                <font face="Tahoma" color="#0000FF">
                                        <a href="DtlQueryFishes.php"><b>Detailed Search</b></a>
                                </font>
                                <br>
                        </td>
                </tr>
		<tr>
                        <td colspan="3"><?php include "footerFishes.php" ?>
                        </td>
                </tr>
		</table>
		</center>
	</body>
</html>
