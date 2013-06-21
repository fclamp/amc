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
		'CatBarcode',
		'CulCultureRef_tab->eparties->CulCulture2',
		'CulCultureRef_tab->eparties->CulCulture3',
		'CulCultureRef_tab->eparties->CulCulture4',
		'CulCultureRef_tab->eparties->CulCulture5',
		'CulCurrent_tab',
		'IdeCurrentObjectName',
	)
);

$extractor = new RecordExtractor();
$extractor->Database = "emultimedia";
$extractor->ExtractFields
(
	array
	(
		'MulDescription',
		'MulCreator_tab',
	)
);

$id = new ImageDisplay();
?>

<font face="Arial, Verdana, Tahoma" size="1">
<table align="center" width="100">
	<tr>
		<td nowrap="nowrap" align="left">
			<form><input type="button" value="Back" onClick="history.go(-1);return true;"> </form>
		</td>
	</tr>
	<tr>
		<td nowrap="nowrap" align="center">
			<?php $id->Show() ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="center">
			<table width="90%" cellpadding="2">
				</tr>
				<?php
				$creators = $extractor->MultivalueFieldAsArray("MulCreator_tab");
				$displayText = 0;	
				foreach ($creators as $creator)
				{
					if (strtolower($creator) == "ethnology" ||
					    strtolower($creator) == "archaeology")
					{
						$displayText = 1;
						break;
					}
				}
				if ($displayText)
				{?>
					<tr>
						<td align="left" valign="top" colspan="2" bgcolor="#DDDDDD">
							This is a scanned image of a catalog card. The card is being preserved unaltered as a historical document. It reflects the terminology and scholarship of the time when the object was cataloged, and therefore some information may be outdated. Please see our <a href="http://nhb-acsmith1.si.edu/anthroDBintro.html">introduction page</a> for more information about data sources and quality.
						</td>
					</tr>
				<?php
				}
				?> 
				<tr>
					<td align="left" valign="top" colspan="2" bgcolor="#DDDDDD">
						Tip: If you choose to save this image, rename the file with the artifact catalog number. This number is required if more information about the object is requested later.
					</td>
				</tr>
				<?php
				if ($catextractor->HasData("CatBarcode"))
				{?>
				<tr>
					<td align="left" valign="top" bgcolor="#DDDDDD">
							<b>Catalog Number:</b>
					</td>
					<td bgcolor="#EEEEEE">
							<?php $catextractor->PrintField("CatBarcode");?>
						
					</td>
				</tr>
				<?php
				}
				$currentCultureArray = $catextractor->MultivalueFieldAsArray("CulCurrent_tab");
                		$culture2Array = $catextractor->MultivalueFieldAsArray("CulCultureRef_tab->eparties->CulCulture2");
               			$culture3Array = $catextractor->MultivalueFieldAsArray("CulCultureRef_tab->eparties->CulCulture3");
                		$culture4Array = $catextractor->MultivalueFieldAsArray("CulCultureRef_tab->eparties->CulCulture4");
                		$culture5Array = $catextractor->MultivalueFieldAsArray("CulCultureRef_tab->eparties->CulCulture5");

				$cultureArray = array();
                		for ($i = 0;$i < count($culture2Array); $i++)
                		{
                			$cultureDisplay = "";
                        		if (strtolower($currentCultureArray[$i]) == "yes")
                        		{
                                		if (! empty($culture2Array[$i]))
						{
							$cultureDisplay .= $culture2Array[$i];
						}
                                		if (! empty($culture3Array[$i]))
                                		{
                                        		$cultureDisplay .= " : " . $culture3Array[$i];
                                		}
                                		if (! empty($culture4Array[$i]))
                                		{
                                        		$cultureDisplay .= " : " . $culture4Array[$i];
                                		}
                                		if (! empty($culture5Array[$i]))
                                		{
                                		        $cultureDisplay .= " : " . $culture5Array[$i];
                                		}
					}		
					$cultureDisplay = trim($cultureDisplay);
					if (! empty($cultureDisplay))
					{
						array_push($cultureArray, $cultureDisplay);
					}
				}
				if (count($cultureArray))
				{
				?>
							<tr>
								<td align="left" valign="top" bgcolor="#DDDDDD">
									<b>Culture:</b>
								</td>
								<td bgcolor="#EEEEEE">
									<?php 
										foreach ($cultureArray as $culture)
										{
											print $culture;
									?>
												<br>
									<?php
										}
									?>
						
								</td>
							</tr>
				<?php
				}
				if ($catextractor->HasData("IdeCurrentObjectName"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Object Name:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $catextractor->PrintField("IdeCurrentObjectName");?>
						</td>
					</tr>
				<?php
				}
				if ($extractor->HasData("MulDescription"))
				{?>
					<tr>
						<td align="left" valign="top"  bgcolor="#DDDDDD">
								<b>Image Description:</b>
						</td>
						<td bgcolor="#EEEEEE">
								<?php $extractor->PrintField("MulDescription");?>
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
