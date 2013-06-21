<?php

require_once('emuweb/php5/query.php');

$IRN = 0;
if (isset($_REQUEST['irn']) && is_numeric($_REQUEST['irn']))
	$IRN = $_REQUEST['irn'];
{
$qry = new Query;
$qry->StartRec = 1;
$qry->EndRec = 1;
$qry->Term('irn_1', $IRN);
$qry->Select('MulMultiMediaRef_tab->emultimedia->SummaryData');
$qry->Select('ColObjectStatus');
$qry->Select('ColCollection');
$qry->Select('ClaObjectName_tab');
$qry->Select('ClaLevel1Classification');
$qry->Select('ColFullName');
$qry->Select('MapTitle');
$qry->Select('MapPublisherRef->eparties->SummaryData');
$qry->Select('ColObjectNumber');
$qry->Select('GeoName');
$qry->Select('TaxTaxonomyRef_tab->etaxonomy->ClaFamily');
$qry->Select('TaxTaxonomyRef_tab->etaxonomy->ClaGenus');
$qry->Select('TaxTaxonomyRef_tab->etaxonomy->ClaOrder');
$qry->Select('TaxTaxonomyRef_tab->etaxonomy->ClaSpecies');
$qry->Select('ColOtherNumbersType_tab');
$qry->Select('ColOtherNumbers_tab');
$qry->Select('BibBibliographyRef_tab->ebibliography->SummaryData');
$qry->Select('ProCulturalGroup_tab');
$qry->Select('ColCollectionName_tab');
$qry->Select('ProMakerRef_tab->eparties->SummaryData');
$qry->Select('ProProductionPlaceRef_tab->esites->SummaryData');
$qry->Select('ProProductionDate');
$qry->Select('AcqCreditLine');
$qry->Select('AssAssociationEvent_tab');
$qry->Select('AssAssociationNameRef_tab->eparties->SummaryData');
$qry->Select('ColPhysicalDescription');
$qry->Select('NumObverseDescription');
$qry->Select('NumReverseDescription');
$qry->Select('GeoChronostratigraphy');
$qry->Select('GeoLithostratigraphy');
$qry->Select('SitSiteRef_tab->esites->SummaryData'); /*Associated Place in some forms*/
$qry->Select('SitSiteName_tab');
$qry->Select('ColMainTitle');
$qry->Select('ColArtistNameRef_tab->eparties->SummaryData');
$qry->Select('AssAssociationPeriod_tab');
$qry->Select('AssAssociationDate_tab'); 
$qry->Select('SitSiteName_tab'); 
$qry->Select('AssSiteRef_tab->esites->SummaryData');
$qry->Select('SitPreciseLocation'); 
$qry->Select('LocLevel1');
$qry->Select('LocLevel2');
$qry->Select('SitSiteCode_tab');
$qry->Select('SitProjectName_tab');

$results = $qry->Fetch();


//Get events data
$eveqry = new Query;
$eveqry->StartRec = 1;
$eveqry->EndRec = 1;
$eveqry->Table = "eevents";
$eveqry->Term('ObjAttachedObjectsRef_tab', $IRN, "int");
$eveqry->Select('SummaryData');
$everesults = $eveqry->Fetch();

$fieldcolourrowcount = 0;
}



?>
