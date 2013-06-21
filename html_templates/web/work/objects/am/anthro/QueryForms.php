<?php

/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/*
Created By: Martin Jujou
Date: 23/9/2003
Last Modified: 26/9/2003
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

// search by title, narrative, summary and keywords
class
AmBasicNarrativeQueryForm extends BaseBasicQueryForm
{
	var $Options = array(	
			'any' => 'SummaryData|NarNarrative|NarTitle|DesSubjects_tab'
			);
} 


// search by title, label, summary, keywords and description
class
AmBasicObjectQueryForm extends BaseBasicQueryForm
{
	var $Options = array(	
			'any' => 'SummaryData|SumItemName|ObjDescription|ObjLabel|ObjKeywords_tab'
			);
} 

 // search by summary, title, firstname, lastname, middlename, and label
class
AmBasicPartyQueryForm extends BaseBasicQueryForm
{
	var $Options = array(	

	'any' => 'SummaryData|NamTitle|NamFirst|NamMiddle|NamLast|BioLabel'

	);
} 

// search all by summary data
class
AmBasicQueryForm extends BaseBasicQueryForm
{
        var $Options = array(   

	'any' => 'enarratives:SummaryData|NarNarrative|NarTitle|DesSubjects_tab;ecatalogue:SummaryData|SumItemName|ObjDescription|ObjLabel|ObjKeywords_tab;eparties:SummaryData|NamTitle|NamFirst|NamMiddle|NamLast|BioLabel'

	);

}

// advanced object and place search
class
AmAdvancedQueryFormOne extends BaseAdvancedQueryForm
{
	var $Options = array(

			'item'		=> 'SumItemName',
			'desc'		=> 'ObjDescription',
			'key'		=> 'ObjKeywords_tab',
			'coun'		=> 'ProCountry_tab',
			'area'		=> 'ProCollectionArea',
			'areagroup'	=> 'ProAreaGroup',
			'region'	=> 'ProRegion',
			'pplace'	=> 'ProPlace',
			//'cate'		=> 'SumCategory',
			'site'		=> 'SumArchSiteName'
			//'aquired'	=> 'AcqHowAcquired'
		);

}

// advanced object and people/culture search
class
AmAdvancedQueryFormTwo extends BaseAdvancedQueryForm
{
	
	var $Options = array(

			'item'		=> 'SumItemName',
			'desc'		=> 'ObjDescription',
			'key'		=> 'ObjKeywords_tab',
			//'aquired'	=> 'AcqHowAcquired',

			// Hmm I dont know how to query reference to parties  
			'cult'		=> 'ObjCulturalAssocRef_tab->eparties->SummaryData',
			'nameofsource'	=> 'AcqNameSourceRef_tab->eparties->SummaryData',
			'historyname'	=> 'AcqNameRef_tab->eparties->SummaryData'
		);

}

// advanced people/culture and place search
class
AmAdvancedQueryFormThree extends BaseAdvancedQueryForm
{
	var $Options = array(

			'coun'		=> 'ProCountry_tab',
			'area'		=> 'ProCollectionArea',
			'areagroup'	=> 'ProAreaGroup',
			'region'	=> 'ProRegion',
			'pplace'	=> 'ProPlace',
			'site'		=> 'SumArchSiteName',

			// Hmm I dont know how to query reference to parties  
			'cult'		=> 'ObjCulturalAssocRef_tab->eparties->SummaryData',
			'nameofsource'	=> 'AcqNameSourceRef_tab->eparties->SummaryData',
			'historyname'	=> 'AcqNameRef_tab->eparties->SummaryData'
		);
}


// detailed object and place search
class
AmDetailedQueryFormOne extends BaseDetailedQueryForm
{
	var $Fields = array(
				'SumItemName',
				'ObjDescription',
				'ObjKeywords_tab',
				'ProCountry_tab',
				'ProCollectionArea',
				'ProAreaGroup',
				'ProRegion',
				'ProPlace',
				'SumArchSiteName'
			);


	var $Hints = array(
				'SumItemName'	=> '[ eg. Boomerang ]',
				'ObjDescription'	=> '[ eg. Wooden material with a banana shape ]',
				'ProCollectionArea'	=> '[ eg. Sydney ]',
				'ObjKeywords_tab'	=> '[ eg. Art ]',
				'ProCountry_tab'	=> '[ eg. Australia ]',
				'ProAreaGroup'		=> '[ eg. Illawarra ]',
				'ProRegion'	=> '[ eg. NSW ]',
				'ProPlace'	=> '[ eg. Banksia ]',
				'SumArchSiteName'	=> '[ eg. Tibet ]',

			);
} 

// detailed object and people/culture search 
class
AmDetailedQueryFormTwo extends BaseDetailedQueryForm
{

	var $Fields = array(
				'SumItemName',
				'ObjDescription',
				'ObjKeywords_tab',
				'ObjCulturalAssocRef_tab->eparties->SummaryData',
				'AcqNameSourceRef_tab->eparties->SummaryData',
				'AcqNameRef_tab->eparties->SummaryData'
			);

	var $Hints = array(
				'SumItemName'	=> '[ eg. Boomerang ]',
				'ObjDescription'	=> '[ eg. Wooden material with a banana shape ]',
				'ObjKeywords_tab'	=> '[ eg. Art ]',
				'ObjCulturalAssocRef_tab->eparties->SummaryData'	=> '[ eg. Mark ]',
				'AcqNameSourceRef_tab->eparties->SummaryData'	=> '[ eg. Chris ]',
				'AcqNameRef_tab->eparties->SummaryData'		=> '[ eg. Lisa ]'


			);
} 


// detailed people/culture and place search
class
AmDetailedQueryFormThree extends BaseDetailedQueryForm
{

	var $Fields = array(
				'ProCountry_tab',
				'ProCollectionArea',
				'ProAreaGroup',
				'ProRegion',
				'ProPlace',
				'SumArchSiteName',
				'ObjCulturalAssocRef_tab->eparties->SummaryData',
				'AcqNameSourceRef_tab->eparties->SummaryData',
				'AcqNameRef_tab->eparties->SummaryData'
			);

	var $Hints = array(

				'ProCollectionArea'	=> '[ eg. Sydney ]',
				'ProCountry_tab'	=> '[ eg. Australia ]',
				'ProAreaGroup'		=> '[ eg. Illawarra ]',
				'ProRegion'	=> '[ eg. NSW ]',
				'ProPlace'	=> '[ eg. Banksia ]',
				'SumArchSiteName'	=> '[ eg. Tibet ]',
				'ObjCulturalAssocRef_tab->eparties->SummaryData'	=> '[ eg. Mark ]',
				'AcqNameSourceRef_tab->eparties->SummaryData'	=> '[ eg. Chris ]',
				'AcqNameRef_tab->eparties->SummaryData'		=> '[ eg. Lisa ]'
			);
} 

// search all terms 
class
AmDetailedQueryFormFour extends BaseDetailedQueryForm
{

	var $Fields = array(
				'SumItemName',
				'ObjDescription',
				'ObjKeywords_tab',

				'ProCountry_tab',
				'ProCollectionArea',
				'ProAreaGroup',
				'ProRegion',
				'ProPlace',
				'SumArchSiteName',
				'ObjCulturalAssocRef_tab->eparties->SummaryData',
				'AcqNameSourceRef_tab->eparties->SummaryData',
				'AcqNameRef_tab->eparties->SummaryData'
			);

	var $Hints = array(

				'SumItemName'   => '[ eg. Boomerang ]',
				'ObjDescription'        => '[ eg. Wooden material with a banana shape ]',
				'ObjKeywords_tab'       => '[ eg. Art ]',

				'ProCollectionArea'	=> '[ eg. Sydney ]',
				'ProCountry_tab'	=> '[ eg. Australia ]',
				'ProAreaGroup'		=> '[ eg. Illawarra ]',
				'ProRegion'	=> '[ eg. NSW ]',
				'ProPlace'	=> '[ eg. Banksia ]',
				'SumArchSiteName'	=> '[ eg. Tibet ]',
				'ObjCulturalAssocRef_tab->eparties->SummaryData'	=> '[ eg. Mark ]',
				'AcqNameSourceRef_tab->eparties->SummaryData'	=> '[ eg. Chris ]',
				'AcqNameRef_tab->eparties->SummaryData'		=> '[ eg. Lisa ]'
			);

} 


?>
