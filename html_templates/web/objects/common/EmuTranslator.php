<?php

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/common/Translator.php');

/**
 *
 * EmuTranslator is Class for translating EMu XML
 *
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class EmuTranslator extends Translator 
{
	var $serviceName = "EmuTranslator";
	var $recordElement = 'tuple';
	var $potentialGroups = array (
			'ScientificName' => '0',
			'Family' => '1', 
			'Genus' => '2', 
			'CollectionCode' => '3', 
		);	

	var $translations = array (
		'atom[name=IdeQualifiedName]' => 'ScientificName',
		'atom[name=LatCentroidLatitude]' => 'Latitude',
		'atom[name=LatCentroidLongitude]' => 'Longitude',
	);

	function describe()
	{
		return	
			"A EmuTranslator is a Translator that can read\n".
			"EMU XML Records into a generic structure\n\n".
			Parent::describe();
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
			return $record['atom[name=SummaryData]'];
		}
		return '';
	}

}

if (isset($_REQUEST['test']) && ($_REQUEST['class'] == 'EmuTranslator'))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == 'EmuTranslator.php')
	{
		$webObject = new EmuTranslator();
		$webObject->test();
	}
}


?>
