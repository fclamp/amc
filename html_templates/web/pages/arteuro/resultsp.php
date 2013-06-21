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
  		<title> La collection et la photothèque de la Fondation Cartier </title>
  	</head>
	<body>
	<?php
	require_once('./includes/results.php');
	?>
		<?php
		if ($qry->Matches == 0)
		{
		?>
			<h1>Désolé - aucun résultat ne correspond à votre requête, s'il vous plaît essayer différents termes de recherche.</h1>
		<?php
		}
		else
		{
		?>
			<h1>Résultats de la Recherche</h1>
			<table class= "searchtable">
				<tr>
					<td class= "searchheader" colspan= "3">		
						<div class="newback">
							<a href="searchp.php">Nouvelle recherche</a> | 
							<a href="index.html">Retour à l’accueil</a>	
						</div>
						<div class="navcontrols">
							<span class="numresults">
							<?php print $qry->StartRec; ?> à <?php print $qry->EndRec; ?> / <?php print $qry->Matches; ?>
							</span>
							<?php
							if (!empty($PrevPageURL))		
							{
							?>
								<a href="<?php print $PrevPageURL; ?>">&lt; Page précédente</a>
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
					<th class= "leftvig">Vignette Image</th>
					<th>Légende Français</th>
					<th>Identifiant</th>
				</tr>
				<?php
				$count = 0;
				foreach ($results as $result)
				{
					$count++;
				?>
					<tr <?php if ($count % 2 == 0) {?> class="oddline" <?php } ?>> 
						<?php
						$alt = "";
						$imgirn = "";
						if (isset($result->MulMultiMediaRef_tab[0]->SummaryData))
							{
								$alt = urlencode($result->MulMultiMediaRef_tab[0]->SummaryData);
								$imgirn = $result->MulMultiMediaRef_tab[0]->irn_1;
							}
						?>
						<td class= "oddnoborder">
							<a href="display.php?irn=<?php print $result->irn_1; ?>"><img src="../../php5/media.php?irn=<?php print $imgirn; ?>&amp;thumb=yes" alt="<?php print $alt; ?>" /></a>
						</td>
						<td>
						 	<?php print htmlentities(utf8_decode($result->InfCaptionFrench)); ?>
						</td>
						<td class="rightborder">
							<?php print htmlentities(utf8_decode($result->InfIdentifier)); ?>
						</td>
					</tr>
				<?php
				}
				?>
					<tr class="searchfooter">
						<td colspan= "3">
							<div class="newback">
								<a href="searchp.php">Nouvelle recherche</a> | 
								<a href="index.html">Retour à l’accueil</a>	
							</div>
							<div class="navcontrols">
								<span class="numresults">
									<?php print $qry->StartRec; ?> à <?php print $qry->EndRec; ?> / <?php print $qry->Matches; ?>
								</span>
						<?php
						if (!empty($PrevPageURL))
						{
						?>
							<a href="<?php print $PrevPageURL; ?>">&lt; Page précédente</a>
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
						<td class= "footer" colspan= "3">
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
