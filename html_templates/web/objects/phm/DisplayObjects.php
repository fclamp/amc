<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd

Martin Jujou
24/10/2003


*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');

class
CatalogueStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	CatalogueStandardDisplay()
	{

		// dimensions height 
		$height = new Field;
		$height->Database = "ecatalogue";
		$height->ColName = "DimHeight_tab";

		// dimensions length
		$length = new Field;
		$length->Database = "ecatalogue";
		$length->ColName = "DimLength_tab";

		// dimensions width 
		$width = new Field;
		$width->Database = "ecatalogue";
		$width->ColName = "DimWidth_tab";

		// dimensions depth 
		$depth = new Field;
		$depth->Database = "ecatalogue";
		$depth->ColName = "DimDepth_tab";

		// dimensions diameter 
		$diameter = new Field;
		$diameter->Database = "ecatalogue";
		$diameter->ColName = "DimDiameter_tab";

		// dimensions unit length 
		$ulength = new Field;
		$ulength->Database = "ecatalogue";
		$ulength->ColName = "DimUnitLength_tab";
		
		// dimensions weight 
		$weight = new Field;
		$weight->Database = "ecatalogue";
		$weight->ColName = "DimWeight_tab";

		// dimensions unit weight 
		$uweight = new Field;
		$uweight->Database = "ecatalogue";
		$uweight->ColName = "DimUnitWeight_tab";

		// dimensions type 
		$type = new Field;
		$type->Database = "ecatalogue";
		$type->ColName = "DimType_tab";

		
		$dimTable = new Table();
		$dimTable->Name = "Dimensions:";
		$dimTable->Headings = array("Height", "Length", "Width", "Depth", "Diameter", 
		"Unit Length", "Weight", "Unit Weight", "Type");
		$dimTable->Columns = array($height, $length, $width, 
		$depth, $diameter, $ulength, $weight, $uweight, $type);


		// associated events 
		$events = new BackReferenceField;
		$events->RefDatabase = "eevents";
		$events->RefField = "ObjAttachedObjectsRef_tab";
		$events->ColName = "SummaryData";
		$events->Label = "Events:";


		$this->Fields = array(

				'DesObjectStatement',
				'SumRegistrationNumber',
				'DesDescription',
				'DesMarks',
				$dimTable,
				DimNotes, 
				HisHistoryNotes, 
				ProProductionNotes, 
				SigStatement, 
				ArcAdministrativeHistory,
				$events

				);


		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();
	}
}

class
AccessionStandardDisplay extends BaseStandardDisplay
{

	function
	AccessionStandardDisplay()
	{

		// associated objects 
		$objects = new BackReferenceField;
		$objects->RefDatabase = "ecatalogue";
		$objects->RefField = "AccAccessionLotRef";
		$objects->ColName = "SummaryData";
		$objects->Label = "Objects:";

		$this->Fields = array(
				
				'LotDescription',
				'LotLotNumber',
				$objects

				);

		$this->Database = 'eaccessionlots';
		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();

	}
}


class
ThesaurusStandardDisplay extends BaseStandardDisplay
{

	function
	ThesaurusStandardDisplay()
	{

		$this->Fields = array(
		
				'TerTerm',
				'TerScopeNotes',
				'BioText'

				);

		$this->Database = 'ethesaurus';
		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();

	}
}



?>
