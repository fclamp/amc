<?php
/*
*       Copyright (c) 1998-2012 KE Software Pty Ltd
*
*    serverconnection.php - provides a raw socket connection object to 
*	texxmlserver.php
*
*    Contains:  Class TexxmlserverConnection
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');

class
TexxmlserverConnection
{
	var $Host;
	var $Port;
	var $SecondaryHost;
	var $SecondaryPort;

	function
	TexxmlserverConnection()
	{
		// Defaults
		$this->Host = $GLOBALS['XML_SERVER_HOST'];
		$this->Port = $GLOBALS['XML_SERVER_PORT'];
		$this->SecondaryHost = $GLOBALS['XML_SECONDARY_SERVER_HOST'];
		$this->SecondaryPort = $GLOBALS['XML_SECONDARY_SERVER_PORT'];
	}


	/*
	** Open() - Return a file descriptor associated with 
	**	a texxmlserver TCP connection.
	*/
	function
	Open()
	{
		// This don't seem to work on a lot of systems, but try anyway
		if (!is_numeric($this->Port))
		{
			$this->Port = getservbyname($this->Port, 'TCP');
		}

		$fd = fsockopen ($this->Host,
				$this->Port,
				$errno, 
				$errstr, 
				30
				);

		// If failed try with secondary server if set
		if (	(!$fd || $fd < 0)
			&& isset($this->SecondaryHost)
			&& isset($this->SecondaryPort)
			)
		{
			$fd = fsockopen ($this->SecondaryHost,
					$this->SecondaryPort,
					$errno, 
					$errstr, 
					30
					);
		}
		return $fd;
	}
} // end TexxmlserverConnection class

?>
