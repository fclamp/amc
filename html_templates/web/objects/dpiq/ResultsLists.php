<?php

/* Copyright (c) 1998-2009 KE Software Pty Ltd
**
** Simple DPIQ interface.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');


class
DpiqStandardResultsList extends BaseStandardResultsList
{
	function
	DpiqStandardResultsList()
	  {
                $this->BaseStandardResultsList();
                $catNumber = new FormatField;
                $catNumber->Format = "{TaxAccNo1} {TaxAccNo2} {TaxAccNo3}";
                $catNumber->Label = "Accession No";

                $locality = new FormatField;
                $locality->Format = "{LocPlace}, {LocState}, {LocCountry}";
                $locality->Label = "Locality";

                $collector = new FormatField;
                $collector->Format = "{ColPrimaryCollectorLocal} {ColCollectionDate}";
                $collector->Label = "Collector";

                $webname = new FormatField;
                $webname->Format = '{WebName}';
                $webname->Label = "Name";

                $this->Fields = array(  $catNumber,
                                        //'WebName',
                                        $webname,
                                        'WebHostSubstrate',
                                        $locality,
                                        $collector,
                                        );
                $this->Database = 'edpiq';
                $this->DisplayThumbnails = 0;
		$this->BaseStandardResultsList();
	}	

}


class
DpiqContactSheet extends BaseContactSheet
{
	function
	DpiqContactSheet()
	{
		$this->Fields = array
				(
					'irn_1',
                                        'WebName',
				);

                $this->Database = 'edpiq';
		$this->BaseContactSheet();
	}

}

?>
