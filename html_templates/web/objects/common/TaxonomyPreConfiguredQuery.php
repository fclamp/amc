<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');

class TaxonomyPreConfiguredQueryLink extends PreConfiguredQueryLink
{
	var $showLevels = array (
		'ClaScientificName','ClaPhylum','ClaClass','ClaOrder','ClaFamily' );
//	var $allowMapper = 1;

	function generateRef()
	{

		$getString = '';
		foreach ($this->showLevels as $level)
		{
			$getString .= "&amp;$level=show";
		}
		if ($this->allowMapper)
			$getString .= "&amp;allowMapper=1";

		return (parent::generateRef() . "?" . $getString);
	}

}

?>
