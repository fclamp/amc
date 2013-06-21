<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



/*  Factory class used to create right instance of client
**  specific DiGIR object.
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/digir/DigirProvider.php');

class DigirProviderFactory
{
	function getInstance()
	{
		if ($provider = new NmnhDigirProvider())
		{
			$provider->configure();
			return $provider;
		}
		return null;
	}
}


/*  Class for client specific field mappings.
*/



class NmnhDigirProvider extends DigirProvider
{

	/* To CONFIGURE A DiGIR SYSTEM to an EMu Client
	 *
	 * 1. add metadata entries in the configure method
	 * 2. implement generateTexql method
	 * 3. implement generateValue method
	 *
	 */

	var $serviceName = "NmnhDigirProvider";


	function describe()
	{
		return	
			"A NMNH Digir Provider is a NMNH client specific\n".
			"Digir Provider\n\n".
			Parent::describe();
	}

	function testQueryTerms()
	{
		// a test filter and records that can be used to confirm
		// system is functional
		return  "<filter>\n".
			"	<or>\n".
			"		<equals>\n".
			"			<darwin:Genus>Culex</darwin:Genus>\n".
			"		</equals>\n".
			"		<equals>\n".
			"			<darwin:Genus>Aedes</darwin:Genus>\n".
			"		</equals>\n".
			"	</or>\n".
			"</filter>\n".
			"<records start='0' limit='5'>\n".
			"	<structure schemaLocation='http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd'/>\n".
			"</records> \n";
	}


	function configure()
	{
		/********** Local Settings for Metadata ***********
		 * need to set properties for
		 * - provider info
		 * - one host (with one or more host contacts) 
		 * and 
		 * - one or more resources (with each resource having
		 * one or more contacts)
		 **************************************************/

		$this->setMetaData('provider',
			array(
				'Name'         =>
					'National Museum of Natural History, 
					Smithsonian Institution',
				'Implementation'=>
					'KE Software EMu, 
					PHP KE EMu DiGIR Interface',
				'AccessPoint'  => 'default',
			)
		);
		$this->setMetaData('host',
			array(
				'Name'         =>
					'National Museum of Natural History
					(NMNH)',
				'Code'         => 'NMNH',
				'RelatedInformation' =>
					'http://www.mnh.si.edu/',
				'Abstract'     =>
					'Data provider via EMu/DiGIR',
			)
		);

		// add contacts to host
		$this->setMetaData('host contact',
			array(
				'Type'         => 'Administrative',
				'Name'         => 'Anna Weitzman',
				'Title'        =>
					'NMNH Informatics Office Manager',
				'Email'        => 'weitzman@si.edu',
				'Phone'        => '+01 202 633 0846',
			)
		);

		$this->setMetaData('host contact',
			array(
				'Type'         => 'Technical',
				'Name'         => 'Dennis Hasch',
				'Title'        => 'NMNH Webmaster',
				'Email'        => 'haschd@si.edu',
				'Phone'        => '+01 202 633 0848',
			)
		);

		 // add a resource
		$this->setMetadata('resource',
			array(
				'Name'         => 'NMNH Collections',
				'Code'         => 'NmnhEMu',
				'RelatedInformation' => 
					'http://www.mnh.si.edu/rc/db/colldb.html',
				'Abstract'     =>
					'NMNH Collections records (test DiGIR
					access system) 8784 Bryozoa, 67658
					Coelenterates, 220481 Crustacea, 
					75036 Echinoderms, 469 Invertebrate
					Zoology, 209175 Mollusks, 28782
					Porifera, 16469 Tunicates, 160300
					Worms',
				'Keywords'     => 'Invertebrate Zoology,
					Smithsonian, NMNH, Museum, specimen, 
					taxonomy, Bryozoa, Coelenterates,
					Crustacea, Echinoderms, Invertebrate
					Zoology, Mollusks, Porifera,
					Tunicates, Worms',
				'Citation' 
					=> 'Not for publication - test data only',
				'UseRestrictions'    
					=> 'See: http://www.mnh.si.edu/rc/db/2data_access_policy.html',
				'ConceptualSchema' 
					=> 'http://digir.net/schema/conceptual/darwin/2003/1.0',
				'SchemaLocation' 
					=> 'http://bnhm.berkeley.museum/DwC/bnhm_dc2_schema.xsd',
				'RecordIdentifier'   => 'NmnhEMu',
				'RecordBasis'        => 'voucher',
				'NumberOfRecords'    => '787478',
				'DateLastUpdated' 
					=> '1970-01-01 00:00:00.00Z',
				'MinQueryTermLength' => '0',
				'MaxSearchResponseRecords' => '1000',
				'MaxInventoryResponseRecords' => '1000',
			)
		);

		// add any contacts to this resource
		$this->setMetaData('resource contact',
			array(
				'Type'         => 'Administrative',
				'Name'         => 'Anna Weitzman',
				'Title'        => 'NMNH Informatics Office Manager',
				'Email'        => 'weitzman@si.edu',
				'Phone'        => '+01 202 633 0846',
			)
		);
		$this->setMetaData('resource contact',
			array(
				'Type'         => 'Technical',
				'Name'         => 'Dennis Hasch',
				'Title'        => 'NMNH Webmaster',
				'Email'        => 'haschd@si.edu',
				'Phone'        => '+01 202 633 0848',
			)
		);

		 // add another resource
		$this->setMetaData('resource',
			array(
				'Name'         =>
					'NMNH Invertebrate Collections',
				'Code'         => 'USNM',
				'RelatedInformation' =>
					'http://www.nmnh.si.edu/iz',

				'Abstract'     =>
					'NMNH Collections records (test DiGIR
					access system) 8784 Bryozoa, 67658
					Coelenterates, 220481 Crustacea, 75036
					Echinoderms, 469 Invertebrate Zoology,
					209175 Mollusks, 28782 Porifera, 16469
					Tunicates, 160300 Worms', 
				'Keywords'
					=> 'Invertebrate Zoology, Smithsonian,
					NMNH, Museum, specimen, taxonomy,
					Bryozoa, Coelenterates, Crustacea,
					Echinoderms, Invertebrate Zoology,
					Mollusks, Porifera, Tunicates, Worms',
				'Citation'     =>
					'Not for publication - test data only',
				'UseRestrictions'    =>
					'See: http://www.mnh.si.edu/rc/db/2data_access_policy.html',
				'ConceptualSchema'   =>
					'http://digir.net/schema/conceptual/darwin/2003/1.0',
				'SchemaLocation'     =>
					'http://bnhm.berkeley.museum/DwC/bnhm_dc2_schema.xsd',
				'RecordIdentifier'   => 'NmnhEMu',
				'RecordBasis'        => 'voucher',
				'NumberOfRecords'    => '787478',
				'DateLastUpdated'    => '1970-01-01 00:00:00.00Z',
				'MinQueryTermLength' => '0',
				'MaxSearchResponseRecords' => '1000',
				'MaxInventoryResponseRecords' => '1000',
			)
		);

		// add any contacts to this resource
		$this->setMetaData('resource contact',
			array(
				'Type'         => 'Administrative',
				'Name'         => 'Linda Ward',
				'Title'        => 'NMNH Invertebrate Zoology, Data Manager',
				'Email'        => 'ward.linda@nmnh.si.edu',
				'Phone'        => '+01 202 633 1779',
			)
		);
		$this->setMetaData('resource contact',
			array(
				'Type'         => 'Technical',
				'Name'         => 'Dennis Hasch',
				'Title'        => 'NMNH Webmaster',
				'Email'        => 'haschd@si.edu',
				'Phone'        => '+01 202 633 0848',
			)
		);

		// if any simple mappings - specify them here - if here then
		// not required to write specific translation code for them in
		// generateValue or generateTexql methods 
		// (these should mostly be purpose built darwin fields in
		// catalogue)

		$this->setSimpleMapping('TypeStatus','IdeFiledAsTypeStatus');
		$this->setSimpleMapping('Kingdom','IdeFiledAsKingdom');
		$this->setSimpleMapping('Phylum','IdeFiledAsPhylum');
		$this->setSimpleMapping('Class','IdeFiledAsClass');
		$this->setSimpleMapping('Order','IdeFiledAsOrder');
		$this->setSimpleMapping('IdentifiedBy','IdeFiledAsIdentifiedByLocal');
		$this->setSimpleMapping('FieldNumber','BioSiteVisitNumbersLocal_tab');
		$this->setSimpleMapping('CollectorNumber','BioPrimaryCollNumber');
		$this->setSimpleMapping('Collector','BioPrimaryCollectorLocal');
		$this->setSimpleMapping('Country','BioCountryLocal_tab');
		$this->setSimpleMapping('StateProvince','BioProvinceStateLocal_tab');
		$this->setSimpleMapping('County','BioDistrictCountyShireLocal_tab');
		$this->setSimpleMapping('Island','BioIslandNameLocal');
		$this->setSimpleMapping('CatalogNumber','CatOtherNumbersValue_tab');
		$this->setSimpleMapping('CatalogNumberText','CatOtherNumbersValue_tab');
		// any fields not specified above should be coded into localised
		// generateValue and generateTexql methods
	}


	function generateTexql($field,$operator,$value)
	{
		/*
		Please ensure changes in logic here are reflected in
		generateValue method
		*/

		// leave this line in any client specific implementation
		if (($simple = Parent::generateTexql($field,$operator,$value)))
			return $simple;

		switch($field)
		{
			case 'InstitutionCode' :
				if (preg_match("/'US'/",$value))
					return "CatUnit $operator 'Botany'";
				if (preg_match("/'USNM'/",$value))
					return "CatMuseum $operator 'NMNH'";
				return "CatMuseum $operator $value";	
				break;

			case 'CollectionCode'  :
				$this->sayMissingRule($field);
				break;

			/*case 'CatalogNumber'  :
				return "CatOtherNumbersValue_tab $operator $value";
				break;

			case 'CatalogNumberText'  :
				return "CatOtherNumbersValue_tab $operator $value";
				break;*/

			case 'Sex'  :
				return "ZooSex_tab $operator [$value]";
				break;

			case 'Preparations'  :
				$this->sayMissingRule($field);
				break;

			case 'Tissues'  :
				return $this->sayNotQueryable($field);
				break;

			case 'HigherGeography'  :
				return "ecatalogue.BioOceanLocal_tab $operator $value OR ".
						"ecatalogue.BioSeaGulfLocal_tab $operator $value OR ".
						"ecatalogue.BioCountryLocal_tab $operator $value OR ".
						"ecatalogue.BioProvinceStateLocal_tab $operator $value OR ".
						"ecatalogue.BioDistrictCountyShireLocal_tab $operator $value OR ".
						"ecatalogue.BioIslandGroupingLocal $operator $value OR ".
						"ecatalogue.BioIslandNameLocal $operator $value";
				break;

			case 'IslandGroup'  :
				return "BioArchipelagoLocal $operator $value";
				break;

			case 'ContinentOcean'  :
				return "(EXISTS (BioContinentLocal_tab[BioContinentLocal] ".
					"WHERE BioContinentLocal $operator $value)) OR ".
					"(EXISTS (BioOceanLocal_tab[BioOceanLocal] ".
					" WHERE BioOceanLocal $operator $value))"; 
				break;

			case 'Locality'  :
				return "(BioVerbatimLocality $operator $value OR ".
					"(EXISTS (SqsCityTown_tab[SqsCityTown] WHERE SqsCityTown $operator $value)) OR ".  
					"BioPreciseLocationLocal $operator $value)";
				break;

			case 'YearCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'MonthCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'DayCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'StartYearCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'StartMonthCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'StartDayCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'EndYearCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'EndMonthCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'EndDayCollected'  :
				$this->sayMissingRule($field);
				break;

			case 'TimeCollected'  :
				return $this->sayNotQueryable($field);

			case 'VerbatimCollectingDate'  :
				return $this->sayNotQueryable($field);

			case 'FieldNotes'  :
				return $this->sayNotQueryable($field);

			case 'JulianDay'  :
				$this->sayMissingRule($field);
				break;

			case 'DecimalLatitude'  :
				$this->sayMissingRule($field);
				break;

			case 'DecimalLongitude'  :
				$this->sayMissingRule($field);
				break;

			case 'HorizontalDatum'  :
				return $this->sayNotQueryable($field);

			case 'CoordinateUncertaintyInMeters'  :
				return $this->sayNotQueryable($field);

			case 'OriginalCoordinateSystem'  :
				return $this->sayNotQueryable($field);

			case 'VerbatimLatitude'  :
				return $this->sayNotQueryable($field);

			case 'VerbatimLongitude'  :
				return $this->sayNotQueryable($field);

			case 'GeorefMethod'  :
				return $this->sayNotQueryable($field);

			case 'LatLongComments'  :
				return $this->sayNotQueryable($field);

			case 'MinimumElevationInMeters'  :
				return $this->sayNotQueryable($field);

			case 'MaximumElevationInMeters'  :
				return $this->sayNotQueryable($field);

			case 'VerbatimElevation'  :
				return $this->sayNotQueryable($field);

			case 'MinimumDepthInMeters'  :
				return $this->sayNotQueryable($field);

			case 'MaximumDepthInMeters'  :
				return $this->sayNotQueryable($field);

			case 'VerbatimDepth'  :
				return $this->sayNotQueryable($field);

			case 'Remarks'  :
				return $this->sayNotQueryable($field);

			case 'Family'  :
				return "((IdeFiledAsManuscript = 'No' OR 
						IdeFiledAsManuscript = 'Unknown') 
						AND IdeFiledAsFamily $operator $value)";
				break;

			case 'Genus'  :
				return "((IdeFiledAsManuscript = 'No' OR 
					IdeFiledAsManuscript = 'Unknown') 
					AND IdeFiledAsGenus $operator $value)";
				break;

			case 'Species'  :
				return "((IdeFiledAsManuscript = 'No' OR 
					IdeFiledAsManuscript = 'Unknown') 
					AND IdeFiledAsSpecies $operator $value)";
				break;

			case 'Subspecies'  :
				return "((IdeFiledAsManuscript = 'No' OR 
					IdeFiledAsManuscript = 'Unknown') AND 
					IdeFiledAsSubSpecies $operator $value)";
				break;

			case 'ScientificName'  :
				return "((IdeFiledAsManuscript = 'No' OR 
					IdeFiledAsManuscript = 'Unknown') 
					AND IdeFiledAsNameParts $operator $value)";
				break;

			case 'ScientificNameAuthor'  :
				return "((IdeFiledAsManuscript = 'No' OR 
					IdeFiledAsManuscript = 'Unknown') 
					AND IdeFiledAsNameParts $operator $value)";
				break;

			case 'HigherTaxon'  :
				return "(ecatalogue.IdeFiledAsKingdom $operator $value OR ".
						" ecatalogue.IdeFiledAsPhylum $operator $value OR".
						" ecatalogue.IdeFiledAsClass $operator $value OR".
						" ecatalogue.IdeFiledAsOrder $operator $value OR".
						" ecatalogue.IdeFiledAsFamily $operator $value OR".
						" ecatalogue.IdeFiledAsSubOrder $operator $value OR".
						" ecatalogue.IdeFiledAsSubfamily $operator $value OR".
						" ecatalogue.IdeFiledAsSubphylum $operator $value OR".
						" ecatalogue.IdeFiledAsSubClass $operator $value)";
				break;

			case 'IdentificationModifier'  :
				return $this->sayNotQueryable($field);


			case 'YearIdentified'  :
				$this->sayMissingRule($field);
				break;

			case 'MonthIdentified'  :
				$this->sayMissingRule($field);
				break;

			case 'DayIdentified'  :
				$this->sayMissingRule($field);
				break;

			case 'IndividualCount'  :
				return "CatSpecimenCount $operator $value";
				break;

			case 'OtherCatalogNumbers'  :
				return $this->sayNotQueryable($field);

			case 'RelatedCatalogedItems'  :
				return "RelObjectsRef_tab $operator $value";
				break;

			case 'CatalogNumberNumeric'  :
				return $this->sayNotQueryable($field);

			case 'BasisOfRecord'  :
				switch ($value)
				{
					case 'S':
						return "CatObjectType $operator 'Specimen Lot'";
						break;
					case  'O':
						return "CatObjectType $operator 'Observation'";
						break;
					case 'P':
						return "CatObjectType $operator 'image'";
						break;
					default :		
						return "CatObjectType $operator $value";
						break;
				}
				break;

			case 'DateLastModified'  :
				$this->sayMissingRule($field);
				break;

			case 'LifeStage'  :
				$this->sayMissingRule($field);
				break;

			case 'ColoquialName'  :
				return $this->sayNotQueryable($field);

			case 'AgeClass'  :
				return $this->sayNotQueryable($field);
				
			case 'GenBankNum'  :
				return $this->sayNotQueryable($field);

			case 'Notes'  :
				return $this->sayNotQueryable($field);

			default: 
				$this->addDiagnostic("Configuration Setting", 
					"Warning",
					"no handler for field '$field' in localised generateTexql()");
				break;
		}
		return '';
	}

	function generateValue($field,$record)
	{
		/* 
		Please ensure changes in logic here are reflected in
		generateTexql method
		*/


		// this routine specifies how to assemble EMu fields in the
		// passed record, into desired output fields

		// NB if no record passed assume this a call to find what EMu
		// fields need to be selected in a query for use in
		// translation.  Make sure all fields mentioned in translation
		// are returned in this case.


		// leave this line in any client specific implementation
		if ($simple = parent::generateValue($field,$record))
			return $simple;

		switch($field)
		{
			case 'InstitutionCode' :
				if (! $record)
					return "ecatalogue.CatMuseumAcronym, ecatalogue.CatSection, ecatalogue.CatUnit";
				else
				{
					if ($record['CatMuseum'] == 'NMNH')
					{
						if ($record['CatUnit'] == 'Botany')
							return 'US';
						else
							return 'USNM';
					}
					else
						return $record['CatMuseumAcronym'];
				}	
				break;

			case 'CollectionCode'  :
				if (! $record)
					return "ecatalogue.CatUnit, ecatalogue.CatCatalog, ecatalogue.CatDivision, ecatalogue.CatSection";
				switch ($record['CatUnit'])
				{
					case 'Invertebrate Zoology':
						if ($record['CatCatalog'] != 'Invertebrate Zoology')
							return $record['CatSection'] . ' : '. 
									$record['CatCatalog'];
						else
							return 'Invertebrate Zoology';
						break;
					case 'Vertebrate Zoology':
						return $record['CatSection'] . ' : '. 
									$record['CatDivision'];
						break;
					case 'Botany':
						return 'Botany';
						break;
					default :		
						return 'undetermined';
						break;
				}
			
				break;

			/*case 'CatalogNumber'  :
				if (! $record)
					return "ecatalogue.CatOtherNumbersValue_tab";
				else
					return $record['CatOtherNumbersValue_tab'];
				break;

			case 'CatalogNumberText'  :
				if (! $record)
					return "ecatalogue.CatOtherNumbersValue_tab";
				else
					return $record['CatOtherNumbersValue_tab'];
				break;*/

			case 'Sex'  :
				if (! $record)
					return "ecatalogue.ZooSex_tab";
				else
					return $record['ZooSex_tab'];
				break;

			case 'Preparations'  :
				if (! $record)
					return "ecatalogue.CatUnit, ecatalogue.ZooPreparation_tab, ecatalogue.CatObjectType"; 
				else
				{
					if ($record['CatUnit'] != 'Botany')
						return $record['ZooPreparation_tab'];
					else
						return $record['CatObjectType'];
				}

				break;

			case 'Tissues'  :
				return $this->sayNoMapping($field);
				break;

			case 'HigherGeography'  :
				if (! $record)
					return "ecatalogue.BioOceanLocal_tab, ecatalogue.BioSeaGulfLocal_tab, ".
						"ecatalogue.BioCountryLocal_tab, ecatalogue.BioProvinceStateLocal_tab, ".
						"ecatalogue.BioDistrictCountyShireLocal_tab, ecatalogue.BioIslandGroupingLocal, ".
						"ecatalogue.BioIslandNameLocal";
				else
				{
					$geography =  implode(
						$record['BioOceanLocal_tab'],
						$record['BioSeaGulfLocal_tab'],
						$record['BioCountryLocal_tab'],
						$record['BioProvinceStateLocal_tab'],
						$record['BioDistrictCountyShireLocal_tab'],
						$record['BioIslandGroupingLocal'],
						$record['BioIslandNameLocal'],
						':'
						);
					$geography = preg_replace('/:{2,}/',':',$geography);
					$geography = preg_replace('/^:|:$/','',$geography);
					return $geography;
				}
				break;


			case 'IslandGroup'  :
				if (! $record)
					return "ecatalogue.BioArchipelagoLocal";
				else
					return $record["BioArchipelagoLocal"];
				break;

			case 'ContinentOcean'  :
				if (! $record)
					return "ecatalogue.BioContinentLocal_tab, ecatalogue.BioOceanLocal_tab";
				else
					return implode (array($record['BioContinentLocal_tab'],
							$record['BioOceanLocal_tab']),':');
				break;

			case 'Locality'  :
				if (! $record)
					return "ecatalogue.BioVerbatimLocality, ecatalogue.SqsCityTown_tab, ecatalogue.BioPreciseLocationLocal";
				else
				{
					$geography =  implode(array(
						$record["BioVerbatimLocality"],
						$record["SqsCityTown_tab"],
						$record["BioPreciseLocationLocal"]),
						':');
					$geography = preg_replace('/:{2,}/',':',$geography);
					$geography = preg_replace('/^:|:$/','',$geography);
					return $geography;
				}
				break;

			case 'YearCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedFromLocal'],'Year');
				break;
			case 'MonthCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedFromLocal'],'Month');
				break;
			case 'DayCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedFromLocal'],'Day');
				break;
			case 'StartYearCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedFromLocal'],'Year');
				break;
			case 'StartMonthCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedFromLocal'],'Month');
				break;
			case 'StartDayCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedFromLocal'],'Day');
				break;

			case 'EndYearCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedToLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedToLocal'],'Year');
				break;

			case 'EndMonthCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedToLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedToLocal'],'Month');
				break;

			case 'EndDayCollected'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedToLocal";
				else
					return $this->emuDateComponent(
							$record['BioDateVisitedToLocal'],'Day');
				break;

			case 'TimeCollected'  :
				return $this->sayNoMapping($field);
				break;
			case 'VerbatimCollectingDate'  :
				return $this->sayNoMapping($field);
				break;

			case 'FieldNotes'  :
				return $this->sayNoMapping($field);
				break;

			case 'JulianDay'  :
				if (! $record)
					return "ecatalogue.BioDateVisitedFromLocal";
				else
					return $this->emuDate2JulianDay($record['BioDateVisitedFromLocal']);
				break;

			case 'Latitude'  :
				if (! $record)
					return "ecatalogue.DetCentroidLatitude";
				else
					return $this->emuLatLongToDecimal($record['DetCentroidLatitude']);
				break;

			case 'Longitude'  :
				if (! $record)
					return "ecatalogue.DetCentroidLongitude";
				else
					return $this->emuLatLongToDecimal($record['DetCentroidLongitude']);
				break;

			case 'DecimalLatitude'  :
				if (! $record)
					return "ecatalogue.DetCentroidLatitude";
				else
					return $this->emuLatLongToDecimal($record['DetCentroidLatitude']);
				break;

			case 'DecimalLongitude'  :
				if (! $record)
					return "ecatalogue.DetCentroidLongitude";
				else
					return $this->emuLatLongToDecimal($record['DetCentroidLongitude']);
				break;

			case 'HorizontalDatum'  :
				return $this->sayNoMapping($field);
				break;
			case 'CoordinateUncertaintyInMeters'  :
				return $this->sayNoMapping($field);
				break;
			case 'OriginalCoordinateSystem'  :
				return $this->sayNoMapping($field);
				break;
			case 'VerbatimLatitude'  :
				return $this->sayNoMapping($field);
				break;
			case 'VerbatimLongitude'  :
				return $this->sayNoMapping($field);
				break;
			case 'GeorefMethod'  :
				return $this->sayNoMapping($field);
				break;
			case 'LatLongComments'  :
				return $this->sayNoMapping($field);
				break;
			case 'MinimumElevationInMeters'  :
				return $this->sayNoMapping($field);
				break;
			case 'MaximumElevationInMeters'  :
				return $this->sayNoMapping($field);
				break;
			case 'VerbatimElevation'  :
				return $this->sayNoMapping($field);
				break;
			case 'MinimumDepthInMeters'  :
				if (! $record)
					return "ecatalogue.BioDepthFromMet";
				else
					return $record["BioDepthFromMet"];
				break;
			case 'MaximumDepthInMeters'  :
				if (! $record)
					return "ecatalogue.BioDepthToMet";
				else
					return $record["BioDepthToMet"];
				break;
			case 'VerbatimDepth'  :
				return $this->sayNoMapping($field);
				break;
			case 'Remarks'  :
				return $this->sayNoMapping($field);
				break;
				
			case 'Family'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsFamily, ecatalogue.IdeFiledAsManuscript";
				else
				{
					if ($record['IdeFiledAsManuscript'] == 'Yes')
						return '';
					else
						return $record['IdeFiledAsFamily'];
				}
				break;

			case 'Genus'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsGenus, ecatalogue.IdeFiledAsManuscript";
				else
				{
					if ($record['IdeFiledAsManuscript'] == 'Yes')
						return '';
					else
						return $record['IdeFiledAsGenus'];
				}
				break;

			case 'Species'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsSpecies, ecatalogue.IdeFiledAsManuscript";
				else
				{
					if ($record['IdeFiledAsManuscript'] == 'Yes')
						return '';
					else
						return $record['IdeFiledAsSpecies'];
				}
				break;

			case 'Subspecies'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsSubSpecies, ecatalogue.IdeFiledAsManuscript";
				else
				{
					if ($record['IdeFiledAsManuscript'] == 'Yes')
						return '';
					else
						return $record['IdeFiledAsSubSpecies'];
				}
				break;

			case 'ScientificName'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsNameParts, ecatalogue.IdeFiledAsManuscript,
						IdeFiledAsKingdom, IdeFiledAsPhylum,
						IdeFiledAsSubphylum, IdeFiledAsClass,
						IdeFiledAsSubClass, IdeFiledAsOrder,
						IdeFiledAsSubOrder, IdeFiledAsFamily,
						IdeFiledAsSubfamily";
				else
				{
					if ($record['IdeFiledAsManuscript'] == 'Yes')
					{
						$lowest = '';
						foreach (array(
								$record['IdeFiledAsKingdom'],
								$record['IdeFiledAsPhylum'],
								$record['IdeFiledAsSubphylum'],
								$record['IdeFiledAsClass'],
								$record['IdeFiledAsSubClass'],
								$record['IdeFiledAsOrder'],
								$record['IdeFiledAsSubOrder'],
								$record['IdeFiledAsFamily'],
								$record['IdeFiledAsSubfamily'],
								) as $higher)
						{
							if ($higher)
								$lowest = $higher;
						}
						return $lowest;
					}
					else
					{
						if (preg_match("/(.+)<auth>/",$record["IdeFiledAsNameParts"],$match))
							$name = $match[1];
						else
							$name = $record["IdeFiledAsNameParts"];
						$name = preg_replace('/<.+?>/','',$name);	
						return $name;
					}
				}
				break;

			case 'ScientificNameAuthor'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsNameParts, ecatalogue.IdeFiledAsManuscript";
				else
				{
					if ($record['IdeFiledAsManuscript'] == 'Yes')
						return '';
					else
					{
						if (preg_match("/<auth>(.+)<\/auth>/",$record["IdeFiledAsNameParts"],$match))
							$name = $match[1];
						else
							return '';
						$name = preg_replace('/<.+?>/','',$name);	
						return $name;
					}
				}
				break;

			case 'HigherTaxon'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsKingdom, ecatalogue.IdeFiledAsPhylum, ecatalogue.IdeFiledAsClass, ecatalogue.IdeFiledAsOrder, ecatalogue.IdeFiledAsFamily, ecatalogue.IdeFiledAsSubOrder, ecatalogue.IdeFiledAsSubfamily, ecatalogue.IdeFiledAsSubphylum, ecatalogue.IdeFiledAsSubClass";
				else
				{
					$higherTaxon =  implode(
						$record['IdeFiledAsKingdom'],
						$record['IdeFiledAsPhylum'],
						$record['IdeFiledAsSubphylum'],
						$record['IdeFiledAsClass'],
						$record['IdeFiledAsSubClass'],
						$record['IdeFiledAsOrder'],
						$record['IdeFiledAsSubOrder'],
						$record['IdeFiledAsFamily'],
						$record['IdeFiledAsSubfamily'],
						':'
						);
					$higherTaxon = preg_replace('/:{2,}/',':',$higherTaxon);
					$higherTaxon = preg_replace('/^:|:$/','',$higherTaxon);
					return $higherTaxon;
				}
				break;

			case 'IdentificationModifier'  :
				return $this->sayNoMapping($field);
				break;

			case 'YearIdentified'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsDateIdentified";
				else
					return $this->emuDateComponent(
						$record['IdeFiledAsDateIdentified'],'Year');
				break;

			case 'MonthIdentified'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsDateIdentified";
				else
					return $this->emuDateComponent(
						$record['IdeFiledAsDateIdentified'],'Month');
				break;

			case 'DayIdentified'  :
				if (! $record)
					return "ecatalogue.IdeFiledAsDateIdentified";
				else
					return $this->emuDateComponent(
						$record['IdeFiledAsDateIdentified'],'Day');
				break;

			case 'IndividualCount'  :
				if (! $record)
					return "ecatalogue.CatSpecimenCount";
				else
					return $records["CatSpecimenCount"];
				break;

			case 'OtherCatalogNumbers'  :
				return $this->sayNoMapping($field);
				break;

			case 'RelatedCatalogedItems'  :
				if (! $record)
					return "ecatalogue.RelObjectsRef_tab";
				else
					return $record["RelObjectsRef_tab"];
				break;

			case 'CatalogNumberNumeric'  :
				return $this->sayNoMapping($field);
				break;

			case 'BasisOfRecord'  :
				if (! $record)
					return  "ecatalogue.CatObjectType";
				else	
					switch ($record['CatObjectType'])
					{
						case 'Specimen Lot':
							return 'S';
							break;
						case  'Observation':
							return 'O';
							break;
						case 'image':
							return 'P';
							break;
						case '':
							return '';
							break;
						default :		
							return '?';
							break;
					}
				break;

			case 'DateLastModified'  :
				if (! $record)
					return "ecatalogue.AdmDateModified, ecatalogue.AdmTimeModified";
				else
				{
					return DigirProvider::emuDate2Iso8601Time(
					$record['AdmDateModified'],
					$record['AdmTimeModified']);
				}
				break;

			case 'LifeStage'  :
				if (! $record)
					return "ecatalogue.ZooStage_tab, ecatalogue.BotPhenology";
				else
				{
					if ($record['CatUnit'] != 'Botany')
						return $record['ZooStage_tab'];
					else
						return $record['BotPhenology'];
				}
				break;

			case 'ColoquialName'  :
				return $this->sayNoMapping($field);
				break;
			case 'AgeClass'  :
				return $this->sayNoMapping($field);
				break;
			case 'GenBankNum'  :
				return $this->sayNoMapping($field);
				break;
			case 'Notes' :
				return $this->sayNoMapping($field);
				break;
			default: 
				$this->addDiagnostic("Configuration Setting", 
					"Warning",
					"no handler for field '$field' in localised generateValue()");
				break;
		}
		return '';
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'DigirProviderFactory.php')
	{
		$factory = new DigirProviderFactory;
		if ($webservice = $factory->getInstance())
		{
			$webservice->configure();
			$webservice->test(true);
		}
	}
}


?>
