<?php
include('./includes/header.inc');
require_once('./includes/advquery.php');
?>
<h4>Advanced search</h4>
<form method="get" action="results.php">
<div class="queryline oddline">
	<div class="queryprompt">Object Name:</div>		<div class="queryfield"><input type="text" name="ObjectName" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">Brief Description:</div>	<div class="queryfield"><input type="text" name="BriefDescription" /></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Description:</div>		<div class="queryfield"><input type="text" name="Description" /></div>
</div>
<div class="queryline">
	<div class="queryprompt"></div>		<div class="queryfield"></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Primary Inscription:</div>	<div class="queryfield"><input type="text" name="PrimaryInscription" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">Other Inscription:</div>	<div class="queryfield"><input type="text" name="OtherInscription" /></div>
</div>
<div class="queryline">
	<div class="queryprompt"></div>		<div class="queryfield"></div>
</div>
<?php
$dates = GetLookup("Period Values");
?>
<div class="queryline oddline">
	<div class="queryprompt">Period Date:</div>
	<div class="queryfield">
		<select name="PeriodDate">
			<option></option>
<?php
foreach ($dates as $date)
{
?>
			<option><?php print htmlentities($date); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<div class="queryline">
	<div class="queryprompt">Date Created:</div>		<div class="queryfield"><input type="text" name="DateCreated" /></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">&nbsp;- Earliest:</div>		<div class="queryfield"><input type="text" name="EarliestDate" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">&nbsp;- Latest:</div>		<div class="queryfield"><input type="text" name="LatestDate" /></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Place of Creation:</div>	<div class="queryfield"><input type="text" name="PlaceOfCreation" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">Creators Name:</div>	<div class="queryfield"><input type="text" name="CreatorsName" /></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Creators Role:</div>	<div class="queryfield"><input type="text" name="CreatorsRole" /></div>
</div>
<?php
$place3 = GetLookup("Creation Place", 2);
?>
<div class="queryline">
	<div class="queryprompt">Creation Place - County:</div>
	<div class="queryfield">
		<select name="CreationPlace3">
			<option></option>
<?php
foreach ($place3 as $place)
{
?>
			<option><?php print htmlentities($place); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<?php
$place4 = GetLookup("Creation Place", 3);
?>
<div class="queryline oddline">
	<div class="queryprompt">Creation Place - Town:</div>
	<div class="queryfield">
		<select name="CreationPlace4">
			<option></option>
<?php
foreach ($place4 as $place)
{
?>
			<option><?php print htmlentities($place); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<?php
$place5 = GetLookup("Creation Place", 4);
?>
<div class="queryline">
	<div class="queryprompt">Creation Place - Place:</div>
	<div class="queryfield">
		<select name="CreationPlace5">
			<option></option>
<?php
foreach ($place5 as $place)
{
?>
			<option><?php print htmlentities($place); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<?php
$materials = GetLookup("Material");
?>
<div class="queryline oddline">
	<div class="queryprompt">Material:</div>
	<div class="queryfield">
		<select name="Material">
			<option><option>
<?php
foreach ($materials as $material)
{
?>
			<option><?php print htmlentities($material); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<?php
$techniques = GetLookup("Technique");
?>
<div class="queryline">
	<div class="queryprompt">Technique:</div>
	<div class="queryfield">
		<select name="Technique">
			<option><option>
<?php
foreach ($techniques as $technique)
{
?>
			<option><?php print htmlentities($technique); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<div class="queryline">
	<div class="queryprompt"></div>		<div class="queryfield"></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Accession Number:</div>	<div class="queryfield"><input type="text" name="AccessionNo" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">SHIC:</div>			
	<div class="queryfield">
		<select name="SHIC">
<option></option>

<option>Community Life</option>
<option>Community Life - General</option>
<option>Community Life - Cultural tradition</option>
<option>Community Life - Organisations</option>
<option>Community Life - Regulation and control</option>
<option>Community Life - Welfare and wellbeing</option>
<option>Community Life - Education</option>
<option>Community Life - Amenities, entertainment and sport</option>
<option>Community Life - Communications and currency</option>
<option>Community Life - Warfare and defence</option>
<option>Community Life - Other</option>
<option>Domestic and Family Life</option>
<option>Domestic and Family Life - General</option>
<option>Domestic and Family Life - Domestic and family administration and records</option>
<option>Domestic and Family Life - House structure and infrastructure</option>
<option>Domestic and Family Life - Heating, lighting, water and sanitation</option>
<option>Domestic and Family Life - Furnishings and fittings</option>
<option>Domestic and Family Life - Household management</option>
<option>Domestic and Family Life - Food, drink and tobacco</option>
<option>Domestic and Family Life - Family wellbeing</option>
<option>Domestic and Family Life - Hobbies, crafts and pastimes</option>
<option>Domestic and Family Life - Other</option>
<option>Personal Life</option>
<option>Personal Life - General</option>
<option>Personal Life - Administration and records</option>
<option>Personal Life - Relics, mementoes and memorials</option>
<option>Personal Life - Costume</option>
<option>Personal Life - Accessories not elsewhere specified</option>
<option>Personal Life - Toilet</option>
<option>Personal Life - Food, drink and tobacco</option>
<option>Personal Life - Personal wellbeing</option>
<option>Personal Life - Other</option>
<option>Working Life</option>
<option>Working Life - General and unprovenanced</option>
<option>Working Life - Agriculture, forestry and fishing</option>
<option>Working Life - Energy and water supply industries</option>
<option>Working Life - Minerals and chemical </option>
<option>Working Life - Extraction of metallic ores; manufacture of metals and metal goods, engineering industries</option>
<option>Working Life - Manufacturing industries not elsewhere specified</option>
<option>Working Life - Construction</option>
<option>Working Life - Transport and communications</option>
<option>Working Life - Distribution, hotels and catering, repairs</option>
<option>Working Life - Other working life</option>
		</select>
	</div>
</div>
<?php
$groups = GetLookup("Collection Group");
?>
<div class="queryline oddline">
	<div class="queryprompt">Collection Group:</div>
	<div class="queryfield">
		<select name="CollectionGroup">
			<option></option>
<?php
foreach ($groups as $group)
{
?>
			<option><?php print htmlentities($group); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<?php
$subgroups = GetLookup("Collection Sub Group");
?>
<div class="queryline">
	<div class="queryprompt">Collection Sub-Group:</div>
	<div class="queryfield">
		<select name="CollectionSubGroup">
			<option></option>
<?php
foreach ($subgroups as $subgroup)
{
?>
			<option><?php print htmlentities($subgroup); ?></option>
<?php
}
?>
		</select>
	</div>
</div>
<div class="queryline">
	<div class="queryprompt"></div>		<div class="queryfield"></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Current Location:</div>	<div class="queryfield"><input type="text" name="CurrentLocation" /></div>
</div>
<div class="queryline">
	<div class="queryprompt"></div>		<div class="queryfield"></div>
</div>

	<input type="submit" value="Search" />
	<input type="reset" value="Reset" />
</form>
<?php
include('./includes/footer.inc');
?>

