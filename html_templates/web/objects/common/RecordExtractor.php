<?php
/*
*  Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'configuredquery.php');
require_once($LIB_DIR . 'common.php');

/*
** These object provides functionality for add-hoc page layout for 
** record display pages.
**
** Example 1:
**	$extractor = new RecordExtractor;
**	$extractor->ExtractFields(array('TitMainTitle', 'DesDescription'));
**	$extractor->PrintField('TitMainTitle');
**
** Example 2:
**	$e = new RecordExtractor;
**	$e->ExtractFields(array('SummaryData', "CreSubjectClassification_tab", "CreCreatorRef_tab->eparties->SummaryData"));
**	print "<b>";
**	$e->PrintField('SummaryData');
**	print "</b>";
**	$e->PrintMultivalueField("CreSubjectClassification_tab");
**	$e->PrintLinkedField("CreCreatorRef:1->eparties->SummaryData", "test.php");
**	$e->PrintImage(600, 600, 1);
*/


class
RecordExtractor extends BaseWebObject
{

	var $IRN;
	var $Where;
	var $LanguageData 	= "";
	var $Database 		= "ecatalogue";
	var $Intranet		= 0;
	var $NullFieldHolder	= "";

	var $_fields		= array();

	function
	RecordExtractor()
	{
		global $ALL_REQUEST;
		$this->IRN = $ALL_REQUEST['irn'];
		$this->Where = $ALL_REQUEST['Where'];

		$this->BaseWebObject();
	}

	function
	ExtractFields($fieldArray)
	{
		// always bring back irn and media image data
		if ($this->Database == "emultimedia")
		{
			$fieldArray = array_merge($fieldArray, array("irn"));
		}
		else
		{
			$fieldArray = array_merge($fieldArray, 
					array("irn", "MulMultiMediaRef_tab"));
		}
		$q = new ConfiguredQuery;
		$fields = $fieldArray;
		$q->Select = $fields;
		$q->From = $this->Database;
		$where = "";
		if (isset($this->Where) && $this->Where != "")
		{
			$where = $this->Where;
		}
		else
		{
			$where = "irn = " . $this->IRN;
		}

		$q->Where = $where;
		$q->Limit = 1;
		$q->Intranet = $this->Intranet;
		$q->SelectedLanguage = $this->LanguageData;

		$this->_fields = $q->Fetch();
		
	}

	function
	HasValidRecord()
	{
		// Test for a valid IRN
		$irn = $this->_fields[0]->{"irn_1"};
		return(isset($irn) && is_numeric($irn));
	}

	function
	PrintField($fieldName, $rawDisplay=0)
	{
		$this->printData($this->_fields[0]->{$fieldName}, $rawDisplay);
	}

	function
	FieldAsValue($fieldName)
	{
		return $this->_fields[0]->{$fieldName};
	}

	function
	PrintMultivalueField($fieldName)
	{
		$r = $this->MultivalueFieldAsArray($fieldName);
		foreach ($r as $result)
		{
			$this->printData($result);
			print "<br />";
		}
		if (empty($r))
			$this->printData("");
	}

	function
	MultivalueFieldAsArray($fieldName)
	{
		if (!preg_match('/_tab/', $fieldName) && !preg_match('/[^:\d]0$/', $fieldName))
		{
			WebDie("Not a multi value field");
		}
		
		$r = array();
		$modname = "";
		$i = 1;
		while (1)
		{
			if (preg_match('/_tab/', $fieldName))
				$modname = str_replace("_tab", ":$i", $fieldName);
			elseif (preg_match('/[^:\d]0$/', $fieldName))
				$modname = preg_replace('/0$/', ":$i", $fieldName);

			if (!isset($this->_fields[0]->{"$modname"}))
				break;
				
			array_push($r, $this->_fields[0]->{"$modname"});
			$i++;
		}
		return $r;
	}


	function
	PrintLinkedField($fieldName, $linkedPage, $additionalURLParms="")
	{
		if (!preg_match('/->/', $fieldName))
		{
			WebDie("Invalid Field set in 'PrintLinkedField'");
		}
		$sections = split('->', $fieldName);
		$linkirn = $this->_fields[0]->{$sections[0]};
		global $ALL_REQUEST;
		$querypage = $ALL_REQUEST['QueryPage'];

		$link = "$linkedPage?irn=$linkirn";
		if ($querypage != "")
		{
			$link .= "&amp;QueryPage=$querypage";
		}
		if ($additionalURLParms != "")
		{
			$link .= "&amp;" . $additionalURLParms;
		}

		print "<a class=\"KEWebLink\" href=\"$link\">";
		$this->printData($this->_fields[0]->{$fieldName});
		print "</a>";
	}

	function
	PrintMultivalueLinkedField($fieldName, $linkedPage, $additionalURLParms="")
	{
		if (!preg_match('/->/', $fieldName)
			|| ! preg_match('/_tab/', $fieldName))
		{
			WebDie("Invalid Field set in 'PrintMultivalueLinkedField'");
		}
		global $ALL_REQUEST;
		$querypage = $ALL_REQUEST['QueryPage'];

		$sections = split('->', $fieldName);
		$refcol = preg_replace("/_tab/", "", $sections[0]);
		$i = 1;
		while (isset($this->_fields[0]->{"$refcol:$i"}))
		{
			$linkirn = $this->_fields[0]->{"$refcol:$i"};
			$link = "$linkedPage?irn=$linkirn";
			if ($querypage != "")
			{
				$link .= "&amp;QueryPage=$querypage";
			}
			if ($additionalURLParms != "")
			{
				$link .= "&amp;" . $additionalURLParms;
			}

			$fieldName = "$refcol:$i" . "->" . $sections[1] . "->" . $sections[2];
			print "<a class=\"KEWebLink\" href=\"$link\">";
			$this->printData($this->_fields[0]->{$fieldName});
			print "</a><br />";
			$i++;
		}
		// test for no output.  if so, call printData with no output
		if ($i == 1)
			$this->printData("");
	}
		

	function
	BackReferenceFieldsAsObjectArray($refDatabase, $refField, $colName)
	{
		// fetch backreference data in a second query
		$qry = new ConfiguredQuery();
		$qry->SelectedLanguage = $this->LanguageData;
		$qry->Intranet = $this->Intranet;
		$qry->Select = array("irn", $colName);
		$qry->From = $refDatabase;
		$qry->Limit = 0;
		$matches = array();
		if (preg_match('/^(.+?)_tab$/', $refField, $matches))
		{
			$subcol = $matches[1];
			$qry->Where = "EXISTS($refField WHERE $subcol=" . $this->IRN . ")";
		}
		else
			$qry->Where =  $refField . "=" . $this->IRN;

		$r = array();
		$records = $qry->Fetch();
		foreach ($records as $record)
		{
			$backref->IRN = $record->{irn_1};
			if (preg_match('/^(.+?)_tab$/', $colName))
			{
				$row = 1; 
				$fieldData = "";
				$copyname = preg_replace('/_tab/', ":$row", $colName);
				while(isset($record->{$copyname}))
				{
					if ($row != 1)
						$fieldData .= "\n";

					$fieldData .= $record->{$copyname};
					$row++;
					$copyname = preg_replace('/:[0-9]+/', ":$row", $copyname);
				}
				$backref->Data = $fieldData;
			}
			else
				$backref->Data = $record->{$colName};

			array_push($r, $backref);
		}
		return $r;
	}

	function
	BackReferenceFieldAsArray($refDatabase, $refField, $colName)
	{
		$a = $this->BackReferenceFieldsAsObjectArray(
					$refDatabase, 
					$refField, 
					$colName);
		$r = array();
		foreach($a as $o)
		{
			array_push($r, $o->Data);
		}
		return $r;
	}

	function
	PrintBackReferenceField($refDatabase, $refField, $colName)
	{
		$a = $this->BackReferenceFieldsAsObjectArray(
					$refDatabase, 
					$refField, 
					$colName);
		foreach ($a as $o)
		{
			$this->printData($o->Data);
			print "<br />";
		}
	}

	function
	PrintBackReferenceFieldAsLink($refDatabase, $refField, $colName, $linkPage)
	{
		$a = $this->BackReferenceFieldsAsObjectArray(
					$refDatabase, 
					$refField, 
					$colName);

		foreach ($a as $o)
		{
			$linkirn = $o->IRN;
			$link = "$linkPage?irn=$linkirn";
			if ($querypage != "")
			{
				$link .= "&amp;QueryPage=$querypage";
			}
			print "<a class=\"KEWebLink\" href=\"$link\">";
			$this->printData($o->Data);
			print "</a>";
			print "<br />";
		}
	}

	function
	PrintImage($width=190, $height=190, $imageNumber=1, $link="DEFAULT", $newwindow=0, $cssdimensions=0)
	{
		// The MediaImage will select the most appropriate size for us.
		// If $link is set, then we pass this through to MediaImage
		$image = new MediaImage;
		if ($link != "DEFAULT")
			$image->Link = $link;
		$image->ShowBorder = 0;
		$image->Intranet = $this->Intranet;
		if ($this->Database == "emultimedia")
		{
			$image->IRN = $this->_fields[0]->{"irn_1"};
		}
		else
		{
			$image->IRN = $this->_fields[0]->{"MulMultiMediaRef:$imageNumber"};
		}
		$image->Width = $width;
		$image->Height = $height;
		if ($cssdimensions == 1)
			$image->StyleSize = 1;
		if ($newwindow == 1)
			$image->NewWindow = 1;
		if ($this->ImageDisplayPage != "")
		{
			$image->ImageDisplayPage = $this->ImageDisplayPage;
		}
		elseif($this->Intranet)
		{
			$image->ImageDisplayPage = $GLOBALS['INTRANET_DEFAULT_IMAGE_DISPLAY_PAGE'];
		}	
		else
		{
			$image->ImageDisplayPage = $GLOBALS['DEFAULT_IMAGE_DISPLAY_PAGE'];
		}
		$image->Show();
	}
	
	function
	MediaCount()
	{
		// Return the number of media records attached to the catalogue
		for ($i = 1; isset($this->_fields[0]->{"MulMultiMediaRef:$i"}); $i++)
		{
		}
		return $i - 1;
	}

	function
	HasData($field)
	{
		// Test for data in field - return true or false
		return (isset($this->_fields[0]->{$field})
			&& $this->_fields[0]->{$field} != "");
	}

	function
	printData($data, $raw=0)
	{
		if ($raw == 0)
		{
			$data = htmlspecialchars($data);
			$data = preg_replace('/\\r?\\n/', "<br />\n", $data);
		}
		if ($data == "")
			$data = $this->NullFieldHolder;
			
		print $data;
	}
}


// Test Code

/*
$e = new RecordExtractor;
$e->ExtractFields(array('SummaryData', "CreSubjectClassification_tab", "CreCreatorRef_tab->eparties->SummaryData"));
$e->PrintField('SummaryData');
$e->PrintMultivalueField("CreSubjectClassification_tab");
$e->PrintLinkedField("CreCreatorRef:1->eparties->SummaryData", "test.php");

$e->PrintImage(600, 600, 1);
*/

?>
