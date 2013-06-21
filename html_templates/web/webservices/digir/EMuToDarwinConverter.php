<?php

/*
 *  Copyright (c) 2005 - KE Software Pty Ltd
 */


// NB this file probably best viewed with tabspace=3 if using 80
// character line terminal



if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/Provider.php');


/**
 * 
 * Class EMuToDarwinConverter
 *
 * class provides parsing methods to assist in taking an EMu Response and
 * translating it into Darwin Core XML.
 * NB it is NOT a EMuWebService 'translator'
 *
 * Copyright (c) 2005 - KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class EMuToDarwinConverter extends BaseWebServiceObject
{

	// this class provides parsing methods to assist in taking an EMu xml
	// response and translating it into Darwin Core XML

	var $provider;

	var $emuResponse = array();
	var $emuRecord = array();
	var $emuField;
	var $multiValue = false;

	var $_errors = Array();

	function setProvider($provider)
	{
		$this->provider = $provider;
	}

	function describe()
	{
		return	
			"A EMuToDarwin Converter is a tool to convert EMu data into Darwin Core XML\n\n".
			parent::describe();
	}

	function startEMuElement($p,$element,$attrib)
	{
		switch ($this->parserMode)
		{
			case 'wantResults' :
				if ($element == 'results')
				{
					$this->resultsAttrib = $attrib;
					$this->parserMode = 'wantRecord';
					$this->emuResponse = array();
					$this->emuRecord = array();
				}
				else
				{
					$this->parserMode = 'failed';
					$this->addError("expecting 'results' element got '$element'");
				}
				break;
			case 'wantRecord' :
				if ($element == 'record')
				{
					$this->parserMode = 'wantElement';
				}
				else
				{
					$this->parserMode = 'failed';
					$this->addError("expecting 'record' element got '$element'");
				}
				break;
			case 'wantElement' :
				$this->multiValue = false;
				$this->parserMode = 'readingElement';
				$this->emuField = $element;
				$this->emuRecord[$element] = '';
				break;
			case 'readingElement' :
				// new element found when reading anothers element data
				// eg occurs with something like
				//	<ZooSex_tab><ZooSex>Male</ZooSex></ZooSex_tab>
				// treat new element as parent element but keep
				// a note the parent element is a multivalue
				// item
				$this->multiValue = true;
				break;
			case 'resultsFound' :
				$this->addError("Cannot parse xml. Unexpected content at '$element'" );
				$this->parserMode = 'failed';
				break;
			case 'failed' :
				break;
			default:
				$this->addError("Cannot parse xml. Unimplemented Parser Mode 
							'$this->parserMode' at start element $element");
				$this->parserMode = 'failed';
				break;
		}
	}

	function endEMuElement($p,$element)
	{
		switch ($this->parserMode)
		{
			case 'wantRecord' :
				switch($element)
				{
					case 'results':
						$this->parserMode = 'resultsFound';
						break;
					case 'record':
						$this->parserMode = 'wantRecord';
						break;
					default:
						$this->addError("Cannot parse xml. unexpected end of '$element'");
						$this->parserMode = 'failed';
					break;	
				}
				break;
			case 'readingElement' :
				if ($element == $this->emuField)
					$this->parserMode = 'wantElement';
				break;
			case 'wantElement' :
				if ($element == 'record')
				{
					$this->parserMode = 'wantRecord';
					$this->emuResponse[] = 
						$this->provider->_emuRecordToDarwin($this->emuRecord);

				}
				break;
			case 'resultsFound' :
				$this->addError("Cannot parse xml. Unexpected content at '$element'" );
				$this->parserMode = 'failed';
				break;
				
			case 'failed' :
				break;
			default:
				$this->addError("Cannot parse xml. Unimplemented Parser Mode 
							'$this->parserMode' at end element $element");
				$this->parserMode = 'failed';
				break;
		}
	}
	function emuCharacterData($p,$data)
	{
		switch ($this->parserMode)
		{
			case 'readingElement' :
				$data = preg_replace('/&/','&amp;',$data);
				$data = preg_replace('/</','&lt;',$data);

				if ($this->emuRecord[$this->emuField])
				{
					if ($this->multiValue)
						$join = ' : ';
					else
						$join = '';

					$this->emuRecord[$this->emuField] .= $join.$data;
				}
				else
				{
					$this->emuRecord[$this->emuField] = $data;
				}
				break;
			case 'wantRecord' :
			case 'wantElement' :
			case 'resultsFound' :
				if (preg_match('/\S/',$data))
				{
					$this->addError("Cannot parse xml. Unexpected content (mode $this->parserMode)
							'$data'" );
					$this->parserMode = 'failed';
				}
				break;
			case 'failed' :
				break;
			default:
				$this->addError("Cannot parse xml. Unimplemented Parser Mode 
							'$this->parserMode' at end element $element");
				$this->parserMode = 'failed';
				break;
		}
	}

	function emuResponseToDarwin($xml)
	{
		// take emu xml records and translate into darwin core records
		$this->parserMode = 'wantResults';


		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->parser,$this);
		xml_set_element_handler($this->parser,'startEMuElement','endEMuElement');
		xml_set_character_data_handler($this->parser,'emuCharacterData');

		xml_parse($this->parser,$xml,true);

		xml_parser_free($this->parser);

		$records = '';
		foreach ($this->emuResponse as $record)
		{

			$records .= "<record>\n";
			foreach ($record as $field => $value)
			{
				if ($value)
				{
					$records .= "\t<darwin:$field>$value</darwin:$field>\n";
				}
				
			}
			$records .= "</record>\n";
		}
		
		return array(count($this->emuResponse), $records);

	}

	function addError($message)
	{
		$this->_errors[] = $message;
	}

	function makeTestPage()
	{
		$args = array();
		$args['EMu Data'] =  "<textarea cols='80' rows='15' name='emuResults'>".
'<results>
  <record>
    <AdmDateModified>06/05/2005</AdmDateModified>
    <AdmTimeModified>17:15</AdmTimeModified>
    <CatMuseumAcronym/>
    <CatSection>Invertebrate Zoology</CatSection>
    <CatUnit>Invertebrate Zoology</CatUnit>
    <CatCatalog>Mosquito</CatCatalog>
    <CatDivision>Entomology</CatDivision>
    <CatOtherNumbersValue_tab>
      <CatOtherNumbersValue>60002400</CatOtherNumbersValue>
      <CatOtherNumbersValue>60002300</CatOtherNumbersValue>
      <CatOtherNumbersValue>0</CatOtherNumbersValue>
    </CatOtherNumbersValue_tab>
    <IdeFiledAsNameParts>
		&lt;genus&gt;Anopheles&lt;/genus&gt; (&lt;subgenus&gt;Nyssorhynchus&lt;/subgenus&gt;) &lt;species&gt;albimanus&lt;/species&gt;
	</IdeFiledAsNameParts>
    <IdeFiledAsManuscript>Unknown</IdeFiledAsManuscript>
    <IdeFiledAsKingdom/>
    <IdeFiledAsPhylum/>
    <IdeFiledAsSubphylum/>
    <IdeFiledAsClass/>
    <IdeFiledAsSubClass/>
    <IdeFiledAsOrder>Diptera</IdeFiledAsOrder>
    <IdeFiledAsSubOrder/>
    <IdeFiledAsFamily>Culicidae</IdeFiledAsFamily>
    <IdeFiledAsSubfamily>Anophelinae</IdeFiledAsSubfamily>
    <CatObjectType>Mass Rearing</CatObjectType>
    <IdeFiledAsGenus>Anopheles</IdeFiledAsGenus>
    <IdeFiledAsSpecies>albimanus</IdeFiledAsSpecies>
    <IdeFiledAsSubSpecies/>
    <IdeFiledAsIdentifiedByLocal>Faran, M E</IdeFiledAsIdentifiedByLocal>
    <IdeFiledAsDateIdentified/>
    <IdeFiledAsTypeStatus/>
    <BioPrimaryCollNumber/>
    <BioSiteVisitNumbersLocal_tab>
	</BioSiteVisitNumbersLocal_tab>
    <BioPrimaryCollectorLocal>Giovannoli, L</BioPrimaryCollectorLocal>
    <BioDateVisitedFromLocal>01/04/1953</BioDateVisitedFromLocal>
    <BioContinentLocal_tab>
	</BioContinentLocal_tab>
    <BioOceanLocal_tab>
	</BioOceanLocal_tab>
    <BioCountryLocal_tab>
      <BioCountryLocal>Bahama Is</BioCountryLocal>
    </BioCountryLocal_tab>
    <BioProvinceStateLocal_tab>
      <BioProvinceStateLocal>Eleuthera (island)</BioProvinceStateLocal>
    </BioProvinceStateLocal_tab>
    <BioDistrictCountyShireLocal_tab>
	</BioDistrictCountyShireLocal_tab>
    <BioVerbatimLocality/>
    <SqsCityTown_tab>
      <SqsCityTown>James Cistern</SqsCityTown>
    </SqsCityTown_tab>
    <BioPreciseLocationLocal/>
    <DetCentroidLongitude>076 20 00 W</DetCentroidLongitude>
    <DetCentroidLatitude>25 17  N</DetCentroidLatitude>
    <ZooSex_tab>
      <ZooSex>Female</ZooSex>
    </ZooSex_tab>
    <CatSpecimenCount/>
  </record>
</results>'.
		"</textarea>";

		$args["Darwin Fields To Extract"] = "<input type='text' name='select'  size='40' value='Genus,Species' />\n";
		$vars = array();
		$vars['class'] = 'EMuToDarwinConverter';
		$vars['test'] = 'true';
		$vars['testCall'] = 'true';

		$submission = "<input type='submit' name='action' value='translate' />";

		print $this->makeDiagnosticPage(
					"KE EMu ". $this->serviceName,
					"EMu-DiGIR EMu To Darwin Converter Test",
					$js,
					'./EMuToDarwinConverter.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}

	function test($serviceSpecific=false)
	{
		if (! $serviceSpecific)
			parent::test();
		else	
		{
			if (isset($_REQUEST['testCall']))
			{
				require_once ($this->webRoot . "/webservices/digir/". $this->backendType ."/DigirProviderFactory.php");
				$factory = new DigirProviderFactory;
				if (! $digir = $factory->getInstance())
					Provider::errorResponse('Failure to get instance in EMuToDarwinConverter.php');
				$digir->select = $_REQUEST['select'];

				$this->setProvider($digir);

				header("Content-type: text/plain",1);
				print "Darwin:\n". $this->emuResponseToDarwin($_REQUEST['emuResults']) ."\n";
				print "Errors:\n". implode("\n\t",$this->_errors) ."\n";
			}
			else	
			{
				header("Content-type: text/html",1);
				print $this->makeTestPage();
			}
		}
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "EMuToDarwinConverter.php")
	{
		$converter = new EMuToDarwinConverter();
		$converter->test(true);
	}
}


?>
