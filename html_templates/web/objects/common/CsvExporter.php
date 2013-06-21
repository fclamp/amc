<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'common.php');
require_once($LIB_DIR . 'BaseQueryGenerator.php');
require_once($LIB_DIR . 'serverconnection.php');

/*
**  The CsvExporter will fetch results marked up as a CSV file.
**	It should be placed on a page that also contains a 
**	results list object.
**	
**	The CsvExporter object places an "Export" button on the 
**	page.
*/

class
CsvExporter extends BaseWebObject
{
	var $Database = 'ecatalogue';		// Base table to perform export off
	var $ExportFields = 'SummaryData';	// Magic collist passed to csvexport
	var $ImagePath = '';			// Use an image rather than a form button
	var $ButtonText = '';

	var $Where;
	var $Restriction = '';
	var $ExportPage;

	function
	CsvExporter()
	{
		global $ALL_REQUEST;
		$this->BaseWebObject();
		$this->ExportPage 	= $GLOBALS['CSVEXPORT_URL'];
		$this->Restriction	= $ALL_REQUEST['Restriction'];
	}

	function
	Show()
	{
		$this->sourceStrings();
		
		print '<form name="export" target="_blank" method="post" action="';
		print $this->ExportPage;
		print "\">\n";

		print '<input type="hidden" name="Database" value="';
		print $this->Database;
		print "\" />\n";

		print '<input type="hidden" name="ExportFields" value="';
		print $this->ExportFields;
		print "\" />\n";

		if ($this->Restriction != '')
		{
			print '<input type="hidden" name="Restriction" value="';
			print $this->Restriction;
			print "\" />\n";
		}

		// Note:  Change in future
		$perams = array_merge($GLOBALS['HTTP_POST_VARS'], $GLOBALS['HTTP_GET_VARS']);
		while(list($key, $val) = each($perams))
		{ 
			// Don't pass through empty vars - try to keep url length down
			if ($val == '')
				continue;
			$key = stripslashes($key);
			$val = stripslashes($val);
			print "<input type=\"hidden\" name=\"$key\" value=\"$val\" />\n";
		} 

		// print button
		if ($this->ImagePath != '')
		{
			print '<input type="image" name="Submit" src="';
			print $this->ImagePath;
			print "\" />\n";
		}
		else
		{
			if ($this->ButtonText == '')
				$this->ButtonText= $this->_STRINGS['EXPORT'];
			print '<input type="submit" name="Submit" value="';
			print $this->ButtonText;
			print "\" />\n";
		}

		print '</form>';

		print "\n<!-- end WebObject (CsvExporter) -->\n";
	}
}

?>
