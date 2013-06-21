<?php
/*
** Copyright (c) KE Software Pty. Ltd. 2008
*/
?>

	<?php
	require_once('./includes/results.php');
	include('includes/header.inc');
	?>
		<?php
		if ($qry->Matches == 0)
		{
		?>
			<h1>Sorry, no results were found</h1>
		<?php
		}
		else
		{
		?>
			<table class= "resultstable">
				<tr>
					<td colspan= "3">
						<div class= "numres">	
							<a href="index.php?"> New Search </a>
						</div>
						<div class="navcontrols">
							<span class="stats">
								<?php print $qry->StartRec; ?> to <?php print $qry->EndRec; ?> of <?php print $qry->Matches; ?>
							</span>
							<?php
							if (!empty($PrevPageURL))
							{
							?>
								<a href="<?php print $PrevPageURL; ?>">&lt; Previous Page</a>
								<?php
							}
							if (!empty($NextPageURL))
							{
							?>
								<a href="<?php print $NextPageURL; ?>">Next Page &gt;</a>
							<?php
							}
							?>
						</div>
					</td>
				</tr>
				<tr class= "resultsheader">
					<th class= "imgheader">Image</th>
					<th>Object Number</th>
					<th class= "sumhead">Summary</th>
				</tr>
				<?php
				$count = 0;
				foreach ($results as $result)
				{
					$count++;
				?>

					<tr <?php if ($count % 2 == 0) {?> class="oddline" <?php } ?> > 
							<td class= "borderleft">
							<?php
								$alt = "";
								$imgirn = "";
								if (isset($result->MulMultiMediaRef_tab[0]->SummaryData))
								{
									$alt = urlencode($result->MulMultiMediaRef_tab[0]->SummaryData);
									$imgirn = $result->MulMultiMediaRef_tab[0]->irn_1;
								}
							?>
							
								<a href="display.php?irn=<?php print $result->irn_1; ?>"><img src="emuweb/php5/media.php?irn=<?php print $imgirn; ?>&amp;thumb=yes" alt="<?php print $alt; ?>" /></a>
							</td>
							<td>
								<a href="display.php?irn=<?php print $result->irn_1; ?>"><?php print htmlentities(utf8_decode($result->ColObjectNumber)); ?></a>
							</td>
							<td class= "borderright">
								<a href="display.php?irn=<?php print $result->irn_1; ?>"><?php print htmlentities(utf8_decode($result->SummaryData)); ?></a>
							</td>	
					</tr>
				<?php
				}
				?>
				<tr>
					<td class= "navfooter" colspan= "3">
						<div class= "numres">	
							<a href="index.php?">New Search</a>
						</div>
						<div class="navcontrols">
							<span class="stats">
								<?php print $qry->StartRec; ?> to <?php print $qry->EndRec; ?> of <?php print $qry->Matches; ?>
							</span>
							<?php
							if (!empty($PrevPageURL))
							{
							?>
								<a href="<?php print $PrevPageURL; ?>">&lt; Previous Page</a>
								<?php
							}
							if (!empty($NextPageURL))
							{
							?>
								<a href="<?php print $NextPageURL; ?>">Next Page &gt;</a>
							<?php
							}
							?>
						</div>
					</td>
				</tr>
			</table>
		<?php
		}
		?>

<?php
include('includes/footer.inc');
?>		