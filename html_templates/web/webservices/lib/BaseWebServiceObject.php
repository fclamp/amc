<?php


/**
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 *
 * @tutorial EMuWebServices/EMuWebServices.pkg
 * @tutorial EMuWebServices/Install.pkg
 * @tutorial EMuWebServices/Emusync.pkg
 * @tutorial EMuWebServices/Javascript.pkg
 *
 * @todo write site installation notes
 *
 * @todo testing, bug fixing
 *
 * @todo documenting xsl interfaces
 *
 */

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($WEB_ROOT . '/objects/lib/common.php');
require_once($WEB_ROOT . '/objects/lib/serverconnection.php');
require_once($WEB_ROOT . '/webservices/lib/Logger.php');

/**
 * 
 * Base Web Service Class
 *
 * This class is the base class of most of the web service components.  It
 * provides error handling and logging facilities
 *
 * Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 *
 */
class BaseWebServiceObject
{
	/* PROPERTIES */

	/**
	 * Define actual service name.
	 * You should set this appropriately for all children
	 * @var string 
	 */
	var $serviceName = "BaseWebServiceObject";

 	/**
	 * set from global environment
	 * @var string 
	 */
	var $backendType;
 	/**
	 * set from global environment
	 * @var string 
	 */
	var $webRoot;
 	/**
	 * set from global environment
	 * @var string 
	 */
	var $webDirName;

	/**
	 * logName
	 * @var string 
	 */
	var $logName;

	/**
	 * tmpDir
	 * @var string 
	 */
	var $tmpDir;

	/**
	 * logger object
	 * @var resource
	 */
	var $_logger;

	/**
	 * list of all error messages set
	 * @var string[]
	 */
	var $errorMessage = array();

	/**
	 * used to record actual instance of created object
	 * @var string 
	 */
	var $_currentInstance = 0;

	/**
	 * is debugging mode required
	 * @var boolean 
	 */
	var $_debugOn = false;

	/**
	 * which hosts have privileged access
	 * @var Array 
	 */
	var $specialRemotes = Array('127.0.0.1');

	/* METHODS */

	/**
	 *
	 * Base class constructor of most Web Service Objects
	 *
	 * NB PHP doesn't auto call the parents constructor so ensure any
	 * constructor overrides in children specifically call this constructor
	 *
	 * Typically called with no arguments in which case values are read
	 * from globals set by CONFIG.php - only set params to override
	 * CONFIG.php
	 *
	 * @param string $backendType
	 * @param string $webRoot
	 * @param string $webDirName
	 * @param int $debugOn
	 *
	 * @return void
	 */
	function BaseWebServiceObject($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		global $WEB_ROOT;
		global $BACKEND_TYPE;
		global $WEB_DIR_NAME;
		global $DEBUG;

		if (!$backendType)
			$this->backendType = $BACKEND_TYPE;
		else
			$this->backendType = $backendType;

		if (!$webRoot)
			$this->webRoot = $WEB_ROOT;
		else	
			$this->webRoot = $webRoot;

		if (!$webDirName)
			$this->webDirName = $WEB_DIR_NAME;
		else	
			$this->webDirName = $webDirName;

		if (!$debugOn)
			$this->_debugOn = $DEBUG;
		else
			$this->_debugOn = $debugOn;

		if (! isset($_REQUEST['instance']))
			$this->_currentInstance = $this->serviceName . "." . getmypid() . "." . time();

		$this->tmpDir = "{$this->webRoot}/tmp";

		if (PHP_OS == "WINNT" || PHP_OS == "WIN32")
		{
			$this->backendType = preg_replace("/\\\/", "/", $this->backendType);
			$this->webRoot = preg_replace("/\\\/", "/", $this->webRoot);
			$this->webDirName = preg_replace("/\\\/", "/", $this->webDirName);
			$this->tmpDir = preg_replace("/\\\/", "/", $this->tmpDir);
		}

		$this->logName = basename($_SERVER['PHP_SELF'], ".php") . '.log';
		$this->_logger =& new Logger("$this->tmpDir/logs", $this->logName, $this->_currentInstance);
        }

	/**
	 * Display object function for use with test system
	 * Every child should override this.  Experimental idea. May be removed
	 * @return string
	 */
	function describe()
	{
		return 
			"A BaseWebServiceObject provides basic functionality\n".
			"for WebService Components\n\n".
			"Type: $this->serviceName\n".
			"EMu-Web System: $this->webDirName\n".	
			"Logfile: $this->logName\n";
	}


	/**
	 * Test if EMuWeb is running
	 *
	 * Attempts to create a texserver connection to test if emuweb running
	 * @return boolean
	 *
	 */
	function emuwebRunning()
	{
		$status = false;
		$conn = new TexxmlserverConnection;
		$fd = @$conn->Open(); 
		if ($fd > 0) 
		{
			fclose($fd);
			$status = true;
		}
		return $status;
	}


	/**
	 * Test for appropriate PHP version
	 *
	 * function to check if PHP is greater than or equal to the passed
	 * PHP version string
	 * @param string $minimum
	 * @return boolean
	 */
	function phpVersionMinimum($minimum)
	{
		$vCurrent = preg_split('/\./',phpversion());
		$vNeeded =  preg_split('/\./',$minimum);
		if ($vCurrent[0] > $vNeeded[0])
			return 1;
		if ($vCurrent[0] < $vNeeded[0])
			return 0;
		if ($vCurrent[1] > $vNeeded[1])
			return 1;
		if ($vCurrent[1] < $vNeeded[1])
			return 0;
		if ($vCurrent[2] > $vNeeded[2])
			return 1;
		if ($vCurrent[2] < $vNeeded[2])
			return 0;
	}

	#########################
	### LOGGING FUNCTIONS ###
	#########################
	/*
	** send message to log file
	** @param string $message message to log
	** @return bool false = logging error, true = success
	*/
	function 
	_log($message)
	{
		return $this->log($message);
	}

	function 
	log($message)
	{
		return $this->_logger->log($message);
	}

	/*
	** write a file to the log file without holding the
	** entire file in memory at once
	** @param string the file to log
	** @return bool false = logging error, true = success
	*/
	function 
	filesToLog($files, $message=null)
	{
		return $this->_logger->logFiles($files, $message);
	}

	/*
	** Get the last log error message
	** @return mixed, bool false if no error, string otherwise
	*/
	function 
	getLogErrors()
	{
		return $this->_logger->getErrors();
	}

	#############################
	### END LOGGING FUNCTIONS ###
	#############################

	#######################
	### DEBUG FUNCTIONS ###
	#######################
	/*
	** Log debugging message
	** @param string debug message, 
	** 	int minimum debug level required
	** @return bool
	*/
        function
        debugMessage($message, $level)
        {
                if ($this->_debugOn >= $level)
                        return $this->log($message);
		return true;
        }

	/*
	** Log file as debugging message
	** @param string file to log
	** 	int minimum debug level required
	** @return bool
	*/
        function
        debugFile($files, $level, $message=null)
        {
                if ($this->_debugOn >= $level)
                        return $this->filesToLog($files, $message);
		return true;
        }
	###########################
	### END DEBUG FUNCTIONS ###
	###########################

	#######################
	### ERROR FUNCTIONS ###
	#######################

	function 
	setError($message, $file=null, $line=null)
	{
                $error = "";
                $error .= $message;

		if (isset($file) && isset($line))
			$error .= " in $file on line $line";

                if ($this->log($error) === false)
                {
                        if (($logErrors = $this->getLogErrors()) !== false)
			{
				foreach ($logErrors as $logError)
				{
                                	$this->errorMessage[] = "Error: could not write error '$error' to log file because of log error '$logError'";
				}
			}
                        else
			{
                                $this->errorMessage[] = "Error: could not write error '$error' to log file because of unknown log error";
			}
                }
		$this->errorMessage[] = $error;
		return false;
	}

	/**
	 * add an error to error list
	 *
	 * @param string $message error message to set
	 *
	 * @return void
	 */
	function 
	_setError($message)
	{
		$this->errorMessage[] = $message;
	}

	/**
	 * returns string of set errors (if any) Also clears error list
	 * @return string
	 */
	function 
	getError()
	{
		if (! isset($this->errorMessage) || empty($this->errorMessage))
			return '';

		$message = implode($this->errorMessage,'; ');
		$this->errorMessage = array();
		return $message;
	}


	###########################
	### END ERROR FUNCTIONS ###
	###########################

	/**
	 * look up web request parameter
	 *
	 * takes a request hash (typically CGI $_REQUEST)
	 * and returns value.  If none use default
	 *
	 * @param string $param parameter to find
	 * @param string $default if not set use default
	 * @param array $request hash of parameters
	 *
	 * @return string array of paths to files containing child objects
	 */
	function getRequestedParameter($param,$default='',$request)
	{
		if (isset($request[$param]) && $request[$param])
			$default = $request[$param];
		return $default;
	}			

	function encodeXmlSpecialChars($data)
	{
		$find = array("&", ">", "<", "\"", "'");
		$replace = array("&amp;", "&gt;", "&lt;", "&quot;", "&apos;");
		return (str_replace($find, $replace, $data));
	}


	/**
	 * test if duplicate CGI parameters passed
	 *
	 * looks at request string and returns true if
	 * arguments used more than once.  OAI protocol
	 * requires this be detected and error sent but
	 * also potentially useful for other services
	 *
	 * @param string $request passed CGI QUERY_STRING
	 *
	 * @return boolean true if duplicates
	 */
	function duplicateCgiArguments($request)
	{
		$known = Array();
		$args = preg_split("/&/",$request);
		foreach ($args as $argument)
		{
			List($param,$value) = preg_split("/=/",$argument,2);
			if (isset($known[$param]))
				return true;
			else
				$known[$param]++;
		}
		return false;
	}

	/**
	 * Determine if no arguments passed in $_GET or $_POST.
	 * (Several applications have been designed to show the query screen if
	 * they are not passed any arguments.  Be aware $_REQUEST has not just
	 * POST and GET but also COOKIE data)
	 */
	function noArgsPassed()
	{
		return ((! $_GET)  && (! $_POST));
	}


	/**
	 * Allow a host to have Privileged Access
	 *
	 * adds host as a privileged 'user'.  Services may then
	 * allow extra functionality for requests from these hosts (eg to run
	 * the DataCaching test service)
	 *
	 * It is up to the services descended from this class to define what
	 * (if anything) being privileged means)
	 *
	 * @param string $host 
	 *
	 * @return void
	 *
	 */
	function addRemote($host)
	{
		$this->specialRemotes[$host]++;
	}


	/*
	 *
	 * Test if host has privilege
	 *
	 * @param string $host 
	 *
	 * @return boolean
	 *
	 *
	 */
	function remoteSpecial($host)
	{
		return isset($this->specialRemotes[$host]) && $this->specialRemotes[$host];
	}

	function notAllowed($host,$action,$reason)
	{
		header("Content-Type: text/xml",true);
		return "<response component='". 
				$this->serviceName .
			"' status='denied' host='$host'>".
			"<action>$action</action>".
			"<message>$reason</message>".
			"</response>";
	}


	/**
	 * find child classes
	 *
	 * traverses directory looking for classes that extend an object
	 * this method normally only called in testing
	 * - experimental - may be removed
	 *
	 *
	 * @param string $dir directory to start searching from
	 * @param string $object class name to find children of
	 * @param string $exclude array of filenames to not check
	 *
	 * @return string array of paths to files containing child objects
	 */
	function findChildren($dir,$object,$exclude)
	{

		$children = array();
		$potentials = array();
		$stack[] = $dir;
		while ($stack)
		{
			$currentDir = array_pop($stack);
			if (is_dir($currentDir) && $dh = opendir($currentDir))
			{

				while (($file = readdir($dh)) !== false)
				{
					$currentFile = "$currentDir/$file";
					if (! (preg_match('/^\./',$file)) && is_dir($currentFile))
					{
						if (! isset($exclude[$file]))
                                 			$stack[] = $currentFile;
					}
					else if (preg_match('/\.php$/',$file))
						if (is_file($currentFile))
                               				$potentials[] = "$currentDir/$file";
				}
			}
		}
		foreach ($potentials as $file)
		{
			if ($fh = fopen($file, "r"))
			{
				if (filesize($file) > 0)
				{
					$php = fread($fh, filesize($file));
					fclose($fh);
					if (preg_match_all("/(\S+)\s+extends\s+$object/i",$php,$match))
					{
						foreach ($match[1] as $class)
							$children[$class] = $file;
					}
				}
			}
		}
		return $children;
	}


	/**
	 * simple live test facility
	 *
	 * respond to a test call generate a list of child objects with links
	 * to appropriate test urls for each.  Also may display test form to
	 * actually implement and use the object in a simple form
	 *
	 * prints html page
	 *
	 * @param boolean $clientSpecific flag used in children
	 * @param string $dir path to find source file
	 *
	 * @return void
	 *
	 */
	function test($clientSpecific=false,$dir='')
	{
		if (! $dir)
			$dir = $this->webRoot."/webservices";

		$serviceFile = basename($file);
		$object = get_class($this);

		// avoid looking in the following...
		$exclude = array("style"=>1, "maps"=>1);

		$args['Specific Instances'] = "";
		foreach ($this->findChildren($dir, $object, $exclude) as $class => $file)
		{
			$url = preg_replace("/". preg_quote($this->webRoot,'/') ."/", $this->webDirName,$file);
			$args['Specific Instances'] .= "Test <a href='/$url?test=true&class=$class'>$class</a><br/>\n";
		}

		print $this->makeDiagnosticPage
		(
			"{$this->serviceName} $object Tests",
			"Find Components based on $object",
			'',
			'',
			$args,
			'',
			Array(),
			$this->describe()	
		);
	}


	/**
	 * Assist in Making a test page
	 *
	 * For Diagnostic and Configuration Use.  Assemble a generic testing
	 * page for running diagnostics from.
	 *
	 * @param string $title Page Title
	 * @param string $comments Heading
	 * @param string $javascript any js to place on page
	 * @param string $action form action
	 * @param string $args hash of parameters to be placed in hidden inputs
	 * @param string $submission url to submit form to
	 * @param string $vars hash of required input variables
	 * @param string $describe general text to display
	 *
	 * @return string
	 */
	function 
	makeDiagnosticPage($title, $comments, $javascript, $action, $args, $submission, $vars, $describe)
	{

		$headColour = array('#ddddff','#cccccc','#eeeeee'); 
		$bodyColour = array('#ffffff','#eeeeee','#cccccc'); 

		$table = array();
		$table[] = "<tr bgcolor='$headColour[2]'>";
		if ($args)
		{
			foreach ($args as $heading => $value)
				$table[] = "\t<td align='center'>$heading</td>";
		}
		$table[] = "</tr>";
		$table[] = "<tr bgcolor='$bodyColour[0]'>";
		if ($args)
		{
			foreach ($args as $heading => $value)
				$table[] = "\t<td align='center'>$value</td>";
		}
		$table[] = "</tr>";
		$controls = implode("\n",$table);

		$hidden = array();
		if ($vars)
		{
			foreach ($vars as $param => $value)
				$hidden[] = "<input type='hidden' name='$param' id='$param' value='$value' />";
		}
		$params = implode("\n",$hidden);

		$describe .= "\nBase Class: <a href='/" .
			     $this->webDirName .
			     "/webservices/lib/BaseWebServiceObject.php?test=true&class=BaseWebServiceObject'>BaseWebServiceObject</a>";

		$cols = count($args);

		if ($this->emuwebRunning())
			$status = "<span style='color: green'>EMuWeb Running OK</span>";
		else
			$status = "<span style='color:red'><b>WARNING - EMuWeb IS NOT RUNNING !</b></span>";

		return <<<HTML
<html>	
	<head>
		<title>$title</title>
		<script language='javascript'>
		<!--
			$javascript
		 -->	
		</script>
	</head>
	<body>
		<form method='get' action='$action' >
			<center>
			<div style='font-size: 120%;'>$title</div>
			<div style='font-size: 110%;'>$comments</div>
			<div style='font-size: 110%;'>$status</div>
			<br/>
			<table border='1' cellspacing='0'>
				<tr><th bgcolor='$headColour[0]' colspan='$cols'>Component: $this->serviceName</th></td>
				<tr><th bgcolor='$headColour[1]' colspan='$cols'>Diagnostic Parameters/Tests</th></td>
				$controls
				<tr>
					<th bgcolor='$headColour[2]' colspan='$cols'>
						$submission
					</th>
				</tr>
			</table>
			<br/>
			<div>
				<table border='1' bgcolor='$bodyColour[1]'>
					<tr><th bgcolor='$headColour[0]'>Component Description</th></td>
					<tr><td><pre>$describe</pre></td></tr>
					
				</table>
			</div>
			<div id='message'></div>
			<p>
      				<img border="0" alt='KE EMu' src="../../images/productlogo.gif" width="134" height="48">
				<img border='0'alt="KE Software" src="../../images/companylogo.gif"  width="60" height="50">
				<br/>
				(C) 2000-2007 KE Software
			</p>
			</center>
			<input type='hidden' name='test' value='true' />
			<input type='hidden' name='testCall' value='true' />
			$params
		</form>

	</body>
</html>	
HTML;
	}


	/**
	 *
	 * Identify system faults
	 *
	 * This method can be used to identify if the component has self
	 * detected any faults If overridden in descendents, suugest you always
	 * call parent method
	 *
	 * @param null
	 *
	 * @return string
	 *
	 */
	 function systemFaults()
	 {
		/* Not a fault??
		if (! is_writeable($this->logName))
			
			return "Log File: $this->logName is not writeable";
		else
	 		return "";
		*/
		return "";
	 }


	/**
	 * low level error response
	 *
	 * simple response and quit use to bail out at low level (ie before you
	 * can safely construct a particular implementation of a web service)
	 *
	 * prints xml and exits
	 *
	 * @param string $msg message to write
	 *
	 * @return void
	 */
	function errorResponse($msg,$status='fail',$encodeEntities=true)
	{
		if ($encodeEntities)
			$msg = htmlentities($msg);

		header("Content-Type: text/xml",true);
		print("<?xml-stylesheet type='text/xsl'  href='lib/style/error.xsl'?>\n");
		print("<response component='". $this->serviceName
			."' status='$status'><message>$msg</message></response>");
		exit(1);
	}


	/**
	 * forced exit - write message and die
	 *
	 * for debug use only !! - returns passed parameters in XML
	 * format viewable by browser and quits
	 *
	 * prints response and exits
	 *
	 * @param mixed $msg text to display as context
	 * @param mixed $var variable to dump
	 * @param boolean $dump if true var_dump $var, if false print $var (if
	 * xml print in text form)
	 *
	 * @return void
	 */
	function _debug($msg,$var,$dump)
	{

		echo "<keInternalDebug>\n";
		echo " <message>$msg</message>\n<data>";
		if ($dump)
			var_dump($var);
		else
		{
			$var = preg_replace('/</','&lt;',$var);
			echo $var;
		}
		echo " </data>\n";
		echo "</keInternalDebug>";
		exit(0);
	}


	/**
	 * Break a method
	 *
	 * Used to 'break' a method that should be overridden by inherited
	 * children - experimental - may be removed
	 *
	 * attempts to use the method will result in exit with debug xml
	 * message
	 *
	 * @param string $methodName function name called from
	 */
	function _makeThisAbstractMethod($methodName)
	{

		$this->_debug("Implementation Error.\n".
			"Calling abstract method '$methodName'\n".
			"in '".$this->serviceName ."'\n".
			"This method must be overridden in child of
			".$this->serviceName ."'s class definition", 
			"Method called from object of class: ".get_class($this),0);
	}
}



if (isset($_REQUEST['test']))
{
	$serviceFile = basename($_SERVER['PHP_SELF']);

	if (basename($serviceFile) == "BaseWebServiceObject.php")
	{
		$webObject = new BaseWebServiceObject();
		$webObject->test();
	}
}

?>
