<?php
/*
*   Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');

/*
* This file contains very common code - keep fast & to a minimum.
*/

/*
*  A Pretty Print function
*/
function
PPrint ($text, $face='', $size='', $color='', $hightlightColor='', $raw=0)
{
	$face == '' ? $faceAttrib = '' : $faceAttrib = "face=\"$face\"";
	$size == '' ? $sizeAttrib = '' : $sizeAttrib = "size=\"$size\"";
	$color == '' ? $colorAttrib = '' : $colorAttrib = "color=\"$color\"";
	
	if (! $raw)
	{
		$text = htmlspecialchars($text);
		$text = preg_replace('/\\r?\\n/', "<br />\n", $text);
	}

	if ($hightlightColor == '')
	{
		print "<font $faceAttrib $sizeAttrib $colorAttrib>$text</font>";
	}
	else
	{
		print "<font onmouseover=\"this.style.background='$hightlightColor'\"
				onmouseout=\"this.style.background=''\" 
				$faceAttrib $sizeAttrib $colorAttrib>$text</font>";
	}
}

/*
* A Base Class for all web objects
*/
class
BaseWebObject
{
	var $LanguagePrompts;		// value to use for strings (eg. "english")
	var $LanguageData = "";		// value to use for data ("0" or "0,1")

	var $Internet = 1;
	var $Intranet = 0;
	var $ExtraStrings = array();
	var $LocalStringsFile = '';
	var $CatalogueType;
	var $QueryFormPage;
	var $ResultsListPage;
	var $DisplayPage;
	var $ImageDisplayPage;

	var $_STRINGS;

	//constructor (set defaults)
	function
	BaseWebObject()
	{
		global $ALL_REQUEST;
		$lang = "";
		if (isset($ALL_REQUEST['Language']) )
		{
			$lang = $ALL_REQUEST['Language'];
		}
		elseif (isset($ALL_REQUEST['lang']))
		{
			$lang = $ALL_REQUEST['lang'];
		}

		global $LANGUAGE_MAP;
		if (is_numeric(substr($lang, 0, 1)))
		{
			$this->LanguagePrompts = $LANGUAGE_MAP[substr($lang, 0, 1)];
			$this->LanguageData = $lang;
		}
		elseif ($lang != "")
		{
			$this->LanguagePrompts = strtolower($lang);
			$this->LanguageData = $LANGUAGE_MAP[strtolower($lang)];
		}

		$this->QueryFormPage	= $GLOBALS['DEFAULT_QUERY_PAGE'];
		$this->QueryFrenchFormPage	= $GLOBALS['DEFAULT_FRENCH_QUERY_PAGE'];
		$this->ResultsListPage	= $GLOBALS['DEFAULT_RESULTS_PAGE'];
		$this->ContactSheetPage = $GLOBALS['DEFAULT_CONTACT_SHEET_PAGE'];
		$this->DisplayPage	= $GLOBALS['DEFAULT_DISPLAY_PAGE'];
		$this->PartyDisplayPage	= $GLOBALS['DEFAULT_PARTY_DISPLAY_PAGE'];
		$this->ImageDisplayPage = $GLOBALS['DEFAULT_IMAGE_DISPLAY_PAGE'];
		$this->NarrativeDisplayPage = $GLOBALS['DEFAULT_NARRATIVES_DISPLAY_PAGE'];
		$this->NarrativeResultsList = $GLOBALS['DEFAULT_NARRATIVES_RESULTS_LIST'];
		$this->CatalogueType	= $GLOBALS['BACKEND_TYPE'];
	}

	/*
	 * Make overriding PPrint easier
	 */
	function
	printData($text, $face='', $size='', $color='', $hightlightColor='', $raw=0)
	{
		if ($this->PrintOverride($text, $face, $size, $color, $hightlightColor, $raw) == 0)
		{
			PPrint($text, $face, $size, $color, $hightlightColor, $raw);
		}
	}

	function
	PrintOverride($text, $face, $size, $color, $hightlightColor, $raw)
	{
		return 0;
	}

	function
	sourceStrings()
	{
		// for legacy support
		if (isset($this->Language))
		{
			$this->LanguagePrompts = $this->Language;
			$this->LanguageData = $this->Language;
		}

		if (is_numeric($this->LanguagePrompts))
		{
			global $LANGUAGE_MAP;
			$this->LanguagePrompts = $LANGUAGE_MAP[$this->LanguagePrompts];
		}
		$lang = strtolower($this->LanguagePrompts);
		// Source general strings out of lib/strings dir
		$generalStrings = $GLOBALS['LIB_DIR'] . "strings/$lang.php";
		if (file_exists($generalStrings))
			include($generalStrings);
		else
			include($GLOBALS['LIB_DIR'] . "strings/english.php");

		// Source common strings out of lib/strings dir
		$commonStrings = $GLOBALS['COMMON_DIR'] . "strings/$lang.php";
		if (file_exists($commonStrings))
			include($commonStrings);
		else
			include($GLOBALS['COMMON_DIR'] . "strings/english.php");

		// Source the client spacific strings file
		$clientStrings = $GLOBALS['STRINGS_DIR'] . "$lang.php";
		if (file_exists($clientStrings))
			include($clientStrings);
		else
			include($GLOBALS['STRINGS_DIR'] . "english.php");

		$this->_STRINGS = array_merge($GENERAL_STRINGS, $COMMON_STRINGS, $STRINGS);

		// Source any local strings file
		if ($this->LocalStringsFile != '' && file_exists($this->LocalStringsFile))
		{
			include($this->LocalStringsFile);
			if (!isset($LOCAL_STRINGS))
			{
				WebDie('Local strings file does not contain $LOCAL_STRINGS array', 
					'common.php - sourceStrings()'); 
			}
			$this->_STRINGS = array_merge($this->_STRINGS, $LOCAL_STRINGS);
		}

		// The ExtraStrings property will clobber anything in the defined strings files
		if (is_array($this->ExtraStrings) && count($this->ExtraStrings) > 0)
			$this->_STRINGS = array_merge($this->_STRINGS, $this->ExtraStrings);

		if (isset($GLOBALS['LOCAL_STRINGS']) && 
				count($GLOBALS['LOCAL_STRINGS']) && 
				is_array($GLOBALS['LOCAL_STRINGS']))
		{
			$this->_STRINGS = array_merge($this->_STRINGS, $GLOBALS['LOCAL_STRINGS']);
		}

	}
}

/*
*  MediaImage is now included in MediaImage.php. The following line has been
*	added for backwards compatability:
*/
require_once($LIB_DIR . 'MediaImage.php');

/*
*  A Help display objects.  Loads a user-defined help page in a new windows
*/
class
WebHelpLink extends BaseWebObject
{
	var $LinkText	= '';
	var $LinkImage	= '';
	var $FontFace	= '';
	var $FontSize	= '';
	var $TextColor	= '';
	var $Resizable	= 0;
	var $HelpPage;
	var $NewWindow = 1;

	function
	display()
	{
		if ($this->LinkImage == '')
		{
			if ($this->NewWindow)
			{
				$toPage = $this->HelpPage;
				print "<a href=\"javascript:;\" ";
				print " onclick=\"window.open('$toPage', 'newwin', ";
				print "'toolbar=0,scrollbars=1,location=0,statusbar=0,";
				print "menubar=0,resizable=";
				if ($this->Resizable)
					print "1";
				else
					print "0";
				print ",width=400,height=300');\">";
				PPrint($this->LinkText, $this->FontFace, $this->FontSize, $this->TextColor);
				print "</a>\n";
			}
			else
			{
				print '<a href="' . $this->HelpPage . '">';
				PPrint($this->LinkText, $this->FontFace, $this->FontSize, $this->TextColor);
				print "</a>\n";
			}
		}
		else
		{
			// TODO
			print '';
		}
	}

	function
	Show ()
	{
		$this->sourceStrings();
		if ($this->LinkText == '')
		{
			$this->LinkText = $this->_STRINGS['HELP'];
		}
		if ($this->HelpPage == '')
		{
			$this->HelpPage = $GLOBALS['WEB_DEFAULT_HELP_PAGE'];
		}
		$this->display();
	}
}

		


/*
*  A pretty die function
*/
function
WebDie ($message, $debug='')
{
	//  TODO - This should grap and display some nice, user-defined content
	global $DEBUG;
	if ($DEBUG)
	{
		$text 	= htmlspecialchars("ERROR: $message");
		$text 	.= htmlspecialchars(" -> DEBUG MESSAGE: $debug");
		Die($text);
	}
	else
	{
		$text 	= htmlspecialchars("ERROR: $message");
		Die($text);
	}
}

/*
*  This function returns PHP_SELF.  It'll work with all versions of PHP
*       and should be used in preference to $PHP_SELF directly.
*/
function
WebSelf()
{
        $r = isset($GLOBALS['PHP_SELF'])
                ? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
        return $r;
}

/*
*  This function returns an array of all the parameters as passed to the
*	page the function is moved from. Note that this function may need
*	modifying if in the future this way of retrieving the values is
*	abolished.
*/
function
GetCurrentUrlParams()
{
	$params = array_merge(
		$GLOBALS['HTTP_POST_VARS'], 
		$GLOBALS['HTTP_GET_VARS']
		);

	return $params;
}

/*
* Return a registry entry from the cached entries in cache/system.php
*/
function
GetRegistryEntry($key1, $key2="", $key3="", $key4="", $key5="")
{
	require_once($GLOBALS['CACHE_DIR'] . 'system.php');
	$keyid = strtolower($key1);
	if ($key2 != "")
		$keyid .= "-" . strtolower($key2);
	if ($key3 != "")
		$keyid .= "-" . strtolower($key3);
	if ($key4 != "")
		$keyid .= "-" . strtolower($key4);
	if ($key5 != "")
		$keyid .= "-" . strtolower($key5);
	global $REGISTRY_CACHE;
	return $REGISTRY_CACHE[$keyid];
}

/*
* Return a luts entry from the cached entries in cache/system.php
*/
function
GetLutsEntry($name)
{
	require_once($GLOBALS['CACHE_DIR'] . 'system.php');
	$name = strtolower($name);
	global $LUTS_CACHE;
	return $LUTS_CACHE[$name];
}
		

/*
** BACKWARDS COMPATABILITY:
*  A drop-down list language selector
*/
require_once($COMMON_DIR . "LanguageSelector.php");

?>
