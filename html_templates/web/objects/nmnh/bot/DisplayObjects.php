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
NmnhBotanyStandardDisplay extends NmnhStandardDisplay
{
	function
	NmnhBotanyStandardDisplay()
	{
		$this->NmnhStandardDisplay();
		$this->HeaderField = 'IdeFiledAsQualifiedNameWeb';

		// START - Identification
		$filedAsQualifiedName = new Field;
		$filedAsQualifiedName->ColName = 'IdeFiledAsQualifiedNameWeb';

		$filedAsIdentifiedBy = new Field;
		$filedAsIdentifiedBy->ColName = 'IdeFiledAsIdentifiedByRef->eparties->SummaryData';

		$filedAsIdentificationDate = new Field;
		$filedAsIdentificationDate->ColName = 'IdeFiledAsDateIdentified';

		$filedAsQualifiedNameTable = new Table;
		$filedAsQualifiedNameTable->Name = 'IdeFiledAsQualifiedName';
                $filedAsQualifiedNameTable->Headings = array('', 'Identified By', 'Identification Date');
                $filedAsQualifiedNameTable->Columns = array($filedAsQualifiedName, $filedAsIdentifiedBy, $filedAsIdentificationDate);
		// END - Identification
		

		// START - Other Identifications 
                $otherQualifiedName = new Field;
                $otherQualifiedName->ColName = 'IdeOtherQualifiedNameWeb_tab';

                $otherDateIdentified = new Field;
                $otherDateIdentified->ColName = 'IdeOtherDateIdentifiedWeb0';

                $otherIdentifiedBy = new Field;
                $otherIdentifiedBy->ColName = 'IdeOtherIdentifiedByWebRef_tab->eparties->NamBriefName';

                $otherTaxonomicNamesTable = new Table;
                $otherTaxonomicNamesTable->Name = 'IdeOtherQualifiedName_tab';
                $otherTaxonomicNamesTable->Headings = array('', 'Identified By', 'Identification Date');
                $otherTaxonomicNamesTable->Columns = array($otherQualifiedName, $otherIdentifiedBy, $otherDateIdentified);
		// END - Other Identifications 

		// START - Common Name
		$comName = new Field;
		$comName->ColName = 'IdeFiledAsRef->etaxonomy->ComName_tab';

		$language = new Field;
		$language->ColName = 'IdeFiledAsRef->etaxonomy->ComLanguage_tab';

		$commonName = new Table;
		$commonName->Name = 'IdeFiledAsRef->etaxonomy->ComName_tab';
		$commonName->Headings = array('Name', 'Language');
		$commonName->Columns = array($comName, $language);
		// END - Common Name
		
		// START - Other Numbers
		$otherNumbersType = new Field;
		$otherNumbersType->ColName = 'CatOtherNumbersType_tab';

		$otherNumbersValue = new Field;
		$otherNumbersValue->ColName = 'CatOtherNumbersValue_tab';

		$otherNumbers = new Table;
		$otherNumbers->Name = 'CatOtherNumbersType_tab';
		$otherNumbers->Headings = array('Type', 'Value');
		$otherNumbers->Columns = array($otherNumbersType, $otherNumbersValue);
		// END - Other Numbers

		// START - Other Counts
		$OtherCountsType = new Field;
		$OtherCountsType->ColName = 'CatOtherCountsType_tab';

		$OtherCountsValue = new Field;
		$OtherCountsValue->ColName = 'CatOtherCountsValue_tab';

		$OtherCountsTable = new Table;
		$OtherCountsTable->Name = 'CatOtherCountsType_tab';
		$OtherCountsTable->Headings = array('Type', 'Value');
		$OtherCountsTable->Columns = array($OtherCountsType, $OtherCountsValue);
		// END - Other Counts

		// START - Date Collected
		$dateCollected = new FormatField;
		$dateCollected->Name = 'Date Collected (dd/mm/yyyy)';
		$dateCollected->Format = $this->BuildDateCollectedFormat();
		// END - Date Collected
	
		// START - Elevation
		$elevation = new FormatField;
		$elevation->Name = "Elevation";
		$elevation->Format = $this->BuildElevationFormat();
		// END - Elevation
		
		// START - Catalog Number
		$catNumber = new FormatField;
		$catNumber->Name = "Catalog Number";
		$catNumber->Format = $this->BuildCatalogNumberFormat();
		// END - Catalog Number

		// START - Authority & Status
		$authority = new Field;
                $authority->ColName = 'IdeFiledAsRef->etaxonomy->GeoAuthoritySummaryData_tab';

		$geoStatus = new Field;
                $geoStatus->ColName = 'IdeFiledAsRef->etaxonomy->GeoStatus_tab';

                $authorityTable = new Table;
                $authorityTable->Name = 'Conservation Status';
                $authorityTable->Headings = array('', 'Status');
                $authorityTable->Columns = array($authority, $geoStatus);
		// END - Authority & Status
	
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

		// START - Notes
		$notes = new FormatField;
                $notes->Name = 'NotNmnhText0';
                $notes->Format = $this->BuildNotesFormat(true, NULL, NULL);
		// END - Notes

		$this->Fields = array
		(
			'IdeFiledAsQualifiedNameWeb',
			'CatBarcode',
			$catNumber,
			'CatCatalog',
			'CatCollectionName_tab',
			'IdeFiledAsRef->etaxonomy->ClaPhylum',
			'IdeFiledAsRef->etaxonomy->ClaOrder',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsRef->etaxonomy->ClaSubfamily',
			$filedAsQualifiedNameTable,
			$otherTaxonomicNamesTable,
			$commonName,
			$typeCitations,
			'IdeFiledAsRef->etaxonomy->CitVerificationDegree_tab',
			'BioEventSiteRef->ecollectionevents->ColParticipantString',
			'BioPrimaryCollNumber',
			$dateCollected,
			'BioEventSiteRef->ecollectionevents->LocBiogeographicalRegion',
			'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory',
			'BioEventSiteRef->ecollectionevents->LocDistrictCountyShire',
			'BioEventSiteRef->ecollectionevents->LocPreciseLocation',
			'BioEventSiteRef->ecollectionevents->LocIslandName',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLatitude',
			'BioEventSiteRef->ecollectionevents->LatPreferredCentroidLongitude',
			$authorityTable,
			$elevation,
			'BioMicrohabitatDescription',
			$OtherCountsTable,
			$otherNumbers,
			'BotCultivated',
			$notes,
			'BotRecentFossil',
                        'AdmDateModified',
);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
