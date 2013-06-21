
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
	$out = sprintf( '<img src="%s" %s border="2" vspace="2" hspace="6" align="left" alt="Invertebrate Zoology Photo Galleries" />%s', $file_name, $image_size[3], "\n" ); 
                                     
	return $out; 
} 
</script> 

<?php include "header-large.html" ?>

<html>
<head>
	<title>Search the NMNH Department of Invertebrate Zoology</title>
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
				<b>Invertebrate Zoology Collections Search</b><br>
				<br>
			</font>
			<font color="#013567" size="2" face="Tahoma">
				If you don't know what you want to see, you may want to try the choices in the Quick Browse section to the right.<br>
				<br>
				Key word searches on all available fields can be performed in the main search box below. 
				Searches on values in specific fields are available from the <a href="DtlQuery.php">Detailed Search</a> link below.<br>
				<br>
				Please note: the Department of Invertebrate Zoology has electronic data on less than 33% of our collections 
				and images for even fewer. We constantly add new data and correct records.<br>
				<br>
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
					$holidayset->Where = "irn = 6435 or
							      irn = 32845 or
							      irn = 32979 or
							      irn = 56841 or
							      irn = 74542 or
							      irn = 89645 or
							      irn = 107232 or
							      irn = 143760 or
							      irn = 200582 or
							      irn = 204320 or
							      irn = 284689 or
							      irn = 284945 or
							      irn = 284995 or
							      irn = 285620 or
							      irn = 285653 or
							      irn = 285690 or
							      irn = 285809 or
							      irn = 287113 or
							      irn = 287253 or
							      irn = 287283 or
							      irn = 288815 or
							      irn = 288850 or
							      irn = 337784 or
							      irn = 342702 or
							      irn = 348544 or
							      irn = 355728 or
							      irn = 365849 or
							      irn = 366096 or
							      irn = 366525 or
							      irn = 367062 or
							      irn = 367572 or
							      irn = 368091 or
							      irn = 368393 or
							      irn = 368557 or
							      irn = 369409 or
							      irn = 369812 or
							      irn = 369969 or
							      irn = 378595 or
							      irn = 393987 or
							      irn = 410138 or
							      irn = 469393 or
							      irn = 483562 or
							      irn = 508781 or
							      irn = 523524 or
							      irn = 523548 or
							      irn = 531367 or
							      irn = 531493 or
							      irn = 531776 or
							      irn = 540162 or
							      irn = 543329 or
							      irn = 543649 or
							      irn = 550510 or
							      irn = 552219 or
							      irn = 553018 or
							      irn = 553346 or
							      irn = 553976 or
							      irn = 557554 or
							      irn = 561858 or
							      irn = 568545 or
							      irn = 568703 or
							      irn = 569823 or
							      irn = 569859 or
							      irn = 570007 or
							      irn = 570135 or
							      irn = 570655 or
							      irn = 571295 or
							      irn = 571655 or
							      irn = 572007 or
							      irn = 572212 or
							      irn = 572638 or
							      irn = 572978 or
							      irn = 573154 or
							      irn = 573636 or
							      irn = 575181 or
							      irn = 647548 or
							      irn = 737692 or
							      irn = 779519 or
							      irn = 779559 or
							      irn = 779586 or
							      irn = 782187 or
							      irn = 782293 or
							      irn = 782785 or
							      irn = 783225 or
							      irn = 783539 or
							      irn = 783704 or
							      irn = 783754 or
							      irn = 784740 or
							      irn = 788372 or
							      irn = 794811 or
							      irn = 796028 or
							      irn = 796800 or
							      irn = 797332 or
							      irn = 808781 or
							      irn = 817071 or
							      irn = 818515 or
							      irn = 879451 or
							      irn = 888922";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/Hepatus_epheliticus_thumb.jpg" border="2"></a><br>
			<font color="#336699" face="Tahoma" size="2">
				Selected Photographs of Specimens<br>
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
					$holidayset->Where = "irn = 6405 or 
							      irn = 26260 or
							      irn = 32840 or
							      irn = 32914 or
							      irn = 32945 or
							      irn = 33011 or
							      irn = 53012 or
							      irn = 88333 or
							      irn = 200581 or
							      irn = 200847 or
							      irn = 200851 or
							      irn = 200853 or
							      irn = 284914 or
							      irn = 285618 or
							      irn = 285657 or
							      irn = 285688 or
							      irn = 285698 or
							      irn = 285805 or
							      irn = 287185 or
							      irn = 287262 or
							      irn = 287279 or
							      irn = 288261 or
							      irn = 288819 or
							      irn = 288826 or
							      irn = 288829 or
							      irn = 288846 or
							      irn = 289555 or
							      irn = 341505 or
							      irn = 365988 or
							      irn = 366367 or
							      irn = 366720 or
							      irn = 366744 or
							      irn = 368232 or
							      irn = 368396 or
							      irn = 368714 or
							      irn = 369372 or
							      irn = 369409 or
							      irn = 369894 or
							      irn = 522899 or
							      irn = 531431 or
							      irn = 531517 or
							      irn = 531577 or
							      irn = 531619 or
							      irn = 531664 or
							      irn = 539980 or
							      irn = 540211 or
							      irn = 540613 or
							      irn = 543321 or
							      irn = 550497 or
							      irn = 550503 or
							      irn = 552218 or
							      irn = 552219 or
							      irn = 552420 or
							      irn = 553018 or
							      irn = 553041 or
							      irn = 553540 or
							      irn = 555329 or
							      irn = 555333 or
							      irn = 569817 or
							      irn = 569848 or
							      irn = 570044 or
							      irn = 570064 or
							      irn = 570655 or
							      irn = 571407 or
							      irn = 572312 or
							      irn = 573058 or
							      irn = 573096 or
							      irn = 573122 or
							      irn = 574910 or
							      irn = 647544 or
							      irn = 737258 or
							      irn = 737280 or
							      irn = 737691 or
							      irn = 737694 or
							      irn = 779592 or
							      irn = 779632 or
							      irn = 782074 or
							      irn = 782187 or
							      irn = 782206 or
							      irn = 782212 or
							      irn = 782288 or
							      irn = 782291 or
							      irn = 782760 or
							      irn = 783354 or
							      irn = 783564 or
							      irn = 789685 or
							      irn = 790490 or
							      irn = 796026 or
							      irn = 796043 or
							      irn = 796049 or
							      irn = 796888 or
							      irn = 797979 or
							      irn = 817058 or
							      irn = 817068 or
							      irn = 817076 or
							      irn = 818465 or
							      irn = 818471 or
							      irn = 879449 or
							      irn = 885173 or
							      irn = 885480";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/Serolis_cornuta_thumb.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2">
				Selected NSF Polar Programs Collections Images<br>
			</font>
		</td>
	</tr>
	<tr>
		<td height="111" colspan="2" valign=top>
		<p>
		<?php
			require_once('../../../objects/nmnh/iz/QueryForms.php');
			$queryform = new NmnhIzBasicQueryForm;
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
					$holidayset->Where = "irn = 536025 or
							      irn = 536030 or
							      irn = 426041 or
							      irn = 543885 or
							      irn = 437625 or
							      irn = 414813 or
							      irn = 435836 or
							      irn = 442270 or
							      irn = 446531 or
							      irn = 387538 or
							      irn = 452816 or
							      irn = 426876 or
							      irn = 578753";
					$holidayset->ResultsListPage = 'ResultsList.php';
					$holidayset->PrintRef();
				?>
			"><img src="images/feature-button.jpg" border="2"></a><br>
			<font face="Tahoma" color="#336699" size="2"> 
				Selected Cowrie Specimens<br>
			</font>
		</td>
	</tr>
</table>
<?php include "footer.php" ?>
</body>
</html>
