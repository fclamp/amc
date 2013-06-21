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
 * TexxmlTranslator is a class for translating OZCAN XML
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 */
class TexxmlTranslator extends Translator 
{
	var $serviceName = "TexxmlTranslator";
	var $recordElement = 'record';
	var $latitudeElement = 'Latitude';
	var $longitudeElement = 'Longitude';
	var $potentialGroups = array (
			'irn_1' => '0',
		);	

	// used to list EMu SELECT fields based on mappings
	var $requiredFields = Array();	

	function TexxmlTranslator($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);

		$descriptionSet = false;
		foreach ($this->translations as $srcField => $translatedField)
		{
			if ($translatedField == 'description')
			{
				$descriptionSet = true;	
			}
		}
		if (! $descriptionSet)
		{
			$this->setTranslation('ecatalogue.SummaryData','description');
		}
	}

	function describe()
	{
		return	
			"An TexxmlTranslator is a Translator that can read\n".
			"TexXML Web Service Records\n\n".
			parent::describe();
	}

	function getDescription()
	{
		if ($this->recordPointer >= 0 && $this->recordPointer < count($this->records))
		{
			$record = $this->records[$this->recordPointer];
			if (isset($record['description']))
				return $record['description'];
			if (isset($record['SummaryData']))
				return $record['SummaryData'];
			else if (isset($record['Summary']))
				return $record['Summary'];
			else
				return "??";
		}
		return '';
	}

	function setTranslation($fieldFrom,$fieldTo,$fromFieldType="")
	{
		$this->fieldTypes[$fieldFrom] = $fromFieldType;
		$this->requiredFields[$fieldFrom] = $fieldTo;

		if (preg_match("/(\w+)\.(\w+)\[(.+)\]/",$fieldFrom,$match))
		{
			$fieldFrom = $match[1] .".". $match[3];
			$this->translations[$fieldFrom] = $fieldTo;
		}
		else
		{
			$this->translations[$fieldFrom] = $fieldTo;
		}
	}

	function getElement($element)
	{
		// may need to add enhancements for texpress nested tables
		return parent::getElement($element);
	}

	function returnAllFields()
	{
		// to translate a SELECT ALL into SELECT fields know by translator
		return implode(",",array_keys($this->requiredFields));
	}

	function hasRecord()
	{
		return false;
	}

	function makeTestPage()
	{
		$args = array();
		$args['TexXMl Records (enter 1 or more TexXML xml records)'] = "<textarea cols='120' rows='15' name='data'>".
			"<results status='success' matches='1'>\n".
			" <record>\n".
			"   <irn>\n".
			"     <irn_1>1</irn_1>\n".
			"   </irn>\n".
			"   <SummaryData>10087 [BRY] Cornucopina antillea Osburn : : : : Bryozoa; Type; North Atlantic Ocean : : : : : : : West Of Puerto Rico : 18 14 20 N : 67 38 25 W : Sta. 36; 10 Feb 1933; ; Johnson - Smithsonian Deep Sea Expedition; 732;</SummaryData>\n".
			"   <BioPreferredCentroidLatitude>18 14 20 N</BioPreferredCentroidLatitude>\n".
			"   <BioPreferredCentroidLongitude>067 38 25 W</BioPreferredCentroidLongitude>\n".
			" </record>\n".
			"</results>".
			"</textarea>";
		$vars = array();
		$submission = "<input type='submit' name='action' value='translate' />";
		return $this->makeDiagnosticPage(
					'Test TexXML Translator',
					'simple test',
					'',
					'./TexxmlTranslator.php',
					$args,
					$submission,
					$vars,
					$this->describe()
				);
	}
}

if (isset($_REQUEST['test']))
{
	if (basename($_SERVER['PHP_SELF']) == 'TexxmlTranslator.php')
	{
		$translator = new TexxmlTranslator();
		print $translator->test(true);
	}
}


?>
