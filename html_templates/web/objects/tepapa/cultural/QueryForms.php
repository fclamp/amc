<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');
require_once ('DefaultPaths.php');

class
TePapaBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any'	=> 	'SummaryData|ClaMainTitle|WebClaObjectName_tab|ProProductionMakerLocal|WebProProdPlace_tab|ProProductionDate_tab|DesWebSummary|SubSubjects_tab|AssHistoricalEvent_tab|AssPeriodStyle_tab|AssConcept_tab|AssAssociationDate_tab|AssAssociationNameRef_tab->eparties->SummaryData|AssAssociationCountry_tab|WebProCulturalGroup_tab',
				'cla'	=> 	'ClaMainTitle|WebClaObjectName_tab',
				'pro'	=> 	'ProProductionMakerLocal|WebProProdPlace_tab|ProProductionDate_tab',
				'web'	=> 	'DesWebSummary',
				'ass'	=> 	'SubSubjects_tab|AssHistoricalEvent_tab|AssPeriodStyle_tab|AssConcept_tab|AssAssociationDate_tab|AssAssociationNameRef_tab->eparties->SummaryData|AssAssociationCountry_tab|WebProCulturalGroup_tab',
				);

}  // end TePapaBasicQueryForm class

class
TePapaAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any'	=> 	'SummaryData|ClaMainTitle|WebClaObjectName_tab|ProProductionMakerLocal|WebProProdPlace_tab|ProProductionDate_tab|DesWebSummary|SubSubjects_tab|AssHistoricalEvent_tab|AssPeriodStyle_tab|AssConcept_tab|AssAssociationDate_tab|AssAssociationNameRef_tab->eparties->SummaryData|AssAssociationCountry_tab|WebProCulturalGroup_tab',
				'cla'	=> 	'ClaMainTitle|WebClaObjectName_tab',
				'pro'	=> 	'ProProductionMakerLocal|WebProProdPlace_tab|WebProProductionDate_tab',
				'web'	=> 	'DesWebSummary',
				'ass'	=> 	'SubSubjects_tab|AssHistoricalEvent_tab|AssPeriodStyle_tab|AssConcept_tab|AssAssociationDate_tab|AssAssociationNameRef_tab->eparties->SummaryData|AssAssociationCountry_tab|WebProCulturalGroup_tab',
				);

}  // end TePapaAdvancedQueryForm class
	

class
TePapaDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	TePapaDetailedQueryForm()
	{
		$proEDate = new QueryField;
		$proEDate->ColName = 'ProEarliestDate0';
		$proEDate->ColType = 'date';

		$proLDate = new QueryField;
		$proLDate->ColName = 'ProLatestDate0';
		$proLDate->ColType = 'date';

		$assEDate = new QueryField;
		$assEDate->ColName = 'AssAssociationEarliestDate0';
		$assEDate->ColType = 'date';

		$assLDate = new QueryField;
		$assLDate->ColName = 'AssAssociationLatestDate0';
		$assLDate->ColType = 'date';

		$this->Fields = array(	
					'ColCollectionType',
					'RegRegistrationNumberString',
					'WebClaObjectName_tab',
					'ClaMainTitle',
					'ProProductionMakerLocal',
					'WebProMakerRole_tab',
					'WebProProdPlace_tab',
					$proEDate,
					$proLDate,
					'WebMatPrimaryMaterials_tab',
					'WebMatTechnique_tab',
					'DesWebSummary',
					'SubSubjects_tab',
					'AssHistoricalEvent_tab',
					'AssPeriodStyle_tab',
					'AssConcept_tab',
					'AssAssociationNameRef_tab->eparties->SummaryData',
					'AssAssociationCountry_tab',
					'WebProCulturalGroup_tab',
					$assEDate,
					$assLDate,
					);

		$this->Hints = array(	
					'ColCollectionType'		=> '[Select from list]',
					'RegRegistrationNumberString'		=> '[our unique number e.g. 1960-0013-1, ME 016630]',
					'ClaMainTitle'			=> '[e.g. waistcoat, chair]',
					'ProProductionMakerLocal'	=> '[e.g. McCahon]',
					'WebProMakerRole_tab'		=> '[e.g. Painter]',
					'WebProProdPlace_tab'		=> '[e.g. Auckland]',
					'ProEarliestDate0'		=> '[day/month/year, 1975 <br>note: not all objects have dates]',
					'ProLatestDate0'		=> '[day/month/year, 1975 <br>note: not all objects have dates]',
					'WebMatPrimaryMaterials_tab'	=> '[e.g. silk, wood, glass]',
					'WebMatTechnique_tab'		=> '[e.g. lithography, carving]',
					'SubSubjects_tab'		=> '[e.g. Christianity]',
					'AssHistoricalEvent_tab'	=> '[e.g. First World War]',
					'AssPeriodStyle_tab'		=> '[e.g. Victorian]',
					'AssConcept_tab'		=> '[e.g. allegory, standing]',
					'AssAssociationNameRef_tab->eparties->SummaryData'	=> '[person or organisation]',
					'AssAssociationCountry_tab'	=> '[e.g. Wellington]',
					'WebProCulturalGroup_tab'		=> '[e.g. Whanganui, Italian]',
					'AssAssociationEarliestDate0'	=> '[day/month/year, 1975 <br>note: not all objects have dates]',
					'AssAssociationLatestDate0'	=> '[day/month/year, 1975 <br>note: not all objects have dates]',
					);
					
		$this->DropDownLists = array(	
					'ColCollectionType'		=> 'eluts:Administration Category[3]',
					'WebProMakerRole_tab'		=> 'eluts:Web Production Maker Role',
					'WebProProdPlace_tab'		=> 'eluts:Web Production Place',
					'WebMatTechnique_tab'		=> 'eluts:Web Technique',
					'SubSubjects_tab'		=> 'eluts:Subjects',
					'AssHistoricalEvent_tab'	=> 'eluts:Historical Event',
				//	'AssPeriodStyle_tab'		=> 'eluts:Period Style',
					'AssConcept_tab'		=> 'eluts:Associated  Concept',
					'WebProCulturalGroup_tab'		=> 'eluts:Web Cultural Group',
					);
		
		$this->LookupLists = array(	
					'WebClaObjectName_tab'		=> 'Web Object Classification',
					'AssAssociationCountry_tab'	=> 'Associated Places',
					'WebMatPrimaryMaterials_tab'	=> 'Web Materials',
					'AssPeriodStyle_tab'		=> 'Period Style',
					);
	}

} // End TePapaDetailedQueryForm class
?>
