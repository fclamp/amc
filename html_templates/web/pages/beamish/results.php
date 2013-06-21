<?php
require_once('./includes/results.php');
include('./includes/header.inc');
?>
<h4>Search results...</h4>
<?php
if ($qry->Matches == 0)
{
?>
	<h5>Sorry - no results matched your query, please try different terms</h5>
<?php
}
else
{
?>
	<div class="resultsnav">
		<div class="numresults">
			<?php print $qry->StartRec; ?> to <?php print $qry->EndRec; ?> of <?php print $qry->Matches; ?> results
		</div>
		<div class="navcontrols">
	<?php
		if (!empty($PrevPageURL))
		{
	?>
			<a href="<?php print $PrevPageURL; ?>">&lt; Previous</a>
	<?php
		}
		if (!empty($NextPageURL))
		{
	?>
			<a href="<?php print $NextPageURL; ?>">Next &gt;</a>
	<?php
		}
	?>
		</div>
	</div>

	<?php
	$count = 0;
	foreach ($results as $result)
	{
		$count++;
	?>
		<div class="resultline<?php if ($count % 2 == 1) {?> oddline<?php }; ?>">
<?php
		$alt = "";
		if (isset($result->MulMultiMediaRef_tab[0]->SummaryData))
			$alt = urlencode($result->MulMultiMediaRef_tab[0]->SummaryData);
?>
			<a href="display.php?irn=<?php print $result->irn_1; ?>"><img src="emuweb/php5/media.php?irn=<?php print $result->MulMultiMediaRef_tab[0]->irn_1; ?>&amp;thumb=yes" alt="<?php print $alt; ?>" /></a>
			<a href="display.php?irn=<?php print $result->irn_1; ?>"><?php print htmlentities(utf8_decode($result->SummaryData)); ?></a>
		</div>
	<?php
	}
}
?>
<?php
include('./includes/footer.inc');
?>
