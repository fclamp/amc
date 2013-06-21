<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
LcmsStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	LcmsStandardDisplay()
	{
		$location = new FormatField;
		$location->Label = 'Location';
		$location->Format = '{LocCurrentLocationRef->elocations->LocLevel1}, {LocCurrentLocationRef->elocations->LocLevel2}';	
		
		$emptyLocation = new FormatField;
		$emptyLocation->Label = 'Location';
		$emptyLocation->Format = 'Not on Display';
		$emptyLocation->ShowCondition = 'LocCurrentLocationRef->elocations->LocLevel1 = /^$/';	

		$colHeight = new Field;
		$colHeight->ColName = 'DimHeight_tab';

		$colWidth = new Field;
		$colWidth->ColName = 'DimWidth_tab';

		$colLength = new Field;
		$colLength->ColName = 'DimLength_tab';
	
		$dimTable = new Table;
		$dimTable->Name = 'Physical Dimensions';
		$dimTable->Columns = array($colHeight, $colWidth, $colLength);

		$this->Fields = array(	
			'ClaObjectName:1',  
			'ClaObjectName_tab',
			'ColAccessionNumber',
			$dimTable,
			'ColCollectionName_tab',
			'ProProductionDate',
			'MatPrimaryMaterials_tab',
			'MatSecondaryMaterials_tab',
			'MatTechnique_tab',
			'DesInscriptions',
			'DesPhysicalDescription',
			$location,
			$emptyLocation,	
			//'LocCollectorsRef_tab->eparties->SummaryData',
			);
		
		$this->BaseStandardDisplay();
	}
}

class
LcmsPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	LcmsPartyDisplay()
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
