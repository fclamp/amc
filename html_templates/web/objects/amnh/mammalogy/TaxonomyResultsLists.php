<?php

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
AmnhTaxonomyStandardResultsList extends BaseStandardResultsList
{
	function
	AmnhTaxonomyStandardResultsList()
	{
		$this->BaseStandardResultsList();
		$this->Fields = array(	
					'ClaScientificName',
					'ClaFamily',
					'ClaSubfamily',
					'ClaGenus',
					'ClaSpecies',
					'ClaSubspecies',
					);	
		$this->DisplayPage = "../../../pages/amnh/mammalogy/TaxonomyDisplayPage.php";
		$this->QueryPage = "../../../pages/amnh/mammalogy/TaxonomyQuery.php";
		$this->Database = 'etaxonomy';
	}	

}

/*
class
AmnhTaxonomyContactSheet extends BaseContactSheet
{
	function
	AmnhTaxonomyContactSheet()
	{
		$this->BaseContactSheet();
		$this->Fields = array(	'irn_1'
					);	

		$this->DisplayPage = "../../../pages/amnh/mammalogy/TaxonomyDisplayPage.php";
		$this->QueryPage = "../../../pages/amnh/mammalogy/TaxonomyQuery.php";
		$this->ResultsListPage = "../../../pages/amnh/mammalogy/TaxonomyBrowserResultsList.php";
		$this->Database = 'etaxonomy';
	}

}
*/

?>
