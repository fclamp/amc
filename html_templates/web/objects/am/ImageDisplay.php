<?php
/* Copyright (c) 2009 - KE Software Pty. Ltd. */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($WEB_ROOT . '/objects/am/media.php');

class AMImageDisplay 
{
	var $rec;
	var $irn;
	var $size;
	var $title;

	function AMImageDisplay()
	{
		global $ALL_REQUEST;

		if (isset($ALL_REQUEST["size"]))
			$this->size = $ALL_REQUEST["size"];

		if (isset($ALL_REQUEST["thumb"]) && $ALL_REQUEST["thumb"] == "yes")
		{
			$this->size = "thumb";
		}
		
		$this->irn = $ALL_REQUEST['irn'];

		$qry = new ConfiguredQuery;
		$qry->Select = array(	'MulTitle',
					'MulCreator_tab',
					'MulDescription',
					'DetPublisher',
					'DetRights',
				);
		$qry->From = 'emultimedia';
		$qry->Where = "irn=" . $this->irn;
		$this->rec = $qry->Fetch();
	}


	function Title($default)
	{
		if ($this->rec[0]->MulTitle)
			return $this->rec[0]->MulTitle;
		else
			return $default;
	}
	function Description($default)
	{
		if ($this->rec[0]->MulDescription)
			return $this->rec[0]->MulDescription;
		else
			return $default;
	}
	function Rights($default)
	{
		if ($this->rec[0]->DetRights)
			return $this->rec[0]->DetRights;
		else
			return $default;
	}
	function Creator($default)
	{
		if ($this->rec[0]->{"MulCreator:1"})
			return $this->rec[0]->{"MulCreator:1"};
		else
			return $default;
	}

	function ImageLink()
	{

		return "<img src='../../objects/am/webmedia.php?irn=" . $this->irn . "&size=" . $this->size . "' />";
	}	
}



?>
