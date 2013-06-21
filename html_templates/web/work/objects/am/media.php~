<?php
/* Copyright (c) 2009 - KE Software Pty. Ltd. */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'media.php');

class AmMediaRetriever extends MediaRetriever
{
	function AmMediaRetriever()
	{
		return parent::MediaRetriever();
	}

	function imageIsViewable($irn)
	{
		$qry = new ConfiguredQuery;
		$qry->Select = array(	'AdmPublishWebNoPassword',
					'AdmPublishWebPassword',
				);
		$qry->From = 'emultimedia';
		$qry->Intranet = $this->Intranet;
		$qry->Where = "irn=$irn";
		$r = $qry->Fetch();

		if ($this->Intranet)
		{
			if (strtolower($r[0]->AdmPublishWebPassword) != strtolower($qry->SystemYes))
			{
				// Access denied
				return false;
			}
		}
		else
		{
			if(strtolower($r[0]->AdmPublishWebNoPassword) != strtolower($qry->SystemYes))
			{
				// Access denied
				return false;
			}
		}
		return true;
	}
}

