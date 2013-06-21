<?php
/*
** Copyright (c) KE Software Pty. Ltd. 2008
*/

require_once('emuweb/php5/query.php');
$StartAt= 1;
if (isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) && $_REQUEST['start'] > 0)
	$StartAt = $_REQUEST['start'];
	
$qry = new Query;
$qry->StartRec = $StartAt;
$qry->Select('MulMultiMediaRef_tab->emultimedia->SummaryData');
$qry->Select('ColObjectNumber');
$qry->Select('SummaryData');

$RecordsPerPage = 40;
if (isset($_REQUEST['results']) && is_numeric($_REQUEST['results']))
					{
   						$RecordsPerPage = $_REQUEST['results'];
					} 
$qry->EndRec = ($StartAt + ($RecordsPerPage - 1));

/*
 * The preconfigured queries for the collection
 */
if (isset($_REQUEST['preconf']) && !empty($_REQUEST['preconf']))
{
	$qry->Term("ColCollection", $_REQUEST['preconf']);
}
/*
** Intranet Detailed Search
*/
if (isset($_REQUEST['colname']) && !empty($_REQUEST['colname']))
{
	$qry->Term("ColCollection", $_REQUEST['colname']);
}
if (isset($_REQUEST['objstatus']) && !empty($_REQUEST['objstatus']))
{
	$qry->Term("ColObjectStatus", $_REQUEST['objstatus']);
}
if (isset($_REQUEST['colcoll']) && !empty($_REQUEST['colcoll']))
{
	$qry->Term("ColCollection", mysql_escape_string($_REQUEST['colcoll']));
}

if (isset($_REQUEST['objname']) && !empty($_REQUEST['objname']))
{
	$qry->Term("ClaObjectName_tab", mysql_escape_string($_REQUEST['objname']));
}
if (isset($_REQUEST['subclassification']) && !empty($_REQUEST['subclassification']))
{
	$qry->Term("ClaLevel1Classification", mysql_escape_string($_REQUEST['subclassification']));
}
if (isset($_REQUEST['objfullname']) && !empty($_REQUEST['objfullname']))
{
	$qry->Term("ColFullName", mysql_escape_string($_REQUEST['objfullname']));
}
if (isset($_REQUEST['maptitle']) && !empty($_REQUEST['maptitle']))
{
	$qry->Term("MapTitle", mysql_escape_string($_REQUEST['maptitle']));
}
if (isset($_REQUEST['objnum']) && !empty($_REQUEST['objnum']))
{
	$qry->Term("ColObjectNumber", mysql_escape_string($_REQUEST['objnum']));
}
if (isset($_REQUEST['specimenname']) && !empty($_REQUEST['specimenname']))
{
	$qry->Term("GeoName", mysql_escape_string($_REQUEST['specimenname']));
}
if (isset($_REQUEST['family']) && !empty($_REQUEST['family']))
{
	$famqry = new Query;
	$famqry->Table = "etaxonomy";
	$famqry->Select("irn_1");
	$famqry->Term("ClaFamily", mysql_escape_string($_REQUEST['family']));
	$famresults = $famqry->Fetch();
	if ($famqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($famresults as $famresult)
		{
			$qry->Term("TaxTaxonomyRef_tab", $famresult->irn_1, "int");
		}
	}
}
if (isset($_REQUEST['genus']) && !empty($_REQUEST['genus']))
{
	$genqry = new Query;
	$genqry->Table = "etaxonomy";
	$genqry->Select("irn_1");
	$genqry->Term("ClaGenus", mysql_escape_string($_REQUEST['genus']));
	$genresults = $genqry->Fetch();
	if ($genqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($genresults as $genresult)
		{
			$qry->Term("TaxTaxonomyRef_tab", $genresult->irn_1, "int");
		}
	}
}
if (isset($_REQUEST['order']) && !empty($_REQUEST['order']))
{
	$ordqry = new Query;
	$ordqry->Table = "etaxonomy";
	$ordqry->Select("irn_1");
	$ordqry->Term("ClaOrder", mysql_escape_string($_REQUEST['order']));
	$ordresults = $ordqry->Fetch();
	if ($ordqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($ordresults as $ordresult)
		{
			$qry->Term("TaxTaxonomyRef_tab", $ordresult->irn_1, "int");
		}
	}
}
if (isset($_REQUEST['species']) && !empty($_REQUEST['species']))
{
	$speqry = new Query;
	$speqry->Table = "etaxonomy";
	$speqry->Select("irn_1");
	$speqry->Term("ClaSpecies", mysql_escape_string($_REQUEST['species']));
	$speresults = $speqry->Fetch();
	if ($speqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($speresults as $speresult)
		{
			$qry->Term("TaxTaxonomyRef_tab", $speresult->irn_1, "int");
		}
	}
}

if (isset($_REQUEST['othernumtype']) && !empty($_REQUEST['othernumtype']))
{
	$qry->Term("ColOtherNumbersType_tab", mysql_escape_string($_REQUEST['othernumtype']));
}
if (isset($_REQUEST['othernum']) && !empty($_REQUEST['othernum']))
{
	$qry->Term("ColOtherNumbers_tab", mysql_escape_string($_REQUEST['othernum']));
}
if (isset($_REQUEST['bibliography']) && !empty($_REQUEST['bibliography']))
{
	$parqry = new Query;
	$parqry->Table = "ebibliography";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['bibliography']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("BibBibliographyRef_tab", $party->irn_1, "int");
		}
	}	
}

if (isset($_REQUEST['publisher']) && !empty($_REQUEST['publisher']))
{

	$pubqry = new Query;
	$pubqry->Table = "eparties";
	$pubqry->Select("irn_1");
	$pubqry->Term("NamOrganisation", mysql_escape_string($_REQUEST['publisher']));
	$pubresults = $pubqry->Fetch();
	if ($pubqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($pubresults as $pubresult)
		{
			$qry->Term("MapPublisherRef", $pubresult->irn_1, "int");
		}
	}	
	
}
if (isset($_REQUEST['culturalgroup']) && !empty($_REQUEST['culturalgroup']))
{
	$qry->Term("ProCulturalGroup_tab", mysql_escape_string($_REQUEST['culturalgroup']));
}
if (isset($_REQUEST['namecoll']) && !empty($_REQUEST['namecoll']))
{
	$qry->Term("ColCollectionName_tab", mysql_escape_string($_REQUEST['namecoll']));
}
if (isset($_REQUEST['manmaker']) && !empty($_REQUEST['manmaker']))
{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['manmaker']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("ProMakerRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['pproduction']) && !empty($_REQUEST['pproduction']))
{
	$parqry = new Query;
	$parqry->Table = "esites";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['pproduction']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("ProProductionPlaceRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['dproduction']) && !empty($_REQUEST['dproduction']))
{
	$qry->Term("ProProductionDate", mysql_escape_string($_REQUEST['dproduction']));
}
if (isset($_REQUEST['assoccreditline']) && !empty($_REQUEST['assoccreditline']))
{
	$credqry = new Query;
	$credqry->Table = "eaccessionlots";
	$credqry->Select("irn_1");
	$credqry->Term("AcqCreditLine", mysql_escape_string($_REQUEST['assoccreditline']));
	$credresults = $credqry->Fetch();
	if ($credqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($credresults as $credresult)
		{
			$qry->Term("AccAccessionLotRef", $credresult->irn_1, "int");
		}
	}	
}

if (isset($_REQUEST['assocevent']) && !empty($_REQUEST['assocevent']))
{
	$qry->Term("AssAssociationEvent_tab", mysql_escape_string($_REQUEST['assocevent']));
}
if (isset($_REQUEST['assocpersonorg']) && !empty($_REQUEST['assocpersonorg']))
{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['assocpersonorg']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("AssAssociationNameRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['description']) && !empty($_REQUEST['description']))
{
	$qry->Term("ColPhysicalDescription", mysql_escape_string($_REQUEST['description']));
}
if (isset($_REQUEST['obvdescription']) && !empty($_REQUEST['obvdescription']))
{
	$qry->Term("NumObverseDescription", mysql_escape_string($_REQUEST['obvdescription']));
}
if (isset($_REQUEST['revdescription']) && !empty($_REQUEST['revdescription']))
{
	$qry->Term("NumReverseDescription", mysql_escape_string($_REQUEST['revdescription']));
}


if (isset($_REQUEST['chronsgraphy']) && !empty($_REQUEST['chronsgraphy']))
{
	$qry->Term("GeoChronostratigraphy", mysql_escape_string($_REQUEST['chronsgraphy']));
}
if (isset($_REQUEST['lithosgraphy']) && !empty($_REQUEST['lithosgraphy']))
{
	$qry->Term("GeoLithostratigraphy", mysql_escape_string($_REQUEST['lithosgraphy']));
}
if (isset($_REQUEST['locality']) && !empty($_REQUEST['locality']))
{
	$parqry = new Query;
	$parqry->Table = "esites";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['locality']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("SitSiteRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['archsitename']) && !empty($_REQUEST['archsitename']))
{
	$qry->Term("SitSiteName_tab", mysql_escape_string($_REQUEST['archsitename']));
}
if (isset($_REQUEST['title']) && !empty($_REQUEST['title']))
{
	$qry->Term("ColMainTitle", mysql_escape_string($_REQUEST['title']));
}
if (isset($_REQUEST['artist']) && !empty($_REQUEST['artist']))
{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['artist']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("ColArtistNameRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['period']) && !empty($_REQUEST['period']))
{
	$qry->Term("AssAssociationPeriod_tab", mysql_escape_string($_REQUEST['period']));
}
if (isset($_REQUEST['adate']) && !empty($_REQUEST['adate']))
{
	$qry->Term("AssAssociationDate_tab", mysql_escape_string($_REQUEST['adate']));
}
if (isset($_REQUEST['aplace']) && !empty($_REQUEST['aplace']))
{
	$qry->Term("SitSiteName_tab", mysql_escape_string($_REQUEST['aplace']));
}
if (isset($_REQUEST['plocation']) && !empty($_REQUEST['plocation']))
{
	$qry->Term("AssPreciseLocation_tab", mysql_escape_string($_REQUEST['plocation']));
}

if (isset($_REQUEST['collevent']) && !empty($_REQUEST['collevent']))
{
	$parqry = new Query;
	$parqry->Table = "eevents";
	$parqry->Select("ObjAttachedObjectsRef_tab");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['collevent']));
	$parresults = $parqry->Fetch();
	
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			foreach($party->ObjAttachedObjectsRef_tab as $attachedObject)
			{
				$qry->Term("irn_1", $attachedObject, "int");
			}
		}
	}	
}
if (isset($_REQUEST['loclevel1']) && !empty($_REQUEST['loclevel1']))
{      
	$loc1qry = new Query;
	$loc1qry->Table = "elocations";
	$loc1qry->Select("irn_1");
	$loc1qry->Term("LocLevel1", mysql_escape_string($_REQUEST['loclevel1']));
	$loc1results = $loc1qry->Fetch();
	if ($loc1qry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($loc1results as $loc1result)
		{
			$qry->Term("LocCurrentLocationRef", $loc1result->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['loclevel2']) && !empty($_REQUEST['loclevel2']))
{
	$loc2qry = new Query;
	$loc2qry->Table = "elocations";
	$loc2qry->Select("irn_1");
	$loc2qry->Term("LocLevel2", mysql_escape_string($_REQUEST['loclevel2']));
	$loc2results = $loc2qry->Fetch();
	if ($loc2qry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($loc2results as $loc2result)
		{
			$qry->Term("LocCurrentLocationRef", $loc2result->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['sitecode']) && !empty($_REQUEST['sitecode']))
{
	$qry->Term("SitSiteCode_tab", mysql_escape_string($_REQUEST['sitecode']));
}
if (isset($_REQUEST['projectname']) && !empty($_REQUEST['projectname']))
{
	$qry->Term("SitProjectName_tab", mysql_escape_string($_REQUEST['projectname']));
}
/*
** Intranet Keyword Search
*/

if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword']))
{
	$asiteqry = new Query;
	$asiteqry->Table = "esites";
	$asiteqry->Select("irn_1");
	$asiteqry->Term("SummaryData", mysql_escape_string($_REQUEST['keyword']));
	$asiteqryresults = $asiteqry->Fetch();
}
$texql = "";
if (isset($_REQUEST['keyword']) && !empty($_REQUEST['keyword']))
{
	$keywordtext = $_REQUEST['keyword'];
	$texql = " (exists(SitSiteName_tab where SitSiteName contains '$keywordtext'))";
	$texql .= " or MapTitle contains '$keywordtext'";
	$texql .= " or ColArtistNameLocal contains '$keywordtext'"; 
	$texql .= " or SummaryData contains '$keywordtext'";
	$texql .= " or (exists(AssAssociationPeriod_tab where AssAssociationPeriod contains '$keywordtext'))";
	$texql .= " or TaxTaxonomyLocal contains '$keywordtext'";
	$texql .= " or GeoName contains '$keywordtext'";
	$texql .= " or (exists(ClaObjectName_tab where ClaObjectName contains '$keywordtext'))";
	$texql .= " or ColObjectNumber contains '$keywordtext'";     
	if ($asiteqry->Matches > 0)
	{
		foreach ($asiteqryresults as $asiteqryresult)
		{
			$texql .= " or (exists(AssSiteRef_tab where AssSiteRef = $asiteqryresult->irn_1))";
		}
	} 
	$texql .= " or (exists(AssAssociationPeriod_tab where AssAssociationPeriod contains '$keywordtext'))";
}

/*
 * Only show records with images
 */ 
if (!empty($_REQUEST['itemsimgcheck']))
{
	$qry->Term("MulHasMultiMedia", "Y");
}
/*
 * Actually run the query
 */
$qry->Where = $texql;
$results = $qry->Fetch();

if ($qry->EndRec > $qry->Matches)
{
	$truematches = $qry->StartRec + count($results) - 1;
	if ($truematches < $qry->Matches)
		$qry->Matches = $truematches;
	if ($truematches < $qry->EndRec)
		$qry->EndRec = $truematches;
}
$NextPageURL = "";
if ($qry->Matches > $qry->EndRec)
{
	$NextPageURL = $_SERVER['PHP_SELF'] . "?";
	$Params = "";
	foreach ($_REQUEST as $key => $val)
	{
		if ($key == "start")
			continue;
		if (!empty($Params))
			$Params .= "&amp;";
			$Params .= $key . "=" . urlencode($val);
	}
	$nextstart = $qry->StartRec + $RecordsPerPage ;
	$NextPageURL .= $Params . "&amp;" . "start=$nextstart";
}
$PrevPageURL = "";
if ($qry->StartRec > 1)
{
	$PrevPageURL = $_SERVER['PHP_SELF'] . "?";
	$Params = "";
	foreach ($_REQUEST as $key => $val)
	{
		if ($key == "start")
			continue;
		if (!empty($Params))
			$Params .= "&amp;";
		$Params .= $key . "=" . urlencode($val);
	}
	$prevstart = $qry->StartRec - $RecordsPerPage ;
	if ($prevstart < 1)
		$prevstart = 1;

	$PrevPageURL .= $Params . "&amp;" . "start=$prevstart";
}
?>