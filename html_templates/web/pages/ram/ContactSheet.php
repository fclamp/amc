<?php
include('includes/header.inc');

$Where = "";
$Anywhere = "TitBriefDescription|TitFullDescription|TitSeriesTitle|TitObjectType|TitCollection|TitTitleNotes|CreCreatorLocal_tab|CreCreatorRef_tab->eparties->SynSynonymyLocal_tab|CreRole_tab|CreCreatorRef_tab->eparties->BioNationality|CreDateCreated|CreCreatorRef_tab->eparties->BioBirthDate|CreCreatorRef_tab->eparties->BioDeathDate|CreCountry_tab|CreCreationNotes|CreState_tab|CreDistrict_tab|CreCity_tab|CreSubjectClassification_tab|CreCultureState|CrePrimaryInscriptions|CreInscriptionNotes|PhyClassification|PhyTechnique_tab|PhyMedium_tab|PhyMaterials_tab|PhyPhysicalDescription|PhyUnitLength_tab|AssRelatedPartiesRef_tab->eparties->SummaryData|AssPartiesRelationship_tab|NotNotes|AssRelatedPartiesRef_tab->eparties->BioCommencementNotes|AssRelatedPartiesRef_tab->eparties->SynSynonymyLocal_tab";

if (isset($_REQUEST['QueryName']) && ($_REQUEST['QueryName'] == "BasicQuery" || $_REQUEST['QueryName'] == "AdvancedQuery"))
{
	$_REQUEST['Anywhere'] = $Anywhere;
	if ($_REQUEST['QueryName'] == "BasicQuery")
		$_REQUEST['QueryPage'] = "/emuweb/pages/ram/Query.php";
}
elseif (isset($_REQUEST['quicksearch']))
{
	$search = $_REQUEST['quicksearch'];
	if ($search == "paintings")
		$Where = "PhyClassification contains 'painting' OR PhyClassification contains 'drawing'";
	elseif ($search == "archive")
		$Where = "exists(CreSubjectClassification_tab where CreSubjectClassification contains 'archive')";
	elseif ($search == "photos")
		$Where = "PhyClassification contains 'photograph'";
	elseif ($search == "bows")
		$Where = "TitBriefDescription contains 'bow'";
	elseif ($search == "venues")
		$Where = "exists(CreSubjectClassification_tab where CreSubjectClassification contains 'venue')";
	elseif ($search == "playbills")
		$Where = "TitBriefDescription contains 'playbill' OR TitBriefDescription contains 'programme'";
	elseif ($search == "prints")
		$Where = "exists(PhyTechnique_tab where PhyTechnique contains 'engraving') OR exists(PhyTechnique_tab where PhyTechnique contains 'lithograph') OR exists(PhyTechnique_tab where PhyTechnique contains 'etching') OR exists(PhyTechnique_tab where PhyTechnique contains 'stipple')";
	elseif ($search == "sculpture")
		$Where = "TitFullDescription contains 'sculpture'";
	elseif ($search == "manuscripts")
		$Where = "exists(CreSubjectClassification_tab where CreSubjectClassification contains 'manuscript') OR exists(CreSubjectClassification_tab where CreSubjectClassification contains 'musical quotation') OR exists(CreSubjectClassification_tab where CreSubjectClassification contains 'notation') OR exists(CreSubjectClassification_tab where CreSubjectClassification contains '\"early english library material\"') OR TitFullDescription contains '\"musical quotation\"'";
	elseif ($search == "opera")
		$Where = "exists(CreSubjectClassification_tab where CreSubjectClassification contains 'opera')";
	elseif ($search == "sheet")
		$Where = "TitFullDescription contains '\"sheet music\"' OR TitFullDescription contains '\"title page\"'";
	elseif ($search == "worldmusic")
		$Where = "exists(CreSubjectClassification_tab where CreSubjectClassification contains '\"world music\"')";
	elseif ($search == "instruments")
		$Where = "TitObjectType contains 'instrument'";
	elseif ($search == "documents")
		$Where = "TitObjectType contains 'document' AND (TitFullDescription contains 'letter' OR TitFullDescription contains '\"musical quotation\"' OR TitFullDescription contains 'declaration' OR TitFullDescription contains 'receipt' OR TitFullDescription contains 'receipts' OR TitFullDescription contains 'contract')";

	$_REQUEST['QueryName'] = "BasicQuery";
	$_REQUEST['QueryPage'] = "/emuweb/pages/ram/Query.php";
}	
elseif (isset($_REQUEST['search']))
{
	$_REQUEST['Anywhere'] = $Anywhere;
	$_REQUEST['QueryOption'] = "Anywhere";
	$_REQUEST['QueryName'] = "BasicQuery";
	$_REQUEST['QueryPage'] = "/emuweb/pages/ram/Query.php";
	$_REQUEST['QueryTerms'] = $_REQUEST['search'];
}

require_once('../../objects/ram/ResultsLists.php');
$list = new RamContactSheet();
$list->BorderColor = '#B6CD35';
if ($Where != "")
	$list->Where = $Where;
$list->BodyColor = '#ffffff';
$list->TextColor = '#000000';
$list->ResultsListPage = 'ResultsList.php';
$list->ShowImageBorders = '0';

?>
<div align="center"><?php $list->Show(); ?></div>
<?php
include('includes/footer.inc');
?>
