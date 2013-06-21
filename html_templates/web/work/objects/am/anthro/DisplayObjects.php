<?php

/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/* 

Created By: Martin Jujou
Creation Date: 17/9/2003
Last Modified: 25/9/2003

*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');


// displays narrative information
class
AmStandardDisplay extends BaseStandardDisplay
{

	// Set default in the constructor
	function
	AmStandardDisplay()
	{
		// associated narratives
		$ass = new BackReferenceField;
		$ass->RefDatabase = "enarratives";
		$ass->RefField = "AssMasterNarrativeRef";
		$ass->ColName = "SummaryData";
		$ass->Label = "Sub Narratives:";
		$ass->LinksTo = "Display.php";

		// master narrative
		$master = new BackReferenceField;
		$master->RefDatabase = "enarratives";
		$master->RefField = "AssAssociatedWithRef_tab";
		$master->ColName = "SummaryData";
		$master->Label = "Master Narrative:";
		$master->LinksTo = "Display.php";

		// links to authors
		$authors = new Field;
		$authors->Database = "eparties";
		$authors->Field = "SummaryData";
		$authors->Label = "Related Authors:";
		$authors->ColName = "NarAuthorsRef_tab->eparties->SummaryData";
		$authors->LinksTo = "DisplayParty.php";

		// links to parties 
		$parties = new Field;
		$parties->Database = "eparties";
		$parties->Field = "SummaryData";
		$parties->ColName = "ParPartiesRef_tab->eparties->SummaryData";
		$parties->LinksTo = "DisplayParty.php";

		// links to associated objects 	
		$objects = new Field;
		$objects->Database = "ecatalogue";
		$objects->Field = "SummaryData";
		$objects->ColName = "ObjObjectsRef_tab->ecatalogue->SumItemName";
		$objects->LinksTo = "DisplayObject.php";

		// related module table
		$modTable = new Table();
		$modTable->Name = "Associated Modules:";
		$modTable->Headings = array("Related Parties/Cultures", "Related Objects");
		$modTable->Columns = array($parties, $objects); 

		$this->Fields = array(
				'NarTitle',
				//'irn_1',
				'NarNarrative',
				'DesVersionDate',
				//'DesHistoricalSignificance',
				//'DesPurpose',
				//'DesType_tab',
				//'DesIntendedAudience_tab',
				'DesGeographicLocation_tab',
				'DesSubjects_tab',
				//'NotNotes',
				$master,
				$ass,
				$authors, 
				$modTable
				);


		$this->HeaderField = 'SummaryData';
		$this->BaseStandardDisplay();
		$this->Database = 'enarratives';
	}
}


// displays object
class
AmObjectDisplay extends BaseStandardDisplay
{

	function
	AmObjectDisplay()
	{
		// narrative link
		$narrative = new BackReferenceField;
		$narrative->RefDatabase = "enarratives";
		$narrative->RefField = "ObjObjectsRef_tab";
		$narrative->ColName = "SummaryData";
		$narrative->Label = "Narrative Links:";
		$narrative->LinksTo = "Display.php";

				
		/*
		$party = new BackReferenceField;
		$party->RefDatabase = "enarratives";
		$party->RefField = "ObjObjectsRef_tab";
		$party->ColName = "NarAuthorsRef_tab";
		$party->Label = "Party Links";
		$party->LinksTo = "DisplayParty.php";
		*/


		// links to sources 
		$sources = new Field;
		$sources->Database = "eparties";
		$sources->Field = "SummaryData";
		$sources->Label = "Acquired From:";
		$sources->ColName = "AcqNameSourceRef_tab->eparties->SummaryData";
		$sources->LinksTo = "DisplayParty.php";

		// bibliography summary
		$bib = new Field;
		$bib->Database = "ebibliography";
		$bib->Field = "SummaryData";
		$bib->Label = "Bibliography:";
		$bib->ColName = "AcqBibliographyRef_tab->ebibliography->SummaryData";
		$bib->LinksTo = "DisplayBib.php";

		// links to objects
		$obj = new Field;
		$obj->Database = "ecatalogue";
		$obj->Field = "SumItemName";
		$obj->Label = "Associated Objects:";
		$obj->ColName = "ObjAssocObjectsRef_tab->ecatalogue->SumItemName";
		$obj->LinksTo = "DisplayObject.php";


		// links to cultural associates 
		$cult = new Field;
		$cult->Database = "eparties";
		$cult->Field = "SummaryData";
		$cult->Label = "Cultural Associations:";
		$cult->ColName = "ObjCulturalAssocRef_tab->eparties->SummaryData";
		$cult->LinksTo = "DisplayParty.php";


		// dimensions height 	
		$height = new Field;
		$height->Database = "ecatalogue";
		$height->ColName = "ObjHeight";

		
		// dimensions length 	
		$length = new Field;
		$length->Database = "ecatalogue";
		$length->ColName = "ObjLength";

		// dimensions width
		$width = new Field;
		$width->Database = "ecatalogue";
		$width->ColName = "ObjWidth";

		// dimensions depth
		$depth = new Field;
		$depth->Database = "ecatalogue";
		$depth->ColName = "ObjDepth";

		// dimensions diameter 
		$diam = new Field;
		$diam->Database = "ecatalogue";
		$diam->ColName = "ObjDiameter";

		// dimensions circumference 
		$circ = new Field;
		$circ->Database = "ecatalogue";
		$circ->ColName = "ObjCircumference";

		// dimensions weight 
		$weight = new Field;
		$weight->Database = "ecatalogue";
		$weight->ColName = "ObjWeight";

		// dimensions clothing size 
		$size = new Field;
		$size->Database = "ecatalogue";
		$size->ColName = "ObjClothingSize";

		// dimensions table
		$dim = new Table();
		$dim->Name = "Dimensions:";
		$dim->Headings = array("Height", "Length", "Width", "Depth", "Diameter", "Circumference", "Weight", "Clothing Size");
		$dim->Columns = array($height, $length, $width, $depth, $diam, $circ, $weight, $size); 


		$this->Fields = array(
				'SumItemName',	
				//'irn_1',
				'SumRegNum',
				'ObjDescription',
				'ObjLabel',
				'ProCollectionArea',
				'ProRegion',
				'ProPlace',
				'ProStateProvince_tab',
				'ProCountry_tab',
				//'SumCategory',
				'SumArchSiteName',
				'AcqRegDate',
				//'SumAccessionLotRef->eaccessionlots->LotLotNumber',
				//'SumAccessionLotRef->eaccessionlots->AcqDateReceived',
				//'LocCurrentLocationRef->elocations->SummaryData',
				//'LocPermanentLocationRef->elocations->SummaryData',
				$dim,
				$bib,
				$sources,
				$cult,
				$obj,
				$narrative
				);


		$this->HeaderField = 'SumItemName';	
		$this->BaseStandardDisplay();
		$this->Database = 'ecatalogue';
	}
}

// display bibliography information
class
AmBibDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	AmBibDisplay()
	{

		// Authors and Contributors
		$authors = new Field;
		$authors->Database = "eparties";
		$authors->Field = "SummaryData";
		$authors->Label = "Authors/Contributors:";
		$authors->ColName = "BooAuthorsRef_tab->eparties->SummaryData";
		$authors->LinksTo = "DisplayParty.php";

		// publishers
		$pubs = new Field;
		$pubs->Database = "eparties";
		$pubs->Field = "SummaryData";
		$pubs->Label = "Publishers:";
		$pubs->ColName = "BooPublishedByRef->eparties->SummaryData";
		$pubs->LinksTo = "DisplayParty.php";


		$this->Fields = array(
				'BooTitle',
				'BooISBN',
				'BooEdition',
				'BooVolume',
				'BooPages',
				'BooPublicationCity',
				'BooPublicationDate',
				$authors
				//$pubs
				);


		$this->BaseStandardDisplay();
		$this->HeaderField = 'SummaryData';
		$this->Database = 'ebibliography';
	}
}


// displays party information
class
AmPartyDisplay extends BaseStandardDisplay
{

	// Set default field in the constructor
	function
	AmPartyDisplay()
	{
		// narrative link
		$narrative = new BackReferenceField;
		$narrative->RefDatabase = "enarratives";
		$narrative->RefField = "ParPartiesRef_tab";
		$narrative->ColName = "SummaryData";
		$narrative->Label = "Related Narratives:";
		$narrative->LinksTo = "Display.php";

		// links to parties 
		$parties = new Field;
		$parties->Database = "eparties";
		$parties->Field = "SummaryData";
		$parties->Label = "Associated Parties:";
		$parties->ColName = "AssAssociationRef_tab->eparties->SummaryData";
		$parties->LinksTo = "DisplayParty.php";


		/*
		should work !!!!
		$object = new BackReferenceField;
		$object->RefDatabase = "enarratives";
		$object->RefField = "NarAuthorsRef_tab";
		$object->ColName = "ObjObjectsRef_tab->ecatalogue->SummaryData";
		$object->Label = "Related Objects";
		$object->LinksTo = "DisplayObject.php";
		*/

		$this->Fields = array(
				'SummaryData',
				//'irn_1',
				'NamTitle',
				'NamFirst',
				'NamMiddle',
				'NamLast',
				//'NamPartyType',		
				//'NamRoles_tab',
				//'NamSpecialities_tab',
				//'BioNationality',
				//'BioCulturalInfluences_tab',
				//'NamSex',
				//'BioBirthPlace',
				//'BioDeathPlace',
				//'BioEthnicity',
				'BioBirthDate',
				'BioDeathDate',
				'BioLabel',
				//'NotNotes',
				$parties,
				$narrative

				);


		$this->BaseStandardDisplay();
		$this->HeaderField = 'SummaryData';
		$this->Database = 'eparties';
	}
}



?>
