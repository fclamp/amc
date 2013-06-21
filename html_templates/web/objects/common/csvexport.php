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
**  The CsvDataMaker will make up as a CSV file and save it to the server.
**
**  The CsvDataFetcher will fetch the CSV file and push to the browser.
*/

class
CsvDataMaker extends BaseWebObject
{
	var $QueryName;

	var $Database = 'ecatalogue';
	var $ExportFields;		// Magic collist passed to csvexport

	var $Where = '';
	var $Restriction = '';
	var $QueryGenerator = 'BaseQueryGenerator';

	function
	CsvDataMaker()
	{
		global $ALL_REQUEST;
		$this->QueryName 	= $ALL_REQUEST['QueryName'];
		$this->Where		= $ALL_REQUEST['Where'];
		$this->Restriction	= $ALL_REQUEST['Restriction'];
		$this->ExportFields	= $ALL_REQUEST['ExportFields'];

		if (isset($ALL_REQUEST['Database']) && $ALL_REQUEST['Database'] != '')
			$this->Database = $ALL_REQUEST['Database'];

		$this->BaseWebObject();
	}

	function
	Export()
	{
		/*
		** Use the exec feature in texxmlserver to fetch the CSV data
		*/
		$this->sourceStrings();

		// Construct the where clause
		$where = '';
		if (!isset($this->Where) || $this->Where == '')
		{
			if ($this->QueryName == '')
				WebDie('Data submited by query form is invalid.', 'CsvResultsData - Export()');
			$qryGenerator = new $this->QueryGenerator;
			$qryattrib = $qryGenerator->{$this->QueryName}();
			$where = $qryattrib->Where;
		}
		else
			$where = $this->Where;
		if (isset($this->Restriction) && $this->Restriction != '')
			$where = "($where) AND (" . $this->Restriction . ')';

		if ($where == '')
			$where = 'true';

		// Construct command
		//	texcsvexport -c -wwhere collist dbname
		$exec = urlencode('texcsvexport');
		$arg1 = urlencode(stripslashes('-c'));
		$arg2 = urlencode(stripslashes("-w\"$where\""));
		$arg3 = urlencode(stripslashes($this->ExportFields));
		$arg4 = urlencode(stripslashes($this->Database));

		$cmd = "/?exec=$exec";
		$cmd .= "&amp;arg1=$arg1";
		$cmd .= "&amp;arg2=$arg2";
		$cmd .= "&amp;arg3=$arg3";
		$cmd .= "&amp;arg4=$arg4";

		// Open connection to texxmlserver
		$conn = new TexxmlserverConnection;
		$fd = $conn->Open();
		if (!$fd || $fd < 0)
		{
			WebDie('Cannot connect to the KE XML database server.',
				'CsvResultsData - Export()');
		}

		$get = "GET $cmd HTTP/1.0\r\n\r\n";
		fputs($fd, $get);
		fflush($fd);
		socket_set_blocking($fd, FALSE);

		// Now cat the csv output to a temp file
		$tmpfile = tempnam($GLOBALS['REPORT_DIR'], 'webreport');

		// extract report file name
		$matches = array();
		preg_match('/[\/\\\]+([^\/\\\]+)$/', $tmpfile, $matches);
		$reportfile = $matches[1];
		$link = $GLOBALS['PHP_SELF'] . "?ReportFile=$reportfile";

		// start printing HTML activity to keep the user informed 
		// that something is happening and keep the connection alive
		print "<html><body onload=\"javascript:window.location='$link'\">";
		// need to send some null data.  This forces the browser to
		// start rendering.  IE will only render after receiving approx.
		// 1K of data.
		print "                                           \n";
		print "                                           \n";
		print "                                           \n";
		print "                                           \n";
		print "                                           \n";
		print "                                           \n";
		print "                                           \n";
		print "                                           \n";
		print "<p><b>";
		print $this->_STRINGS['EXPORTING_DATA'];
		print "</b></p>";

		if ($GLOBALS['DEBUG'])
                        print "Saving report in: " . $tmpfile;
		flush();

		$tmpfd = fopen($tmpfile, "w");
		$i = 0;
		while (!feof($fd))
		{
			$i++;
			$data = fread($fd, 4096);
			if (strlen($data) == 0)
			{
				print '<span style="background-color: #000080">';
				print '<font color="#000080">##</font></span>&nbsp;';
				if ($i == 20)
				{
					print "<br /><br />\n";
					$i = 0;
				}
				// flush HTML down to browser now
				flush();
				sleep(1);
			}
			else
			{
				fwrite($tmpfd, $data);
			}
		}
		fclose($fd);
		fclose($tmpfd);

		print '<p><b>';
		print $this->_STRINGS['COMPLETE'];
		print '</b></p>';
		print "<p><a href=\"$link\">";
		print $this->_STRINGS['DOWNLOAD_DATA'];
		print '</a></p>';
		print "<p><a href=\"javascript:void()\" onclick=\"javascript:window.close()\">";
		print $this->_STRINGS['CLOSE_WINDOW'];
		print '</a></p>';
		print "</body></html>\n";
	}
}

class
CsvDataFetcher
{
	function
	Fetch()
	{
		global $ALL_REQUEST;
		$file = $GLOBALS['REPORT_DIR'] . "/" . $ALL_REQUEST['ReportFile'];
		if (!file_exists($file))
		{
			WebDie("Can't locate report file.  Please try again.", 'CsvDataFetcher');
		}

		// print header
		header("Content-type: text/plain");
		header("Content-Disposition: attachment; filename=emuresults.csv");

		// Cat File
		$fd = fopen($file, "r");
		while (!feof($fd))
		{
			print fread($fd, 4096);
		}

		// Delete file
		fclose($fd);
		unlink($file);
	}
}


/* 
** MAIN
*/

global $ALL_REQUEST;
if (isset($ALL_REQUEST['ReportFile']) && $ALL_REQUEST['ReportFile'] != '')
{
	$csvfetch = new CsvDataFetcher;
	$csvfetch->Fetch();
}
else
{
	$csvmaker = new CsvDataMaker;
	$csvmaker->Export();
}

?>
