
<script language="php"> 

function rotate_images() 
{ 
	// open directory, images must be in a separate directory 
	$dir_pointer = dir( "rotationFishes" ); 

	// make an array of filenames 
	while( $entryName = $dir_pointer->read() ) 
	{ 
		// don't include parent/current directory listing /. /.. 
		if( !ereg( "^\.", $entryName ) ) 
		$file_array[] = $entryName; 

		// could be done this way to simplify some code below 
		# $file_array[] = "rotationFishes/$entryName"; 
	} 
                                     
	// close directory 
	$dir_pointer->close(); 
                                     
	$count_array = count( $file_array ) - 1; 
                                     
	// intialize random seed 
	srand( time() ); 
                                     
	// get a random index number to pull from array 
	$random_no = rand( 0, $count_array ); 
                                     
	// make a file pointer 
	$file_name = "rotationFishes/$file_array[$random_no]"; 
                                     
	// or if directory added to array element 
	#$file_name = $file_array[$random_no]; 
                                     
	// get image dimensions 
	$image_size = getimagesize( $file_name ); 
                                     
	// create dynamic image tag 
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Vertebrate Zoology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large-fishes.html" ?>

<html>
<head>
	<title>Search the NMNH Division of Fishes Collections</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="1" valign=top rowspan="3"> 
				<font color="#013567" size="2" face="Tahoma">
					<a href="rotation_masterFishes.php"><?php print rotate_images(); ?></a> 
					<b>Fish Collections Data at NMNH</b><br>
					<br>
					The online Fish Collection database includes all relevant information for each cataloged lot of specimens. Please note that slightly over 50% of our holdings are presently listed and we are constantly adding records. There are currently only a small number of images associated with catalog records. Approximately 95% of families with freshwater-dwelling species, but less than 50% of those of saltwater-dwelling species are entered into the database and available for online search. Data included in the Locality field are directly from a collector's field notes or from cruise logs. Geographic retrieval fields added by cataloging staff are based on internally defined criteria and may not be geographically accurate. If you spot an error in our data please let us know.<br>
					<br>
					<b>Search the Fish Collections</b><br>
					<br>
					We recommend that you use the <a href="DtlQueryFishes.php">Detailed Search</a> link below for most queries (e.g. scientific name or specific locality) to achieve best search results. Key word searches on any available field can be run from the Quick Search box below. Don't know what to search for? Try one of the three sample searches in the Quick Browse panel at right.<br>
					<br>
					Common name search is currently unavailable.<br>
					<br>
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
					$holidayset->Where = "irn = 5000175 or
							      irn = 5000187 or
							      irn = 5022234 or
							      irn = 5044754 or
							      irn = 5022962 or
							      irn = 5023127 or
							      irn = 5023741 or
							      irn = 5046259 or
							      irn = 5090233 or
							      irn = 5090258 or
							      irn = 5024496 or
							      irn = 5024505 or
							      irn = 5003060 or
							      irn = 5049575 or
							      irn = 5072485 or
							      irn = 5029261 or
							      irn = 5029598 or
							      irn = 5051620 or
							      irn = 5030204 or
							      irn = 5030215 or
							      irn = 5030218 or
							      irn = 5250237 or
							      irn = 5030362 or
							      irn = 5001016 or
							      irn = 5015386 or
							      irn = 5011816 or
							      irn = 5031488 or
							      irn = 5053677 or
							      irn = 5053680 or
							      irn = 5053681 or
							      irn = 5031651 or
							      irn = 5031838 or
							      irn = 5010825 or
							      irn = 5011442 or
							      irn = 5012580 or
							      irn = 5012619 or
							      irn = 5013032 or
							      irn = 5013161 or
							      irn = 5013236 or
							      irn = 5013560 or
							      irn = 5079726 or
							      irn = 5080073 or
							      irn = 5058811 or
							      irn = 5036958 or
							      irn = 5037285 or
							      irn = 5037287 or
							      irn = 5037292 or
							      irn = 5213604 or
							      irn = 5192201 or
							      irn = 5038153 or
							      irn = 5017130 or
							      irn = 5017131 or
							      irn = 5039176 or
							      irn = 5025108 or
							      irn = 5039196 or
							      irn = 5039239 or
							      irn = 5039243 or
							      irn = 5039721 or
							      irn = 5062105 or
							      irn = 5062113 or
							      irn = 5062138 or
							      irn = 5018295 or
							      irn = 5063179 or
							      irn = 5063186 or
							      irn = 5085417 or
							      irn = 5012151 or
							      irn = 5065740 or
							      irn = 5013263 or
							      irn = 5011823 or
							      irn = 5013179";
					$holidayset->ResultsListPage = 'ResultsListFishes.php';
					$holidayset->PrintRef();
				?>
	  		"><img src="images/xray_thumb_fishes.jpg" border="2"></a><br>
			<font color="#336699" face="Tahoma" size="2">
				Holotypes with Radiographs<br>
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
					$holidayset->Where = "irn = 5293986 or
							      irn = 5294568 or
							      irn = 5294134 or
							      irn = 5275259 or
							      irn = 5275320 or
							      irn = 5293921 or
							      irn = 5294506 or
							      irn = 5294362 or
							      irn = 5294202 or
							      irn = 5294057 or
							      irn = 5294513 or
							      irn = 5294891 or
							      irn = 5294755 or
							      irn = 5294114 or
							      irn = 5294889 or
							      irn = 5294759 or
							      irn = 5294115 or
							      irn = 5294113 or
							      irn = 5293884 or
							      irn = 5295034 or
							      irn = 5294840 or
							      irn = 5294700 or
							      irn = 5294099 or
							      irn = 5293988 or
							      irn = 5294767 or
							      irn = 5294543 or
							      irn = 5294652 or
							      irn = 5293679 or
							      irn = 5294561 or
							      irn = 5294832 or
							      irn = 5293776 or
							      irn = 5294667 or
							      irn = 5294666 or
							      irn = 5294663 or
							      irn = 5294504 or
							      irn = 5294507 or
							      irn = 5294825 or
							      irn = 5294662 or
							      irn = 5294641 or
							      irn = 5294564 or
							      irn = 5294695 or
							      irn = 5293677 or
							      irn = 5294756 or
							      irn = 5294060 or
							      irn = 5294534 or
							      irn = 5294398 or
							      irn = 5294542 or
							      irn = 5293670 or
							      irn = 5294503 or
							      irn = 5294690 or
							      irn = 5294366 or
							      irn = 5294689 or
							      irn = 5304938 or
							      irn = 5294396 or
							      irn = 5295028 or
							      irn = 5294764 or
							      irn = 5295026 or
							      irn = 5294093 or
							      irn = 5294644 or
							      irn = 5294765 or
							      irn = 5294358 or
							      irn = 5294092 or
							      irn = 5294102 or
							      irn = 5294348 or
							      irn = 5294563 or
							      irn = 5304904 or
							      irn = 5294708 or
							      irn = 5293966 or
							      irn = 5293950 or
							      irn = 5295243 or
							      irn = 5294762 or
							      irn = 5294119 or
							      irn = 5275495 or
							      irn = 5293894 or
							      irn = 5294193 or
							      irn = 5294212 or
							      irn = 5293970 or
							      irn = 5293905 or
							      irn = 5284680 or
							      irn = 5284711 or
							      irn = 5294557 or
							      irn = 5294877 or
							      irn = 5294935 or
							      irn = 5304926 or
							      irn = 5294790 or
							      irn = 5293676 or
							      irn = 5294826 or
							      irn = 5294515 or
							      irn = 5294126 or
							      irn = 5293777 or
							      irn = 5294523"; 
					$holidayset->ResultsListPage = 'ResultsListFishes.php';
					$holidayset->PrintRef();
				?>
				"><img src="images/mindoro_thumb_fishes.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2">
				2000 Expedition to Mindoro, Philippines<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="1" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/vz/QueryForms.php');
			$queryform = new NmnhVzFishesBasicQueryForm;
			$queryform->ResultsListPage = 'ResultsListFishes.php';
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
				<a href="DtlQueryFishes.php"><b><u>Detailed Search</u></b></a>
			</font>
		</p>
		</td> 
		<td width="128" align="center" valign="center" bgcolor="#FFF3DE"> 
			<br>
			<a href="
				<?php
					require_once('../../../objects/common/PreConfiguredQuery.php');
					$holidayset = new PreConfiguredQueryLink;
					$holidayset->Where = "irn = 5294568 or 
							      irn = 5294134 or
							      irn = 5275259 or
							      irn = 5275320 or
							      irn = 5293921 or
							      irn = 5294506 or
							      irn = 5294362";
					$holidayset->ResultsListPage = 'ResultsListFishes.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/eel_thumb_fishes.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				Eel Records with Images
			</font>
			<br>
		</td>
	</tr>
</table>
<br>
<?php include "footerFishes.php" ?>
</body>
</html>
