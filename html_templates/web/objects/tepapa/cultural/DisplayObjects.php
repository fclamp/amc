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

		/*
		** the Maker table
		*/
		$proMaker = new Field;
		$proMaker->ColName = 'ProProductionMakerLocal';

		$proRole = new Field;
		$proRole->ColName = 'WebProMakerRole_tab';
		
		$proDate = new Field;
		$proDate->ColName = 'ProProductionDate_tab';
		
		$proPlace = new Field;
		$proPlace->ColName = 'WebProProdPlace_tab';
		
		
		/*
		$proMakerRef = new Field;
		$proMakerRef->ColName = 'ProProductionMakerRef_tab';
		$proMakerRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		*/
		
		$MakerTable = new Table;
		$MakerTable->Name = "MAKER";
		$MakerTable->Columns = array( 	$proMaker, 
						$proRole, 
						$proDate, 
						$proPlace,
					);


		/*
		** setting up the Dimensions table
		*/
		$height = new Field;
		$height->ColName = 'DimHeight_tab';

		$length = new Field;
		$length->ColName = 'DimLength_tab';

		$width = new Field;
		$width->ColName = 'DimWidth_tab';

		$dimater = new Field;
		$dimater->ColName = 'DimOutsideDiameter_tab';

		$lenUnit = new Field;
		$lenUnit->ColName = 'DimLengthUnit_tab';
		$lenUnit->Italics = 1;
		
		$weight = new Field;
		$weight->ColName = 'DimWeight_tab';

		$wghUnit = new Field;
		$wghUnit->ColName = 'DimWeightUnit_tab';
		$wghUnit->Italics = 1;

		$dimNotes = new Field;
		$dimNotes->ColName = 'DimDimensionComments0';


		$MeaTable = new Table;
		$MeaTable->Name = "Dimensions";
		$MeaTable->Columns = array(	$height, 
						$length, 
						$width, 
						$dimater,
						$lenUnit,
						$weight,
						$wghUnit,
						$dimNotes
					);

/*
		$assParty = new Field;
		$assParty->ColName = 'AssAssociationNameRef_tab->eparties->SummaryData';

		$assPartyTable = new Table;
		$assPartyTable->Columns = array($assParty
				);
				*/

		$this->Fields = array(
				'SummaryData',
				'ColCollectionType',
				'RegRegistrationNumberString',
				'WebClaObjectName_tab',
				'ClaMainTitle',
				$MakerTable,
				'WebMatPrimaryMaterials_tab',
				'WebMatTechnique_tab',
				$MeaTable,
				'MeaFormat_tab',
				'DesWebSummary',
				'SubSubjects_tab',
				'AssHistoricalEvent_tab',
				'AssPeriodStyle_tab',
				'AssConcept_tab',
				//$assPartyTable,
				'AssAssociationNameRef_tab->eparties->SummaryData',
				'AssAssociationCountry_tab',
				'WebProCulturalGroup_tab',
				'AssAssociationDate_tab',
				);
		
		$this->SuppressEmptyFields = 0;
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
