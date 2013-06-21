<html>

<center>
	<?php include "header-small-herps.html" ?>
</center>

<head>
	<title>Search the NMNH Division of Amphibians & Reptiles Collections</title>
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
			<td align="left" valign="top"><img src="rotationHerps/Heterodon_platirhinos.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Heterodon platirhinos') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles')";
					$MediaLink->ResultsListPage = 'ResultsListHerps.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Heterodon platirhinos</i></a><br>
					Eastern Hog-Nosed Snake<br>
					<br>
					<br>
				    </font>
			</td>
			<td align="left" valign="top"><img src="rotationHerps/Bogertophis_subocularis.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Bogertophis subocularis') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles')";
					$MediaLink->ResultsListPage = 'ResultsListHerps.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Bogertophis subocularis</i></a><br>
					Trans-Pecos Rat Snake<br>
					Val Verde Co., Texas<br>
					Photo by Charles W. Painter
				    </font>
			</td>
			<td align="left" valign="top"><img src="rotationHerps/Plethodon_petraeus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Plethodon petraeus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles')";
					$MediaLink->ResultsListPage = 'ResultsListHerps.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Plethodon petraeus</i></a><br>
					Pigeon Mountain Salamander<br>
					Pigeon Mountain, Georgia<br>
					Photo by Addison Wynn
				    </font>
			</td>
		</tr>

		<tr align="left"> 
			<td align="left" valign="top"><img src="rotationHerps/Cycloramphus_semipalmatus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Cycloramphus semipalmatus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles')";
					$MediaLink->ResultsListPage = 'ResultsListHerps.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Cycloramphus semipalmatus</i></a><br>
					Leptodactylid Frog<br> 
					Boraceia, Atlantic Forest, Brazil<br> 
					Photo by Charles W. Myers
				    </font>
			</td>
			<td align="left" valign="top"><img src="rotationHerps/Chamaeleolis_barbatus.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Chamaeleolis barbatus') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles')";
					$MediaLink->ResultsListPage = 'ResultsListHerps.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Chamaeleolis barbatus</i></a><br>
					Giant Bearded Twig Anole<br>
					Soroa, Provincia Pinar del Rio, Cuba<br>
					Photo by Kevin de Queiroz
				    </font>
			</td>
			<td align="left" valign="top"><img src="rotationHerps/Centrolene_grandisonae.jpg"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeQualifiedName_tab where IdeQualifiedName contains 'Centrolene grandisonae') ";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles')";
					$MediaLink->ResultsListPage = 'ResultsListHerps.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Centrolene grandisonae</i></a><br>
					Glass Frog<br>
					Quebrada La Plata, Pichincha Province, Ecuador<br>
					Photo by Roy McDiarmid
				    </font>
			</td>
    		</tr>
                <tr>
                        <td align="left" valign="top" height="30" colspan="3">
                                <font face="Tahoma" color="#013567" size="3">
                                        <a href="QueryHerps.php"><b>Basic Search</b></a>
                                </font>
                                <font color="#000000">
                                        &nbsp; |&nbsp;&nbsp;
                                </font>
                                <font face="Tahoma" color="#0000FF">
                                        <a href="DtlQueryHerps.php"><b>Detailed Search</b></a>
                                </font>
                                <br>
                        </td>
                </tr>
		<tr> 
			<td colspan="3"><?php include "footerHerps.php" ?>
			</td>
		</tr>
		</table>
		</center>
	</body>
</html>
