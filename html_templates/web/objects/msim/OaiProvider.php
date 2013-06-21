<?php
/*
** Copyright (c) 2005 - Ke Software Pty Ltd
*/

/*
** OAI-PHM Provider for Msim
*/

//$ENABLE = 0;
$ENABLE = 1;
if ($ENABLE != 1)
{
	die;
}

ini_set("max_execution_time", "600");

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/common/OaiProvider.php');
require_once($WEB_ROOT . '/objects/common/OaiHandlers.php');

class
MsimOaiDcHandler extends OaiDcHandler
{
	function
	getRestriction()
	{
		/* Restrict record subset to Ferranti records */
		return "ColParentRecordRef=1498";
	}
	
	function
	getSelectArray()
	{
		return array(
			"irn_1",
			"AdmDateModified",
			"ColRegNumber",
			"ClaObjectName",
			"ClaObjectSummary",
			"SubSubjects_tab",
			"ColTypeOfItem",
			"AssAssociationType_tab",
			"AssAssociationNameLocal_tab",
			"MulMultiMediaRef_tab",
			"MulMultiMediaRef_tab->emultimedia->MulMimeType",
		);
	}

	function
	formMainXml(&$record)
	{	
		$string = "";
		$tableader = "       ";
		
		/* Identifier */
		$value = "http://emu.msim.org.uk/collections/online/display.php?irn=" . $record->{"irn_1"};
		$string .= $tableader . "<dc:identifier>$value</dc:identifier>\n";

		/* Title */
		if (!empty($record->{"ClaObjectName"}))
		{       
			$value = htmlspecialchars(utf8_encode($record->{"ClaObjectName"}));
			$string .= $tableader . "<dc:title>$value</dc:title>\n";
		}

		/* Description */
		$desc = $record->{"ClaObjectSummary"};
		if (!empty($desc))
		{
			$value = htmlspecialchars(utf8_encode($desc));
			$string .=  $tableader .  "<dc:description>$value</dc:description>\n";
		}

		/* Subject (agent) */
		$agents = array();
		for ($i=1; !empty($record->{"AssAssociationType:$i"}); $i++)
		{
			if (!preg_match("/subject/i", $record->{"AssAssociationType:$i"}))
				next;
			$value = htmlspecialchars(utf8_encode($record->{"AssAssociationNameLocal:$i"}));
			if (!empty($value))
				array_push($agents, $value);
		}
		foreach ($agents as $agent)
		{
			$string .= $tableader."<dc:subject>$agent</dc:subject>";
		}

		/* Creator */
		$creators = array();
		for ($i=1; !empty($record->{"AssAssociationType:$i"}); $i++)
		{
			if (!preg_match("/maker/i", $record->{"AssAssociationType:$i"}))
				next;
			$value = htmlspecialchars(utf8_encode($record->{"AssAssociationNameLocal:$i"}));
			if (!empty($value))
				array_push($creators, $value);
		}
		foreach ($creators as $creator)
		{
			$string .= $tableader."<dc:creator>$creator</dc:creator>";
		}

		/* Rights */
		$string .= $tableader . "<dc:rights>Rights Holder: The Museum of Science and Industry in Manchester</dc:rights>\n";
		$string .= $tableader . "<dc:rights>Metadata made available under: http://creativecommons.org/licenses/by-nc-sa/2.5/</dc:rights>\n";

		/* Relation : IsPartOf */
		$string .= $tableader . "<dc:relation>http://www.msim.org.uk/</dc:relation>\n";

		/* Relation : Thumbnail */
		if (preg_match("/image/i", $record->{"MulMultiMediaRef:1->emultimedia->MulMimeType"}))
		{
			/* hard-coded url to webmedia.php */
			$string .= $tableader . "<dc:relation>".
				"http://82.138.231.51/web/objects/common/webmedia.php?thumb=yes&amp;irn=".
				$record->{"MulMultiMediaRef:1"} . "</dc:relation>\n";
		}		

		/* Spatial */
		$spatials = array();
		for ($i=1; !empty($record->{"AssAssociationType:$i"}); $i++)
		{
			if (!preg_match("/town/i", $record->{"AssAssociationType:$i"}) &&
		       		!preg_match("/city/i", $record->{"AssAssociationType:$i"}))
			{
				next;
			}
			$value = htmlspecialchars(utf8_encode($record->{"AssAssociationNameLocal:$i"}));
			if (!empty($value))
				array_push($spatials, $value);
		}
		foreach ($spatials as $spatial)
		{
			$string .= $tableader."<dc:coverage>$spatial</dc:coverage>";
		}

		return $string;
	}

			
}

class
MsimPndsDcHandler extends PndsDcHandler
{
	function
	getRestriction()
	{
		/* Restrict record subset to Ferranti records */
		return "ColParentRecordRef=1498";
	}
	
	function
	getSelectArray()
	{
		return array(
			"irn_1",
			"AdmDateModified",
			"ColRegNumber",
			"ClaObjectName",
			"ClaObjectSummary",
			"SubSubjects_tab",
			"ColTypeOfItem",
			"AssAssociationType_tab",
			"AssAssociationNameLocal_tab",
			"MulMultiMediaRef_tab",
			"MulMultiMediaRef_tab->emultimedia->MulMimeType",
		);
	}

	function
	formMainXml(&$record)
	{	
		$string = "";
		$tableader = "       ";
		
		/* Identifier */
		$value = "http://emu.msim.org.uk/collections/online/display.php?irn=" . $record->{"irn_1"};
		$string .= $tableader . "<dc:identifier encSchemeURI=\"http://purl.org/dc/terms/URI\">$value</dc:identifier>\n";

		/* Title */
		if (!empty($record->{"ClaObjectName"}))
		{       
			$value = htmlspecialchars(utf8_encode($record->{"ClaObjectName"}));
			$string .= $tableader . "<dc:title>$value</dc:title>\n";
		}

		/* Description */
		$desc = $record->{"ClaObjectSummary"};
		if (!empty($desc))
		{
			$value = htmlspecialchars(utf8_encode($desc));
			$string .=  $tableader .  "<dc:description>$value</dc:description>\n";
		}

		/* Subject (agent) */
		$agents = array();
		for ($i=1; !empty($record->{"AssAssociationType:$i"}); $i++)
		{
			if (!preg_match("/subject/i", $record->{"AssAssociationType:$i"}))
				next;
			$value = htmlspecialchars(utf8_encode($record->{"AssAssociationNameLocal:$i"}));
			if (!empty($value))
				array_push($agents, $value);
		}
		foreach ($agents as $agent)
		{
			$string .= $tableader."<dc:subject encSchemeURI=\"http://purl.org/mla/pnds/terms/Agent\">$agent</dc:subject>";
		}

		/* Creator */
		$creators = array();
		for ($i=1; !empty($record->{"AssAssociationType:$i"}); $i++)
		{
			if (!preg_match("/maker/i", $record->{"AssAssociationType:$i"}))
				next;
			$value = htmlspecialchars(utf8_encode($record->{"AssAssociationNameLocal:$i"}));
			if (!empty($value))
				array_push($creators, $value);
		}
		foreach ($creators as $creator)
		{
			$string .= $tableader."<dc:creator>$creator</dc:creator>";
		}

		/* Rights */
		$string .= $tableader . "<dcterms:rightsHolder>The Museum of Science and Industry in Manchester</dcterms:rightsHolder>\n";
		$string .= $tableader . "<dcterms:licence valueURI=\"http://creativecommons.org/licenses/by-nc-sa/2.5/\" />\n\n";

		/* Relation : IsPartOf */
		$string .= $tableader . "<dcterms:isPartOf valueURI=\"http://www.msim.org.uk/\" />\n";

		/* Relation : Thumbnail */
		if (preg_match("/image/i", $record->{"MulMultiMediaRef:1->emultimedia->MulMimeType"}))
		{
			/* hard-coded url to webmedia.php */
			$string .= $tableader . "<pndsterms:thumbnail valueURI=\"".
				"http://82.138.231.51/web/objects/common/webmedia.php?thumb=yes&amp;irn=".
				$record->{"MulMultiMediaRef:1"} . "\" />\n";
		}		

		/* Spatial */
		$spatials = array();
		for ($i=1; !empty($record->{"AssAssociationType:$i"}); $i++)
		{
			if (!preg_match("/town/i", $record->{"AssAssociationType:$i"}) &&
		       		!preg_match("/city/i", $record->{"AssAssociationType:$i"}))
			{
				next;
			}
			$value = htmlspecialchars(utf8_encode($record->{"AssAssociationNameLocal:$i"}));
			if (!empty($value))
				array_push($spatials, $value);
		}
		foreach ($spatials as $spatial)
		{
			$string .= $tableader."<dcterms:spatial>$spatial</dcterms:spatial>";
		}

		return $string;
	}
}

$provider = New OaiProvider();
$provider->RepositoryName = "The Museum of Science and Industry KE EMu OAI-PHM Provider";
$provider->AdminEmail = "alex.fell@kesoftware.com";
$provider->EarliestDatestamp = "2001-01-01";

$msimDcHandler = new MsimOaiDcHandler();
$msimPndsHandler = new MsimPndsDcHandler();

$provider->AddHandler($msimDcHandler);
$provider->AddHandler($msimPndsHandler);

$provider->ProcessRequest();
?>
