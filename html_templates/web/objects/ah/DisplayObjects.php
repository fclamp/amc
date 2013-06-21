<?php

/*
**
**	Copyright (c) 1998-2009 KE Software Pty Ltd
**
**
*/


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseDisplayObjects.php');



class
AHStandardDisplay extends BaseStandardDisplay
{
	// Set default in the constructor
	function
	AHStandardDisplay()
	{
		$this->Fields = array(
				'ObjObjectName',
				'ObjMuseumName',
				'ObjCategory1',
				'ObjCategory2',
				'ObjCategory3',
				'ObjCategory4',
				'SrcTitle',
				'SrcCopyright',
				'SrcOrganisation',
				'IdtArtist',
				'IdtOrigin',
				'IdtPeriod',
				'IdtSerial',
				'IdtSerialLocation',
				'DesDescription',
				'DesLength',
				'DesWidth',
				'DesHeight',
				'DesWeight',
				'DesColour',
				'DesMaterial',
				'DesProvenance',
				'DesRelevance',
				'NotNotes',
				);
		
		$this->BaseStandardDisplay();
	}
}

?>
