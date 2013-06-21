<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/
require_once(dirname(realpath(__FILE__)) . "/config.php");

class
ServerConnection
{
	public function
	__construct()
	{
		global $EMU_GLOBALS;

		if (isset($EMU_GLOBALS['TEXXMLSERVER_HOST']))
			$this->Host = $EMU_GLOBALS['TEXXMLSERVER_HOST'];
		if (isset($EMU_GLOBALS['TEXXMLSERVER_PORT']))
			$this->Port = $EMU_GLOBALS['TEXXMLSERVER_PORT'];
	}

	public $Host = "localhost";
	public $Port = 30000;

	public function
	Open()
	{
		if (!is_numeric($this->Port))
		{
			$this->Port = getservbyname($this->Port, 'TCP');
		}

		$fd = fsockopen($this->Host,
				$this->Port,
				$errno, 
				$errstr, 
				30
				);
		if ($fd === FALSE)
			throw new Exception("fsockopen failed: $errstr", $errno);

		return $fd;
	}
}
?>
