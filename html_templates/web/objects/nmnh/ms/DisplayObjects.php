<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
** This file contains the following classes.
**	NmnhMsStandardDisplay - General display
**	NmnhMsGemStandardDisplay - For Gems & Minerals records
**	NmnhMsPetStandardDisplay - For Petrology & Volcanology records
**	NmnhMsMetStandardDisplay - For Meteorite records
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/nmnh/NmnhDisplayObjects.php');

//=====================================================================================================
//=====================================================================================================
class
NmnhMsStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhMsStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeTaxonRef:1->etaxonomy->ClaSpecies';

                // START - Catalog Number
                $catNumber = new FormatField;
                $catNumber->Name = 'Catalog Number';
                $catNumber->Format = $this->BuildCatalogNumberFormat();
                // END - Catalog Number

		// START - Identification
                $taxonSumData = new Field;
                $taxonSumData->ColName = 'IdeTaxonRef_tab->etaxonomy->ClaSpecies';

                $qualifier = new Field;
                $qualifier->ColName = 'IdeQualifier_tab';

                $namedPart = new Field;
                $namedPart->ColName = 'IdeNamedPart_tab';

		$identificationDetails = new Table;
		$identificationDetails->Name = 'IdeTaxonRef_tab->etaxonomy->ClaSpecies';
		$identificationDetails->Headings = array('', 'Qualifier', 'Named Part');
		$identificationDetails->Columns = array($taxonSumData, $qualifier, $namedPart);
		// END - Identification
		

		// START Mineral Weight
		$minWeight = new FormatField;
		$minWeight->Format = "{MeaCurrentWeight} {MeaCurrentUnit}";
		$minWeight->Name = "MeaCurrentWeight";
		// END Mineral Weight

		// START - Meteorite details
		$meteoriteName = new Field;
		$meteoriteName->ColName = 'MetMeteoriteName';

		$meteoriteType = new Field;
		$meteoriteType->ColName = 'MetMeteoriteType';

		$meteorite = new Table;
		$meteorite->Name = 'MetMeteoriteName';
		$meteorite->Headings = array('', 'Type');
		$meteorite->Columns = array($meteoriteName, $meteoriteType);
		// END - Meteorite details

		$this->Fields = array
		(
			'IdeTaxonRef:1->etaxonomy->ClaSpecies',
			$catNumber,
			'CatDivision',
			'CatCollectionName_tab',
			$identificationDetails,
			'ZooPreparation_tab',
			'BioEventSiteRef->ecollectionevents->LocOcean',
			'BioEventSiteRef->ecollectionevents->LocSeaGulf',
                        'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'BioEventSiteRef->ecollectionevents->LocMineName',
			'BioEventSiteRef->ecollectionevents->LocMiningDistrict',
			'MinColor_tab',
			'MinCut',
			$minWeight,
			//Meteorites
			$meteorite,
			//Volcanology & Petrology
			'BioEventSiteRef->ecollectionevents->VolVolcanoName',
			'PetLavaSource',
			'PetEruptionDate',
			'PetFlowTephra',
			'PetFlowTephraDate',
			'PetCommodityMetal_tab',
		);
	}
}

//=====================================================================================================
//=====================================================================================================
class
NmnhMsGemStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhMsGemStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeTaxonRef:1->etaxonomy->ClaSpecies';

		// cat number 
		$catNumberFormat = new FormatField;
		$catNumberFormat->Format = "{CatPrefix} {CatNumber} {CatSuffix}";
		$catNumberFormat->Name = "CatNumber";
		// end cat number 

		// identification list
		$ideTaxon = new Field;
		$ideTaxon->ColName = 'IdeTaxonRef_tab->etaxonomy->ClaSpecies';

		$ideQualifier = new Field;
		$ideQualifier->ColName = 'IdeQualifier_tab';

		$ideNamedPart = new Field;
		$ideNamedPart->ColName = 'IdeNamedPart_tab';

		$ideIdentifiedBy = new Field;
		$ideIdentifiedBy->ColName = 'IdeIdentifiedByRef_tab->eparties->NamBriefName';

		$ideTexture = new Field;
		$ideTexture->ColName = 'IdeTextureStructure_tab';

		$ideIdentificationList = new Table;
		$ideIdentificationList->Name = 'Identification List';
		$ideIdentificationList->Headings = array('Taxon', 'Qualifier', 'Named Part', 'Id By', 'Texture/Structure');
		$ideIdentificationList->Columns = array($ideTaxon, $ideQualifier, $ideNamedPart, $ideIdentifiedBy, $ideTexture);
		// end 

		// Identified by
		$ideFiledAsIdentBy = new FormatField;
		$ideFiledAsIdentBy->Name = 'IdeIdentifiedByRefLocal_tab';
		$ideFiledAsIdentBy->Format = '{IdeFiledAsRef->eparties->NamBriefName} {IdeFiledAsRef->eparties->NamOrganisation}';
		// end Identified by

		// Citations
		$citTypeStatus = new Field;
		$citTypeStatus->ColName = 'CitTypeStatus_tab';

		$citTaxonRefLocal = new Field;
		$citTaxonRefLocal->ColName = 'IdeScientificNameLocal_tab';

		$typeCitations = new Table;
		$typeCitations->Name = 'TypeCitations';
		$typeCitations->Columns = array($citTypeStatus, $citTaxonRefLocal);
		// end Citations


		// Other identifications name
		$ideOtherQualifiedName = new Field;
		$ideOtherQualifiedName->ColName = 'IdeOtherQualifiedNameWeb_tab';

		$ideDateIdentified = new Field;
		$ideDateIdentified->ColName = 'IdeOtherDateIdentifiedWeb0';

		$ideIdentifiedBy = new Field;
		$ideIdentifiedBy->ColName = 'IdeOtherIdentifiedByWebRef_tab->eparties->NamBriefName';

		$otherIdentTable = new Table;
		$otherIdentTable->Name = 'IdeOtherQualifiedName_tab';
		$otherIdentTable->Headings = array('Identification', 'Date Identified', 'Identified By');
		$otherIdentTable->Columns = array($ideOtherQualifiedName, $ideDateIdentified, $ideIdentifiedBy);
		// end Other identifications name

		// Specimen Count
		$catSpecimenCount = new Field;
		$catSpecimenCount->ColName = 'CatSpecimenCount';

		$catSpecimenCountMod = new Field;
		$catSpecimenCountMod->ColName = 'CatSpecimenCountModifier';

		$specimenCountTable = new Table;
		$specimenCountTable->Name = 'SpecCount';
		$specimenCountTable->Headings = array('', '');
		$specimenCountTable->Columns = array($catSpecimenCount, $catSpecimenCountMod);
		// end Specimen Count

		$dateCollected = new FormatField;
		$dateCollected->Name = 'DateCollected';
		$dateCollected->Format = $this->BuildDateCollectedFormat();

		$minWeight = new FormatField;
		$minWeight->Format = "{MeaCurrentWeight} {MeaCurrentUnit}";
		$minWeight->Name = "MeaCurrentWeight";

		// START Other Numbers
		$otherNumbersType = new Field;
		$otherNumbersType->ColName = 'CatOtherNumbersType_tab';

		$otherNumbersValue = new Field;
		$otherNumbersValue->ColName = 'CatOtherNumbersValue_tab';

		$otherNumbersTable = new Table;
		$otherNumbersTable->Name = 'OtherNumbers';
		$otherNumbersTable->Headings = array('Type', 'Value');
		$otherNumbersTable->Columns = array($otherNumbersType, $otherNumbersValue);
		// END Other Numbers

		$this->Fields = array
		(
			'IdeTaxonRef:1->etaxonomy->ClaSpecies',
			$catNumberFormat,
			'CatCollectionName_tab',
			$specimenCountTable,
			$ideIdentificationList,
			$typeCitations,
			'IdeTaxonRef_tab->etaxonomy->AutCombAuthorString',
			$ideFiledAsIdentBy, 
			$otherIdentTable,
			$dateCollected, 
			'BioEventSiteRef->ecollectionevents->LocOcean',
                        'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocSeaGulf',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'MinDescribedFigured_tab',
			'BibBibliographyRef_tab->ebibliography->SummaryData', 	
			$otherNumbersTable,
			'MinName',
			$minWeight,
			'MinJeweleryType',
			'MinCut',
			'MinColor_tab',
			'MinCutByRef->eparties->SummaryData',
			'MinMakerRef->eparties->SummaryData',
			'MinSynonyms_tab',
			'MinMicroprobed',
			'MinXRayed',
			'MinSynthetic',
			'MinChemicalModifier',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhMsPetStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhMsPetStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeTaxonRef:1->etaxonomy->ClaSpecies';

		// cat number 
		$catNumberFormat = new FormatField;
		$catNumberFormat->Format = "{CatPrefix} {CatNumber} {CatSuffix}";
		$catNumberFormat->Name = "CatNumber";
		// end cat number 

		// identification list
		$ideTaxon = new Field;
		$ideTaxon->ColName = 'IdeTaxonRef_tab->etaxonomy->ClaSpecies';

		$ideQualifier = new Field;
		$ideQualifier->ColName = 'IdeQualifier_tab';

		$ideNamedPart = new Field;
		$ideNamedPart->ColName = 'IdeNamedPart_tab';

		$ideIdentifiedBy = new Field;
		$ideIdentifiedBy->ColName = 'IdeIdentifiedByRef_tab->eparties->NamBriefName';

		$ideTexture = new Field;
		$ideTexture->ColName = 'IdeTextureStructure_tab';

		$ideIdentificationList = new Table;
		$ideIdentificationList->Name = 'Identification List';
		$ideIdentificationList->Headings = array('Taxon', 'Qualifier', 'Named Part', 'Id By', 'Texture/Structure');
		$ideIdentificationList->Columns = array($ideTaxon, $ideQualifier, $ideNamedPart, $ideIdentifiedBy, $ideTexture);
		// end 

		// Specimen Count
		$catSpecimenCount = new Field;
		$catSpecimenCount->ColName = 'CatSpecimenCount';

		$catSpecimenCountMod = new Field;
		$catSpecimenCountMod->ColName = 'CatSpecimenCountModifier';

		$specimenCountTable = new Table;
		$specimenCountTable->Name = 'SpecCount';
		$specimenCountTable->Headings = array('', '');
		$specimenCountTable->Columns = array($catSpecimenCount, $catSpecimenCountMod);
		// end Specimen Count

		$dateCollected = new FormatField;
		$dateCollected->Name = 'DateCollected';
		$dateCollected->Format = $this->BuildDateCollectedFormat();

		// Eruption details
		$erupDate = new Field;
		$erupDate->ColName = 'PetEruptionDate';

		$erupTime = new Field;
		$erupTime->ColName = 'PetEruptionTime';

		$erupZone = new Field;
		$erupZone->ColName = 'PetEruptionTimeZone';

		$erupDetails = new Table;
		$erupDetails->Name = 'ErupDetails';
		$erupDetails->Headings = array('Date', 'Time','Zone');
		$erupDetails->Columns = array($erupDate, $erupTime, $erupZone);

		// Flow details
		$flowDate = new Field;
		$flowDate->ColName = 'PetFlowTephraDate';

		$flowTime = new Field;
		$flowTime->ColName = 'PetFlowTephraTime';

		$flowZone = new Field;
		$flowZone->ColName = 'PetFlowTephraTimeZone';

		$flowDetails = new Table;
		$flowDetails->Name = 'FlowTephraDetails';
		$flowDetails->Headings = array('Date', 'Time','Zone');
		$flowDetails->Columns = array($flowDate, $flowTime, $flowZone);

		// petrology prep details 
		$zooPrep = new Field;
		$zooPrep->ColName = 'ZooPreparation_tab';

		$zooPrepBy = new Field;
		$zooPrepBy->ColName = 'ZooPreparedByRef_tab->eparties->SummaryData';

		$zooCount = new Field;
		$zooCount->ColName = 'ZooPreparationCount_tab';

		$zooRem = new Field;
		$zooRem->ColName = 'ZooPreparationRemarks_tab';

		$zooPrepDetails = new Table;
		$zooPrepDetails->Name = 'ZooPreparation_tab';
		$zooPrepDetails->Headings = array('', 'Prepared By', 'Count', 'Remarks');
		$zooPrepDetails->Columns = array($zooPrep, $zooPrepBy, $zooCount, $zooRem);
		// end 

		// geolithic age details 
		$ageSystem = new Field;
		$ageSystem->ColName = 'AgeGeologicAgeSystem_tab';

		$ageSeries = new Field;
		$ageSeries->ColName = 'AgeGeologicAgeSeries_tab';

		$ageStage = new Field;
		$ageStage->ColName = 'AgeGeologicAgeStage_tab';

		$ageAuthority = new Field;
		$ageAuthority->ColName = 'AgeGeologicAgeAuthorityRef_tab->eparties->SummaryData';

		$geoAgeDetails = new Table;
		$geoAgeDetails->Name = 'GeoAgeDetails';
		$geoAgeDetails->Headings = array('System', 'Series', 'Stage', 'Authority');
		$geoAgeDetails->Columns = array($ageSystem, $ageSeries, $ageStage, $ageAuthority);
		// end 


		// stratigraphy details 
		$stratGroup = new Field;
		$stratGroup->ColName = 'AgeStratigraphyGroup_tab';

		$stratFormation = new Field;
		$stratFormation->ColName = 'AgeStratigraphyFormation_tab';

		$stratMember = new Field;
		$stratMember->ColName = 'AgeStratigraphyMember_tab';

		$stratAuth = new Field;
		$stratAuth->ColName = 'AgeStratigraphyAuthorityRef_tab->eparties->SummaryData';

		$geoStratDetails = new Table;
		$geoStratDetails->Name = 'AgeStratigraphyGroup_tab';
		$geoStratDetails->Headings = array('Group', 'Formation', 'Member', 'Authority');
		$geoStratDetails->Columns = array($stratGroup, $stratFormation, $stratMember, $stratAuth);
		// end 

		// START Collection Name
		$collName = new Field;
		$collName->Name = 'Collection Name';
		$collName->ColName = 'CatCollectionName_tab';
		// END Collection Name

		// START Other Numbers
		$otherNumbersType = new Field;
		$otherNumbersType->ColName = 'CatOtherNumbersType_tab';

		$otherNumbersValue = new Field;
		$otherNumbersValue->ColName = 'CatOtherNumbersValue_tab';

		$otherNumbersTable = new Table;
		$otherNumbersTable->Name = 'OtherNumbers';
		$otherNumbersTable->Headings = array('Type', 'Value');
		$otherNumbersTable->Columns = array($otherNumbersType, $otherNumbersValue);
		// END Other Numbers

		$this->Fields = array
		(
			'IdeTaxonRef:1->etaxonomy->ClaSpecies',
			$catNumberFormat,
			$collName,
			$specimenCountTable,
			$ideIdentificationList,
			$dateCollected, 
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'BioEventSiteRef->ecollectionevents->LocOcean',
                        'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocSeaGulf',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
                        'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BibBibliographyRef_tab->ebibliography->SummaryData', 	
			$otherNumbersTable,
			'BioEventSiteRef->ecollectionevents->VolVolcanoName',
			'PetLavaSource',
			'PetFlowTephra',
			$erupDetails,
			$flowDetails,
			$zooPrepDetails,
			'PetChemicalAnalysisRef_tab->enmnhanalysis->SummaryData',
			'MinColor_tab',
			'PetCommodityMetal_tab',
			$geoAgeDetails,
			$geoStratDetails,
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhMsMetStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhMsMetStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'MetMeteoriteName';

		// cat number 
		$catNumberFormat = new FormatField;
		$catNumberFormat->Format = "{CatPrefix} {CatNumber} {CatSuffix}";
		$catNumberFormat->Name = "CatNumber";
		// end cat number 

		// current weight
		$minWeight = new FormatField;
		$minWeight->Format = "{MeaCurrentWeight} {MeaCurrentUnit}";
		$minWeight->Name = "MeaCurrentWeight";
		// end current weight

		$this->Fields = array
		(
			'MetMeteoriteName',
			$catNumberFormat,
			'CatCollectionName_tab',
                        'BioEventSiteRef->ecollectionevents->LocCountry',
                        'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
			'MetMeteoriteName',
			'MetSynonym',
			'MetMeteoriteType',
			'MetFindFall',
			$minWeight,
                        'AdmDateModified',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
