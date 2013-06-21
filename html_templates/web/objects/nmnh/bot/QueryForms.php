<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

class
NmnhBotanyBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'US' AND CatDepartment = 'Botany'";
	var $Options = array
	(	
		'any' 		=> 'SummaryData|AdmWebMetadata|IdeQualifiedName_tab|BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'taxonomy' 	=> 'IdeGenusLocal_tab|IdePhylumLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeFamilyLocal_tab|CitTypeStatus_tab|IdeSpeciesLocal_tab|IdeQualifiedName_tab',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal|BioPreciseLocationLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhBotanyAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'US' AND CatDepartment = 'Botany'";
	var $Options = array
	(
		'any' 		=> 'SummaryData|AdmWebMetadata|IdeQualifiedName_tab|BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
		'taxonomy' 	=> 'IdeGenusLocal_tab|IdePhylumLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeFamilyLocal_tab|CitTypeStatus_tab|IdeSpeciesLocal_tab|IdeQualifiedName_tab',
		'place' 	=> 'BioOceanLocal|BioSeaGulfLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioIslandGroupingLocal|BioIslandNameLocal|BioPreciseLocationLocal',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhBotanyDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'US' AND CatDepartment = 'Botany'";
	
	function
	NmnhBotanyDetailedQueryForm()
	{
		global $ALL_REQUEST;

		$this->BaseDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$datefrom = new QueryField;
		$datefrom->ColName = 'BioDateVisitedFromLocal';
		$datefrom->ColType = 'date';

		$this->Fields = array
		(	
			'CatBarcode',
			$catNumber,
			'CatCatalog',
			'CatCollectionName_tab',
			'IdePhylumLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeSubfamilyLocal_tab',
			'IdeQualifiedName_tab',
			'BioPrimaryCollectorLocal',
			'BioParticipantLocal_tab',
			'BioPrimaryCollNumber',
			$datefrom,
			'BioBiogeographicalRegionLocal',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioPreciseLocationLocal',
			'BioIslandNameLocal',
		);

		$this->Hints = array
		(	
			'CatBarcode'					=> '[e.g. 00012345]',
			'CatNumber'					=> '[Sheet or Greenhouse accession number]',
			'CatCatalog'					=> '[Select a database subset, please include other fields to refine search]',
			'CatCollectionName_tab'				=> '[Type specimens or other special collection; Select from list]',
			'IdePhylumLocal_tab'				=> '[For Algae only]',
			'IdeFamilyLocal_tab'				=> '[Enter value or use lookup button; up to 3 leading characters narrows lookup]',
			'IdeSubfamilyLocal_tab'				=> '[Poaceae & Fabaceae only]',
			'IdeQualifiedName_tab'				=> '[e.g.: Acer rubrum OR Acer OR rubrum]',
			'IdeFiledAs_tab'				=> '[Select from list]',
			'CitTypeStatus_tab'				=> '[Select from list]',
			'BioPrimaryCollectorLocal'			=> '[e.g. Jones]',
			'BioParticipantLocal_tab'			=> '[e.g. Smith]',
			$datefrom->ColName				=> '[format dd-mm-yyyy, mm-yyyy OR yyyy]',
			'BioPrimaryCollNumber'				=> '[e.g. 224]',
			'BioBiogeographicalRegionLocal'			=> '[Select from list]',
			'BioCountryLocal'				=> '[Select from list]',
			'BioProvinceStateLocal'				=> '[First political subdivision]',
			'BioDistrictCountyShireLocal'			=> '[Second political subdivision]',
			'BioPreciseLocationLocal'			=> '[e.g. Miami]',
			'BioIslandNameLocal'				=> '[Enter value or use lookup button; up to 3 leading characters narrows lookup]',
		);

		$this->DropDownLists = array
		(
			'CatCatalog'					=> '|Algae|Bryophytes and Lichens|Diatoms|Dinoflagellates|Flowering Plants and Ferns|Greenhouse',
			'IdePhylumLocal_tab'				=> 'eluts:Taxonomy[3]',
			'IdeSubfamilyLocal_tab'				=> 'eluts:Taxonomy[15]',
			'IdeFiledAs_tab'				=> 'eluts:YesNo',
			'CitTypeStatus_tab'				=> 'eluts:Type Status',
			'BioBiogeographicalRegionLocal'			=> 'eluts:Biogeography Region',
			'BioCountryLocal'				=> 'eluts:Continent[2]',
		);

		if (isset($ALL_REQUEST['collection']))
		{
			if (strtolower($ALL_REQUEST['collection']) == "dcflora")
			{
				$this->DropDownLists['CatCollectionName_tab'] = 'DC Flora||Type Register|Wilkes Exploring Expedition|Wood Collection';
			}
			else if (strtolower($ALL_REQUEST['collection']) == "type")
			{
				$this->DropDownLists['CatCollectionName_tab'] = 'Type Register||DC Flora|Wilkes Exploring Expedition|Wood Collection';
			}
			else if (strtolower($ALL_REQUEST['collection']) == "wilkes")
			{
				$this->DropDownLists['CatCollectionName_tab'] = 'Wilkes Exploring Expedition||DC Flora|Type Register|Wood Collection';
			}
			else if (strtolower($ALL_REQUEST['collection']) == "wood")
			{
				$this->DropDownLists['CatCollectionName_tab'] = 'Wood Collection||DC Flora|Type Register|Wilkes Exploring Expedition';
			}
		}

		if (! isset($this->DropDownLists['CatCollectionName_tab']))
		{
			$this->DropDownLists['CatCollectionName_tab'] = '|DC Flora|Type Register|Wilkes Exploring Expedition|Wood Collection';
		}

		$this->LookupLists = array
		(
			'IdeFamilyLocal_tab'				=> 'Taxonomy[14]',
			'BioIslandNameLocal'				=> 'Island Name',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
