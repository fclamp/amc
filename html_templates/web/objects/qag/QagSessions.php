<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/*
** Class to facilitate the use of sessions, through either cookies
** or a passed SID.
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once($WEB_ROOT . '/objects/common/EMuWebSessions.php');

class
QagSession extends EMuWebSession
{
	function
	QagSession($sessname="")
	{
		if (!empty($sessname))
			$this->SessName = $sessname;
	
		session_name($this->SessName);
		session_cache_limiter('must-revalidate');
		session_start();
	}
}
?>
