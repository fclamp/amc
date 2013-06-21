<<<<<<< Query.php

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
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Mineral Sciences Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large.html" ?>

<html>
<head>
	<title>Search the NMNH Department of Mineral Sciences</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="1" valign=top rowspan="3"> 
		<p>
			<font color="#013567" size="2" face="Tahoma">
				<a href="rotation_master.php"><?php print rotate_images(); ?></a> 
			</font>
		</td>
		<td colspan="1" valign=top rowspan="3"> 
		<p>
			<font color="#013567" size="2" face="Tahoma">
				<b>Mineral Sciences Collections Search</b><br>
				<br>
			</font>
			<font color="#013567" size="2" face="Tahoma">
				If you don't know what you want to see, you may want to try the choices in the Quick Browse section to the right.<br>
				<br>
				Key word searches on all available fields can be performed in the main search box below. 
			</font>
			<font color="#013567" size="2" face="Tahoma">
				Advanced searches and searches on values in specific fields are available on the links below.
			</font>
		</p>
		<p>
			<font color="#013567" size="2" face="Tahoma">
				Please note: we have electronic data on less than 10% of our collections and images for even fewer. 
				We constantly add new data and correct records.<br>
				If you see an error please let us know.
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
					$holidayset->Where = "irn = ?";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/amatrene_sm.jpg" border="2"></a><br>
			<font color="#336699" face="Tahoma" size="2">
				QB1<br>
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
					$holidayset->Where = "irn = ?";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/quartz_sm.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2">
				QB2<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/ms/QueryForms.php');
			$queryform = new NmnhMsBasicQueryForm;
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
					$holidayset->Where = "irn = ?";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/smithsonite_sm.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				QB3<br>
			</font>
		</td>
	</tr>
</table>
<?php include "footer.html" ?>
</body>
</html>
=======

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
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Mineral Sciences Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large.html" ?>

<html>
<head>
	<title>Search the NMNH Department of Mineral Sciences</title>
</head>

<br>

<table border="0" width="817" cellspacing="3" cellpadding="2" height="0">
	<tr> 
		<td colspan="2" valign=top rowspan="3"> 
		<p>
			<font color="#013567" size="2" face="Tahoma">
				<a href="rotation_master.php"><?php print rotate_images(); ?></a> 
				<b>Mineral Sciences Collections Search</b><br>
				<br>
				If you don't know what you want to see, you may want to try the choices in the Quick Browse section to the right.<br>
				<br>
				Key word searches on all available fields can be performed in the main search box below. <a href="DtlQuery.php">Detailed searches</a> on values in specific fields are available via the link below. Searches will return a maximum of 5000 records, and the results are sorted by Meteorite Name (when present) and Catalog Number. 
		</p>
		<p>
				Please note: we have electronic records for more than 90% of our collections, but images for less than 10%. 
				We constantly add new data and correct records. If searches do not return expected data users are welcome to <a href="http://www.mineralsciences.si.edu/contact.htm">contact Department of Mineral Sciences collection managers</a>. 
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
					$holidayset->Where = "irn = 1148046 or
							      irn = 1148445 or
							      irn = 1172392 or
							      irn = 1138201 or
							      irn = 1156561 or
							      irn = 1007571 or
							      irn = 1000874 or
							      irn = 1000938 or
							      irn = 1000974 or
							      irn = 1169689 or
							      irn = 1001363 or
							      irn = 1170449 or
							      irn = 1001949 or
							      irn = 1171989 or
							      irn = 1002199 or
							      irn = 1154109 or
							      irn = 1173528 or
							      irn = 1155721 or
							      irn = 1174202 or
							      irn = 1155798 or
							      irn = 1155900 or
							      irn = 1156193 or
							      irn = 1156296 or
							      irn = 1156446 or
							      irn = 1005033 or
							      irn = 1176306 or
							      irn = 1177142 or
							      irn = 1005819 or
							      irn = 1005834 or
							      irn = 1177894 or
							      irn = 1006570 or
							      irn = 1006586 or
							      irn = 1000172 or
							      irn = 1159153 or
							      irn = 1159712 or
							      irn = 1128915 or
							      irn = 1130454 or
							      irn = 1163254 or
							      irn = 1163595 or
							      irn = 1165513 or
							      irn = 1165930 or
							      irn = 1166677 or
							      irn = 1166822 or
							      irn = 1167180 or
							      irn = 1167199 or
							      irn = 1167303 or
							      irn = 1167304 or
							      irn = 1350159 or
							      irn = 1112816 or
							      irn = 1119075 or
							      irn = 1120024 or
							      irn = 1120695 or
							      irn = 1044194 or
							      irn = 1049125 or
							      irn = 1179330 or
							      irn = 1051340 or
							      irn = 1051893 or
							      irn = 1052193 or
							      irn = 1053747 or
							      irn = 1058244 or
							      irn = 1058656 or
							      irn = 1058717 or
							      irn = 1060827 or
							      irn = 1061373 or
							      irn = 1180674 or
							      irn = 1063563 or
							      irn = 1069288 or
							      irn = 1069829 or
							      irn = 1071369 or
							      irn = 1074347 or
							      irn = 1074397 or
							      irn = 1075012 or
							      irn = 1075709 or
							      irn = 1075878 or
							      irn = 1077007 or
							      irn = 1077488 or
							      irn = 1081323 or
							      irn = 1082384 or
							      irn = 1084737 or
							      irn = 1086367 or
							      irn = 1086396 or
							      irn = 1086708 or
							      irn = 1086710 or
							      irn = 1086852 or
							      irn = 1087651 or
							      irn = 1099479 or
							      irn = 1100118 or
							      irn = 1100119 or
							      irn = 1101737 or
							      irn = 1104562 or
							      irn = 1107314 or
							      irn = 1107330 or
							      irn = 1350747 or
							      irn = 1107635 or
							      irn = 1107770 or
							      irn = 1107808 or
							      irn = 1108233 or
							      irn = 1350031 or
							      irn = 1350040 or
							      irn = 1350041";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/Smithsonite.jpg" border="2" alt="Smithsonite - Gems and Minerals records"></a><br>
			<font color="#336699" face="Tahoma" size="2">
				Gems &amp; Minerals with images<br>
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
					$holidayset->Where = "irn = 1015332 or
							      irn = 1016091 or
							      irn = 1017023 or
							      irn = 1017941 or
							      irn = 1018098 or
							      irn = 1018512 or
							      irn = 1019327 or
							      irn = 1020692 or
							      irn = 1020768 or
							      irn = 1020994 or
							      irn = 1021122 or
							      irn = 1021276 or
							      irn = 1033181 or
							      irn = 1033220 or
							      irn = 1369228 or
							      irn = 1033312 or
							      irn = 1035076 or
							      irn = 1033427 or
							      irn = 1033489 or
							      irn = 1033532 or
							      irn = 1033602 or
							      irn = 1033650 or
							      irn = 1013503 or
							      irn = 1013586 or
							      irn = 1013820 or
							      irn = 1014053 or
							      irn = 1014055 or
							      irn = 1014156 or
							      irn = 1014211 or
							      irn = 1040194 or
							      irn = 1014495 or
							      irn = 1014523 or
							      irn = 1014686 or
							      irn = 1014882 or
							      irn = 1015329 or
							      irn = 1040512 or
							      irn = 1040513 or
							      irn = 1015455 or
							      irn = 1015456 or
							      irn = 1015544 or
							      irn = 1015804 or
							      irn = 1016636 or
							      irn = 1016708 or
							      irn = 1016925 or
							      irn = 1017013 or
							      irn = 1017046 or
							      irn = 1017147 or
							      irn = 1041000 or
							      irn = 1017402 or
							      irn = 1042362 or
							      irn = 1017504 or
							      irn = 1041159 or
							      irn = 1019128 or
							      irn = 1019909 or
							      irn = 1020278 or
							      irn = 1020329 or
							      irn = 1020332 or
							      irn = 1020562 or
							      irn = 1020571 or
							      irn = 1020584 or
							      irn = 1020616 or
							      irn = 1041585 or
							      irn = 1041586 or
							      irn = 1041587 or
							      irn = 1021031 or
							      irn = 1021134 or
							      irn = 1041706 or
							      irn = 1041707 or
							      irn = 1369761 or
							      irn = 1021451 or
							      irn = 1021463 or
							      irn = 1021467 or
							      irn = 1021979 or
							      irn = 1022201 or
							      irn = 1022223 or
							      irn = 1369790 or
							      irn = 1022242 or
							      irn = 1022283 or
							      irn = 1022289 or
							      irn = 1022304 or
							      irn = 1023225 or
							      irn = 1023599 or
							      irn = 1023720 or
							      irn = 1023880 or
							      irn = 1024845 or
							      irn = 1041954 or
							      irn = 1041955 or
							      irn = 1025444 or
							      irn = 1026865 or
							      irn = 1027662 or
							      irn = 1030842 or
							      irn = 1030854 or
							      irn = 1030790 or
							      irn = 1030796 or
							      irn = 1030808 or
							      irn = 1369812 or
							      irn = 1369813 or
							      irn = 1369814 or
							      irn = 1369815 or
							      irn = 1369811";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/Williamette.jpg" border="2" alt="Williamette - Meteorite records"></a><br>
			<font face="Tahoma" color="#336699" size="2">
				Meteorites with images<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/ms/QueryForms.php');
			$queryform = new NmnhMsBasicQueryForm;
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
					$holidayset->Where = "irn = 1353349 or
							      irn = 1321799 or
							      irn = 1350978 or
							      irn = 1350583 or
							      irn = 1321805 or
							      irn = 1321819 or
							      irn = 1350578 or
							      irn = 1321827 or
							      irn = 1350901 or
							      irn = 1350916 or
							      irn = 1321837 or
							      irn = 1350975 or
							      irn = 1321852 or
							      irn = 1350546 or
							      irn = 1350867 or
							      irn = 1321875 or
							      irn = 1321878 or
							      irn = 1351046 or
							      irn = 1350541 or
							      irn = 1321882 or
							      irn = 1350535 or
							      irn = 1350605 or
							      irn = 1321886 or
							      irn = 1350595 or
							      irn = 1350899 or
							      irn = 1351051 or
							      irn = 1321890 or
							      irn = 1321893 or
							      irn = 1350556 or
							      irn = 1205100 or
							      irn = 1351052 or
							      irn = 1211847 or
							      irn = 1321913 or
							      irn = 1350877 or
							      irn = 1211878 or
							      irn = 1350905 or
							      irn = 1211886 or
							      irn = 1353543 or
							      irn = 1350584 or
							      irn = 1321969 or
							      irn = 1321972 or
							      irn = 1321976 or
							      irn = 1321977 or
							      irn = 1321981 or
							      irn = 1321982 or
							      irn = 1211963 or
							      irn = 1321990 or
							      irn = 1321991 or
							      irn = 1321553 or
							      irn = 1321558 or
							      irn = 1211481 or
							      irn = 1211482 or
							      irn = 1211483 or
							      irn = 1211484 or
							      irn = 1350525 or
							      irn = 1350524 or
							      irn = 1331699 or
							      irn = 1337538 or
							      irn = 1249488 or
							      irn = 1321604 or
							      irn = 1321612 or
							      irn = 1321615 or
							      irn = 1321617 or
							      irn = 1321621 or
							      irn = 1321623 or
							      irn = 1321637 or
							      irn = 1321641 or
							      irn = 1321647 or
							      irn = 1321649 or
							      irn = 1321650 or
							      irn = 1321652 or
							      irn = 1321658 or
							      irn = 1321659 or
							      irn = 1321674 or
							      irn = 1321676 or
							      irn = 1344959 or
							      irn = 1345003 or
							      irn = 1322042 or
							      irn = 1211519 or
							      irn = 1211526 or
							      irn = 1211544 or
							      irn = 1211553 or
							      irn = 1211563 or
							      irn = 1211566 or
							      irn = 1260821 or
							      irn = 1211570 or
							      irn = 1211573 or
							      irn = 1211653 or
							      irn = 1211656 or
							      irn = 1261560 or
							      irn = 1211663 or
							      irn = 1211664 or
							      irn = 1211666 or
							      irn = 1261565 or
							      irn = 1211673 or
							      irn = 1321826 or
							      irn = 1321846 or
							      irn = 1321993 or
							      irn = 1321858 or
							      irn = 1321859";
					$holidayset->ResultsListPage = 'ContactSheet.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/BasaltOlivine.jpg" border="2" alt="Basalt (Olivine) - Rock and Ore records"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				Rocks and Ores with images<br>
			</font>
		</td>
	</tr>
</table>
<?php include "footer.php" ?>
</body>
</html>
>>>>>>> 1.6
