<?php

/**
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package ObjectLocator 
 *
 */

require_once ('objectlocator/config.php');
require_once ($WEB_ROOT . '/objects/lib/' . 'configuredquery.php');
require_once ($WEB_ROOT . '/objects/lib/' . 'common.php');
require_once ($WEB_ROOT . '/objects/lib/' . 'BaseQueryGenerator.php');
require_once ($WEB_ROOT . '/webservices/lib/BaseWebServiceObject.php');

/**
 * Object Locator web service
 *
 * @package ObjectLocator 
 *
 */
class ObjectLocator extends BaseWebServiceObject
{
	var $disableUpdate = True;

	function ObjectLocator($backendType='',$webRoot='',$webDirName='',$debugOn=0)
	{
		// call the parent constructor 
		$this->{get_parent_class(__CLASS__)}($backendType,$webRoot,$webDirName,$debugOn);
		$this->serviceName = "ObjectLocator";
	}

	/**
	 * Query by passing texql to emu web object method and return xml with results
	 *
	 */
	function query($backFields='',$database='',$where='')
	{
		if($where == "")
		{
			$texql = "SELECT $backFields FROM $database";
		}
		else
		{
			$texql = "SELECT $backFields FROM $database WHERE $where";
			$texql = str_replace("\\'Yes\\'", "'Yes'", $texql);
		}

		$this->_log($texql);

		$qry = new Query;
		$qry->PrintXML($texql);
	}
	
	/**
	 * Update by passing texql to emu web object method and return xml with result
	 *
	 */
	function update($updateFields='',$database='',$where='')
	{
		if($this->disableUpdate) 
		{
			$this->printSecurityFailure();
			return;
		}

		$texql = "UPDATE $database SET $updateFields WHERE $where";

		$this->_log($texql);

		$qry = new Query;
		$qry->PrintXML($texql);
	}

	/**
	 * Print security fail message in xml format  
	 *
	 */
	function printSecurityFailure()
	{
		header("Content-Type: text/xml",true);
                print("<response component='". $this->serviceName
	        ."' status='fail'><message>Security for updates has been restricted</message></response>");
	}

	/**
	 * Set weather you can update/insert/delete records or not  
	 *
	 */
	function setSecurityLevel($updateDisable)
	{
		$this->disableUpdate = $updateDisable;
	}
}


/**
 * Query interface to texxmlserver from the java applet - will need to add security 
 * so that not everyone can update the database 
 *
 */  
$select = $ALL_REQUEST['select'];
$database = $ALL_REQUEST['database'];
$where = $ALL_REQUEST['where']; 
$update = $ALL_REQUEST['update'];

$objectLocator = new ObjectLocator();

if($DISABLE_UPDATE == "true")
{
	$objectLocator->setSecurityLevel(True);
}
else
{
	$objectLocator->setSecurityLevel(False);
}

if($update != "")
{
	$objectLocator->update($update, $database, $where);
}
else
{
	$objectLocator->query($select, $database, $where);
}

?>
