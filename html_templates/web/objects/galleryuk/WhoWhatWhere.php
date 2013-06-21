<?

if (!isset($WEB_ROOT))
	$WEB_ROOT=dirname(dirname(dirname(realpath(_FILE_))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
WagWhoWhatWhereQueryForm extends BaseDetailedQueryForm
{
	function
	WagWhoWhatWhereQueryForm ()
	{


		$this->Fields = array(
			'CreCreatorLocal_tab|CreCulturalOriginSummary',
			'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitTitleNotes|TitObjectName',
			'CreCulturalOrigin1|CreCulturalOrigin2|CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab',
			'CreDateCreated',
			'PhyTechnique_tab|PhySupport'
			);

		$this->Hints = array(
			'CreCreatorLocal_tab|CreCulturalOriginSummary' => "[ e.g. Hockney ]",
			'TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitTitleNotes' => "[ e.g. print or sampler ]",
			'CreCulturalOrigin1|CreCulturalOrigin2|CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab' => "[ e.g. Manchester, Russia ]",
			'CreDateCreated' => "[ note: not all works have dates ]",
			'PhyTechnique_tab|PhySupport' => "[ e.g. lithography ]",
			);

		$this->ExtraStrings = array(
			"CreCreatorLocal_tab|CreCulturalOriginSummary" => "Who",
			"TitMainTitle|TitSeriesTitle|TitCollectionTitle|TitTitleNotes" => "What",
			"PhyTechnique_tab|PhySupport" => "How",
			"CreCulturalOrigin1|CreCulturalOrigin2|CreCreationPlace1_tab|CreCreationPlace2_tab|CreCreationPlace3_tab|CreCreationPlace4_tab|CreCreationPlace5_tab" => "Where",
			"CreDateCreated" => "When",
			);

		$this->BaseDetailedQueryForm();
	}
}//End WagWhoWhatWhereQueryForm class
?>
