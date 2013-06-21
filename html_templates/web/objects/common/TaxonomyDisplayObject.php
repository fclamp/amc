<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
TaxonomyStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	TaxonomyStandardDisplay()
	{

		$this->Database = 'etaxonomy';
		//$this->SuppressEmptyFields = 0;
		
		$ClaScientificName = new Field;
		$ClaScientificName->ColName = 'ClaScientificName->etaxonomy->SummaryData';
		$ClaScientificName->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];

		$IntIntervieweeRef = new Field;
		$IntIntervieweeRef->ColName = 'IntIntervieweeRef_tab->eparties->SummaryData';
		$IntIntervieweeRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];	

		$IntInterviewerRef = new Field;
		$IntInterviewerRef->ColName = 'IntInterviewerRef_tab->eparties->SummaryData';
		$IntInterviewerRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];

		$ParPartiesRef = new Field;
		$ParPartiesRef->ColName = 'ParPartiesRef_tab->eparties->SummaryData';
		$ParPartiesRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];

		$ObjObjectsRef = new Field;
		$ObjObjectsRef->ColName = 'ObjObjectsRef_tab->ecatalogue->SummaryData';
		$ObjObjectsRef->LinksTo = $GLOBALS['DEFAULT_DISPLAY_PAGE'];	

		$NarNarrative = new Field;
		$NarNarrative->ColName = 'NarNarrative';
		$NarNarrative->MarkupKeywords = 1;
			
	
		$this->Fields = array(
				//'NarTitle',
				//$NarNarrative,
				//$NarAuthorsRef,
				//'DesHistoricalSignificance',
				//'DesGeographicLocation_tab',
				//'DesType_tab',
				//'DesIntendedAudience_tab',
				//$IntIntervieweeRef,
				//$IntInterviewerRef,
				//'IntInterviewDate0',
				//$ObjObjectsRef,
				//$ParPartiesRef,
				//'NotNotes',
				'SummaryData',
				'ClaClass',
				'ClaGenus',
				'ClaFamily',
				'ClaSpecies',
				);
		
		$this->BaseStandardDisplay();
	}
}

?>
