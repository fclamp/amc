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
		'CatPrefix',
		'CatNumber',
		'CatSuffix',
		'IdeFiledAsQualifiedNameWeb',
		'IdeFiledAsClass',
	)
);

$extractor = new RecordExtractor();
$extractor->Database = "emultimedia";
$extractor->ExtractFields
(
	array
	(
		'MulTitle',
                'MulDescription',
                'MulMimeFormat',
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
				$prefix = $catextractor->FieldAsValue('CatPrefix');
				$number = $catextractor->FieldAsValue('CatNumber');
				$suffix = $catextractor->FieldAsValue('CatSuffix');
				$catNumber = '';

				if (! empty($prefix))
					$catNumber .= $prefix;

				if (! empty($number))
				{
					if (! empty($catNumber))
						$catNumber .= ' ';
					$catNumber .= $number;
				}

				if (! empty($suffix))
				{
					if (! empty($catNumber))
						$catNumber .= '.';
					$catNumber .= $suffix;
				}
				?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Catalog Number:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $catextractor->PrintData($catNumber);?>
						
					</td>
				</tr>
				<?php
				if ($catextractor->HasData("IdeFiledAsQualifiedNameWeb"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Qualified Name:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $catextractor->PrintField("IdeFiledAsQualifiedNameWeb");?>
						</td>
					</tr>
				<?php
				}
				if ($catextractor->HasData("IdeFiledAsClass"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Class:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $catextractor->PrintField("IdeFiledAsClass");?>
						</td>
					</tr>
				<?php
				}
				if ($catextractor->HasData("MulTitle"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Title:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $catextractor->PrintField("MulTitle");?>
						</td>
					</tr>
				<?php
				}
				if ($catextractor->HasData("MulDescription"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Description:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $catextractor->PrintField("MulDescription");?>
						</td>
					</tr>
				<?php
				}
				if ($extractor->HasData("MulMimeFormat"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Format:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $extractor->PrintField("MulMimeFormat");?>
						</td>
					</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
</table>
</font>
</body>
</html>
