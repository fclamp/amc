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
LanguageSelector extends BaseWebObject 
{
	var $DefaultLangauge;
	var $FontFace;
	var $FontSize;
	var $FontColor;
	var $Language;
	var $QueryUrl;
	var $Item;
	

	function
	Show()
	{
		$QueryUrl = $this->QueryUrl;
		$LangType = $this->LangType;

		list($Url, $lang,$Langval) = split ("[?=]", $QueryUrl);
		list($lang1, $lang2) = split ("[,]", $LangType);

		if ($LangType == '0,1')
		{
			if ($Langval == 0)
			{
				$QueryUrl = $this->QueryFrenchFormPage;
				//$QueryUrl = str_replace("Query.php","QueryF.php",$QueryUrl);
				//$QueryUrl = str_replace("0","1",$QueryUrl);
				//print "<p> Cette page en: <a href=\"$QueryUrl\"> Fran&ccedil;ais </a>";
			
			}
			if ($Langval == 1)
			{
				$QueryUrl = $this->QueryFormPage;
				//$QueryUrl = str_replace("QueryF.php","Query.php",$QueryUrl);
				//$QueryUrl = str_replace("1","0",$QueryUrl);
				//print "<p> This page in: <a href=\"$QueryUrl\"> English </a>";
			}
		}
		return ($QueryUrl);
	}
	


	function
	display()
	{
		$this->sourceStrings();
		$Item = $this->Item;

		if ($Item == 'ImageTitle')
		{
			$ImageTitle = $this->_STRINGS['TITLE IMAGE'];
			return ($ImageTitle);
		}
		if ($Item == 'OrganizationIcon')
		{
			$OrganizationIcon = $this->_STRINGS['MUSEUM ICON'];
			return ($OrganizationIcon);
		}
		if ($Item == 'SearchResult')
		{
			$SearchResult = $this->_STRINGS['SEARCH RESULT'];
			return ($SearchResult);
		}
		if ($Item == 'FooterNote1')
		{
			$FooterNote1 = $this->_STRINGS['CONDITION1'];
			return ($FooterNote1);
		}
		if ($Item == 'FooterNote2')
		{
			$FooterNote2 = $this->_STRINGS['CONDITION2'];
			return ($FooterNote2);
		}
		if ($Item == 'FooterNote3')
		{
			$FooterNote3 = $this->_STRINGS['CONDITION3'];
			return ($FooterNote3);
		}
		if ($Item == 'FooterNote4')
		{
			$FooterNote4 = $this->_STRINGS['CONDITION4'];
			return ($FooterNote4);
		}
		if ($Item == 'CreatedDate')
		{
			$CreatedDate = $this->_STRINGS['CREATED DATE'];
			return ($CreatedDate);
		}
		if ($Item == 'CopyRight')
		{
			$CopyRight = $this->_STRINGS['COPY RIGHT'];
			return ($CopyRight);
		}

	}
}

?>
