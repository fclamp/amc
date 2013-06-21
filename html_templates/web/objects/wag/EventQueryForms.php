<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
GalleryUKEventQueryForm extends BaseDetailedQueryForm
{

	function
	GalleryUKEventQueryForm()
	{
		$eventDate = new QueryField;
		$eventDate->ColName = 'DatCommencementDate|DatCompletionDate';
		$eventDate->ColType = 'date';

		$this->Fields = array(
				'EveEventTitle',
				'EveTypeOfEvent',
				'EveEventDescription',
				'EveIntendedAudience',
				$eventDate,
				);

		$this->Hints = array(
				'EveEventTitle' => 'Use one or more keywords',
				'EveTypeOfEvent' => 'Select from drop-down list',
				'EveEventDescription' => 'Use one or more keywords',
				'EveIntendedAudience' => 'eg modern art, textiles',
				'DatCommencementDate' => 'Use year only',
				);

		$this->DropDownLists = array(
				'EveTypeOfEvent' => '|collection display|collection exhibition|exhibition|loan exhibition',
				'EveIntendedAudience' => 'eluts:Intended Audience',
				);

		$this->ExtraStrings = array(
                                'ONLY_WITH_IMAGES' => 'List exhibitions only with images',
                                );
		

		$this->BaseDetailedQueryForm();
	}

} // End GalleryUKEventQueryForm class
?>
