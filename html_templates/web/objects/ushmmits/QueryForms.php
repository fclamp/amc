<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'BaseQueryForms.php');

class
UshmmitsDetailedQueryForm extends BaseDetailedQueryForm
{

	function
	UshmmitsDetailedQueryForm()
	{
		$irn = new QueryField;
		$irn->ColType = "integer";
		$irn->ColName = "irn_1";

		$pagecount = new QueryField;
		$pagecount->ColType = "integer";
		$pagecount->ColName = "PageCount";

		$imagevers = new QueryField;
		$imagevers->ColType = "integer";
		$imagevers->ColName = "ImageVersion";

		$datavers = new QueryField;
		$datavers->ColType = "integer";
		$datavers->ColName = "DataVersion";

		$newdoc = new QueryField;
		$newdoc->ColType = "integer";
		$newdoc->ColName = "NewDoc";

		$filingno = new QueryField;
		$filingno->ColType = "integer";
		$filingno->ColName = "FilingNo";

		$seqno = new QueryField;
		$seqno->ColType = "integer";
		$seqno->ColName = "SequenceNo";

		$datefrom = new QueryField;
		$datefrom->ColType = "date";
		$datefrom->ColName = "DateFrom";

		$listtype = new QueryField;
		$listtype->ColType = "integer";
		$listtype->ColName = "ListType";

		$datebirth = new QueryField;
		$datebirth->ColType = "date";
		$datebirth->ColName = "DateOfBirth";

		$number = new QueryField;
		$number->ColType = "integer";
		$number->ColName = "Number";

		$this->Fields = array(
			$irn,
			"DocId",
			"InventoryNo",
			$pagecount,
			"MimeType",
			$imagevers,
			$datavers,
			"AUNumber",
			"AUType",
			$newdoc,
			"ContainerName",
			$filingno,
			"PageNo",
			$seqno,
			"DocCategory",
			"Nationality",
			$datefrom,
			"RefCC",
			"LocInfo",
			"LocDetails",
			"LocDetailsType",
			$listtype,
			"LastName",
			"FirstName",
			"MaidenName",
			$datebirth,
			$number,
				);


		$this->BaseDetailedQueryForm();
	}

} // End UshmmitsDetailedQueryForm class
?>
