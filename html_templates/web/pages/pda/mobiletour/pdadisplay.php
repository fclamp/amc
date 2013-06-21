<html>

<body bgcolor="#EOF5DF">

<?php
require_once("../../../objects/common/RecordExtractor.php");

// Written by Martin Jujou
// 18/2/2004
// Last Modified: 28/6/2004


/*
** Extract data from record using the RecordExtractor object, and specify fields to be retrieved
*/
$extractor = new RecordExtractor;
$extractor->Database = "enarratives";
$extractor->NullFieldHolder = "-";
$extractor->ExtractFields(array(
		"NarTitle",
		"NarNarrative",
		"DesVersionDate",
		"DesGeographicLocation_tab",
		"DesSubjects_tab",
		"MulMultiMediaRef_tab",
		"MulMultiMediaRef_tab->emultimedia->SummaryData",
		"MulMultiMediaRef_tab->emultimedia->MulMimeFormat",
		"MulMultiMediaRef_tab->emultimedia->Multimedia",
		));

if (! $extractor->HasValidRecord())
{
	die ("Invalid Request");
}
/*
** Print main image
*/
?>
<center><?php $extractor->PrintImage(100, 100, 1); ?>
<br /><br />
</div></td>

<!-- Begin Main Display Table - Print alternating columns of field heading and field contents -->
<table width="95%" cellspacing="2" cellpadding="4" border="0" class="item2">
<tr><td bgcolor="#EEEEEE" colspan=2><font face="helvetica, arial, sans-serif" size="2"><b>Title</b></font></td></tr>
<tr><td bgcolor="#FFFFFF" colspan=2><font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("NarTitle");?>
&nbsp;</font></td></tr>
<tr><td bgcolor="#EEEEEE" colspan=2><font face="helvetica, arial, sans-serif" size="2"><b>Narrative</b></font></td></tr>
<tr><td bgcolor="#FFFFFF" colspan=2><font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("NarNarrative"); ?>
&nbsp;</font></td></tr>
<tr><td bgcolor="#EEEEEE" colspan=2><font face="helvetica, arial, sans-serif" size="2"><b>Version Date</b></font></td></tr>
<tr><td bgcolor="#FFFFFF" colspan=2><font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintField("DesVersionDate")?>
&nbsp;</font></td></tr>
<tr><td bgcolor="#EEEEEE" colspan=2><font face="helvetica, arial, sans-serif" size="2"><b>Geographic Location</b></font></td></tr>
<tr><td bgcolor="#FFFFFF" colspan=2><font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintMultivalueField("DesGeographicLocation_tab"); ?>
&nbsp;</font></td></tr>
<tr><td bgcolor="#EEEEEE" colspan=2><font face="helvetica, arial, sans-serif" size="2"><b>Subjects</b></font></td></tr>
<tr><td bgcolor="#FFFFFF" colspan=2><font face="helvetica, arial, sans-serif" size="2"><?php $extractor->PrintMultivalueField("DesSubjects_tab"); ?>
&nbsp;</font></td></tr>

<tr><td bgcolor="#EEEEEE" colspan=2><font face="helvetica, arial, sans-serif" size="2"><b>Associated Multimedia</b></font></td></tr>
<tr><td bgcolor="#FFFFFF" colspan=2><font face="helvetica, arial, sans-serif" size="2">
<i>Under Construction .... </i>
<br>
<br>

<?php
/*
** Iterate attached multimedia if there is any and display outside of any table to allow browser
**	to wrap if required
*/


$count = $extractor->MediaCount();


// change this link according to the location of the image display page
$imageDisplay = "http://bondi.syd.kesoftware.com/emuwebartbank/pages/common/imagedisplay.php";

// seed generator
srand(time(NULL));

for($i = 1; $i <= $count; $i++)
{

	// used to change the link to relate to the type of media 
	$type = "MulMultiMediaRef:${i}->emultimedia->MulMimeFormat";
	$type = $extractor->FieldAsValue($type);

	// used for the summary data
	$stuff = "MulMultiMediaRef:${i}->emultimedia->SummaryData";
	$multiname = $extractor->FieldAsValue($stuff);

	$loc = "MulMultiMediaRef:${i}->emultimedia->Multimedia";
	$loc = $extractor->FieldAsValue($loc);


	if(($type == "gif") || ($type == "jpg") || ($type == "jpeg") || ($type == "bmp")){

		print "Image: ";
		$extractor->PrintLinkedField($stuff, $imageDisplay);

	}
	else if(($type == "x-ms-wma") || ($type == "x-ms-wmv") || ($type == "x-ms-asf")){

		// must create a wvx file with appropriate link inside it 
		// then have the below link point to the newly created file

		// create 2 random numbers for the streaming file name 
		$r = rand(1, 10000);
		$r2 = rand(1, 10000);
		$spath = "/streaming/${r}${r2}.wvx";
		$streampath = "/usr/local/www/htdocs/streaming/${r}${r2}.wvx";


		$handle = fopen("$streampath", "w");

		$filecontents = "<ASX VERSION=\"3.0\">
<ENTRY>
<REF HREF=\"http://bondi.syd.kesoftware.com/artbankmedia/$loc\" />
</ENTRY>
</ASX>";

		fwrite($handle, "$filecontents");
		fclose($handle);

		print "Media Player Stream: <a href=\"$spath\">$multiname</a>";

	}
	else if(($type == "mpeg") || ($type == "mpg")){

		// the following is for pocket tv software

		// must create a m1u file with appropriate link inside it 
		// then have the below link point to the newly created file

		// create 2 random numbers for the streaming file name 
		$r = rand(1, 10000);
		$r2 = rand(1, 10000);
		$spath = "/streaming/${r}${r2}.m1u";
		$streampath = "/usr/local/www/htdocs/streaming/${r}${r2}.m1u";


		$handle = fopen("$streampath", "w");
		$filecontents = "http://bondi.syd.kesoftware.com/artbankmedia/$loc";
		fwrite($handle, "$filecontents");
		fclose($handle);

		print "Pocket TV Stream: <a href=\"$spath\">$multiname</a>";
	}

	print '<br>';
}


?>

&nbsp;
</font></td></tr>


</table>
<!-- End Main Display Table -->

<br>
</center>
<font face="helvetica, arial, sans-serif" size="2">
<div align="left"><a href="index.php">New Search</a></div>
</font>
</body>

</html>
