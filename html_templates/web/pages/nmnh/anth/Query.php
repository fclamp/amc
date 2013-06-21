
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
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Anthropology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large.html" ?>

<html>
<head>
	<title>Search the NMNH Department of Anthropology Collections</title>
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
				<p>
					<b>Search the Archaeology and Ethnology Collections</b>
				</p>
				<p>
					Information about this database, our image use policy, search tips, and a list of additional sources of information are available in the <a href="http://nhb-acsmith1.si.edu/anthroDBintro.html">Introduction</a>.
				</p>
				<p>
					Use the search box below to perform simple keyword searches on selected fields. If you need to search on another field, use the <a href="DtlQuery.php">detailed search</a>. If you would just like to see a sample from the collection, click on the image to the left for a diverse selection of artifacts, or choose a topic from the 'Quick Browse' section on the right.
				</p>
				<p>
					For more information about Anthropology collections, see our <a href="http://anthropology.si.edu/cm/index.htm">main collections page</a>.
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
						$holidayset->Where = "irn = 8352171 or
								    irn =  8352172 or
								    irn =  8352173 or
								    irn =  8352174 or
								    irn =  8352207 or
								    irn =  8352209 or
								    irn =  8352211 or
								    irn =  8359813 or
								    irn =  8359878 or
								    irn =  8360277 or
								    irn =  8367434 or
								    irn =  8367445 or
								    irn =  8367493 or
								    irn =  8367527 or
								    irn =  8367546 or
								    irn =  8368271 or
								    irn =  8371619 or
								    irn =  8372508 or
								    irn =  8372519 or
								    irn =  8372530 or
								    irn =  8372541 or
								    irn =  8372564 or
								    irn =  8372597 or
								    irn =  8372608 or
								    irn =  8372619 or
								    irn =  8372632 or
								    irn =  8372643 or
								    irn =  8372665 or
								    irn =  8372756 or
								    irn =  8372768 or
								    irn =  8372820 or
								    irn =  8372875 or
								    irn =  8373028 or
								    irn =  8373085 or
								    irn =  8373089 or
								    irn =  8378229 or
								    irn =  8378276 or
								    irn =  8378293 or
								    irn =  8378294 or
								    irn =  8378494 or
								    irn =  8378572 or
								    irn =  8378573 or
								    irn =  8378574 or
								    irn =  8378575 or
								    irn =  8378577 or
								    irn =  8378603 or
								    irn =  8378605 or
								    irn =  8378606 or
								    irn =  8378960 or
								    irn =  8379296 or
								    irn =  8410498 or
								    irn =  8468143 or
								    irn =  8468144 or
								    irn =  8468185 or
								    irn =  8468552 or
								    irn =  8470323 or
								    irn =  8470334 or
								    irn =  8470345 or
								    irn =  8484426 or
								    irn =  8339935 or
								    irn =  8339936 or
								    irn =  8339937 or
								    irn =  8339938 or
								    irn =  8339943 or
								    irn =  8402149";
						$holidayset->ResultsListPage = 'ResultsList.php';
						$holidayset->PrintRef();
					?>
	  			"><img src="images/E2671_tiny.jpg"></a><br>
			</font>
			<font color="#336699" face="Tahoma" size="2">
				War Department Collection, 1864
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
						$holidayset->Where = "irn = 8314175 or
								      irn = 8314239 or
								      irn = 8009759 or
								      irn = 8010131 or
								      irn = 8026567 or
								      irn = 8030218 or
								      irn = 8043122 or
								      irn = 8047379 or
								      irn = 8047382 or
								      irn = 8054373 or
								      irn = 8071703 or
								      irn = 8071752 or
								      irn = 8072515 or
								      irn = 8072552 or
								      irn = 8072575 or
								      irn = 8072819 or
								      irn = 8073146 or
								      irn = 8075360 or
								      irn = 8075476 or
								      irn = 8075477 or
								      irn = 8077485 or
								      irn = 8077492 or
								      irn = 8077502 or
								      irn = 8077517 or
								      irn = 8077533 or
								      irn = 8077852 or
								      irn = 8079304 or
								      irn = 8080771 or
								      irn = 8085119 or
								      irn = 8101697 or
								      irn = 8103101 or
								      irn = 8110603 or
								      irn = 8110925 or
								      irn = 8110930 or
								      irn = 8121919 or
								      irn = 8121926 or
								      irn = 8121930 or
								      irn = 8121944 or
								      irn = 8121947 or
								      irn = 8124348 or
								      irn = 8126274 or
								      irn = 8126277 or
								      irn = 8126289 or
								      irn = 8168467 or
								      irn = 8168476 or
								      irn = 8175519 or
								      irn = 8175520 or
								      irn = 8175522 or
								      irn = 8182572 or
								      irn = 8184940 or
								      irn = 8188781 or
								      irn = 8193597 or
								      irn = 8193671 or
								      irn = 8193684 or
								      irn = 8193887 or
								      irn = 8193897 or
								      irn = 8206876 or
								      irn = 8206883 or
								      irn = 8206907 or
								      irn = 8208096 or
								      irn = 8208100 or
								      irn = 8208102 or
								      irn = 8219975 or
								      irn = 8219984 or
								      irn = 8503876 or
								      irn = 8503881 or
								      irn = 8503885 or
								      irn = 8503894 or
								      irn = 8503979 or
								      irn = 8503980 or
								      irn = 8503990 or
								      irn = 8504005 or
								      irn = 8504006";
						$holidayset->ResultsListPage = 'ResultsList.php';
						$holidayset->PrintRef();
					?>
				"><img src="images/a553069_tiny.jpg"></a><br>
			</font>
			<font face="Tahoma" color="#336699" size="2">
				Selected Egyptian Archaeology
			</font>
			<br>
			</div>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/anth/QueryForms.php');
			$queryform = new NmnhAnthBasicQueryForm;
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
			<font face="Tahoma" color="#0000FF" size=3>
				<a href="DtlQuery.php"><b>Detailed Search</b></a>
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
					$holidayset->Where = "irn = 8083872 or
								      irn = 8083873 or
								      irn = 8083871 or
								      irn = 8376356 or
								      irn = 8376319 or
								      irn = 8376321 or
								      irn = 8411378 or
								      irn = 8403666 or
								      irn = 8421183 or
								      irn = 8376260 or
								      irn = 8376279 or
								      irn = 8376264 or
								      irn = 8377647 or
								      irn = 8381197 or
								      irn = 8376146 or
								      irn = 8376148 or
								      irn = 8407560 or
								      irn = 8414724 or
								      irn = 8409708 or
								      irn = 8433040 or
								      irn = 8409707 or
								      irn = 8435421 or
								      irn = 8344757 or
								      irn = 8376339 or
								      irn = 8377676 or
								      irn = 8376320 or
								      irn = 8376322 or
								      irn = 8418816 or
								      irn = 8419351 or
								      irn = 8479358 or
								      irn = 8334997 or
								      irn = 8393720 or
								      irn = 8425329 or
								      irn = 8376449 or
								      irn = 8383670 or
								      irn = 8376294 or
								      irn = 8376519 or
								      irn = 8083878 or
								      irn = 8395632 or
								      irn = 8365064 or
								      irn = 8487688 or
								      irn = 8401929 or
								      irn = 8376342 or
								      irn = 8376115 or
								      irn = 8393911 or
								      irn = 8426419 or
								      irn = 8376402 or
								      irn = 8376513 or
								      irn = 8365988 or
								      irn = 8409843 or
								      irn = 8376142 or
								      irn = 8414732 or
								      irn = 8393905 or
								      irn = 8403853 or
								      irn = 8340847 or
								      irn = 8341008 or
								      irn = 8383671 or
								      irn = 8376375 or
								      irn = 8376374 or
								      irn = 8414719 or
								      irn = 8417593 or
								      irn = 8376368 or
								      irn = 8376346 or
								      irn = 8376345 or
								      irn = 8403894 or
								      irn = 8377689 or
								      irn = 8393885 or
								      irn = 8336559 or
								      irn = 8403895 or
								      irn = 8340844 or
								      irn = 8376386 or
								      irn = 8376347 or
								      irn = 8376340 or
								      irn = 8376523 or
								      irn = 8376183 or
								      irn = 8083874 or
								      irn = 8083876 or
								      irn = 8376396 or
								      irn = 8457946 or
								      irn = 8387690 or
								      irn = 8376381 or
								      irn = 8417591 or
								      irn = 8376384 or
								      irn = 8487443 or
								      irn = 8400050 or
								      irn = 8376354 or
								      irn = 8435423 or
								      irn = 8376308";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/e383640_tiny.jpg"></a><br>
			</font>
			<font face="Tahoma" color="#336699" size="2"> 
				Hawaii, Selected Objects
			</font>
			<br>
			<br>
			</div>
		</td>
	</tr>
</table>
<br>
<?php include "footer.php" ?>
</body>
</html>
