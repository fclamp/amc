<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'ResultsLists.php');

class
NmnhPalStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhPalStandardResultsList()
	{
		$this->NmnhStandardResultsList();

		$this->referer = '/pages/nmnh/pal/Query.php';
                $this->Order = '+IdeFiledAsQualifiedNameWeb|+CatPrefix|+CatNumber|+CatSuffix';

                $details = new FormatField;
                $details->Format = 'Detailed View';
                $details->Label = 'Click for Details';

		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber}.{CatSuffix}';
		$catNumber->Label = 'Catalog Number';

		$this->Fields = array
		(
			$details,
			$catNumber,
			'CatCollectionName:1',
			'IdeFiledAsClass',
			'IdeFiledAsOrder',
			'IdeFiledAsQualifiedNameWeb',
			'AgeStratigraphyFormation:1',
			'AgeGeologicAgeSystem:1',
			'BioCountryLocal',
			'BioOceanLocal',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhPalContactSheet extends NmnhContactSheet
{
	function
	NmnhPalContactSheet()
	{
		$this->NmnhContactSheet();
		
                $this->Order = '+IdeFiledAsQualifiedNameWeb|+CatPrefix|+CatNumber|+CatSuffix';

		$details = new FormatField;
                $details->Format = 'Detailed View';

		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber}.{CatSuffix}';

		$this->Fields = array
		(	
			$details,
			$catNumber,
			'IdeFiledAsQualifiedNameWeb',
			'IdeFiledAsClass',
		);	
	}
}
//=====================================================================================================
//=====================================================================================================
?>
