<?php
require_once('includes/MatchLimit.php');
require_once('includes/Results.php');
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
<div align="left">
	<a href="<?php print $_REQUEST['QueryPage']; ?>">New Search</a>
</div>

<?php
$cnt = count($Results);
if ($qry->Status == 'failed')
{
?>
<?php
	print "<h4>$qry->Error</h4>";
	print "<p>Search was:<br>$qry->Where";
}
elseif ($cnt == 0)
{
?>
	<h4>No matching records. Please adjust your query</h4>
<?php
	print "<p>Search was:<br>$qry->Where";
}
else
{
	$last = $StartRec + $_REQUEST['LimitPerPage'] - 1;
	if ($MatchLimit - $last < $_REQUEST['LimitPerPage'])
		$nextUrl = "";
	$more = "";
	if ($qry->Matches < $EndRec)
		$EndRec = $qry->Matches;
	elseif ($EndRec == $last && $qry->Matches > $EndRec)
		$more = "+";
	$msg = "";
	if ($more != "" && $nextUrl == "")
		$msg = " (maximum $last records returned per query)";
?>
	<h4>Displaying <?php print $StartRec; ?> to <?php print "$EndRec$more"; print $msg ?></h4>
<?php
	if (! empty($prevUrl))
	{
?>
		<span align="left"><a href="<?php print $prevUrl; ?>">Previous Page</a></span>
<?php
	}
?>
<?php
	if (! empty($nextUrl))
	{
?>
		<span align="right"><a href="<?php print $nextUrl; ?>">Next Page</a></span>
<?php
	}

	for ($i = 0; $i < $cnt && $i < $_REQUEST['LimitPerPage']; $i++)
	{
?>
		<div><?php print $StartRec + $i; ?>. <a href="Display.php?irn=<?php print $Results[$i]->{"irn_1"}; ?>&amp;recno=<?php print $StartRec + $i; ?> "><?php print $Results[$i]->{"SummaryData"}; ?></a></div>
<?php
	}
?>

<?php
	if ($cnt > 1)
	{
?>
		<br />
		<div>
		<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
		<?php
		foreach ($_REQUEST as $key => $val)
		{
			if ($val == "")
				continue;
			$val = stripslashes($val);
			$val = preg_replace('/&/', '&amp;', $val);
			$val = preg_replace('/</', '&lt;', $val);
			$val = preg_replace('/>/', '&gt;', $val);
			$val = preg_replace("/'/", '&apos;', $val);
			$val = preg_replace('/"/', '&quot;', $val);
		?>
			<input type="hidden" name="<?php print $key;?>" value="<?php print $val;?>" />
		<?php
		}
	?>
		Sort records by:
		<p>
		<select name="Order1">
			<option value="" selected="selected"></option>
			<option value="irn.irn_1">IRN</option>
			<option value="DocId">DocID</option>
			<option value="InventoryNo">InventoryNo</option>
			<option value="PageCount">PageCount</option>
			<option value="MimeType">MimeType</option>
			<option value="ImageVersion">ImageVersion</option>
			<option value="DataVersion">DataVersion</option>
			<option value="AUNumber">AUNumber</option>
			<option value="AUType">AUType</option>
			<option value="NewDoc">NewDoc</option>
			<option value="ContainerName">ContainerName</option>
			<option value="FilingNo">FilingNo</option>
			<option value="PageNo">PageNo</option>
			<option value="SequenceNo">SequenceNo</option>
			<option value="DocCategory">DocCategory</option>
			<option value="Nationality">Nationality</option>
			<option value="DateFrom">DateFrom</option>
			<option value="RefCC">RefCC</option>
			<option value="LocInfo">LocInfo</option>
			<option value="LocDetails">LocDetails</option>
			<option value="LocDetailsType">LocDetailsType</option>
			<option value="ListType">ListType</option>
			<option value="LastName">LastName</option>
			<option value="FirstName">FirstName</option>
			<option value="MaidenName">MaidenName</option>
			<option value="DateOfBirth">DateOfBirth</option>
			<option value="Number">Number</option>
		</select>
		<input type="radio" name="Order1AscDesc" checked="true" value="ascending">ascending</input>
		<input type="radio" name="Order1AscDesc" value="descending">descending</input>, then by:
		<br>
		<select name="Order2">
			<option value="" selected="selected"></option>
			<option value="irn.irn_1">IRN</option>
			<option value="DocId">DocID</option>
			<option value="InventoryNo">InventoryNo</option>
			<option value="PageCount">PageCount</option>
			<option value="MimeType">MimeType</option>
			<option value="ImageVersion">ImageVersion</option>
			<option value="DataVersion">DataVersion</option>
			<option value="AUNumber">AUNumber</option>
			<option value="AUType">AUType</option>
			<option value="NewDoc">NewDoc</option>
			<option value="ContainerName">ContainerName</option>
			<option value="FilingNo">FilingNo</option>
			<option value="PageNo">PageNo</option>
			<option value="SequenceNo">SequenceNo</option>
			<option value="DocCategory">DocCategory</option>
			<option value="Nationality">Nationality</option>
			<option value="DateFrom">DateFrom</option>
			<option value="RefCC">RefCC</option>
			<option value="LocInfo">LocInfo</option>
			<option value="LocDetails">LocDetails</option>
			<option value="LocDetailsType">LocDetailsType</option>
			<option value="ListType">ListType</option>
			<option value="LastName">LastName</option>
			<option value="FirstName">FirstName</option>
			<option value="MaidenName">MaidenName</option>
			<option value="DateOfBirth">DateOfBirth</option>
			<option value="Number">Number</option>
		</select>
		<input type="radio" name="Order2AscDesc" checked="true" value="ascending">ascending</input>
		<input type="radio" name="Order2AscDesc" value="descending">descending</input>, then by:
		<br>
		<select name="Order3">
			<option value="" selected="selected"></option>
			<option value="irn.irn_1">IRN</option>
			<option value="DocId">DocID</option>
			<option value="InventoryNo">InventoryNo</option>
			<option value="PageCount">PageCount</option>
			<option value="MimeType">MimeType</option>
			<option value="ImageVersion">ImageVersion</option>
			<option value="DataVersion">DataVersion</option>
			<option value="AUNumber">AUNumber</option>
			<option value="AUType">AUType</option>
			<option value="NewDoc">NewDoc</option>
			<option value="ContainerName">ContainerName</option>
			<option value="FilingNo">FilingNo</option>
			<option value="PageNo">PageNo</option>
			<option value="SequenceNo">SequenceNo</option>
			<option value="DocCategory">DocCategory</option>
			<option value="Nationality">Nationality</option>
			<option value="DateFrom">DateFrom</option>
			<option value="RefCC">RefCC</option>
			<option value="LocInfo">LocInfo</option>
			<option value="LocDetails">LocDetails</option>
			<option value="LocDetailsType">LocDetailsType</option>
			<option value="ListType">ListType</option>
			<option value="LastName">LastName</option>
			<option value="FirstName">FirstName</option>
			<option value="MaidenName">MaidenName</option>
			<option value="DateOfBirth">DateOfBirth</option>
			<option value="Number">Number</option>
		</select>
		<input type="radio" name="Order3AscDesc" checked="true" value="ascending">ascending</input>
		<input type="radio" name="Order3AscDesc" value="descending">descending</input>
		<p>
		<input type="submit" value="Sort" />
		</form>
		</div>
<?php
	}
}
?>
</body>
</html>
