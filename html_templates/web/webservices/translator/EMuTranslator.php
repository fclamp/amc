<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/webservices/translator/Translator.php');

/**
 *
 * EMuTranslator is Class for translating EMu XML
 *
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class EMuTranslator extends Translator 
{
	var $serviceName = "EMuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Family' => '1', 
			'Genus' => '2', 
			'Species' => '3', 
		);	

	var $translations = array (
		'ecatalogue.atom[name=IdeQualifiedName]' => 'ScientificName',
		'ecatalogue.atom[name=LatCentroidLatitude]' => 'Latitude',
		'ecatalogue.atom[name=LatCentroidLongitude]' => 'Longitude',
	);

	var $discard = Array( 'tuple' => 1 );

	var $_tupleSelect = Array();

	var $_table = 'ecatalogue';
	var $_mangles = array(); // regexp replacements

	function EMuTranslator($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		// php doesn't auto call parent constructors - do it manually
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->preMangle();
	}

	function describe()
	{
		return	
			"An EMuTranslator is a Translator that can read\n".
			"EMU XML Records (typically generated from the EMu\n".
			"client as part of a report) into a generic\n".
			"structure\n\n".  parent::describe();
	}

	function preMangle()
	{
		/* premangle XML to allow same3d named atoms to be extracted as
		 *  separate fields eg in XML like:
		 *
		 * <atom name='SummaryData'>Main Summary</atom>
		 * <tuple name='T'>
		 * 	<atom name='SummaryData'>Tuple Summary</atom>
		 * </tuple>
		 *
		 * we can use setTranslation calls:
		 *
		 * $this->setTranslation('atom[name=SummaryData]','Field1','string');
		 * $this->setTranslation('tuple[name=T]/atom[name=SummaryData]','Field2','string');
		 *
		 * to have:
		 *   field1 = Main Summary
		 *   field2 = Tuple Summary
		 * 
		 * because this behaviour is an add on, rather than rewrite XML
		 * parsing, instead do a quick and dirty hack... 'mangle' the
		 * EMuXML to drop the inner element tags and translate using
		 * outer tuple tags
		 */
		 $dropTranslations = array();
		 $newTranslations = array();
		 foreach ($this->translations as $emuField => $newField)
		 {
		 	if (preg_match("/\//", $emuField))
			{
				$dropTranslations[$emuField] = $newField;
				list($outer, $inner) = preg_split("/\//", $emuField, 2);
				$newTranslations[$outer] = $newField;
				if (preg_match("/(\w+)\[name=(\w+)\]\/(\w+)\[name=(\w+)\]/", $emuField, $matches))
				{
					$outerTag = $matches[1];
					$outerName = $matches[2];
					$innerTag = $matches[3];
					$innerName = $matches[4];
		 			$this->_mangles[
						"<$outerTag\s+name=.$outerName.>\s+<$innerTag\s+name=.$innerName.>\s*(.*?)\s*<.$innerTag>\s*<.$outerTag>"
						] = "<$outerTag name=\"$outerName\">\$1</$outerTag>";
				}
			}
		 }
		 foreach ($dropTranslations as $emuField => $newField)
		 {
		 	unset($this->translations[$emuField]);
		 }
		 foreach ($newTranslations as $emuField => $newField)
		 {
		 	$this->translations[$emuField] = $newField;
		 }
	}


	function hasRecord()
	{
		return false;
	}


	function getGroup($group)
	{
		return $this->getElement($group);
	}

	function getDescription()
	{
		if ($this->recordPointer >= 0 && $this->recordPointer < count($this->records))
		{
			$record = $this->records[$this->recordPointer];
			if (isset($record['description']))
				return $record['description'];
			else	
				return $record['atom[name=SummaryData]'];
		}
		return '';
	}

	function setTupleNumber($fieldTo,$tupleNumber=0)
	{
		// tupleNumber used if translation is of a field that is a
		// tuple in Texpress.  If set will take the tupleNumbered field
		// as the value.  If not will do standard behaviour
		// (ie just concatenate all values)
		// NB 1 indexed so == 0 means concatonate all values

		if ($tupleNumber > 0)
		{
			$this->_tupleSelect[$fieldTo] = $tupleNumber;
			$this->concatenateField($fieldTo,false,"~");
		}	
	}

	function getElement($element)
	{
		// handle situation of wanting specific row of a tuple

		$value = parent::getElement($element);

		if (isset($this->_tupleSelect[$element]))
		{
			// if tuple then value is an
			// "array" represented by a
			// 0x01 delimited string
			$valueArray = preg_split("/\x01/",$value);
			$value = $valueArray[$this->_tupleSelect[$element]-1];
		}
		return $value;
	}

	function translate($data)
	{
		$this->_table = $this->getTable($data);
		$this->filterTranslationsBasedOnTable($this->_table);
		foreach ($this->_mangles as $pattern => $replacement)
		{
			if (get_magic_quotes_gpc())
				$data = stripslashes($data);
			$data = preg_replace("/$pattern/", $replacement, $data);
		}
		parent::translate($data);
	}

	function getTable($data)
	{
		if (get_magic_quotes_gpc())
			$data = stripslashes($data);

		if (preg_match('/<table name=.(e[a-z]*).>/', $data, $match))
		{
			return $match[1];
		}
		else
		{
			return 'ecatalogue';
		}
	}

	function filterTranslationsBasedOnTable($table)
	{
		// remove translations that don't apply to the 'table' that the
		// XML represents - this allows fields with the same name to be
		// mapped to different spots depending on what database table
		// they appear in
		foreach ($this->translations as $fieldFrom => $fieldTo)
		{
			if (preg_match("/^e\w+\./", $fieldFrom))
			{
				if (! preg_match("/^$table\./", $fieldFrom))
				{
					unset($this->translations[$fieldFrom]);
					unset($this->fieldTypes[$fieldFrom]);
				}
			}
		}

		$groupAble = array();
		foreach (array_values($this->translations) as $toField)
		{
			$groupAble[$toField]++;
		}
		foreach ($this->potentialGroups as $group => $groupLevel)
		{
			if (! key_exists($group, $groupAble))
			{
				unset($this->potentialGroups[$group]);
			}
		}
	}

}

if (isset($_REQUEST['test']) && ($_REQUEST['class'] == 'EMuTranslator'))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == 'EMuTranslator.php')
	{
		$webObject = new EMuTranslator();
		$webObject->test();
	}
}


?>
