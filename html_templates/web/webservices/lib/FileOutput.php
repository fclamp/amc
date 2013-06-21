<?php
/*
**  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once($WEB_ROOT . '/objects/lib/webinit.php');

class FileOutput
{
	/* PROPERTIES */

	var $_outputDir;
	var $_outputFiles = array();
	var $_cleanupFiles = array();
	var $_outputFileHandle;
        var $_maxFileSize = 2147418112;
	var $_errors = array();
	var $_readLength = 8192;

	function 
	FileOutput($outputDir=null)
	{
		if (! isset($outputDir))
		{
			global $WEB_ROOT;
			$baseName = basename($_SERVER['PHP_SELF'], '.php');
			$outputDir = "$WEB_ROOT/tmp/$baseName";
		}
		$this->_outputDir = $outputDir;
		register_shutdown_function(array(&$this, 'CLEANUP'));
	}

	function 
	CLEANUP()
	{
		$status = true;

		if (isset($this->_outputFileHandle))
		{
			fflush($this->_outputFileHandle);
			fclose($this->_outputFileHandle);
		}

		clearstatcache();
		foreach ($this->_cleanupFiles as $file)
		{
			if (is_file($file) && ! unlink($file))
				$status = false;
		}
		$this->_cleanupFiles = array();
		return $status;
	}

	########################
	### PUBLIC FUNCTIONS ###
	########################

        function
        write($mixed, $file=false)
        {
		$status = true;

		if (! isset($this->_outputFileHandle))
		{
			if ($this->_open() === false)
				return false;
		}

		if (! is_array($mixed))
			$mixed = array($mixed);

		if ($file === true)
		{
			$resources = array();
			clearstatcache();
			foreach ($mixed as $file)
			{
				if (! is_file($file) || ! is_readable($file))
				{
					$mesg = "file $file does not exist or cannot be read from";
					return $this->_setError($mesg, __LINE__);
				}
				if (($fileHandle = fopen($file, 'rb')) === false)
				{
					$mesg = "could not open file $file for reading";
					return $this->_setError($mesg, __LINE__);
				}
				$resources[] =& $fileHandle;
			}
			$mixed = $resources;
		}


                if (flock($this->_outputFileHandle, LOCK_EX) === false)
		{
			$mesg = 'could not lock output file';
			return $this->_setError($mesg, __LINE__);
		}

		foreach ($mixed as $output)
		{
			if (is_string($output))
			{
				$status = $this->_writeString($output);
			}
			else if (is_resource($output) && get_resource_type($output) == 'stream')
			{
				$status = $this->_writeResource($output);
			}
			else
			{
				$status = false;
				$mesg = "unknown output type \"$output\"";
				$this->_setError($mesg, __LINE__);
				break;
			}
		}

                if (flock($this->_outputFileHandle, LOCK_UN) === false)
		{
			$mesg = 'could not release lock on output file';
			return $this->_setError($mesg, __LINE__);
		}

		if ($file === true)
		{
			foreach ($mixed as $fileHandle)
			{
				if (fclose($fileHandle) === false)
				{
					$mesg = 'could not close file';
					return $this->_setError($mesg, __LINE__);
				}
			}
		}

		if ($status === false)
			return false;
		return $this->_outputFiles;
	}

        function
        finish()
        {
		if (isset($this->_outputFileHandle))
		{
			fflush($this->_outputFileHandle);
			if (fclose($this->_outputFileHandle) === false)
			{
				$mesg = 'could not close output file';
				return $this->_setError($mesg, __LINE__);
			}
			$this->_outputFileHandle = null;
		}

		$this->_errors = array();
		$outputFiles = $this->_outputFiles;
		$this->_outputFiles = array();
		return $outputFiles;
	}

	function 
	getErrors()
	{
		if (empty($this->_errors))
			return false;
		return $this->_errors;
	}

	function 
	setReadLength($length)
	{
		$this->_readLength = $length;
	}


	#########################
	### PRIVATE FUNCTIONS ###
	#########################

        function
        _open()
        {
		if (isset($this->_outputFileHandle))
		{
			if (fseek($this->_outputFileHandle, 0, SEEK_END) != 0)
			{
				$mesg = 'could not seek to end of output file';
				return $this->_setError($mesg, __LINE__);
			}

			if (($size = ftell($this->_outputFileHandle)) === false)
			{
				$mesg = 'could not determine size of output file';
				return $this->_setError($mesg, __LINE__);
			}

			### IF WE STILL HAVE ROOM IN THE CURRENT OUTPUT FILE JUST RETURN
			if ($size < $this->_maxFileSize)
				return true;
			
			fflush($this->_outputFileHandle);
			if (fclose($this->_outputFileHandle) === false)
			{
				$mesg = 'could not close output file';
				return $this->_setError($mesg, __LINE__);
			}
		}

		if (! is_dir($this->_outputDir))
		{
			if (! mkdir($this->_outputDir, 0777))
			{
				$mesg = 'could not close output file';
				return $this->_setError($mesg, __LINE__);
			}
			chmod($this->_outputDir, 0777);
		}

		$fileName = tempnam($this->_outputDir, 'FileOutput_');
		if (($fileHandle = fopen($fileName, 'wb')) === false)
		{
			$mesg = 'could not open output file';
			return $this->_setError($mesg, __LINE__);
		}

		$this->_outputFileHandle = $fileHandle;
		$this->_outputFiles[] = $this->_cleanupFiles[] = $fileName;
		return true;
	}

        function
        _writeString(&$string)
        {
		$start = 0;
		$length = $this->_readLength;

		### DETERMINE CURRENT OUTPUT FILE SIZE
		if (fseek($this->_outputFileHandle, 0, SEEK_END) != 0)
		{
			$mesg = 'could not seek to end of output file';
			return $this->_setError($mesg, __LINE__);
		}

		if (($fileSize = ftell($this->_outputFileHandle)) === false)
		{
			$mesg = 'could not determine size of output file';
			return $this->_setError($mesg, __LINE__);
		}

		### DO NOT GET MORE THAN THE REMAINING SPACE IN THE OUTPUT FILE
		$outputRemaining = $this->_maxFileSize - $fileSize;
		if ($outputRemaining > 0 && $outputRemaining < $length)
			$length = $outputRemaining;

		### READ
                while (($output = substr($string, $start, $length)) !== false)
                {
			### FIGURE OUT HOW MUCH WE ACTUALLY READ
			$length = strlen($output);

			### IF THE NEXT WRITE IS GOING TO TAKE US OVER THE MAXIMUM OUTPUT FILE
			### SIZE THEN OPEN A FILE HANDLE TO A NEW OUTPUT FILE
			if (($fileSize + $length) > $this->_maxFileSize)
			{
				if ($this->_open() === false)
					return false;
				$fileSize = 0;
			}

			### WRITE
			if (($bytesWritten = fwrite($this->_outputFileHandle, $output)) === false)
			{
				$mesg = 'could not write to output file';
				return $this->_setError($mesg, __LINE__);
			}

			$fileSize += $bytesWritten;
			$start += $length;
			$length = $this->_readLength;

			### DO NOT GET MORE THAN THE REMAINING SPACE IN THE OUTPUT FILE
			$outputRemaining = $this->_maxFileSize - $fileSize;
			if ($outputRemaining > 0 && $outputRemaining < $length)
				$length = $outputRemaining;
                }
		return true;
	}

        function
        _writeResource($resource)
        {
		$readSize = $this->_readLength;

		### DETERMINE CURRENT OUTPUT FILE SIZE
		if (fseek($this->_outputFileHandle, 0, SEEK_END) != 0)
		{
			$mesg = 'could not seek to end of output file';
			return $this->_setError($mesg, __LINE__);
		}
		
		if (($fileSize = ftell($this->_outputFileHandle)) === false)
		{
			$mesg = 'could not determine size of output file';
			return $this->_setError($mesg, __LINE__);
		}

		while (! feof($resource))
		{
			### DO NOT READ MORE THAN THE REMAINING SPACE IN THE OUTPUT FILE
			$outputRemaining = $this->_maxFileSize - $fileSize;
			if ($outputRemaining > 0 && $outputRemaining < $readSize)
				$readSize = $outputRemaining;

			### READ
			if (($output = fread($resource, $readSize)) === false)
			{
				$mesg = 'could not read resource data';
				return $this->_setError($mesg, __LINE__);
			}

			### FIGURE OUT HOW MUCH WE ACTUALLY READ
			$readSize = strlen($output);
			    
			### IF THE NEXT WRITE IS GOING TO TAKE US OVER THE MAXIMUM OUTPUT FILE
			### SIZE THEN OPEN A FILE HANDLE TO A NEW OUTPUT FILE
			if (($fileSize + $readSize) > $this->_maxFileSize)
			{
				if ($this->_open() === false)
					return false;
				$fileSize = 0;
			}

			### WRITE
			if (($bytesWritten = fwrite($this->_outputFileHandle, $output)) === false)
			{
				$mesg = 'could not write to output file';
				return $this->_setError($mesg, __LINE__);
			}

			$fileSize += $bytesWritten;
			$readSize = $this->_readLength;
		}
                return true;
        }

	function 
	_setError($message, $line)
	{
		$this->_errors[] = $message . ' [' . __FILE__ . ' on line ' . $line . ']';
		return false;
	}
}
?>
