<?php
/*
** Copyright (c) KE Software Pty. Ltd. 2008
*/
?>

		<?php
			require_once('./includes/display.php');
			include('includes/header.inc');
		?>
		<table class= "resultstable">	
			<tr class= "displaynavbody">
					<td class= "displaynavbottom" colspan= "2">
						<a href="index.php"> New Search </a> |
						<a href="javascript: history.go(-1)">Back to Results</a> |
					</td>
				</tr>
			<tr>
				<td class= "imgdisplay" colspan= "2">
					<?php 
					if (isset($results[0]->MulMultiMediaRef_tab[0]->irn_1))
					{
					?>				
						<a href="../emuweb/php5/media.php?irn=<?php print $results[0]->MulMultiMediaRef_tab[0]->irn_1; ?>"><img src="../emuweb/php5/media.php?irn=<?php print $results[0]->MulMultiMediaRef_tab[0]->irn_1; ?>&amp;width=300"alt= "<?php print $results[0]->MulMultiMediaRef_tab[0]->SummaryData; ?>" />		
					<?php
					}
					?>
					<?php print htmlentities($results[0]->ColMainTitle);?>
					
				</td>	
			</tr>
		
			<?php
			if (!empty($results[0]->ColObjectStatus))
			{
				$fieldcolourrowcount++;
			?>
				<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th>Object Status</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ColObjectStatus);?></td>
			</tr>
			<?php
			}		
			?>				
			
			<?php
			if (!empty($results[0]->ColCollection))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Type of Collection</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ColCollection);?></td>
			</tr>
			<?php
			}		
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->ClaObjectName_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->ClaObjectName_tab); $j++)
				{
				?>
					
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Object Name</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->ClaObjectName_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->ClaLevel1Classification))
			{
				$fieldcolourrowcount++;	
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Subject Classification</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ClaLevel1Classification);?></td>
			</tr>
			<?php
			}		
			?>
		
			<?php
			if (!empty($results[0]->ColFullName))
			{
				$fieldcolourrowcount++;	
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Object Full Name</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ColFullName);?></td>
			</tr>
			<?php
			}		
			?>
			<?php
			if (!empty($results[0]->MapTitle))
			{
				$fieldcolourrowcount++;	
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Map Title</th>
				<td class= "borderright"><?php print htmlentities($results[0]->MapTitle);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if (!empty($results[0]->MapPublisherRef->SummaryData))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th>Publisher</th>
				<td class= "borderright"><?php print htmlentities($results[0]->MapPublisherRef->SummaryData);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if (!empty($results[0]->ColObjectNumber))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Object Number</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ColObjectNumber);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if (!empty($results[0]->GeoName))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Specimen Name</th>
				<td> class= "borderright"<?php print htmlentities($results[0]->GeoName);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if(isset($results[0]->TaxTaxonomyRef_tab[0]->ClaFamily))
			{
				$fieldcolourrowcount++;
				?>
				<?php	
				for($j=0; $j<count($results[0]->TaxTaxonomyRef_tab[0]->ClaFamily); $j++)
				{
				?>
					<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
						<th class= "borderleft">Family</th>
						<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->TaxTaxonomyRef_tab[0]->ClaFamily)); ?></td>
					</tr>
				<?php
				}
			}
			?>
			<?php
			if(isset($results[0]->TaxTaxonomyRef_tab[0]->ClaGenus))
			{
				$fieldcolourrowcount++;
				?>
				<?php	
				for($j=0; $j<count($results[0]->TaxTaxonomyRef_tab[0]->ClaGenus); $j++)
				{
				?>
					<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
						<th class= "borderleft">Genus</th>
						<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->TaxTaxonomyRef_tab[0]->ClaGenus)); ?></td>
					</tr>
				<?php
				}
			}
			?>
			<?php
			if(isset($results[0]->TaxTaxonomyRef_tab[0]->ClaOrder))
			{
				$fieldcolourrowcount++;
				?>
				<?php	
				for($j=0; $j<count($results[0]->TaxTaxonomyRef_tab[0]->ClaOrder); $j++)
				{
				?>
					<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
						<th class= "borderleft">Order</th>
						<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->TaxTaxonomyRef_tab[0]->ClaOrder)); ?></td>
					</tr>
				<?php
				}
			}
			?>
			<?php
			if(isset($results[0]->TaxTaxonomyRef_tab[0]->ClaSpecies))
			{
				$fieldcolourrowcount++;
				?>
				<?php	
				for($j=0; $j<count($results[0]->TaxTaxonomyRef_tab[0]->ClaSpecies); $j++)
				{
				?>
					<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
						<th class= "borderleft">Species</th>
						<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->TaxTaxonomyRef_tab[0]->ClaSpecies)); ?></td>
					</tr>
				<?php
				}
			}
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->ColOtherNumbersType_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			<?php	
				for($j=0; $j<count($results[0]->ColOtherNumbersType_tab); $j++)
				{
				?>
				<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				   	<th class= "borderleft">Other Number Type</th>
				   	<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->ColOtherNumbersType_tab[$j])); ?></td>
				</tr>
				<?php
				}
			}
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->ColOtherNumbers_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
				<?php	
				for($j=0; $j<count($results[0]->ColOtherNumbers_tab); $j++)
				{
				?>
				<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				   	<th class= "borderleft">Other Number</th>
				   	<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->ColOtherNumbers_tab[$j])); ?></td>
				</tr>
				<?php
				}
			}
			?>
			<?php	
			if (count($results[0]->BibBibliographyRef_tab) > 0)
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >	
				<th class= "borderleft">Bibliography</th>
				<td class= "borderright">
					<?php	
					for($j=0; $j<count($results[0]->BibBibliographyRef_tab); $j++)
					{
		   				if(isset($results[0]->BibBibliographyRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->BibBibliographyRef_tab[$j]->SummaryData)); 
		   				}
		   			?>
		   				
		   			<?php		
					}
					?>
				</td>
			</tr>
			<?php
			}
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->ProCulturalGroup_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->ProCulturalGroup_tab); $j++)
				{
				?>
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Cultural Group</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->ProCulturalGroup_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<?php	
			if (count($results[0]->ProMakerRef_tab) > 0)
			{
				$fieldcolourrowcount++;
			?>
				<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
					<th class= "borderleft">Manufacturer/Maker</th>
					<td class= "borderright">
						<?php	
						for($j=0; $j<count($results[0]->ProMakerRef_tab); $j++)
						{
			   				if(isset($results[0]->ProMakerRef_tab[$j]->SummaryData))
			   				{
			        				print htmlentities(utf8_decode($results[0]->ProMakerRef_tab[$j]->SummaryData)); 
			   				}
			   			?>	
			   			<?php		
						}
						?>
					</td>
				</tr>
			<?php
			}
			?>
			<?php	
			if (count($results[0]->ProProductionPlaceRef_tab) > 0)
			{
				$fieldcolourrowcount++;	
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >	
				<th class= "borderleft">Place of production</th>
				<td class= "borderright">
					<?php	
					for($j=0; $j<count($results[0]->ProProductionPlaceRef_tab); $j++)
					{
		   				if(isset($results[0]->ProProductionPlaceRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->ProProductionPlaceRef_tab[$j]->SummaryData)); 
		   				}
		   			?>	
		   			<?php		
					}
					?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->ProProductionDate))
			{
					$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >	
				<th class= "borderleft">Date of Production</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ProProductionDate);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if (!empty($results[0]->AcqCreditLine))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Credit Line</th>
				<td class= "borderright"><?php print htmlentities($results[0]->AcqCreditLine);?></td>
			</tr>
			<?php
			}		
			?> 
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->AssAssociationEvent_tab))
		   	{
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->AssAssociationEvent_tab); $j++)
				{
					$fieldcolourrowcount++;
				?>
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Associated Event</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->AssAssociationEvent_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<?php	
			if (count($results[0]->AssAssociationNameRef_tab) > 0)
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >	
				<th class= "borderleft">Associated Person/Organisation</th>
				<td class= "borderright">
					<?php	
					for($j=0; $j<count($results[0]->AssAssociationNameRef_tab); $j++)
					{
		   				if(isset($results[0]->AssAssociationNameRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->AssAssociationNameRef_tab[$j]->SummaryData)); 
		   				}
		   			?>	
		   			<?php		
					}
					?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->ColPhysicalDescription))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Description</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ColPhysicalDescription);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if (!empty($results[0]->NumObverseDescription))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Obverse Description</th>
				<td class= "borderright"><?php print htmlentities($results[0]->NumObverseDescription);?></td>
			</tr>
			<?php
			}		
			?> 
			<?php
			if (!empty($results[0]->NumReverseDescription))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Reverse Description</th>
				<td class= "borderright"><?php print htmlentities($results[0]->NumReverseDescription);?></td>
			</tr>
			<?php
			}		
			?>
			<?php
			if (!empty($results[0]->GeoChronostratigraphy))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Chronostratigraphy</th>
				<td class= "borderright"><?php print htmlentities($results[0]->GeoChronostratigraphy);?></td>
			</tr>
			<?php
			}		
			?>
			<?php
			if (!empty($results[0]->GeoLithostratigraphy))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Lithostratigraphy</th>
				<td class= "borderright"><?php print htmlentities($results[0]->GeoLithostratigraphy);?></td>
			</tr>
			<?php
			}		
			?>
			<?php	
			if (count($results[0]->SitSiteRef_tab) > 0)
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Locality</th>
				<td class= "borderright">
					<?php	
					for($j=0; $j<count($results[0]->SitSiteRef_tab); $j++)
					{
		   				if(isset($results[0]->SitSiteRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->SitSiteRef_tab[$j]->SummaryData)); 
		   				}
		   			?>	
		   			<?php		
					}
					?>
				</td>
			</tr>
			<?php
			}
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->SitSiteName_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->SitSiteName_tab); $j++)
				{
				?>
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Archaeological Site Name</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->SitSiteName_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->ColMainTitle))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Title</th>
				<td class= "borderright"><?php print htmlentities($results[0]->ColMainTitle);?></td>
			</tr>
			<?php
			}		
			?>
			<?php	
			if (count($results[0]->ColArtistNameRef_tab) > 0)
			{
			$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Artist</th>
				<td class= "borderright">
					<?php	
					for($j=0; $j<count($results[0]->ColArtistNameRef_tab); $j++)
					{
		   				if(isset($results[0]->ColArtistNameRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->ColArtistNameRef_tab[$j]->SummaryData)); 
		   				}
		   			?>	
		   			<?php		
					}
					?>
				</td>
			</tr>
			<?php
			}
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->AssAssociationPeriod_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->AssAssociationPeriod_tab); $j++)
				{
				?>
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Associated Period</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->AssAssociationPeriod_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<!-- Multivalued field therefore loop continues as far as the number of values stored in the field within EMu-->
			<?php
			if(isset($results[0]->AssAssociationDate_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->AssAssociationDate_tab); $j++)
				{
				?>
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Associated Date</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->AssAssociationDate_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<?php	
			if (count($results[0]->AssSiteRef_tab) > 0)
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >	
				<th class= "borderleft">Associated Place</th>
				<td class= "borderright">
					<?php	
					for($j=0; $j<count($results[0]->AssSiteRef_tab); $j++)
					{
		   				if(isset($results[0]->AssSiteRef_tab[$j]->SummaryData))
		   				{
		        				print htmlentities(utf8_decode($results[0]->AssSiteRef_tab[$j]->SummaryData)); 
		   				}
		   			?>	
		   			<?php		
					}
					?>
				</td>
			</tr>
			<?php
			}
			?>
			<?php
			if (!empty($results[0]->SitPreciseLocation))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Precise Location</th>
				<td class= "borderright"><?php print htmlentities($results[0]->SitPreciseLocation);?></td>
			</tr>
			<?php
			}		
			?>
		
			<?php
			if ($eveqry->Matches > 0)
			{
				$fieldcolourrowcount++;
			?>
				<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
					<th class= "borderleft">Collection Event</th>
					<td class= "borderright">
						<table>
						<?php	
						foreach($everesults as $everesult)
						{
						?>
							<tr>
								<td><?php print htmlentities(utf8_decode($everesult->SummaryData)); ?></td>
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
			if (!empty($results[0]->LocLevel1))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Location Level 1</th>
				<td class= "borderright"><?php print htmlentities($results[0]->LocLevel1);?></td>
			</tr>
			<?php
			}		
			?>
			<?php
			if (!empty($results[0]->LocLevel2))
			{
				$fieldcolourrowcount++;
			?>
			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
				<th class= "borderleft">Location Level 2</th>
				<td class= "borderright"><?php print htmlentities($results[0]->LocLevel2);?></td>
			</tr>
			<?php
			}		
			?>
			<!-- Makes the number iterations according to how many values are stored within the field in EMu! (Multi valued field-->
			<?php
			if(isset($results[0]->SitSiteCode_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->SitSiteCode_tab); $j++)
				{
				?>
			   			<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Site Code</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->SitSiteCode_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
			<?php
			if(isset($results[0]->SitProjectName_tab))
		   	{
		   		$fieldcolourrowcount++;
			?>
			   	<?php	
				for($j=0; $j<count($results[0]->SitProjectName_tab); $j++)
				{
				?>
			   		<tr <?php if ($fieldcolourrowcount % 2 == 0) {?> class="normal" <?php } ?><?php if ($fieldcolourrowcount % 2 == 1) {?> class= "oddline" <?php }?> >
			   			<th class= "borderleft">Project Name</th>
			   			<td class= "borderright"><?php print htmlentities(utf8_decode($results[0]->SitProjectName_tab[$j])); ?></td>
			        	</tr>
			   	<?php
				}
				?>
			<?php
			}
			?>
				<tr class= "displaynavbody">
					<td class= "displaynavbottom" colspan= "2">
						<a href="index.php"> New Search </a> |
						<a href="javascript: history.go(-1)">Back to Results</a> |
					</td>
				</tr>
				
				   					
		</table>	
<?php
include('includes/footer.inc');
?>		
