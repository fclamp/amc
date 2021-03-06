<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


 
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/WebServiceObject.php');

/**
 *
 * Class Translator
 *
 * the Translator class provides mechanisms for translating and extracting a
 * subset of important information from record data from some data provider
 * (eg DiGIR).
 * typically wanted fields are latitude, longitude, description etc 
 *
 * The Class provides methods for selecting a record and getting field values
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class Translator extends BaseWebServiceObject
{
	var $serviceName = "Translator";
	var $parser;
	var $elementStack = array();
	var $data = array();
	var $records = array();
	var $recordPointer = -1;

	var $_foundRecords = false;


	/*
	 * below are defaults to indicate 'typical' settings, and may not be
	 * appropriate for some services - change (if necessary) in specific
	 * service translators 
	 */

	// main elements
	var $recordElement = 'record';
	var $latitudeElement = 'latitude';
	var $longitudeElement = 'longitude';

	/* potentialGroups = categories records can be grouped by.
	  NB the value defines the sort order
	   eg 
			'ScientificName' => '0',
			'Family' => '1', 
			'Genus' => '2', 
			'CollectionCode' => '3',  */
	var $potentialGroups = array ();


	/* direct translations (from => to)
	 * used for mapping of XML to specified fields
	 *
	 * eg 
	 *
	 * if StateProvince is the wanted value and it comes from
	 * <StateTerritory> element
         *	"StateTerritory" => "StateProvince"
	 * or if ScientificName comes from <atom name='SciName'>
	 *	'atom[name=IdeQualifiedName]' => 'ScientificName',
	 */ 
	var $translations = array ();


	function Translator($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		// php doesn't auto call parent constructors - do it manually
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		asort($this->potentialGroups);
	}

	function addPotentialGroups($groups,$reset=false)
	{
		if ($reset)
			$this->potentialGroups = array();
		$ordinal = 0;	
		foreach ($groups as $group)
			$this->potentialGroups[$group] = $ordinal++;
		asort($this->potentialGroups);
	}

	function describe()
	{
		return	
			"A Translator is a generic Object that can read\n".
			"records from various Data Sources (typically\n".
			"non EMu) and translate components of those\n".
			"records into a common structure.  The translated data\n".
			"can be accessed by using the Translator Object's\n".
			"methods.  It is designed to assist various KE EMu\n".
			"web service  components in using data from\n".
			"as wide a potential field as possible\n\n".
			Parent::describe(); }


	function startElement($p, $element, $attrib)
	{
		$this->_foundRecords = ($this->_foundRecords || $element == $this->recordElement);
		if ($this->_foundRecords)
		{
			$element = preg_replace('/^.+?:/','',$element);
		
			$this->elementStack[] = $element;
			$this->attributeStack[] = $attrib;
		}
	}

	function endElement($p,$element)
	{
		if ($this->_foundRecords)
		{
			$element = preg_replace('/^.+?:/','',$element);


			// if we have completed a record there should only be
			// the record start element on stack
			if (count($this->elementStack) == 1)
			{
				$this->records[] = $this->data;
				$this->data = array();
			}
			array_pop($this->elementStack);
			array_pop($this->attributeStack);
		}
	}

	function characterData($p,$data)
	{
		if ($this->_foundRecords)
		{
			//$this->data[$field] = preg_replace('/^\s+/','',$data);
			$topOfElementStack = count($this->elementStack) - 1;
			$field = $this->elementStack[$topOfElementStack];

			if (count($this->attributeStack))
			{
				$topOfAttributeStack = count($this->attributeStack) - 1;
				$attrib = $this->attributeStack[$topOfAttributeStack];
				$params = Array();
				foreach ($attrib as $param => $value)
				{
					$params[] = "$param=$value";
				}
				if (count($params))
					$field .= "[". implode(",",$params) ."]";
			}

			if (isset($this->translations[$field]))
			{
				$field = $this->translations[$field];
			}

			$this->data[$field] = preg_replace('/^\s+/','',$data);
		}
	}

	function translate($data)
	{
		if (get_magic_quotes_gpc())
			$data = stripslashes($data);
		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->parser,$this);
		xml_set_element_handler($this->parser,'startElement','endElement');
		xml_set_character_data_handler($this->parser,'characterData');
		xml_parse($this->parser,$data);
		xml_parser_free($this->parser);
	}

	function getGroups()
	{
		return array_keys($this->potentialGroups);
	}

	function nextRecord()
	{
		$this->recordPointer++;
		return ($this->recordPointer < count($this->records));
	}

	function getElement($element)
	{
		if ($this->recordPointer >= 0 && $this->recordPointer < count($this->records))
		{
			$record = $this->records[$this->recordPointer];
			if (isset($record[$element]))
				return $record[$element];
			else
				return '';
		}
		return '';
	}


	function getLatitude()
	{
		return $this->getElement($this->latitudeElement);
	}

	function getLongitude()
	{
		return $this->getElement($this->longitudeElement);
	}

	function getDescription()
	{
		$this->_makeThisAbstractMethod('getDescription');
	}

	function getGroup($group)
	{
		return $this->getElement($group);
	}

	function saveState($index,$cacher)
	{
		if ($cacher)
			$cacher->save($index,serialize($this));
	}

	function retrieveState($index,$cacher)
	{
		if ($cacher)
			if ($cacher->exists($index))
			{
				$obj = unserialize($cacher->retrieve($index));
				$this->records = $obj->records;
				$this->potentialGroups = $obj->potentialGroups;
				$this->recordPointer = -1;
				return true;
			}	
		return false;
	}




	function translateGroupAndReturn($xml)
	{
		$translated[] = "<TestRecordsTranslated>";
		$translated[] = "<!-- This data assembled from calls to translator methods -->";
		$translated[] = "<!-- translator->translate -->";
		$this->translate($xml);
		$translated[] = "<!-- translator->getGroups -->";
		$groups = $this->getGroups();
		while ($this->nextRecord())
		{
			$translated[] = "\t<!-- translator->nextRecord -->";
			$translated[] = "\t<record>";
			$translated[] = "\t\t<!-- translator->getLatitude -->";
			$translated[] = "\t\t<latitude>". $this->getLatitude() ."</latitude>";
			$translated[] = "\t\t<!-- translator->getLongitude -->";
			$translated[] = "\t\t<longitude>". $this->getLongitude()  ."</longitude>";
			$translated[] = "\t\t<!-- translator->getDescription -->";
			$translated[] = "\t\t<description>".  $this->getDescription() ."</description>";
			foreach ($groups as $group)
			{
				$translated[] = "\t\t<!-- translator->getGroup($group) -->";
				$translated[] = "\t\t<group name='$group'>".  $this->getGroup($group) ."</group>";
			}
			$translated[] = "\t</record>";
		}
		$translated[] = "</TestRecordsTranslated>";
		return implode("\n",$translated);
	}

	function makeTestPage()
	{
		$this->_makeThisAbstractMethod('getDescription');
	}


	function test($clientSpecific=false)
	{
		if (! $clientSpecific)
			parent::test();
		else	
		{
			if (isset($_REQUEST['testCall']))
			{
				header("Content-type: text/xml",1);
				print $this->translateGroupAndReturn($_REQUEST['data']);
			}
			else	
			{
				header("Content-type: text/html",1);
				print $this->makeTestPage();
			}
		}
	}


}

class genericTranslator extends Translator
{
	/* a really simple xml structure translator
	 * xml same as used in portal
	 * <records>
	 *	<record index='n' marked='[true|false]'>
	 *		<description>YYYYY</description>
	 *		<latitude>nn.nnn</latitude>
	 *		<longitude>nn.nnn</longitude>
	 *
	 *		<!-- can be followed by other elements with no
	 *		predefined meaning to translator ->
	 *		<recordSource>XXXX</recordSource>
	 *		<otherStuff>ZZZZ</otherStuff>
	 *		<etc>AAA</etc>
	 *		<etc>BBB</etc>
	 *		...
	 *		</record>
	 *	<record index='n' ...
	 * </records>
	*/

	var $serviceName = "Generic Translator";

	// main elements
	var $recordElement = 'record';
	var $latitudeElement = 'latitude';
	var $longitudeElement = 'longitude';

	function getDescription()
	{
		return $this->getElement('description');
	}

	function makeTestPage()
	{
		$args = array();
		$args['Generic XML Record (enter 1 or more XML records)'] = "<textarea cols='120' rows='15' name='data'>".
			"<records>\n".
			"<record index='6' marked='false'>\n".
			"	<recordSource>NMNH Mosquito (EMu-DiGIR.02)</recordSource>\n".
			"	<description>Aedes </description>\n".
			"	<latitude>10.35528</latitude>\n".
			"	<longitude>67.72139</longitude>\n".
			"	<group name='CatalogNumber'>34474622 : 34474412 : 050</group>\n".
			"	<group name='ScientificName'>Aedes </group>	\n".
			"	<group name='CollectionCode'>Invertebrate Zoology : Mosquito</group>	\n".
			"	<group name='Order'>Diptera</group>	\n".
			"	<group name='Family'>Culicidae</group>	\n".
			"	<group name='Genus'>Aedes</group>	\n".
			"	<group name='Longitude'>67.72139</group>	\n".
			"	<group name='Latitude'>10.35528</group>	\n".
			"	<group name='ContinentOcean'>:</group>	\n".
			"	<group name='Country'>Venezuela</group>	\n".
			"	<group name='StateProvince'>Aragua</group>\n".
			"	<group name='Locality'>Ocumare De La Costa:10 Km Nw Of Rancho Grande On Natl Rt 3</group>\n".
			"	<group name='Collector'>Valencia, Jose</group>\n".
			"	<group name='YearCollected'>1969</group>\n".
			"	<group name='DateLastModified'>2005-05-06 17:23:00.00Z</group>\n".
			"</record>\n".
			"<record index='7' marked='false'>\n".
			"	<recordSource>NMNH Mosquito (EMu-DiGIR.02)</recordSource>\n".
			"	<description>Aedes </description>\n".
			"	<latitude>18.86667</latitude>\n".
			"	<longitude>-98.43333</longitude>\n".
			"	<group name='CatalogNumber'>20975140 : 3</group>\n".
			"	<group name='ScientificName'>Aedes </group>\n".
			"	<group name='CollectionCode'>Invertebrate Zoology : Mosquito</group>\n".
			"	<group name='Order'>Diptera</group>\n".
			"	<group name='Family'>Culicidae</group>\n".
			"	<group name='Genus'>Aedes</group>\n".
			"	<group name='Longitude'>-98.43333</group>\n".
			"	<group name='Latitude'>18.86667</group>\n".
			"	<group name='ContinentOcean'>:</group>\n".
			"	<group name='Country'>Mexico</group>\n".
			"	<group name='StateProvince'>Guerrero</group>\n".
			"	<group name='Locality'>Acapulco:About 1.5 Km S Of Puerto Marquez (el Marques)</group>\n".
			"	<group name='Collector'>Fisher, Eric</group>\n".
			"	<group name='YearCollected'>1964</group>\n".
			"	<group name='DateLastModified'>2005-05-06 17:27:00.00Z</group>\n".
			"</record>\n".
			"</records>\n".
			"</textarea>";
		$vars = array();
		$vars['class'] = 'GenericTranslator';
		$submission = "<input type='submit' name='action' value='translate' />";

		return $this->makeDiagnosticPage(
					'Test Emu Translator',
					'simple test',
					'',
					'./Translator.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}
}	

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'Translator.php')
	{
		if ($_REQUEST['class'] == 'GenericTranslator')
		{
			$webObject = new GenericTranslator();
			$webObject->test(true);
		}
		else	
		{
			$webObject = new Translator();
			$webObject->test();
		}
	}
}


?>
