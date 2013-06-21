
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
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Entomology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large.html" ?>

<html>
<head>
	<title>Search the NMNH Department of Entomology Collections</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="2" valign=top rowspan="3"> 
		<font color="#013567" size="2" face="Tahoma">

				<a href="rotation_master.php"><?php print rotate_images(); ?></a> 
				<b>Entomology Collections Search</b>
			<p>
				The <a href="http://entomology.si.edu/Collections.html">U.S. National Entomological Collection</a> is one of the largest entomological collections in the world, with over 35 million specimens. These initial electronic data from the Department of Entomology focus on bee <a href="http://nhb-acsmith2.si.edu/whataretypes.html">Type Specimen</a> collections and all Odonata collections. We will publish data and images for additional taxonomic groups as they are prepared by the specialists. A custom presentation for our Illustration Archive is also in preparation, although those records and images are currently available here in the interim.
			</p>
			<p>
				Key word searches on summary fields can be performed in the search box below. If you don't know what you want to see, you might explore the sample records in the 'Quick Browse' section to the right. <a href="DtlQuery.php">Detailed Searches</a> across specific fields are available through the link below.
			</p>
			<p>
				Search results are sorted by taxonomic group and limited to 2000 records. If you need to retrieve a larger record set, please <a href="http://entomology.si.edu/ContactUs.html">contact the Department of Entomology</a>.
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
					$holidayset->Where = "irn = 9100322 or
							      irn = 9100358 or
							      irn = 9100367 or
							      irn = 9100370 or
							      irn = 9100371 or
							      irn = 9168462 or
							      irn = 9168746 or
							      irn = 9169407 or
							      irn = 9170469 or
							      irn = 9170730 or
							      irn = 9171576 or
							      irn = 9171905 or
							      irn = 9172004 or
							      irn = 9172130 or
							      irn = 9172134 or
							      irn = 9172229 or
							      irn = 9172266 or
							      irn = 9172771 or
							      irn = 9172798 or
							      irn = 9172922 or
							      irn = 9172992 or
							      irn = 9173924 or
							      irn = 9174025 or
							      irn = 9174117 or
							      irn = 9174177 or
							      irn = 9174449 or
							      irn = 9174508 or
							      irn = 9175324 or
							      irn = 9175349 or
							      irn = 9175861 or
							      irn = 9175862 or
							      irn = 9175865 or
							      irn = 9175900 or
							      irn = 9175906 or
							      irn = 9176131 or
							      irn = 9176995 or
							      irn = 9178114 or
							      irn = 9178634 or
							      irn = 9178622 or
							      irn = 9205142 or
							      irn = 9208004 or
							      irn = 9170469 or
							      irn = 9312640";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/Ceratina_amabilis_thumb.jpg" border="2" alt="Ceratina amabilis"></a><br>
			<font color="#336699" face="Tahoma" size="2">
				Selected imaged bee type specimens<br>
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
					$holidayset->Where = "irn = 9198878 or
							      irn = 9208064 or
							      irn = 9198879 or
							      irn = 9100437 or
							      irn = 9206185 or
							      irn = 9198864 or
							      irn = 9198865 or
							      irn = 9198867 or
							      irn = 9198868 or
							      irn = 9198869 or
							      irn = 9198841 or
							      irn = 9205855 or
							      irn = 9205856 or
							      irn = 9205858 or
							      irn = 9209159 or
							      irn = 9208434 or
							      irn = 9205730 or
							      irn = 9198920 or
							      irn = 9100308 or
							      irn = 9205956 or
							      irn = 9100310 or
							      irn = 9100311 or
							      irn = 9205221 or
							      irn = 9205222 or
							      irn = 9200146 or
							      irn = 9198910 or
							      irn = 9100115 or
							      irn = 9198911 or
							      irn = 9198912 or
							      irn = 9198913 or
							      irn = 9198914 or
							      irn = 9198915 or
							      irn = 9199043 or
							      irn = 9198916 or
							      irn = 9198917 or
							      irn = 9198918 or
							      irn = 9198919 or
							      irn = 9205854 or
							      irn = 9312631 or
							      irn = 9198886 or
							      irn = 9198844 or
							      irn = 9205860 or
							      irn = 9205861 or
							      irn = 9198831 or
							      irn = 9198873 or
							      irn = 9208063 or
							      irn = 9208065 or
							      irn = 9198874 or
							      irn = 9198871 or
							      irn = 9198875 or
							      irn = 9198908 or
							      irn = 9198909 or
							      irn = 9100429 or
							      irn = 9210979 or
							      irn = 9210980 or
							      irn = 9198866 or
							      irn = 9210978";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/00391567_thumb.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2">
				Imaged Odonata type specimens<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/ento/QueryForms.php');
			$queryform = new NmnhEntoBasicQueryForm;
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
				<a href="DtlQuery.php"><b><u>Detailed Search</u></b></a>
			</font>
			<font color="#000000">
				&nbsp; |&nbsp;&nbsp;
			</font>
			<font face="Tahoma" color="#0000FF">
				<a href="DtlQueryIA.php"><b>Illustration Archive</b></a>
			</font>
		</p>
		</td> 
		<td width="128" align="center" valign="center" bgcolor="#FFF3DE"> 
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 9312875 or
							      irn = 9312879 or
							      irn = 9312904 or
							      irn = 9313080 or
							      irn = 9313135 or
							      irn = 9313347 or
							      irn = 9313851 or
							      irn = 9314014 or
							      irn = 9314128 or
							      irn = 9314707 or
							      irn = 9314752 or
							      irn = 9314801 or
							      irn = 9314850 or
							      irn = 9314863 or
							      irn = 9316136 or
							      irn = 9315132 or
							      irn = 9315117 or
							      irn = 9315111 or
							      irn = 9313007 or
							      irn = 9314963 or
							      irn = 9314928";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/Aspasiola_esijhe.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				Selected Illustration Archive records<br>
			</font>
		</td>
	</tr>
</table>
<?php include "footer.php" ?>
</body>
</html>
