<?php
/********************************************************
 *  Copyright (c) 1998-2009 KE Software Pty Ltd
 ********************************************************/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ('DefaultPaths.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');
//require_once ($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');

class TaxonomyDisplayObjectTitle 
{
	var $info;
	var $suffix;

	function TaxonomyDisplayObjectTitle($suffix)
	{
		global $ALL_REQUEST;

		$this->suffix = $suffix;
		$all = array_merge($ALL_REQUEST['HTTP_GET_VARS'],$ALL_REQUEST['HTTP_POST_VARS']);
		$this->info = $all['name'];
	}

	function Show()
	{
		print 'KE EMu "'. $this->info . '" '. $this->suffix;
	}
}

/*******************************************************
 *
 * class TaxonomyStandardDisplay extends BaseStandardDisplay
 *
 *  mapperDataSource = name to pass to mapper of data source
 *
 *  mapUrl = URL of mapping component
 *
 *
 ******************************************************/

class TaxonomyStandardDisplay extends BaseStandardDisplay
{

//	var $mapDisplay = 0;
//	var $mapperDataSource = '';
//	var $mapUrl = '';

	// Set default in the constructor
	function
	TaxonomyStandardDisplay()
	{
		$this->BaseStandardDisplay();

		$this->DisplayImage = 1;

		$this->HeaderField = 'ClaScientificName';

		$this->Fields = array(
					'ClaScientificName',
					'ClaOrder',
					'ClaFamily',
					'ClaSubfamily',
					'ClaGenus',
					'ClaSpecies',
					'ClaSubspecies',
					'ClaSuborder',
					'ClaSuperfamily',
					'ClaFamilyNumber',
					'ClaGenusNumber',
					'ClaSubgenus',
					'ClaOtherRank_tab',
					'ClaOtherValue_tab',
					'NotNotes',
				);


		$this->Database = 'etaxonomy';

		$this->SuppressEmptyFields = 1;

	}




}
?>
