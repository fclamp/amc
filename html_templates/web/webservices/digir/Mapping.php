<?php

/*
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/lib/serverconnection.php');

/*
**
*/
class 
MappingFactory
{
	function 
	&getInstance()
	{
		$map =& new Mapping();
		$this->_setMapping($map);
		return $map;
	}

	###
	### THE DEFAULT MAPPING. DARWIN CORE FIELD NAMES TO EMU COLUMN MAPPING
	###
	function
	_setMapping(&$map)
	{
		#######################
		### DARWIN CORE 1.2 ###
		#######################
		$map->setMapping('BasisOfRecord', 'DarBasisOfRecord');
		$map->setMapping('BoundingBox', 'DarBoundingBox');
		$map->setMapping('CatalogNumber', 'DarCatalogNumber');
		$map->setMapping('Class', 'DarClass');
		$map->setMapping('CollectionCode', 'DarCollectionCode');
		$map->setMapping('Collector', 'DarCollector');
		$map->setMapping('CollectorNumber', 'DarCollectorNumber');
		$map->setMapping('ContinentOcean', 'DarContinentOcean');
		$map->setMapping('CoordinatePrecision', 'DarCoordinatePrecision', 'Float');
		$map->setMapping('Country', 'DarCountry');
		$map->setMapping('County', 'DarCounty');
		### SET A DUMMY MAPPING SO WE DON'T GET AN ERROR WHEN 
		### WE TRY TO SET TEXQL & VALUE HANDLERS BELOW
		$map->setMapping('DateLastModified', null, null);
		$map->setMapping('DayCollected', 'DarDayCollected', 'Integer');
		$map->setMapping('DayIdentified', 'DarDayIdentified', 'Integer');
		$map->setMapping('Family', 'DarFamily');
		$map->setMapping('FieldNumber', 'DarFieldNumber');
		$map->setMapping('Genus', 'DarGenus');
		$map->setMapping('IdentifiedBy', 'DarIdentifiedBy');
		$map->setMapping('IndividualCount', 'DarIndividualCount', 'Integer');
		$map->setMapping('InstitutionCode', 'DarInstitutionCode');
		$map->setMapping('JulianDay', 'DarJulianDay', 'Integer');
		$map->setMapping('Kingdom', 'DarKingdom');
		$map->setMapping('Latitude', 'DarLatitude', 'Float');
		$map->setMapping('Locality', 'DarLocality');
		$map->setMapping('Longitude', 'DarLongitude', 'Float');
		$map->setMapping('MaximumDepth', 'DarMaximumDepth', 'Float');
		$map->setMapping('MaximumElevation', 'DarMaximumElevation', 'Float');
		$map->setMapping('MinimumDepth', 'DarMinimumDepth', 'Float');
		$map->setMapping('MinimumElevation', 'DarMinimumElevation', 'Float');
		$map->setMapping('MonthCollected', 'DarMonthCollected', 'Integer');
		$map->setMapping('MonthIdentified', 'DarMonthIdentified', 'Integer');
		$map->setMapping('Notes', 'DarNotes');
		$map->setMapping('Order', 'DarOrder');
		$map->setMapping('Phylum', 'DarPhylum');
		$map->setMapping('PreparationType', 'DarPreparationType');
		$map->setMapping('PreviousCatalogNumber', 'DarPreviousCatalogNumber');
		$map->setMapping('RelatedCatalogItem', 'DarRelatedCatalogItem');
		$map->setMapping('RelationshipType', 'DarRelationshipType');
		$map->setMapping('ScientificName', 'DarScientificName');
		$map->setMapping('ScientificNameAuthor', 'DarScientificNameAuthor');
		$map->setMapping('Sex', 'DarSex');
		$map->setMapping('Species', 'DarSpecies');
		$map->setMapping('StateProvince', 'DarStateProvince');
		$map->setMapping('Subspecies', 'DarSubspecies');
		$map->setMapping('TimeOfDay', 'DarTimeOfDay', 'Float');
		$map->setMapping('TypeStatus', 'DarTypeStatus');
		$map->setMapping('YearCollected', 'DarYearCollected', 'Integer');
		$map->setMapping('YearIdentified', 'DarYearIdentified', 'Integer');

		########################
		### DARWIN CORE 1.21 ###
		########################
		$map->setMapping('AgeClass', 'DarAgeClass');
		# BasisOfRecord
		# BoundingBox
		$map->setMapping('CatalogNumberNumeric', 'DarCatalogNumberNumeric', 'Integer');
		$map->setMapping('CatalogNumberText', 'DarCatalogNumberText');
		# Class
		# CollectionCode
		# Collector
		# CollectorNumber
		# ContinentOcean
		$map->setMapping('CoordinateUncertaintyInMeters', 'DarCoordinateUncertaintyInMeter', 'Float');
		# Country
		# County
		# DateLastModified
		# DayCollected
		# DayIdentified
		$map->setMapping('DecimalLatitude', 'DarDecimalLatitude', 'Float');
		$map->setMapping('DecimalLongitude', 'DarDecimalLongitude', 'Float');
		# Family
		$map->setMapping('FieldNotes', 'DarFieldNotes');
		# FieldNumber
		$map->setMapping('GenBankNum', 'DarGenBankNum');
		# Genus
		$map->setMapping('GeorefMethod', 'DarGeorefMethod');
		$map->setMapping('HigherGeography', 'DarHigherGeography');
		$map->setMapping('HigherTaxon', 'DarHigherTaxon');
		$map->setMapping('HorizontalDatum', 'DarHorizontalDatum');
		$map->setMapping('IdentificationModifier', 'DarIdentificationModifier');
		# IdentifiedBy
		# IndividualCount
		# InstitutionCode
		$map->setMapping('Island', 'DarIsland');
		$map->setMapping('IslandGroup', 'DarIslandGroup');
		# JulianDay
		# Kingdom
		$map->setMapping('LatLongComments', 'DarLatLongComments');
		# Locality
		$map->setMapping('MaximumDepthInMeters', 'DarMaximumDepthInMeters', 'Float');
		$map->setMapping('MaximumElevationInMeters', 'DarMaximumElevationInMeters', 'Float');
		$map->setMapping('MinimumDepthInMeters', 'DarMinimumDepthInMeters', 'Float');
		$map->setMapping('MinimumElevationInMeters', 'DarMinimumElevationInMeters', 'Float');
		# MonthCollected
		# MonthIdentified
		# Order
		$map->setMapping('OriginalCoordinateSystem', 'DarOriginalCoordinateSystem');
		$map->setMapping('OtherCatalogNumbers', 'DarOtherCatalogNumbers');
		$map->setMapping('Preparations', 'DarPreparations');
		# Phylum
		$map->setMapping('RelatedCatalogedItems', 'DarRelatedCatalogItems');
		$map->setMapping('Remarks', 'DarRemarks');
		# ScientificName
		# ScientificNameAuthor
		# Sex
		# Species
		# StateProvince
		# Subspecies
		$map->setMapping('TimeCollected', 'DarTimeCollected', 'Float');
		$map->setMapping('Tissues', 'DarTissues');
		# TypeStatus
		$map->setMapping('VerbatimCollectingDate', 'DarVerbatimCollectingDate');
		$map->setMapping('VerbatimDepth', 'DarVerbatimDepth');
		$map->setMapping('VerbatimElevation', 'DarVerbatimElevation');
		$map->setMapping('VerbatimLatitude', 'DarVerbatimLatitude');
		$map->setMapping('VerbatimLongitude', 'DarVerbatimLongitude');
		# YearCollected
		# YearIdentified

		#######################
		### DARWIN CORE 1.3 ###
		#######################
		# BasisOfRecord
		# CatalogNumber
		# Class
		# CollectionCode
		# Collector
		$map->setMapping('Continent', 'DarContinent');
		# CoordinateUncertaintyInMeters
		# Country
		# County
		# DateLastModified
		# DayCollected
		# DecimalLatitude
		# DecimalLongitude
		# Family
		# Genus
		$map->setMapping('GeodeticDatum', 'DarGeodeticDatum');
		$map->setMapping('GlobalUniqueIdentifier', 'DarGlobalUniqueIdentifier');
		# HigherGeography
		# HigherTaxon
		$map->setMapping('IdentificationQualifier', 'DarIdentificationQualifier');
		$map->setMapping('ImageURL', 'DarImageURL');
		$map->setMapping('InfraspecificEpithet', 'DarInfraspecificEpithet');
		$map->setMapping('InfraspecificRank', 'DarInfraspecificRank');
		# InstitutionCode
		# Island
		# IslandGroup
		# JulianDay
		# Kingdom
		$map->setMapping('LifeStage', 'DarLifeStage');
		# Locality
		# MaximumDepthInMeters
		# MaximumElevationInMeters
		# MinimumDepthInMeters
		# MinimumElevationInMeters
		# MonthCollected
		# Order
		# Phylum
		$map->setMapping('RelatedInformation', 'DarRelatedInformation');
		# ScientificName
		# ScientificNameAuthor
		# Sex
		$map->setMapping('SpecificEpithet', 'DarSpecificEpithet');
		# StateProvince
		# TimeCollected
		$map->setMapping('WaterBody', 'DarWaterBody');
		# YearCollected

		#######################
		### DARWIN CORE 1.4 ###
		#######################
		$map->setMapping('Attributes', 'DarAttributes');
		$map->setMapping('AuthorYearOfScientificName', 'DarAuthorYearOfScientificName');
		# BasisOfRecord
		# CatalogNumber
		# Class
		$map->setMapping('CollectingMethod', 'DarCollectingMethod');
		# CollectionCode
		# Collector
		# Continent
		# Country
		# County
		# DateLastModified
		$map->setMapping('DayOfYear', 'DarDayOfYear', 'Integer');
		$map->setMapping('EarliestDateCollected', 'DarEarliestDateCollected');
		# Family
		# Genus
		# GlobalUniqueIdentifier
		# HigherGeography
		# HigherTaxon
		# IdentificationQualifier
		# ImageURL
		$map->setMapping('InformationWithheld', 'DarInformationWithheld');
		# InfraspecificEpithet
		# InfraspecificRank
		# InstitutionCode
		# Island
		# IslandGroup
		# Kingdom
		$map->setMapping('LatestDateCollected', 'DarLatestDateCollected');
		# LifeStage
		# Locality
		# MaximumDepthInMeters
		# MaximumElevationInMeters
		# MinimumDepthInMeters
		# MinimumElevationInMeters
		$map->setMapping('NomenclaturalCode', 'DarNomenclaturalCode');
		# Order
		# Phylum
		# RelatedInformation
		# Remarks
		# ScientificName
		# Sex
		# SpecificEpithet
		# StateProvince
		$map->setMapping('ValidDistributionFlag', 'DarValidDistributionFlag');
		# WaterBody

		###################################
		### DARWIN CORE 1.4 EXTENSIONS? ###
		###################################
		$map->setMapping('DateIdentified', 'DarDateIdentified');
		$map->setMapping('Disposition', 'DarDisposition');
		$map->setMapping('FootprintSpatialFit', 'DarFootprintSpatialFit', 'Integer');
		$map->setMapping('FootprintWKT', 'DarFootprintWKT');
		$map->setMapping('GeoreferenceProtocol', 'DarGeoreferenceProtocol');
		$map->setMapping('GeoreferenceRemarks', 'DarGeoreferenceRemarks');
		$map->setMapping('GeoreferenceSources', 'DarGeoreferenceSources');
		$map->setMapping('GeoreferenceVerificationStatus', 'DarGeoreferenceVerificationStatus');
		$map->setMapping('PointRadiusSpatialFit', 'DarPointRadiusSpatialFit', 'Integer');
		$map->setMapping('RelatedCatalogItems', 'DarRelatedCatalogItems');
		$map->setMapping('VerbatimCoordinates', 'DarVerbatimCoordinates');
		$map->setMapping('VerbatimCoordinateSystem', 'DarVerbatimCoordinateSystem');


		############
		### OBIS ###
		############
		$map->setMapping('Citation', 'DarCitation');
		$map->setMapping('DepthRange', 'DarDepthRange');
		$map->setMapping('EndDayCollected', 'DarEndDayCollected', 'Integer');
		$map->setMapping('EndJulianDay', 'DarEndJulianDay', 'Integer');
		$map->setMapping('EndLatitude', 'DarEndLatitude', 'Float');
		$map->setMapping('EndLongitude', 'DarEndLongitude', 'Float');
		$map->setMapping('EndMonthCollected', 'DarEndMonthCollected', 'Integer');
		$map->setMapping('EndTimeOfDay', 'DarEndTimeOfDay', 'Float');
		$map->setMapping('EndYearCollected', 'DarEndYearCollected', 'Integer');
		$map->setMapping('GMLFeature', 'DarGMLFeature');
		# LifeStage
		$map->setMapping('ObservedIndividualCount', 'DarObservedIndividualCount', 'Integer');
		$map->setMapping('ObservedWeight', 'DarObservedWeight', 'Float');
		$map->setMapping('RecordURL', 'DarRecordURL');
		$map->setMapping('SampleSize', 'DarSampleSize', 'Integer');
		$map->setMapping('Source', 'DarSource');
		$map->setMapping('StartDayCollected', 'DarStartDayCollected', 'Integer');
		$map->setMapping('StartJulianDay', 'DarStartJulianDay', 'Integer');
		$map->setMapping('StartLatitude', 'DarStartLatitude', 'Float');
		$map->setMapping('StartLongitude', 'DarStartLongitude', 'Float');
		$map->setMapping('StartMonthCollected', 'DarStartMonthCollected', 'Integer');
		$map->setMapping('StartTimeOfDay', 'DarStartTimeOfDay', 'Float');
		$map->setMapping('StartYearCollected', 'DarStartYearCollected', 'Integer');
		$map->setMapping('Start_EndCoordinatePrecision', 'DarStart_EndCoordinatePrecision', 'Float');
		$map->setMapping('Subgenus', 'DarSubgenus');
		$map->setMapping('Temperature', 'DarTemperature', 'Float');
		$map->setMapping('TimeZone', 'DarTimeZone');

		#############
		### PALEO ###
		#############
		$map->setMapping('Age', 'DarAge');
		# BasisOfRecord
		$map->setMapping('Bed', 'DarBed');
		# BoundingBox
		# CatalogNumber
		# Class
		# CollectionCode
		# Collector
		# CollectorNumber
		$map->setMapping('ContentDescription', 'DarContentDescription');
		# ContinentOcean
		# CoordinatePrecision
		# Country
		# County
		# DateLastModified
		$map->setMapping('Datum', 'DarDatum');
		# DayCollected
		# DayIdentified
		$map->setMapping('DepthInCore', 'DarDepthInCore');
		$map->setMapping('Element', 'DarElement');
		$map->setMapping('Epoch', 'DarEpoch');
		$map->setMapping('Facies', 'DarFacies');
		# Family
		# FieldNumber
		$map->setMapping('Formation', 'DarFormation');
		# Genus
		$map->setMapping('Group', 'DarGroup');
		# IdentificationQualifier
		# IdentifiedBy
		# IndividualCount
		# InstitutionCode
		# JulianDay
		# Kingdom
		# Latitude
		# Locality
		$map->setMapping('LocalityNumber', 'DarLocalityNumber');
		# Longitude
		# MaximumDepth
		# MaximumElevation
		$map->setMapping('Member', 'DarMember');
		# MinimumDepth
		# MinimumElevation
		# MonthCollected
		# MonthIdentified
		# Notes
		# Order
		$map->setMapping('Period', 'DarPeriod');
		# Phylum
		# PreparationType
		# PreviousCatalogNumber
		# RelatedCatalogItem
		# RelationshipType
		# ScientificName
		# ScientificNameAuthor
		# Sex
		# Species
		$map->setMapping('Stage', 'DarStage');
		# StateProvince
		# Subgenus
		# Subspecies
		$map->setMapping('TermsAndConditionsURL', 'DarTermsAndConditionsURL');
		# TimeOfDay
		# TypeStatus
		# YearCollected
		# YearIdentified
		$map->setMapping('Zone', 'DarZone');


		### SET UP DEFAULT HANDLERS FOR DateLastModified
		### USE AdmDateModified & AdmTimeModified
		$code = 
		'
			$texql = "";
			list($date, $time) = preg_split("/t/i", $value, 2, PREG_SPLIT_NO_EMPTY);

			if (! isset($date))
			{
				// error
				$texql = "FALSE";
			}
			else
			{
				$texql .= "AdmDateModified $operator";
				if (strtolower($operator) != "like")
					$texql .= " DATE";
				$texql .= " \'$date\'";
				
				if (isset($time))
				{
					### STRIP OFF FRACTIONS OF SECONDS & TIME ZONE DESIGNATIONS AS THEY ARE MEANINGLESS TO US
					$time = preg_replace("/(?:\.\d+)?(?:\+|-|Z).*$/", "", $time);
	
					$texql .= " AND AdmTimeModified $operator";
					if (strtolower($operator) != "like")
						$texql .= " TIME";
					$texql .= " \'$time\'";
				}
			}
			return $texql;
		';
		$map->setTexqlHandler('DateLastModified', array('AdmDateModified', 'AdmTimeModified'), $code);

		$code = 
		'
			return Provider::emuDate2Iso8601Time($record[\'AdmDateModified\'], $record[\'AdmTimeModified\']);
		';
		$map->setValueHandler('DateLastModified', $code);

		###
		### SET MANDOTORY FIELDS 
		###
		$map->setMandatory('ScientificName');
		$map->setMandatory('CatalogNumber');
		$map->setMandatory('CollectionCode');
		$map->setMandatory('InstitutionCode');
	}
}

class 
Mapping extends BaseWebServiceObject
{
	### MAPPING STANDARD FIELD NAME TO FIELDMAP OBJECT
	var $_fieldToColumn = array();
	var $_mandatoryFields = array();

	function 
	setMapping($field, $column, $columnType='Text')
	{
		$this->_fieldToColumn[strtolower($field)] = array
		(
			'field'		=> $field,
			'column'	=> $column,
			'type'		=> $columnType,
			'texql'		=> false,
			'value'		=> false,
		);
	}

	function 
	clearMappings()
	{
		$this->_fieldToColumn = array();
	}

	function 
	setMappingRef($fromField, $toField)
	{
		$lcFromField = strtolower($fromField);
		$lcToField = strtolower($toField);

		if (! isset($this->_fieldToColumn[$lcFromField]))
		{
			$mesg = "cannot set reference from unknown field '$fromField'";
			trigger_error("MAPPING_ERROR:warning:$mesg", E_USER_ERROR);
			return false;
		}

		if (! isset($this->_fieldToColumn[$lcToField]))
		{
			$mesg = "cannot set reference to unknown field '$toField'";
			trigger_error("MAPPING_ERROR:warning:$mesg", E_USER_ERROR);
			return false;
		}

		$newMapping = $this->_fieldToColumn[$lcToField];
		$newMapping['field'] = $fromField;
		$this->_fieldToColumn[$lcFromField] = $newMapping;
		return true;
	}

	function 
	setNoMapping($field)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
		{
			$message = "cannot set no mapping on unknown field '$field'";
			trigger_error("MAPPING_ERROR:warning:$message", E_USER_ERROR);
			return false;
		}
		$this->_fieldToColumn[$lcField] = false;
		return true;
	}

	function 
	isMapping($field)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
			return null;

		if ($this->_fieldToColumn[$lcField] === false)
			return false;

		return true;
	}

	function 
	getField($field)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
			return false;

		if ($this->_fieldToColumn[$lcField] === false)
			return $field;

		return $this->_fieldToColumn[$lcField]['field'];
	}

	function
	getColumns($field)
	{
		$lcField = strtolower($field);
		if ($this->_fieldToColumn[$lcField] !== false)
		{
			if ($this->_fieldToColumn[$lcField]['texql'] !== false)
			{
				return $this->_fieldToColumn[$lcField]['texql']['columns'];
			}
			else if (isset($this->_fieldToColumn[$lcField]))
			{
				return array($this->_fieldToColumn[$lcField]['column']);
			}
		}
		return array();
	}

	function
	setMandatory($field)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
		{
			$message = "cannot set unknown field '$field' to mandatory";
			trigger_error("MAPPING_ERROR:error:$message", E_USER_ERROR);
			return false;
		}
		$this->_mandatoryFields[] = $field;
		return true;
	}

	function
	clearMandatory()
	{
		$this->_mandatoryFields = array();
	}

	function
	getMandatory()
	{
		$texql = '';
		if (! empty($this->_mandatoryFields))
		{
			foreach ($this->_mandatoryFields as $field)
			{
				foreach ($this->getColumns($field) as $column)
				{
					if (preg_match('/(:?_tab|0)$/', $column))
					{
						$term = "$column <> []";
					}
					else
					{
						$term = "$column is not null";
					}
					if (! empty($texql))
						$texql .= " AND $term";
					else
						$texql .= $term;
				}
			}
		}
		if (empty($texql))
			return false;

		return $texql;
	}

	function
	setTexqlHandler($field, $columns, $code, $data=null)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
		{
			$message = "cannot set texql handler on unknown field '$field'";
			trigger_error("MAPPING_ERROR:error:$message", E_USER_ERROR);
			return false;
		}

		if (isset($columns) && ! is_array($columns))
			$columns = array($columns);

		if (isset($data))
			$function = create_function('$field, $operator, $value, $data', $code);
		else
			$function = create_function('$field, $operator, $value', $code);

		if ($function === false || ! is_callable($function))
		{
			$message = "error occured setting texql handler for field '$field'";
			trigger_error("MAPPING_ERROR:error:$message", E_USER_ERROR);
			return false;
		}

		$texql = array
		(
			'function'	=> $function,
			'columns'	=> $columns,
			'data'		=> $data
		);
		$this->_fieldToColumn[$lcField]['texql'] = $texql;
		return true;
	}

	function
	generateTexql($field, $operator, $value)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
			return false;

		if ($this->_fieldToColumn[$lcField]['texql'] === false)
		{
			$column = $this->_fieldToColumn[$lcField]['column'];
			$type = $this->_fieldToColumn[$lcField]['type'];
			$value = addslashes($value);

			if (strtolower($value) != 'null' && 
			    (strtolower($type) == 'string' || 
			     strtolower($type) == 'text' || 
			     strtolower($operator) == 'like'))
			{
				$value = "'$value'";
			}
	
			if (preg_match('/^(.+)_tab$/', $column, $match))
				$texql = "(EXISTS ($column WHERE {$match[1]} $operator $value))";
			else
				$texql = "$column $operator $value";
		}
		else
		{
			$function = $this->_fieldToColumn[$lcField]['texql']['function'];

			if (($data = $this->_fieldToColumn[$lcField]['texql']['data']) !== null)
				$texql = call_user_func($function, $field, $operator, $value, $data);
			else
				$texql = call_user_func($function, $field, $operator, $value);
		}
		return $texql;
	}

	function
	setValueHandler($field, $code, $data=null)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
		{
			$message = "cannot set value handler on unknown field '$field'";
			trigger_error("MAPPING_ERROR:error:$message", E_USER_ERROR);
			return false;
		}

		if (isset($data))
			$function = create_function('$field, &$record, $data', $code);
		else
			$function = create_function('$field, &$record', $code);

		if ($function === false || ! is_callable($function))
		{
			$message = "error occured setting value handler for field '$field'";
			trigger_error("MAPPING_ERROR:error:$message", E_USER_ERROR);
			return false;
		}

		$value = array
		(
			'function'	=> $function,
			'data'		=> $data
		);
		$this->_fieldToColumn[$lcField]['value'] = $value;
		return true;
	}

	function
	generateValue($field, &$record)
	{
		$lcField = strtolower($field);
		if (! isset($this->_fieldToColumn[$lcField]))
			return false;

		if ($this->_fieldToColumn[$lcField]['value'] === false)
		{
			if (! isset($record[$this->_fieldToColumn[$lcField]['column']]))
				$value = null;
			else
				$value = $record[$this->_fieldToColumn[$lcField]['column']];
		}
		else
		{

			$function = $this->_fieldToColumn[$lcField]['value']['function'];

			if (($data = $this->_fieldToColumn[$lcField]['value']['data']) !== null)
				$value = call_user_func($function, $field, $record, $data);
			else
				$value = call_user_func($function, $field, $record);
		}
		return $value;
	}

	function
	checkColumns($database)
	{
		foreach (array_keys($this->_fieldToColumn) as $field)
		{
			$column = $this->_fieldToColumn[$field]['column'];
			if (isset($column) && $this->_columnExists($column, $database) === false)
				$this->setNoMapping($field);
		}
	}

	function
	_columnExists($column, $database)
	{
		$status = false;
		$texql = "describe(select $column from $database)";
		$connection = new TexxmlserverConnection;

		### IF FOR SOME REASON AN ERROR OCCURS THEN DON'T RETURN FALSE.
		### IF THE PROBLEM PERSISTS WE WILL PICK IT UP AND REPORT IT LATER.
		### IF NOT & IF WE HAVE ACCIDENTALLY INCLUDED A COLUMN THAT DOESN'T 
		### EXIST IN THE BACKEND THEN WE WILL BAIL OUT WITH A TEXQL ERROR 
		### LATER BUT THE DiGIR PORTAL CAN ALWAYS RERUN THE REQUEST, IS 
		### BETTER THAN RETURNING A REQUEST WITH MISSING DATA
		if (! $connection)
			return null;

		$socket = $connection->Open();
		if (! $socket || $socket < 0)
			return null;

		$content = "texql=". urlencode($texql);
		$length = strlen($content);
		$post = "POST /texxmlserver/post HTTP/1.0\r\n" .
			"Content-Length: $length\r\n\r\n" .
			$content;

		if (fwrite($socket, $post) === false)
		{
			fclose($socket);
			return null;
		}
		fflush($socket);

		while (! feof($socket))
		{
			if (($line = trim(fgets($socket))) === false)
			{
				fclose($socket);
				return null;
			}

			if (preg_match("/^<results\s+status=\"(.+)\">$/", $line, $match))
			{
				if ($match[1] == "success")
					$status = true;
				break;
			}
		}

		fclose($socket);
		return $status;
	}
}
?>
