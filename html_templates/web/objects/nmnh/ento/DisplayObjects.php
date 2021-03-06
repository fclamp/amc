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
NmnhEntoStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhEntoStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsQualifiedNameWeb';

		$catNumber = new FormatField;
		$catNumber->Name = "CatNumber";
		$catNumber->Format = $this->BuildCatalogNumberFormat();

                // START - type citations
                $typeCitations = new FormatField;
                $typeCitations->Name = 'TypeCitations';
                $typeCitationFormat = $this->BuildRawTypeCitationFormat();

                if (! empty($typeCitationFormat))
                {
                        $typeCitations->RawDisplay = 1;
                        $typeCitations->Format = $typeCitationFormat;
                }
                else
                {
                        $typeCitations->Format = '';
                }
                // END - type citations

                // START - Sex/Stage
                $zooSex = new Field;
                $zooSex->ColName = 'ZooSex_tab';

                $zooStage = new Field;
                $zooStage->ColName = 'ZooStage_tab';

                $zooRemarks = new Field;
                $zooRemarks->ColName = 'ZooSexStageRemarks_tab';

                $zooSexStageTable = new Table;
                $zooSexStageTable->Name = 'SexAndStage';
                $zooSexStageTable->Headings = array('Sex', 'Stage', 'Remarks');
                $zooSexStageTable->Columns = array($zooSex, $zooStage, $zooRemarks);
                // END - Sex/Stage

                // START - Preparations
                $zooPrep = new Field;
                $zooPrep->ColName = 'ZooPreparation_tab';

                $zooPrepBy = new Field;
		$zooPrepBy->ColName = 'ZooPreparedByRef_tab->eparties->SummaryData';

                $zooPrepRem = new Field;
                $zooPrepRem->ColName = 'ZooPreparationRemarks_tab';

                $zooPrepTable = new Table;
                $zooPrepTable->Name = 'ZooPrepDetails';
                $zooPrepTable->Headings = array('Preparation', 'Prepared By', 'Remarks');
                $zooPrepTable->Columns = array($zooPrep, $zooPrepBy, $zooPrepRem);
                // END - Preparations

		// START date visited from and date visited to
                $dateCollected = new FormatField;
                $dateCollected->Name = 'BioDateVisitedFromLocal';
		$dateCollected->Format = $this->BuildDateCollectedFormat();
		// END date visited from and date visited to
	
		$this->Fields = array
		(
			'IdeFiledAsQualifiedNameWeb',
			$catNumber,
			'CatBarcode',
			'CatCatalog',
			'CatCollectionName_tab',
			'IdeFiledAsRef->etaxonomy->ClaClass',
			'IdeFiledAsRef->etaxonomy->ClaOrder',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsQualifiedNameWeb',
			'IdeOtherQualifiedNameWeb_tab',
			$typeCitations,
<<<<<<< DisplayObjects.php
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
=======
			$zooSexStageTable,
			$zooPrepTable,
>>>>>>> 1.10
			'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
			'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioVerbatimLocality',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatDec',
                        'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongDec',
<<<<<<< DisplayObjects.php
			$aquDepth,
			'BioMicrohabitatDescription',
			'MulMultiMediaRef_tab->emultimedia->MulDescription_tab',
=======
                        'BioEventSiteRef->ecollectionevents->TerVerbatimElevation',
			'BioEventSiteRef->ecollectionevents->ColParticipantString',
			$dateCollected,
>>>>>>> 1.10
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
