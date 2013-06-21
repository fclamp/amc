<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($COMMON_DIR . '/EMuWebSessions.php');

class
TrailElement
{
	var $Page = "";
	var $Url = "";
}

class
Crumbtrail
{
	var $Seperator = "->";
	var $PagesDefaultToSelf = 1;
	var $EMuSession;
	var $Trail = array();

	function
	Crumbtrail()
	{

		$this->EMuSession = new EMuWebSession();
		$trail = $this->EMuSession->GetVar("crumbtrail");
		if (!empty($trail))
			$this->Trail = $trail;
	}

	function
	AddPage($name, $url="", $urlparams=array())
	{
		// Setup defaults
		if (empty($urlparams) && $this->PagesDefaultToSelf == 1)
			$urlparams = $_REQUEST;
		if (empty($url) && $this->PagesDefaultToSelf == 1)
			$url = $_SERVER['PHP_SELF'];

		$urlstring = "";
		if (!empty($urlparams))
		{
			$urlstring = '?';
			foreach ($urlparams as $param => $value)
			{
				$urlstring .= $param . "=" . urlencode(stripslashes($value)) . "&";
			}
			$urlstring = preg_replace('/&$/', "", $urlstring);
		}
		$url .= $urlstring;
		
		$found = 0;
		$trailsize = count($this->Trail);
		for($i = 0; $i < $trailsize; $i++)
		{
			if ($name === $this->Trail[$i]->Page)
			{
				$this->Trail[$i]->Url = $url;
				$found = 1;
			}
			elseif ($found == 1)
				unset($this->Trail[$i]);
		}

		if ($found != 1)
		{
			$crumbel = new TrailElement();
			$crumbel->Page = $name;
			$crumbel->Url = $url;
			array_push($this->Trail, $crumbel);
		}
		
		$this->EMuSession->SaveVar("crumbtrail", $this->Trail);
	}

	function
	PrintTrail($linkclass="")
	{
		if ($linkclass != "")
			$linkclass = 'class="' . $linkclass . '" ';

		for ($i = 0; $i < count($this->Trail); $i++)
		{
			print '<a ' . $linkclass . 'href="' . $this->Trail[$i]->Url . '">' . $this->Trail[$i]->Page . '</a>';
			if (isset($this->Trail[$i+1]))
				print htmlspecialchars($this->Seperator);
		}
	}

	function
	ClearTrail()
	{
		$this->Trail = array();
		$this->EMuSession->ClearSession();
	}
}
?>
