<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
require_once ('DefaultPaths.php');

class
TePapaStandardDisplay extends BaseStandardDisplay
{
	//var $DisplayAllMedia = 0;
	var $DisplayImage = 1;

	// Set default in the constructor
	function
	TePapaStandardDisplay()
	{
		$this->BaseStandardDisplay();

		$ideIdBy = new Field;
		$ideIdBy->ColName = 'IdeIdentifiedByRef_tab->eparties->SummaryData';
		$ideIdBy->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		/*
		$taxPhy = new Field;
		$taxPhy->ColName = 'TaxTaxonomyRef_tab->etaxonomy->ClaPhylum';

		$taxOrd = new Field;
		$taxOrd->ColName = 'TaxTaxonomyRef_tab->etaxonomy->ClaOrder';

		$TaxTable = new Table;
		$TaxTable->Name = "TAXON";
		$TaxTable->Column = array (	$taxPhy,
						$taxOrd,
						);

		*/

		$this->Fields = array(
				'SummaryData',
				'ColCollectionType',
				'RegRegistrationNumberString',
				/*
				'TaxTaxonomyRef_tab',
				'TaxTaxonomyRef_tab->etaxonomy->ClaOrder',
				'TaxTaxonomyRef_tab->etaxonomy->ClaFamily',
				$TaxTable,
				*/
				'WebClaPhylum',
				'WebClaClass',
				'WebClaOrder',
				'WebClaFamily',
				'IdeScientificNameLocal:1',
				'WebIdeTypeStatus',
				$ideIdBy,
				'IdeDateIdentified0',
				'WebComName_tab',
				'WebLocCountry',
				'ColCollectionEventRef->ecollectionevents->LocOcean',
				'WebLocProvinceStateTerritory',
				'LocPreciseLocation',
				'LatCentroidLatitude0',
				'LatCentroidLongitude0',
				'ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab',
				'ColCollectionEventRef->ecollectionevents->ColDateVisitedFrom',
				'AquDepthFromMet', 
				'AquHabitat_tab',
				);
		
		$this->SuppressEmptyFields = 0;
	}

	function
	adjustOutput($item)
	{
		// If String definition then turn to a field item
		if (is_string($item))
			$field = new Field($item, $this->_STRINGS[$item]);

		switch(strtolower(get_class($item)))
		{
			case 'field':
				if (preg_match('/_tab/', $item->ColName)
				    || preg_match('/[^:\d]0$/', $item->ColName) )
				{
					if(preg_match('/IdeDateIdentified/', $item->ColName))
					{
						$item->ColName = preg_replace('/0$/', ':1', $item->ColName);
						$this->_printField($item);
					}
					elseif(preg_match('/IdeIdentifiedByRef/', $item->ColName))
					{
						$item->ColName = preg_replace('/_tab/', ':1', $item->ColName);
						$this->_printField($item);
					}
					else
						$this->_printTabField($item);
				}
				else
				{
					$this->_printField($item);
			}
			break;

			case 'table':
				$this->_printTable($item);
				break;

			case 'formatfield':
				$this->_printFormatField($item);
				break;
			case 'backreferencefield':
				$this->_printBackReferenceField($item);
				break;
		}

	}

}


class
TePapaPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	TePapaPartyDisplay()
	{
		// Setup Birth and Death Date fields to be shown on
		//	Party records
		$bioBirthDate = new Field;
		$bioBirthDate->ColName = 'BioBirthDate';
		$bioBirthDate->Label = 'Born';
		$bioBirthDate->ShowCondition = 'NamPartyType = Person';

		$bioDeathDate = new Field;
		$bioDeathDate->ColName = 'BioDeathDate';
		$bioDeathDate->Label = 'Died';
		$bioDeathDate->ShowCondition = 'NamPartyType = Person';
		
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				$bioBirthDate,
				$bioDeathDate,
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}

}
?>
