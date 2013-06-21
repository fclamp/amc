<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
NmcPensacolaWebBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'NamObjectTitle|NamObjectName_tab',
					'notes' => 'DesObjectDescription|DesObjectNotes',
					'artist' => 'CreCreatorSummaryData_tab',
					'place' => 'CrePlaceOfOrigin',
					);

}  // end NmcMiramarBasicQueryForm class

class
NmcPensacolaWebAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'NamObjectTitle|NamObjectName_tab',
					'notes' => 'DesObjectDescription|DesObjectNotes',
					'artist' => 'CreCreatorSummaryData_tab',
					'place' => 'CrePlaceOfOrigin',
					);

}  // end NmcMiramarAdvancedQueryForm class
	

class
NmcPensacolaWebDetailedQueryForm extends BaseDetailedQueryForm
{
	var $Fields = array(	'NamObjectTitle',
				'ObjAccessionNumber',
				'ObjStatus',
				'ObjPropertyType',
				'AccAccessionLotRef->eaccessionlots->SummaryData',
				'ObjCreditLine',
				'ObjOtherNumberType_tab',
				'ObjOtherNumber_tab',
				'ClaCategory',
				'ClaSubCategory',
				'ClaType',
				'ClaSubType',
				'ClaClassification',
				'NamObjectName_tab',
				'NamCommonNames_tab',
				'NamNomenclature_tab',
				'NamInstrument_tab',
				'NamRecordingFormat_tab',
				'DesObjectDescription',
				'DesObjectNotes',
				'DesMaterials_tab',
				'DesMedium_tab',
				'DesInscription_tab',
				'MeaMeasurementNotes',
				'CreCreatorSummaryData_tab',
				'CreCreatorRole_tab',
				'CrePlaceOfOrigin',
				'CreCulture',
				'CreProvenance_tab',
				'DatDateCreated',
				'DatDateNotes',
				'DatPeriodOfUse',
				'DatUseNotes',
				'DatCenturyEra',
				'SubSubject_tab',
				'SubGeographicReference_tab',
				'SubPersonReference_tab',
				'SubEventReference_tab',
				#'ComShipCommandName',
				#'ComBaseFacility',
				#'ComOperatingForce',
				#'ComDivisionWing',
				#'ComRegimentGroup',
				#'ComBattalionSquadron',
				#'ComCompanyPlatoon',
				#'ComTeamDetachment',
				#'ComNavyMCNotes',
				#'ComShipCommandAcronym',
				#'LibAuthorRef->eparties->SummaryData',
				#'LibPublisherRef->eparties->SummaryData',
				#'LibPublicationNotes',
				#'LibContents',
				'BibBibliographyRef->ebibliography->SummaryData',
				#'ArcIdentity',
				#'ArcType',
				#'ArcLocationRef->ecollectionevents->SummaryData',
				#'ArcExcavation',
				#'ArcSurvey',
				#'ArcVisualInspection->eparties->SummaryData',
				#'ArcElectrochemicalStatus',
				#'ArcBilogicalActivity',
				#'ArcMetallurgical',
				#'ArcEnvironmentalMeasurements',
				'MulTitle->emultimedia->SummaryData',
				'MulDescription->emultimedia->MulDescription',
				'NotNotes',
				#'eevents->ObjAttachedObjectsRef_tab->eevents->SummaryData',
				);

	var $Hints = array(	'NamObjectTitle' 		=> '[ eg. Navy Cross Medal ]',
				'NamNomenclature' 	=> '[ eg. Flag, USMC ]',
				'SubSubject'=> '[ eg. US Naval History ]',
				'DesMaterials'	=> '[ Select from the list ]',
				'DesMedium'		=> '[ Select from the list ]',
				'CrePlaceOfOrigin'		=> '[ eg. USA ]',
				'CreDateCreated'	=> '[ eg. 1999 ]',
				);

	var $DropDownLists = array(	'DesMaterials_tab' => '|Brass|Glass|Cardboard|Paper',
					'CrePlaceOfOrigin' => 'eluts:Place Of Origin',
					'DesMedium_tab' => 'eluts:Medium',
				);

	var $LookupLists = array (
					'ClaCategory' => 'Category',
				);

} // End NmcPensacolaWebDetailedQueryForm class
?>
