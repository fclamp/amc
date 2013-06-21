<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ('DefaultPaths.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
TePapaBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any'	=> 	'SummaryData|WebClaPhylum|WebClaClass|WebClaOrder|WebClaFamily|IdeScientificNameLocal_tab|WebIdeTypeStatus|WebComName_tab|WebLocCountry|ColCollectionEventRef->ecollectionevents->LocOcean|WebLocProvinceStateTerritory|LocPreciseLocation|AquHabitat_tab|ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				'tax'	=>	'WebClaPhylum|WebClaClass|WebClaOrder|WebClaFamily|IdeScientificNameLocal_tab|WebIdeTypeStatus|WebComName_tab',

				'loc'	=>	'LocCountry|ColCollectionEventRef->ecollectionevents->LocOcean|ColCollectionEventRef->ecollectionevents->LocProvinceStateTerritory|LocPreciseLocation|AquHabitat_tab',

				'peo'	=>	'ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				);

}  // end TePapaBasicQueryForm class

class
TePapaAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any'	=> 	'SummaryData|WebClaPhylum|WebClaClass|WebClaOrder|WebClaFamily|IdeScientificNameLocal_tab|WebIdeTypeStatus|WebComName_tab|WebLocCountry|ColCollectionEventRef->ecollectionevents->LocOcean|WebLocProvinceStateTerritory|LocPreciseLocation|AquHabitat_tab|ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				'tax'	=>	'WebClaPhylum|WebClaClass|WebClaOrder|WebClaFamily|IdeScientificNameLocal_tab|WebIdeTypeStatus|WebComName_tab',

				'loc'	=>	'WebLocCountry|ColCollectionEventRef->ecollectionevents->LocOcean|WebLocProvinceStateTerritory|LocPreciseLocation|AquHabitat_tab',

				'peo'	=>	'ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				);

}  // end TePapaAdvancedQueryForm class
	

class
TePapaDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	TePapaDetailedQueryForm()
	{
		$ideDate = new QueryField;
		$ideDate->ColName = 'IdeDateIdentified0';
		$ideDate->ColType = 'date';

		$latLat = new QueryField;
		$latLat->ColName = 'LatCentroidLatitude0';
		$latLat->ColType = 'latitude';

		$latLong = new QueryField;
		$latLong->ColName = 'LatCentroidLongitude0';
		$latLong->ColType = 'longitude';

		$colDate = new QueryField;
		$colDate->ColName = 'ColCollectionEventRef->ecollectionevents->ColDateVisitedFrom';
		$colDate->ColType = 'date';

		$aquDepth = new QueryField;
		$aquDepth->ColName = 'AquDepthFromMet';
		$aquDepth->ColType = 'integer';

		$this->Fields = array(	
					'SummaryData',
					'ColCollectionType',
					'RegRegistrationNumberString',
					'WebClaPhylum',
					'WebClaClass',
					'WebClaOrder',
					'WebClaFamily',
					'IdeScientificNameLocal_tab',
					'WebIdeTypeStatus',
					'IdeIdentifiedByRef_tab->eparties->SummaryData',
					$ideDate,
					'WebComName_tab',
					'WebLocCountry',
					'ColCollectionEventRef->ecollectionevents->LocOcean',
					'WebLocProvinceStateTerritory',
					'LocPreciseLocation',
					$latLat,
					$latLong,
					'ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab',
					$colDate,
					$aquDepth,
					'AquHabitat_tab',
					);

		$this->Hints = array(	
					'ColCollectionType'		=> '[Select from list]',
					'WebClaPhylum'			=> '[e.g. Pteridophyta, Chordata]',
					'WebClaClass'			=> '[e.g. Pteridophyta, Aves]',
					'WebClaOrder'			=> '[e.g. , Psittaciformes]',
					'WebClaFamily'			=> '[e.g. Cyatheaceae, Psittacidae]',
					'IdeScientificNameLocal_tab'	=> '[e.g. Cyathea dealbata, Nestor meridionalis]',
					'WebIdeTypeStatus'		=> '[Select from list]',
					'IdeDateIdentified0'		=> '[day/month/year, 1975 note: not all specimens have dates]',
					'WebComName_tab'			=> '[e.g. Silver fern, punga, k&#228;k&#228;]',
					'WebLocCountry'			=> '[Select from list]',
					'ColCollectionEventRef->ecollectionevents->LocOcean'	=> '[Select from list]',
					'WebLocProvinceStateTerritory'		=> '[Select from list]',
					'LocPreciseLocation'		=> '[e.g. Motueka]',
					'ColCollectionEventRef->ecollectionevents->ColDateVisitedFrom'		=> '[day/month/year, 1975 note: not all specimens have dates]',
					);
					
		$this->DropDownLists = array(	
					'ColCollectionType'		=> 'eluts:Administration Category[3]',
					'WebClaPhylum'			=> 'eluts:Web Catalogue Taxonomy[1]',
					'WebClaClass'			=> 'eluts:Web Catalogue Taxonomy[2]',
					'WebClaOrder'			=> 'eluts:Web Catalogue Taxonomy[3]',
					'WebIdeTypeStatus'		=> 'eluts:Web Type Status',
					'WebLocCountry'			=> 'eluts:Web Catalogue Locality[1]',
					'ColCollectionEventRef->ecollectionevents->LocOcean'	=> 'eluts:Ocean',
					'WebLocProvinceStateTerritory'		=> 'eluts:Web Catalogue Locality[2]',
					);
		
		$this->LookupLists = array(	
					'WebClaFamily'			=> 'Web Catalogue Taxonomy[4]',
					'WebComName_tab'			=> 'Web Catalogue Common Name',
					);
	}

} // End TePapaDetailedQueryForm class
?>
