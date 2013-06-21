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


// basic query form
// grant smith added some base code to get this working
class
CatalogueQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	
'any' => 'ecatalogue:SumRegistrationNumber|DesDescription|ProProductionNotes|HisHistoryNotes|SigStatement|ArcAdministrativeHistory;eaccessionlots:LotLotNumber|LotDescription;ethesaurus:TerTerm|BioText'
//'any' => 'ecatalogue:SumRegistrationNumber|DesDescription;eaccessionlots:LotLotNumber'
//'any' => 'ecatalogue:SummaryData;'

			);
}  


// advanced query form
class
PhmAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	
		'any' => 'SummaryData|AdmWebMetadata',

	);

}
	
// detailed query form 
class
PhmDetailedQueryForm extends BaseDetailedQueryForm
{

	var $Fields = array(	
				'SumRegistrationNumber',
				'DesDescription',
				'ProProductionNotes',
				'HisHistoryNotes',
				'SigStatement',
				'ArcAdministrativeHistory'

				);

	var $Hints = array(	

				'SumRegistrationNumber'	=> '[ eg. 10004 ]',
				'DesDescription'	=> '[ eg. spear shaped ]',
				'ProProductionNotes'	=> '[ eg. this was made .. ]',
				'HisHistoryNotes'	=> '[ eg. used to be used for .. ]',
				'SigStatement'		=> '[ eg. important because .. ]',  
				'ArcAdministrativeHistory'	=> '[ eg. added on the .. ]'



				);


} 



?>
