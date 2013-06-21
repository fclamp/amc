<?php
require_once('../web/objects/lib/texquery.php');

$xml = urldecode($_REQUEST['xml']);
//var_dump($xml);

$parser = xml_parser_create("");
xml_parse_into_struct($parser, $xml, $vals, $index);
xml_parser_free($parser);
//print_r($vals);
//print_r($index);

//foreach($vals as $elem)
//{
	//print_r($elem);
	$elem = $vals[0];
	if ($elem['tag'] == "REQUEST")
	{
		//print "REQUEST type. ";
		if ($elem['attributes']['TYPE'] == "all")
		{
			$limit = 30;
			if (isset($elem['attributes']['LIMIT']))
				$limit = $elem['attributes']['LIMIT'];
			return_list($limit);
		}
		if ($elem['attributes']['TYPE'] == "gallery")
		{
			$irn = 0;
			if (isset($elem['attributes']['ID']))
				$irn = $elem['attributes']['ID'];
			return_gallery($irn);
		}
		if ($elem['attributes']['TYPE'] == "story")
		{
			$irn = 0;
			if (isset($elem['attributes']['ID']))
				$irn = $elem['attributes']['ID'];
			return_story($irn);
		}
		if ($elem['attributes']['TYPE'] == "searchfields")
		{
			return_search_fields();
		}
		if ($elem['attributes']['TYPE'] == "search")
		{
			$hrquery = new HrQuery;

			for($i=1; $i<count($vals); $i++)
			{
				if ($vals[$i]['tag'] == "PARAM")
				{
					$type = $vals[$i]['attributes']['ID'];
					$value = $vals[$i]['value'];
					$hrquery->{$type} = $value;
				}
			}
			return_list(0, $hrquery);
		}
	}
//}

function
return_list($limit, $hrqry)
{
	$Order = "AdmDateModified desc, AdmTimeModified desc";
	$Where = "DetNarrativeIdentifier contains '\"Oral History\"'";

	/*
	 * if $hrqry is set we've been asked for a specific set of results, so clear out $Order and form
	 * the texql. Otherwise leave ordered on Date Modified
	 */
	if (isset($hrqry))
	{
		$Order = "";
		if (!empty($hrqry->theme))
		{
			if (!empty($Where))
				$Where .= " AND ";
			$Where .= "DetNarrativeIdentifier contains '\"$hrqry->theme\"'";
		}
		if (!empty($hrqry->name))
		{
			$subwhere = "";
			
			$subqry = new Query;
			$subqry->Select = array("irn_1");
			$subqry->From = "eparties";
			$subqry->Where = "SummaryData contains '\"" . $hrqry->name . "\"'";
			$subqry->All = 1;
			$subqry->Limit = 0;
			$subresults = $subqry->Fetch();
			if (count($subresults) > 0)
			{
				foreach ($subresults as $subresult)
				{
					if (!empty($subwhere))
						$subwhere .= " OR ";
					$subwhere .= "ParPartiesRef=" . $subresult->{"irn_1"};
				}
				
				$subwhere = "exists(ParPartiesRef_tab where $subwhere)";

				if (!empty($Where))
					$Where .= " AND ";
				$Where .= $subwhere;
			}
		}
		if (!empty($hrqry->company))
		{
			$subwhere = "";
			
			$subqry = new Query;
			$subqry->Select = array("irn_1");
			$subqry->From = "eparties";
			$subqry->Where = "SummaryData contains '\"" . $hrqry->company . "\"'";
			$subqry->All = 1;
			$subqry->Limit = 0;
			$subresults = $subqry->Fetch();
			if (count($subresults) > 0)
			{
				foreach ($subresults as $subresult)
				{
					if (!empty($subwhere))
						$subwhere .= " OR ";
					$subwhere .= "ParPartiesRef=" . $subresult->{"irn_1"};
				}
				
				$subwhere = "exists(ParPartiesRef_tab where $subwhere)";

				if (!empty($Where))
					$Where .= " AND ";
				$Where .= $subwhere;
			}
		}
		if (!empty($hrqry->place))
		{
			if (!empty($Where))
				$Where .= " AND ";
			$Where .= "exists(DesGeographicLocation_tab where DesGeographicLocation contains '\"" . 
				$hrqry->place . "\"')";
		}
		if (!empty($hrqry->daterange))
		{
			if (!empty($Where))
				$Where .= " AND ";
			$Where .= "exists(ParPartiesNotes_tab where ParPartiesNotes contains '" . $hrqry->daterange . "')";
		}
		if (!empty($hrqry->date))
		{
			if (preg_match("/(\d\d\d)\d/", $hrqry->date, $matches))
			{
				$date = $matches[1];
				if (!empty($Where))
					$Where .= " AND ";
				$Where .= "exists(ParPartiesNotes_tab where ParPartiesNotes contains '" . $date . "0s')";
			}
		}
		if (!empty($hrqry->keyword))
		{
			if (!empty($Where))
				$Where .= " AND ";
			$Where .= "exists(DesSubjects_tab where DesSubjects contains '\"" . $hrqry->keyword . "\"')";
		}
	}

	$qry = new Query;
	$qry->Select = array(
		"irn_1",
		"AdmDateModified",
		"AdmTimeModified",
		"NarTitle",
		"NarNarrative",
		"MulMultiMediaRef_tab->emultimedia->AdmPublishWebNoPassword"
		);
	$qry->From = "enarratives";
	$qry->Where = $Where;
	$qry->Limit = $limit;
	$qry->Order = $Order;
	$results = $qry->Fetch();
	//print_r($qry);
	
	header("Content-type: text/xml");
	print '<?xml version="1.0" encoding="iso-8859-1"?>' ."\n";
	print "<storylist>\n";

	foreach ($results as $result)
	{
		print '<story id="' . $result->{'irn_1'} . '">' . "\n";

		$caption = substr($result->{"NarNarrative"}, 0, strpos($result->{"NarNarrative"}, ".") + 1);
		$caption = $result->{"NarTitle"};

		print '<caption>' . htmlspecialchars($caption) . "</caption>\n";

		if (isset($result->{"MulMultiMediaRef:1->emultimedia->AdmPublishWebNoPassword"}))
		{
			print '<image>';
			$mediapath = $GLOBALS['MEDIA_URL'] . "?thumb=yes&";
			$mediapath .= "irn=" . $result->{"MulMultiMediaRef:1"};
			print htmlspecialchars($mediapath);
			print "</image>\n";
		}
		print "</story>\n";
	}
	print "</storylist>\n";
}

function
return_gallery($irn)
{
	$qry = new Query;
	$qry->Select = array(
		"MulMultiMediaRef_tab",
	);
	$qry->From = "enarratives";
	$qry->Where = "irn_1=$irn";
	$results = $qry->Fetch();

	$mediawhere = "";
	$fieldname = "MulMultiMediaRef:";
	for ($i = 1; !empty($results[0]->{"MulMultiMediaRef:$i"}); $i++)
	{
		if (!empty($mediawhere))
			$mediawhere .= " OR ";
		$mediawhere .= "irn_1=" . $results[0]->{"MulMultiMediaRef:$i"};
	}

	$mediaqry = new Query;
	$mediaqry->Select = array(
		"irn_1",
		"MulTitle");
	$mediaqry->From = "emultimedia";
	$mediaqry->Where = $mediawhere;
	$mediaqry->Limit = 0;
	$results = $mediaqry->Fetch();
	
	header("Content-type: text/xml");
	print '<?xml version="1.0" encoding="iso-8859-1"?>' ."\n";
	print "<gallery id=\"$irn\">\n";
	foreach($results as $result)
	{
		print '<item id="' . $result->{"irn_1"} . '">' . "\n";
		$imageurl = $GLOBALS['MEDIA_URL'] . "?thumb=yes&irn=";
		$imageurl .= $result->{"irn_1"};
		print '<image>' . htmlspecialchars($imageurl) . "</image>\n";
		print "<caption>" . htmlspecialchars($result->{"MulTitle"}) . "</caption>\n";
		print "</item>\n";
	}
	print "</gallery>\n";
}

function
return_story($irn)
{
	$qry = new Query;
	$qry->Select = array(
		"NarTitle",
		"NarNarrative",
		"MulMultiMediaRef_tab->emultimedia->AdmPublishWebNoPassword"
	);
	$qry->From = "enarratives";
	$qry->Where = "irn_1=$irn";
	$results = $qry->Fetch();
	
	$transqry = new Query;
	$transqry->Select = array(
		"irn_1",
		"NarTitle",
		"NarNarrative",
		"MulMultiMediaRef_tab->emultimedia->AdmPublishWebNoPassword",
		"MulMultiMediaRef_tab->emultimedia->MulMimeType",
		"MulMultiMediaRef_tab->emultimedia->MulMimeFormat",
	);
	$transqry->From = "enarratives";
	$transqry->Where = "AssMasterNarrativeRef=$irn";
	$transresults = $transqry->Fetch();


	/*
	 * Work out if there is a gallery associated with the narrative
	 */
	$gallery = "false";
	for ($i = 1; $i <= 10; $i++)
	{
		$field = "MulMultiMediaRef:$i" . "->emultimedia->AdmPublishWebNoPassword";
		if ($results[0]->{"$field"} != "")
		{
			$gallery = "true";
			break;
		}
	}

	header("Content-type: text/xml");
	print '<?xml version="1.0" encoding="iso-8859-1"?>' ."\n";
	print "<stories gallery=\"$gallery\">\n";
	print "<person>" . htmlspecialchars($results[0]->{"NarTitle"}) . "</person>\n";
	print "<biography>" . htmlspecialchars($results[0]->{"NarNarrative"}) . "</biography>\n";
	foreach ($transresults as $trans)
	{
		print '<story id="' . $trans->{"irn_1"} . '">' . "\n";
		print '<storyname>' . htmlspecialchars($trans->{"NarTitle"}) . "</storyname>\n";
		/*
		 * work out if there's some audio attached to the child narrative
		 */
		$audiourl = "";
		if ($trans->{'MulMultiMediaRef:1->emultimedia->MulMimeType'} == "audio" &&
			$trans->{'MulMultiMediaRef:1->emultimedia->MulMimeFormat'} == "mpeg")
		{
			$audiourl = $GLOBALS['MEDIA_URL'] . "?irn=" . $trans->{"MulMultiMediaRef:1"};
		}

		print '<audio>' . htmlspecialchars($audiourl) . "</audio>\n";
		print '<transcript>' . htmlspecialchars($trans->{"NarNarrative"}) . "</transcript>\n";
		print "</story>\n";
	}
	print "</stories>\n";
}

function
return_search_fields()
{
	header("Content-type: text/xml");
	print '<?xml version="1.0" encoding="iso-8859-1"?>' ."\n";
	print "<search>\n";

	/*
	 * themes
	 */
	$themeqry = new Query;
	$themeqry->Select = array("Value000", "Value010");
	$themeqry->From = "eluts";
	$themeqry->Where = "NameText contains '\"Oral History - Theme\"'";
	$themeqry->All = 1;
	$themeqry->Limit = 0;
	$results = $themeqry->Fetch();
		
	print "<themes>\n";
	foreach ($results as $result)
	{
		$theme = $result->{"Value000"};
		if (!empty($result->{"Value010"}))
			$theme .= " - " . $result->{"Value010"};
		
		print "<theme>" . htmlspecialchars($theme) . "</theme>\n";
	}
	print "</themes>\n";

	/*
	 * names
	 */
	$nameqry = new Query;
	$nameqry->Select = array("Value000");
	$nameqry->From = "eluts";
	$nameqry->Where = "NameText contains '\"Oral History - People\"'";
	$nameqry->All = 1;
	$nameqry->Limit = 0;
	$results = $nameqry->Fetch();

	print "<names>\n";
	foreach ($results as $result)
	{
		print "<name>" . htmlspecialchars($result->{"Value000"}) . "</name>\n";
	}
	print "</names>\n";

	/*
	 * locations
	 */
	$locqry = new Query;
	$locqry->Select = array("Value000");
	$locqry->From = "eluts";
	$locqry->Where = "NameText contains '\"Oral History - Place\"'";
	$locqry->All = 1;
	$locqry->Limit = 0;
	$results = $locqry->Fetch();

	print "<locations>\n";
	foreach ($results as $result)
	{
		print "<loc>" . htmlspecialchars($result->{"Value000"}) . "</loc>\n";
	}
	print "</locations>\n";

	/*
	 * dates
	 */
	$dateqry = new Query;
	$dateqry->Select = array("Value000");
	$dateqry->From = "eluts";
	$dateqry->Where = "NameText contains '\"Oral History - Period\"'";
	$dateqry->All = 1;
	$dateqry->Limit = 0;
	$results = $dateqry->Fetch();

	print "<dates>\n";
	foreach ($results as $result)
	{
		print "<range>" . htmlspecialchars($result->{"Value000"}) . "</range>\n";
	}
	print "</dates>\n";

	/*
	 * companies
	 */
	$comqry = new Query;
	$comqry->Select = array("Value000");
	$comqry->From = "eluts";
	$comqry->Where = "NameText contains '\"Oral History - Organisation\"'";
	$comqry->All = 1;
	$comqry->Limit = 0;
	$results = $comqry->Fetch();

	print "<companies>\n";
	foreach ($results as $result)
	{
		print "<com>" . htmlspecialchars($result->{"Value000"}) . "</com>\n";
	}
	print "</companies>\n";

	/*
	 * keywords
	 */
	$keyqry = new Query;
	$keyqry->Select = array("Value000");
	$keyqry->From = "eluts";
	$keyqry->Where = "NameText contains '\"Oral History - Keywords\"'";
	$keyqry->All = 1;
	$keyqry->Limit = 0;
	$results = $keyqry->Fetch();

	print "<keywords>\n";
	foreach ($results as $result)
	{
		print "<key>" . htmlspecialchars($result->{"Value000"}) . "</key>\n";
	}
	print "</keywords>\n";

	print "</search>\n";
}

class
HrQuery
{
	var	$theme = "";
	var	$name = "";
	var	$place = "";
	var	$daterange = "";
	var	$date = "";
	var	$company = "";
	var	$keyword = "";
}
?>
