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
			require_once('./includes/display.php');
		?>
		<?php 
		if(preg_match("/oeuvre/i", $results[0]->ObjectType))		
		{ 
		?>
			<h1> Notice de l’œuvre </h1>
		<?php
		}
		else
		{
		?>
			<h1> 
				Notice du visuel 
			</h1>
		<?php
		}
		?>
		<table class="record">
			<tr>
				<td id= "imageheader" colspan= "2">
					<?php
					if(preg_match("/oeuvre/i", $results[0]->ObjectType))
					{
					?>
						<a href="search.php"> Nouvelle recherche </a>  | 
					<?php
					}
					else
					{
					?>
						<a href="searchp.php"> Nouvelle recherche </a>  | 
					<?php
					}
					?>
					<a href="javascript: history.go(-1)"> Retour aux résultats </a>
				</td>
			</tr>
			<tr>
				<td class= "title"  colspan= "2">
					<?php
					if(preg_match("/oeuvre/i", $results[0]->ObjectType))	
					{
					?>
						"<?php print htmlentities(utf8_decode($results[0]->TitMainTitle)); ?>" <?php print htmlentities(utf8_decode($results[0]->CreDateCreated)); ?>,  
					 	<?php	
						for($j=0; $j<count($results[0]->CreCreatorRef_tab); $j++)
						{
   							if(isset($results[0]->CreCreatorRef_tab[$j]->SummaryData))
   							{
        							print htmlentities($results[0]->CreCreatorRef_tab[$j]->SummaryData); 
   							}
						}
					}
					else
					{
					?>	
						<div id = "blank">
						</div>
					<?php
					}
					?>	
				</td>
			</tr>
			<tr class= "top">
				<td class= "bigimage">
					<a href="../../php5/media.php?irn=<?php print $results[0]->MulMultiMediaRef_tab[0]->irn_1;?>&amp;width=300"><img src="../../php5/media.php?irn=<?php print $results[0]->MulMultiMediaRef_tab[0]->irn_1; ?>&amp;width=300" alt="<?php print $results[0]->MulMultiMediaRef_tab[0]->SummaryData; ?>" /></a>		
				</td>
				<td class= "title2">
				<?php 
					if(preg_match("/oeuvre/i", $results[0]->ObjectType))
					{
						print htmlentities(utf8_decode($results[0]->TitMainTitle));  
					}
				?>
				</td>	
			</tr>
			<?php 
			if (!empty($results[0]->CreCreatorRef_tab[0]->SummaryData))
			{
			/*Increment row counter */
			$fieldrowcount++;
			?>
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?> <?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
					<th>
						Artiste
					</th>
					<td>
					<?php	
						for($j=0; $j<count($results[0]->CreCreatorRef_tab); $j++)
						{
   							if(isset($results[0]->CreCreatorRef_tab[$j]->SummaryData))
   							{
        							print htmlentities($results[0]->CreCreatorRef_tab[$j]->SummaryData); 
   							}
						}
					?>
					</td>
				</tr>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->CreDateCreated)) 
			{
				/*Increment row counter */
				$fieldrowcount++;
				?>
					<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?> <?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
						<th>
							Titre
						</th>
						<td>
							<?php print htmlentities(utf8_decode($results[0]->TitMainTitle)); ?>
						</td>
					</tr>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->CreDateCreated))
			{
			/*Increment row counter */
			$fieldrowcount++;
			?>
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?> <?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
					<th>
						Date
					</th>
					<td>
						<?php print htmlentities(utf8_decode($results[0]->CreDateCreated)); ?>
					</td>
				</tr>
			<?php
			}
			?>		
			<?php
			if (!empty($results[0]->TitSeriesTitle))
			{
				/*Increment row counter */
				$fieldrowcount++;
			?>
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?> <?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
					<th>
						Numero d'Edition
					</th>
					<td>
						<?php print htmlentities(utf8_decode($results[0]->TitSeriesTitle)); ?>
					</td>
				</tr>
			<?php	
			}
			?>
			<?php
			if(preg_match("/oeuvre/i", $results[0]->ObjectType))
			//if (!empty($results[0]->ObjectType))
			{
				/*Increment row counter */
				$fieldrowcount++;
				?>
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?> >
					<th>
						Domaine
					</th>
					<td>
						<?php print htmlentities(utf8_decode($results[0]->ObjectType)); ?>
					</td>
				</tr>
			<?php
			}
			?>
			<?php
			if (!empty ($results[0]->PhyDescription))
			{
				/*Increment row counter */
				$fieldrowcount++;
			?>				
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?> >
					<th>
						Descriptif
					</th>
					<td>
						<?php print htmlentities(utf8_decode($results[0]->PhyDescription)); ?>
					</td>
				</tr>
			<?php
			}
			?>
			<?php
			if ($DimensionGridLevels > 0)
			{
				/*Increment row counter */
				$fieldrowcount++;			
			?>	
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
					<th>
						Dimensions
					</th>
					<td>
						<table class= "dimensions">
							<tr>
								<?php
								if (!empty ($results[0]->PhyType_tab))
								{
								?>	
									<th class= "dimhead">
                                        		Type
                                   		</th>
                                   	<?php
                                   	}
								?>
								<?php
								if (!empty ($results[0]->PhyHeight_tab))
								{
								?>
                                   		<th class= "dimhead">
                                 				Hauteur
									</th>
								<?php
								}
								?>
								<?php
								if (!empty ($results[0]->PhyWidth_tab))
								{
								?>
									<th class= "dimhead">
										Largeur
									</th> 
								<?php
								}
								?>
								<?php
								if (!empty ($results[0]->PhyDepth_tab))
								{
								?>
									<th class= "dimhead">
										Profondeur
									</th>
								<?php
								}
								?>
								<?php
								if (!empty ($results[0]->PhyDiameter_tab))
								{
								?>
									<th class= "dimhead">
										Diamétre
									</th>
								<?php
								}
								?>
								<?php	
								if (!empty ($results[0]->PhyUnitLength_tab))
								{
								?>
									<th class= "dimhead">
										Unite Longueur
									</th>
								<?php
								}
								?>           		   			
						</tr>
						<?php	
						for ($j=0 ; $j<$DimensionGridLevels ; $j++)
                              {
						?>	
							<?php
							if (!empty ($results[0]->PhyType_tab))
							{
							?>
								<tr>
									<td class= "dimfield">
			   						<?php		
									if(isset($results[0]->PhyType_tab[$j]))
			   						{
			        						print htmlentities($results[0]->PhyType_tab[$j]); 
			   						}	
									?> 
									</td>
							<?php		
							}
							?>	
							<?php	
							if (!empty ($results[0]->PhyHeight_tab))
							{
							?>
								<td class= "dimfield">
									<?php	
   									if(isset($results[0]->PhyHeight_tab[$j]))
   									{
        									print htmlentities($results[0]->PhyHeight_tab[$j]); 
   									}
									?>
								</td>
							<?php		
							}
							?>
							<?php
						if (!empty ($results[0]->PhyWidth_tab))
						{		
						?>		
							<td class= "dimfield">
								<?php	
   								if(isset($results[0]->PhyWidth_tab[$j]))
   								{
        								print htmlentities($results[0]->PhyWidth_tab[$j]); 
   								}
								?>
							</td>
						<?php
						}
						?>
						<?php
						if (!empty ($results[0]->PhyDepth_tab))
						{
						?>
							<td class= "dimfield">
								<?php	
   								if(isset($results[0]->PhyDepth_tab[$j]))
   								{
        								print htmlentities($results[0]->PhyDepth_tab[$j]); 
   								}
								?>
							</td>
						<?php	
						}
						?>
						<?php
						if (!empty ($results[0]->PhyDiameter_tab))
						{
						?>
							<td class= "dimfield">
								<?php	
   								if(isset($results[0]->PhyDiameter_tab[$j]))
   								{
        								print htmlentities($results[0]->PhyDiameter_tab[$j]); 
   								}
								?>
							</td>
						<?php
						}
						?>
						<?php
						if (!empty ($results[0]->PhyUnitLength_tab))
						{
						?>		
							<td class= "dimfield">
							<?php	
   								if(isset($results[0]->PhyUnitLength_tab[$j]))
   								{
        								print htmlentities($results[0]->PhyUnitLength_tab[$j]); 
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
			</td>
		</tr>
	
		<?php
			}
		?>
	
		<?php	
		if (!empty ($results[0]->TitAccessionDate))
		{
		/*Increment row counter */
		$fieldrowcount++;	
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Année d'Acquisition
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->TitAccessionDate)); ?>
				</td>
			</tr>
		<?php
		}
		?>
		<?php	
		if (!empty ($results[0]->InflIdentifier))
		{
		/*Increment row counter */
		$fieldrowcount++;	
		
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Identifiant
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfIdentifier)); ?>
				</td>
			</tr>
		<?php
		}
		?>
		
		<?php	
		if (!empty ($results[0]->InflIdentifier))
		{
		/*Increment row counter */
		$fieldrowcount++;	
		
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Identifiant
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfIdentifier)); ?>
				</td>
			</tr>
		<?php
		}
		?>
		
		<?php	
		if (!empty ($results[0]->InfIdentifier))
		{
		/*Increment row counter */
		$fieldrowcount++;	
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Identifiant
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfIdentifier)); ?>
				</td>
			</tr>
			<?php
		}
			?>
			
			<?php	
		if (!empty ($results[0]->InfCaptionFrench))
		{
		/*Increment row counter */
		$fieldrowcount++;	
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Légende Français
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfCaptionFrench)); ?>
				</td>
			</tr>
			<?php
		}
			?>	
				
		<?php	
		if (!empty ($results[0]->InfCaptionFrench))
		{
		/*Increment row counter */
		$fieldrowcount++;
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Lègende Anglais
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfCaptionEnglish)); ?>
				</td>
			</tr>
		<?php
		}
		?>
		<?php	
		if (!empty ($results[0]->InfDescription))
		{
		/*Increment row counter */
		$fieldrowcount++;
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Description
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfDescription)); ?>
				</td>
			</tr>
		<?php
		}
		?>	
		<?php	
		if (!empty ($results[0]->InfDateCreated))
		{
		/*Increment row counter */
		$fieldrowcount++;
		?>
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Date de prise de vue
				</th>
				<td>
					<?php print htmlentities(utf8_decode($results[0]->InfDateCreated)); ?>
				</td>
			</tr>
		<?php
		}
		?>
		<?php	
		if (!empty ($results[0]->Inf300DpiHeight) && !empty ($results[0]->Inf300DpiLength))
		{
		/*Increment row counter */
		$fieldrowcount++;
		?>	
			<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
				<th>
					Dimensions de la photographie
				</th>
				<td>
					<table class="dimensions">
						<tr>		
						<?php	
						if (!empty ($results[0]->Inf300DpiHeight))
						{
						?>
							<th>
								Hauteur 
							</th>
						<?php
						}
						?>
						<?php	
						if (!empty ($results[0]->Inf300DpiLength))
						{
						?>
							<th>
								Largeur
							</th>
						<?php
						}
						?>
						</tr>
						<tr>
							
							<td>
								<?php print htmlentities(utf8_decode($results[0]->Inf300DpiHeight)); ?>
							</td>
							<td>
								<?php print htmlentities(utf8_decode($results[0]->Inf300DpiLength)); ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php
			}
			?>	
		
			<?php
			if ($PhotoDimensionGridLevels > 0)
			{
			/*Increment row counter */
			$fieldrowcount++;
			?>
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?>>
					<th>
						Historique des publications:
					</th>
					<td>
					<table class="dimensions">
						<tr>					
							<th>
								Titre catalogue
							</th>
							<th>
								Page
							</th>
						</tr>
						<?php
						for ($j=0 ; $j<$PhotoDimensionGridLevels ; $j++)
						{
						?>
							<tr class = "subsection">
								<td>
								<?php
								if(isset($results[0]->InfCatalogueTitle_tab[$j]))
								{
									print htmlentities(utf8_decode($results[0]->InfCatalogueTitle_tab[$j])); 
								} 
								?>
								</td>
								<td>
								<?php
								if(isset($results[0]->InfCataloguePages_tab[$j]))
								{
									print htmlentities(utf8_decode($results[0]->InfCataloguePages_tab[$j])); 
								}
								?>
								</td>
							</tr> 
						<?php
						}
						?>	
					</table>
					</td>
				</tr>
			<?php
			}
			?>
			<?php	
			if (count($results[0]->PhoRigPhotographerRef_tab) > 0)
			{
				/*Increment row counter */
				$fieldrowcount++;
				?>	
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
					<th>
						Crédit photographe
					</th>
					<td>
					<?php	
					for($j=0; $j<count($results[0]->PhoRigPhotographerRef_tab); $j++)
					{
		   				if(isset($results[0]->PhoRigPhotographerRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->PhoRigPhotographerRef_tab[$j]->SummaryData)); 
		   				}
		   			?>
		   				<br />
		   			<?php		
					}
					?>
					</td>
				</tr>	
			<?php
			}
			?>		
			<?php	
			if (count($results[0]->PhoRigArtistRef_tab) > 0)
			{
				/*Increment row counter */
				$fieldrowcount++;
				?>	
				<tr <?php if ($fieldrowcount % 2 == 0) {?> class="oddline" <?php } ?><?php if ($fieldrowcount % 2 == 1) {?> class= "normal" <?php }?>>
					<th>
						Crédit artiste
					</th>
					<td>
					<?php	
					for($j=0; $j<count($results[0]->PhoRigArtistRef_tab); $j++)
					{
	   					if(isset($results[0]->PhoRigArtistRef_tab[$j]->SummaryData))
	   					{
	        					print htmlentities(utf8_decode($results[0]->PhoRigArtistRef_tab[$j]->SummaryData)); 
	   					}
	   				?>
	   			<br />
	   			<?php		
					}
				?>
					</td>
				</tr>
			<?php
			}
			?>
			<tr class="searchfooter">
					<td colspan= "2">
						<a href="index.html"> Retour à l’accueil</a> | 
						<a href="javascript:window.print()"> Imprimer </a>	
					</td>		
				</tr>
				<tr>
					<td class= "footer" colspan= "2">
						<div class= "footerlogo">
							<img src="images/logo.jpg" alt="Fondation Cartier pour l'art contemporain" />
						</div>
					</td>
				</tr>	
				<?php if(preg_match("/phototh/i", $results[0]->ObjectType))
				{ 
				?>
					<tr>
						<td id= "photolink" colspan= "2">	
							<a href="mailto:adeline.pelletier@fondation.cartier.com"> Commander l’image en haute définition</a> 	
						</td>
					</tr>
					<tr>			
						<td id="photosummary" colspan= "2">
							Pour obtenir cette image en haute définition, veuillez contacter l’administrateur de la 
							photothèque qui vous transmettra les contacts des artistes et photographes du visuel demandé pour le règlement des droits.
						</td>
					</tr>		
				<?php
				}
				?>
		</table>
	</body>
</html>

