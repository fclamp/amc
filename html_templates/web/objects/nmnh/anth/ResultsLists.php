<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if ( ! isset( $WEB_ROOT ) )
	$WEB_ROOT = dirname( dirname( dirname( dirname( realpath( __FILE__ ) ) ) ) );

require_once ( $WEB_ROOT . '/objects/lib/webinit.php' );
require_once ( $WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst( $GLOBALS['BACKEND_TYPE'] ) . 'ResultsLists.php' );

class
NmnhAnthStandardResultsList extends NmnhStandardResultsList
{
	function
	NmnhAnthStandardResultsList()
	{
		$this->NmnhStandardResultsList();
	
		$this->Order = '+CatPrefix|+CatNumber|+CatSuffix|+CatPartNumber';
                $this->referer = '/pages/nmnh/anth/Query.php';

		$culture = new FormatField;
		$culture->Format = '{CulCulture2Local:1} : {CulCulture3Local:1} : {CulCulture4Local:1} : {CulCulture5Local:1}';
		$culture->Label = 'Culture';

                $barcode = new FormatField;
                $barcode->Format = '{CatBarcode}';
                $barcode->Label = 'Cat. No.';

                $pst = new FormatField;
                $pst->Format = '{BioEventSiteRef->ecollectionevents->LocProvinceStateTerritory}';
                $pst->Label = 'State / Prov.';

		$this->Fields = array
		(
			$barcode,
                        'CatDivision',
                    	'IdeCurrentIndexTerm',
                    	'IdeCurrentObjectName',
                        $culture,
			'BioEventSiteRef->ecollectionevents->LocCountry',
			$pst,
                        'MulHasMultimediaInternet',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
class
NmnhAnthContactSheet extends NmnhContactSheet
{
	function
	NmnhAnthContactSheet()
	{
		$this->NmnhContactSheet();

		$this->Order = '+CatPrefix|+CatNumber|+CatSuffix|+CatPartNumber';

		$culture = new FormatField;
		$culture->Format = '{CulCulture2Local:1} : {CulCulture3Local:1} : {CulCulture4Local:1} : {CulCulture5Local:1}';
		$culture->Label = 'Culture';

	        $this->Fields = array
		(    
			'CatBarcode',
			'IdeCurrentIndexTerm',
			$culture,
			'BioEventSiteRef->ecollectionevents->LocCountry',
		);	
	}
}
//=====================================================================================================
//=====================================================================================================
?>
