<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
GalleryStandardResultsList extends BaseStandardResultsList
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				'CreCreatorLocal:1',
				'CreDateCreated',
				'TitObjectType'
				);	

} // end GalleryResultsList class
class
GallerySummaryDataResultsList extends BaseStandardResultsList
{
	var $KeepImageAspectRatio = 1;
        var $Fields = array(    'SummaryData',
                                'TitObjectType'
                                );

} // end GalleryResultsList class



class
GallerySportResultsList extends BaseStandardResultsList
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	'SpoNameLocal',
				'SpoSport',
				'SpoHallOfFame',
				'TitObjectType'
				);	

} // end GalleryResultsList class

class
GalleryDiggerResultsList extends BaseStandardResultsList
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	'MilNameLocal',
				'MilAge',
				'MilRegimentalNumber',
				'MilRank',
				'MilUnit',
				'TitObjectType'
				);	

} // end GalleryResultsList class

class
GalleryContactSheet extends BaseContactSheet
{
	var $KeepImageAspectRatio = 1;
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				);	

} // end GalleryContactSheetResultsList class

?>
