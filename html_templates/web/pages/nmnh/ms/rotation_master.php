<html>

<center>
	<?php include "header-small.html" ?>
</center>

<head>
	<title>Search the NMNH Department of Mineral Sciences Collections</title>
</head>
	<body bgcolor="#AAC1C0">
		<center>
		<br>
		<br>
		<table width="570" border="0" cellspacing="3" cellpadding="3">
		<tr> 
			<td align="left" valign="top" height="30" colspan="3">
				<font face="Tahoma" color="#013567" font size="2">
				Click on the name for the specimen record
				</font>
			</td>
		</tr>
		<tr> 
			<td align="left" valign="top"><img src="rotation/06.gif"><br>
			<a href="DisplayMet.php?irn=1023225&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Allan Hills 84001</i></font></a><br>
			<font face="Tahoma" size="1">Allan Hills 84001 exhibits a black fusion crust covering the gray, orthopyroxene-rich interior. This 174 gram meteorite is 4.5 billion years old and was collected in Antarctica in 1984. It provides a sample of the earliest crustal rocks on Mars. Tiny carbonate globules formed from fluids about 4 billion years ago. In 1996, NASA scientists suggested that these carbonates may contain fossilized evidence of microbes. Although widely debated since, this study has sparked renewed interest in the origin of life and exploration of Mars.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/15.gif"><br>
			<a href="DisplayGem.php?irn=1107640&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Calcite Stalactites</i></font></a><br>
			<font face="Tahoma" size="1">These small stalactites are made up of tiny calcite crystals that grew as water containing dissolved minerals dripped from the roof of a cave.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/16.gif"><br>
			<a href="DisplayGem.php?irn=1054705&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Oppenheimer Diamond</i></font></a><br>
			<font face="Tahoma" size="1">This diamond is extraordinary, not only for its size (253.7 carats), but also because it has survived uncut. Its double pyramid, or octahedral, shape is typical of many diamond crystals.</font><br>
			</td>
		</tr>
		<tr align="left"> 
			<td align="left" valign="top"><img src="rotation/23.gif"><br>
			<a href="DisplayGem.php?irn=1160546&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Gypsum</i></font></a><br>
			<font face="Tahoma" size="1">Fed by a mineral-rich solution that seeped through rock, this gypsum specimen grew from the wall of a cave in Chihuahua, Mexico. The “ram’s horns” curved as some crystal strands grew faster than others.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/27.gif"><br>
			<a href="DisplayGem.php?irn=1069781&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Elbaite "Candelabra"</i></font></a><br>
			<font face="Tahoma" size="1">Some people think this specimen, nicknamed "Candelabra", looks like three hot-pink candles in a quartz candelabra. As the elbaite crystals grew, the growth solution changed from manganese-rich to iron-rich, creating a blue top on each candle.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/31.gif"><br>
			<a href="DisplayGem.php?irn=1107682&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Crocoite</i></font></a><br>
			<font face="Tahoma" size="1">Crocoite’s color, always orange or reddish-orange, comes from chromium – a valuable metal first extracted from this rare mineral. The best crocoite in the world is found in Tasmania, where it was once mined for lead.</font><br>
			</td>
    		</tr>
		<tr align="left"> 
			<td align="left" valign="top"><img src="rotation/32.gif"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "exists(IdeTaxonLocal_tab where IdeTaxonLocal contains 'Opal')";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatDepartment = 'Mineral Sciences' AND CatDivision = 'Gems & Minerals')";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Opal</i></a><br>
			<font face="Tahoma" size="1">Within opal, tiny stacked spheres of silica scatter light, causing the play of colors. Opals with this fiery flash are prized as gems. But water comprises six to ten percent of their weight, and heat can dry them out and make them crack. Opal is the October birthstone.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/33.gif"><br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$MediaLink = new PreConfiguredQueryLink;
					$MediaLink->Where = "(BioVolcanoNameLocal contains 'Pacaya')";
					$MediaLink->Where .= "and (CatMuseum = 'NMNH' AND CatDepartment = 'Mineral Sciences' AND CatDivision = 'Petrology & Volcanology')";
					$MediaLink->ResultsListPage = 'ResultsList.php';
					$MediaLink->PrintRef();
				?>"><font face="Tahoma" size="2"><i>Pacaya</i></a><br>
			<font face="Tahoma" size="1">Long-term strombolian explosions began at this volcano, 30 kilometers south-southwest of Guatemala City, in 1965 and continued for more than a quarter century. Here a lava flow descends the night skyline. Pacaya is one of many volcanoes that present hazards to aircraft in the form of drifting ashclouds.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/34.gif"><br>
			<a href="DisplayMet.php?irn=1014523&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Lafayette</i></font></a><br>
			<font face="Tahoma" size="1">The fusion crust of this small (10 cm diameter) meteorite shows streaks of melted rock that flowed back from its leading edge as it entered Earth’s atmosphere. Gases trapped within these meteorites closely match those measured in the atmosphere of Mars by the Viking landers in 1976.</font><br>
			</td>
    		</tr>
		<tr align="left"> 
			<td align="left" valign="top"><img src="rotation/40.gif"><br>
			<a href="DisplayPet.php?irn=1325657&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Clay Concretion</i></font></a><br>
			<font face="Tahoma" size="1">This curious rock, called a concretion, formed underground as mineral-laden water seeped through sediment and porous rock. In certain spots, commonly around a fossil or bit of organic matter, minerals crystallize and cement the surrounding particles. This concretion was found in Vermont.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/41.gif"><br>
			<a href="DisplayGem.php?irn=1006108&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Spodumene (Kunzite) Necklace</i></font></a><br>
			<font face="Tahoma" size="1">When spodumene is found as lustrous transparent pink crystals, the cut gem is called kunzite. Kunzite was first discovered in Pala, California in 1902 and named for the American gemologist, George F. Kunz. Kunzite gems must be cut relatively large to show a strong body color, and in some cases, upon exposure to light over time kunzite will fade and turn almost colorless. This 396.30 carat kunzite gem from Afghanistan is set in a stunning gold and diamond necklace with South Sea baroque pearls. It was designed by Paloma Picasso in 1986 to celebrate the 150th anniversary of Tiffany & Co.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/46.gif"><br>
			<a href="DisplayPet.php?irn=1211881&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Septarian Nodule</i></font></a><br>
			<font face="Tahoma" size="1">This remarkable structure began as a mudball that dried, shrank, and cracked. Fluids infiltrated the cracks and deposited quartz crystals. Later, the clay eroded away – leaving behind a quartz framework.</font><br>
			</td>
    		</tr>
		<tr align="left"> 
			<td align="left" valign="top"><img src="rotation/52.gif"><br>
			<a href="DisplayPet.php?irn=1211655&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Garnets in Schist</i></font></a><br>
			<font face="Tahoma" size="1">The red “thumbprints” in this rock are garnets that grew when the rock was glowing hot, 16 kilometers (10 miles) below Earth’s surface. The garnets took about 12 million years to get this big. In the process, they rolled slowly like snowballs. The peculiar S-shaped patterns within the garnets are made of minerals trapped as the garnets grew.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/55.gif"><br>
			<a href="DisplayMet.php?irn=1033650&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Farmville</i></font></a><br>
			<font face="Tahoma" size="1">The Farmville (North Carolina) chondrite is typical of the vast majority of the meteorites falling to Earth. The black glassy fusion curst on the exterior, formed by melting during atmospheric entry, coats an interior composed of millimeter-sized grains of silicates, metal and sulfide.  These grains formed in the space more than 4.5 billion years ago, and are thought to be the material from which the planets originally formed.</font><br>
			</td>

			<td align="left" valign="top"><img src="rotation/56.gif"><br>
			<a href="DisplayMet.php?irn=1018512&QueryPage=%2Femuwebnmnhweb%2Fpages%2Fnmnh%2Fms%2Frotation_master.php"><font face="Tahoma" size="2"><i>Ahumada</i></font></a><br>
			<font face="Tahoma" size="1">Pallasites, such as this sliced and polished specimen of Ahumada (Mexico), are samples of the deep interiors of differentiated asteroids.  Pallasites formed at the core-mantle boundary, where a core of Fe-Ni metal mixed with overlying olivine-rich mantle.</font><br>
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
                        <td colspan="3">
				<?php include "footer.php" ?>
                        </td>
                </tr>
		</table>
		</center>
	</body>
</html>
