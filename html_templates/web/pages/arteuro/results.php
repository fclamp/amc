<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
  		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  		<link type="text/css" rel="stylesheet" href="css/style.css" />
  		<title> La collection et la phototh�que de la Fondation Cartier </title>
  	</head>
	<body>
	<?php
	require_once('./includes/results.php');
	?>
		<?php
		if ($qry->Matches == 0)
		{
		?>
			<h1>D�sol� - aucun r�sultat ne correspond � votre requ�te, s'il vous pla�t essayer diff�rents termes de recherche.</h1>
		<?php
		}
		else
		{
		?>
			<h1>R�sultats de la recherche</h1>
			<table class= "searchtable">
				<tr>
					<td class= "searchheader" colspan= "4">		
						<div class="newback">
							<a href="search.php">Nouvelle recherche</a> | 
							<a href="index.html">Retour � l�accueil</a>	
						</div>
						<div class="navcontrols">
							<span class="numresults">
								<?php print $qry->StartRec; ?> � <?php print $qry->EndRec; ?> / <?php print $qry->Matches; ?>
							</span>
							<?php
							if (!empty($PrevPageURL))
							{
							?>
								<a href="<?php print $PrevPageURL; ?>">&lt; Page pr�c�dente</a>
							<?php
							}
							if (!empty($NextPageURL))
							{
							?>
								<a href="<?php print $NextPageURL; ?>">Page suivante &gt;</a>
							<?php
							}
							?>
						</div>
					</td>
				</tr>	
				<tr class="header">
					<th class="leftvig">Image</th>
					<th>Artiste</th>
					<th>Titre</th>
					<th>Date</th>
				</tr>
				<?php
				$count = 0;
				foreach ($results as $result)
				{
					$count++;
				?>
				<tr <?php if ($count % 2 == 0) {?> class="oddline" <?php } ?> > 
				<?php
				$alt = "";
				$imgirn = "";
				if (isset($result->MulMultiMediaRef_tab[0]->SummaryData))
				{
					$alt = urlencode($result->MulMultiMediaRef_tab[0]->SummaryData);
					$imgirn = $result->MulMultiMediaRef_tab[0]->irn_1;
				}
				?>
					<td class="oddnoborder">
						<a href="display.php?irn=<?php print $result->irn_1; ?>"><img src="../../php5/media.php?irn=<?php print $imgirn; ?>&amp;thumb=yes" alt="<?php print $alt; ?>" /></a>
					</td>
					<td>
					<?php
					if (isset($result->CreCreatorRef_tab[0]->SummaryData))
					{	
						print htmlentities(utf8_decode($result->CreCreatorRef_tab[0]->SummaryData));
					}
					?>
					</td>
					<td>
						<a href="display.php?irn=<?php print $result->irn_1; ?>"><?php print htmlentities(utf8_decode($result->TitMainTitle)); ?></a>			
					</td>
				
					<td class="rightborder">
						<?php print htmlentities(utf8_decode($result->CreDateCreated)); ?>
					</td>
				</tr>
				<?php
				}
				?>
					<tr class="searchfooter">
						<td colspan="4">
							<div class="newback">
								<a href="search.php">Nouvelle recherche</a> | 
								<a href="index.html">Retour � l�accueil</a>	
							</div>
							<div class="navcontrols">
								<span class="numresults">
									<?php print $qry->StartRec; ?> � <?php print $qry->EndRec; ?> / <?php print $qry->Matches; ?>
								</span>
								<?php
								if (!empty($PrevPageURL))
								{
								?>
									<a href="<?php print $PrevPageURL; ?>">&lt; Page pr�c�dente</a>
								<?php
								}
								if (!empty($NextPageURL))
								{
								?>
									<a href="<?php print $NextPageURL; ?>">Page suivante &gt;</a>
								<?php
								}
								?>
							</div>
						</td>		
					</tr>
					<tr>
						<td class= "footer" colspan= "4">
							<div class= "footerlogo">
								<img src="images/logo.jpg" alt="Fondation Cartier pour l'art contemporain" />
							</div>
						</td>
					</tr>
				</table>
			<?php
			}
			?>
	</body>
</html>
