<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
MmStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	MmStandardDisplay()
	{

		$colProvenaceAssoc = new Field;
		$colProvenaceAssoc->ColName = 'ColProvenanceAssociation_tab';

		$colProvenace = new Field;
		$colProvenace->ColName = 'ColProvenanceRef_tab->eparties->SummaryData';
		
		$provTable = new Table;
		$provTable->Name = 'Provenance';
		$provTable->Columns = array($colProvenace, $colProvenaceAssoc);

		$ideHistTaxonomy = new Field;
		$ideHistTaxonomy->ColName = 'TaxTaxonomyRef_tab->etaxonomy->SummaryData';

		$ideHistTable = new Table;
		$ideHistTable->Name = 'Identification History';
		$ideHistTable->Columns = array($ideHistTaxonomy); 

		$ideHistDate = new Field;
		$ideHistDate->ColName = 'IdeDateIdentified0';

		$ideHistWho = new Field;
		$ideHistWho->ColName = 'IdeIdentifiedByRef_tab->eparties->SummaryData';

		$ideIdentTable = new Table;
		$ideIdentTable->Columns = array($ideHistWho, $ideHistDate);

      		$notCatNotes = new Field;
		$notCatNotes->ColName = 'notNotes';

		$notTaxNotes = new Field;
		$notTaxNotes->ColName = 'TaxTaxonomyRef_tab->etaxonomy->NotNotes';

		$notTable = new Table;
		$notTable->Name = 'Notes';
		$notTable->Columns = array($notCataxNot, $notTaxNotes);

		$this->Fields = array(	
			'ColCollectionName_tab',
			'TaxTaxonomyRef_tab->etaxonomy->ClaFamily',
			'TaxTaxonomyRef_tab->etaxonomy->ClaGenus',
			'TaxTaxonomyRef_tab->etaxonomy->ClaSpecies',
			'TaxTaxonomyRef_tab->etaxonomy->ClaSubspecies',
			'TaxTaxonomyRef_tab->etaxonomy->ClaOtherRank_tab',
			'TaxTaxonomyRef_tab->etaxonomy->ClaOtherValue_tab',
			'TaxTaxonomyRef_tab->etaxonomy->AutCombAuthorsLocal_tab',
			'TaxTaxonomyRef_tab->etaxonomy->AutBasionymAuthorsLocal_tab',
			$ideHistTable,
			$ideIdentTable,
			'SpeAttributes_tab',
			'IdeTypeStatus_tab',
			'SitSiteRef_tab->esites->SummaryData',
			'LocCollectorsRef_tab->eparties->SummaryData',
			'LocDateCollectedFrom',
			'AccAccessionLotLocal',
			$provTable,
			'SpeConditionComments',
			'TaxTaxonomyRef_tab->etaxonomy->ComName_tab',
			$notTable,
			);
		
		$this->BaseStandardDisplay();
	}
}

class
MmPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	MmPartyDisplay()
	{
		$this->Database = 'eparties';

		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				);

		$this->BaseStandardDisplay();
	}
}
?>
