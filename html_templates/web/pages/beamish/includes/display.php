<?php
require_once('emuweb/php5/query.php');

$IRN = 0;
if (isset($_REQUEST['irn']) && is_numeric($_REQUEST['irn']))
	$IRN = $_REQUEST['irn'];

$qry = new Query;
$qry->StartRec = 1;
$qry->EndRec = 1;
$qry->Term('irn_1', $IRN);
$qry->Select("SummaryData");
$qry->Select('AccAccessionLotRef->eaccessionlots->SummaryData');
$qry->Select('AccAccessionLotRef->eaccessionlots->AcqSourceRef_tab->eparties->SummaryData');
$qry->Select('AccAccessionLotRef->eaccessionlots->AcqAcquisitionMethod');
$qry->Select('TitObjectName');
$qry->Select('TitAccessionNo');
$qry->Select('TitObjectStatus');
$qry->Select('ConConditionStatus');
$qry->Select('LocCurrentLocationRef->elocations->SummaryData');
$qry->Select('CreBriefDescription');
$qry->Select('TitCollectionGroup_tab');
$qry->Select('TitCollectionSubGroup_tab');
$qry->Select('PhyShicClassification_tab');
$qry->Select('CreProvenance');
$qry->Select('CreCreatorRef_tab->eparties->SummaryData');
$qry->Select('CreRole_tab');
$qry->Select('CreCreationPlace1_tab');
$qry->Select('CreCreationPlace2_tab');
$qry->Select('CreCreationPlace3_tab');
$qry->Select('CreCreationPlace4_tab');
$qry->Select('CreCreationPlace5_tab');
$qry->Select('CrePeriodDate');
$qry->Select('CreDateCreated');
$qry->Select('CreEarliestDate');
$qry->Select('CreLatestDate');
$qry->Select('CreCreationNotes');
$qry->Select('CrePrimaryInscriptions');
$qry->Select('CreOtherInscriptions');
$qry->Select('PhyTechnique_tab');
$qry->Select('PhyMaterial_tab');
$qry->Select('PhyMedium_tab');
$qry->Select('PhySupport');
$qry->Select('PhyDescription');
$qry->Select('MulMultiMediaRef_tab->emultimedia->SummaryData');
$results = $qry->Fetch();
//print_r($qry);
?>


