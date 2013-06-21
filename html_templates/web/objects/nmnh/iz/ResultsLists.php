<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'ResultsLists.php');

class
NmnhIzStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhIzStandardResultsList()
	{
		$this->NmnhStandardResultsList();

		$this->referer = '/pages/nmnh/iz/Query.php';
                $this->Order = '+IdeFiledAsPhylum|+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb|+CatNumber';

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
			'IdeFiledAsQualifiedNameWeb',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsRef->etaxonomy->ClaPhylum',
			'BioEventSiteRef->ecollectionevents->LocOcean',
			'BioEventSiteRef->ecollectionevents->LocCountry',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhIzContactSheet extends NmnhContactSheet
{
	function
	NmnhIzContactSheet()
	{
		$this->NmnhContactSheet();

                $this->Order = '+IdeFiledAsPhylum|+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb|+CatNumber';

                $details = new FormatField;
                $details->Format = 'Detailed View';

		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber} {CatSuffix}';

	        $this->Fields = array
		(   
			$details,
			$catNumber,
			'IdeFiledAsQualifiedNameWeb',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>
