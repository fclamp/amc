
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
		$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Botany Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
		return $out; 
	} 
</script> 

<?php include "header-large.html" ?>

<html>
	<head>
		<title>Search the NMNH Department of Botany</title>
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
			        <b>Botany Collections</b><br>
				<br>
				The plant collections of the Smithsonian Institution began with the acquisition of specimens collected by the United States Exploring Expedition (1838-1842).  These formed the foundation of a national herbarium which today numbers 4.8 million historical plant records, placing it among the world's largest and most important.<br>
				<br>
				Nearly 800,000 specimen records (including over 90,000 type specimens) are currently available in this online catalog. Images for the type specimens are available in our <a href="http://botany.si.edu/types/">Type Specimen Register</a>.<br>
				<br>
				<b>Search the Botany Collections</b><br>
				<br>
				Key word searches on selected fields can be performed in the search box below. <a href="DtlQuery.php">Detailed Searches</a> on values on specific fields are available through the link below. If you don't know what you want to see, you may want to look at the sample records in the 'Quick Browse' section to the right. Searches are limited to 2000 records and the results are sorted by taxonomic group. If you need to retrieve a larger record set, contact the Department of Botany's <a href="mailto:russellr@si.edu">Collections Manager</a>.
			</p>
			<p>
				&nbsp;
			</p>    
				</font>
		</td>

		<td width="128" valign="middle" bgcolor="#003366" align="center" height="32"> 
			<b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick Browse</font> 
			<br>
			</b> 
		</td>
		</tr>
		<tr> 
			<td width="128" valign="center" bgcolor="#FFF3DE" align="center"> 
				<br>
				<a href="<?php
						require_once('../../../objects/common/PreConfiguredQuery.php');
						// Botany Holiday Card Set
						$holidayset = new PreConfiguredQueryLink;
						$holidayset->Where = "irn = 2119407 or
								      irn = 2149872 or
								      irn = 2161549 or
								      irn = 2790611 or
								      irn = 2105614 or
								      irn = 2099734 or
								      irn = 2134596 or
								      irn = 2116358 or
								      irn = 2166713 or
								      irn = 2151580 or
								      irn = 2158541 or
								      irn = 2143664 or
								      irn = 2097212 or
								      irn = 2076608 or
								      irn = 2167306 or
								      irn = 2121665 or
								      irn = 2095940 or
								      irn = 2075490";
						$holidayset->ResultsListPage = 'ResultsList.php';
						$holidayset->PrintRef();
					?>"><img src="images/Type-button.jpg" border="2"><br></a>
				<font color="#336699" face="Tahoma" size="2">
					Sample Records from the Botanical Type Register<br>
       		 		</font>
			</td>
		</tr>

		<tr> 
			<td width="128" valign="center" bgcolor="#FFF3DE" align="center"> 
				<br>
				<a href="<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					// Botany Holiday Card Set
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 2524597 or
							      irn = 2705372 or
							      irn = 2705371 or
							      irn = 2743367 or
							      irn = 2699717 or
							      irn = 2741233 or
							      irn = 2741229 or
							      irn = 2733613 or
							      irn = 2741227 or
							      irn = 2680776 or
							      irn = 2741226 or
							      irn = 2741217 or
							      irn = 2741216 or
							      irn = 2687168 or
							      irn = 2702446 or
							      irn = 2684992 or
							      irn = 2680753 or
							      irn = 2680752 or
							      irn = 2741176 or
							      irn = 2741175 or
							      irn = 2693758 or
							      irn = 2680751 or
							      irn = 2678261";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>"><img src="images/WilkesVoyagers-button.jpg" border="2"></a><br>
				<font face="Tahoma" color="#336699" size="2">
					Sample Records from the Wilkes Expedition<br>
				</font>
			</td>
		</tr>

		<tr>
			<td height="111" colspan="2" valign=top><p>
				<?php
					require_once('../../../objects/nmnh/bot/QueryForms.php');
					$queryform = new NmnhBotanyBasicQueryForm;
					$queryform->ResultsListPage = 'ResultsList.php';
					$queryform->Title = 'Quick Search';
					$queryform->FontFace = 'Arial';
					$queryform->FontSize = '2';
					$queryform->TitleTextColor = '#FFFFFF';
					$queryform->BorderColor = '#013567';
					$queryform->BodyColor = '#FFF3DE';
					$queryform->Show();
				?>
			        <font color="#013567" size="2" face="Tahoma"> </font></p>
			        <p>
					<font face="Tahoma" color="#0000FF"><u><a href="DtlQuery.php"><b>Detailed Search</b></a></u>
					</font>
				</p>
			</td> 
		    	<td width="128" align="center" valign="middle" bgcolor="#FFF3DE"> 
				<br>
				<a href="<?php
						require_once('../../../objects/common/PreConfiguredQuery.php');
						// Botany Holiday Card Set
						$holidayset = new PreConfiguredQueryLink;
						$holidayset->Where = "irn = 2205692 or
	               						      irn = 2197595 or
	               						      irn = 2191752 or
	               						      irn = 2175968 or
	               						      irn = 2213272 or
	               						      irn = 2196389 or
	               						      irn = 2200318 or
	               						      irn = 2192830 or
                       						      irn = 2219158 or
                       						      irn = 2200909 or
                       						      irn = 2208745 or
                       						      irn = 2223985 or
                       						      irn = 2175937 or
                       						      irn = 2192264 or
                       						      irn = 2220376";
						$holidayset->ResultsListPage = 'ResultsList.php';
						$holidayset->PrintRef();
				?>"><img src="images/DCFlora-button.jpg" border="2"></a><br>
				<font face="Tahoma" color="#336699" size="2">
					Sample Records from the DC Flora Collection<br>
				</font>
			</td>
		</tr>
	</table>
<br>

<?php include "footer.php" ?>

</body>
</html>
