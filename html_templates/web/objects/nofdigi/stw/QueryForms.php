<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');


class
StwBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					);

}

class
StwAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					);

}
	

class
StwDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	StwDetailedQueryForm()
	{
		$this->Fields = array(	'Dc1Title',
					'Dc1Description',
					'Dc1CreatorLocal_tab',
					'Dc2DateCreated',
					'Dc1PublisherRef->eparties->SummaryData',
					'Dc1Type',
					'Dc1Format',
					'Dc1ContributorRef->eparties->SummaryData',
					'Dc1Identifier',
					'Dc1Subject_tab',
					'AdmWebMetadata|SummaryData',
					);

		$this->Hints = array(	
			'Dc1Title'		=> '[ e.g. Crompton Centenary ]',
			'Dc1Description'	=> '[ e.g. sales catalogue ]',
			'Dc1CreatorLocal_tab'	=> '[ e.g. Greg, Samuel ]',
			'Dc2DateCreated'	=> '[ e.g. 1791 1934 ]',
			'Dc1PublisherRef->eparties->SummaryData' => '[ e.g. Platt Brothers, Cotton Board ]',
			'Dc1Type'		=> '[ e.g. text, images, document, multimedia ]',
			'Dc1Format'		=> '[ e.g. Book, Manuscript, Photograph ]',
			'Dc1ContributorRef->eparties->SummaryData' => '[ Select from list ]',
			'Dc1Identifier'		=> '[ e.g. Holding organisation which owns original item ]',
			'Dc1Subject_tab'	=> '[ e.g. mill owners, child labour, spinning ]',
			);

		$this->DropDownLists = array(
			'Dc1Type'	=> "|3-D Object|Text|Document|Image|Maps and Plans|Multimedia|Textile Samples",
			'Dc1ContributorRef->eparties->SummaryData'	=> "|Ancoats Buildings Preservation Trust|Bolton Archives and Local Studies|Bolton Museum and Art Gallery|Gallery of Costume, Manchester|Greater Manchester Archaeological Unit|Greater Manchester County Record Office|John Rylands University Library of Manchester|Manchester Library and Information Service|Museum of Science and Industry in Manchester|Museum of the Lancashire Textile Industry|North West Sound Archive|Oldham Local Studies and Archives|People's History Museum|Quarry Bank Mill|Stockport Library and Information Service|Tameside Local Studies and Archive|Textile Institute",
				);

		$this->LookupLists = array (
					);

		$this->BaseDetailedQueryForm();
	}


} 
?>
