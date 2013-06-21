<?php

/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd

Martin Jujou
23/10/2003

*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');
#require_once ($LIB_DIR . 'BaseQueryForm.php');


// basic query form
// grant smith added some base code to get this working
class
MhsoxBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array
	(	
		//'any' => 'SummaryData|TitInventoryNo|TitMainTitle|CreDateCreated|CrePrimaryInscriptions|CreProvenance|TitCollectionGroup_tab|PhyMaterial_tab|CreBriedDescrption|TitAccessionNo|TitPreviousAccessionNo_tab|PhyPartPart|PhyPartAspect_tab|PhyPartDescription0',
		'any' => 'SummaryData|TitMainTitle|CreDateCreated|CrePrimaryInscriptions|CreProvenance|TitCollectionGroup_tab|PhyMaterial_tab|CreBriefDescription|TitAccessionNo|TitPreviousAccessionNo_tab|PhyPartPart_tab',
	);
}  


// advanced query form
class
MhsoxAdvancedQueryForm extends BaseAdvancedQueryForm
{
	
	var $Options = array
	(	
		#'any' => 'SummaryData|TitMainTitle|CreDateCreated|CrePrimaryInscriptions|CreProvenance|TitCollectionGroup_tab|PhyMaterial_tab|CreBriefDescription|TitAccessionNo|TitPreviousAccessionNo_tab|PhyPartPart_tab|PhyPartAspect_tab|PhyPartDescription0',
		#'any' => 'SummaryData|TitMainTitle|CreDateCreated|CrePrimaryInscriptions|CreProvenance|TitCollectionGroup_tab|PhyMaterial_tab|CreBriefDescription|TitAccessionNo',	
		'Anywhere' => 'SummaryData',
		'Title' => 'TitMainTitle|TitSeriesTitle|TitCollectionTitle',
		'Artist/Maker' => 'CreCreatorLocal_tab'
	);

}
	
// detailed query form 
class
MhsoxDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	MhsoxDetailedQueryForm()
	{
	
		$invno = new QueryField;
	
		$invno->ColName = 'TitInventoryNo';
		$invno->ColType = 'integer';
		$this->Fields = array
		(
				$invno,
				'TitAccessionNo',
				'TitPreviousAccessionNo_tab',
				'TitMainTitle',
				'CreDateCreated',
				'CrePrimaryInscriptions',
				'CreProvenance',
				'PhyMaterial_tab',
				'CreBriefDescription',
				//ocMuseum',
				//'TitObjectName',
				//'TitCollectionTitle',
				//'CreBriefDescription',
				'CreCreatorRef_tab->eparties->SummaryData',
				//'TitaccessionNo|TitPreviousAccessionNo_tab', // Also search TitPreviousAccessionNo_tab?
				//'SumRegistrationNumber',
				//'DesDescription',
				//'ProProductionNotes',
				//'HisHistoryNotes',
				//'SigStatement',
				//'ArcAdministrativeHistory'
		);
		$Hints = array(	
				'TitInventoryNo'	=> '[ eg. 10004 ]',
				'TitAccessionNo'	=> '[ eg. 10004 ]',
				'CreBriefDescription'	=> '[ eg. spear shaped ]',
				'ProProductionNotes'	=> '[ eg. this was made .. ]',
				'HisHistoryNotes'	=> '[ eg. used to be used for .. ]',
				'SigStatement'		=> '[ eg. important because .. ]',  
				'ArcAdministrativeHistory'	=> '[ eg. added on the .. ]'
		);
		$DropDownLists = array
		(
					//'CreProvenance' 		=> 'eluts:Provence',
					//'TitMainTitle' 	=> 'eluts:Main Title',
					'TitCollectionTitle' 	=> 'eluts:Collection Title',
		);
		$this->BaseDetailedQueryForm();
	}
} 
?>
