<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(dirname(realpath(__FILE__))))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ('DefaultPaths.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
TePapaBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any'	=> 	'SummaryData|IntClaPhylum|IntClaClass|IntClaOrder|IntClaFamily|IdeScientificNameLocal_tab|IntIdeTypeStatus|IntComName_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				'tax'	=>	'IntClaPhylum|IntClaClass|IntClaOrder|IntClaFamily|IdeScientificNameLocal_tab|IntIdeTypeStatus|IntComName_tab',

				'peo'	=>	'ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				);

}  // end TePapaBasicQueryForm class

class
TePapaAdvancedQueryForm extends BaseAdvancedQueryForm
{


	var $Options = array(	'any'	=> 	'SummaryData|IntClaPhylum|IntClaClass|IntClaOrder|IntClaFamily|IdeScientificNameLocal_tab|IntIdeTypeStatus|IntComName_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				'tax'	=>	'IntClaPhylum|IntClaClass|IntClaOrder|ClaFamily|IdeScientificNameLocal_tab|IntIdeTypeStatus|ComName_tab',

				'peo'	=>	'ColCollectionEventRef->ecollectionevents->ColParticipantLocal_tab|IdeIdentifiedByRef_tab->eparties->SummaryData',
				);

}  // end TePapaAdvancedQueryForm class
	

class
TePapaDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	TePapaDetailedQueryForm()
	{
		$ideDate = new QueryField;
		$ideDate->ColName = 'IdeDateIdentified0';
		$ideDate->ColType = 'date';

		$this->Fields = array(	
					'ColCollectionType',
					'RegRegistrationNumberString',
					'IntClaPhylum',
					'IntClaClass',
					'IntClaOrder',
					'ClaFamily',
					'IdeScientificNameLocal_tab',
					'IntIdeTypeStatus',
					'IdeIdentifiedByRef_tab->eparties->SummaryData',
					$ideDate,
					'ComName_tab',
					);

		$this->Hints = array(	
					'ColCollectionType'		=> '[Select from list]',
					'IntClaPhylum'			=> '[e.g. Pteridophyta, Chordata]',
					'IntClaClass'			=> '[e.g. Pteridophyta, Aves]',
					'IntClaOrder'			=> '[e.g. , Psittaciformes]',
					'ClaFamily'		    	=> '[e.g. Cyatheaceae, Psittacidae]',
					'IdeScientificNameLocal_tab'	=> '[e.g. Cyathea dealbata, Nestor meridionalis]',
					'IntIdeTypeStatus'		=> '[Select from list]',
					'IdeDateIdentified0'		=> '[day/month/year, 1975 note: not all specimens have dates]',
					'ComName_tab'			=> '[e.g. Silver fern, punga, k&#228;k&#228;]',
					);
					
		$this->DropDownLists = array(	
					'ColCollectionType'		=> 'eluts:Administration Category[3]',
					'IntClaPhylum'			=> 'eluts:Int Catalogue Taxonomy[1]',
					'IntClaClass'			=> 'eluts:Int Catalogue Taxonomy[2]',
					'IntClaOrder'			=> 'eluts:Int Catalogue Taxonomy[3]',
					'IntIdeTypeStatus'		=> 'eluts:Int Type Status',
					);
		
		$this->LookupLists = array(	
					'ClaFamily'			=> 'Catalogue Taxonomy[4]',
					'ComName_tab'			=> 'Catalogue Common Name',
					);
		$this->LookupRestrictions = array (
					'Administration Category' => "(Value010='Collection')", 
					);
	}

} // End TePapaDetailedQueryForm class
?>
