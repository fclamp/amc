<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */

 
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/lib/WebServiceObject.php');

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
	var $elementStack = Array();
	var $data = Array();
	var $records = Array();
	var $recordPointer = -1;
	var $_foundRecords = false;
	var $attributeStack = false;
	var $recordCount = 0;

	// SAX parsers can call the registered cdata handler
	// multiple times even within one cdata string - arbitrarily breaking
	// the string up.  We need to detect if handler is being passed a cdata
	// string that is a continuation of a unfinished string or is start of
	// a new string, so we can concatenate data appropriately
	var $_continuingCData = false;  


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
	var $potentialGroups = Array ();

	var $truncate = Array();


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
	var $translations = Array ();

	/* can be used to record field types:
	 * (fromField => type)
	 *
	 * eg
	 * "ecatalogue.DarLatitude" => "float"
	 */
	var $fieldTypes = Array();

	// hash of elements to ignore when translating
	var $discard = Array();

	// if encounter <element/> do we record it a element = NULL or drop it
	// altogether (dropping may cause issues with nested tables) but
	// normally safer to not translate
	var $_dropNullValues = true;


	// Specify how multiple values for a field are stored.  Default is to
	// concatenate.  Alternatively if the _concatField array for a
	// field is set you can concatenate with a concatenate string or can
	// ask that values be stored as array rather than be concatenated.
	// eg 
	//	<a>value1</a>
	//	<a>value2</a>
	//
	// if ! isset _concatField[a]
	//    create record[a] = value1value2
	//
	// else if _concatField[a] = Array(true,'~') then
	//    create record[a] = value1~value2
	//
	// else if _concatField[a] = Array(false) then
	//    create record[a] = Array(value1,value2)
	//
	// Always set this using method concatenateField
	var $_concatField = Array();

	// holds elements that will be passed through and returned 'untouched' by
	// translator.  Set using passThrough method
	var $_passThrough = Array();

	// internal parser
	var $_passThroughStack = Array();

	function Translator($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		// php doesn't auto call parent constructors - do it manually
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->configure();
		asort($this->potentialGroups);
	}

	function configure()
	{
	}

	function addPotentialGroups($groups,$reset=false)
	{
		if ($reset)
			$this->potentialGroups = array();
		$ordinal = 0;	
		foreach ($groups as $group)
		{
			$group = preg_replace("/^\s+|\s+$/","",$group);
			if ($group and $group != 'keVerbatim')
				$this->potentialGroups[$group] = $ordinal++;
		}
		asort($this->potentialGroups);
	}

	function recordNullValues($bool)
	{
		$this->_dropNullValues = $bool;
	}	


	function reset()
	{
		$this->recordPointer = -1;
	}

	function forgetAll()
	{
		$this->recordPointer = -1;
		$this->records = Array();
		$this->elementStack = Array();
		$this->attributeStack = Array();
		$this->recordCount = 0;
		$this->data = Array();
		$this->_foundRecords = false;
	}

	function repeatFields($field)
	{
		$this->_repeatField[$field] = true;
	}
	function concatenateField($field,$concatenate=true,$concatenator="")
	{
		$this->_concatField[$field] = Array($concatenate,$concatenator);
	}

	function passThrough($element)
	{
		$this->_passThrough[$element]++;
	}

	function tagAllRecords($field,$value)
	{
		// adds a field with passed value to all records
		// can be used to tag records from a translator or at a point
		// in time when the records may pass to other systems
		for ($i=0; $i < $this->recordCount; $i++)
		{
			$this->records[$i][$field] = $value;
		}
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
			parent::describe(); }

	function setTranslation($fieldFrom,$fieldTo,$fromFieldType="")
	{
		$this->fieldTypes[$fieldFrom] = $fromFieldType;
		$this->translations[$fieldFrom] = $fieldTo;
	}

	function getFieldType($field)
	{
		return $this->fieldTypes[$field];
	}

	function startElement($p, $element, $attrib)
	{
		$this->_continuingCData = false;
		$this->_foundRecords = ($this->_foundRecords || $element == $this->recordElement);
		if ($this->_foundRecords)
		{
			$element = preg_replace('/^.+?:/','',$element);
			$element = preg_replace('/^\s*|\s*$/','',$element);
			if ($element)
			{
				$this->elementStack[] = $element;
				$this->attributeStack[] = $attrib;

				if ($attrib)
					$element .= "[". implode(" ",$attrib) ."]";
				if ((count($this->_passThroughStack) > 0) or (isset($this->_passThrough[$element])))
					$this->_passThroughStack[] = $element;
			}
		}
	}

	function endElement($p,$element)
	{
		if ($this->_foundRecords)
		{
			$element = preg_replace('/^.+?:/','',$element);
			if ((count($this->_passThroughStack) > 0) or (isset($this->_passThrough[$element])))
				array_pop($this->_passThroughStack);


			// if we have completed a record there should only be
			// the record start element on stack
			if (count($this->elementStack) == 1)
			{
				$this->data = preg_replace("/&/","&amp;",$this->data);
				$this->records[] = $this->data;
				$this->data = array();
			}
			array_pop($this->elementStack);
			array_pop($this->attributeStack);
		}
		$this->_continuingCData = false;

		if (($this->_dropNullValues) && (! isset($this->data[$element])))
		{
				$this->data[$element] = "";
		}
	}

	function characterData($p,$data)
	{
		$translations = Array();
		foreach ($this->translations as $field => $new)
		{
			$field = preg_replace("/^[a-z]+\./","",$field);
			$translations[$field] = $new;
		}
		if ($this->_foundRecords && count($this->elementStack) > 0)
		{
			$topOfElementStack = count($this->elementStack) - 1;
			$field = $this->elementStack[$topOfElementStack];


			if (isset($this->discard[$field]))
				return ;

			if (count($this->_passThroughStack))
			{
				// untranslated (verbatim) data
				// create a array structure to store xml for
				// later retrieval in similar format to source

				$data = preg_replace("/\s+/"," ",$data);
				$data = preg_replace("/^\s+|\s+$/","",$data);
				$tail = $data;
				foreach (array_reverse($this->_passThroughStack) as $fieldN)
				{
					$head = Array($fieldN => $tail);
					$tail = $head;
				}


				if (! isset($this->data[keVerbatim]))
					$this->data[keVerbatim] = $tail;

				$recdata = &$this->data[keVerbatim];

				while (is_array($tail) && $tail)
				{
					$fields = array_keys($tail);
					$fieldN = $fields[0];
					$next = $tail[$fieldN];

					if (! isset($recdata[$fieldN]))
						$recdata[$field] = $next;
					$recdata = &$recdata[$fieldN];	

					$tail = $next;	
				}
				//return;
			}

			// determine what field the data will go into
			if (count($this->attributeStack))
			{
				$topOfAttributeStack = count($this->attributeStack) - 1;
				$attrib = $this->attributeStack[$topOfAttributeStack];
				$params = Array();
				
				if (($field == 'group') && isset($attrib['name']) &&  (count($attrib) == 1))
				{
					// special case is internally
					// translated xml... which means this
					// isn't really just a generic
					// translator but is a internal and
					// generic translator - perhaps need
					// new internal translator class...
					$field = $attrib['name'];
					if ($field == 'latitude' || $field == 'longitude')
						return;
				}
				else if ($field == 'record')
				{
					return;
				}
				else
				{
					// unknown xml format - join tag and attributes
					foreach ($attrib as $param => $value)
					{
						$params[] = "$param=$value";
					}
					if (count($params))
						$field .= "[". implode(",",$params) ."]";
				}	
			}


			// use any set field name translations
			if (isset($translations[$field]) && $translations[$field])
			{
				$field = $translations[$field];
			}

			// assign data to field
			$data = preg_replace('/</','&lt;',$data);
			$data = preg_replace('/>/','&gt;',$data);
			if (isset($this->data[$field]))
			{
				// we already have entry for this field, either
				// concatenate it or make an array of values
				if (! isset($this->_concatField[$field]))
				{
					$data = preg_replace('/\s+$/','',$data);
					$this->data[$field] .= preg_replace('/^\s+/',' ',$data);
				}
				else if ($this->_concatField[$field][0])
				{
					$concat = $this->_concatField[$field][1];

					if (! $this->_continuingCData)
					{
						$this->data[$field] .= $concat . preg_replace('/^\s+/',' ',$data);
					}
					else
					{
						// if merely continuation of an
						// earlier handled cdata string
						// don't join with concat
						// string
						$this->data[$field] .= preg_replace('/^\s+/',' ',$data);
					}
				}
				else
				{
					if (! $this->_continuingCData)
					{
						// don't seem to be able to dynamically
						// change data type to array (unlike
						// perl) instead encode the array as
						// 0x01 delimited string - hack...
						$this->data[$field] .= "\x01" .
						preg_replace('/^\s+/',' ',$data);
					}
					else
					{
						// if merely continuation of an
						// earlier handled cdata string
						// don't treat as new array
						// item, add to top item
						$this->data[$field] .= preg_replace('/^\s+/',' ',$data);
					}
				}

			}
			else
			{
				$this->data[$field] = preg_replace('/^\s+/','',$data);
			}

		}
		$this->_continuingCData = true;
	}

	function decodeUtf8()
	{
		$cleanRecs = array();
		foreach ($this->records as $r)
		{
			foreach ($r as $field => $value)
			{
				$r[$field] = utf8_decode($value);
			}
			$cleanRecs[] = $r;
		}
		$this->records = $cleanRecs;
	}

	function translate($data)
	{
		$this->forgetAll();

		$data = preg_replace("/^\s*HTTP.*?</s","<",$data);

		// encode naked ampersands ie any "&" not followed by "[a-z]+;"
		$data = preg_replace('/&(?![a-z]+;)/','&amp;',$data);

		# preg_replace memory hungry - only do if necessary or may
		# run out of memory
		if (preg_match("/<\?/",$data))
                	$data = preg_replace("/^.*?\?>\s*/s","",$data);

		if (get_magic_quotes_gpc())
			$data = stripslashes($data);
		$data = utf8_encode($data);

		$this->parser = xml_parser_create();
		xml_parser_set_option($this->parser,XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->parser,$this);
		xml_set_element_handler($this->parser,'startElement','endElement');
		xml_set_character_data_handler($this->parser,'characterData');
		xml_parse($this->parser,$data);
		xml_parser_free($this->parser);
		$this->recordCount = count($this->records);
	}

	function getGroups()
	{
		return array_keys($this->potentialGroups);
	}

	function nextRecord()
	{
		$this->recordPointer++;
		return ($this->recordPointer < $this->recordCount);
	}

	function getCurrentRecord()
	{
		if ($this->recordPointer >= 0 && $this->recordPointer < $this->recordCount)
		{
			return $this->records[$this->recordPointer];
		}
		return NULL;
	}

	function showVerbatim($indent=0)
	{
		$record = $this->getCurrentRecord();
		if (isset($record[keVerbatim]))
		{
			$data = $record[keVerbatim];
			return $this->_expandArray($data,$indent);
		}
		else
			return "";
	}	

	function _expandArray($data,$depth)
	{
		if (! is_array($data))
			return $data;

		$xml = "\n";
		for ($i=0; $i<$depth; $i++)
			$xml .= "\t";

		foreach ($data as $element => $values)
		{
			$head = preg_replace("/\[(.+)\]/"," name='$1'",$element);
			$tail = preg_replace("/\[.+\]/","",$element);


			$xml .= "<$head>". $this->_expandArray($values,$depth+1) ."</$tail>\n";
			for ($i=0; $i<$depth; $i++)
				$xml .= "\t";
		}
		return $xml;
	}

	function getElement($element)
	{
		if ($this->recordPointer >= 0 && $this->recordPointer < $this->recordCount)
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
		// special case are groups assuming internally
		// translated xml such as group = "group=catalognumber"
		// to match internally translated xml like:
		// <group name='catalognumber'>1234</group>
		if (preg_match("/group\s+name=(\S+)/",$group,$match))
		{
			$group = $match[1];
			$group = preg_replace("/\"|'/",'',$group);
		}
		if (isset($this->truncate[$group]))
		{
			 $value = $this->getElement($group);
			 if ($this->truncate[$group] < strlen($value))
			 {
			 	$pos = strpos($value,' ',$this->truncate[$group]-1);
			 	if ($pos)
			 		return substr($value,0,$pos) . "...";
			}
		}
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
				$this->recordCount = count($this->records);
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
		$this->_makeThisAbstractMethod('makeTestPage');
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

/**
 *
 * Class GenericTranslator
 *
 * a really simple xml structure translator
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
 *
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */

class GenericTranslator extends Translator
{

	var $serviceName = "Generic Translator";

	// main elements
	var $recordElement = 'record';
	var $latitudeElement = 'latitude';
	var $longitudeElement = 'longitude';

	function getDescription()
	{
		return $this->getElement('description');
	}

	/**
	* SetGroupsUsingPattern
	*
	* must be called following translation.  Will trawl all
	* records and build up field names in source xml that match
	* supplied pattern and add them as potential groups.
	*/
	function setGroupsUsingPattern($pattern)
	{

		$knownFields = Array();
		foreach ($this->records as $record)
			foreach ($record as $field => $value)
			{
				$knownFields[$field]++;
			}
		$fields = Array();
		foreach ($knownFields as $field => $count)
		{
			if (preg_match($pattern,$field))
			{
				$fields[] = $field;
			}
		}
		$this->addPotentialGroups($fields,true);
	}

	function makeTestPage()
	{
		$args = array();
		#$this->passThrough('keLayers');
		$args['Generic XML Record (enter 1 or more XML records)'] = <<<XML
<textarea cols='120' rows='15' name='data'>
<records><record>
	<recordSource></recordSource>
	<description>P.038418; Chaunax sp.; ethanol 70% &amp; Fred</description>
	<latitude>-41.538</latitude>
	<longitude>170.420</longitude>
	
	<group name='recordSource'>Emu</group>
	<group name='ScientificName'>Chaunax sp.</group>
	<group name='Family'>Chaunacidae</group>
	<group name='Genus'>Chaunax</group>
	<group name='Species'>sp.</group>

	<group name='irn'>608592</group>
	<group name='Collector'>Loveridge; Brunning; observers</group>
		<group name='Marine Eco Regions'>Central New Zealand</group>	<keLayers>
		<keLayer name='Marine Eco Regions'>
			<keDescription>Central New Zealand</keDescription>
			<ECO_CODE>2.51990000000e+004</ECO_CODE>

			<ECOREGION>Central New Zealand</ECOREGION>
			<PROV_CODE>5.40000000000e+001</PROV_CODE>
			<PROVINCE>Southern New Zealand</PROVINCE>
			<RLM_CODE>1.10000000000e+001</RLM_CODE>
			<REALM>Temperate Australasia</REALM>
			<ALT_CODE>2.05000000000e+002</ALT_CODE>

			<ECO_CODE_X>1.99000000000e+002</ECO_CODE_X>
			<Shape_Leng>4.79864102085e+001</Shape_Leng>
			<Shape_Area>9.48526830952e+001</Shape_Area>
			<Lat_Zone>Temperate</Lat_Zone>
		</keLayer>	</keLayers>
</record><record marked='false' index='13'>
	<recordSource></recordSource>

	<description>P.035676; Melanocetus johnsoni Gunther &amp; Fred, 1865; ethanol 70% with some 'quoted' text</description>
	<latitude>-35.632</latitude>
	<longitude>165.578</longitude>
	
	<group name='recordSource'>Emu</group>
	<group name='ScientificName'>Melanocetus johnsoni Gunther, 1865</group>
	<group name='Family'>Melanocetidae</group>
	<group name='Genus'>Melanocetus</group>
	<group name='Species'>johnsoni Gunther, 1865</group>
	<group name='irn'>422456</group>

	<group name='Collector'>Sealy; Lyon; observers</group>
</record></records>
</textarea>
XML;
		$vars = array();
		$vars['class'] = 'GenericTranslator';
		$submission = "<input type='submit' name='action' value='translate' />";

		return $this->makeDiagnosticPage(
					'Test EMu Translator',
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
