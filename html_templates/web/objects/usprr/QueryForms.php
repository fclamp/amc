<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
UsprrBasicQueryForm extends BaseBasicQueryForm
{
	var $Restriction = "MulHasMultiMedia = 'Y'";
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'number' => 'irn|ColAccessionNo|ColIsgnNo|ColRepositoryNo|ColPrimaryFieldNo|ColSecondaryFieldNo|ColMagneticArchiveNo|ColBarcode',
					'notes' => 'NotNotes',
					'source' => 'ColCollectorLocal|ColSourceLocal',
					'place' => 'LtyOceanSea|LtyContinent|LtyCountry|LtyRegion|LtyMountainRangeIslandGroup|LtyMountainNameIslandName|LtyPreciseLocation',
					//'location' => 'elocations:SummaryData',
					);


}  // end UsprrBasicQueryForm class

class
UsprrAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Restriction = "MulHasMultiMedia = 'Y'";
        var $Options = array(   'any' => 'SummaryData|AdmWebMetadata',
                                        'number' => 'irn|ColAccessionNo|ColIsgnNo|ColRepositoryNo|ColPrimaryFieldNo|ColSecondaryFieldNo|ColMagneticArchiveNo|ColBarcode',
                                        'notes' => 'NotNotes',
                                        'source' => 'ColCollectorLocal|ColSourceLocal',
                                        'place' => 'LtyOceanSea|LtyContinent|LtyCountry|LtyRegion|LtyMountainRangeIslandGroup|LtyMountainNameIslandName|LtyPreciseLocation',
                                        //'location' => 'elocations:SummaryData',
                                        );

}  // end UsprrAdvancedQueryForm class
	

class
UsprrDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	'ColIsgnNo',
				'ColPrimaryFieldNo',
				'ColCollectorLocal',
				'ColSourceLocal',
				'ObjKindOfObject',
				'ObjRockType',
				'ObjRockName',
				'ObjMineralsObserved_tab',
				'LtyOceanSea',
				'LtyContinent',
				'LtyCountry',
				'LtyRegion',
				'LtyMountainRangeIslandGroup',
				'LtyMountainNameIslandName',
				'LtyPreciseLocation',
				'AgeGroup_tab',
				'AgeFormation_tab',
				'AgeMember_tab',
				'AgeEra_tab',
				'AgePeriod_tab',
				'AgeEpoch_tab',
				'ObjSurfaceFeatures_tab',
				'FosInformalName_tab',
				'ObjSampleDescription',
				'NotNotes',
				);

	var $Hints = array(	'ColIsgnNo' 		=> '[ eg. IGSN.PRR003515 ]',
				'LtyOceanSea' 		=> '[ Select from the list ]',
				'ObjKindOfObject'		=> '[ Select from the list ]',
				'ObjMineralsObserved_tab'	=> '[ Select from the list ]',
				'AgeGroup_tab'	=> '[ Select from the list ]',
				'AgeFormation_tab' =>	'[ Select from the list ]',
				'AgeMember_tab'	=>	'[ Select from the list ]',
				'ObjSurfaceFeatures_tab' =>	'[ Select from the list ]',
				);

	var $DropDownLists = array(	'ObjKindOfObject' => 'eluts:Object Details',
					'LtyOceanSea'	=> 'eluts:Ocean Sea',
					'ObjMineralsObserved_tab'	=> 'eluts:Minerals Observed',
					'AgeGroup_tab'	=> 'eluts:Age Group',
					'AgeFormation_tab'	=> 'eluts:Age Formation',
					'AgeMember_tab'	=> 'eluts:Age Member',
					'ObjSurfaceFeatures_tab' => 'eluts:Surface Features',
				);

	var $LookupLists = array (
				);

} // End UsprrDetailedQueryForm class
?>
