<?php
/*
*	Copyright (c) 1998-2012 KE Software Pty Ltd
*    configuredquery.php - Inheriate texquery and configure defaults.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');
require_once ($LIB_DIR . 'common.php');

class ConfiguredQuery extends Query
{
	function
	ConfiguredQuery()
	{

		// Constructor - setup defaults
		$this->SystemYes = GetLutsEntry("system yes");

		$this->SupportedLanguages = GetRegistryEntry(	
							"system",
							"setting",
							"language", 
							"supported");

		if (isset($GLOBALS['LANGUAGE_DELIMITER']))
		{
			$this->LanguageDelimiter = 
					$GLOBALS['LANGUAGE_DELIMITER'];
		}

		if (isset($GLOBALS['LANGUAGE_SHOW_FIRST_FILLED']))
		{
			$this->LanguageShowFirstFilled = 
				$GLOBALS['LANGUAGE_SHOW_FIRST_FILLED'];
		}
		else
		{
			// else get default out of registry
			$showfirst = GetRegistryEntry(
						"system",
						"setting",
						"language",
						"show first filled");
			$showfirst = strtolower($showfirst);
			$this->LanguageShowFirstFilled = ($showfirst == "true");
		}
		
		// Check to see if "lang" is set in the url
		global $ALL_REQUEST;
		if (isset($ALL_REQUEST['lang']) && is_numeric($ALL_REQUEST['lang']))
		{
			$this->SelectedLanguage = $ALL_REQUEST['lang'];
		}
	}
}

?>
