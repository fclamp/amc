<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'ResultsLists.php');

$GLOBALS['STRINGS_DIR'] = $WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . $GLOBALS['DEPARTMENT'] . '/strings/' . $GLOBALS['BACKEND_ENV'] . '/';

//======================================================================================================
//======================================================================================================
class
NmnhVzBirdsStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhVzBirdsStandardResultsList()
	{
		$this->NmnhStandardResultsList();

		$this->Order = '+IdeFiledAsFamilyNumber|+IdeFiledAsQualifiedNameWeb|+BioCountryLocal|+BioProvinceStateLocal|+CatNumber';
		$this->referer = '/pages/nmnh/vz/QueryBirds.php';

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
			'CatCollectionName:1',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsRef->etaxonomy->ClaOrder',
			'BioEventSiteRef->ecollectionevents->LocCountry', 
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory', 
		);
	}
}
//======================================================================================================
//======================================================================================================
class
NmnhVzMammalsStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhVzMammalsStandardResultsList()
	{
		$this->NmnhStandardResultsList();

		$this->Order = '+IdeFiledAsGenusNumber|+IdeFiledAsQualifiedNameWeb|+BioCountryLocal|+BioProvinceStateLocal|+CatNumber';
                $this->referer = '/pages/nmnh/vz/QueryMammals.php';

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
			'CatCollectionName:1',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsRef->etaxonomy->ClaOrder',
			'BioEventSiteRef->ecollectionevents->LocCountry', 
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory', 
		);
	}
}
//======================================================================================================
//======================================================================================================
class
NmnhVzFishesStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhVzFishesStandardResultsList()
	{
		$this->NmnhStandardResultsList();

		$this->Order = '+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb';
                $this->referer = '/pages/nmnh/vz/QueryFishes.php';

                $details = new FormatField;
                $details->Format = 'Detailed View';
                $details->Label = 'Click for Details';

		$catNumber = new FormatField;
		$catNumber->Format = '{CatPrefix} {CatNumber} {CatSuffix}';
		$catNumber->Label = 'Catalog (USNM) #';

		$this->Fields = array
		(	
			$details,
			$catNumber,
			'IdeFiledAsQualifiedNameWeb',
			'IdeFiledAsTypeStatus',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'BioEventSiteRef->ecollectionevents->LocOcean', 
			'BioEventSiteRef->ecollectionevents->LocCountry', 
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory', 
		);
	}
}
//======================================================================================================
//======================================================================================================
class
NmnhVzHerpsStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhVzHerpsStandardResultsList()
	{
		$this->NmnhStandardResultsList();

		$this->Order = '+IdeFiledAsClass|+IdeFiledAsOrder|+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb';
                $this->referer = '/pages/nmnh/vz/QueryHerps.php';

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
			'IdeFiledAsRef->etaxonomy->ClaClass',
			'IdeFiledAsRef->etaxonomy->ClaOrder',
			'IdeFiledAsRef->etaxonomy->ClaFamily',
			'IdeFiledAsQualifiedNameWeb',
			'BioEventSiteRef->ecollectionevents->LocCountry', 
			'BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory', 
		);
	}
}
//======================================================================================================
//======================================================================================================
class
NmnhVzBirdsContactSheet extends NmnhContactSheet
{
	function
	NmnhVzBirdsContactSheet()
	{
		$this->NmnhContactSheet();

		$this->Order = '+IdeFiledAsFamilyNumber|+IdeFiledAsQualifiedNameWeb|+BioCountryLocal|+BioProvinceStateLocal|+CatNumber';

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
//======================================================================================================
//======================================================================================================
class
NmnhVzFishesContactSheet extends NmnhContactSheet
{
	function
	NmnhVzFishesContactSheet()
	{
		$this->NmnhContactSheet();

		$this->Order = '+IdeFiledAsFamily|+IdeFiledAsQualifiedNameWeb';

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
//======================================================================================================
//======================================================================================================
class
NmnhVzHerpsContactSheet extends NmnhContactSheet
{
	function
	NmnhVzHerpsContactSheet()
	{
		$this->NmnhContactSheet();

		$this->Order = '+IdeFiledAsClass|+IdeFiledAsOrder|+IdeFiledAsFamily';

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
//======================================================================================================
//======================================================================================================
class
NmnhVzMammalsContactSheet extends NmnhContactSheet
{
	function
	NmnhVzMammalsContactSheet()
	{
		$this->NmnhContactSheet();

		$this->Order = '+IdeFiledAsGenusNumber|+IdeFiledAsQualifiedNameWeb|+BioCountryLocal|+BioProvinceStateLocal|+CatNumber';

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
//======================================================================================================
//======================================================================================================
?>
