<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
	<title>Display...</title>
</head>

<body bgcolor="#FFFFFF">

<?php
require_once('../../../objects/common/RecordExtractor.php');
require_once('../../../objects/common/ImageDisplay.php');

$catextractor = new RecordExtractor();
$catextractor->Database = "ecatalogue";
$catextractor->IRN = $ALL_REQUEST['refirn'];
$catextractor->ExtractFields
(
        array
        (
                'IdeFiledAsQualifiedNameWeb'
        )
);


$extractor = new RecordExtractor();
$extractor->Database = "emultimedia";
$extractor->ExtractFields
(
	array
	(
		"MulTitle",
		"MulCreator_tab",
		"MulDescription",
		"MulMimeFormat",
		"DetPublisher",
		"DetRights",
		"DetDate0"
	)
);

$id = new ImageDisplay();
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
				if ($catextractor->HasData("IdeFiledAsQualifiedNameWeb"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Scientific Name:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $catextractor->PrintField("IdeFiledAsQualifiedNameWeb");?>
					</td>
				</tr>
				<?php
				}
				if ($extractor->HasData("MulCreator_tab"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Image Creator:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintMultivalueField("MulCreator_tab");?>
					</td>
				</tr>
				<?php
				}
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
