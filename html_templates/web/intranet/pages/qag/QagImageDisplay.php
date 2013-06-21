<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252"/>
	<link rel="stylesheet" type="text/css" href="Query.css">
	<title>QAG Search Results</title>
</head>

<body>

	<table id="HeaderTable">
		<tr>
    			<td id="HeaderCellLeft">
				<a href="http://www.qag.qld.gov.au"><img id="HeaderImage" src="images/qagLogo.gif"></img>
			</td>
			<td id="HeaderCellMiddle">
			</td>
			<td id="HeaderCellRight">
				<p>Collection<b>Search</b></p>
			</td>
		</tr>
	</table>

	<br>
<?php
require_once('../../../objects/common/RecordExtractor.php');
require_once('../../../objects/qag/ImageDisplay.php');

$extractor = new RecordExtractor();
$extractor->Intranet = 1;
$extractor->Database = "emultimedia";
$extractor->ExtractFields(array(
		"NotNotes",
		"MulTitle",
		"MulDescription",
		"MulMimeFormat",
		"DetPublisher",
		"DetRights",
		"MulIdentifier",
		"DetDate0"));

$id = new ImageDisplay();
$id->Intranet = 1;
$id->Notes = $extractor->FieldAsValue("NotNotes");

?>

<font face="Arial, Verdana, Tahoma" size="1">
<table id="MainTable" align="center" width="100">
	<tr>
		<td nowrap="nowrap" align="center">
			<?php $id->Show() 
		?>
	<tr>
	<td valign=top align=center><font size="1" color="#000000">
	<?php 
		$rights = $extractor->FieldAsValue("DetRights");
		if ($rights != "")
			print "&#xA9; " . $rights;
	?>
	</td>
	</tr>
	<tr>
		<td valign="top" align="center">
			<table width="90%" cellpadding="2">
				<tr>
				<?php
				$filenameid = $extractor->FieldAsValue("MulIdentifier");
				$filetitle = $extractor->FieldAsValue("MulTitle");
				?>
		<a href="mailto:imagerequest@qag.qld.gov.au?body=Please supply a publication-quality image of <?php print $filenameid; ?> %0A%0ARequired by: (date / time - please allow for a minimum 24-hour turnaround) %0A%0APurpose: (supply detail)%0A%0ACopyright cleared? Yes / No%0A%0A%0ARequests from external sources for reproductions must be referred to Publications for copyright clearance.%0A%0AImage will be supplied on CD and will not be in a suitable format for emailing. Please discuss with Photography if this does not meet your requirements.&subject=<?php print ($filenameid); ?>">Request for high-resolution image for publication</p><br><br></a> 
				</tr>
				<?php
				if ($extractor->HasData("MulTitle"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Title:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("MulTitle");?>
					</td>
				</tr>
				<?php
				}
				if ($extractor->HasData("MulMimeFormat"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Format:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("MulMimeFormat");?>
					</td>
				</tr>
				<?php
				}
				if ($extractor->HasData("DetRights"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Rights:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("DetRights");?>
					</td>
				</tr>
				<?php
				}
				if ($extractor->HasData("DetPublisher"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Publisher:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("DetPublisher");?>
					</td>
				</tr>
				<?php
				}
				if ($extractor->HasData("DetDate0"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Date:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("DetDate0");?>
						
					</td>
				</tr>
				<?php
				}
				if ($extractor->HasData("MulDescription"))
				{?>
				<tr>
					<td align="left" valign="top"  bgcolor="#DDDDDD">
							<b>Description:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("MulDescription");?>
					</td>
				</tr>
				<?php
				}?> 
			</table>
		</td>
	</tr>
</table>
</font>
</body>
</html>
