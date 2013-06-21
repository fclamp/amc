<?php
require_once('..\\..\\php5\\query.php');

$IRN = 0;
if (isset($_REQUEST['irn']) && is_numeric($_REQUEST['irn']))
	$IRN = $_REQUEST['irn'];

$qry = new Query;
$qry->StartRec = 1;
$qry->EndRec = 1;
$qry->Term('irn_1', $IRN);
$qry->Select('MulMultiMediaRef_tab->emultimedia->SummaryData');
$qry->Select('CreCreatorRef_tab->eparties->SummaryData');
$qry->Select('TitMainTitle');
$qry->Select('CreDateCreated');
$qry->Select('TitSeriesTitle');
$qry->Select('ObjectType');
$qry->Select('PhyDescription');
$qry->Select('PhyType_tab');
$qry->Select('PhyHeight_tab');
$qry->Select('PhyWidth_tab');
$qry->Select('PhyDepth_tab');
$qry->Select('PhyDiameter_tab');
$qry->Select('TitAccessionDate');
$qry->Select('PhyUnitLength_tab');
$qry->Select('InfIdentifier');
$qry->Select('InfCaptionFrench');
$qry->Select('InfCaptionEnglish');
$qry->Select('InfDescription');
$qry->Select('InfDateCreated');
$qry->Select('Inf300DpiHeight');
$qry->Select('Inf300DpiLength');
$qry->Select('InfCatalogueTitle_tab');
$qry->Select('InfCataloguePages_tab');
$qry->Select('PhoRigArtistRef_tab->eparties->SummaryData'); 
$qry->Select('PhoRigPhotographerRef_tab->eparties->SummaryData');



$results = $qry->Fetch();
//print_r($qry);

/* Get all use full information for Dimension Grid
*/
// get count for number of rows
$DimensionGridLevels = 0;
if(count($results[0]->PhyType_tab) > $DimensionGridLevels)
	$DimensionGridLevels = count($results[0]->PhyType_tab);
if(count($results[0]->PhyHeight_tab) > $DimensionGridLevels)
	$DimensionGridLevels = count($results[0]->PhyHeight_tab);
if(count($results[0]->PhyWidth_tab) > $DimensionGridLevels)
	$DimensionGridLevels = count($results[0]->PhyWidth_tab);
if(count($results[0]->PhyDepth_tab) > $DimensionGridLevels)
	$DimensionGridLevels = count($results[0]->PhyDepth_tab);
if(count($results[0]->PhyDiameter_tab) > $DimensionGridLevels)
	$DimensionGridLevels = count($results[0]->PhyDiameter_tab);
if(count($results[0]->PhyUnitLength_tab) > $DimensionGridLevels)
	$DimensionGridLevels = count($PhyUnitLength_tab);
	
/*Photheque Section*/
$PhotoDimensionGridLevels = 0;
if(count($results[0]->InfCatalogueTitle_tab) > $PhotoDimensionGridLevels)
	$PhotoDimensionGridLevels = count($results[0]->InfCatalogueTitle_tab);
if(count($results[0]->InfCataloguePages_tab) > $PhotoDimensionGridLevels)
	$PhotoDimensionGridLevels = count($results[0]->InfCataloguePages_tab);

/*Define row counter for fields in display page */
$fieldrowcount = 0







?>



