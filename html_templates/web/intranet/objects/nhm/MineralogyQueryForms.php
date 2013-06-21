<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
MineralogyBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					);

}  // end MineralogyBasicQueryForm class

class
MineralogyAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					);

}  // end MineralogyAdvancedQueryForm class
	

class
MineralogyDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	MineralogyDetailedQueryForm()
	{
		$recoverydate = new QueryField();
		$recoverydate->ColName = "MinMetRecoveryDate";
		$recoverydate->ColType = "date";

		$latitude = new QueryField();
		$latitude->ColName = 'MinLocalityRef->esites->LatCentroidLatitude0';
		$latitude->ColType = "latitude";

		$longitude = new QueryField();
		$longitude->ColName = 'MinLocalityRef->esites->LatCentroidLongitude0';
		$logitude->ColType = "longitude";

		$this->Fields = array(	'MinGroup',
					'MinBmNumber',
					// Type Status? 'TypTypeStatus_tab',
					'MinIdentificationAsRegistered',
					'MinIdentificationRef->etaxonomy->SummaryData|MinIdentificationText',
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
					'MinOBDCollectionEventRef->ecollectionevents->SummaryData|MinLocalityRef->esites->SummaryData',
					'MinAccessionLotRef->eaccessionlots->SummaryData',
					'MinLocalityRef->esites->LocOcean_tab',
					'MinLocalityRef->esites->LocIslandName',
					'MinLocalityRef->esites->LocCountry_tab',
					'MinLocalityRef->esites->LocProvinceStateTerritory_tab',
					'MinLocalityRef->esites->LocDistrictCountyShire_tab',
					'MinNhmVerbatimLocalityLocal',
					$latitude,
					$longitude,
					'MinLocalityRef->esites->GeoNhmComplex',
					'MinLocalityRef->esites->GeoNhmStandardMine',
					'MinLocalityRef->esites->GeoNhmLithostrat',
					'MinMetRecoveryFindFall',
					$recoverydate,
					);

		$this->Hints = array(
			"MinGroup"	=>	"[ select from list ]",
			"MinBmNumber"	=>	"[ e.g. BM.1987,O235 ]",
			// Type Status? 'TypTypeStatus_tab',
			'MinIdentificationAsRegistered'	=> "[ e.g. Flint nodule ]",
			'MinIdentificationRef->etaxonomy->SummaryData|MinIdentificationText' => '[ e.g. Wohlerite ]',
			'MinMetChondriteAchondrite'	=>	'[ select from list ]',
			'MinMetType'	=>	'[ select from list ]',
			'MinMetClass'	=>	'[ select from list ]',
			'MinMetGroup'	=>	'[ select from list ]',
			'MinIdentificationRef->etaxonomy->ClaSoiUSDAOrder'	=>	'[ e.g. Andisol ]',
			'MinOreDepositType'	=>	'[ e.g. Vein ]',
			'MinSoiTexture'	=>	'[ select from list ]',
			'MinOreCommodity'	=>	'[ select from list ]',
			'MinOBDCollectionEventRef->ecollectionevents->SummaryData|MinLocalityRef->esites->SummaryData'
				=>	'[ e.g. Australasia ]',
			'MinAccessionLotRef->eaccessionlots->SummaryData'	=>	'[ e.g. Presented 1890 ]',
			'MinLocalityRef->esites->LocOcean_tab'	=>	'[ e.g. Pacific ]',
			'MinLocalityRef->esites->LocCountry_tab'	=>	'[ e.g. Algeria ]',
			'MinLocalityRef->esites->LocProvinceStateTerritory_tab'	=>	'[ e.g. Arizona ]',
			'MinLocalityRef->esites->LocDistrictCountyShire_tab'	=>	'[ e.g. Colorado ]',
			'MinLocalityRef->esites->LocNhmVerbatimLocality'	=>	'[ e.g. Ouenza Mine ]',
			'MinLocalityRef->esites->GeoNhmStandardMine'	=>	'[ e.g. Ouenza ]',
			'MinMetRecoveryFindFall'	=>	'[ select from list ]',
			'MinMetRecoveryDate'	=>	'[ e.g. 1961 ]'
			);

		$this->DropDownLists = array(
			'MinGroup' => 'eluts:MinCategory[2]',
			'MinMetChondriteAchondrite' => 'eluts:Chondrite Achondrite',
			'MinMetType' => 'eluts:Meteorite Type',
			'MinMetGroup' => 'eluts:Meteorite Group',
			'MinMetClass' => 'eluts:Meteorite Class',
			'MinSoiTexture' => 'eluts:Soil Texture',
			'MinOreCommodity' => 'eluts:Commodity',
			'MinMetRecoveryFindFall' => 'eluts:Find Fall',	
			);
	}

} // End MineralogyDetailedQueryForm class
?>
