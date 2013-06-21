<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');

/*
*  Make a Preconfigured query link
*
*	eg 1.
*	$preConfigQuery = new PreConfiguredQueryLink;
*	$preConfigQuery->Where = "TitTitle contains 'dancing'";
*	$preConfigQuery->PrintRef();
*
*
*	eg 2.
*	$preConfigQuery = new PreConfiguredQueryLink;
*	$preConfigQuery->QueryTerms = array (
*				"TitTitle" => "dancing",
*				"SurSubject" => "dance",
*				);
*	$preConfigQuery->PrintRef();
*/

class PreConfiguredQueryLink extends BaseWebObject
{
	var $Where = '';
	var $QueryTerms;
	var $LimitPerPage = 20;
	var $LinkText = 'Click Here';

	function
	generateRef()
	{
		// Minimize white space
		$self = isset($GLOBALS['PHP_SELF']) 
				? $GLOBALS['PHP_SELF'] : $_SERVER['PHP_SELF'];
		$page = urlencode($self);
		$getString = '';
		if ($this->Where != '')
		{
			$this->Where = preg_replace('/\\r?\\n/', 
						' ', $this->Where);
			$this->Where = preg_replace('/\\t/', 
						' ', $this->Where);
			$this->Where = preg_replace('/\\s\\s+/', 
						' ', $this->Where);
			$where = urlencode($this->Where);
			$getString = 
				"Where=$where&amp;QueryPage=$page&amp;LimitPerPage=" 
					. $this->LimitPerPage;
		}
		elseif (is_array($this->QueryTerms))
		{	
			$getString = "QueryName=DetailedQuery&amp;QueryPage=$page&amp;LimitPerPage=" 
					. $this->LimitPerPage;
			foreach ($this->QueryTerms as $field => $term)
			{
				$value = str_replace("'", '', $term);
				$value = urlencode($value);
				$field = urlencode('col_' . $field);
				$getString .= "&amp;$field=$value";
			}
		}
		else
		{
			WebDie('Could not create URL, Where or QueryTerms should be set', 
				'PreConfiguredQueryLink - generateRef()');
		}

		return ($this->ResultsListPage . "?" . $getString);
	}

	function
	PrintRef()
	{
		print $this->generateRef();
	}

	function
	Show()
	{
		print '<a href="' . $this->generateRef() 
			. '">' . $this->LinkText . '</a>';
	}
}

?>
