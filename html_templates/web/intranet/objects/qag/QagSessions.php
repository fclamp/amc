<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/*
** Class to facilitate the use of sessions, through either cookies
** or a passed SID.
*/
require_once('../../../objects/common/EMuWebSessions.php');

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
