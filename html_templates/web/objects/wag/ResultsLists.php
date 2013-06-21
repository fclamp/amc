<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseResultsLists.php');



class
GalleryUKStandardResultsList extends BaseStandardResultsList
{
	var $Fields = array(	'TitMainTitle',
				'CreCreatorLocal:1',
				'CreCreationPlace1:1',
				'CreDateCreated',
				'TitAccessionNo',
				);	
	var $NonDisplayFields = array(
		"TitObjectName",
		"AssParentObjectRef",
		"EdiBookNumberParts");

	function
	conditionalDisplayPageLink($displaylink, $record)
	{
		if (preg_match("/book/i", $record->{"TitObjectName"}))
		{
			// Changed as a result of raised issue - no longer
			// 	conforms to spec.
			//if (!empty($record->{"AssParentObjectRef"})
			//	&& $record->{"EdiBookNumberParts"} > 1)
			if ($record->{"EdiBookNumberParts"} > 1)
			{
				$displaylink = "/collections/search/bookbrowser/";
			}
		}

		return $displaylink;
	}

} // end GalleryResultsList class

class
GalleryUKContactSheet extends BaseContactSheet
{
	var $Fields = array(	'TitMainTitle',
				'TitAccessionNo',
				);	
        var $NonDisplayFields = array(
                "TitObjectName",
                "AssParentObjectRef",
                "EdiBookNumberParts");

        function
        conditionalDisplayPageLink($displaylink, $record)
        {
                if (preg_match("/book/i", $record->{"TitObjectName"}))
                {
                        if (!empty($record->{"AssParentObjectRef"})
                                && $record->{"EdiBookNumberParts"} > 1)
                        {
                                $displaylink = "/collections/search/bookbrowser/
";
                        }
                }

                return $displaylink;
        }


} // end GalleryContactSheetResultsList class


?>
