<?php
/*
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');

if (function_exists("date_default_timezone_set"))
{
	        date_default_timezone_set('America/New_York');
}

/*
** Logging Class
*/
class Logger
{
	/*** PROPERTIES ***/

	var $_logDir;
	var $_logFilePath;
	var $_logFileHandle;

	var $_errors = array();


	/*** PUBLIC METHODS ***/

	function 
	Logger($logDir, $logName, $instance)
	{
		if (! preg_match('/\.log$/', $logName))
			$logName = $logName . '.log';
		
		$this->_logDir = $logDir;
		$this->_logFilePath = "$logDir/$logName";	
		$this->_instance = $instance;
	}

	###
	### WRITE A MESSAGE TO THE LOG FILE
	###
	function 
	log(&$message)
	{
		$status = true;

		if ($this->_openLog() === false)
			return false;

		$header = date('Y-m-d H:i:s');
		$header .= ' - ' . $this->_instance;
		$header .= ' - ' . $_SERVER['REMOTE_ADDR'];
		$footer = "\n";

		###
		### OBTAIN LOCK ON LOG FILE
		###
		if (flock($this->_logFileHandle, LOCK_EX) === false)
		{
			$mesg = "could not obtain lock on file {$this->_logFilePath}";
			return $this->_setError($mesg, __FUNCTION__, __LINE__);
		}

		###
		### SEEK TO END OF LOG FILE
		###
		if (fseek($this->_logFileHandle, 0, SEEK_END) != 0)
		{
			$mesg = "could not seek to end of file {$this->_logFilePath}";
			return $this->_setError($mesg, __FUNCTION__, __LINE__);
		}

		foreach (array($header, ' - ', &$message, $footer) as $output)
		{
			if (($status = $this->_writeString($output)) === false)
				break;
		}

		###
		### RELEASE LOCK ON LOG FILE
		###
		if (flock($this->_logFileHandle, LOCK_UN) === false)
		{
			$mesg = "could not release lock on file {$this->_logFilePath}";
			return $this->_setError($mesg, __FUNCTION__, __LINE__);
		}
		return $status;
	}

	###
	### WRITE A FILE TO THE LOG FILE
	###
	function 
	logFiles($files, $message=null)
	{
		$status = true;

		if ($this->_openLog() === false)
			return false;

		if (! is_array($files))
			$files = array($files);

		clearstatcache();
		foreach ($files as $file)
		{
			if (! is_file($file))
			{
				$mesg = "file $file does not exist";
				return $this->_setError($mesg, __FUNCTION__, __LINE__);
			}
		}

		$output = date('Y-m-d H:i:s');
		$output .= ' - ' . $this->_instance;
		$output .= ' - ' . $_SERVER['REMOTE_ADDR'];
		if (isset($message))
			$output .= ' - ' . $message;
		$output .= "\n";

		###
		### OBTAIN LOCK ON LOG FILE
		###
		if (flock($this->_logFileHandle, LOCK_EX) === false)
		{
			$mesg = "could not obtain lock on file {$this->_logFilePath}";
			return $this->_setError($mesg, __FUNCTION__, __LINE__);
		}

		###
		### SEEK TO END OF LOG FILE
		###
		if (fseek($this->_logFileHandle, 0, SEEK_END) != 0)
		{
			$mesg = "could not seek to end of file {$this->_logFilePath}";
			return $this->_setError($mesg, __FUNCTION__, __LINE__);
		}

		###
		### WRITE INITIAL OUTPUT TO LOG FILE AND IF SUCCESSFUL THEN WRITE FILE TO LOG FILE
		###
		if (($status = $this->_writeString($output)) !== false)
		{
			foreach ($files as $file)
			{
				###
				### OPEN THE FILE TO WRITE OUT FROM
				###
				if (($fileHandle = fopen($file, 'rb')) === false)
				{
					$mesg = "could not open file $file";
					$this->_setError($mesg, __FUNCTION__, __LINE__);
					$status = false;
					break;
				}

                		while (! feof($fileHandle))
                		{
					###
					### READ FROM THE FILE
					###
                		        if (($output = fread($fileHandle, 8192)) === false)
					{
						$mesg = "could not read from file $file";
						$this->_setError($mesg, __FUNCTION__, __LINE__);
						$status = false;
						break;
                		        }

					###
					### WRITE TO THE LOG. IF THIS FAILS DONT RETURN IMMEDIATELY AS WE WANT TO TRY TO RELEASE 
					### THE LOCK ON THE LOG FILE AND CLOSE THE FILE WE ARE WRITING TO THE LOG FILE
					###
                			if (fwrite($this->_logFileHandle, $output) === false)
					{
						$mesg = "could not write to log file $this->_logFilePath";
						$status = $this->_setError($mesg, __FUNCTION__, __LINE__);
						break;
                			}
                		}

				###
				### CLOSE THE FILE WE ARE WRITING TO THE LOG FILE
				###
				if (fclose($fileHandle) === false)
				{
					$mesg = "could not close file $file";
					$this->_setError($mesg, __FUNCTION__, __LINE__);
					$status = false;
					break;
				}

				if ($status === false)
					break;
			}
		}

		###
		### RELEASE LOCK ON LOG FILE
		###
		if (flock($this->_logFileHandle, LOCK_UN) === false)
		{
			$mesg = "could not release lock on file {$this->_logFilePath}";
			return $this->_setError($mesg, __FUNCTION__, __LINE__);
		}

		return $status;
	}

	function 
	getErrors()
	{
		if (isset($this->_errors))
			return $this->_errors;
		return false;
	}

	/*** PRIVATE METHODS ***/

	function 
	_openLog()
	{
		if (isset($this->_logFileHandle))
			return true;

		if (! isset($this->_logDir) || 
		    ! isset($this->_logFilePath) || 
		    ! isset($this->_instance))
		{
			$mesg = 'bad logging setup';
			$this->_setError($mesg, __FUNCTION__, __LINE__);
			return false;
		}

		if (! is_dir($this->_logDir))
		{
			if (! mkdir($this->_logDir, 0777))
			{
				$mesg = "could not create log directory $this->_logDir";
				$this->_setError($mesg, __FUNCTION__, __LINE__);
				return false;
			}
			chmod($this->_logDir, 0777);
		}

		if (($fileHandle = fopen($this->_logFilePath, 'ab')) === false)
		{
			$mesg = "could not open log file $this->_logFilePath for writing";
			$this->_setError($mesg, __FUNCTION__, __LINE__);
			return false;
		}

		$this->_logFileHandle = $fileHandle;
		return true;

	}

	function 
	_writeString(&$output)
	{
		$start = 0;
		$length = 8192;

		while (($currentOutput = substr($output, $start, $length)) !== false)
		{
                	if (fwrite($this->_logFileHandle, $currentOutput) === false)
			{
				$mesg = "could not write to log file $this->_logFilePath";
				return $this->_setError($mesg, __FUNCTION__, __LINE__);
                	}
			$start += $length;
		}
		return true;
	}

	function 
	_setError($message, $function, $line)
	{
		$this->_errors[] = $message . ' [' . __FILE__ . ' : ' . $function . ' : ' . $line . ']';
		return false;
	}
}
