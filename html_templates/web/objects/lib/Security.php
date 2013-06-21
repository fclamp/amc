<?php
/*
*   Copyright (c) 1998-2012 KE Software Pty Ltd
*
*	This file contacts security related classes.
*		SecurityTester : test the validity of the user.
*/
if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');


class
SecurityTester
{
	var $GroupsArray;
	var $AuthType = 'web server';
	
	/*
	** $validUsers is a space separated string of users or groups
	**	to validate from.
	*/
	function
	UserIsValid($validUsers, $user='')
	{
		$group = '';
		if ($user == '')
		{
			switch($this->AuthType)
			{
			    case 'web server':
				if (isset ($GLOBALS['REMOTE_USER']))
					$user = $GLOBALS['REMOTE_USER'];
				else
					$user = $_SERVER['REMOTE_USER'];
					
				if (isset($this->GroupsArray))
					$group = $this->GroupsArray[$user];
				else
					$group = $GLOBALS['USER_GROUPS'][$user];
				break;
			    default:
			    	WebDie('Unsupported User Authentication Type', 'SecurityTester - UserIsValid');
				break;
			}
		}

		$user = strtolower($user);
		$group = strtolower($group);

		/* TODO - sould use a pattern match so subnames can't match */
		if ($user != '' && strpos($validUsers, $user) !== false)
			return(1);
		if ($group != '' && strpos($validUsers, $group) !== false)
			return(1);

		return(0);
	}

	function
	GroupIsValid($validUsers, $group='')
	{
		WebDie('Not Implimented', 'SecurityTester');
		return(0);
	}
}

?>
