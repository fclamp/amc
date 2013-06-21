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
		if ($provider = new NhmDigirProviderr())
		{
			$provider->configure();
			return $provider;
		}
		return null;
	}
}


/*  Class for client specific field mappings.
*/



class NhmDigirProvider extends DigirProvider
{

	/* To CONFIGURE A DiGIR SYSTEM to an EMu Client
	 *
	 * 1. add metadata entries in the configure method
	 * 2. implement generateTexql method
	 * 3. implement generateValue method
	 *
	 */

	var $serviceName = "NhmDigirProvider";

	function describe()
	{
		return	
			"A NHM Digir Provider is a Natural History Museum client specific\n".
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
			"			<darwin:Genus>Helix</darwin:Genus>\n".
			"		</equals>\n".
			"		<equals>\n".
			"			<darwin:Genus>Conus</darwin:Genus>\n".
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
					'Natural History Museum', 
				'Implementation'=>
					'KE Software EMu, 
					PHP KE EMu DiGIR Interface',
				'AccessPoint'  => 'default',
			)
		);
		$this->setMetaData('host',
			array(
				'Name'         =>
					'Natural History Museum (NHM)',
				'Code'         => 'NHM',
				'RelatedInformation' =>
					'',
				'Abstract'     =>
					'Data provider via EMu/DiGIR',
			)
		);

		// add contacts to host
		$this->setMetaData('host contact',
			array(
				'Type'         => 'Administrative',
				'Name'         => '',
				'Title'        => '',
				'Email'        => '',
				'Phone'        => '',
			)
		);

		$this->setMetaData('host contact',
			array(
				'Type'         => 'Technical',
				'Name'         => '',
				'Title'        => '',
				'Email'        => '',
				'Phone'        => '',
			)
		);

		 // add a resource
		$this->setMetadata('resource',
			array(
				'Name'         => 'NHM Collections',
				'Code'         => 'NhmEMu',
				'RelatedInformation' => 
					'',
				'Abstract'     =>
					'',
				'Keywords'     => '',
				'Citation' 
					=> 'Not for publication - test data only',
				'UseRestrictions'    
					=> '',
				'ConceptualSchema' 
					=> 'http://digir.net/schema/conceptual/darwin/2003/1.0',
				'SchemaLocation' 
					=> 'http://digir.sourceforge.net/schema/conceptual/darwin/full/2003/1.0/darwin2full.xsd',
				'RecordIdentifier'   => 'NhmEMu',
				'RecordBasis'        => '',
				'NumberOfRecords'    => '23',
				'DateLastUpdated' => '1970-01-01 00:00:00.00Z',
				'MinQueryTermLength' => '0',
				'MaxSearchResponseRecords' => '1000',
				'MaxInventoryResponseRecords' => '1000',
			)
		);

		// add any contacts to this resource
		$this->setMetaData('resource contact',
			array(
				'Type'         => 'Administrative',
				'Name'         => '',
				'Title'        => '',
				'Email'        => '',
				'Phone'        => '',
			)
		);
		$this->setMetaData('resource contact',
			array(
				'Type'         => 'Technical',
				'Name'         => '',
				'Title'        => '',
				'Email'        => '',
				'Phone'        => '',
			)
		);


		// if any simple mappings - specify them here - if here then
		// not required to write specific translation code for them in
		// generateValue or generateTexql methods 
		// (these should mostly be purpose built darwin fields in
		// catalogue)

		$this->setSimpleMapping('Kingdom','DarKingdom');
		$this->setSimpleMapping('Phylum','DarPhylum');
		$this->setSimpleMapping('Class','DarClass');
		$this->setSimpleMapping('Order','DarOrder');
		$this->setSimpleMapping('Family','DarFamily');
		$this->setSimpleMapping('Genus','DarGenus');
		$this->setSimpleMapping('Species','DarSpecies');
		$this->setSimpleMapping('Subspecies','DarSubspecies');
		$this->setSimpleMapping('ScientificName','DarScientificName');
		$this->setSimpleMapping('TypeStatus','DarTypeStatus');
		$this->setSimpleMapping('IdentifiedBy','DarIdentifiedBy');
		$this->setSimpleMapping('Collector','DarCollector');
		$this->setSimpleMapping('Country','DarCountry');
		$this->setSimpleMapping('StateProvince','DarStateProvince');
		$this->setSimpleMapping('County','DarCounty');
		$this->setSimpleMapping('CatalogNumber','DarCatalogNumber');
		$this->setSimpleMapping('Locality','DarLocality');
		$this->setSimpleMapping('Latitude','DarLatitude');
		$this->setSimpleMapping('Longitude','DarLongitude');
		// any fields NOT specified above should be coded into localised
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
			default: 
				$this->addDiagnostic("Configuration Setting", 
					"Warning",
					"no handler for $field in localised generateValue()");
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
		if (($simple = parent::generateValue($field,$record)))
			return $simple;

		switch($field)
		{
			case "InstitutionCode": 
				if (! $record)
					return "";
				else	
					return "NHM";
				break;

			default: 
				$this->addDiagnostic("Configuration Setting", 
					"Warning",
					"no handler for $field in localised generateValue()");
				break;
		}
		return '';
	}

}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Digir.php')
	{
		$actualProvider = new NhmDigir($BACKEND_TYPE,$WEB_ROOT,$WEB_DIR_NAME);
		$actualProvider->configure();
		$actualProvider->test(true);
	}
}


?>
