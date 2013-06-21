<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'ResultsLists.php');

class
NmnhBotanyStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhBotanyStandardResultsList()
	{
		$this->NmnhStandardResultsList();
		
                $this->Order = '+CatCatalog|+CatDivision|+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb';
                $this->OrderLimit = 2000;
                $this->referer = '/pages/nmnh/bot/Query.php';
		
		$details = new FormatField;
                $details->Format = 'Detailed View';
                $details->Label = 'Click for Details';

		$catNumber = new FormatField;
        	$catNumber->Label = 'Catalog #';
            	$catNumber->Format = '{CatPrefix}{CatNumber} {CatSuffix}';

		$this->Fields = array
		(
			$details,
			'CatCatalog',
			'IdeFiledAsFamily',
			'IdeFiledAsQualifiedNameWeb',
			'CatBarcode',
			$catNumber,
			'IdeFiledAsTypeStatus',
			'BioEventSiteRef->ecollectionevents->ColPrimaryParticipantLocal',
			'BioPrimaryCollNumber',
			'BioEventSiteRef->ecollectionevents->LocCountry',
		);
	}
}
//=====================================================================================================
//=====================================================================================================

class
NmnhBotanyContactSheet extends NmnhContactSheet
{
	function
	NmnhBotanyContactSheet()
	{
		$this->NmnhContactSheet();

                $this->Order = '+CatCatalog|+CatDivision|+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb';
                $this->OrderLimit = 2000;

		$details = new FormatField;
                $details->Format = 'Detailed View';

		$catNumber = new FormatField;
            	$catNumber->Format = '{CatPrefix}{CatNumber} {CatSuffix}';

		$this->Fields = array
		(
			$details,
			$catNumber,
			'IdeFiledAsQualifiedName',
		);	
	}
} 
//=====================================================================================================
//=====================================================================================================
?>
