<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . '/texquery.php');

/*
** Main class
** 	Note: To provide a new type of provider, you need to override this class.
**	Unless what you are doing is very specific it's probably worth doing this at the end of this file
**		to keep everything together. See OaiDcHandler below for an example, then:
**		~emu/web/objects/mcag/McagOaiProvider.php
**		for how to actually get it working for a specific client's mapping
*/
class
OaiHandler
{
	var $Format = "";
	var $DataOpeningTag = "";
	var $DataClosingTag = "";
	var $Header = "";

	function
	processGetRecord(&$response)
	{
		/* Die if identifier not pure numbers (as we use IRN's) */
		if (!is_numeric($_REQUEST['identifier']))
		{
			$response = "idDoesNotExist";
			return 0;
		}

		$irn = $_REQUEST['identifier'];

		$where = "irn_1=$irn";

		$restriction = $this->getRestriction();
		if (!empty($restriction))
		{
			$where = "($where) and ($restriction)";
		}
		
		$qry = new Query();
		$qry->Select = $this->getSelectArray();
		$qry->From = "ecatalogue";
		$qry->Where = $where;
		$record = $qry->Fetch();

		if (!isset($record[0]))
		{
			$response = "idDoesNotExist";
			return 0;
		}

		$response .= "  <GetRecord>\n";
		$response .= $this->formRecord($record[0]);
		$response .= "  </GetRecord>\n";
		return 1;;
	}

	function
	processListRecords($start, $from, $until, &$response)
	{
		$qry = new Query();
		$qry->Select = $this->getSelectArray();
		$qry->From = "ecatalogue";
		
		$where = $this->buildDateRangeWhere($from, $until);
		if (empty($where))
		{
			$response = "badArgument";
			return 0;
		}

		$restriction = $this->getRestriction();
		if (!empty($restriction))
		{
			$where = "($where) and ($restriction)";
		}

		$qry->Where = $where;
		$qry->Limit = 50;
		$qry->Offset = $start;
		$records = $qry->Fetch();

		if ($qry->Matches < 1)
		{
			$response = "noRecordsMatch";
			return 0;
		}
		
		$resumptionToken = "";
		if ($qry->Matches > ($qry->Offset + $qry->Limit))
		{
			$resumptionToken = $this->encodeResumptionToken($qry->Offset + $qry->Limit,
			$from, $until);
		}

		/*
		** Form record
		*/
		$response .= "  <ListRecords>\n";
		for($i=0; $i<count($records); $i++)
		{
			$response .= $this->formRecord($records[$i]);
		}
		$response .= $this->formResumptionTag($qry->Matches, $qry->Offset, $resumptionToken);
		$response .= "  </ListRecords>\n";
		
		return 1;
	}

	function
	processListIdentifiers($start, $from, $until, &$response)
	{
		/*
		** Build texql where and incorporate 'from' and 'until' if supplied
		*/
		$where = $this->buildDateRangeWhere($from, $until);
		if (empty($where))
		{
			$response = "badArgument";
			return 0;
		}

		$restriction = $this->getRestriction();
		if (!empty($restriction))
		{
			$where = "($where) and ($restriction)";
		}
	
		/*
		** Run query
		*/
		$qry = new Query();
		$qry->Select = array("AdmDateModified","irn_1");
		$qry->From = "ecatalogue";
		$qry->Where = $where;
		$qry->Limit = 50;
		$qry->Offset = $start;
		$records = $qry->Fetch();

		if ($qry->Matches < 1)
		{
			$response = "noRecordsMatch";
			return 0;
		}

		$resumptionToken = "";
		if ($qry->Matches > ($qry->Offset + $qry->Limit))
			$resumptionToken = $this->encodeResumptionToken($qry->Offset + $qry->Limit,
				$from, $until);
	
		/*
		** form response and show
		*/
		$response .= "  <ListIdentifiers>\n";
		for ($i=0; isset($records[$i]); $i++)
		{
			$response .= $this->formHeader($records[$i]->{"irn_1"}, $records[$i]->{"AdmDateModified"});
		}
		$response .= $this->formResumptionTag($qry->Matches, $qry->Offset, $resumptionToken);
		$response .= "  </ListIdentifiers>\n";

		return 1;
	}

	function
	processListMetadataFormats()
	{
		return $this->Header;
	}

	function
	getRestriction()
	{
		return "";
	}
	
	function
	encodeResumptionToken($start, $from, $until)
	{
		$unencoded = $start . "%" . $from . "%" . $until . "%" . $this->Format;
		return urlencode(base64_encode($unencoded));
	}

	function
	formResumptionTag($matches, $startat, $token)
	{
		$tag .= "    <resumptionToken \n".
			"      completeListSize=\"$matches\" \n".
			"      cursor=\"$startat\">$token</resumptionToken>\n";

		return $tag;
	}
	
	function
	formHeader($id, $emudate)
	{
		$datestamp = "";
		if (preg_match("/(\d+)\/(\d+)\/(\d+)/", $emudate, $matches))
			$datestamp = $matches[3] . "-" . $matches[2] . "-" . $matches[1];
		
		$string = 	"    <header>\n".
		$string .=	"     <identifier>" . htmlspecialchars(utf8_encode($id)) . "</identifier>\n";
		$string .=	"     <datestamp>" . htmlspecialchars(utf8_encode($datestamp)) . "</datestamp>\n";
		$string .=	"    </header>\n";

		return $string;
	}

	function
	formRecord(&$record)
	{
		$string = "";
		
		/*
		** Display header
		*/
		$string .= "   <record>\n";
		$string .= $this->formHeader($record->{"irn_1"}, $record->{"AdmDateModified"});

		/*
		** Start record
		*/
		$string .=	"    <metadata>\n";
		$string .= $this->DataOpeningTag;
	
		/*
		** Form the main XML of the record
		*/
		$string .= $this->formMainXml($record);
		
		/*
		** Close the record off
		*/
		$string .= $this->DataClosingTag;
		$string .= "    </metadata>\n".
			"   </record>\n";

		return $string;
	}

	function
	formMainXml(&$record)
	{
		/*
		** Virtual function: override in child class
		*/
		return "";
	}

	function
	buildDateRangeWhere($from, $until)
	{
		$where = "";
		if (!empty($from) || !empty($until))
		{
			if ($from == $until)
			{
				$date = $this->datetoemudate($from);
				if (empty($date))
					return "";

				$where .= "(AdmDateModified LIKE DATE '$date')";
			}
			else
			{
				if (!empty($from))
				{
					$date = $this->datetoemudate($from); 
					if (empty($date))
						return "";

					$where .= "(AdmDateModified > DATE '" . $date . "'".
						" OR AdmDateModified LIKE DATE '" . $date . "')";
				}
				if (!empty($until))
				{
					if (!empty($where))
						$where .= " AND ";

					$date = $this->datetoemudate($until);
					if (empty($date))
						return "";
						
					$where .= "(AdmDateModified < DATE '" . $date . "'".
						" OR AdmDateModified LIKE DATE '" . $date . "')";
				}
			}
		}
		else
		{
			$where = "true";
		}
		
		return $where;
	}

	function
	datetoemudate($date)
	{
		$string = "";
		if (preg_match("/(\d\d\d\d)-(\d\d)-(\d\d)/", $date, $matches))
		{
			$string = $matches[3] . "/" . $matches[2] . "/" . $matches[1];
		}

		return $string;
	}
}

class
OaiDcHandler extends OaiHandler
{
	function
	OaiDcHandler()
	{
		$this->Format = "oai_dc";
		$this->Header = "   <metadataFormat>\n".
			"    <metadataPrefix>oai_dc</metadataPrefix>\n".
			"    <schema>http://www.openarchives.org/OAI/2.0/oai_dc.xsd</schema>\n".
			"    <metadataNamespace>http://www.openarchives.org/OAI/2.0/oai_dc/</metadataNamespace>\n".
			"   </metadataFormat>\n";
		$this->DataOpeningTag = "      <oai_dc:dc\n".
			'        xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/" '."\n".
			'        xmlns:dc="http://purl.org/dc/elements/1.1/" '."\n".
			'        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '."\n".
			'        xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ '."\n".
			'        http://www.openarchives.org/OAI/2.0/oai_dc.xsd">'."\n";
		$this->DataClosingTag = "      </oai_dc:dc>\n";
	}
}

class
PndsDcHandler extends OaiHandler
{
	function
	PndsDcHandler()
	{
		$this->Format = "pnds_dc";
		$this->Header = "   <metadataFormat>\n".
			"    <metadataPrefix>pnds_dc</metadataPrefix>\n".
			"    <schema>http://www.ukoln.ac.uk/metadata/pns/pndsdcxml/2005-06-13/xmls/pndsdc.xsd</schema>\n".
			"    <metadataNamespace>http://purl.org/mla/pnds/pndsdc/</metadataNamespace>\n".
			"   </metadataFormat>\n";
		$this->DataOpeningTag = "      <pndsdc:description\n".
			'        xmlns:dc="http://purl.org/dc/elements/1.1/"'."\n".
			'        xmlns:dcterms="http://purl.org/dc/terms/"'."\n".
			'        xmlns:pndsterms="http://purl.org/mla/pnds/terms/"'."\n".
			'        xmlns:pndsdc="http://purl.org/mla/pnds/pndsdc/"'."\n".
			'        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\n".
			'        xsi:schemaLocation="http://purl.org/mla/pnds/pndsdc/'."\n".
			'                            http://www.ukoln.ac.uk/metadata/pns/pndsdcxml/2005-06-13/xmls/pndsdc.xsd"'."\n".
			'      >'."\n";
			
		$this->DataClosingTag = "      </pndsdc:description>\n";
	}
}
?>
