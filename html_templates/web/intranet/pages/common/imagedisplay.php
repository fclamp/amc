<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<title>Display...</title>
</head>

<body bgcolor="#FFFFFF">

<?php
require_once('../../../objects/common/RecordExtractor.php');
require_once('../../../objects/common/ImageDisplay.php');

$extractor = new RecordExtractor();
$extractor->Database = "emultimedia";
$extractor->Intranet = 1;
$extractor->ExtractFields(array(
		"MulTitle",
		"MulDescription",
		"MulMimeFormat",
		"DetPublisher",
		"DetRights",
		"DetDate0"));

$id = new ImageDisplay();
$id->Intranet = 1;
?>

<font face="Arial, Verdana, Tahoma" size="1">
<table align="center" width="100">
	<tr>
		<td nowrap="nowrap" align="center">
			<?php $id->Show() ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="center">
			<table width="90%" cellpadding="2">
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
