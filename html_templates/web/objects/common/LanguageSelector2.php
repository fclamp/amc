<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'configuredquery.php');
require_once ($LIB_DIR . 'border.php');
require_once ($LIB_DIR . 'Security.php');



/*
** This object provides a HTML option box for selecting the language 
** used by web objects. It will simply refreash the current page 
** setting the required lang value
*/

class
LanguageSelector2 extends BaseWebObject 
{
	var $DefaultLangauge;
	var $FontFace;
	var $FontSize;
	var $FontColor;
	var $Language;
	var $QueryUrl;
	var $Item;
	var $lang;
	var $LangArraySize;
	var $PageAssociations;
	

	function
	Show()
	{
		$LangDef = $GLOBALS['DEFAULT_LANGUAGE'];
		$LangArr = $GLOBALS['LANG_ARRAY'];
		$pageAssociations = $this->PageAssociations;
		$LangArraySize = count($LangArr);
		$QueryPage = '';
		$PagePrompt = '';
		$LangPrompt = '';
		$i = '';
		$j = '';


		if (isset($LangArr))
		{ 
			if ($LangArraySize > 2)
			{
				$this->sourceStrings();
				$PagePrompt = $this->_STRINGS['THIS_PAGE_IN'];
				print "<FORM METHOD=GET ACTION=\"/cmcc/pages/common/redirect.php\">";
				print "$PagePrompt";	
				print "<select name=\"url\">";
	
				foreach ($LangArr as $i)
				{
					$j = ucwords(strtolower($i));
					$QueryPage = $pageAssociations[$j];
					$LangPrompt = $this->_STRINGS['QUERY_LANG_' . $i];
					
					if ($LangPrompt != $this->Language)
					{
					   print "<option VALUE = \"http://kodiak/webcmcc/pages/cmcc/$QueryPage\">$LangPrompt"; 
					}
				}
			
				print "</select>";
				print "<input type=\"submit\" value=\"go!\">";
				print "</FORM>";
			}
			else
			{
				$this->sourceStrings();
				$PagePrompt = $this->_STRINGS['THIS PAGE IN'];

				foreach ($LangArr as $i)
				{
					$j = ucwords(strtolower($i));
					if ($j == $this->Language) 
					{
					}
					else
					{
						$QueryPage = $pageAssociations[$j];
					
						print "<a href=\"http://kodiak/webcmcc/pages/cmcc/$QueryPage\">$PagePrompt<a>"; 

					}
				}
			}
		}
	}
}

?>
