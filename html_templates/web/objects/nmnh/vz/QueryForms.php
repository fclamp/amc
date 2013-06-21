<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
{
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
}

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

$GLOBALS['STRINGS_DIR'] = $WEB_ROOT . "/objects/" . $GLOBALS['BACKEND_TYPE'] . "/" . $GLOBALS['DEPARTMENT'] . "/strings/" . $GLOBALS['BACKEND_ENV'] . "/";

class
NmnhVzBirdsBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber=integer',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzFishesBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber=integer',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzHerpsBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber=integer',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzMammalsBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Mammals'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber=integer',
	);
}
//=====================================================================================================
//=====================================================================================================
// VZ ADVANCED QUERY FORM CLASSES

class
NmnhVzBirdsAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzFishesAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber',
	);
} 
//=====================================================================================================
//=====================================================================================================
class
NmnhVzHerpsAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzMammalsAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Mammals'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeFiledAsName',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'number' 	=> 'CatNumber',
	);
}
//=====================================================================================================
//=====================================================================================================
// VZ DETAILED QUERY FORM CLASSES
class
NmnhVzBirdsDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Birds'";

	function
	NmnhVzBirdsDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$dateVistedFrom = new QueryField;
		$dateVistedFrom->ColName = 'BioDateVisitedFromLocal';
		$dateVistedFrom->ColType = 'date';

		$this->Fields = array
		(	
			$catNumber,
			'CatCollectionName_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeScientificNameLocal_tab',
			'IdeCommonNameLocal_tab',
			$dateVistedFrom,
			'BioOceanLocal',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioParticipantLocal_tab',
			'BioExpeditionNameLocal',
			'ZooSex_tab',
			'ZooStage_tab',
			'ZooPreparation_tab',
			'MeaType_tab',
		);

		$this->Hints = array
		(	

			$catNumber->ColName 			=> '[USNM number]',
			'IdeOrderLocal_tab'			=> '[e.g. Apodiformes]',
			'IdeFamilyLocal_tab'			=> '[e.g. Strigidae; up to 3 leading characters narrows lookup]',
			'IdeCommonNameLocal_tab'               	=> '[N. American species only; up to 3 leading characters narrows lookup]',
			'CitTypeStatus_tab' 			=> '[Select from list]',
			'IdeScientificNameLocal_tab' 		=> '[e.g. Otus asio]',
			'CatCollectionName_tab'			=> '[Select from list, e.g. Types]',
			'CatSpecimenCount'			=> '[e.g. 2]',
			'ZooPreparation_tab' 			=> '[Select from list]',
			'BioOceanLocal' 			=> '[e.g. North Atlantic, Pacific]',
			'BioCountryLocal' 			=> '[Select from list]',
			'BioProvinceStateLocal' 		=> '[e.g. Florida]',
			'BioDistrictCountyShireLocal'	 	=> '[e.g. Montgomery]',
			'BioIslandGroupingLocal'		=> '[Select from list]',
			'BioIslandNameLocal'			=> '[Select from list]',
			'BioExpeditionNameLocal' 		=> '[e.g. Thayer Expedition; up to 3 leading characters narrows lookup]',
			'BioVesselNameLocal' 			=> '[e.g. Albatross]',
			'BioSiteNumberLocal'			=> '[e.g. Z - 22, X054, B212, or 10A]',
			'BioCruiseNumberLocal' 			=> '[e.g. III, VI, Y7102B, or 21]',
			'BioParticipantLocal_tab' 		=> '[e.g. Mearns]',
			'BioDateVisitedFromLocal'		=> '[e.g. format dd-mm-yyyy, partial entry works]',
			'ZooSex_tab'            		=> '[Select from list]',
			'ZooStage_tab'            		=> '[Select from list]',
			'MeaType_tab'            		=> '[Select from list]',
		);

		$this->DropDownLists = array
		(	
			'IdeOrderLocal_tab'			=> 'eluts:Taxonomy[9]',
			'BioCountryLocal' 			=> 'eluts:Continent[2]', 
			'BioIslandGroupingLocal'		=> 'eluts:Island Grouping',
			'BioIslandNameLocal'			=> 'eluts:Island Name',
			'BioOceanLocal' 			=> 'eluts:Ocean[1]',
			'CatCollectionName_tab'			=> '|Types',
			'CitTypeStatus_tab' 			=> 'eluts:Type Status', 
			'ZooPreparation_tab' 			=> 'eluts:Zoology Preparation', 
			'ZooSex_tab' 				=> 'eluts:Zoology Sex',
			'ZooStage_tab' 				=> 'eluts:Zoology Stage',
			'MeaType_tab'            		=> '|Weight',
		);

		$this->LookupLists = array
		(
			'BioExpeditionNameLocal' 		=> 'Expedition Name',
			'IdeFamilyLocal_tab'                    => 'Taxonomy[14]',
			'IdeCommonNameLocal_tab'               	=> 'Common Names',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzMammalsDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Mammals'";

	function
	NmnhVzMammalsDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$dateVistedFrom = new QueryField;
		$dateVistedFrom->ColName = 'BioDateVisitedFromLocal';
		$dateVistedFrom->ColType = 'date';

		$this->Fields = array
		(	
			'CatMuseum',	
			$catNumber,
			'CatObjectType',	
			'CatCollectionName_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeScientificNameLocal_tab',
			$dateVistedFrom,
			'BioOceanLocal',
			'BioSeaGulfLocal',
			'BioCountryLocal',
			'BioIslandNameLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioParticipantLocal_tab',
			'ZooSex_tab',
			'ZooStage_tab',
			'ZooPreparation_tab',
			'VerCollectionMethod',
			'MamSexualMaturity',
			'MamPhysicalMaturity',
			'MamSpecimenCondition',
			'MeaType_tab',
		);

		$this->Hints = array
		(	

			'CatMuseum'			=> '[leave NMNH for our specimens, blank to include non-specimen whale records]',
			$catNumber->ColName 		=> '[USNM number]',
			'CatObjectType'			=> '[Select from list]',
			'CatCollectionName_tab'		=> '[Select from list; e.g. Types or Whale Collection]',
			'IdeOrderLocal_tab'		=> '[Select from list; e.g. Rodentia]',
			'IdeFamilyLocal_tab'		=> '[e.g. Leporidae; up to 3 leading characters narrows lookup]',
			'IdeScientificNameLocal_tab' 	=> '[e.g. Ailurus fulgens]',
			'BioDateVisitedFromLocal'	=> '[e.g. format dd-mm-yyyy, partial entry works]',
			'BioOceanLocal' 		=> '[e.g. North Atlantic, Pacific]',
			'BioSeaGulfLocal' 		=> '[Select from list]',
			'BioCountryLocal' 		=> '[Select from list]',
			'BioIslandNameLocal'		=> '[Select from list]',
			'BioProvinceStateLocal' 	=> '[e.g. Ohio]',
			'BioDistrictCountyShireLocal'	=> '[e.g. Fairfax]',
			'BioParticipantLocal_tab' 	=> '[e.g. Nelson]',
			'ZooSex_tab'            	=> '[Select from list]',
			'ZooStage_tab'            	=> '[Select from list]',
			'ZooPreparation_tab' 		=> '[Select from list]',
			'VerCollectionMethod' 		=> '[Select from list, for whale records only]',
			'MamSexualMaturity'	 	=> '[Select from list, for whale records only]',
			'MamPhysicalMaturity'	 	=> '[Select from list, for whale records only]',
			'MamSpecimenCondition'	 	=> '[Select from list, for whale records only]',
			'MeaType_tab'            	=> '[Select from list]',
		);

		$this->DropDownLists = array
		(	
			'CatMuseum'			=> 'NMNH|',
			'CatObjectType'			=> 'eluts:Object Type[2]',
			'CatCollectionName_tab'		=> '|Types|Whale Collection',
			'IdeOrderLocal_tab'		=> 'eluts:Taxonomy[9]',
			'BioOceanLocal' 		=> 'eluts:Ocean[1]',
			'BioSeaGulfLocal' 		=> 'eluts:Ocean[2]',
			'BioCountryLocal' 		=> 'eluts:Continent[2]', 
			'BioIslandNameLocal'		=> 'eluts:Island Name',
			'ZooSex_tab' 			=> 'eluts:Zoology Sex',
			'ZooStage_tab'            	=> '|Adult|Embryo|Fetus|Immature|Juvenile|Neonate|Nestling|Stillborn|Subadult|Yearling|Young',
			'ZooPreparation_tab' 		=> '|Anatomical|Antler or Horn|Baculum/Baubellum|Baleen|Cast|Fluid|Histological|Mandible|Model|Mounted|Photograph|Skeletal Elements|Skeleton|Skin|Skull|Tissue|Tooth or Tusk', 
			'VerCollectionMethod'		=> '|Capture|Incidental Catch|Sighting|Stranding|Vessel Collision',
			'MamSexualMaturity'            	=> '|Calf|Fetus|Juvenile|Lactating|Mature|Maturing|Neonate|Pregnant|Resting',
			'MamPhysicalMaturity'           => '|Closed|Fused|Open',
			'MamSpecimenCondition'         	=> '|Alive|Dead, advanced decomposition|Dead, condition unknown|Dead, decomposed|Dead, fresh|Dead, moderately decomposed|Old carcass (mummy or skeleton)|Unknown',
			'MeaType_tab'            	=> '|Length|Weight',
		);

		$this->LookupLists = array
		(
			'IdeFamilyLocal_tab'		=> 'Taxonomy[14]',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhVzHerpsDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Amphibians & Reptiles'";

	function
	NmnhVzHerpsDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$dateVistedFrom = new QueryField;
		$dateVistedFrom->ColName = 'BioDateVisitedFromLocal';
		$dateVistedFrom->ColType = 'date';

		$this->Fields = array
		(	
			$catNumber,
			'CatCollectionName_tab',
			'IdeFiledAsFamily',
			'IdeFiledAsQualifiedNameWeb',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
		);

		$this->Hints = array
		(	
			$catNumber->ColName 		=> '[USNM number]',
			'CatCollectionName_tab'		=> '[Select from list, e.g. Type]',
			'IdeFiledAsFamily'		=> '[e.g. Hylidae; up to 3 leading characters narrows lookup]',
			'IdeFiledAsQualifiedNameWeb'	=> '[e.g. Stefania evansi]',
			'BioCountryLocal' 		=> '[Select from list; e.g. United States]',
			'BioProvinceStateLocal' 	=> '[e.g. Florida]',
			'BioDistrictCountyShireLocal' 	=> '[e.g. Brevard]',
		);

		$this->DropDownLists = array
		(	
			'CatCollectionName_tab'		=> '|Type',
			'BioCountryLocal' 		=> 'eluts:Continent[2]', 
		);

		$this->LookupLists = array
		(
			'IdeFiledAsFamily'		=> 'Taxonomy[14]',
		);
	}
} 
//=====================================================================================================
//=====================================================================================================
class
NmnhVzFishesDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Fishes'";

	function
	NmnhVzFishesDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$dateVistedFrom = new QueryField;
		$dateVistedFrom->ColName = 'BioDateVisitedFromLocal';
		$dateVistedFrom->ColType = 'date';

		$this->Fields = array
		(	
			$catNumber,
			'CatCollectionName_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeSubfamilyLocal_tab',
			'IdeFiledAsQualifiedNameWeb',
			'ZooPreparation_tab',
			'BioSiteVisitNumbersLocal_tab',
			'BioVesselNameLocal',
			'BioCruiseNumberLocal',
			'BioSiteNumberLocal',
			'BioExpeditionNameLocal',
			'BioParticipantLocal_tab',
			$dateVistedFrom,
			'BioOceanLocal',
			'BioSeaGulfLocal',
			'BioIslandNameLocal|BioIslandGroupingLocal|BioArchipelagoLocal',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioPreciseLocationLocal',
		);

		$this->Hints = array
		(	

			$catNumber->ColName 		=> '[USNM number]',
			'CatCollectionName_tab'		=> '[Select from list]',
			'IdeOrderLocal_tab'		=> '[Select from list; e.g. Anguilliformes]',
			'IdeFamilyLocal_tab'		=> '[e.g. Congridae; up to 3 leading characters narrows lookup]',
			'IdeSubfamilyLocal_tab'		=> '[Select from list; e.g. Congrinae]',
			'IdeFiledAsQualifiedNameWeb' 	=> '[e.g. Conger oceanicus]',
			'ZooPreparation_tab' 		=> '[Select from list]',
			'BioSiteVisitNumbersLocal_tab' 	=> '[Number typically assigned by collector, identifies collecting site, e.g. MIN 00-54]',
			'BioVesselNameLocal' 		=> '[e.g. Albatross]',
			'BioCruiseNumberLocal' 		=> '[e.g. III, VI, Y7102B, or 21]',
			'BioSiteNumberLocal' 		=> '[Number assigned to a collecting site in association with a specific vessel and cruise number]',
			'BioExpeditionNameLocal' 	=> '[e.g. Albatross Expedition]',
			'BioParticipantLocal_tab' 	=> '[e.g. Jordan, D.S.]',
			'BioDateVisitedFromLocal'	=> '[format dd-mm-yyyy, partial entry works]',
			'BioOceanLocal' 		=> '[Select from list]',
			'BioSeaGulfLocal' 		=> '[e.g. Gulf of Mexico]',
			'BioIslandNameLocal|BioIslandGroupingLocal|BioArchipelagoLocal' 	=> '[e.g. Society Islands or Palmyra Atoll]',
			'BioCountryLocal' 		=> '[Select from list; e.g. United States]',
			'BioProvinceStateLocal' 	=> '[e.g. Florida]',
			'BioDistrictCountyShireLocal'	=> '[e.g. Monroe]',
			'BioPreciseLocationLocal'	=> '[e.g. North end Loggerhead Key]',
		);

		$this->DropDownLists = array
		(	
			'CatCollectionName_tab'		=> '|Types',
			'BioOceanLocal' 		=> 'eluts:Ocean[1]',
			'BioCountryLocal' 		=> 'eluts:Continent[2]', 
			'IdeOrderLocal_tab'	        => 'eluts:Taxonomy[9]',
			'IdeSubfamilyLocal_tab'         => 'eluts:Taxonomy[15]',
			'ZooPreparation_tab' 		=> 'eluts:Zoology Preparation', 
		);

		$this->LookupLists = array
		(
			'IdeFamilyLocal_tab'            => 'Taxonomy[14]',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
