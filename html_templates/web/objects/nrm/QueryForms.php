<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
GalleryBasicQueryForm extends BaseBasicQueryForm
{

	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata|TitMainTitle|TitTitleNotes|NotNotes|CreCreatorLocal_tab|CreCountry_tab',
					'title' => 'TitMainTitle|TitTitleNotes',
					'notes' => 'NotNotes|TitTitleNotes',
					'artist' => 'CreCreatorLocal_tab',
					'place' => 'CreCountry_tab',
					'type' => 'TitObjectType',
					//'location' => 'elocations:SummaryData',
					);

}  // end GalleryBasicQueryForm class
class
NrmBasicQueryForm extends BaseDetailedQueryForm
{
	function
	NrmBasicQueryForm()
	{
		$this->BaseDetailedQueryForm();

		$this->Fields = array(  
					//'TitObjectType',
					'SummaryData|AdmWebMetadata|TitMainTitle|TitTitleNotes|NotNotes|CreCreatorLocal_tab|CreCountry_tab',
					'TitMainTitle|TitTitleNotes|TitCollectionTitle',
					'NotNotes|TitTitleNotes|RefBibliographicNotes_tab',
					'CreCreatorLocal_tab',
					'CreCountry_tab',
					);
		$this->Hints = array(	
					'TitObjectType' 	=> '[ Leave blank to search all databases ]',
					'CreCountry_tab' 	=> '[ Select from the list ]',
					);
		$this->DropDownLists = array(	
						//'TitObjectType' => 'eluts:Object Type',
						//'TitObjectType' => '|Art Search|Digger|Earthquake|Hunter Photo Bank|Museum Collection|Sporting Person',
						'CreCountry_tab' => 'eluts:Creator Location[1]',
						);
	}
}

class
GalleryAdvancedQueryForm extends BaseAdvancedQueryForm
{
	var $Options = array(	'any' => 'SummaryData|AdmWebMetadata',
					'title' => 'SummaryData|AdmWebMetadata|TitMainTitle|TitTitleNotes|NotNotes|CreCreatorLocal_tab|CreCountry_tab',
					'notes' => 'TitMainTitle|TitTitleNotes|TitCollectionTitle',
					'artist' => 'CreCreatorRefLocal_tab',
					'place' => 'CreCountry_tab',
					'type' => 'TitObjectType',
					//'location' => 'LocCurrentLocationRef',
					//'location' => 'LocCurrentLocationRef->elocations->SummaryData',
					);

}  // end GalleryAdvancedQueryForm class
	

class
GalleryDetailedQueryForm extends BaseDetailedQueryForm
{
	function
	GalleryDetailedQueryForm()
	{

	// dummy headers for main detailed query
	$objectHeader = new QueryField;
	$objectHeader->ColName = 'CreEarliestDateOrig';
	$sportHeader = new QueryField;
	$sportHeader->ColName = 'Validation';
	$diggerHeader = new QueryField;
	$diggerHeader->ColName = 'AdmPublishWebNoPasswordFlag';
	$quakeHeader = new QueryField;
	$quakeHeader->ColName = 'AdmPublishWebPasswordFlag';
	// dummy headers for main detailed query

	$this->BaseDetailedQueryForm();
	$this->Width = '800';

	$credateEarliest = new QueryField;
	$credateEarliest->ColName = 'CreEarliestDate';
	$credateEarliest->ColType = 'date';
	$credateLatest = new QueryField;
	$credateLatest->ColName = 'CreLatestDate';
	$credateLatest->ColType = 'date';

	$milAge = new QueryField;
	$milAge->ColName = 'MilAge';
	$milAge->ColType = 'integer';

	$milEnlistmentDate = new QueryField;
	$milEnlistmentDate->ColName = 'MilEnlistmentDate';
	$milEnlistmentDate->ColType = 'date';
	$milEmbarkmentDate = new QueryField;
	$milEmbarkmentDate->ColName = 'MilEmbarkmentDate';
	$milEmbarkmentDate->ColType = 'date';
	$milDischargeDate = new QueryField;
	$milDischargeDate->ColName = 'MilDischargeDate';
	$milDischargeDate->ColType = 'date';
	$milFateEarliestDate = new QueryField;
	$milFateEarliestDate->ColName = 'MilFateEarliestDate';
	$milFateEarliestDate->ColType = 'date';
	$milFateLatestDate = new QueryField;
	$milFateLatestDate->ColName = 'MilFateLatestDate';
	$milFateLatestDate->ColType = 'date';

	$earDatePublished = new QueryField;
	$earDatePublished->ColName = 'EarDatePublished';
	$earDatePublished->ColType = 'date';

	$this->Fields = array(  $objectHeader,	
				'TitMainTitle',
				'TitObjectType',
				'TitCollectionTitle',
				'TitAccessionNo',
				'CreCreatorLocal_tab',
				'CreDateCreated',
				$credateEarliest,
				$credateLatest,
				'CreCountry_tab',
				'CreCity_tab',
				'PhyMediaCategory',
				'PhyMedium',
				'TitTitleNotes',
				'CreSubjectClassification_tab',
				'NotNotes',
				'CrePrimaryInscriptions',
				'BibBibliographyRef_tab->ebibliography->SummaryData',
				'RefBibliographicNotes_tab',

				//'LocCurrentLocationRef->elocations->SummaryData',
				//'PhyTechnique',

                                // Sporting Person
                                // Object Type
				$sportHeader,
                                'SpoNameLocal',
                                'SpoSport',
                                'SpoHallOfFame',
                                'SpoBiography',
                                'SpoAchievements',

                                // Digger
                                // Object Type
				$diggerHeader,
                                'MilNameLocal',
                                'MilMaritalStatus',
                                //'MilAge',
				$milAge,
                                'MilRegimentalNumber',
                                'MilRank',
                                'MilUnit',
                                $milEnlistmentDate,
                                $milEmbarkmentDate,
                                $milDischargeDate,
                                $milFateEarliestDate,
                                $milFateLatestDate,
                                'MilFate',
                                'MilGeneralInfo',

                                // Earthquake
                                // Object Type
				$quakeHeader,
                                'EarAuthorRef_tab->eparties->SummaryData',
                                'EarAbstract',
                                'EarDocumentType',
                                'EarSourceTitle',
                                'EarSourceEdition',
                                $earDatePublished,
                                'EarPlace',
                                'EarPages',
				);

	$this->Hints = array(	'TitMainTitle'          => '[ eg. Portrait of a Strapper ]',
				'TitCollectionTitle' 	=> '[ eg. Snowball Collection ]',
				'TitObjectType' 	=> '[ Select from the list ]',
				'CreSubjectClassification_tab'=> '[ eg. Sport ]',
				'PhyMediaCategory'	=> '[ Select from the list ]',
				'PhyMedium'		=> '[ Select from the list ]',
				'CreCity_tab'		=> '[ Select from the list ]',
				'CreDateCreated'	=> '[ eg. 1983 ]',
				'PhyTechnique'		=> '[ eg. Hand Sewn ]',
				'CreCountry_tab' 	=> '[ Select from the list ]',
				'PhyMedium'	 	=> '[ eg. acrylic or aquatint ]',
				'PhyMediaCategory' 	=> '[ Select from the list ]',

				// dummy headers
				'CreEarliestDateOrig'           => '------------------------------',
				'Validation'		=> '------------------------------',
				'AdmPublishWebNoPasswordFlag'		=> '------------------------------',
				'AdmPublishWebPasswordFlag'		=> '-------------------------------',
				// dummy headers

				// sport
				'SpoSport'	 	=> '[ Select from the list ]',
				'SpoHallOfFame' 	=> '[ Select from the list ]',
                                'SpoNameLocal' 		=> '[ Name: eg. Bainbridge]',
				// Digger
                                'MilNameLocal'		=> '[ Name: eg. Abbott]',
				'MilMaritalStatus'	=> '[ Select from the list ]',
				'MilRank' 		=> '[ Select from the list ]',
                                'MilUnit' 		=> '[ Select from the list ]',
                                'MilEnlistmentDate'	=> '[ eg. 1916 ]',
                                'MilEmbarkmentDate'	=> '[ eg. 1916 ]',
                                'MilDischargeDate'	=> '[ eg. 1916 ]',
                                'MilFateEarliestDate'	=> '[ eg. 1916 ]',
                                'MilFateLatestDate'	=> '[ eg. 1916 ]',
				// Earthquake
				'EarDocumentType'	=> '[ Select from the list ]',
                                'EarAuthorRef_tab->eparties->SummaryData' => '[ Name: eg. Burges]',
                                'EarDatePublished' 	=> '[ eg. 1990]',
                                'EarPlace' 		=> '[ eg. Barton]',
                                'EarPages' 		=> '[ eg. 155]',
				);

	$this->DropDownLists = array(	
					//'PhyMedium' => '|Painting|Satin|Cardboard|Silk|Paper|Ink',
					//'PhyMediaCategory' => '|Documents|Music Sheet|3-Dimensional|Textile|Oral|Programmes|Paper|Music|Visuals|Audio|Photographs|Paper|Printed',
					'PhyMediaCategory' => 'eluts:Collection Area[2]',
					//'PhyMedium' => ''eluts:Collection Area[2]',
					'PhyTechnique' => '|Photographic|Printed|Hand Made|Painted|Glued|Bound',
					'TitObjectType' => 'eluts:Object Type',
					'CreCountry_tab' => 'eluts:Creator Location[1]',
					'CreCity_tab' => 'eluts:Creator Location[4]',
					// sport
					'SpoSport' => 'eluts:Sport',
					'SpoHallOfFame' => '|No|Yes',
					// Digger
					'MilMaritalStatus' => 'eluts:Marital Status',
					'MilRank' => 'eluts:Military Rank',
					'MilUnit' => 'eluts:Military Unit',
					// Earthquake
					'EarDocumentType' => 'eluts:NrmEarDocumentType',
				);

	$this->LookupLists = array (
					'TitCollectionTitle' => 'Collection Title',
					'CreSubjectClassification_tab' => 'Subject Classification',
				);
	}

} // End GalleryDetailedQueryForm class
?>
