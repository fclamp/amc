<?php
/*
* Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');

/* 
*  This class provides common code used in all query forms
*/

class
BaseQueryForm extends BaseWebObject
{
	var $SubmitMethod = "post";
	var $AdditionalTransferVariables = array();

	function
	printAdditionalTransferVariables()
	{
		foreach ($this->AdditionalTransferVariables as $k => $v)
		{
			print '<input type="hidden" name="' . $k . '" value="' . $v . '" />' . "\n";
		}
	}
}

?>
