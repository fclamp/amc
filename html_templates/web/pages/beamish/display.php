<?php
require_once('./includes/display.php');
include('./includes/header.inc');
?>

<h4><?php print htmlentities(utf8_decode($results[0]->SummaryData)); ?></h4>

<table class="record">
	<tr class="oddline">
		<th>
			Object Name
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->TitObjectName)); ?>
		</td>
	</tr>
	<tr>
		<th>
			Brief Description
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreBriefDescription)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Physical Description
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->PhyDescription)); ?>
		</td>
	</tr>
	<tr>
		<th>
			&nbsp;
		</th>
		<td>
		</td>
	</tr>
	<tr>
		<th>
			Primary Inscriptions
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CrePrimaryInscriptions)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Other Inscriptions
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreOtherInscriptions)); ?>
		</td>
	</tr>
	<tr>
		<th>
			&nbsp;
		</th>
		<td>
		</td>
	</tr>
	<tr>
		<th>
			Period Date
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CrePeriodDate)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Date Created
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreDateCreated)); ?>
		</td>
	</tr>
	<tr>
		<th>
			Earliest Date Created
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreEarliestDate)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Latest Date Created
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreLatestDate)); ?>
		</td>
	</tr>
	<tr>
		<th>
			Creators Name
		</th>
		<td>
<?php
			if (isset($results[0]->CreCreatorRef_tab[0]->SummaryData))
			{
				foreach ($results[0]->CreCreatorRef_tab as $value)
				{
					print htmlentities(utf8_decode($value->SummaryData));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Creators Role
		</th>
		<td>
<?php
			if (isset($results[0]->CreRole_tab))
			{
				foreach ($results[0]->CreRole_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Creation Notes
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreCreationNotes)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Place of Creation 1
		</th>
		<td>
<?php
			if (isset($results[0]->CreCreationPlace1_tab))
			{
				foreach ($results[0]->CreCreationPlace1_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Place of Creation 2
		</th>
		<td>
<?php
			if (isset($results[0]->CreCreationPlace2_tab))
			{
				foreach ($results[0]->CreCreationPlace2_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Place of Creation 3
		</th>
		<td>
<?php
			if (isset($results[0]->CreCreationPlace3_tab))
			{
				foreach ($results[0]->CreCreationPlace3_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Place of Creation 4
		</th>
		<td>
<?php
			if (isset($results[0]->CreCreationPlace4_tab))
			{
				foreach ($results[0]->CreCreationPlace4_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Place of Creation 5
		</th>
		<td>
<?php
			if (isset($results[0]->CreCreationPlace5_tab))
			{
				foreach ($results[0]->CreCreationPlace5_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Materials
		</th>
		<td>
<?php
			if (isset($results[0]->PhyMaterial_tab))
			{
				foreach ($results[0]->PhyMaterial_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Technique
		</th>
		<td>
<?php
			if (isset($results[0]->PhyTechnique_tab))
			{
				foreach ($results[0]->PhyTechnique_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			&nbsp;
		</th>
		<td>
		</td>
	</tr>
	<tr>
		<th>
			Accession No
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->TitAccessionNo)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Object Status
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->TitObjectStatus)); ?>
		</td>
	</tr>
	<tr>
		<th>
			Condition Status
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->ConConditionStatus)); ?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			SHIC
		</th>
		<td>
<?php
			if (isset($results[0]->PhyShicClassification_tab))
			{
				foreach ($results[0]->PhyShicClassification_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Collection Group
		</th>
		<td>
<?php

			if (isset($results[0]->TitCollectionGroup_tab))
			{
				foreach ($results[0]->TitCollectionGroup_tab as $colgrp)
				{
					print htmlentities(utf8_decode($colgrp));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Collection Sub-group
		</th>
		<td>
<?php
			if (isset($results[0]->TitCollectionSubGroup_tab))
			{
				foreach ($results[0]->TitCollectionSubGroup_tab as $subgrp)
				{
					print htmlentities(utf8_decode($subgrp));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			&nbsp;
		</th>
		<td>
		</td>
	</tr>

	<tr>
		<th>
			Aquisition Lot
		</th>
		<td>
<?php
			if (isset($results[0]->AccAccessionLotRef->SummaryData))
			{
				print htmlentities(utf8_decode($results[0]->AccAccessionLotRef->SummaryData));
			}
?>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Current Location
		</th>
		<td>
<?php
			if (isset($results[0]->LocCurrentLocationRef->SummaryData))
			{
				print htmlentities(utf8_decode($results[0]->LocCurrentLocationRef->SummaryData));
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Provenance
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->CreProvenance)); ?>
		</td>
	</tr>
	<tr>
		<th>
			&nbsp;
		</th>
		<td>
		</td>
	</tr>
	<tr class="oddline">
		<th>
			Medium
		</th>
		<td>
<?php
			if (isset($results[0]->PhyMedium_tab))
			{
				foreach ($results[0]->PhyMedium_tab as $value)
				{
					print htmlentities(utf8_decode($value));
?>
					<br />
<?php
				}
			}
?>
		</td>
	</tr>
	<tr>
		<th>
			Support
		</th>
		<td>
			<?php print htmlentities(utf8_decode($results[0]->PhySupport)); ?>
		</td>
	</tr>
	<tr>
		<th>
			Multimedia
		</th>
		<td>
<?php
			if (isset($results[0]->MulMultiMediaRef_tab))
			{
				foreach ($results[0]->MulMultiMediaRef_tab as $media)
				{
					if (isset($media->SummaryData))
					{
	?>
						<a href="emuweb/php5/media.php?irn=<?php print $media->irn_1; ?>"><img src="emuweb/php5/media.php?thumb=yes&irn=<?php print $media->irn_1; ?>" alt="<?php print $media->SummaryData; ?>" /></a>
	<?php
					}
				}
			}
?>
		</td>
	</tr>

</table>
<?php
include('./includes/footer.inc');
?>
