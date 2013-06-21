
<script language="php"> 

function rotate_images() 
{ 
	// open directory, images must be in a separate directory 
	$dir_pointer = dir( "rotationBirds" ); 

	// make an array of filenames 
	while( $entryName = $dir_pointer->read() ) 
	{ 
		// don't include parent/current directory listing /. /.. 
		if( !ereg( "^\.", $entryName ) ) 
		$file_array[] = $entryName; 

		// could be done this way to simplify some code below 
		# $file_array[] = "rotationBirds/$entryName"; 
	} 
                                     
	// close directory 
	$dir_pointer->close(); 
                                     
	$count_array = count( $file_array ) - 1; 
                                     
	// intialize random seed 
	srand( time() ); 
                                     
	// get a random index number to pull from array 
	$random_no = rand( 0, $count_array ); 
                                     
	// make a file pointer 
	$file_name = "rotationBirds/$file_array[$random_no]"; 
                                     
	// or if directory added to array element 
	#$file_name = $file_array[$random_no]; 
                                     
	// get image dimensions 
	$image_size = getimagesize( $file_name ); 
                                     
	// create dynamic image tag 
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Vertebrate Zoology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large-birds.html" ?>

<html>
<head>
	<title>Search the NMNH Division of Birds Collections</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="2" valign=top rowspan="3"> 
			<p>
				<font color="#013567" size="2" face="Tahoma">
					<a href="rotation_masterBirds.php"><?php print rotate_images(); ?></a> 
				</font>
			</p>
			<p>
				<font color="#013567" size="2" face="Tahoma">
					<b>Birds Collection Search</b><br>
					<br>
					The Division of Birds, National Museum of Natural History, Smithsonian Institution, houses and maintains the third largest bird collection in the world with over 625,000 specimens. Our National Collection has representatives of about 80% of the approximately 9600 known species in the world's avifauna. The collection is comprised of specimens primarily prepared as study skins, skeletons, fluid preserved, eggs, nests, and mounted skins. We also hold nearly 4000 primary type specimens. Our tissue sample holdings are not searchable in this first phase of public web access to the Birds database.<br>
					<br>
					<b>Search the Bird Collections</b><br>
					<br>
					Key word searches on any available field can be run from the Quick Search box below. More defined searches can be run against specific fields from the <a href="DtlQueryBirds.php">Detailed Search</a> link below. Don't know what to search for? Try one of the three sample searches in the Quick Browse panel at right.<br>
					<br>
					Please note that approximately 65% of our holdings are completely or partially listed in our specimen database at present. There are currently only a small number of specimens with images associated with them. We are constantly adding records and images to the Birds database. If you spot an error in our data please let us know.
				</font>
			</p>
			<p>
				&nbsp;
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
			<font face="Tahoma">
				<a href="
					<?php
						require_once('../../../objects/common/PreConfiguredQuery.php');
						$holidayset = new PreConfiguredQueryLink;
						$holidayset->Where = "irn = 4004773 or
								      irn = 4009300 or
								      irn = 4015150 or
								      irn = 4023876 or
								      irn = 4065601 or
								      irn = 4138970 or
								      irn = 4230140 or
								      irn = 4272611 or
								      irn = 4346273 or
								      irn = 4383533 or
								      irn = 4402451";
						$holidayset->ResultsListPage = 'ResultsListBirds.php';
						$holidayset->PrintRef();
					?>
	  			"><img src="images/sample_search_1_birds.jpg" border="2"></a><br>
			</font>
			<font color="#336699" face="Tahoma" size="2">
				Selected specimens with images<br>
			</font>
		</td>
	</tr>
	<tr> 
		<td width="128" valign="center" bgcolor="#FFF3DE" align="center"> 
			<font face="Tahoma">
				<a href="
					<?php
						require_once('../../../objects/common/PreConfiguredQuery.php');
						$holidayset = new PreConfiguredQueryLink;
						$holidayset->Where = "irn = 4006309 or
								      irn = 4006909 or
								      irn = 4009165 or
								      irn = 4015766 or
								      irn = 4022681 or
								      irn = 4022682 or
								      irn = 4022692 or
								      irn = 4038374 or
								      irn = 4041839 or
								      irn = 4055344 or
								      irn = 4055345 or
								      irn = 4057108 or
								      irn = 4096821 or
								      irn = 4112756 or
								      irn = 4114000 or
								      irn = 4127866 or
								      irn = 4138240 or
								      irn = 4138307 or
								      irn = 4139039 or
								      irn = 4139904 or
								      irn = 4141268 or
								      irn = 4141981 or
								      irn = 4145878 or
								      irn = 4147150 or
								      irn = 4157183 or
								      irn = 4160912 or
								      irn = 4165094 or
								      irn = 4236767 or
								      irn = 4236770 or
								      irn = 4236775 or
								      irn = 4236801 or
								      irn = 4236803 or
								      irn = 4236805 or
								      irn = 4236814 or
								      irn = 4236815 or
								      irn = 4237066 or
								      irn = 4264779 or
								      irn = 4265113 or
								      irn = 4354076";
						$holidayset->ResultsListPage = 'ResultsListBirds.php';
						$holidayset->PrintRef();
					?>
				"><img src="images/sample_search_2_birds.jpg" border="2"></a><br>
			</font>
			<font face="Tahoma" color="#336699" size="2">
				Selected specimens of extinct North American birds<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
			<p>
				<?php
					require_once('../../../objects/nmnh/vz/QueryForms.php');
					$queryform = new NmnhVzBirdsBasicQueryForm;
					$queryform->ResultsListPage = 'ResultsListBirds.php';
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
					<a href="DtlQueryBirds.php"><b>Detailed Search</b></a>
				</font>
			</p>
		</td> 
		<td width="128" align="center" valign="center" bgcolor="#FFF3DE"> 
			<font face="Tahoma">
			<br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 4010995 or 
							      irn = 4010999 or 
							      irn = 4011005 or 
							      irn = 4011010 or 
							      irn = 4012550 or 
							      irn = 4012551 or 
							      irn = 4021332 or 
							      irn = 4022007 or 
							      irn = 4138345 or 
							      irn = 4138686 or 
							      irn = 4185271 or 
							      irn = 4187564 or 
							      irn = 4188280 or 
							      irn = 4293517 or 
							      irn = 4331012 or 
							      irn = 4354294 or 
							      irn = 4376467 or 
							      irn = 4376468 or 
							      irn = 4376474 or 
							      irn = 4376516 or 
							      irn = 4376555";
					$holidayset->ResultsListPage = 'ResultsListBirds.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/sample_search_3_birds.jpg" border="2"></a><br>
			</font>
			<font face="Tahoma" color="#336699" size="2"> 
				Selected specimens collected by Audubon, Darwin, Roosevelt, and Wallace<br>
			</font>
		</td>
	</tr>
</table>
<br>
<?php include "footerBirds.php" ?>
</body>
</html>
