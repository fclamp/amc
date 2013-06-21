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
$extractor->Database = 'ecatalogue';
$extractor->IRN = $ALL_REQUEST['refirn'];
$extractor->ExtractFields
(
	array
	(
		'BibBibliographyRef_tab->ebibliography->SummaryData',
		'BioLiveSpecimen',
		'CatOtherNumbersValue_tab',
		'IdeFiledAsClass',
		'IdeFiledAsFamily',
		'IdeFiledAsOrder',
		'IdeFiledAsQualifiedNameWeb',
		'IdeOtherQualifiedNameWeb_tab',
		'NotNmnhText0',
		'NotNmnhType_tab',
		'ZooPreparation_tab',
		'ZooPreparationSize_tab',
		'ZooPreparedByRef_tab->eparties->SummaryData'
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
 			?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="center">
			<table width="90%" cellpadding="2">
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Archive ID:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php $extractor->PrintField("CatOtherNumbersValue:1"); ?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Class:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php $extractor->PrintField("IdeFiledAsClass");?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Order:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php $extractor->PrintField("IdeFiledAsOrder");?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Family:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php $extractor->PrintField("IdeFiledAsFamily");?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Scientific Names:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php $extractor->PrintField("IdeFiledAsQualifiedNameWeb");?>
						<br />
						<?php $extractor->PrintMultivalueField("IdeOtherQualifiedNameWeb_tab");?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Illustrator:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php 
							$illustrators = $extractor->MultivalueFieldAsArray("ZooPreparedByRef_tab->eparties->SummaryData");
							$illustrators = implode("; ", $illustrators);
							$extractor->printData($illustrators);
						?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Medium:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php 
							$medium = $extractor->MultivalueFieldAsArray("ZooPreparation_tab");
							$medium = implode("; ", $medium);
							$extractor->printData($medium);
						?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Original Dimensions:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php 
							$extractor->PrintMultivalueField("ZooPreparationSize_tab");
						?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Publication:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php 
							$extractor->PrintMultivalueField("BibBibliographyRef_tab->ebibliography->SummaryData");
						?>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Description:</b>
					</td>
					<td bgcolor="#EEEEEE">
						<?php $extractor->PrintField("BioLiveSpecimen");?>
					</td>
				</tr>
				<?php 
					$notes = $extractor->MultivalueFieldAsArray("NotNmnhText0");
					$types = $extractor->MultivalueFieldAsArray("NotNmnhType_tab");
					for ($i = 0; $i < count($types); $i++)
					{
						if (preg_match('/^Subject$/i', $types[$i]) || 
						    preg_match('/^Common Name$/i', $types[$i]) ||
						    preg_match('/^Condition$/i', $types[$i]))
						{
						?>
							<tr>
								<td align="left" valign="top" bgcolor="#DDDDDD">
									<b><?php $extractor->printData($types[$i] . ': ' )?></b>
								</td>
								<td bgcolor="#EEEEEE">
									<?php $extractor->printData($notes[$i])?>
								</td>
							</tr>
						<?php
						}
					}
				?>
			</table>
		</td>
	</tr>
</table>
</font>
</body>
</html>
