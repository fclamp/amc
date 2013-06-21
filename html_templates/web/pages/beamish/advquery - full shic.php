<?php
include('./includes/header.inc');
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
<div class="queryline oddline">
	<div class="queryprompt">Period Date:</div>		<div class="queryfield"><input type="text" name="PeriodDate" /></div>
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
<div class="queryline">
	<div class="queryprompt">Creation Place - County:</div>	<div class="queryfield"><input type="text" name="CreationPlace3" /></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Creation Place - Town:</div>	<div class="queryfield"><input type="text" name="CreationPlace4" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">Creation Place - Place:</div>	<div class="queryfield"><input type="text" name="CreationPlace5" /></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Material:</div>		<div class="queryfield"><input type="text" name="Material" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">Technique:</div>		<div class="queryfield"><input type="text" name="Technique" /></div>
</div>
<div class="queryline">
	<div class="queryprompt"></div>		<div class="queryfield"></div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Accession Number:</div>	<div class="queryfield"><input type="text" name="AccessionNo" /></div>
</div>
<!--div class="queryline">
	<div class="queryprompt">SHIC:</div>			<div class="queryfield"><input type="text" name="SHIC" /></div>
</div-->
<div class="queryline">
	<div class="queryprompt">SHIC:</div>			
	<div class="queryfield">
		<select name="SHIC"  style="width:95%;">
<option></option>

<option  <?php if($_REQUEST['SHIC'] == "Community Life"){?> selected="selected" <?php };?>>Community Life</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Cultural tradition"){?> selected="selected" <?php };?>>&nbsp;Cultural tradition</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Custom and belief"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Custom and belief</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Religion (Christian)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Religion (Christian)</option>
<option  <?php if($_REQUEST['SHIC'] == "Religion (non-Christian)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Religion (non-Christian)</option>
<option  <?php if($_REQUEST['SHIC'] == "Religious Activity (Christian or non-Christian)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Religious Activity (Christian or non-Christian)</option>
<option  <?php if($_REQUEST['SHIC'] == "Non-theistic belief "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Non-theistic belief </option>
<option  <?php if($_REQUEST['SHIC'] == "Occultism"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Occultism</option>
<option  <?php if($_REQUEST['SHIC'] == "Social customs"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Social customs</option>
<option  <?php if($_REQUEST['SHIC'] == "Calendar customs"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Calendar customs</option>
<option  <?php if($_REQUEST['SHIC'] == "Domestic customs and beliefs"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Domestic customs and beliefs</option>
<option  <?php if($_REQUEST['SHIC'] == "Rites of passage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Rites of passage</option>
<option  <?php if($_REQUEST['SHIC'] == "Occupational"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Occupational</option>
<option  <?php if($_REQUEST['SHIC'] == "Animal and animal husbandry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Animal and animal husbandry</option>
<option  <?php if($_REQUEST['SHIC'] == "Plant and crop husbandry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Plant and crop husbandry</option>
<option  <?php if($_REQUEST['SHIC'] == "Times and numbers "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Times and numbers </option>
<option  <?php if($_REQUEST['SHIC'] == "Colours"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Colours</option>
<option  <?php if($_REQUEST['SHIC'] == "Cosmic phenomena and weather lore"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cosmic phenomena and weather lore</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Language and dialect"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Language and dialect</option>
<option  <?php if($_REQUEST['SHIC'] == "General "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General </option>
<option  <?php if($_REQUEST['SHIC'] == "Linguistic elements"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Linguistic elements</option>
<option  <?php if($_REQUEST['SHIC'] == "Silent forms"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Silent forms</option>
<option  <?php if($_REQUEST['SHIC'] == "Social exchanges"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Social exchanges</option>
<option  <?php if($_REQUEST['SHIC'] == "Verbal play"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Verbal play</option>
<option  <?php if($_REQUEST['SHIC'] == "Verbal social controls"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Verbal social controls</option>
<option  <?php if($_REQUEST['SHIC'] == "Folk narrative"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Folk narrative</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Folktales"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Folktales</option>
<option  <?php if($_REQUEST['SHIC'] == "Legends"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Legends</option>
<option  <?php if($_REQUEST['SHIC'] == "Myths"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Myths</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Folk dance, drama and music"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Folk dance, drama and music</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Dance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dance</option>
<option  <?php if($_REQUEST['SHIC'] == "Drama"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Drama</option>
<option  <?php if($_REQUEST['SHIC'] == "Music"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Music</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Games"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Games</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Competition"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Competition</option>
<option  <?php if($_REQUEST['SHIC'] == "Chance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Chance</option>
<option  <?php if($_REQUEST['SHIC'] == "Simulation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Simulation</option>
<option  <?php if($_REQUEST['SHIC'] == "Vertigo – swings and slides"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Vertigo – swings and slides</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Attitudes"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Attitudes</option>
<option  <?php if($_REQUEST['SHIC'] == "Identity and race"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Identity and race</option>
<option  <?php if($_REQUEST['SHIC'] == "Lifestyles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Lifestyles</option>
<option  <?php if($_REQUEST['SHIC'] == "Gender and age"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Gender and age</option>
<option  <?php if($_REQUEST['SHIC'] == "Occupation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Occupation</option>
<option  <?php if($_REQUEST['SHIC'] == "Sexuality"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sexuality</option>
<option  <?php if($_REQUEST['SHIC'] == "Social behaviour"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Social behaviour</option>
<option  <?php if($_REQUEST['SHIC'] == "Personal Attributes"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Personal Attributes</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Other Cultural Traditions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other Cultural Traditions</option>
<option  <?php if($_REQUEST['SHIC'] == "Organisations"){?> selected="selected" <?php };?>>&nbsp;Organisations</option>
<option  <?php if($_REQUEST['SHIC'] == "Environment and amenity"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Environment and amenity</option>
<option  <?php if($_REQUEST['SHIC'] == "Global and national environment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Global and national environment</option>
<option  <?php if($_REQUEST['SHIC'] == "Natural environment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Natural environment</option>
<option  <?php if($_REQUEST['SHIC'] == "Built environment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Built environment</option>
<option  <?php if($_REQUEST['SHIC'] == "Food, drink and tobacco"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food, drink and tobacco</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Humane and conscience"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Humane and conscience</option>
<option  <?php if($_REQUEST['SHIC'] == "Human rights"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Human rights</option>
<option  <?php if($_REQUEST['SHIC'] == "Gender"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Gender</option>
<option  <?php if($_REQUEST['SHIC'] == "Race"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Race</option>
<option  <?php if($_REQUEST['SHIC'] == "Animal welfare"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Animal welfare</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Political"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Political</option>
<option  <?php if($_REQUEST['SHIC'] == "Conservative party and predecessors"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Conservative party and predecessors</option>
<option  <?php if($_REQUEST['SHIC'] == "Labour party and predecessors"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Labour party and predecessors</option>
<option  <?php if($_REQUEST['SHIC'] == "Liberal democrats and predecessors"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Liberal democrats and predecessors</option>
<option  <?php if($_REQUEST['SHIC'] == "Right-wing political parties"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Right-wing political parties</option>
<option  <?php if($_REQUEST['SHIC'] == "Nationalist political parties"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Nationalist political parties</option>
<option  <?php if($_REQUEST['SHIC'] == "Other political parties"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other political parties</option>
<option  <?php if($_REQUEST['SHIC'] == "Ethnic and nationalist"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Ethnic and nationalist</option>
<option  <?php if($_REQUEST['SHIC'] == "Friendly and cooperative societies"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Friendly and cooperative societies</option>
<option  <?php if($_REQUEST['SHIC'] == "Social and community"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Social and community</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Children’s and youth organisations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Children’s and youth organisations</option>
<option  <?php if($_REQUEST['SHIC'] == "Women’s"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Women’s</option>
<option  <?php if($_REQUEST['SHIC'] == "Men’s"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Men’s</option>
<option  <?php if($_REQUEST['SHIC'] == "Sexual"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sexual</option>
<option  <?php if($_REQUEST['SHIC'] == "Elderly people"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Elderly people</option>
<option  <?php if($_REQUEST['SHIC'] == "People with disabilities"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;People with disabilities</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Learned"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Learned</option>
<option  <?php if($_REQUEST['SHIC'] == "Arts"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Arts</option>
<option  <?php if($_REQUEST['SHIC'] == "Historical"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Historical</option>
<option  <?php if($_REQUEST['SHIC'] == "Natural history"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Natural history</option>
<option  <?php if($_REQUEST['SHIC'] == "Other scientific and technical"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other scientific and technical</option>
<option  <?php if($_REQUEST['SHIC'] == "Collecting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Collecting</option>
<option  <?php if($_REQUEST['SHIC'] == "Model making"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Model making</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Other organisations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other organisations</option>
<option  <?php if($_REQUEST['SHIC'] == "Regulation and control"){?> selected="selected" <?php };?>>&nbsp;Regulation and control</option>
<option  <?php if($_REQUEST['SHIC'] == "National government"){?> selected="selected" <?php };?>>&nbsp;&nbsp;National government</option>
<option  <?php if($_REQUEST['SHIC'] == "Monarchy"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Monarchy</option>
<option  <?php if($_REQUEST['SHIC'] == "Parliament"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Parliament</option>
<option  <?php if($_REQUEST['SHIC'] == "General "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General </option>
<option  <?php if($_REQUEST['SHIC'] == "Administration and finance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Administration and finance</option>
<option  <?php if($_REQUEST['SHIC'] == "Buildings and equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Buildings and equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Process of government"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Process of government</option>
<option  <?php if($_REQUEST['SHIC'] == "Government products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Government products</option>
<option  <?php if($_REQUEST['SHIC'] == "Other operations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other operations</option>
<option  <?php if($_REQUEST['SHIC'] == "People"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;People</option>
<option  <?php if($_REQUEST['SHIC'] == "Events"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Events</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Regional government"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Regional government</option>
<option  <?php if($_REQUEST['SHIC'] == "County"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;County</option>
<option  <?php if($_REQUEST['SHIC'] == "Hundred and wapentake"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hundred and wapentake</option>
<option  <?php if($_REQUEST['SHIC'] == "Other regional government"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other regional government</option>
<option  <?php if($_REQUEST['SHIC'] == "Local government"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Local government</option>
<option  <?php if($_REQUEST['SHIC'] == "District"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;District</option>
<option  <?php if($_REQUEST['SHIC'] == "City, borough and county borough"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;City, borough and county borough</option>
<option  <?php if($_REQUEST['SHIC'] == "Urban district council and rural district council"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Urban district council and rural district council</option>
<option  <?php if($_REQUEST['SHIC'] == "Poor law union"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Poor law union</option>
<option  <?php if($_REQUEST['SHIC'] == "Parish"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Parish</option>
<option  <?php if($_REQUEST['SHIC'] == "Manor"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Manor</option>
<option  <?php if($_REQUEST['SHIC'] == "Other local government"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other local government</option>
<option  <?php if($_REQUEST['SHIC'] == "Law enforcement"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Law enforcement</option>
<option  <?php if($_REQUEST['SHIC'] == "Justice"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Justice</option>
<option  <?php if($_REQUEST['SHIC'] == "Police"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Police</option>
<option  <?php if($_REQUEST['SHIC'] == "Punishment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Punishment</option>
<option  <?php if($_REQUEST['SHIC'] == "Law breaking"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Law breaking</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Consumer protection and licensing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Consumer protection and licensing</option>
<option  <?php if($_REQUEST['SHIC'] == "Trading standards"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Trading standards</option>
<option  <?php if($_REQUEST['SHIC'] == "Licensing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Licensing</option>
<option  <?php if($_REQUEST['SHIC'] == "Emergency services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Emergency services</option>
<option  <?php if($_REQUEST['SHIC'] == "Ambulance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ambulance</option>
<option  <?php if($_REQUEST['SHIC'] == "Fire"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Fire</option>
<option  <?php if($_REQUEST['SHIC'] == "Cave and mountain rescue"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cave and mountain rescue</option>
<option  <?php if($_REQUEST['SHIC'] == "Costal"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Costal</option>
<option  <?php if($_REQUEST['SHIC'] == "Boundary control"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Boundary control</option>
<option  <?php if($_REQUEST['SHIC'] == "Immigration and emigration"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Immigration and emigration</option>
<option  <?php if($_REQUEST['SHIC'] == "Imports and exports"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Imports and exports</option>
<option  <?php if($_REQUEST['SHIC'] == "Other regulation and control"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other regulation and control</option>
<option  <?php if($_REQUEST['SHIC'] == "Welfare and wellbeing"){?> selected="selected" <?php };?>>&nbsp;Welfare and wellbeing</option>
<option  <?php if($_REQUEST['SHIC'] == "Health"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Health</option>
<option  <?php if($_REQUEST['SHIC'] == "Specialist practices"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Specialist practices</option>
<option  <?php if($_REQUEST['SHIC'] == "Hospitals, nursing homes, etc"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hospitals, nursing homes, etc</option>
<option  <?php if($_REQUEST['SHIC'] == "Mental health institutions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mental health institutions</option>
<option  <?php if($_REQUEST['SHIC'] == "Homeopathic and alternative medicine practices"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Homeopathic and alternative medicine practices</option>
<option  <?php if($_REQUEST['SHIC'] == "Health pressure groups "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Health pressure groups </option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Welfare"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Welfare</option>
<option  <?php if($_REQUEST['SHIC'] == "Workhouses"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Workhouses</option>
<option  <?php if($_REQUEST['SHIC'] == "Child care"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Child care</option>
<option  <?php if($_REQUEST['SHIC'] == "Care of the elderly"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Care of the elderly</option>
<option  <?php if($_REQUEST['SHIC'] == "Care for disabled people"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Care for disabled people</option>
<option  <?php if($_REQUEST['SHIC'] == "Social work"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Social work</option>
<option  <?php if($_REQUEST['SHIC'] == "Sickness and employment services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sickness and employment services</option>
<option  <?php if($_REQUEST['SHIC'] == "Shelter"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Shelter</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Sanitation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sanitation</option>
<option  <?php if($_REQUEST['SHIC'] == "Pest and disease control"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pest and disease control</option>
<option  <?php if($_REQUEST['SHIC'] == "Refuse disposal"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Refuse disposal</option>
<option  <?php if($_REQUEST['SHIC'] == "Sewage disposal"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sewage disposal</option>
<option  <?php if($_REQUEST['SHIC'] == "Cemeteries and crematoria"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cemeteries and crematoria</option>
<option  <?php if($_REQUEST['SHIC'] == "Street drainage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Street drainage</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Education"){?> selected="selected" <?php };?>>&nbsp;Education</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "School"){?> selected="selected" <?php };?>>&nbsp;&nbsp;School</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Nursery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Nursery</option>
<option  <?php if($_REQUEST['SHIC'] == "Infant/junior"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Infant/junior</option>
<option  <?php if($_REQUEST['SHIC'] == "Senior"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Senior</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Higher"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Higher</option>
<option  <?php if($_REQUEST['SHIC'] == "Technical college "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Technical college </option>
<option  <?php if($_REQUEST['SHIC'] == "Polytechnic/university"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Polytechnic/university</option>
<option  <?php if($_REQUEST['SHIC'] == "Art/drama/music college"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Art/drama/music college</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Adult"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Adult</option>
<option  <?php if($_REQUEST['SHIC'] == "Other education"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other education</option>
<option  <?php if($_REQUEST['SHIC'] == "Amenities, entertainment and sport"){?> selected="selected" <?php };?>>&nbsp;Amenities, entertainment and sport</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Cultural amenities"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Cultural amenities</option>
<option  <?php if($_REQUEST['SHIC'] == "Libraries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Libraries</option>
<option  <?php if($_REQUEST['SHIC'] == "Museums and art galleries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Museums and art galleries</option>
<option  <?php if($_REQUEST['SHIC'] == "Other cultural services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other cultural services</option>
<option  <?php if($_REQUEST['SHIC'] == "Open spaces"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Open spaces</option>
<option  <?php if($_REQUEST['SHIC'] == "Parks"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Parks</option>
<option  <?php if($_REQUEST['SHIC'] == "Children’s playgrounds"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Children’s playgrounds</option>
<option  <?php if($_REQUEST['SHIC'] == "Allotments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Allotments</option>
<option  <?php if($_REQUEST['SHIC'] == "Other open spaces"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other open spaces</option>
<option  <?php if($_REQUEST['SHIC'] == "Public memorials, statuary and purely decorative features"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Public memorials, statuary and purely decorative features</option>
<option  <?php if($_REQUEST['SHIC'] == "Memorials"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Memorials</option>
<option  <?php if($_REQUEST['SHIC'] == "Non-memorial statuary"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Non-memorial statuary</option>
<option  <?php if($_REQUEST['SHIC'] == "Other decorative features"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other decorative features</option>
<option  <?php if($_REQUEST['SHIC'] == "Hygiene amenities"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Hygiene amenities</option>
<option  <?php if($_REQUEST['SHIC'] == "Public lavatories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Public lavatories</option>
<option  <?php if($_REQUEST['SHIC'] == "Public slipper baths"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Public slipper baths</option>
<option  <?php if($_REQUEST['SHIC'] == "Public laundries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Public laundries</option>
<option  <?php if($_REQUEST['SHIC'] == "Drinking fountains"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Drinking fountains</option>
<option  <?php if($_REQUEST['SHIC'] == "Street management"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Street management</option>
<option  <?php if($_REQUEST['SHIC'] == "Cleaning"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cleaning</option>
<option  <?php if($_REQUEST['SHIC'] == "Maintenance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Maintenance</option>
<option  <?php if($_REQUEST['SHIC'] == "Lighting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Lighting</option>
<option  <?php if($_REQUEST['SHIC'] == "Seating and shelter"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Seating and shelter</option>
<option  <?php if($_REQUEST['SHIC'] == "Signposting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Signposting</option>
<option  <?php if($_REQUEST['SHIC'] == "Other street management"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other street management</option>
<option  <?php if($_REQUEST['SHIC'] == "Entertainment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Entertainment</option>
<option  <?php if($_REQUEST['SHIC'] == "Sport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sport</option>
<option  <?php if($_REQUEST['SHIC'] == "Sports amenities"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sports amenities</option>
<option  <?php if($_REQUEST['SHIC'] == "Sporting and fitness clubs and teams"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sporting and fitness clubs and teams</option>
<option  <?php if($_REQUEST['SHIC'] == "Other amenities"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other amenities</option>
<option  <?php if($_REQUEST['SHIC'] == "Communications and currency"){?> selected="selected" <?php };?>>&nbsp;Communications and currency</option>
<option  <?php if($_REQUEST['SHIC'] == "Communications"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Communications</option>
<option  <?php if($_REQUEST['SHIC'] == "Vocal"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Vocal</option>
<option  <?php if($_REQUEST['SHIC'] == "Manuscript"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Manuscript</option>
<option  <?php if($_REQUEST['SHIC'] == "Printed"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Printed</option>
<option  <?php if($_REQUEST['SHIC'] == "Telecommunications"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Telecommunications</option>
<option  <?php if($_REQUEST['SHIC'] == "Currency"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Currency</option>
<option  <?php if($_REQUEST['SHIC'] == "Coins of the realm"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Coins of the realm</option>
<option  <?php if($_REQUEST['SHIC'] == "Tokens "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Tokens </option>
<option  <?php if($_REQUEST['SHIC'] == "Warfare and defence"){?> selected="selected" <?php };?>>&nbsp;Warfare and defence</option>
<option  <?php if($_REQUEST['SHIC'] == "General and unprovenanced"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General and unprovenanced</option>
<option  <?php if($_REQUEST['SHIC'] == "Army"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Army</option>
<option  <?php if($_REQUEST['SHIC'] == "British regular"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;British regular</option>
<option  <?php if($_REQUEST['SHIC'] == "British auxiliary forces – includes Territorial Army"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;British auxiliary forces – includes Territorial Army</option>
<option  <?php if($_REQUEST['SHIC'] == "Youth training units"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Youth training units</option>
<option  <?php if($_REQUEST['SHIC'] == "Foreign"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Foreign</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Navy"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Navy</option>
<option  <?php if($_REQUEST['SHIC'] == "Royal navy"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Royal navy</option>
<option  <?php if($_REQUEST['SHIC'] == "Royal navy volunteer reserve (R.N.V.R.)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Royal navy volunteer reserve (R.N.V.R.)</option>
<option  <?php if($_REQUEST['SHIC'] == "Youth training units"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Youth training units</option>
<option  <?php if($_REQUEST['SHIC'] == "Foreign"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Foreign</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Air force"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Air force</option>
<option  <?php if($_REQUEST['SHIC'] == "Royal Air Force"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Royal Air Force</option>
<option  <?php if($_REQUEST['SHIC'] == "Youth training units"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Youth training units</option>
<option  <?php if($_REQUEST['SHIC'] == "Foreign"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Foreign</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Campaigns"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Campaigns</option>
<option  <?php if($_REQUEST['SHIC'] == "Sixteenth century and before"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sixteenth century and before</option>
<option  <?php if($_REQUEST['SHIC'] == "Seventeenth century"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Seventeenth century</option>
<option  <?php if($_REQUEST['SHIC'] == "Eighteenth century"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Eighteenth century</option>
<option  <?php if($_REQUEST['SHIC'] == "French revolution and Napoleonic wars"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;French revolution and Napoleonic wars</option>
<option  <?php if($_REQUEST['SHIC'] == "Nineteenth century"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Nineteenth century</option>
<option  <?php if($_REQUEST['SHIC'] == "First world war"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;First world war</option>
<option  <?php if($_REQUEST['SHIC'] == "Second world war"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Second world war</option>
<option  <?php if($_REQUEST['SHIC'] == "Other twentieth century warfare"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other twentieth century warfare</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Intelligence"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Intelligence</option>
<option  <?php if($_REQUEST['SHIC'] == "Civil units"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Civil units</option>
<option  <?php if($_REQUEST['SHIC'] == "Home guard"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Home guard</option>
<option  <?php if($_REQUEST['SHIC'] == "Royal observer corps"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Royal observer corps</option>
<option  <?php if($_REQUEST['SHIC'] == "Air raid precautions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Air raid precautions</option>
<option  <?php if($_REQUEST['SHIC'] == "Civil defence"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Civil defence</option>
<option  <?php if($_REQUEST['SHIC'] == "Women’s service"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Women’s service</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Civilian life in wartime"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Civilian life in wartime</option>
<option  <?php if($_REQUEST['SHIC'] == "Precautions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Precautions</option>
<option  <?php if($_REQUEST['SHIC'] == "Evacuation and refugees"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Evacuation and refugees</option>
<option  <?php if($_REQUEST['SHIC'] == "Housing and welfare"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Housing and welfare</option>
<option  <?php if($_REQUEST['SHIC'] == "Work"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Work</option>
<option  <?php if($_REQUEST['SHIC'] == "Scarcity of resources"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Scarcity of resources</option>
<option  <?php if($_REQUEST['SHIC'] == "Propaganda"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Propaganda</option>
<option  <?php if($_REQUEST['SHIC'] == "Personal life"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Personal life</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Other aspects of warfare"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other aspects of warfare</option>
<option  <?php if($_REQUEST['SHIC'] == "Prisoners of war"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Prisoners of war</option>
<option  <?php if($_REQUEST['SHIC'] == "Pacifist and anti-war"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pacifist and anti-war</option>
<option  <?php if($_REQUEST['SHIC'] == "Other military material"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other military material</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Events not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Events not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Topography"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Topography</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Domestic and Family Life"){?> selected="selected" <?php };?>>Domestic and Family Life</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Domestic and family administration and records"){?> selected="selected" <?php };?>>&nbsp;Domestic and family administration and records</option>
<option  <?php if($_REQUEST['SHIC'] == "House structure and infrastructure"){?> selected="selected" <?php };?>>&nbsp;House structure and infrastructure</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Walling"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Walling</option>
<option  <?php if($_REQUEST['SHIC'] == "Roofing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Roofing</option>
<option  <?php if($_REQUEST['SHIC'] == "Doors"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Doors</option>
<option  <?php if($_REQUEST['SHIC'] == "Windows"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Windows</option>
<option  <?php if($_REQUEST['SHIC'] == "Flooring"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Flooring</option>
<option  <?php if($_REQUEST['SHIC'] == "Ceilings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Ceilings</option>
<option  <?php if($_REQUEST['SHIC'] == "Staircases"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Staircases</option>
<option  <?php if($_REQUEST['SHIC'] == "Services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Services</option>
<option  <?php if($_REQUEST['SHIC'] == "Gas"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Gas</option>
<option  <?php if($_REQUEST['SHIC'] == "Electricity"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electricity</option>
<option  <?php if($_REQUEST['SHIC'] == "Water"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Water</option>
<option  <?php if($_REQUEST['SHIC'] == "Sewage and drainage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sewage and drainage</option>
<option  <?php if($_REQUEST['SHIC'] == "Communications"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Communications</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Other components"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other components</option>
<option  <?php if($_REQUEST['SHIC'] == "Heating, lighting, water and sanitation"){?> selected="selected" <?php };?>>&nbsp;Heating, lighting, water and sanitation</option>
<option  <?php if($_REQUEST['SHIC'] == "Heating"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Heating</option>
<option  <?php if($_REQUEST['SHIC'] == "Solid fuel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Solid fuel</option>
<option  <?php if($_REQUEST['SHIC'] == "Liquid fuel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Liquid fuel</option>
<option  <?php if($_REQUEST['SHIC'] == "Gas"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Gas</option>
<option  <?php if($_REQUEST['SHIC'] == "Electricity"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electricity</option>
<option  <?php if($_REQUEST['SHIC'] == "Central heating radiators"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Central heating radiators</option>
<option  <?php if($_REQUEST['SHIC'] == "Other heating appliances"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other heating appliances</option>
<option  <?php if($_REQUEST['SHIC'] == "Lighting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Lighting</option>
<option  <?php if($_REQUEST['SHIC'] == "Solid fuel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Solid fuel</option>
<option  <?php if($_REQUEST['SHIC'] == "Oil"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Oil</option>
<option  <?php if($_REQUEST['SHIC'] == "Gas"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Gas</option>
<option  <?php if($_REQUEST['SHIC'] == "Electricity "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electricity </option>
<option  <?php if($_REQUEST['SHIC'] == "Water"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Water</option>
<option  <?php if($_REQUEST['SHIC'] == "Sanitation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sanitation</option>
<option  <?php if($_REQUEST['SHIC'] == "Furnishings and fittings"){?> selected="selected" <?php };?>>&nbsp;Furnishings and fittings</option>
<option  <?php if($_REQUEST['SHIC'] == "Furniture"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Furniture</option>
<option  <?php if($_REQUEST['SHIC'] == "Small furnishings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Small furnishings</option>
<option  <?php if($_REQUEST['SHIC'] == "Floor coverings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Floor coverings</option>
<option  <?php if($_REQUEST['SHIC'] == "Ornaments and curios"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Ornaments and curios</option>
<option  <?php if($_REQUEST['SHIC'] == "Pictures"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Pictures</option>
<option  <?php if($_REQUEST['SHIC'] == "Wall fittings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Wall fittings</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Household management"){?> selected="selected" <?php };?>>&nbsp;Household management</option>
<option  <?php if($_REQUEST['SHIC'] == "Genera."){?> selected="selected" <?php };?>>&nbsp;&nbsp;Genera.</option>
<option  <?php if($_REQUEST['SHIC'] == "House cleaning"){?> selected="selected" <?php };?>>&nbsp;&nbsp;House cleaning</option>
<option  <?php if($_REQUEST['SHIC'] == "Dry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dry</option>
<option  <?php if($_REQUEST['SHIC'] == "Wet"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wet</option>
<option  <?php if($_REQUEST['SHIC'] == "Finishing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Finishing</option>
<option  <?php if($_REQUEST['SHIC'] == "Waste disposal "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Waste disposal </option>
<option  <?php if($_REQUEST['SHIC'] == "Utensil cleaning and maintenance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Utensil cleaning and maintenance</option>
<option  <?php if($_REQUEST['SHIC'] == "Costume and soft furnishings care and maintenance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Costume and soft furnishings care and maintenance</option>
<option  <?php if($_REQUEST['SHIC'] == "Dry cleaning"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dry cleaning</option>
<option  <?php if($_REQUEST['SHIC'] == "Washing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Washing</option>
<option  <?php if($_REQUEST['SHIC'] == "Drying"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Drying</option>
<option  <?php if($_REQUEST['SHIC'] == "Ironing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ironing</option>
<option  <?php if($_REQUEST['SHIC'] == "Darning and mending"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Darning and mending</option>
<option  <?php if($_REQUEST['SHIC'] == "Costume and soft furnishings storage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Costume and soft furnishings storage</option>
<option  <?php if($_REQUEST['SHIC'] == "Shoe cleaning and storage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Shoe cleaning and storage</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Home protection and security"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Home protection and security</option>
<option  <?php if($_REQUEST['SHIC'] == "Intruder protection and detection"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Intruder protection and detection</option>
<option  <?php if($_REQUEST['SHIC'] == "Pest control"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pest control</option>
<option  <?php if($_REQUEST['SHIC'] == "Fire protection"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Fire protection</option>
<option  <?php if($_REQUEST['SHIC'] == "Other protection "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other protection </option>
<option  <?php if($_REQUEST['SHIC'] == "Family hygiene"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Family hygiene</option>
<option  <?php if($_REQUEST['SHIC'] == "Provisioning"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Provisioning</option>
<option  <?php if($_REQUEST['SHIC'] == "Maintenance and decoration"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Maintenance and decoration</option>
<option  <?php if($_REQUEST['SHIC'] == "Food, drink and tobacco"){?> selected="selected" <?php };?>>&nbsp;Food, drink and tobacco</option>
<option  <?php if($_REQUEST['SHIC'] == "Nutrition"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Nutrition</option>
<option  <?php if($_REQUEST['SHIC'] == "Storage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Storage</option>
<option  <?php if($_REQUEST['SHIC'] == "Preservation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Preservation</option>
<option  <?php if($_REQUEST['SHIC'] == "Preparation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Preparation</option>
<option  <?php if($_REQUEST['SHIC'] == "Cooking"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Cooking</option>
<option  <?php if($_REQUEST['SHIC'] == "Food heating appliances and accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food heating appliances and accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Other cooking processes"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other cooking processes</option>
<option  <?php if($_REQUEST['SHIC'] == "Cooking containers and accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cooking containers and accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Liquid heating appliances and accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Liquid heating appliances and accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Liquid heating containers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Liquid heating containers</option>
<option  <?php if($_REQUEST['SHIC'] == "Other cooking accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other cooking accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Serving, eating and drinking"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Serving, eating and drinking</option>
<option  <?php if($_REQUEST['SHIC'] == "Food serving containers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food serving containers</option>
<option  <?php if($_REQUEST['SHIC'] == "Food serving cutlery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food serving cutlery</option>
<option  <?php if($_REQUEST['SHIC'] == "Food serving accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food serving accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Food eating containers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food eating containers</option>
<option  <?php if($_REQUEST['SHIC'] == "Food eating cutlery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food eating cutlery</option>
<option  <?php if($_REQUEST['SHIC'] == "Drink serving vessels"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Drink serving vessels</option>
<option  <?php if($_REQUEST['SHIC'] == "Drink accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Drink accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Serving and eating not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Serving and eating not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Products</option>
<option  <?php if($_REQUEST['SHIC'] == "Tobacco"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Tobacco</option>
<option  <?php if($_REQUEST['SHIC'] == "Family wellbeing"){?> selected="selected" <?php };?>>&nbsp;Family wellbeing</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Infant raising"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Infant raising</option>
<option  <?php if($_REQUEST['SHIC'] == "Child rearing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Child rearing</option>
<option  <?php if($_REQUEST['SHIC'] == "Nursing the family"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Nursing the family</option>
<option  <?php if($_REQUEST['SHIC'] == "Physical fitness in the home"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Physical fitness in the home</option>
<option  <?php if($_REQUEST['SHIC'] == "Family change"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Family change</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Hobbies, crafts and pastimes"){?> selected="selected" <?php };?>>&nbsp;Hobbies, crafts and pastimes</option>
<option  <?php if($_REQUEST['SHIC'] == "Toys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Toys</option>
<option  <?php if($_REQUEST['SHIC'] == "Creative, educational and activity toys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Creative, educational and activity toys</option>
<option  <?php if($_REQUEST['SHIC'] == "Representations of creatures"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Representations of creatures</option>
<option  <?php if($_REQUEST['SHIC'] == "Child sized toys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Child sized toys</option>
<option  <?php if($_REQUEST['SHIC'] == "Motion toys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Motion toys</option>
<option  <?php if($_REQUEST['SHIC'] == "Play environments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Play environments</option>
<option  <?php if($_REQUEST['SHIC'] == "Miniature toys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miniature toys</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Games"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Games</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Board and table"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Board and table</option>
<option  <?php if($_REQUEST['SHIC'] == "Card"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Card</option>
<option  <?php if($_REQUEST['SHIC'] == "Hitting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hitting</option>
<option  <?php if($_REQUEST['SHIC'] == "Physical"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Physical</option>
<option  <?php if($_REQUEST['SHIC'] == "Puzzles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Puzzles</option>
<option  <?php if($_REQUEST['SHIC'] == "Electronic and video games"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electronic and video games</option>
<option  <?php if($_REQUEST['SHIC'] == "Party games"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Party games</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Crafts and hobbies"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Crafts and hobbies</option>
<option  <?php if($_REQUEST['SHIC'] == "Textile crafts purely for recreational purposes"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Textile crafts purely for recreational purposes</option>
<option  <?php if($_REQUEST['SHIC'] == "Art"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Art</option>
<option  <?php if($_REQUEST['SHIC'] == "Woodworking"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Woodworking</option>
<option  <?php if($_REQUEST['SHIC'] == "Metal working"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Metal working</option>
<option  <?php if($_REQUEST['SHIC'] == "Model making"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Model making</option>
<option  <?php if($_REQUEST['SHIC'] == "Other crafts"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other crafts</option>
<option  <?php if($_REQUEST['SHIC'] == "Collecting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Collecting</option>
<option  <?php if($_REQUEST['SHIC'] == "Other hobbies"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other hobbies</option>
<option  <?php if($_REQUEST['SHIC'] == "Sport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sport</option>
<option  <?php if($_REQUEST['SHIC'] == "Walking, climbing, caving and potholing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Walking, climbing, caving and potholing</option>
<option  <?php if($_REQUEST['SHIC'] == "Athletics and gymnastics"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Athletics and gymnastics</option>
<option  <?php if($_REQUEST['SHIC'] == "Ball games"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ball games</option>
<option  <?php if($_REQUEST['SHIC'] == "Water and winter"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Water and winter</option>
<option  <?php if($_REQUEST['SHIC'] == "Combat and target"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Combat and target</option>
<option  <?php if($_REQUEST['SHIC'] == "Flying and motor"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Flying and motor</option>
<option  <?php if($_REQUEST['SHIC'] == "Blood sports includes angling"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Blood sports includes angling</option>
<option  <?php if($_REQUEST['SHIC'] == "Equestrian and animal"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Equestrian and animal</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Music"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Music</option>
<option  <?php if($_REQUEST['SHIC'] == "Played instruments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Played instruments</option>
<option  <?php if($_REQUEST['SHIC'] == "Mechanical instruments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mechanical instruments</option>
<option  <?php if($_REQUEST['SHIC'] == "Accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Musical scores"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Musical scores</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Broadcast and pre-recorded entertainment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Broadcast and pre-recorded entertainment</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Broadcast sound receiving"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Broadcast sound receiving</option>
<option  <?php if($_REQUEST['SHIC'] == "Broadcast vision receiving"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Broadcast vision receiving</option>
<option  <?php if($_REQUEST['SHIC'] == "Mechanically-stored sound reproduction"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mechanically-stored sound reproduction</option>
<option  <?php if($_REQUEST['SHIC'] == "Magnetically-stored sound reproduction"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Magnetically-stored sound reproduction</option>
<option  <?php if($_REQUEST['SHIC'] == "Still image reproduction"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Still image reproduction</option>
<option  <?php if($_REQUEST['SHIC'] == "Moving picture reproduction – optical"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Moving picture reproduction – optical</option>
<option  <?php if($_REQUEST['SHIC'] == "Moving picture reproduction – video "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Moving picture reproduction – video </option>
<option  <?php if($_REQUEST['SHIC'] == "Books"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Books</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Events"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Events</option>
<option  <?php if($_REQUEST['SHIC'] == "Gardening"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Gardening</option>
<option  <?php if($_REQUEST['SHIC'] == "Boundaries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Boundaries</option>
<option  <?php if($_REQUEST['SHIC'] == "Garden structures and ground features"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Garden structures and ground features</option>
<option  <?php if($_REQUEST['SHIC'] == "Garden furniture"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Garden furniture</option>
<option  <?php if($_REQUEST['SHIC'] == "Ornamentation "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ornamentation </option>
<option  <?php if($_REQUEST['SHIC'] == "Plant husbandry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Plant husbandry</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Livestock"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Livestock</option>
<option  <?php if($_REQUEST['SHIC'] == "Travel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Travel</option>
<option  <?php if($_REQUEST['SHIC'] == "Man-powered transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Man-powered transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Animal-powered transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Animal-powered transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Motorise transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Motorise transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Mobile homes"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mobile homes</option>
<option  <?php if($_REQUEST['SHIC'] == "Luggage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Luggage</option>
<option  <?php if($_REQUEST['SHIC'] == "Other travel accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other travel accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Other aspects of travel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other aspects of travel</option>
<option  <?php if($_REQUEST['SHIC'] == "Holidays and movements"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Holidays and movements</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Excursions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Excursions</option>
<option  <?php if($_REQUEST['SHIC'] == "Holidays"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Holidays</option>
<option  <?php if($_REQUEST['SHIC'] == "Moving house"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Moving house</option>
<option  <?php if($_REQUEST['SHIC'] == "Emigration and immigration"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Emigration and immigration</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Communicating equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Communicating equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Writing equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Writing equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Mechanical and electrical writing equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mechanical and electrical writing equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Domestic telecommunications equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Domestic telecommunications equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Radio equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Radio equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Personal Life"){?> selected="selected" <?php };?>>Personal Life</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Administration and records"){?> selected="selected" <?php };?>>&nbsp;Administration and records</option>
<option  <?php if($_REQUEST['SHIC'] == "Certificates"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Certificates</option>
<option  <?php if($_REQUEST['SHIC'] == "Biography"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Biography</option>
<option  <?php if($_REQUEST['SHIC'] == "Diaries and autobiography"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Diaries and autobiography</option>
<option  <?php if($_REQUEST['SHIC'] == "Portraits"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Portraits</option>
<option  <?php if($_REQUEST['SHIC'] == "Commonplace books, etc"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Commonplace books, etc</option>
<option  <?php if($_REQUEST['SHIC'] == "Personal stationery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Personal stationery</option>
<option  <?php if($_REQUEST['SHIC'] == "Other personal administration and records"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other personal administration and records</option>
<option  <?php if($_REQUEST['SHIC'] == "Relics, mementoes and memorials"){?> selected="selected" <?php };?>>&nbsp;Relics, mementoes and memorials</option>
<option  <?php if($_REQUEST['SHIC'] == "Relics"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Relics</option>
<option  <?php if($_REQUEST['SHIC'] == "Mementos"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Mementos</option>
<option  <?php if($_REQUEST['SHIC'] == "Memorials"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Memorials</option>
<option  <?php if($_REQUEST['SHIC'] == "Costume"){?> selected="selected" <?php };?>>&nbsp;Costume</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Adult unisex"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Adult unisex</option>
<option  <?php if($_REQUEST['SHIC'] == "Men’s"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Men’s</option>
<option  <?php if($_REQUEST['SHIC'] == "Main Garments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Main Garments</option>
<option  <?php if($_REQUEST['SHIC'] == "Outerwear "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Outerwear </option>
<option  <?php if($_REQUEST['SHIC'] == "Protective wear"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Protective wear</option>
<option  <?php if($_REQUEST['SHIC'] == "Underwear "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Underwear </option>
<option  <?php if($_REQUEST['SHIC'] == "Supporting and shaping structures"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Supporting and shaping structures</option>
<option  <?php if($_REQUEST['SHIC'] == "Night and dressing wear"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Night and dressing wear</option>
<option  <?php if($_REQUEST['SHIC'] == "Accessories worn"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Accessories worn</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous costume accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous costume accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Women’s"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Women’s</option>
<option  <?php if($_REQUEST['SHIC'] == "Main garments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Main garments</option>
<option  <?php if($_REQUEST['SHIC'] == "Outerwear "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Outerwear </option>
<option  <?php if($_REQUEST['SHIC'] == "Protective wear"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Protective wear</option>
<option  <?php if($_REQUEST['SHIC'] == "Underwear"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Underwear</option>
<option  <?php if($_REQUEST['SHIC'] == "Supporting and shaping structures"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Supporting and shaping structures</option>
<option  <?php if($_REQUEST['SHIC'] == "Night and dressing wear"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Night and dressing wear</option>
<option  <?php if($_REQUEST['SHIC'] == "Accessories worn"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Accessories worn</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous costume accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous costume accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Children’s unisex"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Children’s unisex</option>
<option  <?php if($_REQUEST['SHIC'] == "Boys’"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Boys’</option>
<option  <?php if($_REQUEST['SHIC'] == "Girls’"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Girls’</option>
<option  <?php if($_REQUEST['SHIC'] == "Infants’"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Infants’</option>
<option  <?php if($_REQUEST['SHIC'] == "Accessories not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;Accessories not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Storage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Storage</option>
<option  <?php if($_REQUEST['SHIC'] == "Timekeeping"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Timekeeping</option>
<option  <?php if($_REQUEST['SHIC'] == "Writing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Writing</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Toilet"){?> selected="selected" <?php };?>>&nbsp;Toilet</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Washing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Washing</option>
<option  <?php if($_REQUEST['SHIC'] == "Oral hygiene"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Oral hygiene</option>
<option  <?php if($_REQUEST['SHIC'] == "Feminine hygiene"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Feminine hygiene</option>
<option  <?php if($_REQUEST['SHIC'] == "Hair care"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Hair care</option>
<option  <?php if($_REQUEST['SHIC'] == "Manicure and pedicure"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Manicure and pedicure</option>
<option  <?php if($_REQUEST['SHIC'] == "Perfume"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Perfume</option>
<option  <?php if($_REQUEST['SHIC'] == "Make-up"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Make-up</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Food, drink and tobacco"){?> selected="selected" <?php };?>>&nbsp;Food, drink and tobacco</option>
<option  <?php if($_REQUEST['SHIC'] == "Food"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Food</option>
<option  <?php if($_REQUEST['SHIC'] == "Drink"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Drink</option>
<option  <?php if($_REQUEST['SHIC'] == "Tobacco"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Tobacco</option>
<option  <?php if($_REQUEST['SHIC'] == "Personal wellbeing"){?> selected="selected" <?php };?>>&nbsp;Personal wellbeing</option>
<option  <?php if($_REQUEST['SHIC'] == "Sex and procreation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sex and procreation</option>
<option  <?php if($_REQUEST['SHIC'] == "Sexual orientation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sexual orientation</option>
<option  <?php if($_REQUEST['SHIC'] == "Recreational sex"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Recreational sex</option>
<option  <?php if($_REQUEST['SHIC'] == "Contraception"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Contraception</option>
<option  <?php if($_REQUEST['SHIC'] == "Conception"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Conception</option>
<option  <?php if($_REQUEST['SHIC'] == "Pregnancy"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pregnancy</option>
<option  <?php if($_REQUEST['SHIC'] == "Termination"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Termination</option>
<option  <?php if($_REQUEST['SHIC'] == "Childbirth"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Childbirth</option>
<option  <?php if($_REQUEST['SHIC'] == "Sexually transmitted diseases"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sexually transmitted diseases</option>
<option  <?php if($_REQUEST['SHIC'] == "Medication"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Medication</option>
<option  <?php if($_REQUEST['SHIC'] == "Hearing impairment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Hearing impairment</option>
<option  <?php if($_REQUEST['SHIC'] == "Sight impairment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sight impairment</option>
<option  <?php if($_REQUEST['SHIC'] == "Mobility impairment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Mobility impairment</option>
<option  <?php if($_REQUEST['SHIC'] == "Surgical support"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Surgical support</option>
<option  <?php if($_REQUEST['SHIC'] == "Artificial limbs, organs, etc"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Artificial limbs, organs, etc</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Events"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Events</option>
<option  <?php if($_REQUEST['SHIC'] == "Other"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other</option>
<option  <?php if($_REQUEST['SHIC'] == "Working Life"){?> selected="selected" <?php };?>>Working Life</option>
<option  <?php if($_REQUEST['SHIC'] == "General and unprovenanced"){?> selected="selected" <?php };?>>&nbsp;General and unprovenanced</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "General trade and industry exhibitions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General trade and industry exhibitions</option>
<option  <?php if($_REQUEST['SHIC'] == "Business and professional organisations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Business and professional organisations</option>
<option  <?php if($_REQUEST['SHIC'] == "Labour organisations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Labour organisations</option>
<option  <?php if($_REQUEST['SHIC'] == "Unprovenanced"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Unprovenanced</option>
<option  <?php if($_REQUEST['SHIC'] == "Agriculture, forestry and fishing"){?> selected="selected" <?php };?>>&nbsp;Agriculture, forestry and fishing</option>
<option  <?php if($_REQUEST['SHIC'] == "Agriculture"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Agriculture</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Administration and commerce"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Administration and commerce</option>
<option  <?php if($_REQUEST['SHIC'] == "General buildings, land management, tolls and equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General buildings, land management, tolls and equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Crop husbandry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Crop husbandry</option>
<option  <?php if($_REQUEST['SHIC'] == "Animal husbandry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Animal husbandry</option>
<option  <?php if($_REQUEST['SHIC'] == "Production-related operations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Production-related operations</option>
<option  <?php if($_REQUEST['SHIC'] == "External operations and support services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;External operations and support services</option>
<option  <?php if($_REQUEST['SHIC'] == "People"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;People</option>
<option  <?php if($_REQUEST['SHIC'] == "Other "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other </option>
<option  <?php if($_REQUEST['SHIC'] == "Horticulture"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Horticulture</option>
<option  <?php if($_REQUEST['SHIC'] == "Agricultural and horticultural services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Agricultural and horticultural services</option>
<option  <?php if($_REQUEST['SHIC'] == "Forestry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Forestry</option>
<option  <?php if($_REQUEST['SHIC'] == "Fishing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Fishing</option>
<option  <?php if($_REQUEST['SHIC'] == "Commercial seas fishing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Commercial seas fishing</option>
<option  <?php if($_REQUEST['SHIC'] == "Commercial fishing inland waters"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Commercial fishing inland waters</option>
<option  <?php if($_REQUEST['SHIC'] == "Commercial hunting and trapping"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Commercial hunting and trapping</option>
<option  <?php if($_REQUEST['SHIC'] == "Energy and water supply industries"){?> selected="selected" <?php };?>>&nbsp;Energy and water supply industries</option>
<option  <?php if($_REQUEST['SHIC'] == "Peat cutting and coal extraction"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Peat cutting and coal extraction</option>
<option  <?php if($_REQUEST['SHIC'] == "Peat cutting for fuel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Peat cutting for fuel</option>
<option  <?php if($_REQUEST['SHIC'] == "Coal Mining"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Coal Mining</option>
<option  <?php if($_REQUEST['SHIC'] == "Coke ovens and manufacture of other solid fuels"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Coke ovens and manufacture of other solid fuels</option>
<option  <?php if($_REQUEST['SHIC'] == "Coke ovens"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Coke ovens</option>
<option  <?php if($_REQUEST['SHIC'] == "Low temperature carbonization plants"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Low temperature carbonization plants</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of other solid fuels"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Manufacture of other solid fuels</option>
<option  <?php if($_REQUEST['SHIC'] == "Extraction of mineral oils and natural gas"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Extraction of mineral oils and natural gas</option>
<option  <?php if($_REQUEST['SHIC'] == "Mineral oil processing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Mineral oil processing</option>
<option  <?php if($_REQUEST['SHIC'] == "Mineral oil refining"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mineral oil refining</option>
<option  <?php if($_REQUEST['SHIC'] == "Other treatment of petroleum products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other treatment of petroleum products</option>
<option  <?php if($_REQUEST['SHIC'] == "Nuclear fuel production"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Nuclear fuel production</option>
<option  <?php if($_REQUEST['SHIC'] == "Production and distribution of electricity, gas and other forms of energy"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Production and distribution of electricity, gas and other forms of energy</option>
<option  <?php if($_REQUEST['SHIC'] == "Production and distribution of electricity"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Production and distribution of electricity</option>
<option  <?php if($_REQUEST['SHIC'] == "Production and distribution of gas"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Production and distribution of gas</option>
<option  <?php if($_REQUEST['SHIC'] == "Production and distribution of other forms of energy"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Production and distribution of other forms of energy</option>
<option  <?php if($_REQUEST['SHIC'] == "Water supply industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Water supply industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Minerals and chemical "){?> selected="selected" <?php };?>>&nbsp;Minerals and chemical </option>
<option  <?php if($_REQUEST['SHIC'] == "Extraction of minerals"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Extraction of minerals</option>
<option  <?php if($_REQUEST['SHIC'] == "Extraction of stone, clay, sand and gravel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Extraction of stone, clay, sand and gravel</option>
<option  <?php if($_REQUEST['SHIC'] == "Salt extraction and refining"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Salt extraction and refining</option>
<option  <?php if($_REQUEST['SHIC'] == "Extraction of minerals not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Extraction of minerals not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of non-metallic mineral products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Manufacture of non-metallic mineral products</option>
<option  <?php if($_REQUEST['SHIC'] == "Structural clay products and refractory goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Structural clay products and refractory goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Pottery and ceramic goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pottery and ceramic goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Cement, lime and plaster"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cement, lime and plaster</option>
<option  <?php if($_REQUEST['SHIC'] == "Asbestos goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Asbestos goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Working of stone and other non-metallic minerals not elsewhere "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Working of stone and other non-metallic minerals not elsewhere </option>
<option  <?php if($_REQUEST['SHIC'] == "specified"){?> selected="selected" <?php };?>>specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Abrasive products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Abrasive products</option>
<option  <?php if($_REQUEST['SHIC'] == "Glass and glassware"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Glass and glassware</option>
<option  <?php if($_REQUEST['SHIC'] == "Chemical industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Chemical industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Basic industrial chemicals"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Basic industrial chemicals</option>
<option  <?php if($_REQUEST['SHIC'] == "Paints, varnishes and printing ink"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Paints, varnishes and printing ink</option>
<option  <?php if($_REQUEST['SHIC'] == "Specialised chemical products mainly for industrial and "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Specialised chemical products mainly for industrial and </option>
<option  <?php if($_REQUEST['SHIC'] == "agricultural purposes"){?> selected="selected" <?php };?>>agricultural purposes</option>
<option  <?php if($_REQUEST['SHIC'] == "Pharmaceutical products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pharmaceutical products</option>
<option  <?php if($_REQUEST['SHIC'] == "Soap and toilet preparations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Soap and toilet preparations</option>
<option  <?php if($_REQUEST['SHIC'] == "Specialised chemical products mainly for household and office "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Specialised chemical products mainly for household and office </option>
<option  <?php if($_REQUEST['SHIC'] == "use"){?> selected="selected" <?php };?>>use</option>
<option  <?php if($_REQUEST['SHIC'] == "Production of man-made fibres"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Production of man-made fibres</option>
<option  <?php if($_REQUEST['SHIC'] == "Chemical products not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Chemical products not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Extraction of metallic ores; manufacture of metals and metal goods, "){?> selected="selected" <?php };?>>&nbsp;Extraction of metallic ores; manufacture of metals and metal goods, </option>
<option  <?php if($_REQUEST['SHIC'] == "engineering industries"){?> selected="selected" <?php };?>>engineering industries</option>
<option  <?php if($_REQUEST['SHIC'] == "Ferrous metals industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Ferrous metals industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Extraction and preparation of ferrous ores"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Extraction and preparation of ferrous ores</option>
<option  <?php if($_REQUEST['SHIC'] == "Iron and steel manufacture"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Iron and steel manufacture</option>
<option  <?php if($_REQUEST['SHIC'] == "Iron and steel tubes"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Iron and steel tubes</option>
<option  <?php if($_REQUEST['SHIC'] == "Drawing, cold-rolling and cold-forming of iron and steel"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Drawing, cold-rolling and cold-forming of iron and steel</option>
<option  <?php if($_REQUEST['SHIC'] == "Non-ferrous metals industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Non-ferrous metals industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Aluminium and aluminium alloys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Aluminium and aluminium alloys</option>
<option  <?php if($_REQUEST['SHIC'] == "Copper, brass and other copper alloys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Copper, brass and other copper alloys</option>
<option  <?php if($_REQUEST['SHIC'] == "Lead"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Lead</option>
<option  <?php if($_REQUEST['SHIC'] == "Lead mining"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;&nbsp;Lead mining</option>
<option  <?php if($_REQUEST['SHIC'] == "Tin"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Tin</option>
<option  <?php if($_REQUEST['SHIC'] == "Zinc "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Zinc </option>
<option  <?php if($_REQUEST['SHIC'] == "Precious metals"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Precious metals</option>
<option  <?php if($_REQUEST['SHIC'] == "Other non-ferrous metals and their alloys"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other non-ferrous metals and their alloys</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of metal goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Manufacture of metal goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Founding"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Founding</option>
<option  <?php if($_REQUEST['SHIC'] == "Forging, pressing and stamping"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Forging, pressing and stamping</option>
<option  <?php if($_REQUEST['SHIC'] == "Heat and surface treatment of metals"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Heat and surface treatment of metals</option>
<option  <?php if($_REQUEST['SHIC'] == "Basic finished metal products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Basic finished metal products</option>
<option  <?php if($_REQUEST['SHIC'] == "Hand tools and cutlery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hand tools and cutlery</option>
<option  <?php if($_REQUEST['SHIC'] == "Metal storage and packaging products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Metal storage and packaging products</option>
<option  <?php if($_REQUEST['SHIC'] == "Metal fitments for buildings and domestic use"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Metal fitments for buildings and domestic use</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous finished metal products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous finished metal products</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of metal goods not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Manufacture of metal goods not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Mechanical engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Mechanical engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "General Mechanical engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General Mechanical engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Industrial plant and ironwork"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Industrial plant and ironwork</option>
<option  <?php if($_REQUEST['SHIC'] == "Industrial prime movers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Industrial prime movers</option>
<option  <?php if($_REQUEST['SHIC'] == "Mechanical power transmission equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mechanical power transmission equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Compressors and fluid power equipment, pumps and valves"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Compressors and fluid power equipment, pumps and valves</option>
<option  <?php if($_REQUEST['SHIC'] == "Refrigeration machinery, space heating, ventilating and air-conditioning equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Refrigeration machinery, space heating, ventilating and air-conditioning equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Metal-working machine tools and engineers’ tools"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Metal-working machine tools and engineers’ tools</option>
<option  <?php if($_REQUEST['SHIC'] == "Mining machinery, construction and mechanical handling equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mining machinery, construction and mechanical handling equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Agricultural machinery and tractors"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Agricultural machinery and tractors</option>
<option  <?php if($_REQUEST['SHIC'] == "Machinery for the food, chemical and related industries; process "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Machinery for the food, chemical and related industries; process </option>
<option  <?php if($_REQUEST['SHIC'] == "engineering contractors"){?> selected="selected" <?php };?>>engineering contractors</option>
<option  <?php if($_REQUEST['SHIC'] == "Textile machinery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Textile machinery</option>
<option  <?php if($_REQUEST['SHIC'] == "Machinery for the printing, paper, wood, leather, rubber, glass and related industries; laundry and dry cleaning machinery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Machinery for the printing, paper, wood, leather, rubber, glass and related industries; laundry and dry cleaning machinery</option>
<option  <?php if($_REQUEST['SHIC'] == "Other industrial and commercial machinery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other industrial and commercial machinery</option>
<option  <?php if($_REQUEST['SHIC'] == "Ordnance, small arms and ammunition"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ordnance, small arms and ammunition</option>
<option  <?php if($_REQUEST['SHIC'] == "Mechanical and precision engineering not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mechanical and precision engineering not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Electrical and electronic engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Electrical and electronic engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Insulated wires and cables"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Insulated wires and cables</option>
<option  <?php if($_REQUEST['SHIC'] == "Basic electrical equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Basic electrical equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Electrical equipment for industrial use; batteries and "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electrical equipment for industrial use; batteries and </option>
<option  <?php if($_REQUEST['SHIC'] == "accumulators"){?> selected="selected" <?php };?>>accumulators</option>
<option  <?php if($_REQUEST['SHIC'] == "Telecommunication equipment, electrical measuring equipment, electronic capital goods and passive electronic components"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Telecommunication equipment, electrical measuring equipment, electronic capital goods and passive electronic components</option>
<option  <?php if($_REQUEST['SHIC'] == "Other electronic equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other electronic equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Domestic electrical appliances"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Domestic electrical appliances</option>
<option  <?php if($_REQUEST['SHIC'] == "Electric lamps and other electric lighting equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electric lamps and other electric lighting equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Electrical equipment installation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electrical equipment installation</option>
<option  <?php if($_REQUEST['SHIC'] == "Transport engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Transport engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Road vehicles and parts"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Road vehicles and parts</option>
<option  <?php if($_REQUEST['SHIC'] == "Railway and tramway vehicles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Railway and tramway vehicles</option>
<option  <?php if($_REQUEST['SHIC'] == "Shipbuilding and marine engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Shipbuilding and marine engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Aero engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Aero engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Space engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Space engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Instrument engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Instrument engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Measuring, checking and precision instruments and apparatus"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Measuring, checking and precision instruments and apparatus</option>
<option  <?php if($_REQUEST['SHIC'] == "Medical and surgical equipment and orthopaedic appliances"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Medical and surgical equipment and orthopaedic appliances</option>
<option  <?php if($_REQUEST['SHIC'] == "Optical precision instruments and photographic equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Optical precision instruments and photographic equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Clocks, watches and other timing devices"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Clocks, watches and other timing devices</option>
<option  <?php if($_REQUEST['SHIC'] == "Other miscellaneous engineering not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other miscellaneous engineering not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Office machinery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Office machinery</option>
<option  <?php if($_REQUEST['SHIC'] == "Electronic data processing equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electronic data processing equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacturing industries not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;Manufacturing industries not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Food, drink and tobacco industries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Food, drink and tobacco industries</option>
<option  <?php if($_REQUEST['SHIC'] == "Abattoir"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Abattoir</option>
<option  <?php if($_REQUEST['SHIC'] == "Preparation of milk and milk products – not including dairying carried out at agricultural establishments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Preparation of milk and milk products – not including dairying carried out at agricultural establishments</option>
<option  <?php if($_REQUEST['SHIC'] == "Processing of fruit and vegetables"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Processing of fruit and vegetables</option>
<option  <?php if($_REQUEST['SHIC'] == "Fish processing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Fish processing</option>
<option  <?php if($_REQUEST['SHIC'] == "Grain milling"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Grain milling</option>
<option  <?php if($_REQUEST['SHIC'] == "Starch"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Starch</option>
<option  <?php if($_REQUEST['SHIC'] == "Bread, biscuits and flour confectionery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Bread, biscuits and flour confectionery</option>
<option  <?php if($_REQUEST['SHIC'] == "Sugar and sugar by-products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sugar and sugar by-products</option>
<option  <?php if($_REQUEST['SHIC'] == "Ice cream, cocoa, chocolate and sugar confectionery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ice cream, cocoa, chocolate and sugar confectionery</option>
<option  <?php if($_REQUEST['SHIC'] == "Animal feeding stuffs"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Animal feeding stuffs</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous foods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous foods</option>
<option  <?php if($_REQUEST['SHIC'] == "Spirit distilling and compounding"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Spirit distilling and compounding</option>
<option  <?php if($_REQUEST['SHIC'] == "Wines, cider and perry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wines, cider and perry</option>
<option  <?php if($_REQUEST['SHIC'] == "Brewing and malting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Brewing and malting</option>
<option  <?php if($_REQUEST['SHIC'] == "Soft drinks"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Soft drinks</option>
<option  <?php if($_REQUEST['SHIC'] == "Tobacco industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Tobacco industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Textile industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Textile industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Fulling Mill"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Fulling Mill</option>
<option  <?php if($_REQUEST['SHIC'] == "Woollen and worsted industry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Woollen and worsted industry</option>
<option  <?php if($_REQUEST['SHIC'] == "Cotton and silk industries, including man-made fibre spun on the cotton system"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cotton and silk industries, including man-made fibre spun on the cotton system</option>
<option  <?php if($_REQUEST['SHIC'] == "Throwing, texturing, etc of continuous filament yarn"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Throwing, texturing, etc of continuous filament yarn</option>
<option  <?php if($_REQUEST['SHIC'] == "Spinning and weaving of flax, hemp and ramie"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Spinning and weaving of flax, hemp and ramie</option>
<option  <?php if($_REQUEST['SHIC'] == "Jute and polypropylene yarns and fabrics"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Jute and polypropylene yarns and fabrics</option>
<option  <?php if($_REQUEST['SHIC'] == "Hosiery and other knitted goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hosiery and other knitted goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Textile finishing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Textile finishing</option>
<option  <?php if($_REQUEST['SHIC'] == "Carpets and other textile floor coverings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Carpets and other textile floor coverings</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous textiles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous textiles</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of leather and leather goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Manufacture of leather and leather goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Leather tanning and dressing, and fellmongery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Leather tanning and dressing, and fellmongery</option>
<option  <?php if($_REQUEST['SHIC'] == "Leather goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Leather goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Footwear and clothing industries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Footwear and clothing industries</option>
<option  <?php if($_REQUEST['SHIC'] == "Footwear"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Footwear</option>
<option  <?php if($_REQUEST['SHIC'] == "Clothing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Clothing</option>
<option  <?php if($_REQUEST['SHIC'] == "Hats. Gloves and miscellaneous dress accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hats. Gloves and miscellaneous dress accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Household textiles and other made-up textiles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Household textiles and other made-up textiles</option>
<option  <?php if($_REQUEST['SHIC'] == "Fur goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Fur goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Timber and wooden furniture industries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Timber and wooden furniture industries</option>
<option  <?php if($_REQUEST['SHIC'] == "General wood working"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General wood working</option>
<option  <?php if($_REQUEST['SHIC'] == "Sawmilling, planning, etc of wood"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sawmilling, planning, etc of wood</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of semi-finished wood products and further processing and  treatment of wood"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Manufacture of semi-finished wood products and further processing and  treatment of wood</option>
<option  <?php if($_REQUEST['SHIC'] == "Builders’ carpentry and joinery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Builders’ carpentry and joinery</option>
<option  <?php if($_REQUEST['SHIC'] == "Wooden containers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wooden containers</option>
<option  <?php if($_REQUEST['SHIC'] == "Wooden and upholstered furniture and shop and office fittings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wooden and upholstered furniture and shop and office fittings</option>
<option  <?php if($_REQUEST['SHIC'] == "Articles of cork and plaiting material, bushes and brooms"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Articles of cork and plaiting material, bushes and brooms</option>
<option  <?php if($_REQUEST['SHIC'] == "Wooden agricultural, industrial and technical equipment and articles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wooden agricultural, industrial and technical equipment and articles</option>
<option  <?php if($_REQUEST['SHIC'] == "Other wooden articles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other wooden articles</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of paper and paper products, printing and publishing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Manufacture of paper and paper products, printing and publishing</option>
<option  <?php if($_REQUEST['SHIC'] == "Manufacture of pulp, paper and board"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Manufacture of pulp, paper and board</option>
<option  <?php if($_REQUEST['SHIC'] == "Conversion of paper and board"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Conversion of paper and board</option>
<option  <?php if($_REQUEST['SHIC'] == "Printing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Printing</option>
<option  <?php if($_REQUEST['SHIC'] == "Publishing "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Publishing </option>
<option  <?php if($_REQUEST['SHIC'] == "Processing of rubber and plastics"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Processing of rubber and plastics</option>
<option  <?php if($_REQUEST['SHIC'] == "Rubber products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Rubber products</option>
<option  <?php if($_REQUEST['SHIC'] == "Retreading and specialist repairing of rubber tyres"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retreading and specialist repairing of rubber tyres</option>
<option  <?php if($_REQUEST['SHIC'] == "Processing of plastics"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Processing of plastics</option>
<option  <?php if($_REQUEST['SHIC'] == "Other manufacturing industries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other manufacturing industries</option>
<option  <?php if($_REQUEST['SHIC'] == "Brick making"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Brick making</option>
<option  <?php if($_REQUEST['SHIC'] == "Jewellery and coins"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Jewellery and coins</option>
<option  <?php if($_REQUEST['SHIC'] == "Musical instruments"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Musical instruments</option>
<option  <?php if($_REQUEST['SHIC'] == "Photographic and cinematographic processing laboratories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Photographic and cinematographic processing laboratories</option>
<option  <?php if($_REQUEST['SHIC'] == "Toys and sports goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Toys and sports goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous stationers’ goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous stationers’ goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Ivory, bone, horn, shell, etc products"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Ivory, bone, horn, shell, etc products</option>
<option  <?php if($_REQUEST['SHIC'] == "Other manufacturers not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other manufacturers not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Construction"){?> selected="selected" <?php };?>>&nbsp;Construction</option>
<option  <?php if($_REQUEST['SHIC'] == "General construction and demolition work"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General construction and demolition work</option>
<option  <?php if($_REQUEST['SHIC'] == "Construction and repair of buildings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Construction and repair of buildings</option>
<option  <?php if($_REQUEST['SHIC'] == "Foundations"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Foundations</option>
<option  <?php if($_REQUEST['SHIC'] == "Bricklaying and masonry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Bricklaying and masonry</option>
<option  <?php if($_REQUEST['SHIC'] == "Erection of steel and concrete"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Erection of steel and concrete</option>
<option  <?php if($_REQUEST['SHIC'] == "Carpentry"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Carpentry</option>
<option  <?php if($_REQUEST['SHIC'] == "Roofing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Roofing</option>
<option  <?php if($_REQUEST['SHIC'] == "Slate Roofing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Slate Roofing</option>
<option  <?php if($_REQUEST['SHIC'] == "Thatching"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Thatching</option>
<option  <?php if($_REQUEST['SHIC'] == "Scaffolding"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Scaffolding</option>
<option  <?php if($_REQUEST['SHIC'] == "Other construction and repair"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other construction and repair</option>
<option  <?php if($_REQUEST['SHIC'] == "Installation of fixtures and fittings"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Installation of fixtures and fittings</option>
<option  <?php if($_REQUEST['SHIC'] == "Gas fitting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Gas fitting</option>
<option  <?php if($_REQUEST['SHIC'] == "Plumbing, heating and ventilation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Plumbing, heating and ventilation</option>
<option  <?php if($_REQUEST['SHIC'] == "Sound and heat insulation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sound and heat insulation</option>
<option  <?php if($_REQUEST['SHIC'] == "Electrical installation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Electrical installation</option>
<option  <?php if($_REQUEST['SHIC'] == "Other installation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other installation</option>
<option  <?php if($_REQUEST['SHIC'] == "Building completion work"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Building completion work</option>
<option  <?php if($_REQUEST['SHIC'] == "Painting and decoration"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Painting and decoration</option>
<option  <?php if($_REQUEST['SHIC'] == "Glazing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Glazing</option>
<option  <?php if($_REQUEST['SHIC'] == "Plastering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Plastering</option>
<option  <?php if($_REQUEST['SHIC'] == "Wall and floor tiling"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wall and floor tiling</option>
<option  <?php if($_REQUEST['SHIC'] == "Flooring"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Flooring</option>
<option  <?php if($_REQUEST['SHIC'] == "Other completion work"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other completion work</option>
<option  <?php if($_REQUEST['SHIC'] == "Civil engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Civil engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Construction of roads, car parks, railways, airport runways"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Construction of roads, car parks, railways, airport runways</option>
<option  <?php if($_REQUEST['SHIC'] == "Construction of bridges and tunnels"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Construction of bridges and tunnels</option>
<option  <?php if($_REQUEST['SHIC'] == "Hydraulic engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hydraulic engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Pipe and cable laying"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Pipe and cable laying</option>
<option  <?php if($_REQUEST['SHIC'] == "Construction of aerial structures"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Construction of aerial structures</option>
<option  <?php if($_REQUEST['SHIC'] == "Industrial site construction"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Industrial site construction</option>
<option  <?php if($_REQUEST['SHIC'] == "Shaft drilling and mine sinking"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Shaft drilling and mine sinking</option>
<option  <?php if($_REQUEST['SHIC'] == "Laying out or parks and sports grounds"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Laying out or parks and sports grounds</option>
<option  <?php if($_REQUEST['SHIC'] == "Other civil engineering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other civil engineering</option>
<option  <?php if($_REQUEST['SHIC'] == "Transport and communications"){?> selected="selected" <?php };?>>&nbsp;Transport and communications</option>
<option  <?php if($_REQUEST['SHIC'] == "General"){?> selected="selected" <?php };?>>&nbsp;&nbsp;General</option>
<option  <?php if($_REQUEST['SHIC'] == "Road"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Road</option>
<option  <?php if($_REQUEST['SHIC'] == "Provision of route"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Provision of route</option>
<option  <?php if($_REQUEST['SHIC'] == "General carriers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General carriers</option>
<option  <?php if($_REQUEST['SHIC'] == "Passenger transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Passenger transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Goods haulage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Goods haulage</option>
<option  <?php if($_REQUEST['SHIC'] == "Supporting services to road transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Supporting services to road transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Rail"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Rail</option>
<option  <?php if($_REQUEST['SHIC'] == "Railway companies"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Railway companies</option>
<option  <?php if($_REQUEST['SHIC'] == "Independent passenger carriers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Independent passenger carriers</option>
<option  <?php if($_REQUEST['SHIC'] == "Pullman car company"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;&nbsp;Pullman car company</option>
<option  <?php if($_REQUEST['SHIC'] == "Independent goods carriage"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Independent goods carriage</option>
<option  <?php if($_REQUEST['SHIC'] == "Inland waterway"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Inland waterway</option>
<option  <?php if($_REQUEST['SHIC'] == "Canal companies"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Canal companies</option>
<option  <?php if($_REQUEST['SHIC'] == "Provision of route only"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Provision of route only</option>
<option  <?php if($_REQUEST['SHIC'] == "General carriers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General carriers</option>
<option  <?php if($_REQUEST['SHIC'] == "Passenger carriers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Passenger carriers</option>
<option  <?php if($_REQUEST['SHIC'] == "Freight carriers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Freight carriers</option>
<option  <?php if($_REQUEST['SHIC'] == "Public carriers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;&nbsp;Public carriers</option>
<option  <?php if($_REQUEST['SHIC'] == "Inland ferries"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;&nbsp;Inland ferries</option>
<option  <?php if($_REQUEST['SHIC'] == "Maritime"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Maritime</option>
<option  <?php if($_REQUEST['SHIC'] == "Provision of dock and navigational services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Provision of dock and navigational services</option>
<option  <?php if($_REQUEST['SHIC'] == "General shipping lines"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General shipping lines</option>
<option  <?php if($_REQUEST['SHIC'] == "Passenger lines"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Passenger lines</option>
<option  <?php if($_REQUEST['SHIC'] == "Cargo lines"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cargo lines</option>
<option  <?php if($_REQUEST['SHIC'] == "Supporting services to marine transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Supporting services to marine transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Air"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Air</option>
<option  <?php if($_REQUEST['SHIC'] == "Provision of airport and navigational services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Provision of airport and navigational services</option>
<option  <?php if($_REQUEST['SHIC'] == "Airports"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;&nbsp;Airports</option>
<option  <?php if($_REQUEST['SHIC'] == "Air traffic control"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;&nbsp;Air traffic control</option>
<option  <?php if($_REQUEST['SHIC'] == "General air lines"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General air lines</option>
<option  <?php if($_REQUEST['SHIC'] == "Passenger air lines"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Passenger air lines</option>
<option  <?php if($_REQUEST['SHIC'] == "Air freight lines"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Air freight lines</option>
<option  <?php if($_REQUEST['SHIC'] == "Supporting services to air transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Supporting services to air transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Space"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Space</option>
<option  <?php if($_REQUEST['SHIC'] == "Transport not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Transport not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous transport and storage services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Miscellaneous transport and storage services</option>
<option  <?php if($_REQUEST['SHIC'] == "Travel agents"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Travel agents</option>
<option  <?php if($_REQUEST['SHIC'] == "Freight brokers and other agents facilitating freight transport"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Freight brokers and other agents facilitating freight transport</option>
<option  <?php if($_REQUEST['SHIC'] == "Storage and warehousing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Storage and warehousing</option>
<option  <?php if($_REQUEST['SHIC'] == "Postal services and telecommunications"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Postal services and telecommunications</option>
<option  <?php if($_REQUEST['SHIC'] == "Postal services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Postal services</option>
<option  <?php if($_REQUEST['SHIC'] == "Royal Mail"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Royal Mail</option>
<option  <?php if($_REQUEST['SHIC'] == "Telecommunications"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Telecommunications</option>
<option  <?php if($_REQUEST['SHIC'] == "British Telecom"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;British Telecom</option>
<option  <?php if($_REQUEST['SHIC'] == "Distribution, hotels and catering, repairs"){?> selected="selected" <?php };?>>&nbsp;Distribution, hotels and catering, repairs</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution (except dealing in scrap and waste materials)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Wholesale distribution (except dealing in scrap and waste materials)</option>
<option  <?php if($_REQUEST['SHIC'] == "General wholesalers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General wholesalers</option>
<option  <?php if($_REQUEST['SHIC'] == "Co-operative Wholesale Society (C.W.S.)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Co-operative Wholesale Society (C.W.S.)</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of agricultural raw materials, textile raw materials and semi-manufacturers and live animals"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of agricultural raw materials, textile raw materials and semi-manufacturers and live animals</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of fuels, ores, metals and industrial materials"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of fuels, ores, metals and industrial materials</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of timber and building materials"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of timber and building materials</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of machinery, industrial equipment and vehicles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of machinery, industrial equipment and vehicles</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of household goods, hardware and ironmongery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of household goods, hardware and ironmongery</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of textiles, clothing, footwear and leather goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of textiles, clothing, footwear and leather goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of food, drink and tobacco"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of food, drink and tobacco</option>
<option  <?php if($_REQUEST['SHIC'] == "Wholesale distribution of pharmaceutical, medical and other chemists’ goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Wholesale distribution of pharmaceutical, medical and other chemists’ goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Other wholesale distribution"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other wholesale distribution</option>
<option  <?php if($_REQUEST['SHIC'] == "Dealing in scrap and waste materials"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Dealing in scrap and waste materials</option>
<option  <?php if($_REQUEST['SHIC'] == "Dealing in scrap metals"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dealing in scrap metals</option>
<option  <?php if($_REQUEST['SHIC'] == "Shipbreaking"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Shipbreaking</option>
<option  <?php if($_REQUEST['SHIC'] == "Dealing in other scrap materials"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dealing in other scrap materials</option>
<option  <?php if($_REQUEST['SHIC'] == "Commission agents"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Commission agents</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Retail distribution</option>
<option  <?php if($_REQUEST['SHIC'] == "Mixed retail businesses and markets"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Mixed retail businesses and markets</option>
<option  <?php if($_REQUEST['SHIC'] == "Co-operative Store"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Co-operative Store</option>
<option  <?php if($_REQUEST['SHIC'] == "Market "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Market </option>
<option  <?php if($_REQUEST['SHIC'] == "Food retailing"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Food retailing</option>
<option  <?php if($_REQUEST['SHIC'] == "Confectioners, tobacconists and newsagents, ice cream vendors and off-licences"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Confectioners, tobacconists and newsagents, ice cream vendors and off-licences</option>
<option  <?php if($_REQUEST['SHIC'] == "Dispensing and other chemists"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dispensing and other chemists</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution of clothing and clothing fabrics, etc"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retail distribution of clothing and clothing fabrics, etc</option>
<option  <?php if($_REQUEST['SHIC'] == "Dress accessories"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Dress accessories</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution of footwear and leather goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retail distribution of footwear and leather goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution of furnishing fabrics and household textiles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retail distribution of furnishing fabrics and household textiles</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution of household goods, hardware and ironmongery"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retail distribution of household goods, hardware and ironmongery</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution of motor vehicles and parts"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retail distribution of motor vehicles and parts</option>
<option  <?php if($_REQUEST['SHIC'] == "Filling stations (motor fuel and lubricants)"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Filling stations (motor fuel and lubricants)</option>
<option  <?php if($_REQUEST['SHIC'] == "Retail distribution of books, stationery and office supplies"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Retail distribution of books, stationery and office supplies</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous specialised retail distribution "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous specialised retail distribution </option>
<option  <?php if($_REQUEST['SHIC'] == "Other specialised retail distribution (non-food) "){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other specialised retail distribution (non-food) </option>
<option  <?php if($_REQUEST['SHIC'] == "Hotels and catering"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Hotels and catering</option>
<option  <?php if($_REQUEST['SHIC'] == "Restaurants, snack bars, cafes and other eating places"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Restaurants, snack bars, cafes and other eating places</option>
<option  <?php if($_REQUEST['SHIC'] == "Public houses and bars"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Public houses and bars</option>
<option  <?php if($_REQUEST['SHIC'] == "Night clubs and licensed clubs"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Night clubs and licensed clubs</option>
<option  <?php if($_REQUEST['SHIC'] == "Catering contractors"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Catering contractors</option>
<option  <?php if($_REQUEST['SHIC'] == "Hotel trade"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hotel trade</option>
<option  <?php if($_REQUEST['SHIC'] == "Other tourist or short-stay accommodation"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other tourist or short-stay accommodation</option>
<option  <?php if($_REQUEST['SHIC'] == "Repair of consumer goods and vehicles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Repair of consumer goods and vehicles</option>
<option  <?php if($_REQUEST['SHIC'] == "Repair and servicing of motor vehicles"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Repair and servicing of motor vehicles</option>
<option  <?php if($_REQUEST['SHIC'] == "Repair of footwear and leather goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Repair of footwear and leather goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Repair of other consumer goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Repair of other consumer goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Other working life"){?> selected="selected" <?php };?>>&nbsp;Other working life</option>
<option  <?php if($_REQUEST['SHIC'] == "Banking, finance and insurance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Banking, finance and insurance</option>
<option  <?php if($_REQUEST['SHIC'] == "Banking and bill-discounting"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Banking and bill-discounting</option>
<option  <?php if($_REQUEST['SHIC'] == "Institutions specialising in the granting of credit"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Institutions specialising in the granting of credit</option>
<option  <?php if($_REQUEST['SHIC'] == "Institutions specialising in investment in securities"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Institutions specialising in investment in securities</option>
<option  <?php if($_REQUEST['SHIC'] == "Activities auxiliary to banking and finance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Activities auxiliary to banking and finance</option>
<option  <?php if($_REQUEST['SHIC'] == "Insurance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Insurance</option>
<option  <?php if($_REQUEST['SHIC'] == "Activities auxiliary to insurance"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Activities auxiliary to insurance</option>
<option  <?php if($_REQUEST['SHIC'] == "Other financial institutions"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other financial institutions</option>
<option  <?php if($_REQUEST['SHIC'] == "Business services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Business services</option>
<option  <?php if($_REQUEST['SHIC'] == "House and estate agents; auctioneers"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;House and estate agents; auctioneers</option>
<option  <?php if($_REQUEST['SHIC'] == "Legal services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Legal services</option>
<option  <?php if($_REQUEST['SHIC'] == "Accountants, auditors, tax experts"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Accountants, auditors, tax experts</option>
<option  <?php if($_REQUEST['SHIC'] == "Professional and technical services not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Professional and technical services not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Advertising"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Advertising</option>
<option  <?php if($_REQUEST['SHIC'] == "Other business services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other business services</option>
<option  <?php if($_REQUEST['SHIC'] == "Renting of movables, owning and dealing in real estate"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Renting of movables, owning and dealing in real estate</option>
<option  <?php if($_REQUEST['SHIC'] == "General hiring"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;General hiring</option>
<option  <?php if($_REQUEST['SHIC'] == "Hiring out agricultural and horticultural equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hiring out agricultural and horticultural equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Hiring out construction machinery and equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hiring out construction machinery and equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Hiring out office machinery and equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hiring out office machinery and equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Hiring out consumer goods"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hiring out consumer goods</option>
<option  <?php if($_REQUEST['SHIC'] == "Hiring out transport equipment"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hiring out transport equipment</option>
<option  <?php if($_REQUEST['SHIC'] == "Hiring out other movables"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hiring out other movables</option>
<option  <?php if($_REQUEST['SHIC'] == "Owning and dealing in real estate"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Owning and dealing in real estate</option>
<option  <?php if($_REQUEST['SHIC'] == "Sanitary services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Sanitary services</option>
<option  <?php if($_REQUEST['SHIC'] == "Refuse disposal, sanitation and similar services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Refuse disposal, sanitation and similar services</option>
<option  <?php if($_REQUEST['SHIC'] == "Cleaning services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Cleaning services</option>
<option  <?php if($_REQUEST['SHIC'] == "Education and training, research"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Education and training, research</option>
<option  <?php if($_REQUEST['SHIC'] == "Recreational and other cultural services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Recreational and other cultural services</option>
<option  <?php if($_REQUEST['SHIC'] == "Film and video production, distribution and exhibition"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Film and video production, distribution and exhibition</option>
<option  <?php if($_REQUEST['SHIC'] == "Radio and television services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Radio and television services</option>
<option  <?php if($_REQUEST['SHIC'] == "Theatres, concert halls, etc"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Theatres, concert halls, etc</option>
<option  <?php if($_REQUEST['SHIC'] == "Travelling shows, circuses, etc"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Travelling shows, circuses, etc</option>
<option  <?php if($_REQUEST['SHIC'] == "Authors, music composers and other own account artists not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Authors, music composers and other own account artists not elsewhere specified</option>
<option  <?php if($_REQUEST['SHIC'] == "Sport and associated services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Sport and associated services</option>
<option  <?php if($_REQUEST['SHIC'] == "Betting and gambling"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Betting and gambling</option>
<option  <?php if($_REQUEST['SHIC'] == "Other recreational services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other recreational services</option>
<option  <?php if($_REQUEST['SHIC'] == "Personal and domestic services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Personal and domestic services</option>
<option  <?php if($_REQUEST['SHIC'] == "Laundries, dryers and dry-cleaning"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Laundries, dryers and dry-cleaning</option>
<option  <?php if($_REQUEST['SHIC'] == "Hairdressing and beauty parlours"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Hairdressing and beauty parlours</option>
<option  <?php if($_REQUEST['SHIC'] == "Miscellaneous personal services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Miscellaneous personal services</option>
<option  <?php if($_REQUEST['SHIC'] == "Other personal services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other personal services</option>
<option  <?php if($_REQUEST['SHIC'] == "Domestic services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Domestic services</option>
<option  <?php if($_REQUEST['SHIC'] == "Other domestic services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Other domestic services</option>
<option  <?php if($_REQUEST['SHIC'] == "Other services provided to the general public"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other services provided to the general public</option>
<option  <?php if($_REQUEST['SHIC'] == "Tourist offices"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Tourist offices</option>
<option  <?php if($_REQUEST['SHIC'] == "Veterinary services"){?> selected="selected" <?php };?>>&nbsp;&nbsp;&nbsp;Veterinary services</option>
<option  <?php if($_REQUEST['SHIC'] == "Other working life not elsewhere specified"){?> selected="selected" <?php };?>>&nbsp;&nbsp;Other working life not elsewhere specified</option>

		</select>
	</div>
</div>
<div class="queryline oddline">
	<div class="queryprompt">Collection Group:</div>	<div class="queryfield"><input type="text" name="CollectionGroup" /></div>
</div>
<div class="queryline">
	<div class="queryprompt">Collection Sub-Group:</div>	<div class="queryfield"><input type="text" name="CollectionSubGroup" /></div>
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

