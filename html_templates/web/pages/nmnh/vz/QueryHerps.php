
<script language="php"> 

function rotate_images() 
{ 
	// open directory, images must be in a separate directory 
	$dir_pointer = dir( "rotationHerps" ); 

	// make an array of filenames 
	while( $entryName = $dir_pointer->read() ) 
	{ 
		// don't include parent/current directory listing /. /.. 
		if( !ereg( "^\.", $entryName ) ) 
		$file_array[] = $entryName; 

		// could be done this way to simplify some code below 
		# $file_array[] = "rotationHerps/$entryName"; 
	} 
                                     
	// close directory 
	$dir_pointer->close(); 
                                     
	$count_array = count( $file_array ) - 1; 
                                     
	// intialize random seed 
	srand( time() ); 
                                     
	// get a random index number to pull from array 
	$random_no = rand( 0, $count_array ); 
                                     
	// make a file pointer 
	$file_name = "rotationHerps/$file_array[$random_no]"; 
                                     
	// or if directory added to array element 
	#$file_name = $file_array[$random_no]; 
                                     
	// get image dimensions 
	$image_size = getimagesize( $file_name ); 
                                     
	// create dynamic image tag 
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Vertebrate Zoology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large-herps.html" ?>

<html>
<head>
	<title>Search the NMNH Division of Amphibians & Reptiles Collections</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="2" valign=top rowspan="3"> 
			<p>
				<font color="#013567" size="2" face="Tahoma">
					<a href="rotation_masterHerps.php"><?php print rotate_images(); ?></a> 
				</font>
			</p>
			<p>
				<font color="#013567" size="2" face="Tahoma">
				<p>
					<b>Herpetology Collections at NMNH</b>
				</p>
				<p>
					The Division of Amphibians and Reptiles, National Museum of Natural History, Smithsonian Institution, houses and maintains the largest herpetology collection in the world with over 555,000 specimens. Our collection, comprised primarily of fluid preserved specimens, includes representatives of about 63% of the approximately 15,000 known species of the world's herpetofauna. Our data base holds nearly 13,300 type records; over 2,470 of these are primary (name bearing) types. For more information please see the Division's <a href="http://www.nmnh.si.edu/vert/reptiles/reptiles-collections.htm">collections page</a>
				</p>
				<p>
					<b>Search the Amphibian and Reptile Collections</b>
				</p>
				<p>
					Key word searches on summary fields can be run from the Quick Search box below. Searches can be run against specific fields from the Detailed Search link below. If you don't know what to search for, try one of the three sample searches in the Quick Browse panel at right.
				</p>
				<p>
					Please note that not all of our holdings are included in our specimen database at present (99% are completely or partially listed). Currently only a small number of specimens have associated images. We are constantly adding records and images to the Herpetology database. If you spot an error please let us know.
				</p>
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
		<td width="128" valign="middle" bgcolor="#FFF3DE" align="center" height="7"> 
			<div align="center">
			<font face="Tahoma">
				<a href="
					<?php
						require_once('../../../objects/common/PreConfiguredQuery.php');
						$holidayset = new PreConfiguredQueryLink;
						$holidayset->Where = "irn = 6177348 or
								      irn = 6177362 or
								      irn = 6177365 or
								      irn = 6177384 or
								      irn = 6177433 or
								      irn = 6177453 or
								      irn = 6177462 or
								      irn = 6177475 or
								      irn = 6177484 or
								      irn = 6177485 or
								      irn = 6177540 or
								      irn = 6177551 or
								      irn = 6177555 or
								      irn = 6177584 or
								      irn = 6177585 or
								      irn = 6177586 or
								      irn = 6177594 or
								      irn = 6177598 or
								      irn = 6177687 or
								      irn = 6177688 or
								      irn = 6177690 or
								      irn = 6177718 or
								      irn = 6177741 or
								      irn = 6177743 or
								      irn = 6177745 or
								      irn = 6177756 or
								      irn = 6177775 or
								      irn = 6177776 or
								      irn = 6177777 or
								      irn = 6177784 or
								      irn = 6177786 or
								      irn = 6177797 or
								      irn = 6177799 or
								      irn = 6177801 or
								      irn = 6177803 or
								      irn = 6177804 or
								      irn = 6177805 or
								      irn = 6177806 or
								      irn = 6177810 or
								      irn = 6177824 or
								      irn = 6177825 or
								      irn = 6177826 or
								      irn = 6177827 or
								      irn = 6177829 or
								      irn = 6177830 or
								      irn = 6177831 or
								      irn = 6177832 or
								      irn = 6177833 or
								      irn = 6177834 or
								      irn = 6177840 or
								      irn = 6177842 or
								      irn = 6177850 or
								      irn = 6177851 or
								      irn = 6177852 or
								      irn = 6177853 or
								      irn = 6177854 or
								      irn = 6177855";
						$holidayset->ResultsListPage = 'ContactSheetHerps.php';
						$holidayset->PrintRef();
					?>
	  			"><img src="images/EcuadorButton.jpg"></a><br>
			</font>
			<font color="#336699" face="Tahoma" size="2">
				Selected specimens from Ecuador with images
			</font>
			<br>
			</div>
		</td>
	</tr>
	<tr> 
		<td width="128" valign="middle" bgcolor="#FFF3DE" align="center" height="98"> 
			<div align="center">
			<font face="Tahoma">
				<a href="
					<?php
						require_once('../../../objects/common/PreConfiguredQuery.php');
						$holidayset = new PreConfiguredQueryLink;
						$holidayset->Where = "irn = 6001019 or
								      irn = 6178313 or
								      irn = 6550698 or
								      irn = 6001876 or
								      irn = 6001980 or
								      irn = 6002396 or
								      irn = 6367507 or
								      irn = 6172813 or
								      irn = 6367486 or
								      irn = 6002484 or
								      irn = 6002488 or
								      irn = 6002504 or
								      irn = 6547905 or
								      irn = 6003049 or
								      irn = 6003056 or
								      irn = 6174680 or
								      irn = 6004103 or
								      irn = 6006270 or
								      irn = 6262294 or
								      irn = 6357465 or
								      irn = 6359726 or
								      irn = 6111044 or
								      irn = 6111045 or
								      irn = 6001189 or
								      irn = 6181258 or
								      irn = 6358277 or
								      irn = 6004162";
						$holidayset->ResultsListPage = 'ResultsListHerps.php';
						$holidayset->PrintRef();
					?>
				"><img src="images/WilkesVoyagers-button.jpg"></a><br>
			</font>
			<font face="Tahoma" color="#336699" size="2">
				Wilkes Expedition Primary Types
			</font>
			<br>
			</div>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/vz/QueryForms.php');
			$queryform = new NmnhVzHerpsBasicQueryForm;
			$queryform->ResultsListPage = 'ResultsListHerps.php';
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
				<a href="DtlQueryHerps.php"><b>Detailed Search</b></a>
			</font>
		</p>
		</td> 
		<td width="128" align="center" valign="middle" bgcolor="#FFF3DE"> 
			<div align="center">
			<font face="Tahoma">
			<br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 6031738 or
							      irn = 6322170 or
							      irn = 6288746 or
							      irn = 6079797 or
							      irn = 6170347 or
							      irn = 6141669 or
							      irn = 6031742 or
							      irn = 6322171 or
							      irn = 6141662 or
							      irn = 6322140 or
							      irn = 6016898 or
							      irn = 6166740 or
							      irn = 6322166 or
							      irn = 6114786 or
							      irn = 6114782 or
							      irn = 6076352 or
							      irn = 6322141 or
							      irn = 6322169 or
							      irn = 6057750 or
							      irn = 6517743 or
							      irn = 6047212 or
							      irn = 6026597 or
							      irn = 6225310 or
							      irn = 6164022 or
							      irn = 6141668 or
							      irn = 6357487 or
							      irn = 6008977 or
							      irn = 6114634 or
							      irn = 6027449 or
							      irn = 6284465 or
							      irn = 6038618 or
							      irn = 6284402 or
							      irn = 6284351 or
							      irn = 6026572 or
							      irn = 6262199 or
							      irn = 6284489 or
							      irn = 6005797 or
							      irn = 6005798 or
							      irn = 6005799 or
							      irn = 6130687 or
							      irn = 6024830 or
							      irn = 6101883 or
							      irn = 6080936 or
							      irn = 6286723";
					$holidayset->ResultsListPage = 'ResultsListHerps.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/OpheodrysButton.jpg"></a><br>
			</font>
			<font face="Tahoma" color="#336699" size="2"> 
				Selected Records of Washington DC Herps
			</font>
			<br>
			<br>
			</div>
		</td>
	</tr>
</table>
<br>
<?php include "footerHerps.php" ?>
</body>
</html>
