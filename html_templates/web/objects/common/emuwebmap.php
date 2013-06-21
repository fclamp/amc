<?php

/*******************************************************
 * php wrapper around emuwebmap.pl
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 * $Revision: 1.7 $
 * $Date: 2012-02-08 05:20:55 $
 *******************************************************/


$debug = 0;

if (!isset($WEB_ROOT))
         $WEB_ROOT = dirname(dirname(dirname(__FILE__)));


require_once($WEB_ROOT . '/objects/lib/webinit.php');


// the idea is to pass arguments on to the (perl) cgi script...
// script has to think it was called not this php wrapper

// set up environment to be like web server
foreach ($_SERVER as $param => $value)
{
	putenv($param ."=". $value); 
}


// make a post header
$postvars = array();
foreach ($HTTP_POST_VARS as $param => $value)
{
	if (! is_null($value))
	{
		if ( is_scalar($value))
		{
			$value = preg_replace('/=/s','%3D',$value,-1);
			$postvars[] = "$param=" . $value;
		}
		else
			$postvars[] = "$param=" . implode($value,"&$param=");
	}
}
foreach ($HTTP_GET_VARS as $param => $value)
{
	if (! is_null($value))
	{
		if ( is_scalar($value))
		{
			$value = preg_replace('/=/s','%3D',$value,-1);
			$postvars[] = "$param=" . $value;
		}
		else
			$postvars[] = "$param=" . implode($value,"&$param=");
	}
}

// mung query string
$cgistring = implode($postvars,"&");
$cgistring = preg_replace('/\s+/s','+',$cgistring,-1);
$cgistring = preg_replace('/\//s','%2F',$cgistring,-1);
$cgistring = preg_replace('/\[/s','%5B',$cgistring,-1);
$cgistring = preg_replace('/\]/s','%5D',$cgistring,-1);
$cgistring = preg_replace('/</s','%3C',$cgistring,-1);
$cgistring = preg_replace('/>/s','%3E',$cgistring,-1);
$cgistring = preg_replace("/'/s",'%22',$cgistring,-1);
$cgistring = preg_replace('/\(/s','%28',$cgistring,-1);
$cgistring = preg_replace('/\)/s','%29',$cgistring,-1);
$cgistring = preg_replace('/img_x/','img.x',$cgistring,-1);
$cgistring = preg_replace('/img_y/','img.y',$cgistring,-1);
$cgistring = preg_replace('/ref_x/','ref.x',$cgistring,-1);
$cgistring = preg_replace('/ref_y/','ref.y',$cgistring,-1);

#$cgistring .= '&debugOptions=urls';

putenv("CONTENT_TYPE=application/x-www-form-urlencoded");
putenv("REQUEST_METHOD=POST");
putenv("CONTENT_LENGTH=". strlen($cgistring));
putenv("TEXAPIHOME=/usr/local/emu/texpress/texapi");

$cgistring .= '&specimenMap=1';

// call perl cgi script
exec("echo '" . $cgistring ."&php=1' | /usr/bin/perl " . $WEB_ROOT . "/objects/common/emuwebmap.pl",$page);

// if perl script returns mime header remove it...
if (preg_match('/Content-type:/i',$page[0]))
	array_splice($page,0,1);	


if ($debug)
	print "cgi string passed as post to script: '$cgistring'\n";


print implode($page,"\n");


?>
