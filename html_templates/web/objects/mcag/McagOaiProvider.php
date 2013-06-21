<?php
/*
** Copyright (c) 2005 - Ke Software Pty Ltd
*/

/*
** OAI-PHM Provider for Mcag
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
McagOaiDcHandler extends OaiDcHandler
{
	function
	getSelectArray()
	{
		return array(
			"irn_1",
			"AdmDateModified",
			"TitObjectName",
			"TitMainTitle",
			"CreCreatorLocal_tab",
			"TitCollectionGroup_tab",
			"PhyDescription",
			"TitAccessionNo",
			"CreCreationPlaceSummary_tab",
			"CreSubjectClassification_tab",
			"CreDateCreated",
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
		/*if (!empty($record->{"TitAccessionNo"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitAccessionNo"}));
			$string .= $tableader . "<dc:identifier>$value</dc:identifier>\n";
		}*/
		/* Changed as result of discussion with PNDS */
		$value = "http://www.manchestergalleries.org.uk/the-collections/search-the-collection/display.php?irn=" . $record->{"irn_1"};
		$string .= $tableader . "<dc:identifier>$value</dc:identifier>\n";

		/* Title */
		if (!empty($record->{"TitMainTitle"}))
		{       
			$value = htmlspecialchars(utf8_encode($record->{"TitMainTitle"}));
			$string .= $tableader . "<dc:title>$value</dc:title>\n";
		}
		elseif (!empty($record->{"TitObjectName"}))
		{
			$value = $record->{"TitObjectName"};
			$value = htmlspecialchars(utf8_encode($value));
			$string .= $tableader . "<dc:title>$value</dc:title>\n";
		}

		/* Creator */
		for ($i=1; !empty($record->{"CreCreatorLocal:$i"}); $i++)
		{
			$value = htmlspecialchars(utf8_encode($record->{"CreCreatorLocal:$i"}));
			$string .= $tableader . "<dc:creator>$value</dc:creator>\n";
		}

		/* Subject */
		if (!empty($record->{"TitMainTitle"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitMainTitle"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}
		if (!empty($record->{"TitObjectName"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitObjectName"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}
		for ($i=1; !empty($record->{"TitCollectionGroup:$i"}); $i++)
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitCollectionGroup:$i"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}
		for ($i=1; !empty($record->{"CreSubjectClassification:$i"}); $i++)
		{
			$value = htmlspecialchars(utf8_encode($record->{"CreSubjectClassification:$i"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}

		/* Type */
		$string .= $tableader . "<dc:type>PhysicalObject</dc:type>\n";

		/* Rights */
		$string .= $tableader . "<dc:rights>Rights Holder: Manchester City Galleries</dc:rights>\n";
		$string .= $tableader . "<dc:rights>Metadata made available under: http://creativecommons.org/licenses/by-nc-sa/2.5/</dc:rights>\n";

		/* Description */
		$desc = $record->{"PhyDescription"};
		if (preg_match("/Public:\s*(.*?)(Private:|$)/", $desc, $matches))
		{
			$public = $matches[1];
			$value = htmlspecialchars(utf8_encode($public));
			$string .=  $tableader .  "<dc:description>$value</dc:description>\n";
		}
		
		/* Date */
		if (!empty($record->{"CreDateCreated"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"CreDateCreated"}));
			$string .= $tableader . "<dc:date>$value</dc:date>\n";
		}

		/* Publisher */
		$string .= "<dc:publisher>Manchester City Galleries</dc:publisher>\n";

		/* Contributor */
		for ($i=1; $i<21; $i++)
		{
			$relation = $record->{"AssRelatedPartiesRelationship:$i"};
			if (preg_match("/contributor/i", $relation))
			{
				$value = $record->{"AssRelatedPartiesRef:$i->eparties->SummaryData"};
				$value = htmlspecialchars(utf8_encode($value));
				$string .= $tableader . "<dc:contributor>$value</dc:contributor>\n";
			}
		}

		/* Language */
		$string .= $tableader . "<dc:language>en-GB</dc:language>\n";

		/* Relation */
		// NB: Changed from Vincent's document after reading the PNS spec.
		/*for ($i=1; !empty($record->{"AssRelatedObjectsRef:$i"}); $i++)
		{
			$value = $record->{"AssRelatedObjectsRef:$i->ecatalogue->SummaryData"};
			if (!empty($value))
			{
				$value = htmlspecialchars(utf8_encode($value));
				$string .= $tableader . "<dc:relation>$value</dc:relation>\n";
			}
		}*/
		/* Relation : IsPartOf */
		$string .= $tableader . "<dc:relation>http://www.manchestergalleries.org.uk/</dc:relation>\n";

		/* Relation : Thumbnail */
		if (preg_match("/image/i", $record->{"MulMultiMediaRef:1->emultimedia->MulMimeType"}))
		{
			/* hard-coded url to webmedia.php */
			$string .= $tableader . "<dc:relation>".
				"http://www.manchestergalleries.org.uk/the-collections/search-the-collection/mcgweb/objects/common/webmedia.php?thumb=yes&amp;irn=".
				$record->{"MulMultiMediaRef:1"} . "</dc:relation>\n";
		}		

		/* Coverage */
		for ($i=1; !empty($record->{"CreCreationPlaceSummary:$i"}); $i++)
		{
			$value = $record->{"CreCreationPlaceSummary:$i"};
			$value = htmlspecialchars(utf8_encode($value));
			$string .= $tableader . "<dc:coverage>$value</dc:coverage>\n";
		}

		return $string;
	}

			
}

class
McagPndsDcHandler extends PndsDcHandler
{
	function
	getSelectArray()
	{
		return array(
			"irn_1",
			"AdmDateModified",
			"TitObjectName",
			"TitMainTitle",
			"CreCreatorLocal_tab",
			"TitCollectionGroup_tab",
			"PhyDescription",
			"TitAccessionNo",
			"CreCreationPlaceSummary_tab",
			"CreSubjectClassification_tab",
			"CreDateCreated",
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
		/* if (!empty($record->{"TitAccessionNo"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitAccessionNo"}));
			$string .= $tableader . "<dc:identifier>$value</dc:identifier>\n";
		}*/
		$value = "http://www.manchestergalleries.org.uk/the-collections/search-the-collection/display.php?irn=" . $record->{"irn_1"};
		$string .= $tableader . "<dc:identifier encSchemeURI=\"http://purl.org/dc/terms/URI\">$value</dc:identifier>\n";
		
		/* Title */
		if (!empty($record->{"TitMainTitle"}))
		{       
			$value = htmlspecialchars(utf8_encode($record->{"TitMainTitle"}));
			$string .= $tableader . "<dc:title>$value</dc:title>\n";
		}
		elseif (!empty($record->{"TitObjectName"}))
		{
			$value = $record->{"TitObjectName"};
			$value = htmlspecialchars(utf8_encode($value));
			$string .= $tableader . "<dc:title>$value</dc:title>\n";
		}

		/* Description */
		$desc = $record->{"PhyDescription"};
		if (preg_match("/Public:\s*(.*?)(Private:|$)/", $desc, $matches))
		{
			$public = $matches[1];
			$value = htmlspecialchars(utf8_encode($public));
			$string .=  $tableader .  "<dc:description>$value</dc:description>\n";
		}
		elseif (!preg_match("/Private/", $desc))
		{
			$value = htmlspecialchars(utf8_encode($desc));
			$string .=  $tableader .  "<dc:description>$value</dc:description>\n";
		}
			


		/* Subject */
		if (!empty($record->{"TitMainTitle"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitMainTitle"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}
		if (!empty($record->{"TitObjectName"}))
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitObjectName"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}
		for ($i=1; !empty($record->{"TitCollectionGroup:$i"}); $i++)
		{
			$value = htmlspecialchars(utf8_encode($record->{"TitCollectionGroup:$i"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}
		for ($i=1; !empty($record->{"CreSubjectClassification:$i"}); $i++)
		{
			$value = htmlspecialchars(utf8_encode($record->{"CreSubjectClassification:$i"}));
			$string .= $tableader."<dc:subject>$value</dc:subject>\n";
		}

		/* Creator */
		for ($i=1; !empty($record->{"CreCreatorLocal:$i"}); $i++)
		{
			$value = htmlspecialchars(utf8_encode($record->{"CreCreatorLocal:$i"}));
			$string .= $tableader . "<dc:creator>$value</dc:creator>\n";
		}

		/* Contributor */
		for ($i=1; $i<21; $i++)
		{
			$relation = $record->{"AssRelatedPartiesRelationship:$i"};
			if (preg_match("/contributor/i", $relation))
			{
				$value = $record->{"AssRelatedPartiesRef:$i->eparties->SummaryData"};
				$value = htmlspecialchars(utf8_encode($value));
				$string .= $tableader . "<dc:contributor>$value</dc:contributor>\n";
			}
		}

		/* Publisher */
		$string .= "<dc:publisher>Manchester City Galleries</dc:publisher>\n";

		/* Language */
		$string .= $tableader . "<dc:language encSchemeURI=\"http://purl.org/dc/terms/RFC3066\">en-GB</dc:language>\n";

		/* Coverage */
		for ($i=1; !empty($record->{"CreCreationPlaceSummary:$i"}); $i++)
		{
			$value = $record->{"CreCreationPlaceSummary:$i"};
			$value = htmlspecialchars(utf8_encode($value));
			$string .= $tableader . "<dcterms:spatial>$value</dcterms:spatial>\n";
		}

		/* Type */
		$string .= $tableader . '<dc:type encSchemeURI="http://purl.org/dc/terms/DCMIType">'.
			"PhysicalObject</dc:type>\n";

		/* Relation : IsPartOf */
		$string .= $tableader . "<dcterms:isPartOf valueURI=\"".
			"http://www.manchestergalleries.org.uk/\" />\n";

		/* Relation : Thumbnail */
		if (preg_match("/image/i", $record->{"MulMultiMediaRef:1->emultimedia->MulMimeType"}))
		{
			/* hard-coded url to webmedia.php */
			$string .= $tableader . "<pndsterms:thumbnail valueURI=\"".
				"http://www.manchestergalleries.org.uk/the-collections/search-the-collection/mcgweb/objects/common/webmedia.php?thumb=yes&amp;irn=".
				$record->{"MulMultiMediaRef:1"} . "\" />\n";
		}	

		/* Licence */
		$string .= $tableader . "<dcterms:licence valueURI=\"http://creativecommons.org/licenses/by-nc-sa/2.5/\" />\n";
		/* Rights Holder */
		$string .= $tableader . "<dcterms:rightsHolder>Manchester City Galleries</dcterms:rightsHolder>\n";

		return $string;
	}

			
}

$provider = New OaiProvider();
$provider->RepositoryName = "Manchester City Galleries KE EMu OAI-PHM Provider";
$provider->AdminEmail = "alex.fell@kesoftware.com";
$provider->EarliestDatestamp = "2000-01-01";

$mcagDcHandler = new McagOaiDcHandler();
$mcagPndsHandler = new McagPndsDcHandler();

$provider->AddHandler($mcagDcHandler);
$provider->AddHandler($mcagPndsHandler);

$provider->ProcessRequest();
?>
