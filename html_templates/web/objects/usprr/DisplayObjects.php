<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
UsprrStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	UsprrStandardDisplay()
	{


		$colCollectorRef = new Field;
		$colCollectorRef->ColName = 'ColCollectorRef->eparties->SummaryData';
		$colCollectorRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		$colCollectorRef->Label = "Collector";

		$colSourceRef = new Field;
		$colSourceRef->ColName = 'ColSourceRef->eparties->SummaryData';
		$colSourceRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		$colSourceRef->Label = "Source";

		$structuralMeasurements = new Table;
		$structuralMeasurements->Name = "Structural Measurements";
		$structuralMeasurements->Headings = array('Type', 'Measurement', 'True or Magnetic');
		$structuralMeasurements->Columns = array('MeaType_tab', 'MeaMeasurement_tab', 'MeaTrueOrMagnetic_tab');

		$geologicAge = new Table;
		$geologicAge->Name = "Geologic Age";
		$geologicAge->Headings = array('Era', 'Period', 'Epoch', 'Stage Age', 'Isotopic Age', 'Dating Method', 'Mineral');
		$geologicAge->Columns = array('AgeEra_tab', 'AgePeriod_tab', 'AgeEpoch_tab', 'AgeStageAge_tab', 'AgeIsotopicAge_tab', 'AgeDatingMethod_tab', 'AgeMineral_tab');

		$stratigraphy = new Table;
		$stratigraphy->Name = "Stratigraphy";
		$stratigraphy->Headings = array('Group/Complex', 'Formation', 'Member', 'Section Name', 'Unit Thickness', 'Sample Height', 'Distance From Intrusion');
		$stratigraphy->Columns = array('AgeGroup_tab', 'AgeFormation_tab', 'AgeMember_tab', 'AgeSectionName_tab', 'AgeUnitThickness_tab', 'AgeSampleHeight_tab', 'AgeDistanceFromIntrusion_tab');
		
		$siteMeanNrm = new Table;
		$siteMeanNrm->Name = "Site Mean NRM";
		$siteMeanNrm->Headings = array('Declination', 'Inclination', 'a95', '# of Samples');
		$siteMeanNrm->Columns = array('MagNrmDeclination', 'MagNrmInclination', 'MagNrmA95', 'MagNrmNoOfSamples');

		$siteMeanCm = new Table;
		$siteMeanCm->Name = "Site Mean CM";
		$siteMeanCm->Headings = array ('Declination', 'Inclination', 'a95', '# of Samples');
		$siteMeanCm->Columns = array ('MagCmDeclination', 'MagCmInclination', 'MagCmA95', 'MagCmNoOfSamples');


		$this->Fields = array(
				'ColIsgnNo',
				$colCollectorRef,
				$colSourceRef,
				'ColDateCollected',
				'ColFieldYearCollected',
				'ColPrimaryFieldNo',
				'ColMagneticArchiveNo',
				'ObjKindOfObject',
				'ObjRockType',
				'ObjRockName',
				'ObjInformalName',
				'ObjTypeLocality',
				'ObjMineralsObserved_tab',
				'ObjSurfaceFeatures_tab',
				'ObjAnalyses_tab',
				'ObjSampleDescription',
				'NotNotes',
				'LtyOceanSea',
				'LtyContinent',
				'LtyCountry',
				'LtyRegion',
				'LtyMountainRangeIslandGroup',
				'LtyMountainNameIslandName',
				'LtyPreciseLocation',
				'LtyElevationAslMeters',
				'LtyAproxElevation',
				'LtyLatitudeDms',
				'LtyLatitudeDec',
				'LtyLongitudeDms',
				'LtyLongitudeDec',
				'LtyDeterminationMethod',
				'MeaWeight',
				'MeaVolume',
				'MeaSpecificGravity',
				'MeaSusceptibility',
				$structuralMeasurements,
				$geologicAge,
				$stratigraphy,
				$siteMeanNrm,
				$siteMeanCm,
				'MagMagneticSampleForm_tab',
				'MagPolarity',
				'MagPrimaryMagneticCarrier',
				'MagInstruments_tab',
				'MagMagneticTechniquesUsed_tab',
				'MagNrmIntensity',
				'FosKingdom',
				'FosPhylum',
				'FosClass',
				'FosOrder',
				'FosFamily',
				'FosGenus',
				'FosSpecies',
				'FosInformalName_tab',
				'FosNotes',
				'CorCoringDevice',
				'CorIceThickness',
				'CorCoreDiameter',
				'CorCoreLength',
				'CorSite',
				'CorHole',
				'CorCore',
				'CorSection',
				'CorBox',
				'CorDepthToTop',
				'CorDepthToBottom',
				'UncEnvironment',
				'UncHorizon',
				'UncDepthBelowGroundSurface',
				'UncDepthToPermafrost',
				'UncMatrix',
				'UncMatrixSize',
				'UncPercentGravel',
				'UncPercentSand',
				'UncPercentMud',
				'UncAppearance',
				'UncErratics',
				'UncClastTextures_tab',
				'DreVesselName',
				'DreCruiseNumber',
				'DreStationNumber',
				'DreSampleType',
				'DreSamplingDevice_tab',
				'DreTimeStart',
				'DreTimeFinish',
				'DreDepthStart',
				'DreDepthFinish',
				'DreLatitudeDmsStart',
				'DreLatitudeDecStart',
				'DreLatitudeDmsFinish',
				'DreLatitudeDecFinish',
				'DreLongitudeDmsStart',
				'DreLongitudeDecStart',
				'DreLongitudeDmsFinish',
				'DreLongitudeDecFinish',
				'DreClasts',
				'BibBibliographyRef_tab->ebibliography->SummaryData',
				'ObjBibliography_tab',
				);
		
		$this->BaseStandardDisplay();
	}
}


class
UsprrPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	UsprrPartyDisplay()
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
