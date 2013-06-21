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
$catextractor->Database = 'ecatalogue';
$catextractor->IRN = $ALL_REQUEST['refirn'];
$catextractor->ExtractFields
(
	array
	(
		'IdeFiledAsFamily',
		'IdeFiledAsQualifiedNameWeb'
	)
);


$extractor = new RecordExtractor();
$extractor->Database = 'emultimedia';
$extractor->ExtractFields
(
	array
	(
		'MulTitle',
		'MulDescription',
		'MulMimeFormat',
		'DetDate0',
		'DetPublisher',
		'DetRights',
		'DetSource'
	)
);

$id = new ImageDisplay();
$id->_Image->KeepAspectRatio = 0;
?>

<font face="Arial, Verdana, Tahoma" size="1">
<table align="center" width="100">
	<tr>
		<td nowrap="nowrap" align="center">
			<?php 
				$id->Show();
				if (isset($ALL_REQUEST['refirn']))
				{
                			print "<table width=\"100%\" border=\"0\">\n<tr>\n<td align=\"left\">\n";
					if ($id->Intranet)
						print '[ <a href="' . $GLOBALS['INTRANET_DEFAULT_DISPLAY_PAGE'] . '?irn=' . $ALL_REQUEST['refirn'] . '">Specimen Record</a> ]' . "\n";
					else
						print '[ <a href="' . $GLOBALS['DEFAULT_DISPLAY_PAGE'] . '?irn=' . $ALL_REQUEST['refirn'] . '">Specimen Record</a> ]' . "\n";
                			print "\n</td>\n</tr>\n</table>\n";
				}
 			?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="center">
			<table width="90%" cellpadding="2">
				<?php
				if ($catextractor->HasData("IdeFiledAsFamily"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Family:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $catextractor->PrintField("IdeFiledAsFamily");?>
					</td>
				</tr>
				<?php
				}
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
				if ($extractor->HasData("MulMimeFormat"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Master Format:</b>
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
				if ($extractor->HasData("DetDate0") && ! ctype_space($extractor->FieldAsValue("DetDate0")))
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
				if ($extractor->HasData("DetSource"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Source:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $extractor->PrintField("DetSource");?>
						
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
