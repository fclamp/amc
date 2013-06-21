
<? include "nmnh_mcs_header.html" ?>



<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search results</title>
</head>

<body bgcolor="#AAC1C0">
<h4><font face="Arial" color="#013567"><b>Search results </b> in our prototype 
  display... <br>
  <font size="2">Over time more data and images will be made available.</font></font></h4>
<center>
<?php


require_once('../../objects/nmnh/ResultsLists.php');

$resultlist = new NmnhContactSheet;
$resultlist->ResultsListPage = "ResultsList.php";

$resultlist->DisplayPage = array(
		'ConditionField' => 'AdmWebCategories',

		'Paleobiology' => '../pal/Display.php',
		'Paleobiology - Invertebrate Paleontology' => '../pal/Display.php',
		'Paleobiology - Paleobotony' => '../pal/Display.php',
		'Paleobiology - Sediments' => '../pal/Display.php',
		'Paleobiology - Stratigraphy' => '../pal/Display.php',
		'Paleobiology - Vertebrate Paleontology' => '../pal/Display.php',

		'Systematic Biology' => '/mcs/iz/Display.php',
		'Systematic Biology - Invertebrate Zoology' => '../iz/Display.php',

		'Systematic Biology - Vertebrate Zoology' => '../vz/Display.php',
		'Systematic Biology - Vertebrate Zoology - Amphibians & Reptiles' => '../vz/HerpDisplay.php',
		'Systematic Biology - Vertebrate Zoology - Mammals' => '../vz/MamDisplay.php',
		'Systematic Biology - Vertebrate Zoology - Fishes' => '../vz/FishDisplay.php',
		'Systematic Biology - Vertebrate Zoology - Birds' => '../vz/BirdDisplay.php',

		'Systematic Biology - Botany' => '../bot/Display.php',

		'Mineral Sciences' => '../ms/Display.php',
		'Mineral Sciences - Gems & Minerals' => '../ms/GemDisplay.php',
		'Mineral Sciences - Meteorites' => '../ms/MetDisplay.php',
		'Mineral Sciences - Petrology & Volcanology' => '../ms/PetDisplay.php',

		'Anthropology' => '../anth/Display.php',
		'Anthropology - Archaeology' => '../anth/Display.php',
		'Anthropology - Ethnology' => '../anth/Display.php',
		'Anthropology - Physical Anthropology' => '../anth/Display.php',

		'Default' => 'Display.php',
		);

$resultlist->BodyColor = '#FFF3DE';
$resultlist->Width = '80%';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Arial';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#013567';
$resultlist->HeaderColor = '#013567';
$resultlist->BorderColor = '#013567';
$resultlist->HeaderTextColor = '#013567';
$resultlist->Show();
?>
</center>


<blockquote>
<? include "nmnh_mcs_footer.html" ?>

</blockquote>

</body>

</html>

