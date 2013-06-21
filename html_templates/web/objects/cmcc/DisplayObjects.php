<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
CmccStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	CmccStandardDisplay()
	{
		$desMakerRef = new Field();
		$desMakerRef->ColName = 'DesMakerRef_tab->eparties->SummaryData';
		$desMakerRef->LinksTo = $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		
		$makerTable = new Table();
		$makerTable->Name = "ARTIST/MAKER";
		$makerTable->Columns = array($desMakerRef);

		$this->Fields = array(
				'NumCatNo',
				'NumAccessionNo_tab',
				'ObjDisplayName',
				'ClaCategory_tab',
				'ClaSubCat_tab',
				'ObjTitle',
				'AffOriCountry_tab',
				'AffOriProvince_tab',
				$makerTable,
				'AffCurrCultAffiliations_tab',
				'DatBegin',
				'DatEnd',
				'DatOtherMethods',
				'MeaUnit',
				'MeaDepth',
				'MeaHeight',
				'MeaLength',
				'MeaWidth',
				'MeaOutDiameter',
				);
		
		$this->BaseStandardDisplay();
	}
}


class
CmccPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	CmccPartyDisplay()
	{
		$this->Fields = array(
				'SummaryData',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				'BioBirthPlace',
				'BioDeathPlace',
				'BioEthnicity',
				'NotNotes',
				);
		$this->Database = 'eparties';

		$this->BaseStandardDisplay();
	}
}

?>
