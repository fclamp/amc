<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/nmnh/NmnhDisplayObjects.php');

//=====================================================================================================
//=====================================================================================================
class
NmnhIzStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhIzStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsQualifiedNameWeb';

		// START - Identified By
		$filedAsIdentBy = new FormatField;
		$filedAsIdentBy->Name = 'IdeFiledAsIdentifiedByRef';
		if (filled('IdeFiledAsIdentifiedByRef', 'ecatalogue', $this->IRN))
		{
			$filedAsIdentByRef = get('IdeFiledAsIdentifiedByRef', 'ecatalogue', $this->IRN);
			if (filled('NamOrganisation', 'eparties', $filedAsIdentByRef))
			{ 
				$filedAsIdentBy->Format = '{IdeFiledAsIdentifiedByRef->eparties->NamBriefName}';
				$filedAsIdentBy->Format .= ', ';
				$filedAsIdentBy->Format .= '{IdeFiledAsIdentifiedByRef->eparties->NamOrganisation}';
			}
			else
			{
				$filedAsIdentBy->Format = '{IdeFiledAsIdentifiedByRef->eparties->NamBriefName}';
			}
		}
		// END - Identified By

		// START - Type Citations
		$citationTaxonName = new Field;
		$citationTaxonName->Name = 'CitTaxonRef_tab->etaxonomy->WebScientificName';
		$citationTaxonName->ColName = 'CitTaxonRef_tab->etaxonomy->WebScientificName';

		$citationTypeStatus = new Field;
		$citationTypeStatus->ColName = 'CitTypeStatus_tab';

		$typeCitations = new Table;
		$typeCitations->Headings = array('', '');
		$typeCitations->Name = 'TypeCitations';
		$typeCitations->Columns = array($citationTaxonName, $citationTypeStatus);
		// END - Type Citations

		// START - Other Qualified Names
		/*$otherQualifiedName = new Field;
		$otherQualifiedName->ColName = 'IdeOtherQualifiedNameWeb_tab';

		$ideDateIdentified = new Field;
		$ideDateIdentified->ColName = 'IdeOtherDateIdentifiedWeb0';

		$ideIdentifiedBy = new Field;
		$ideIdentifiedBy->ColName = 'IdeOtherIdentifiedByWebRef_tab->eparties->NamBriefName';

		$otherIdentTable = new Table;
		$otherIdentTable->Name = 'IdeOtherQualifiedNameWeb_tab'; */
		$otherIdentTable->Headings = array('Identification', 'Date Identified', 'Identified By');
		$otherIdentTable->Columns = array($otherQualifiedName, $ideDateIdentified, $ideIdentifiedBy);
		// END - Other Qualified Names

		// START - Zoo Sex Table
		$sexStageCount = new Field;
		$sexStageCount->ColName = 'ZooSexStageCount_tab';

		$sexStageModifier = new Field;
		$sexStageModifier->ColName = 'ZooSexStageModifier_tab';

		$sex = new Field;
		$sex->ColName = 'ZooSex_tab';

		$stage = new Field;
		$stage->ColName = 'ZooStage_tab';

		$sexStageTable = new Table;
		$sexStageTable->Name = 'SexAndStage';
		$sexStageTable->Headings = array('Count', 'Modifier', 'Sex', 'Stage');
		$sexStageTable->Columns = array($sexStageCount, $sexStageModifier, $sex, $stage);
		// END - Zoo Sex Table

		// START - Specimen Count
		$specimenCountTable = new FormatField;
		$specimenCountTable->Name = 'ObjectCount';
		$specimenCountTable->Format = '{CatSpecimenCount} {CatSpecimenCountModifier}';
		// END - Specimen Count
		
		// START - Date Visited
			$dateCollected = new FormatField;
			$dateCollected->Name = 'Date Collected';
		$dateCollected->Format = $this->BuildDateCollectedFormat();
		// END - Date Visited

		// START - Depth
			$aquDepth = new FormatField;
			$aquDepth->Name = 'Depth(m)';
		$aquDepth->Format = $this->BuildDepthFormat();
		// END - Depth

		// START - Common Name
			$commonName = new FormatField;
			$commonName->Name = 'Common Name(s)';
			$commonName->Format = $this->BuildCommonNameFormat();
		// END - Common Name

		// START - Catalog Number
		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber} {CatSuffix}';
		$catNumber->Name = 'CatNumber';
		// END - Catalog Number

		$this->Fields = array
		(
			'IdeFiledAsQualifiedNameWeb',
			$catNumber,
			'IdeFiledAsQualifiedNameWeb',
			$commonName,
			'CatCollectionName_tab',
			$filedAsIdentBy,
			'IdeFiledAsDateIdentified',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsRef->etaxonomy->ClaOrder',
			'IdeFiledAsRef->etaxonomy->ClaClass',
			'IdeFiledAsRef->etaxonomy->ClaPhylum',
			'IdeFiledAsRef->etaxonomy->ComName_tab',
			$otherIdentTable, 		
			$typeCitations,
			$specimenCountTable,
			$sexStageTable,
			'ZooPreparation_tab',
			$dateCollected,
			'ColCollectionMethod',
			'BioEventSiteRef->ecollectionevents->AquVesselName',
			'BioEventSiteRef->ecollectionevents->AquCruiseNumber',
			'BioEventSiteRef->ecollectionevents->ExpExpeditionName',
			'ColParticipantRef_tab->eparties->NamFullName',
			'BioEventSiteRef->ecollectionevents->LocSiteStationNumber',
			'BioEventSiteRef->ecollectionevents->LocOcean',
			'BioEventSiteRef->ecollectionevents->LocSeaGulf',
			'BioEventSiteRef->ecollectionevents->LocBaySound',
			'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
			'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocTownship',
			'BioEventSiteRef->ecollectionevents->LocNearestNamedPlace',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->AquRiverBasin',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatDec',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongDec',
			$aquDepth,
			'BioMicrohabitatDescription',
<<<<<<< DisplayObjects.php
			'MulMultiMediaRef_tab->emultimedia->MulDescription_tab',
		);
=======
			'MulMultiMediaRef_tab->emultimedia->MulDescription',
                        'AdmDateModified',
    );
>>>>>>> 1.29
	}
}
//=====================================================================================================
//=====================================================================================================
?>
