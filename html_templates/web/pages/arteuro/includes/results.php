<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
*/
require_once('\\..\\php5\\query.php');

$StartAt = 1;
if (isset($_REQUEST['start']) && is_numeric($_REQUEST['start']) && $_REQUEST['start'] > 0)
	$StartAt = $_REQUEST['start'];
	
$qry = new Query;
$qry->StartRec = $StartAt;
$qry->Select('CreCreatorRef_tab->eparties->SummaryData');
$qry->Select('CreCreatorLastNameLocal');
$qry->Select('TitMainTitle');
$qry->Select('CreDateCreated');
$qry->Select('MulMultiMediaRef_tab->emultimedia->SummaryData');
$qry->Select('InfCaptionFrench');
$qry->Select('InfIdentifier');
$qry->Select('InfDescription');
$qry->Select('InfCaptionEnglish');
$qry->Select('InfDateCreated');
$qry->Select('Inf300DpiHeight');
$qry->Select('Inf300DpiLength');
$qry->Select('InfColourScheme');
$qry->Select('InfPublicPresent');
$qry->Select('InfView');
$qry->Select('InfCatalogueTitle_tab');
$qry->Select('InfCataloguePages_tab');
$qry->Select('PhoRigPhotographerRef_tab->eparties->SummaryData');
$qry->Select('PhoRigArtistRef_tab->eparties->SummaryData');
$qry->Select('RepObject');
$qry->Select('RepEvent');
$qry->Select('PhoEveExhibition');
$qry->Select('PhoEveTravellingEvent');
$qry->Select('PhoEvePreview');
$qry->Select('PhoEveWorkshop');
$qry->Select('PhoEveChildWorkshop');
$qry->Select('PhoEveLecture');
$qry->Select('AssRelatedEventsRef_tab->eevents->SummaryData');
$qry->Select('RepBuilding');
$qry->Select('BuiBlvdRaspailBuilding');
$qry->Select('BuiBlvdRaspailGarden');
$qry->Select('BuiJenJBuilding');
$qry->Select('BuiJenJGarden');
$qry->Select('RepPortrait');
$qry->Select('PorPortraitRef_tab->eparties->SummaryData');
/*
* Find out if we are querying for works or photos
*/
$RecordsPerPage = 20;
if (isset($_REQUEST['results']) && is_numeric($_REQUEST['results']))
					{
   						$RecordsPerPage = $_REQUEST['results'];
					} 
$qry->EndRec = ($StartAt + ($RecordsPerPage - 1));
$objecttype = "Oeuvre";
if (isset($_REQUEST['objecttype']) && !empty($_REQUEST['objecttype']))
{
	$objecttype=$_REQUEST['objecttype'];
}
$qry->Term("ObjectType", $objecttype);
if (isset($_REQUEST['creatorname']) && !empty($_REQUEST['creatorname']))
{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['creatorname']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("CreCreatorRef_tab", $party->irn_1, "int");
		}
	}
}
if (isset($_REQUEST['maintitle']) && !empty($_REQUEST['maintitle']))
{
	$qry->Term("TitMainTitle", mysql_escape_string($_REQUEST['maintitle']));
}
if (isset($_REQUEST['datecreated']) && !empty($_REQUEST['datecreated']))
{
	$qry->Term("CreDateCreated", mysql_escape_string($_REQUEST['datecreated']));
}
if (isset($_REQUEST['description']) && !empty($_REQUEST['description']))
{
	$qry->Term("PhyDescription", mysql_escape_string($_REQUEST['description']));
}
if (isset($_REQUEST['accessiondate']) && !empty($_REQUEST['accessiondate']))
{
	$qry->Term("TitAccessionDate", mysql_escape_string($_REQUEST['accessiondate']),"date");
}
if (isset($_REQUEST['objecttype']) && !empty($_REQUEST['objecttype']))
{
	$qry->Term("ObjectType", mysql_escape_string($_REQUEST['objecttype']));
}
if (isset($_REQUEST['captionfrench']) && !empty($_REQUEST['captionfrench']))
{
	$qry->Term("InfCaptionFrench", mysql_escape_string($_REQUEST['captionfrench']));
}
if (isset($_REQUEST['identifier']) && !empty($_REQUEST['identifier']))
{
	$qry->Term("InfIdentifier", mysql_escape_string($_REQUEST['identifier']));
}
if (isset($_REQUEST['captionenglish']) && !empty($_REQUEST['captionenglish']))
{
	$qry->Term("InfCaptionEnglish", mysql_escape_string($_REQUEST['captionenglish']));
}
if (isset($_REQUEST['descriptioninf']) && !empty($_REQUEST['descriptioninf']))
{
	$qry->Term("InfDescription", mysql_escape_string($_REQUEST['descriptioninf']));
}
if (isset($_REQUEST['datecreatedvue']) && !empty($_REQUEST['datecreatedvue']))
{
	$qry->Term("InfDateCreated", mysql_escape_string($_REQUEST['datecreatedvue']));
}
if (isset($_REQUEST['identifier']) && !empty($_REQUEST['identifier']))
{
	$qry->Term("InfIdentifier", mysql_escape_string($_REQUEST['identifier']));
}
if (isset($_REQUEST['dimensionshauteur']) && !empty($_REQUEST['dimensionshauteur']))
{
	$qry->Term("Inf300DpiHeight", mysql_escape_string($_REQUEST['dimensionshauteur']));
}
if (isset($_REQUEST['dimensionslargeur']) && !empty($_REQUEST['dimensionslargeur']))
{
	$qry->Term("Inf300DpiLength", mysql_escape_string($_REQUEST['dimensionslargeur']));
}
if (isset($_REQUEST['chromiecolour']) && !empty($_REQUEST['chromiecolour']))
{
	$qry->Term("InfColourScheme","Coleur");
}
if (isset($_REQUEST['chromienoiretblanc']) && !empty($_REQUEST['chromienoiretblanc']))
{
	$qry->Term("InfColourScheme","Noir et Blanc");
}
if (isset($_REQUEST['presencedunpublicoui']) && !empty($_REQUEST['presencedunpublicoui']))
{
	$qry->Term("InfPublicPresent","Oui");
}
if (isset($_REQUEST['presencedunpublicnon']) && !empty($_REQUEST['presencedunpublicnon']))
{
	$qry->Term("InfPublicPresent","No");
}
if (isset($_REQUEST['vuedejour']) && !empty($_REQUEST['vuedejour']))
{
	$qry->Term("InfView","De jour");
}
if (isset($_REQUEST['vuedenuit']) && !empty($_REQUEST['vuedenuit']))
{
	$qry->Term("InfView","De nuit");
}
if (isset($_REQUEST['titrecat']) && !empty($_REQUEST['titrecat']))
{
	$qry->Term("InfCatalogueTitle_tab", mysql_escape_string($_REQUEST['titrecat']));
}
if (isset($_REQUEST['page']) && !empty($_REQUEST['page']))
{
	$qry->Term("InfCataloguePages_tab", mysql_escape_string($_REQUEST['page']));
}
if (isset($_REQUEST['credphoto']) && !empty($_REQUEST['credphoto']))
{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['credphoto']));
	$parresults = $parqry->Fetch(); 
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("PhoRigPhotographerRef_tab", $party->irn_1, "int");
		}
	}
}
if (isset($_REQUEST['credartist']) && !empty($_REQUEST['credartist']))
{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['credartist']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("PhoRigArtistRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['repobjectoui']) && !empty($_REQUEST['repobjectoui']))
{
	$qry->Term("RepObject", "Oui");
}
if (isset($_REQUEST['repobjectnon']) && !empty($_REQUEST['repobjectnon']))
{
	$qry->Term("RepObject", "No");
}
if (isset($_REQUEST['repeventoui']) && !empty($_REQUEST['repeventoui']))
{
	$qry->Term("RepEvent", "Oui");
}
if (isset($_REQUEST['repeventnon']) && !empty($_REQUEST['repeventnon']))
{
	$qry->Term("RepEvent", "No");
}
if (isset($_REQUEST['expositionoui']) && !empty($_REQUEST['expositionoui']))
{
	$qry->Term("PhoEveExhibition","Oui");
}
if (isset($_REQUEST['expositionnon']) && !empty($_REQUEST['expositionnon']))
{
	$qry->Term("PhoEveExhibition", "No");
}
if (isset($_REQUEST['soireenomadeoui']) && !empty($_REQUEST['soireenomadeoui']))
{
	$qry->Term("PhoEveTravellingEvent","Oui");
}
if (isset($_REQUEST['soireenomadenon']) && !empty($_REQUEST['soireenomadenon']))
{
	$qry->Term("PhoEveTravellingEvent", "No");
}
if (isset($_REQUEST['vernissageoui']) && !empty($_REQUEST['vernissageoui']))
{
	$qry->Term("PhoEvePreview","Oui");
}
if (isset($_REQUEST['vernissagenon']) && !empty($_REQUEST['vernissagenon']))
{
	$qry->Term("PhoEvePreview", "No");
}
if (isset($_REQUEST['atelieroui']) && !empty($_REQUEST['atelieroui']))
{
	$qry->Term("PhoEveWorkshop", "Oui");
}
if (isset($_REQUEST['ateliernon']) && !empty($_REQUEST['ateliernon']))
{
	$qry->Term("PhoEveWorkshop", "No");
}
if (isset($_REQUEST['atelierpourenfantoui']) && !empty($_REQUEST['atelierpourenfantoui']))
{
	$qry->Term("PhoEveChildWorkshop", "Oui");
}
if (isset($_REQUEST['atelierpourenfantnon']) && !empty($_REQUEST['atelierpourenfantnon']))
{
	$qry->Term("PhoEveChildWorkshop", "No");
}
if (isset($_REQUEST['phoevelectureoui']) && !empty($_REQUEST['phoevelectureoui']))
{
	$qry->Term("PhoEveLecture", "Oui");
}
if (isset($_REQUEST['phoevelecturenon']) && !empty($_REQUEST['phoevelecturenon']))
{
	$qry->Term("PhoEveLecture", "No");
}
if (isset($_REQUEST['titreevenement']) && !empty($_REQUEST['titreevenement']))
{
	$parqry = new Query;
	$parqry->Table = "eevents";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['titreevenement']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("AssRelatedEventsRef_tab", $party->irn_1, "int");
		}
	}	
}
if (isset($_REQUEST['batimentoui']) && !empty($_REQUEST['batimentoui']))
{
	$qry->Term("RepBuilding", "Oui");
}
if (isset($_REQUEST['batimentnon']) && !empty($_REQUEST['batimentnon']))
{
	$qry->Term("RepBuilding", "No");
}
if (isset($_REQUEST['batimentbououi']) && !empty($_REQUEST['batimentbououi']))
{
	$qry->Term("BuiBlvdRaspailBuilding", "Oui");
}
if (isset($_REQUEST['batimentbounon']) && !empty($_REQUEST['batimentbounon']))
{
	$qry->Term("BuiBlvdRaspailBuilding", "No");
}

if (isset($_REQUEST['batimentjardinoui']) && !empty($_REQUEST['batimentjardinoui']))
{
	$qry->Term("BuiBlvdRaspailGarden", "Oui");
}
if (isset($_REQUEST['batimentjardinnon']) && !empty($_REQUEST['batimentjardinnon']))
{
	$qry->Term("BuiBlvdRaspailGarden", "No");
}
if (isset($_REQUEST['batimentjouyoui']) && !empty($_REQUEST['batimentjouyoui']))
{
	$qry->Term("BuiJenJBuilding", "Oui");
}
if (isset($_REQUEST['batimentjouynon']) && !empty($_REQUEST['batimentjouynon']))
{
	$qry->Term("BuiJenJBuilding", "No");
}
if (isset($_REQUEST['batimentjouyenjosasoui']) && !empty($_REQUEST['batimentjouyenjosasoui']))
{
	$qry->Term("BuiJenJGarden", "Oui");
}
if (isset($_REQUEST['batimentjouyenjosasnon']) && !empty($_REQUEST['batimentjouyenjosasnon']))
{
	$qry->Term("BuiJenJGarden", "No");
}
if (isset($_REQUEST['portraitartisteoui']) && !empty($_REQUEST['portraitartisteoui']))
{
	$qry->Term("RepPortrait", "Oui");
}
if (isset($_REQUEST['portraitartistenon']) && !empty($_REQUEST['portraitartistenon']))
{
	$qry->Term("RepPortrait", "No");
}
if (isset($_REQUEST['nomlast']) && !empty($_REQUEST['nomlast']))
{
	{
	$parqry = new Query;
	$parqry->Table = "eparties";
	$parqry->Select("irn_1");
	$parqry->Term("SummaryData", mysql_escape_string($_REQUEST['nomlast']));
	$parresults = $parqry->Fetch();
	if ($parqry->Matches == 0)
	{
		$qry->Term("irn", 9999999);
	}
	else
	{
		foreach ($parresults as $party)
		{
			$qry->Term("PorPortraitRef_tab", $party->irn_1, "int");
		}
	}
	}
}
if(preg_match("/oeuvre/i", $_REQUEST['objecttype']))		
{ 
		$qry->Order = "CreCreatorLastNameLocal asc, TitMainTitle asc, CreDateCreated asc";
}


/*
 * Actually run the query
 */
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
