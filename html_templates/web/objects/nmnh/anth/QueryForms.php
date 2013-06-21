<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

class
NmnhAnthBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Anthropology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata',
		'name' 		=> 'IdeObjectName_tab|IdeIndexTerm_tab',
		'place' 	=> 'BioContinentLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioTownshipLocal|BioSiteNameLocal|BioSiteNumberLocal',
		'person' 	=> 'BioParticipantLocal_tab|AccTransactorLocal_tab',
		'number' 	=> 'CatNumber=integer',
	);
} 
//=====================================================================================================
//=====================================================================================================
class
NmnhAnthAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Anthropology'";

	var $Options = array
	(		
		'any' 			=> 'SummaryData|AdmWebMetadata',
		'QUERY_OPTION_NAME' 	=> 'IdeObjectName_tab|IdeIndexTerm_tab',
		'place' 		=> 'BioContinentLocal|BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioTownshipLocal|BioSiteNameLocal|BioSiteNumberLocal',
		'person' 		=> 'BioParticipantLocal_tab|AccTransactorLocal_tab',
		'number' 		=> 'CatNumber',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhAnthDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatMuseumAcronym = 'USNM' AND CatDepartment = 'Anthropology'";

	function
	NmnhAnthDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColType = 'integer';
		$catNumber->ColName = 'CatNumber';

		$this->Fields = array
		(	
			'CatBarcode',
			$catNumber,
			'CatDivision',
			'CatCatalog',
			'IdeClassIndex_tab|IdeIndexTerm_tab|IdeSubType_tab|IdeVariety_tab|IdeTerm_tab|IdeObjectName_tab',
			'CulCulture2Local_tab|CulCulture3Local_tab|CulCulture4Local_tab|CulCulture5Local_tab',
			'BioContinentLocal|BioCountryLocal|BioProvinceStateLocal|BioDistrictCountyShireLocal|BioTownshipLocal|BioSiteNameLocal|BioSiteNumberLocal',
			'BioContinentLocal',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioTownshipLocal',
			'BioSiteNameLocal',
			'BioSiteNumberLocal',
			'CatOtherNumbersValue_tab',
			'BioParticipantLocal_tab',
			'BioVerbatimDateLocal',
			'AccTransactorLocal_tab',
			'AccAccessionLotNumber',
			'AccAccessionDateOwnership',
			'DesMaterial_tab',
		);

		$this->Hints = array
		(	
			'CatNumber'							=> '[numbers only, e.g. 1396, 10155]',
			'CatBarcode' 							=> '[include letters, e.g. A1396, EJ10155-0]',
			'CatDivision' 							=> '[Select from list: Archaeology or Ethnology]',
			'CatCatalog' 							=> '[Select from list]',
			'IdeClassIndex_tab|IdeIndexTerm_tab|IdeSubType_tab|IdeVariety_tab|IdeTerm_tab|IdeObjectName_tab' 	=> '[e.g. Atlatl, Hat, Canoe, Bowl]',
			'ArcObjectDate_tab' 						=> '[format dd-mm-yyyy, partial entry works]',
			'CulCulture2Local_tab|CulCulture3Local_tab|CulCulture4Local_tab|CulCulture5Local_tab' 	=> '[e.g. Olmec, Kiowa]',
			'BioContinentLocal|BioCountryLocal|BioProvinceStateLocal|BioDistrictCountyShireLocal|BioTownshipLocal|BioSiteNameLocal|BioSiteNumberLocal' 										    => '[Search all geographic fields below, e.g. Ungava Bay, Tahiti]',
			'BioContinentLocal' 						=> '[e.g. Polynesia, Africa]',
			'BioCountryLocal' 						=> '[Select from list, e.g. Egypt, Panama]',
			'BioProvinceStateLocal' 					=> '[e.g. Wisconsin, Quebec, Yucatan]',
			'BioDistrictCountyShireLocal' 					=> '[e.g. Collier, Montgomery]',
			'BioTownshipLocal' 						=> '[e.g. Beijing, Point Barrow]',
			'BioSiteNameLocal' 						=> '[e.g. Pueblo Bonito, Signal Butte]',
			'BioSiteNumberLocal' 						=> '[e.g. 22UN500, 25SF1]',
			'CatOtherNumbersType_tab' 					=> '[Select from list]',
			'CatOtherNumbersValue_tab' 					=> '[Field or photo negative number, e.g. 78-15832]',
			'BioParticipantLocal_tab' 					=> '[e.g. Sanborn or River Basin Survey. For best results avoid quotes]',
			'BioVerbatimDateLocal' 						=> '[e.g. 1966]',
			'AccTransactorLocal_tab'					=> '[e.g. Bureau of American Ethnology or Edward Palmer. For best results avoid quotes]',
			'AccAccessionLotNumber' 					=> '[e.g. 8451286 or 67A00050]',
			'AccAccessionDateOwnership' 					=> '[e.g. 1867]',
			'DesMaterial_tab' 						=> '[Select from list]',
		);

		$this->DropDownLists = array
		(	
			'CatDivision' 			=> '|Archaeology|Ethnology', 
			'CatCatalog' 			=> '|Archaeobiology', 
			'BioCountryLocal' 		=> 'eluts:Continent[2]', 
			'DesMaterial_tab' 		=> '|ceramic|stone|basketry|fibers', 
			'BioContinentLocal' 		=> '|Africa|Asia|Australia|Caribbean|Central America|Europe|Melanesia|Micronesia|North America|Oceania|Polynesia|South America', 
			'BioCountryLocal' 		=> '|Afghanistan|Algeria|Angola|Antigua|Argentina|Armenia|Aruba|Australia|Austria|Azerbaijan|Bahamas|Bangladesh|Barbados|Barbuda|Belgium|Belize|Benin|Bermuda|Bhutan|Bolivia|Botswana|Brazil|British Virgin Islands|Bulgaria|Burkina Faso|Burma|Burundi|Cambodia|Cameroon|Canada|Cape Verde|Cayman Islands|Central|Central African Republic|Chad|Chile|China|Colombia|Comoros|Cook Islands|Costa Rica|Côte d\'Ivoire|Cuba|Cyprus|Czechoslovakia|Democratic Republic of the Congo|Denmark|Dominica|Dominican Republic|Ecuador|Egypt|El Salvador|Equatorial Guinea|Eritrea|Ethiopia|Federated States of Micronesia|Fiji|Finland|France|French Guiana|Gabon|Gambia|Georgia|Germany|Ghana|Greece|Greenland|Grenada|Guatemala|Guinea|Guinea-Bissau|Guyana|Haiti|Honduras|Hungary|Iceland|India|Indonesia|Iran|Iraq|Ireland|Israel|Italy|Jamaica|Japan|Jordan|Kazakstan|Kenya|Kiribati|Korea|Kuwait|Laos|Lebanon|Lesotho|Liberia|Libya|Lithuania|Madagascar|Malawi|Malaysia|Mali|Marshall Islands|Martinique|Mauritania|Mauritius|Mexico|Mongolia|Morocco|Mozambique|Namibia|Nepal|Netherlands|Netherlands Antilles|New Zealand|Nicaragua|Niger|Nigeria|Niue|North Korea|Norway|Oman|Pakistan|Palau|Palestine|Panama|Papua New Guinea|Paraguay|Peru|Philippines|Poland|Portugal|Republic of the Congo|Romania|Russia|Rwanda|Samoa|Sao Tome And Principe|Saudi Arabia|Senegal|Seychelles|Sierra Leone|Singapore|Solomon Islands|Somalia|South Africa|South Korea|Spain|Sri Lanka|St. Kitts|St. Lucia|St. Vincent|Sudan|Suriname|Swaziland|Sweden|Switzerland|Syria|Taiwan|Tanzania|Thailand|Tibet|Togo|Tonga|Trinidad and Tobago|Tunisia|Turkey|Tuvalu|Uganda|Ukraine|United Kingdom|United States|Uruguay|Uzbekistan|Vanuatu|Venezuela|Vietnam|Yemen|Zambia|Zimbabwe', 
			'CatOtherNumbersType_tab' 	=> '|black/white|color digital|color negative|color transparency|negative number|slide number|field number', 
		);

		$this->LookupLists = array
		(
		);
	}
}
//=====================================================================================================
//=====================================================================================================
?>

