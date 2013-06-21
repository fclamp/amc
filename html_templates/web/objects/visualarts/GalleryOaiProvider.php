<?php
/*
** Copyright (c) 2005 - Ke Software Pty Ltd
*/

/*
** EXAMPLE OF HOW TO ENABLE AN OAI-PHM PROVIDER
*/

$ENABLE = 0;
//$ENABLE = 1;
if ($ENABLE != 1)
{
	die;
}

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/common/OaiProvider.php');

class
GalleryOaiProvider extends OaiProvider
{
	/*
	** Note all these variables are NOT set in an override of the
	**	constructor
	*/

	/*
	** Simple constants used to identify the Provider
	**	Note: EarliestDatestamp should be set to the client's
	**	go-live date for KE EMu, as this is the guaranteed oldest
	**	Last Modified date of any record
	*/
	var $RepositoryName = "KE EMu Gallery OAI-PHM Provider";
	var $AdminEmail = "alex.fell@kesoftware.com";
	var $EarliestDatestamp = "2000-01-01";

	function
	configure()
	{	
		/*
		** Important to call the base class configure() if we want DC fields
		*/
		Parent::configure();

		/*
		** Have to supply DC mapping on a per-client basis
		*/
		$oaidc_mapping = array(
			"dc:title"	=>	"TitMainTitle",
			"dc:creator"	=>	"CreCreatorLocal_tab",
			"dc:subject"	=>	"CreSubjectClassification_tab",
			"dc:description"=>	"CreCreationNotes",
			"dc:date"	=>	"CreDateCreated",
			"dc:publisher"	=>	"EdiPublisherRef->eparties->SummaryData",
			"dc:contributor"=>	"",
			"dc:type"	=>	"TitObjectType",
			"dc:format"	=>	"",
			"dc:identifier"	=>	"TitAccessionNo",
			"dc:source"	=>	"",
			"dc:language"	=>	"",
			"dc:relation"	=>	"",
			"dc:coverage"	=>	"",
			"dc:rights"	=>	"RigRightsRef_tab->erights->SummaryData",
		);
		/*
		** Set $oaidc_mapping as the field mapping for oai_dc:
		*/
		$this->setMapping("oai_dc", $oaidc_mapping);

		/*
		** Example of how to specify another type of mapping
		*/
		$pns_format = new OaiMetadataFormat();
		$pns_format->Format = "pns_dc";
		$pns_format->Mapping = array(
			"dc:title"	=>	"TitMainTitle",
			"dc:creator"	=>	"CreCreatorLocal_tab",
			"dc:subject"	=>	"CreSubjectClassification_tab",
			"dc:description"=>	"CreCreationNotes",
			"dc:date"	=>	"CreDateCreated",
			"dc:publisher"	=>	"EdiPublisherRef->eparties->SummaryData",
			"dc:contributor"=>	"",
			"dc:type"	=>	"TitObjectType",
			"dc:format"	=>	"",
			"dc:identifier"	=>	"TitAccessionNo",
			"dc:source"	=>	"",
			"dc:language"	=>	"",
			"dc:relation"	=>	"",
			"dc:coverage"	=>	"",
			"dcterms:rightsHolder"	=>	"RigRightsRef_tab->erights->SummaryData",
			"dcterms:audience"	=> 	"",
			/*
			** if you place the keyword "CONSTANT" in front of a value it denotes a value that
			**	is not an EMu field. If you place fieldnames inside %{...}% markers
			**	these will be substituted for field values.
			**	NOTE: only single-valued fields supported at present
			*/
			"pnsterms:thumbnail"	=>	"CONSTANThttp://victoria.man.kesoftware.com/webgallerytrain/objects/common/webmedia.php?irn=%{MulMultiMediaRef:1->emultimedia->irn_1}%&thumb=yes",
			);

		/*
		** We also need to define standard XML tags for our new mapping
		**	(the DC ones are done in the base class)
		*/
		/* First one is the header returned when Provider is asked what it supports */
		$pns_format->Header = "   <metadataFormat>\n".
			"    <metadataPrefix>pns_dc</metadataPrefix>\n".
			"    <schema>http://www.openarchives.org/OAI/2.0/oai_dc.xsd</schema>\n".
			"    <metadataNamespace>http://www.openarchives.org/OAI/2.0/oai_dc/</metadataNamespace>\n".
			"   </metadataFormat>\n";
		/* Second is the header surrounding each record */
		$pns_format->OpeningTag = "      <pns_dc:dc\n".
			'        xmlns:pns_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" '."\n".
			'        xmlns:dc="http://purl.org/dc/elements/1.1/" '."\n".
			'        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '."\n".
			'        xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ '."\n".
			'        http://www.openarchives.org/OAI/2.0/oai_dc.xsd">'."\n";
		$pns_format->ClosingTag = "	</pns_dc:dc>\n";
		
		/*
		** Finally add this new format to the array of formats to produce
		*/
		array_push($this->MetadataFormats, $pns_format);
	}
}

$galleryoai = new GalleryOaiProvider();
?>
