<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

class
NmnhMsBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Mineral Sciences'";

	var $Options = array
	(		
		'any' 		=> 'AdmWebMetadata|SummaryData',
		'name' 		=> 'MinName',
		'place' 	=> 'BioCountryLocal|BioProvinceStateLocal',
		'number' 	=> 'CatNumber',
	);
} 
//=====================================================================================================
//=====================================================================================================
class
NmnhMsAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Mineral Sciences'";

	var $Options = array
	(		
		'any' 		=> 'AdmWebMetadata|SummaryData',
		'name' 		=> 'MinName',
		'place' 	=> 'BioCountryLocal|BioProvinceStateLocal',
		'number' 	=> 'CatNumber',
	);
} 
//=====================================================================================================
//=====================================================================================================
class
NmnhMsDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Mineral Sciences'";

	function
	NmnhMsDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$minWeight = new QueryField;
		$minWeight->ColName = 'MeaCurrentWeight';
		$minWeight->ColType = 'integer';

		$this->Fields = array
		(	
			'IdeTaxonLocal_tab',
			'MinColor_tab',
			'MinCut',
			'BioVolcanoNameLocal',
			'PetCommodityMetal_tab',
			'MetMeteoriteName',
			'MetMeteoriteType',
			'BioOceanLocal',
			'BioSeaGulfLocal',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioMiningDistrictLocal',
			'BioMineNameLocal',
			'BioExpeditionNameLocal',
			'ZooPreparation_tab',
			$minWeight,
			'MeaCurrentUnit',
			$catNumber,
			'CatDivision',
			'CatCollectionName_tab',
		);

		$this->Hints = array
		(	
			'CatNumber'					=> '[e.g. 12345]',
			'CatDivision'					=> '[Select from list]',
			'CatCollectionName_tab'				=> '[Select from list]',
			'IdeTaxonLocal_tab'				=> '[e.g. Basalt]',
			'ZooPreparation_tab' 				=> '[Select from list, Petrology & Volcanology only]',
			'BioOceanLocal' 				=> '[Select from list]',
			'BioSeaGulfLocal' 				=> '[e.g. Gulf of Mexico]',
			'BioCountryLocal' 				=> '[Select from list]',
			'BioProvinceStateLocal' 			=> '[e.g. Florida]',
			'BioDistrictCountyShireLocal'	 		=> '[e.g. Montgomery]',
			'BioExpeditionNameLocal' 			=> '[e.g. U.S. Navy Expedition]',
			'BioMineNameLocal' 				=> '[Select from list; up to 3 leading characters narrows lookup]',
			'BioMiningDistrictLocal' 			=> '[Select from list]',
			'MinColor_tab'					=> '[Select from list or enter color; e.g. red, brown, green, yellow, etc.]',
			'MinCut'					=> '[Select from list]',
			'MeaCurrentWeight'				=> '[Meteorite pieces or gems]',
			'MeaCurrentUnit'				=> '[Select from list]',
			'MetMeteoriteType'				=> '[Select from list]',
			'MetMeteoriteName'				=> '[e.g. Allende]',
			'BioVolcanoNameLocal' 				=> '[Select from list]',
			'PetCommodityMetal_tab' 			=> '[Select from list]',
		);

		$this->DropDownLists = array
		(	
			'CatDivision' 					=> '|Gems & Minerals|Meteorites|Petrology & Volcanology', 
			'CatCollectionName_tab' 			=> 'eluts:Collection Name[6]', 
			'ZooPreparation_tab' 				=> 'eluts:Zoology Preparation', 
			'BioOceanLocal' 				=> 'eluts:Ocean', 
			'BioCountryLocal' 				=> 'eluts:Continent[2]',
			'BioMiningDistrictLocal' 			=> 'eluts:Mining District', 
			'MeaCurrentUnit' 				=> 'eluts:Standardized Unit', 
			'MetMeteoriteType' 				=> 'eluts:Meteorite Type', 
			'PetCommodityMetal_tab' 			=> 'eluts:Commodity Metal', 
			'MinCut' 					=> 'eluts:Mineral Cut', 
			'BioVolcanoNameLocal' 				=> 'eluts:Volcano Region Name[3]', 
			'BioExpeditionNameLocal'                        => 'eluts:Expedition Name',
		);

		$this->LookupLists = array
		(
			'MinColor_tab' 					=> 'Minerals Color[2]', 
			'BioMineNameLocal' 				=> 'Mine Name', 
		);
	}
} 
//=====================================================================================================
//=====================================================================================================
?>

