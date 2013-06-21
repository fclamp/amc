<?php

/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once($COMMON_DIR . 'RecordExtractor.php');

class NarrativeLearningJourney extends BaseWebObject
{
	var $Title;
	var $Step = 1;

	var $EntryToJourney = "DesType contains 'Learning Journey Entry";
	var $AdditionalFields = array();

	var $standardFields = array("NarTitle", "NarNarrative");

	var $_entryRecordRE;
	var $_stepRecordRE;
	var $_stepIRN;

	function
	NarrativeLearningJourney()
	{
		$this->BaseWebObject();
		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['step']) 
				&& is_numeric($ALL_REQUEST['step']))
		{
			$this->Step = $ALL_REQUEST['step'];
		}
		if (isset($ALL_REQUEST['title']))
		{
			$this->Title = $ALL_REQUEST['title'];
		}
	}
			

	function
	ExtractJourney()
	{
		// extract the entry record (narrative record that hosts the
		// Journey discription and references to "step" records)
		// Uses the RecordExtractor object 
		$title = $this->Title;
		$this->_entryRecordRE = new RecordExtractor;
		$this->_entryRecordRE->Database = "enarratives";
		$this->_entryRecordRE->Where = "NarTitle = '$title'";
		$this->_entryRecordRE->ExtractFields(array(
							"NarTitle", 
							"NarNarrative",
							"AssAssociatedWithRef_tab",
							));

		// extract the current step record
		$invalidstep = 0;
		$step = $this->Step;
		$irn = $this->_entryRecordRE->FieldAsValue("AssAssociatedWithRef:$step");
		if (! is_numeric($irn))
		{
			// invalid step
			WebDie("The step you have selected is invalid");
		}
		$this->_stepRecordRE = new RecordExtractor;
		$this->_stepRecordRE->Database = "enarratives";
		$this->_stepRecordRE->Where = "irn = $irn";
		$fields = array_merge($this->standardFields, $this->AdditionalFields);
		$this->_stepRecordRE->ExtractFields($fields);
	}

	function
	PrintJourneyTitle()
	{
		// 
		$this->_entryRecordRE->PrintField("NarTitle");
	}

	function
	PrintJourneyOverview()
	{
		$this->_entryRecordRE->PrintField("NarNarrative");
	}

	function
	NumberOfSteps()
	{
		$i = count($this->_entryRecordRE->MultivalueFieldAsArray("AssAssociatedWithRef_tab"));
		if ($i < 1)
			WebDie("Invalid number of steps");
		return $i;
	}

	function
	CurrentStep()
	{
		return $this->Step;
	}
	
	function
	PrintPathToNextStep()
	{
		$this->PrintPathToStep($this->Step + 1);
	}

	function
	PrintPathToStep($number)
	{
		$self = isset($GLOBALS['PHP_SELF']) ?
				$GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$title = urlencode($this->Title);
		print "$self?Title=$title&amp;step=$number";
	}

	function
	ReturnNarrativeRecordExtrator()
	{
		return ($this->_stepRecordRE);
	}

}

/*
// Test Code
$o = new NarrativeLearningJourney;
//$o->Title = "Test Learning Journey";
$o->ExtractJourney();
print "<a href=\"";
$o->PrintPathToNextStep();
print "\">fda</a>";
*/


?>
