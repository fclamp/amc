<?php
/*
**  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . '/objects/' . $GLOBALS['BACKEND_TYPE'] . '/' . ucfirst($GLOBALS['BACKEND_TYPE']) . 'QueryForms.php');

class
NmnhEntoBasicQueryForm extends NmnhBasicQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Entomology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata|IdeIdentifiedByLocal_tab',
		'taxonomy' 	=> 'IdeGenusLocal_tab|IdeSpeciesLocal_tab|IdeSubSpeciesLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeSubOrderLocal_tab|IdeFamilyLocal_tab',
		'place'		=> 'BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioVerbatimLocality',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab|IdeCombAuthorStringLocal_tab|IdeBasionymAuthorStringLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhEntoAdvancedQueryForm extends NmnhAdvancedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Entomology'";

	var $Options = array
	(		
		'any' 		=> 'SummaryData|AdmWebMetadata|IdeIdentifiedByLocal_tab',
		'taxonomy' 	=> 'IdeGenusLocal_tab|IdeSpeciesLocal_tab|IdeSubSpeciesLocal_tab|IdeClassLocal_tab|IdeOrderLocal_tab|IdeSubOrderLocal_tab|IdeFamilyLocal_tab',
		'place'		=> 'BioCountryLocal|BioDistrictCountyShireLocal|BioProvinceStateLocal|BioVerbatimLocality',
		'person' 	=> 'BioParticipantLocal_tab|IdeIdentifiedByLocal_tab|IdeCombAuthorStringLocal_tab|IdeBasionymAuthorStringLocal_tab',
	);
}
//=====================================================================================================
//=====================================================================================================
class
NmnhEntoDetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Entomology'";

	function
	NmnhEntoDetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$catNumber = new QueryField;
		$catNumber->ColName = 'CatNumber';
		$catNumber->ColType = 'integer';

		$dateFrom = new QueryField;
                $dateFrom->ColName = 'BioDateVisitedFromLocal';
                $dateFrom->ColType = 'date';

		$this->Fields = array
		(	
			$catNumber,
			'CatBarcode',
			'CatCollectionName_tab',
			'IdeClassLocal_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeQualifiedName_tab',
			'BioCountryLocal',
			'BioProvinceStateLocal',
			'BioDistrictCountyShireLocal',
			'BioParticipantLocal_tab',
			$dateFrom,
		);

		$this->Hints = array
		(	
			'CatNumber'			=> '[e.g. 70791]',
			'CatBarcode'			=> '[e.g. 00391587]',
			'CatCollectionName_tab'		=> '[Use to select primary types]',
			'IdeClassLocal_tab'		=> '[Select from list]',
			'IdeOrderLocal_tab'		=> '[Select from list]',
			'IdeFamilyLocal_tab'		=> '[Up to 3 leading characters narrows lookup]',
			'BioCountryLocal'		=> '[Select from list; e.g. United States]',
			'BioProvinceStateLocal'		=> '[e.g. Arizona]',
			'BioDistrictCountyShireLocal'	=> '[e.g. Pima]',
			'BioParticipantLocal_tab'	=> '[e.g. Jordan, D.S.]',
			'BioDateVisitedFromLocal'	=> '[e.g. 13-Aug-1953 or Aug-1953 or 1953]',
		);

		$this->DropDownLists = array
		(	
			'CatCollectionName_tab' 	=> '|Primary Types',
			'IdeClassLocal_tab'             => 'eluts:Taxonomy[6]',
			'IdeOrderLocal_tab'             => 'eluts:Taxonomy[9]',
			'BioCountryLocal' 		=> 'eluts:Continent[2]',
		);

		$this->LookupLists = array
		(
			'IdeFamilyLocal_tab'            => 'Taxonomy[14]',
		);
	}
}
//=====================================================================================================
//=====================================================================================================
###
### ILLUSTRATION ARCHIVE
###
class
NmnhEntoIADetailedQueryForm extends NmnhDetailedQueryForm
{
	var $Restriction = "CatMuseum = 'NMNH' AND CatDepartment = 'Entomology' AND CatCatalog = 'Illustration Archive'";

	function
	NmnhEntoIADetailedQueryForm()
	{
		$this->NmnhDetailedQueryForm();

		$this->Fields = array
		(	
			'CatOtherNumbersValue_tab',
			'IdeClassLocal_tab',
			'IdeOrderLocal_tab',
			'IdeFamilyLocal_tab',
			'IdeQualifiedName_tab',
			'ZooPreparedByRef_tab->eparties->SummaryData',
			'ZooPreparation_tab',
			'BioLiveSpecimen'
		);

		$this->Hints = array
		(	
			'CatOtherNumbersValue_tab'				=> '[e.g. 000040]',
			'IdeClassLocal_tab'					=> '[Select from list]',
			'IdeOrderLocal_tab'					=> '[Select from list]',
			'IdeFamilyLocal_tab'					=> '[Enter value or use button; up to 3 leading characters narrows lookup]',
			'IdeQualifiedName_tab'					=> '[Genus and/or species]',
			'ZooPreparedByRef_tab->eparties->SummaryData'		=> '[Select from list]',
			'ZooPreparation_tab'					=> '[Select from list]',
			'BioLiveSpecimen'					=> '[e.g. Habitus or Head or Genitalia]'
		);

		$this->DropDownLists = array
		(	
			'IdeClassLocal_tab'             		=> 'eluts:Taxonomy[6]',
			'IdeOrderLocal_tab'             		=> 'eluts:Taxonomy[9]',
			'ZooPreparedByRef_tab->eparties->SummaryData' 	=> '|Abbott, Lisa|Abbott, Tina|Adams, R.|Adamski, David|Allington, Sophie|Ando, T.|Arakawa, Kuniko|Asano, S.|Aul, Aime M.|B., R. W.|Barber, H. S.|Benson, Mary Foley|Biganzoli, Lisa|Blake, Doris H.|Bradford, H.|Brown, John W.|C., L. B.|C., M A.|Camargo, M. J.|Carvalho, R. S.|Chalkley|Chung, John|Conway, Katherine M.|Cooley, Mary Lou|Cushman, Art|Daishoji, K.|Dammers, C. M.|DeBord, Sara H.|Deleve, Joseph|Denno, Erik|Druckenbrod, Michael|Edmonson, E.|Eeugelhardt, Dentimunitu|Egbert, Addie|Eichlin, Thomas D.|Epstein, Mark E.|Escher, Susan|Flint, Oliver S. Jr.|Florenskaya, Natalia A.|Froeschner, Elsie H.|Gast, Caroline Bartlett|Glance, G.|Glorioso, Michael J.|Greene, Celeste|Greene, Charles T.|Griswald, Brit|Grossbeck, John A.|H., R. E,|Ham, J.|Hamilton, K. G. A.|Hasunuma, M.|Hayes, L. A.|Herbert, Caroline R.|Herdeonann|Herrera, Jose Alejandro|Hodges, Elaine R. S.|Hogue, Patricia J.|Hsu, A. N.|Hurd, Margaret E. Poor|Isham, P. J.|Janson, Andrew R.|Johnson, Phyllis Truth|K., T. J.|Kamei, K.|Kimura, Masashi|Knutson, Lloyd V.|Kramer, James P.|Lacy, Anne E.|Lawrence, Linda Heath|Lee|Leuckart|Lewis, Sue|Lipousky, J. L.|Lisa, M.|Longley, G.|Lutz, Caroline Bartlett|M., C. K.|Malikul, Vichai|Mazza, A. R.|McGinley, Ronald J.|Meyers, Elizabeth Keuther|Monros, F.|Noyes, Francis H.|Ohtawa, S.|Oldroyd|Osborn|P., M. A.|P., S.|Perkins, Philip D.|Pizzini, Andre del Campp|Poor, Margaret E.|Richmond, E. Avery|Roberts, Elizabeth|Roney, Deborah L.|Rozen, B. L.|Rozen, Jerome|S., C.|Sasaki, Y.|Sawamura, K.|Shibata, S.|Silve, Alberto|Smith, Arthur|Smith, Jung Lee|Sohn, Young T.|Spangler, Paul J.|Stromberg, Elinor P.|Swain, Susan Noguchi|Tamura, F.|Tanaka, C.|Terzi|Teteishi, A.|Todd, Edward|Tremouilles, C. R.|Unknown|Venable, George L.|White, Richard E.|Zimmer, Gloria Gordon',
			'ZooPreparation_tab'				=> '|Carbon|Computer|Etching|Gouache|Graphite|Ink|Mixed|Paint|Pen|Pencil|Photos|Prismacolor|Scratchboard|Watercolor'
		);

		$this->LookupLists = array
		(
			'IdeFamilyLocal_tab'            => 'Taxonomy[14]',
		);
	}
}
?>
