<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');

class
TcmiStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'ObjPopularName',
				'ObjAccessionNumber',
				'CreMakerRef:1',
				'DatDateMade'
				);	

} // end TcmiResultsList class

class
GalleryStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				'CreCreatorLocal:1',
				'CreDateCreated'
				);	

} // end GalleryResultsList class

class
TcmiContactSheet extends BaseContactSheet
{
	var $Fields = array(	'ObjPopularName',

				);	

} // end TcmiContactSheet class

class
GalleryContactSheet extends BaseContactSheet
{
	var $Fields = array(	'TitMainTitle',
				);	

} // end GalleryContactSheetResultsList class


?>
