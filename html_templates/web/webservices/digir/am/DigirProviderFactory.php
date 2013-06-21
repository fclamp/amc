<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */

// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/digir/DigirProvider.php');

class DigirProviderFactory
{
	function getInstance()
	{
		if ($provider = new AmDigirProvider())
		{
			$provider->configure();
			return $provider;
		}
		return null;
	}
}


/**
 *
 * Client Specific Digir Provider
 *
 * Normally Created by a Factory class
 * DigirProviderFactory
 *
 * Copyright (c) 2005 - KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class AmDigirProvider extends DigirProvider
{

	/* To CONFIGURE A DiGIR SYSTEM to an EMu Client
	 *
	 * 1. add metadata entries and mappings in the configure method
	 * 2. implement generateTexql method
	 * 3. implement generateValue method
	 *
	 */

	var $serviceName = "AmDigirProvider";
	var $version = "AM KE EMu DiGIR Interface";

	// set to false to disable browser stylesheet rendering
	//var $xslSheet = false;
	var $xslSheet = "digir/style/digir.xsl";

	// set this to false for faster responses (may be needed on heavily
	// loaded/slow servers) - it won't return total match count to DiGIR
	// but avoids running 2 queries for each search.  
	var $enableTotalCountQuery = false;

	function describe()
	{
		return	
			"A AM Digir Provider is a AM client specific\n".
			"Digir Provider\n\n".
			parent::describe();
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

		$this->setProvider(Array(
				'Name'         =>
					'Australian Museum',
				'Implementation'=>
					'KE Software EMu, 
					PHP KE EMu DiGIR Interface',
				'AccessPoint'  => 'default',
			)
		);
		$this->setHost(Array(
				'Name'         =>
					'Australian Museum (AM)',
				'Code'         => 'AM',
				'RelatedInformation' =>
					'http://www.austmus.gov.au/',
				'Abstract'     =>
					'Data provider via EMu/DiGIR',
			)
		);

		// add contacts to host
		$this->addHostContact(Array(
				'Type'         => 'Administrative',
				'Name'         => 'not available',
				'Title'        => 'AM EMu Administrator',
				'Email'        => '',
				'Phone'        => '',
			)
		);

		$this->addHostContact(Array(
				'Type'         => 'Technical',
				'Name'         => 'not available',
				'Title'        => 'AM EMu Administrator',
				'Email'        => '',
				'Phone'        => '',
			)
		);

		 // add a resource
		$resourceId = $this->addResource(Array(
				'Name'         => 'AM Collections',
				'Code'         => 'AmEMu',
				'RelatedInformation' => 
					'http://www.mnh.si.edu/rc/db/colldb.html',
				'Abstract'     => 'AM Collections',
				'Keywords'     => '',
				'Citation'     => 'Not for publication - test data only',
				'UseRestrictions'    
					=> 'Not for publication - test data only',
				'ConceptualSchema' 
					=> 'http://digir.net/schema/conceptual/darwin/2003/1.0',
				'SchemaLocation' 
					=> 'http://bnhm.berkeley.edu/DwC/bnhm_dc2_schema.xsd',
				'RecordIdentifier'   => 'AmEMu',
				'RecordBasis'        => 'voucher',
				'NumberOfRecords'    => '',
				'DateLastUpdated' 
					=> '1970-01-01 00:00:00.00Z',
				'MinQueryTermLength' => '0',
				'MaxSearchResponseRecords' => '1000',
				'MaxInventoryResponseRecords' => '1000',
			)
		);

		// add any contacts to this resource
		$this->addResourceContact($resourceId,Array(
				'Type'         => 'Administrative',
				'Name'         => 'not available',
				'Title'        => 'AM EMu Administrator',
				'Email'        => '',
				'Phone'        => '',
			)
		);
		$this->addResourceContact($resourceId,Array(
				'Type'         => 'Technical',
				'Name'         => 'not available',
				'Title'        => 'AM EMu Administrator',
				'Email'        => '',
				'Phone'        => '',
			)
		);

		// these filters will be added to any Texql query based on the
		// resource code passed in DiGIR request
		// setResourceFilter(Code,Filter)
		$this->setResourceFilter("AmEMu","TRUE");

		// suggested queries used by xslt test pages
		// addSuggestedTestQuery(resourceCode,darwinCoreQuery)
		$this->addSuggestedTestQuery("AmEMu","Species = aspersa");

		// if any simple mappings - specify them here - if here then
		// not required to write specific translation code for them in
		// generateValue or generateTexql methods 
		// (these should mostly be purpose built darwin fields in
		// catalogue)

		$this->setSimpleMapping('Kingdom','QuiTaxonKingdom');
		$this->setSimpleMapping('Phylum','QuiTaxonomyPhylum');
		$this->setSimpleMapping('Class','QuiTaxonomyClass');
		$this->setSimpleMapping('Order','QuiTaxonomyOrder');
		$this->setSimpleMapping('Family','QuiTaxonomyFamily');
		$this->setSimpleMapping('Genus','QuiTaxonomyGenus');
		$this->setSimpleMapping('Subgenus','QuiTaxonomySubGenus');
		$this->setSimpleMapping('Species','QuiTaxonomySpecies');
		$this->setSimpleMapping('Subspecies','QuiTaxonomySubSpecies');
		$this->setSimpleMapping('ScientificName','QuiTaxonScientificName');
		$this->setSimpleMapping('Latitude','QuiLatitude0');
		$this->setSimpleMapping('Longitude','QuiLongitude0');
		
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
		if (($simple = parent::generateTexql($field,$operator,$value)))
			return $simple;

		// please try and keep this roughly alphabetical
		switch($field)
		{
			case 'CatalogNumber'  :
				List($prefix,$number) = preg_split("/\./",$value);
				return "(CatPrefix $operator $prefix AND (CatNumber $operator $number";
				break;
			case 'InstitutionCode' :
				if ($value == 'AM' )
					return "TRUE";
				else
					return "FALSE";
				break;

			case 'AgeClass' :
			case 'BasisOfRecord' :
			case 'CatalogNumberNumeric' :
			case 'CatalogNumberText' :
			case 'CollectionCode' :
			case 'Collector' :
			case 'CollectorNumber' :
			case 'ContinentOcean' :
			case 'CoordinateUncertaintyInMeters' :
			case 'Country' :
			case 'County' :
			case 'DateLastModified' :
			case 'DayCollected' :
			case 'DayIdentified' :
			case 'DecimalLatitude' :
			case 'DecimalLongitude' :
			case 'FieldNotes' :
			case 'FieldNumber' :
			case 'GenBankNum' :
			case 'GeorefMethod' :
			case 'HorizontalDatum' :
			case 'IdentificationModifier' :
			case 'IdentifiedBy' :
			case 'IndividualCount' :
			case 'Island' :
			case 'IslandGroup' :
			case 'JulianDay' :
			case 'LatLongComments' :
			case 'Locality' :
			case 'MaximumDepthInMeters' :
			case 'MaximumElevationInMeters' :
			case 'MinimumDepthInMeters' :
			case 'MinimumElevationInMeters' :
			case 'MonthCollected' :
			case 'MonthIdentified' :
			case 'OriginalCoordinateSystem' :
			case 'OtherCatalogNumbers' :
			case 'Preparations' :
			case 'RelatedCatalogedItems' :
			case 'Remarks' :
			case 'ScientificNameAuthor' :
			case 'Sex' :
			case 'StateProvince' :
			case 'TimeCollected' :
			case 'Tissues' :
			case 'TypeStatus' :
			case 'VerbatimCollectingDate' :
			case 'VerbatimDepth' :
			case 'VerbatimElevation' :
			case 'VerbatimLatitude' :
			case 'VerbatimLongitude' :
			case 'YearCollected' :
			case 'YearIdentified' :
				$this->sayNotQueryable($field);
				break;

			default: 
				$this->addDiagnostic("Configuration Setting", 
					"Warning",
					"no handler for field '$field' in localised generateTexql()");
				return "TRUE";
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

		// please try and keep this roughly alphabetical
		switch($field)
		{
			case 'CatalogNumber'  :
				if (! $record)
					return "ecatalogue.CatPrefix, ecatalogue.CatNumber";
				else
					return $record['CatPrefix'] .".". $record['CatNumber'];
				break;
			case 'InstitutionCode' :
				if (! $record)
					return "";
				else
					return "AM";
				break;
			
			case 'AgeClass' :
			case 'BasisOfRecord' :
			case 'CatalogNumberNumeric' :
			case 'CatalogNumberText' :
			case 'CollectionCode' :
			case 'Collector' :
			case 'CollectorNumber' :
			case 'ContinentOcean' :
			case 'CoordinateUncertaintyInMeters' :
			case 'Country' :
			case 'County' :
			case 'DateLastModified' :
			case 'DayCollected' :
			case 'DayIdentified' :
			case 'DecimalLatitude' :
			case 'DecimalLongitude' :
			case 'FieldNotes' :
			case 'FieldNumber' :
			case 'GenBankNum' :
			case 'GeorefMethod' :
			case 'HorizontalDatum' :
			case 'IdentificationModifier' :
			case 'IdentifiedBy' :
			case 'IndividualCount' :
			case 'Island' :
			case 'IslandGroup' :
			case 'JulianDay' :
			case 'LatLongComments' :
			case 'Locality' :
			case 'MaximumDepthInMeters' :
			case 'MaximumElevationInMeters' :
			case 'MinimumDepthInMeters' :
			case 'MinimumElevationInMeters' :
			case 'MonthCollected' :
			case 'MonthIdentified' :
			case 'OriginalCoordinateSystem' :
			case 'OtherCatalogNumbers' :
			case 'Preparations' :
			case 'RelatedCatalogedItems' :
			case 'Remarks' :
			case 'ScientificNameAuthor' :
			case 'Sex' :
			case 'StateProvince' :
			case 'TimeCollected' :
			case 'Tissues' :
			case 'TypeStatus' :
			case 'VerbatimCollectingDate' :
			case 'VerbatimDepth' :
			case 'VerbatimElevation' :
			case 'VerbatimLatitude' :
			case 'VerbatimLongitude' :
			case 'YearCollected' :
			case 'YearIdentified' :
				$this->sayNoMapping($field);
				break;
			
			default: 
				$this->addDiagnostic("Configuration Setting", 
					"Warning",
					"no handler for field '$field' in localised generateValue()");
				break;
		}
		return '';
	}

	function testQueryTerms()
	{
		// a test filter and records that can be used to confirm
		// system is functional
		return  "<filter>\n".
			"	<or>\n".
			"		<equals>\n".
			"			<darwin:Genus>Conus</darwin:Genus>\n".
			"		</equals>\n".
			"		<equals>\n".
			"			<darwin:Genus>Helix</darwin:Genus>\n".
			"		</equals>\n".
			"	</or>\n".
			"</filter>\n".
			"<records start='0' limit='5'>\n".
			"	<structure schemaLocation='http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd'/>\n".
			"</records> \n";
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
