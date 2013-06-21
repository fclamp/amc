<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/warclip/BaseQueryForms.php');
//require_once ($LIB_DIR . 'BaseQueryForms.php');


class
WarclipBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' =>'AdmWebMetadata',
				'subject' => 'WarSubjectMetaData',
				'headline' => 'WarHeadline',
				'title' => 'ObjTitle',
				);

	var $Words= array(      'all' => 'AllWords',
                                'any' => 'AnyWords',
                                'exact' => 'Phrase',
                                );

	 var $Lang= array(       '0' => 'English',
	                         '1' => 'French',
				 );


}  // end WarclipBasicQueryForm class


class
WarclipAdvancedQueryForm extends BaseAdvancedQueryForm
{

	var $Options = array(	'any' => 'AdmWebMetadata',
				'subject' => 'WarSubjectMetaData',
				'headline' => 'WarHeadline',
				'title' => 'ObjTitle',
				);

	var $Month = array(	'Month' => '00',
				'Jan' => '01',
				'Feb' => '02',
				'Mar' => '03',
				'Apr' => '04',
				'May' => '05',
				'Jun' => '06',
				'Jly' => '07',
				'Aug' => '08',
				'Sep' => '09',
				'Oct' => '10',
				'Nov' => '11',
				'Dec' => '12',
				);

         var $Lang= array(       '0' => 'English',
                                 '1' => 'French',
                                 );

}  // end WarclipAdvancedQueryForm class


class
WarclipDetailedQueryForm extends BaseDetailedQueryForm
{
	var $Fields = array(	'ObjTitle',
				'WarSubjectHeading',
				'DatManufacture',
				'WarHeadline',
				'WarSourceNewspaperSummData',
				'epartiessummarydata',
				);

	var $Hints = array(	'ObjPopularName' 		=> '[ eg. The Cat in the hat ]',
				'ClaCollection' 		=> '[ eg. American Experience ]',
				'ClaClassificationTerm_tab'	=> '[ Select from the list ]',
				'DatDateMade'			=> '[ eg. 1983 ]',
				'DesMaterials'		=> '[ eg. ceramic ]',
				);

	var $DropDownLists = array(	#'TitCollectionTitle' => 'eluts:Collection Title',
				);

	var $LookupLists = array (
					'ClaClassificationTerm_tab' => 'Classification Term',
					'DesMaterials' => 'Materials',
				);

} // End WarclipDetailedQueryForm class

?>
