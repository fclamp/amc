<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/*
** Class to facilitate the use of sessions, through either cookies
** or a passed SID.
*/

class
EMuWebSession
{
	public $SessName = "EMUSESSID";
	
	function
	EMuWebSession($sessname="")
	{
		if (!empty($sessname))
			$this->SessName = $sessname;
	
		session_name($this->SessName);
		session_start();
	}

	function
	ClearSession()
	{
		session_name($this->SessName);
		session_destroy();
		session_start();
	}

	function
	SaveVar($name, $value)
	{
		$_SESSION["$name"] = $value;
	}

	function
	GetVar($name)
	{
		return $_SESSION["$name"];
	}

	function
	GetSessID()
	{
		return strip_tags(session_id());
	}
}
?>
