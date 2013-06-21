<?php

/* CURRENTLY THIS STUFF IS UNDER CONSTRUCTION */

/*
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 */


if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');

/**
 * 
 * Class DataCacher
 *
 * This class provides data caching services to other components
 * data can be saved against a given key string and retrieved at a later time
 * using that key string
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 * @todo Address potential problems posed by exposing cacher as web service
 * 	when using test interface.  Need to avoid someone maliciously caching
 * 	large amount of data (potentially denial of service attack) or
 * 	maliciously emptying cache (an annoyance to users).  Currently it
 * 	allows anyone to clean cache using test procedure and allows anyone to
 * 	caching data using test procedure (but it does prevent test caching of
 * 	data > 50 chars)
 *
 */
class DataCacher extends BaseWebServiceObject
{
	var $serviceName = "DataCacher";
	var $cachePath = '/tmp/wscache'; // will be made relative to
					 // this->webRoot
	var $ttl = 300;			 // seconds				 

	function DataCacher($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		parent::BaseWebServiceObject($backendType,$webRoot,$webDirName,$debugOn);
		$cacheDir = $this->webRoot ."/". $this->cachePath;
		if (! is_dir($cacheDir))
		{
			mkdir($cacheDir,0777);
			chmod($cacheDir,0777);
		}
		
	}

	function describe()
	{
		return	
			"A Data Cacher is a Web Service Object that implements a generic\n".
			"Data Caching service for use with Other Web Service Components\n".
			"It is a kind of web based associative array where data is\n".
			"indexed by a key generated from a passed 'index' string\n\n".
			parent::describe();
	}


	function generateKey($index)
	{
		return md5($index);
	}

	function makeFileName($index)
	{
		$key = $this->generateKey($index);
		$cachePath = $this->webRoot . $this->cachePath;
		return $cachePath ."/". $key;
	}

	function save($index,$data)
	{
		// pass the data and the key string you want to use to identify
		// this resource

		$fileName = $this->makeFileName($index);

		$dataFileName = $fileName . ".wsdata";
		$keyFileName = $fileName . ".wskey";

		if ($fh = fopen($dataFileName, "wb"))
		{
			if (fwrite($fh,$data))
				fclose($fh);
			else	
			{
				$this->_setError("unable to write data to data cache: '$dataFileName' in save method");
				return '';
			}	
		}
		else
		{
			$this->_setError("unable to open file for writing in data cache: '$dataFileName' in save method");
			return '';
		}

		if ($fh = fopen($keyFileName, "wb"))
		{
			$key = $this->generateKey($index);
			if (fwrite($fh,"<index>".urldecode($index)."</index>\n<key>$key</key>\n"))
				fclose($fh);
			else
			{
				$this->_setError("unable to write data to data cache: '$keyFileName' in save method");
				return '';
			}
		}
		else
		{
			$this->_setError("unable to open file for writing in data cache: '$keyFileName' in save method");
			return '';
		}
		return $this->getUrlOfFile($dataFileName);
	}	


	function exists($index)
	{
		$fileName = $this->makeFileName($index);
		$dataFileName = $fileName . ".wsdata";

		if (is_file($dataFileName))
			return 1;
		else	
			return 0;
	}

	function retrieve($index)
	{
		$fileName = $this->makeFileName($index);
		
		$dataFileName = $fileName . ".wsdata";
		if (is_file($dataFileName))
		{
			touch($dataFileName);
			$fsize = filesize($dataFileName);
			if ($fsize)
			{
				$fh = fopen($dataFileName, "r");
				$data = fread($fh, $fsize);
				fclose($fh);
				return $data;
			}
			else
				return '';
		}
		else
			$this->_setError("attempt to read missing cache file: '$fileName' in retrieve method");
			return '';
	}

	function cacheStats($maxAge=0,$clean=false)
	{
		// returns info on files in cache.  including number that would
		// have expired using passed $maxAge criteria.  if $clean then
		// unlink those that have expired

		$curTime = time();
		$cutOff = $curTime - $maxAge;

		$cachePath = $this->webRoot . $this->cachePath;
		$unlinkCount = 0;
		$alive = 0;
		$aliens = 0;
		$oldest = $curTime;
		$newest = 0;
		if (is_dir($cachePath))
		{
			if ($dh = opendir($cachePath))
			{
				while (($file = readdir($dh)) != false)
				{
					if (preg_match('/\.(wsdata$|wskey|gif)$/',$file))
					{
						$file = $cachePath .'/'. $file;
						if ($filemtime = filemtime($file))
						{
							if ($filemtime < $oldest)
								$oldest = $filemtime;
							if ($filemtime > $newest)
								$newest = $filemtime;

							if ($filemtime < $cutOff)
							{
								if ($clean && !  unlink($file))
									$this->_setError("Cannot remove cache file: '$file' in cleanCache method");
								else
									$unlinkCount++;
							}
							else
								$alive++;
						}
						else
							$this->_setError("Cannot stat cache file: '$file' in cleanCache method");
					}		
					else
						if (! is_dir($file))
								$aliens++;
				}
				closedir($dh);
			}
			else
				$this->_setError("Cannot open cache directory: '$cachePath' in cleanCache method");
		}
		else
			$this->_setError("Cannot find cache directory: '$cachePath' in cleanCache method");
		

		$removed = 0;
		if ($clean)
			$removed = $unlinkCount;

		
		$stats = Array(
				'alive' => $alive,
				'expired' => $unlinkCount,
				'removed' => $removed,
				'aliens' => $aliens,
				'oldest' => $curTime - $oldest,
				'newest' => $curTime - $newest,
				'remote' => $_SERVER['REMOTE_ADDR'],
				'allowed' => implode(',',$this->specialRemotes),
		);		
		/*foreach ($_SERVER as $arg => $value)
		{
			$stats[$arg] = $value;
		}*/
		return $stats;

		/*return array(
				'alive' => $alive,
				'expired' => $unlinkCount,
				'removed' => $removed,
				'aliens' => $aliens,
				'oldest' => $curTime - $oldest,
				'newest' => $curTime - $newest,

			);
			*/
	}


	function getUrlOfFile($file)
	{
		// give a file path (in the cache) return a suitable url to access
		// that file

		// if file exists then treat request for url as an access
		if (is_file($file))
			touch($file);

		if (PHP_OS == "WINNT" || PHP_OS == "WIN32")
		{
			$file = preg_replace("/\\\/","/",$file);
			$webRoot = preg_replace("/\\\/","/",$this->webRoot);
			$cachePath = $webRoot . $this->cachePath;
		}
		else
		{
			$cachePath = $this->webRoot . $this->cachePath;
		}
		
		$perlReg = $cachePath;
		$perlReg = preg_replace("/\//","\/",$perlReg);


		return preg_replace("/$perlReg/",'/'.$this->webDirName.$this->cachePath,$file);
	}

	function getUrlOfIndex($index)
	{
		return $this->getUrlOfFile($this->makeFileName($index).'.wsdata');
	}

	function systemFaults()
	{
		$cachePath = $this->webRoot . $this->cachePath;
		if (! is_writeable($cachePath))
			return "Cache Path: $cachePath is not writeable";
		else
			return parent::systemFaults();
	}


	function makeTestPage()
	{

		$args = array();
		$args["Index"] = "<input type='input' name='index' size='30'value='<fortune>returned</fortune>' />";
		$args["Data"] = "<textarea name='data' cols='20' rows='3'>Chicken Little only has to be right once.</textarea>";
		$args["Cache<br/>Actions"] = "<input type='submit' name='action' value='generateKey' /><br/>".
				"<input type='submit' name='action' value='save' /><br/>".
				"<input type='submit' name='action' value='exists' /><br/>".
				"<input type='submit' name='action' value='retrieve' /><br/>".
				"<input type='submit' name='action' value='geturl' /><br/>".
				"<input type='submit' name='action' value='stats' /><br/>".
				"<input type='submit' name='action' value='cleanCache' />";

		$vars = array();

		print $this->makeDiagnosticPage(
					"KE EMu ". $this->serviceName,
					'Data Caching Test System',
					'',
					'./DataCacher.php',
					$args,
					'',
					$vars,
					$this->describe()
				);
	}


	function test()
	{

		if (isset($_REQUEST['testCall']))
		{
			header("Content-type: text/xml",1);
			$action = $_REQUEST['action'];
			$index = $_REQUEST['index'];
			$data = $_REQUEST['data'];
			$remote = $_SERVER['REMOTE_ADDR'];

			switch($action)
			{
				case 'save':
					// avoid saving big test strings
					if (strlen($data) > 50)
					{
						print $this->notAllowed($remote,$action,'access to this operation denied');
						return;
					}
					else
						$response = $this->save($index,$data);
					break;
				case 'generateKey':
					$response = $this->generateKey($index);
					break;
				case 'exists':
					$response = $this->exists($index);
					break;
				case 'retrieve':
					$response = $this->retrieve($index);
					break;
				case 'geturl':
					$response = $this->getUrlOfIndex($index);
					break;
				case 'stats':
					$stats = $this->cacheStats($this->ttl,false);
					$xml[] = "<cache>";
					foreach ($stats as $param => $val)
						$xml[] = "<$param>$val</$param>";
					$xml[] = "</cache>";
					$response = implode("\n",$xml);
					break;
				case 'cleanCache':
					if (true || $this->remoteSpecial($remote))
					{
						$stats = $this->cacheStats(0,true);
						$xml[] = "<cache>";
						foreach ($stats as $param => $val)
							$xml[] = "<$param>$val</$param>";
						$xml[] = "</cache>";
						$response = implode("\n",$xml);
					}
					else
					{
						print $this->notAllowed($remote,$action,'access to this operation denied');
						return;
					}
					break;
				default:
					$this->errorResponse("unknown action requested: '$action'");
					break;
			}
			if ($error = $this->getError())
				$this->errorResponse($error);
			else	
				print("<response component='". $this->serviceName ."' status='success'>\n".
					"\t<action>$action</action>\n".
					"\t<value>$response</value>\n".
					"\t<message/>\n".
					"</response>"
				);
		}
		else	
		{
			header("Content-type: text/html",1);
			print $this->makeTestPage('','Provider test','','','');
		}
	}
}

if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "DataCacher.php")
	{
		$webObject = new DataCacher();
		$webObject->test();
	}
}




?>
