
<script language="php"> 

function rotate_images() 
{ 
	// open directory, images must be in a separate directory 
	$dir_pointer = dir( "rotation" ); 

	// make an array of filenames 
	while( $entryName = $dir_pointer->read() ) 
	{ 
		// don't include parent/current directory listing /. /.. 
		if( !ereg( "^\.", $entryName ) ) 
		$file_array[] = $entryName; 

		// could be done this way to simplify some code below 
		# $file_array[] = "rotation/$entryName"; 
	} 
                                     
	// close directory 
	$dir_pointer->close(); 
                                     
	$count_array = count( $file_array ) - 1; 
                                     
	// intialize random seed 
	srand( time() ); 
                                     
	// get a random index number to pull from array 
	$random_no = rand( 0, $count_array ); 
                                     
	// make a file pointer 
	$file_name = "rotation/$file_array[$random_no]"; 
                                     
	// or if directory added to array element 
	#$file_name = $file_array[$random_no]; 
                                     
	// get image dimensions 
	$image_size = getimagesize( $file_name ); 
                                     
	// create dynamic image tag 
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Paleobiology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large.html"?>

<html>
<head>
	<title>Search the NMNH Department of Paleobiology Collections</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="2" valign=top rowspan="3"> 
		<p>
			<font color="#013567" size="2" face="Tahoma">
				<a href="rotation_master.php"><?php print rotate_images(); ?></a> 
			</font>
		</p>
		<p>
			<font color="#013567" size="2" face="Tahoma">
			<b>Paleobiology Collections</b><br>
			<br>
			The Department of Paleobiology is home to over 40 million specimens, representing fossil invertebrates, vertebrates, and plants from all over the world. Currently, over 585,000 specimen records are available through this online catalog.<br>
			<br>
			<b>Search the Paleobiology Collections</b><br>
			<br>
			Key word searches on any available field can be run from the Quick Search box below. We recommend that you use the <a href="DtlQuery.php">Detailed Search</a> link below for most queries to achieve the best search results. If you don't know what you want to see, you can look at the sample records in the 'Quick Browse' section to the right, or click on the image to the left for additional sample records.<br>
			<br>
			The online catalog does not include all of the specimens housed in the department. All type collections are available; however, some biologic collections have not been inventoried and are not available yet. There are currently only a small number of specimens with images associated with them, although we are continuously adding specimen records and images to the database. If you spot an error in our data, please let us know.
		</p>
			</font>
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
					$holidayset->Where = "irn = 3383668 OR
							      irn = 3440889 OR
							      irn = 3449148 OR
							      irn = 3449152 OR
							      irn = 3451304 OR
							      irn = 3451264 OR
							      irn = 3451233 OR
							      irn = 3448836 OR
							      irn = 3448837 OR
							      irn = 3448828 OR
							      irn = 3440729 OR
							      irn = 3440896";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/DinoButton.jpg" border="2"></a><br>
			<font color="#336699" face="Tahoma" size="2">
				Selected Dinosaur Specimens with Images<br>
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
					$holidayset->Where = "irn = 3021058 OR
							      irn = 3021362 OR
							      irn = 3583034 OR
							      irn = 3440287 OR
							      irn = 3416659 OR
							      irn = 3422513 OR
							      irn = 3396209 OR
							      irn = 3447910 OR
							      irn = 3450096";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/ExcellentPresButton.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2">
				Examples of Excellent Specimen Preservation<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/pal/QueryForms.php');
			$queryform = new NmnhPalBasicQueryForm;
			$queryform->ResultsListPage = 'ResultsList.php';
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
                        <font face="Tahoma" color="#0000FF">
                                <font color="#0000FF"><a href="DtlQuery.php"><b><u>Detailed Search</u></b></a>
                        </font>
		</p>
		</td> 
		<td width="128" align="center" valign="center" bgcolor="#FFF3DE"> 
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 3577924 OR
							      irn = 3421155 OR
							      irn = 3421158 OR
							      irn = 3424581 OR
							      irn = 3401456 OR
							      irn = 3397854 OR
							      irn = 3447710 OR
							      irn = 3578433 OR
							      irn = 3417662 OR
							      irn = 3417789 OR
							      irn = 3584271 OR
							      irn = 3577250 OR
							      irn = 3588411 OR
							      irn = 3418492";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/GreatWhiteButton.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				The Fossil Great White Shark<br>
			</font>
		</td>
	</tr>
</table>
<?php include "footer.php" ?>
</body>
</html>
