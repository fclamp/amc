<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

class
NmnhIzBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Invertebrate Zoology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata|IdeIdentifiedByLocal_tab',
		'taxonomy' 	=> 'IdeGenusLocal_tab|IdePhylumLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeFamilyLocal_tab',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhIzAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Invertebrate Zoology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata|IdeIdentifiedByLocal_tab',
		'taxonomy' 	=> 'IdeGenusLocal_tab|IdePhylumLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeFamilyLocal_tab',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhIzDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Invertebrate Zoology'";

	function
	NmnhIzDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();
		
		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$dateIdentified = new QueryField;
		$dateIdentified->ColType = 'date';
		$dateIdentified->ColName = 'IdeDateIdentified0';

		$speciminCount = new QueryField;
		$speciminCount->ColType = 'integer';
		$speciminCount->ColName = 'CatSpecimenCount';

		$sitSiteNumber = new QueryField;
		$sitSiteNumber->ColName = 'BioSiteNumberLocal';
		
		$dateFrom = new QueryField;
                $dateFrom->ColName = 'BioDateVisitedFromLocal';
                $dateFrom->ColType = 'date';

		$depthFrom = new QueryField;
		$depthFrom->ColName = 'BioDepthFromMet';
		$depthFrom->ColType = 'float';

		$depthTo = new QueryField;
		$depthTo->ColName = 'BioDepthToMet';
		$depthTo->ColType = 'float';

		$this->Fields = array
		(	
			$catNumber,
			'IdePhylumLocal_tab',
			'IdeClassLocal_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeQualifiedName_tab',
			'IdeCommonNameLocal_tab',
			'CitTypeStatus_tab',
			'IdeIdentifiedByLocal_tab',
			$dateIdentified,
			'CatCollectionName_tab',
			$speciminCount,
			'ZooPreparation_tab',
			'ZooSex_tab',
			'ZooStage_tab',
			'BioOceanLocal',
			'BioSeaGulfLocal',
			'BioBaySoundLocal',
			$depthFrom,
			$depthTo,	
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioTownshipLocal',
			'BioPreciseLocationLocal',
			'BioExpeditionNameLocal',
			'BioRiverBasinLocal',
			'BioVesselNameLocal',
			$sitSiteNumber,
			'BioCruiseNumberLocal',
			'BioParticipantLocal_tab',
			$dateFrom,
			'ColCollectionMethod',
		);
		

		$this->Hints = array
		(	
			'CatNumber'				=> '[AKA: USNM number]',
			'IdeQualifiedName_tab' 			=> '[e.g. Amphiblestrum osburni Powell]',
			'IdeCommonNameLocal_tab'		=> '[e.g. Corals; up to 3 leading characters narrows lookup]',
			'IdePhylumLocal_tab'    		=> '[e.g. Bryozoa]',
			'IdeClassLocal_tab'             	=> '[e.g. Maxillopoda]',
			'IdeOrderLocal_tab'             	=> '[e.g. Decapoda]',
			'IdeFamilyLocal_tab'            	=> '[e.g. Cambaridae]',
			'CitTypeStatus_tab' 			=> '[Select from list]',
			'IdeScientificNameLocal_tab'    	=> '[e.g. Cambarus sphenoides]',
			'IdeFiledAsName' 			=> '[e.g. Amphiblestrum osburni Powell]',
			'IdeIdentifiedByLocal_tab' 		=> '[eg. Bouchard]',
			'IdeDateIdentified0'			=> '[e.g. format dd-mm-yyyy, partial entry works]',
			'CatCollectionName_tab'			=> '[Up to 3 leading characters narrows lookup]',
			'CatSpecimenCount'			=> '[e.g. 2]',
			'ZooPreparation_tab' 			=> '[Select from list]',
			'BioOceanLocal'             		=> '[e.g. North Atlantic, Pacific]',
			'BioSeaGulfLocal'   			=> '[e.g. Gulf of Mexico]',
			'BioBaySoundLocal'   			=> '[e.g. Batteaux Bay]',
			'BioDepthFromMet'   			=> '[e.g. 39]',
			'BioDepthToMet'   			=> '[e.g. 39]',
			'BioCountryLocal'        		=> '[Select from list]',
			'BioProvinceStateLocal' 		=> '[e.g. Florida]',
			'BioDistrictCountyShireLocal' 		=> '[e.g. Montgomery]',
			'BioTownshipLocal'			=> '[Select from list]',
			'BioPreciseLocationLocal'		=> '[e.g. Edge Of Pond]',
			'BioIslandGroupingLocal'        	=> '[Select from list]',
			'BioIslandNameLocal'            	=> '[Select from list]',
			'BioExpeditionNameLocal'        	=> '[e.g. U.S. Navy Expedition; up to 3 leading characters narrows lookup]',
			'BioVesselNameLocal'    		=> '[e.g. Albatross; up to 3 leading characters narrows lookup]',
			'BioSiteNumberLocal'            	=> '[e.g. Z - 22, X054, B212, or 10A]',
			'BioCruiseNumberLocal'  		=> '[e.g. III, VI, Y7102B, or 21]',
			'BioRiverBasinLocal' 			=> '[Up to 3 leading characters narrows lookup]',
			'ZooSex_tab'				=> '[Select from list]',
			'ZooStage_tab'				=> '[Select from list]',
			'BioParticipantLocal_tab' 		=> '[e.g. Bouchard]',
			'BioDateVisitedFromLocal'		=> '[e.g. format dd-mm-yyyy, partial entry works]',
			'ColCollectionMethod' 			=> '[e.g. Triangle Dredge; up to 3 leading characters narrows lookup]',
		);

		$this->DropDownLists = array
		(	
			'BioCountryLocal' 			=> 'eluts:Continent[2]',
			'BioTownshipLocal'			=> 'eluts:Township',
			'CitTypeStatus_tab' 			=> 'eluts:Type Status',
			'ZooPreparation_tab' 			=> 'eluts:Zoology Preparation',
			'ZooSex_tab' 				=> 'eluts:Zoology Sex',
			'ZooStage_tab' 				=> 'eluts:Zoology Stage',
		);

		$this->LookupLists = array
		(
			'CatCollectionName_tab' 		=> 'Collection Name[6]',
			'BioExpeditionNameLocal' 		=> 'Expedition Name',
			'ColCollectionMethod' 			=> 'Collection Method',
			'BioVesselNameLocal' 			=> 'Vessel Name',
			'BioRiverBasinLocal' 			=> 'River Basin',
			'IdeCommonNameLocal_tab'		=> 'Common Names',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
