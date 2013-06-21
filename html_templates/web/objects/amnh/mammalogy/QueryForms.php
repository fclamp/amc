<?php

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ('DefaultPaths.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
AmnhBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	//'any' => 'SummaryData',
				//'Taxon' => 'IdeOrderLocal_tab|IdeFamilyLocal_tab|IdeSubfamilyLocal_tab|IdeGenusLocal_tab|IdeSpeciesLocal_tab|IdeCitationTypeStatus_tab',
				//'Locality' => 'BioSiteCountryLocal|BioSiteStateLocal|BioSiteCountyLocal|BioSitePreciseLocalityLocal',
				//'Collector' => 'BioCollectorsLocal_tab|BioPrimaryCollNumber',
				'any' => 'AdmWebMetadata',
				'Taxon' => 'AdmWebTaxon',
				'Locality' => 'AdmWebLocality',
				'Collector' => 'AdmWebCollector',
				);

	/*
	** should only return non-prep records and by assumption there should
	** be a catalogue number prefix of M for all mammalogy records.
	*/
	var $Restriction = "CatPrefix='M'";

}  

class
AmnhAdvancedQueryForm extends BaseAdvancedQueryForm
{
	/*
	** should only return non-prep records and by assumption there should
	** be a catalogue number prefix of M for all mammalogy records.
	*/
	var $Restriction = "CatPrefix='M'";
	var $Options = array(	//'any' => 'SummaryData',
				//'Taxon' => 'IdeOrderLocal_tab|IdeFamilyLocal_tab|IdeSubfamilyLocal_tab|IdeGenusLocal_tab|IdeSpeciesLocal_tab|IdeCitationTypeStatus_tab',
				//'Locality' => 'BioSiteCountryLocal|BioSiteStateLocal|BioSiteCountyLocal|BioSitePreciseLocalityLocal',
				//'Collector' => 'BioCollectorsLocal_tab|BioPrimaryCollNumber',
				'any' => 'AdmWebMetadata',
				'Taxon' => 'AdmWebTaxon',
				'Locality' => 'AdmWebLocality',
				'Collector' => 'AdmWebCollector',
				);


}  
	

class
AmnhDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	AmnhDetailedQueryForm()
	{
		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$catNumberUpper = new QueryField;
		$catNumberUpper->ColName = 'CatNumber';
		$catNumberUpper->ColType = 'integer';
		$catNumberUpper->IsUpper = 1;

		$catNumberLower = new QueryField;
		$catNumberLower->ColName = 'CatNumber';
		$catNumberLower->ColType = 'integer';
		$catNumberLower->IsLower = 1;

		$colDate = new QueryField;
		$colDate->ColType = 'date';
		$colDate->ColName = 'BioDateVisitedFrom';

		$colDateUpper = new QueryField;
		$colDateUpper->ColType = 'date';
		$colDateUpper->ColName = 'BioDateVisitedFrom';
		$colDateUpper->IsUpper = 1;

		$colDateLower = new QueryField;
		$colDateLower->ColType = 'date';
		$colDateLower->ColName = 'BioDateVisitedFrom';
		$colDateLower->IsLower = 1;

		$this->Restriction = "CatPrefix='M'";
		$this->Fields = array(  $catNumber,
					$catNumberLower,
					$catNumberUpper,
                                        'IdeOrderLocal_tab',
                                        'IdeFamilyLocal_tab',
					'IdeSubfamilyLocal_tab',
                                        'IdeGenusLocal_tab',
                                        'IdeSpeciesLocal_tab',
                                        'IdeSubspeciesLocal_tab',
                                        'IdeCitationTypeStatus_tab',
                                        'BioSiteCountryLocal',
                                        'BioSiteStateLocal',
                                        'BioSiteCountyLocal',
                                        'BioSitePreciseLocalityLocal',
                                        'BioCollectorsLocal_tab',
					$colDate,
					$colDateLower,
					$colDateUpper,
                                        'BioPrimaryCollNumber',
					'ZooSex_tab',
					//'PreKindOfObject',
					//'PrePrepDescription',
                                        );


		$this->Hints = array(	'CatNumber' => "[serch for the exact catalogue number]",
					'CatNumberUpper' => "[search for catalogue numbers up to the number you enter]",
					'CatNumberLower' => "[Search for catalogue numbers from the number you enter]",
					'BioDateVisitedFrom' => "[format: d MMM yyyy, ie. 8 Jan 2005<br>or Format: d/m/yyyy, ie 1/1/2005<br>or Format: d m yyyy, ie 1 1 2005<br>or just a year , ie. 1915]",
					'BioDateVisitedFromUpper' => "[same as above, but will search for dates upto the date you enter]",
					'BioDateVisitedFromLower' => "[same as above, but will search for dates from the date you enter]",
					//'IdeCitationTypeStatus_tab' => "If more, let developers know",
					'ZooSex_tab' => "If more, let developers know",
					'BioCollectorsLocal_tab' => "[ie. J.  Smith]",
                                        'BioPrimaryCollNumber' => "[search for single value only, ie.  12345]",
					);

		/*
		** should only return non-prep records and by assumption there should
		** be a catalogue number prefix of M for all mammalogy records.
		*/
		$this->DropDownLists = array(	
					'IdeCitationTypeStatus_tab' => '',
					'ZooSex_tab' => '|Female|Male|Unknow|',
					'IdeOrderLocal_tab' => 'eluts:Taxonomy[9]',
					'IdeCitationTypeStatus_tab' => 'eluts:Type Status',
			//		'BioSiteCountryLocal' => 'eluts:Continent[2]',
			);

		$this->LookupLists = array (
				//	'IdeOrderLocal_tab' => 'Taxonomy[9]',
					'IdeFamilyLocal_tab' => 'Taxonomy[14]',
					'IdeSubfamilyLocal_tab' => 'Taxonomy[15]',
					'IdeGenusLocal_tab' => 'Taxonomy[19]',
					'IdeSpeciesLocal_tab' => 'Taxonomy[22]',
					'IdeSubspeciesLocal_tab' => 'Taxonomy[23]',
					'BioSiteCountryLocal' => 'Continent[2]',
					'BioSiteStateLocal' => 'Continent[3]',
					'BioSiteCountyLocal' => 'Continent[4]',
				
					);

		$this->LookupRestrictions = array (
					'Taxonomy' => "(Value050='Mammalia')",
					);

			    $this->BaseDetailedQueryForm();
		    }

} 

?>
