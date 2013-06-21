<html>

<head>
<title>
Anthropology Collections On-Line [Advanced Search]
</title>

<style type='text/css'>

	body { 
		font-family: Tahoma, Arial;
		font-size: 9pt;
	}	
	table {
		font-family: Tahoma, Arial;
		font-size: 9pt;
		color: #336699;
	}

	a:link { color: #336699; text-decoration: none }
	a:active { color: #336699; text-decoration: none }
	a:visited { color: #336699; text-decoration: none }
	a:hover { color: #FFFFFF; text-decoration: none; background: #336699 }


</style>
</head>


<body bgcolor="#FFFFE8">

<table width=95% cellpadding=0 cellspacing=0>
<tr>
<td width="230" valign="top" align="left">


<table cellpadding=0 cellspacing=0 width=90%>
<tr>
<td bgcolor="#5F9EA0">


<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td width="50%" bgcolor="#5F9EA0">
<font color="#FFFFFF"><b>Topics</b></font>
</td>
</tr>

<tr>
<td bgcolor="#FFFFE8">

<ul>

<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Archaeology') 
	or (NarNarrative contains 'Archaeology') or 
	(NarTitle contains 'Archaeology') or (SummaryData contains 'Archaeology')";

        $MediaLink->PrintRef();
?>

">
Archaeology</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Art' or DesSubjects  contains 'Architecture' 
	or DesSubjects  contains 'Carved Tree') or
	(NarNarrative contains 'Art' or NarNarrative contains 'Architecture' or NarNarrative contains 'Carved Tree') or 
	(NarTitle contains 'Art' or NarTitle contains 'Architecture' or NarTitle contains 'Carved Tree') or 
	(SummaryData contains 'Art' or SummaryData contains 'Architecture' or SummaryData contains 'Carved Tree')";


        $MediaLink->PrintRef();
?>

">
Art</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Body Accessories' or DesSubjects  contains 'Body Enhancement') or
	(NarNarrative contains 'Body Accessories' or NarNarrative contains 'Body Enhancement') or 
	(NarTitle contains 'Body Accessories' or NarTitle contains 'Body Enhancement') or 
	(SummaryData contains 'Body Accessories' or SummaryData contains 'Body Enhancement')";

        $MediaLink->PrintRef();
?>

">
Body Accessories</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Clothing') or
	(NarNarrative contains 'Clothing') or 
	(NarTitle contains 'Clothing') or 
	(SummaryData contains 'Clothing')";

        $MediaLink->PrintRef();
?>

">
Clothing</a></b>



<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Communication' or DesSubjects  contains 'Currency' 
	or DesSubjects  contains 'Measurement') or
	(NarNarrative contains 'Communication' or NarNarrative contains 'Currency' 
	or NarNarrative contains 'Measurement') or 
	(NarTitle contains 'Communication' or NarTitle contains 'Currency' or NarTitle contains 'Measurement') or 
	(SummaryData contains 'Communication' or SummaryData contains 'Currency' 
	or SummaryData contains 'Measurement')";


        $MediaLink->PrintRef();
?>

">
Communication and Exchange</a></b>



<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Container') 
	or (NarNarrative contains 'Container') or (NarTitle contains 'Container') or (SummaryData contains 'Container')";

        $MediaLink->PrintRef();
?>

">
Container</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Household') 
	or (NarNarrative contains 'Household') or (NarTitle contains 'Household') or (SummaryData contains 'Household')";

        $MediaLink->PrintRef();
?>

">
Household</a></b>




<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Hunting' or DesSubjects  contains 'Fishing' 
	or DesSubjects  contains 'Weapon') or
	(NarNarrative contains 'Hunting' or NarNarrative contains 'Fishing' 
	or NarNarrative contains 'Weapon') or 
	(NarTitle contains 'Hunting' or NarTitle contains 'Fishing' or NarTitle contains 'Weapon') or 
	(SummaryData contains 'Hunting' or SummaryData contains 'Fishing' 
	or SummaryData contains 'Weapon')";


        $MediaLink->PrintRef();
?>

">
Hunting</a></b>




<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Pastime') 
	or (NarNarrative contains 'Pastime') or (NarTitle contains 'Pastime') or (SummaryData contains 'Pastime')";

        $MediaLink->PrintRef();
?>

">
Leisure</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Raw Material') 
	or (NarNarrative contains 'Raw Material') or (NarTitle contains 'Raw Material') or 
	(SummaryData contains 'Raw Material')";

        $MediaLink->PrintRef();
?>

">
Raw Material</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Sound' or DesSubjects  contains 'Music') or
	(NarNarrative contains 'Sound' or NarNarrative contains 'Music') or 
	(NarTitle contains 'Sound' or NarTitle contains 'Music') or 
	(SummaryData contains 'Sound' or SummaryData contains 'Music')";

        $MediaLink->PrintRef();
?>

">
Sound and Music</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists 
	(DesSubjects_tab where DesSubjects contains 'Textile' or DesSubjects  contains 'Equipment') or
	(NarNarrative contains 'Textile' or NarNarrative contains 'Equipment') or 
	(NarTitle contains 'Textile' or NarTitle contains 'Equipment') or 
	(SummaryData contains 'Textile' or SummaryData contains 'Equipment')";

        $MediaLink->PrintRef();
?>

">
Textile and Equipment</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Tool') 
	or (NarNarrative contains 'Tool') or (NarTitle contains 'Tool') or 
	(SummaryData contains 'Tool')";

        $MediaLink->PrintRef();
?>

">
Tool</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Toy') 
	or (NarNarrative contains 'Toy') or (NarTitle contains 'Toy') or 
	(SummaryData contains 'Toy')";

        $MediaLink->PrintRef();
?>

">
Toy</a></b>


<li><b>
<a href="
<?php
	require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Where = 
	"exists (DesSubjects_tab where DesSubjects contains 'Transport') 
	or (NarNarrative contains 'Transport') or (NarTitle contains 'Transport') or 
	(SummaryData contains 'Transport')";

        $MediaLink->PrintRef();
?>

">
Transport</a></b>





</ul>

</td>
</tr>


</table>



</td>
</tr>
</table>
<br>


<table cellpadding=0 cellspacing=0 width=90%>
<tr>
<td bgcolor="#5F9EA0">


<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td width="50%" bgcolor="#5F9EA0">
<font color="#FFFFFF"><b>Highlights</b></font>
</td>
</tr>

<tr>
<td bgcolor="#FFFFE8">

<ul>

<li><b>
<a href="
<?php
        require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Database = "enarratives";

	$MediaLink->Where =
	"exists (DesSubjects_tab where DesSubjects contains 'Cook') or
	(NarNarrative contains 'Cook') or (NarTitle contains
	'Cook') or (SummaryData contains 'Cook')";

        $MediaLink->PrintRef();
?>
">
Cook Collection</a></b>


<li><b>
<a href="
<?php
        require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Database = "enarratives";

	$MediaLink->Where =
	"exists (DesSubjects_tab where DesSubjects contains 'Malagan') or
	(NarNarrative contains 'Malagan') or (NarTitle contains
	'Malagan') or (SummaryData contains 'Malagan')";


        $MediaLink->PrintRef();
?>
">
Malagan Masks</a></b>



<li><b>
<a href="
<?php
        require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Database = "enarratives";

	$MediaLink->Where =
	"exists (DesSubjects_tab where DesSubjects contains 'Aboriginal') or
	(NarNarrative contains 'Aboriginal') or (NarTitle contains
	'Aboriginal') or (SummaryData contains 'Aboriginal')";


        $MediaLink->PrintRef();
?>
">
Aboriginal Bark Paintings</a></b>



<li><b>
<a href="
<?php
        require_once('../../objects/common/PreConfiguredQuery.php');
        $MediaLink = new PreConfiguredQueryLink;
        $MediaLink->LimitPerPage = 20;
        $MediaLink->Database = "enarratives";
        $MediaLink->Where = "SummaryData contains 'Torres Strait Islands'";

	$MediaLink->Where =
	"exists (DesSubjects_tab where DesSubjects contains 'Torres') or
	(NarNarrative contains 'Torres') or (NarTitle contains
	'Torres') or (SummaryData contains 'Torres')";

        $MediaLink->PrintRef();
?>
">

Torres Strait Islands</a></b>
</ul>


</td>



</tr>
</table>
</td>
</tr>
</table>


<br>

<table cellpadding=0 cellspacing=0 width=90%>
<tr>
<td bgcolor="#5F9EA0">


<table border="0" width="100%" cellspacing="2" cellpadding="2">
<tr>
<td width="50%" bgcolor="#5F9EA0">
<font color="#FFFFFF"><b>Search Types</b></font>
</td>
</tr>

<tr>
<td bgcolor="#FFFFE8">

<ul>
<li><b><a href="Query.php">Basic Query</a></b>
<li><i>Advanced Query</i>
<li><b><a href="DtlQuery.php">Detailed Query</a></b>
</ul>

</td>

</tr>
</table>
</td>
</tr>
</table>


</td>


<td width="*" valign="top" align="left">

<b><u>Anthropology Collection</u> [Advanced Search]</b>
<br>
<br>
<br>
<i>Popular searches are available in the section to the left. 
</i>
<br>
<i>Advanced keyword searches can be performed in the main search box below. </i>
<br>
<i>Different search options can be accessed on the left navigation bar.  </i>



<br>
<br>

<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
//$LangSelector->Show();
?>


<form action="" method=GET>
<font face=Tahoma size=2 color=#336699>Topics to search
<br>
<select name=type onChange="submit();">

<?php

// used to switch selected dropdown menu
if($ALL_REQUEST['type'] == "objectpeople"){

        ?>
	<option value="objectplace">Object and Place</option>
	<option value="objectpeople" selected>Object and People/Culture</option>
	<option value="peopleculture">People/Culture and Place</option>
	<?php
}
elseif($ALL_REQUEST['type'] == "objectplace"){

        ?>
	<option value="objectplace" selected>Object and Place</option>
	<option value="objectpeople">Object and People/Culture</option>
	<option value="peopleculture">People/Culture and Place</option>
	<?php
}
else{

        ?>
	<option value="objectplace">Object and Place</option>
	<option value="objectpeople">Object and People/Culture</option>
	<option value="peopleculture" selected>People/Culture and Place</option>
	<?php
}

?>

</select>
</font>
<input type=submit value="Go!">
</form>

<br>
(Note: Will only search catalogue records)


</td>
</tr>

</table>


<br>
<br>
<center>
<?php

if($ALL_REQUEST['type'] == "objectplace"){

	require_once('../../objects/amanthro/QueryForms.php');
	$queryform = new AmAdvancedQueryFormOne;
	$queryform->ResultsListPage = "ResultsListObject.php";
	$queryform->Title = "Advanced Object and Place Search";
	$queryform->FontFace = 'Tahoma, Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#336699';
	$queryform->BorderColor = '#336699';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Show();
}
elseif($ALL_REQUEST['type'] == "objectpeople"){

	require_once('../../objects/amanthro/QueryForms.php');
	$queryform = new AmAdvancedQueryFormTwo;
	$queryform->ResultsListPage = "ResultsListObject.php";
	$queryform->Title = "Advanced Object and People/Culture Search";
	$queryform->FontFace = 'Tahoma, Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#336699';
	$queryform->BorderColor = '#336699';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Show();
}
else{

	require_once('../../objects/amanthro/QueryForms.php');
	$queryform = new AmAdvancedQueryFormThree;
	$queryform->ResultsListPage = "ResultsListObject.php";
	$queryform->Title = "Advanced People/Culture and Place Search";
	$queryform->FontFace = 'Tahoma, Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#336699';
	$queryform->BorderColor = '#336699';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Show();
}

?>

</center>
</body>
</html>
