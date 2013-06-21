<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
DpiqBasicQueryForm extends BaseBasicQueryForm
{
	//var $Restriction = "TaxAccNo1 = 'BRIP' And LocState = 'QLD' or LocState = 'Qld' or LocState = 'qld'";
	var $Restriction = "TaxAccNo1 = 'BRIP'";

        var $Options = array(           'any' => 'SummaryData|TaxDuplicates_tab|ExtendedData|TaxCollection_tab|SpeSpecimenType_tab|SpeAdditionalComments|NotNotes|ColPrimaryCollectorLocal|ColDeterminerLocal_tab|LocPlace|LocCountry|LocState|LocPreciseLocation|LocLocalGovernmentRegion|WebName|WebHostSubstrate|HosCommonName|TaxIdentificationQualifier',
                                        'taxonomy' => 'WebName|WebHostSubstrate|HosCommonName|TaxIdentificationQualifier',
                                        'place' => 'LocPlace|LocCountry|LocState|LocPreciseLocation|LocLocalGovernmentRegion',
                                        'person' => 'ColPrimaryCollectorLocal|ColDeterminerLocal_tab',
                                        );

}  // end NmnhBasicQueryForm class

class
DpiqAdvancedQueryForm extends BaseAdvancedQueryForm
{
	//var $Restriction = "TaxAccNo1 = 'BRIP' And LocState = 'QLD' or LocState = 'Qld' or LocState = 'qld'";
	var $Restriction = "TaxAccNo1 = 'BRIP'";
        var $Options = array(           'any' => 'SummaryData|TaxDuplicates_tab|ExtendedData|TaxCollection_tab|SpeSpecimenType_tab|SpeAdditionalComments|NotNotes|ColPrimaryCollectorLocal|ColDeterminerLocal_tab|LocPlace|LocCountry|LocState|LocPreciseLocation|LocLocalGovernmentRegion|WebName|WebHostSubstrate|HosCommonName|TaxIdentificationQualifier',
                                        'taxonomy' => 'WebName|WebHostSubstrate|HosCommonName|TaxIdentificationQualifier',
                                        'place' => 'LocPlace|LocCountry|LocState|LocPreciseLocation|LocLocalGovernmentRegion',
                                        'person' => 'ColPrimaryCollectorLocal|ColDeterminerLocal_tab',
                                        );

}  // end NmnhAdvancedQueryForm class


class
DpiqDetailedQueryForm extends BaseDetailedQueryForm
{
	//var $Restriction = "TaxAccNo1 = 'BRIP' And LocState = 'QLD' or LocState = 'Qld' or LocState = 'qld'";
	var $Restriction = "TaxAccNo1 = 'BRIP'";
        function
        DpiqDetailedQueryForm()
        {
                $taxaccno1 = new QueryField;
                $taxaccno1->ColName = 'TaxAccNo2';
                $taxaccno1->ColType = 'integer';

                $colldate = new QueryField;
                $colldate->ColName = 'ColCollectionDate';
                $colldate->ColType = 'date';

                //$speciminCount = new QueryField;
                //$speciminCount->ColType = 'integer';
                //$speciminCount->ColName = 'CatSpecimenCount';

                //$sitSiteNumber = new QueryField;
                //$sitSiteNumber->ColName = 'BioSiteNumberLocal';
                //$sitSiteNumber->ColType = 'integer';

                //$expStartDate = new QueryField;
                //$expStartDate->ColName = 'ExpStartDate';
                //$expStartDate->ColType = 'date';

                //$minWeight = new QueryField;
                //$minWeight->ColName = 'MinWeight';
                //$minWeight->ColType = 'integer';

                $this->Fields = array(
                                $taxaccno1,
				//'TaxAccNo3',
				'TaxOrgType',
				'TaxDivision',
				'TaxOrder',
				'TaxGenus',
				//'TaxGenus|TaxSpecies|TaxInfrasp',
				'HosHostFamily',
				'HosHostGenus|HosHostSpecies|HosHostInfrasp',
				'HosCommonName|HosHostInfrasp',
				'HosSymptom_tab',
				'ColPrimaryCollectorLocal',
				$colldate,
				'SpeLivingCulture',
				'LocPreciseLocation|LocPlace',
                                );

                $this->BaseDetailedQueryForm();


                $this->Hints = array(
                                'TaxAccNo2'         => '[ Defaults to BRIP -- enter a number e.g., 26216 ]',
				'TaxAccNo3'        => '[ e.g., a ]',
				'TaxOrgType'        => '[ Select from list ]',
				'TaxDivision'        => '[ e.g., Basidiomycotina ]',
				'TaxOrder'        => '[ e.g., Polyporales ]',
				'TaxGenus|TaxSpecies|TaxInfrasp'        => '[ e.g., eucalypti ]',
				'TaxGenus'        => '[ e.g., Aulographina eucalypti ]',
				'HosHostFamily'        => '[ e.g., Ericaceae ]',
				'HosHostGenus|HosHostSpecies|HosHostInfrasp'        => '[ e.g., Eucalyptus ]',
				'HosCommonName|HosHostInfrasp'        => '[ e.g., Peanut ]',
				'HosSymptom_tab'        => '[ e.g., Rust ]',
				'ColPrimaryCollectorLocal'        => '[ e.g., D Smith ]',
				'ColCollectionDate'        => '[ e.g., 19 Dec 2000 or 19/12/2002 ]',
				'SpeLivingCulture'        => '[ Select from list ]',
				'LocPreciseLocation|LocPlace'        => '[ QLD only e.g., Gadgarra Forest ]',
                                );

                $this->DropDownLists = array(
                                'SpeLivingCulture' => '|Yes|No',
                                //'SpeLivingCulture' => 'eluts:Living Culture Status',
                                'TaxOrgType' => '|Bacterium|Fungus|Virus',
                                );

                $this->LookupLists = array(
                        //'CatCollectionName_tab' => 'Collection Name[5]',
                        //'BioExpeditionNameLocal' => 'Expedition Name',
                        //'ColCollectionMethod' => 'Collection Method',
                        //'BioVesselNameLocal' => 'Vessel Name',
                        //'BioRiverBasinLocal' => 'River Basin',
                        );

        }
} // End NmnhDetailedQueryForm class
?>

