<?php

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ('DefaultPaths.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');
require_once ($LIB_DIR . 'texquery.php');




if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
AmnhStandardResultsList extends BaseStandardResultsList
{
	function
	AmnhStandardResultsList()
	{
	/*
		$prepType = new BackReferenceField;
		$prepType->RefDatabase = "ecatalogue";
		$prepType->RefField = 'PreObjectRef';
		$prepType->ColName = 'PrePrepType';
		*/

		$this->Fields = array(	'CatNumber',
					'IdeGenusLocal:1',
					'IdeSpeciesLocal:1',
					'IdeSubspeciesLocal:1',
					'BioSiteCountyLocal',
					'BioSiteStateLocal',
					'BioSiteCountryLocal',
					'PrePrepType',
					);	

		$this->BaseStandardResultsList();
	}	

	function
	adjustData($field, $rec, $fieldData)
	{
		/* choosing PrePrepType as the column as it the prep
		** type that will be displayed, also this field should
		** be empty for specimen records.
		*/
		if ($field == 'PrePrepType')
		{
			$irn = $rec->irn_1;
			$newquery = new Query;
			$newquery->Texql = 'select PrePrepType from ecatalogue where PreObjectRef=' . $irn;
			$items = $newquery->Fetch();
			foreach ($items as $i)
			{
				if ($fieldData == '')
					$fieldData = $i->PrePrepType;
				else
					$fieldData = $fieldData . ', ' . $i->PrePrepType;
					
			}
		}
		return $fieldData;
	}
}


?>
