
<script language="php"> 

function rotate_images() 
{ 
	// open directory, images must be in a separate directory 
	$dir_pointer = dir( "rotationMammals" ); 

	// make an array of filenames 
	while( $entryName = $dir_pointer->read() ) 
	{ 
		// don't include parent/current directory listing /. /.. 
		if( !ereg( "^\.", $entryName ) ) 
		$file_array[] = $entryName; 

		// could be done this way to simplify some code below 
		# $file_array[] = "rotationMammals/$entryName"; 
	} 
                                     
	// close directory 
	$dir_pointer->close(); 
                                     
	$count_array = count( $file_array ) - 1; 
                                     
	// intialize random seed 
	srand( time() ); 
                                     
	// get a random index number to pull from array 
	$random_no = rand( 0, $count_array ); 
                                     
	// make a file pointer 
	$file_name = "rotationMammals/$file_array[$random_no]"; 
                                     
	// or if directory added to array element 
	#$file_name = $file_array[$random_no]; 
                                     
	// get image dimensions 
	$image_size = getimagesize( $file_name ); 
                                     
	// create dynamic image tag 
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Vertebrate Zoology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large-mammals.html" ?>

<html>
<head>
	<title>Search the NMNH Division of Mammals Collections</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="2" valign=top rowspan="3"> 
			<p>
				<font color="#013567" size="2" face="Tahoma">
					<a href="rotation_masterMammals.php"><?php print rotate_images(); ?></a> 
				</font>
			</p>
			<p>
				<font color="#013567" size="2" face="Tahoma">
					<b>Mammal Collections</b><br>
					<br>
					The Division of Mammals, National Museum of Natural History, Smithsonian Institution, houses and maintains 
					the world's largest mammal collection with over 590,000 specimens. The taxonomic and geographic scope of the 
					USNM (acronym derived from our former name United States National Museum) mammal collection spans the globe, 
					with especially strong representation from North America, Central America, northern South America, Africa, 
					and southeast Asia. The research value of this collection to mammalogists is evidenced by the 3200 primary 
					type specimens preserved, a number exceeded only by The Natural History Museum, London.<br>
					<br>
					<b>Search the Mammal Collections</b><br>
					<br>
					Key word searches on any available field can be run from the Quick Search box below. 
					More defined searches can be run against specific fields from the 
					<a href="DtlQueryMammals.php">Detailed Search</a> link below. 
					Don't know what to search for? Try one of the three sample searches in the Quick Browse panel at right.<br>
					<br>
					Please note that our entire holdings are completely or partially listed in our specimen database at present. 
					There are currently only a small number of specimens with images associated with them. 
					If you spot an error in our data please let us know.<br>
					<br>
				</font>
			</p>
		</td>

		<td width="128" valign="middle" bgcolor="#003366" align="center" height="32"> 
			<font size="2" face="Tahoma" color="#FFFFFF">
				&nbsp;<b>Quick Browse</b>
			</font> 
			<br>
		</td>
	</tr>

	<tr> 
		<td width="128" valign="center" bgcolor="#FFF3DE" align="center"> 
			<br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 7156400 or
							      irn = 7225130 or
							      irn = 7244058 or
							      irn = 7428241 or
							      irn = 7507532 or
							      irn = 7510664 or
							      irn = 7588997 or
							      irn = 7591689";
					$holidayset->ResultsListPage = 'ResultsListMammals.php';
					$holidayset->PrintRef();
				?>
	  		"><img src="images/sample_search_1_mammals.jpg"></a><br>
			<font color="#336699" face="Tahoma" size="2" border="2">
				Selected specimens with images<br>
			</font>
		</td>
	</tr>
	<tr> 
		<td width="128" valign="center" bgcolor="#FFF3DE" align="center"> 
			<br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 7148182 or
							      irn = 7224859 or
							      irn = 7224860 or
							      irn = 7225179 or
							      irn = 7225180 or
							      irn = 7225181 or
							      irn = 7225182 or
							      irn = 7225183 or
							      irn = 7225184 or
							      irn = 7225185 or
							      irn = 7225186 or
							      irn = 7225187 or
							      irn = 7225188 or
							      irn = 7225189 or
							      irn = 7225190 or
							      irn = 7225191 or
							      irn = 7225192 or
							      irn = 7225193 or
							      irn = 7225194 or
							      irn = 7225195 or
							      irn = 7225196 or
							      irn = 7225198 or
							      irn = 7225199 or
							      irn = 7226010 or
							      irn = 7226011";
					$holidayset->ResultsListPage = 'ResultsListMammals.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/sample_search_2_mammals.jpg"></a><br>
			<font face="Tahoma" color="#336699" size="2" border="2">
				Selected specimens from the U. S. Exploring Expedition (1838-1842)<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/vz/QueryForms.php');
			$queryform = new NmnhVzMammalsBasicQueryForm;
			$queryform->ResultsListPage = 'ResultsListMammals.php';
			$queryform->Title = 'Enter search term(s)...';
			$queryform->FontFace = 'Arial';
			$queryform->FontSize = '2';
			$queryform->TitleTextColor = '#FFFFFF';
			$queryform->BorderColor = '#013567';
			$queryform->BodyColor = '#FFF3DE';
			$queryform->Show();
		?>
		</p>
		<p>
			<font face="Tahoma" color="#0000FF" size=3>
				<a href="DtlQueryMammals.php"><b>Detailed Search</b></a>
			</font>
		</p>
		</td> 
		<td width="128" align="center" valign="center" bgcolor="#FFF3DE"> 
			<br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 7021343 or 
							      irn = 7023422 or
							      irn = 7073956 or
							      irn = 7075918 or
							      irn = 7099885 or
							      irn = 7214086 or
							      irn = 7214087 or
							      irn = 7215842 or
							      irn = 7216148 or
							      irn = 7508463 or
							      irn = 7510670 or
							      irn = 7515422 or
							      irn = 7516140 or
							      irn = 7517883 or
							      irn = 7518454 or
							      irn = 7537862 or
							      irn = 7538010 or
							      irn = 7571947 or
							      irn = 7571955 or
							      irn = 7572370";
					$holidayset->ResultsListPage = 'ResultsListMammals.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/sample_search_3_mammals.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				Selected whale strandings from Delaware
			</font>
			<br>
			</div>
		</td>
	</tr>
</table>
<br>
<?php include "footerMammals.php" ?>
</body>
</html>
