<?php
require_once('includes/Display.php');
?>
<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="ushmmits.css">
<Title>ITS Test</Title>
</head>
<body>
<?php
if ($_REQUEST['seq'] != "yes")
{
?>
	<p><a href="Query.php">New Search</a></p>

<?php
}
?>
<?php
if ($_REQUEST['seq'] != "yes")
{
?>
	<?php
	if (is_numeric($PrevIRN))
	{
	?>
		<span style="align: left; width: 50%; text-align: left"><a href="<?php print $_SERVER['PHP_SELF']; ?>?irn=<?php print $PrevIRN;?>&amp;recno=<?php print $Recno - 1; ?>">Previous Record in Results</a></span>
	<?php
	}
	elseif (isset($PrevPage) && $PrevPage != "")
	{
	?>
		<span style="align: left; width: 50%; text-align: left;"><a href="<?php print $PrevPage; ?>">Previous Page of Results</a></span>
	<?php
	}
	?>

	<?php
	if (is_numeric($NextIRN))
	{
	?>
		<span style="align: right; width: 50%; text-align: right;"><a href="<?php print $_SERVER['PHP_SELF']; ?>?irn=<?php print $NextIRN; ?>&amp;recno=<?php print $Recno + 1; ?>">Next Record in Results</a></span>
	<?php
	}
	elseif (isset($NextPage) && $NextPage != "")
	{
	?>
		<span style="align: right; width: 50%; text-align: right;"><a href="<?php print $NextPage; ?>">Next Page of Results</a></span>
	<?php
	}
	?>
	</p>

<?php
}
?>
<p>
<?php
/*
 * Next/previous in sequence (irn +/- 1)
 */
if (isset($PrevIRNUrl))
{
?>
	<span style="align: left; width: 50%; text-align: left;"><a <?php if($_REQUEST['seq'] != "yes"){ ?>target="_blank"<?php } ?> href="<?php print $PrevIRNUrl; ?>">Previous Record in Sequence</a></span>
<?php
}
if (isset($NextIRNUrl))
{
?>
	<span style="align: right; width: 50%; text-align: right;"><a <?php if($_REQUEST['seq'] != "yes"){ ?>target="_blank"<?php } ?> href="<?php print $NextIRNUrl; ?>">Next Record in Sequence</a></span>
<?php
}
?>

<?php
if ($_REQUEST['seq'] != "yes")
	print "<p>Record No. $Recno";
?>
</p>

<table align="left" border="0" cellpadding="0" width="100%">
<?php
$row = 0;
foreach ($qry->Select as $field)
{
	$row++;
?>
	<tr>
		<th width="15%" align="left" valign="top">
<?php
		if ($field == 'irn_1')
			print htmlentities('IRN');
		elseif ($field == "MulMultiMediaRef_tab")
			print htmlentities('Image IRNs');
		else
			print htmlentities($field);
?>
		</th>
		<td align="left" valign="top">
<?php
		if ($field != "MulMultiMediaRef_tab")
		{
			print htmlentities($Record->{$field});
?>
			</td>
<?php
		}
		else
		{
			for ($i = 0; $i < count($MediaIrns); $i++)
			{
				if ($i > 0)
					print ' ';
				print htmlentities($MediaIrns[$i]);
			}
?>
			</td>
			</tr>
			<tr>
			<th width="15%" align="left" valign="top">
<?php
			if (count($MediaIrns) > 0)
			{
				print "Image ";
				print $MediaStart + 1;
				print " of ";
				print count($MediaIrns);
			}
?>
			</th>
			<td align="left" valign="top">
<?php
			if (isset($MediaPrev) || isset($MediaNext))
			{
				if (isset($MediaPrev))
				{
?>
					<a href="<?php print $_SERVER['PHP_SELF']; ?>?irn=<?php print $IRN; ?><?php if($_REQUEST['seq'] == "yes"){ ?>&amp;seq=yes<?php } ?>&amp;media=<?php print $MediaPrev; ?>&amp;recno=<?php print $Recno; ?>">Previous Image</a>
<?php
				}
				if (isset($MediaNext))
				{
?>
					<a href="<?php print $_SERVER['PHP_SELF']; ?>?irn=<?php print $IRN; ?><?php if($_REQUEST['seq'] == "yes"){ ?>&amp;seq=yes<?php } ?>&amp;media=<?php print $MediaNext; ?>&amp;recno=<?php print $Recno; ?>">Next Image</a>
<?php
				}
?>
				<br>
<?php
			}
?>
<?php
			for ($i = $MediaStart; $i < $MediaStart + 1 && isset($MediaIrns[$i]); $i++)
			{
				$media = new MediaImage;
				$media->IRN = $MediaIrns[$i];
				$media->Width = 500;
				$media->Height = 500;
				$media->ShowBorder = 0;
				$media->Show();
			}
?>
			</td>
<?php
		}
?>
	</tr>
<?php
}
?>
</table>
<br />

</body>
</html>
