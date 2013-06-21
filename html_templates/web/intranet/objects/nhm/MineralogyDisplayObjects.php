<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');


class
MineralogyStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	MineralogyStandardDisplay()
	{
		$lat = new Field();
		$lat->ColName = "MinLocalityRef->esites->LatCentroidLatitude0";

		$long = new Field();
		$long->ColName = "MinLocalityRef->esites->LatCentroidLongitude0";

		$latlong = new Table();
		$latlong->Columns = array($lat, $long);
		$latlong->Label = "Lat. / Long.";

		$findfall = new Table();
		$findfall->Columns = array("MinMetRecoveryFindFall", "MinMetRecoveryDate");
		$findfall->Headings = array("Find / Fall", "Date");
		$findfall->Label = "Recovery info.";
		
		$this->Fields = array(
			'SummaryData',
			'MinGroup',
			'MinBmNumber',
			// Type Status? 'TypTypeStatus_tab',
			'MinIdentificationAsRegistered',
			'MinIdentificationRef->etaxonomy->SummaryData',
			'MinIdentificationText',
			'MinPetIdentificationCommercial',
			'MinMetChondriteAchondrite',
			'MinMetType',
			'MinMetClass',
			'MinMetGroup',
			'MinIdentificationRef->etaxonomy->ClaSoiUSDAOrder',
			'MinIdentificationRef->etaxonomy->ClaSoiFAOOrder',
			'MinOreDepositType',
			'MinColour',
			'MinSoiTexture',
			'MinOreCommodity',
			'MinOBDCollectionEventRef->ecollectionevents->SummaryData',
			'MinAccessionLotRef->eaccessionlots->SummaryData',
			'MinLocalityRef->esites->LocOcean_tab',
			'MinLocalityRef->esites->LocIslandName',
			'MinLocalityRef->esites->LocCountry_tab',
			'MinLocalityRef->esites->LocProvinceStateTerritory_tab',
			'MinLocalityRef->esites->LocDistrictCountyShire_tab',
			'MinLocalityRef->esites->LocNhmVerbatimLocality',
			$latlong,
			'MinLocalityRef->esites->GeoNhmComplex',
			'MinLocalityRef->esites->GeoNhmStandardMine',
			'MinLocalityRef->esites->GeoNhmLithostrat',
			$findfall,
			);
	
		$this->BaseStandardDisplay();
	}
}


class
MineralogyPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	MineralogyPartyDisplay()
	{
		// Setup Birth and Death Date fields to be shown on
		//	Party records
		$bioBirthDate = new Field;
		$bioBirthDate->ColName = 'BioBirthDate';
		$bioBirthDate->Label = 'Born';
		$bioBirthDate->ShowCondition = 'NamPartyType = Person';

		$bioDeathDate = new Field;
		$bioDeathDate->ColName = 'BioDeathDate';
		$bioDeathDate->Label = 'Died';
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';
		
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				$bioBirthDate,
				$bioDeathDate,
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}
?>
