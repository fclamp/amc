<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'ResultsLists.php');

class
NmnhMsStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhMsStandardResultsList()
	{
		$this->NmnhStandardResultsList();

                $this->Order = '+MetMeteoriteName|+CatPrefix|+CatNumber|+CatSuffix';
		$this->referer = '/pages/nmnh/ms/Query.php';

                $details = new FormatField;
                $details->Format = 'Detailed View';
                $details->Label = 'Click for Details';

		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber} {CatSuffix}';
		$catNumber->Label = 'Catalog #';

		$this->Fields = array
		(	
			$details,
			$catNumber,
			'CatDivision',
			'IdeTaxonRef:1->etaxonomy->ClaSpecies',
			'MetMeteoriteName',
			'BioEventSiteRef->ecollectionevents->VolVolcanoName',
			'BioEventSiteRef->ecollectionevents->LocCountry',
			'BioEventSiteRef->ecollectionevents->LocMineName',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhMsContactSheet extends NmnhContactSheet
{
	function
	NmnhMsContactSheet()
	{
		$this->NmnhContactSheet();

                $this->Order = '+MetMeteoriteName|+CatPrefix|+CatNumber|+CatSuffix';

	        $details = new FormatField;
	        $details->Format = 'Detailed View';

		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber} {CatSuffix}';

		$this->Fields = array
		(	
			$details,
			$catNumber,
			'CatDivision',
			'IdeTaxonRef:1->etaxonomy->ClaSpecies',
			'MetMeteoriteName',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
