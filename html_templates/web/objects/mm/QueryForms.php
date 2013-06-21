<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
MmBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
				'taxonomy' => 'TaxTaxonomyLocal|IdeTypeStatus_tab',
				'notes' => 'NotNotes',
				'place' => 'SitSiteLocal_tab',
				);

}  // end MmBasicQueryForm class

class
MmAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
				'taxonomy' => 'TaxTaxonomyLocal|IdeTypeStatus_tab',
				'notes' => 'NotNotes',
				'place' => 'SitSiteLocal_tab',
				);

}  // end MmAdvancedQueryForm class
	

class
MmDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	MmDetailedQueryForm()
	{
		$dateCollectedFrom = new QueryField;
		$dateCollectedFrom->ColName = 'LocDateCollectedFrom';
		$dateCollectedFrom->ColType = 'date';

		$identificationDate = new QueryField;
		$identificationDate->ColName = 'IdeDateIdentified0';
		$identificationDate->ColType = 'date';

		$acqDetails = new QueryField;
		$acqDetails->ColName = 'ColProvenanceRef_tab->eparties->SummaryData|AccAccessionLotLocal';


		$this->Fields = array(	
				'ColCollectionName_tab',
				'TaxTaxonomyRef_tab->etaxonomy->ClaFamily',
				'TaxTaxonomyRef_tab->etaxonomy->ClaGenus',
				'TaxTaxonomyRef_tab->etaxonomy->ClaSpecies',
				'TaxTaxonomyRef_tab->etaxonomy->ClaSubspecies',
				'TaxTaxonomyRef_tab->etaxonomy->ClaOtherRank_tab',
				'TaxTaxonomyRef_tab->etaxonomy->ClaOtherValue_tab',
				'TaxTaxonomyRef_tab->etaxonomy->AutCombAuthorsLocal_tab',
				'TaxTaxonomyRef_tab->etaxonomy->AutBasionymAuthorsLocal_tab',
				'TaxTaxonomyLocal',
				'SpeAttributes_tab',
				'IdeTypeStatus_tab',
				'SitSiteRef_tab->esites->SummaryData',
				'LocCollectorsRef_tab->eparties->SummaryData',
				$dateCollectedFrom,
				'IdeIdentifiedByRef_tab->eparties->SummaryData',
				$identificationDate,
				$acqDetails,
				);

		$this->Hints = array(
				'ColCollectionName_tab' => '[ e.g. British Flowering Plants ]',
				'TaxTaxonomyRef_tab->etaxonomy->ClaFamily' => '[ e.g. Rosaceae ]',
				'TaxTaxonomyRef_tab->etaxonomy->ClaGenus' => '[ e.g. Rubus ]',
				'TaxTaxonomyRef_tab->etaxonomy->ClaSpecies' => '[ e.g. lentiginosus ]',
				'TaxTaxonomyRef_tab->etaxonomy->ClaSubspecies' => '[ e.g. subsp. juncea ]',
				'TaxTaxonomyRef_tab->etaxonomy->ClaOtherRank_tab' => '[ e.g. var. ]',
				'TaxTaxonomyRef_tab->etaxonomy->ClaOtherValue_tab' => '[ e.g. vulgaris ]',
				'TaxTaxonomyRef_tab->etaxonomy->AutCombAuthorsLocal_tab' => '[ e.g. Watson ]',
				'TaxTaxonomyRef_tab->etaxonomy->AutBasionymAuthorsLocal_tab' => '[ e.g. Reuter ]',
				'TaxTaxonomyLocal' => '[ e.g. Rubus fissus Lindley 1835 ]',
				'SpeAttributes_tab' => '[ e.g. fruit ]',
				'IdeTypeStatus_tab' => '[ e.g. Holotype ]',
				'SitSiteRef_tab->esites->SummaryData' => '[ e.g. England, Cheshire, VC58, Macclesfield ]',
				'LocCollectorsRef_tab->eparties->SummaryData' => '[ e.g. Augustin Ley ]',
				'IdeIdentifiedByRef_tab->eparties->SummaryData' => '[ e.g. Alan Newton ]',
				'LocDateCollectedFrom'  => '[ dd/mm/yyyy ]',
				'IdeDateIdentified0' => '[ dd/mm/yyyy ]',
				'ColProvenanceRef_tab->eparties->SummaryData|AccAccessionLotLocal' => '[ e.g. Charles Bailey ]',
				);

		$this->DropDownLists = array(	
						'CreCountry_tab' => 'eluts:Location',
						'IdeTypeStatus_tab' => 'eluts:Type Status',
					);

		$this->LookupLists = array (
					'TaxTaxonomyRef_tab->etaxonomy->ClaFamily' => 'Taxonomy[12]',
					'TaxTaxonomyRef_tab->etaxonomy->ClaGenus' => 'Taxonomy[17]',
					'TaxTaxonomyRef_tab->etaxonomy->ClaSpecies' => 'Taxonomy[19]',
					'TaxTaxonomyRef_tab->etaxonomy->ClaSubspecies' => 'Taxonomy[20]',
					'SitSiteRef_tab->esites->LocCountry_tab' => 'Site Locality[3]',
					'SitSiteRef_tab->esites->LocProvinceStateTerritory_tab' => 'Site Locality[4]',
					'SitSiteRef_tab->esites->LocDistrictCountyShire_tab' => 'Site Locality[5]',
					'SitSiteRef_tab->esites->LocTownship_tab' => 'Site Locality[6]',
					'ColCollectionName_tab' => 'Collection Name',
					'SpeAttributes_tab' => 'Specimen Attributes',
					);

		$this->BaseDetailedQueryForm();
	}

} // End MmDetailedQueryForm class
?>
