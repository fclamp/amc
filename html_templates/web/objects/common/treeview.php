<?php
/*
**	Copyright (c) 1998-2012 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));

require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . "texquery.php");
require_once($COMMON_DIR . "/RecordExtractor.php");

class
TreeElement
{
	var $Data;
	var $IRN;
	var $ChildTree = array();
}

class
TreeView extends BaseWebObject
{
	/*
	** Which Field to Display from EMu
	**	- multivalued fields will display the first value only
       	*/
	var $DisplayField	= "SummaryData"; 
	
	
	var $ExpandedIrns	= array();
	var $Tree;
	var $UseStyle		= 1;
	var $ParentRefField	= "ParParentRef";
	var $ImageDir;
	var $SelectedRecord;
	
	
	
	function
	TreeView()
	{
		$this->Tree = new TreeElement();
		$this->ImageDir = "/" . $GLOBALS['WEB_DIR_NAME'] . "/objects/images";
	}
	
	function
	ParseURL()
	{
		if (isset($_REQUEST['irn']) && is_numeric($_REQUEST['irn']))
		{
			$this->Tree->IRN = $this->GetMaster($_REQUEST['irn']);
			$this->ExpandedIrns[$this->Tree->IRN] = "e";
			$this->SelectedRecord = $_REQUEST['irn'];
		}
		else
		{
			if (isset($_REQUEST['m']) && is_numeric($_REQUEST['m']))
			{
				$this->Tree->IRN = $_REQUEST['m'];
				$this->ExpandedIrns[$this->Tree->IRN] = "e";
			}

			foreach ($_REQUEST as $key => $val)
			{
				if (is_numeric($key) && $val == "e")
				{
					$this->ExpandedIrns["$key"] = "e";
				}
				elseif ($val == "n")
				{
					/* Handles case where tree on master element is collapsed */
					$this->ExpandedIrns["$key"] = "n";
				}
				elseif ($key == "s" && is_numeric($val))
				{
					$this->SelectedRecord = $val;
				}
			}	
		}
	}

	function
	QueryMaster()
	{
		$qry = new Query();
		$qry->Select = array($this->DisplayField);
		$qry->From = $this->Database;
		$qry->Where = "irn_1=" . $this->Tree->IRN;
		$results = $qry->Fetch();
		if (preg_match("/_tab$/", $this->DisplayField))
		{
			$first = preg_replace("/_tab$/", ":1", $this->DisplayField);
			$this->Tree->Data = $results[0]->{$first};
		}
		else
			$this->Tree->Data = $results[0]->{$this->DisplayField};
	}

	function
	Show()
	{
		$this->ParseURL();
		$this->QueryMaster();
		$this->BuildTree($this->Tree);
		$this->PrintElement($this->Tree);
	}

	function
	GetMaster($irn)
	{
		$masterirn = "";
		$subirn = $irn;
		
		while ($subirn != "")
		{
			$qry = new Query();
			$qry->Select = array($this->ParentRefField);
			$qry->From = $this->Database;
			$qry->Where = "irn_1=" . $subirn;
			$results = $qry->Fetch();
			$subirn = $results[0]->{"$this->ParentRefField"};
			if (is_numeric($subirn))
			{
				$masterirn = $subirn;
				$this->ExpandedIrns["$masterirn"] = "e";
			}
		}

		if (is_numeric($masterirn))
			return $masterirn;
		else
			return $irn; /* It's possible this record is a master */
	}
	
	function
	BuildTree(&$TreeElement)
	{
		if ($this->ExpandedIrns["$TreeElement->IRN"] != "e")
			return;

		$qry = new Query();
		$qry->Limit = 0;
		$qry->Intranet = $this->Intranet;
		$qry->Select = array("irn_1", $this->DisplayField);
		$qry->From = $this->Database;
		$qry->Where = $this->ParentRefField . "=" . $TreeElement->IRN;
		$results = $qry->Fetch();

		/* TODO: handle failed query? */

		foreach ($results as $result)
		{
			$element = new TreeElement();
			if (preg_match("/_tab$/", $this->DisplayField))
			{
				$first = preg_replace("/_tab$/", ":1", $this->DisplayField);
				//$this->Tree->Data = $result->{$first};
				$element->Data = $result->{$first};
			}
			else				
				$element->Data = $result->{$this->DisplayField};
			
			$element->IRN = $result->{"irn_1"};
			$this->BuildTree($element);

			array_push($TreeElement->ChildTree, $element);
		 }	 
	}

	function
	PrintElement(&$TreeElement)
	{
		if ($this->UseStyle == "1")
		print "<style type=\"text/css\">#list-menu ul {list-style-type: none; }</style><div id=\"list-menu\">\n";
		print "<ul>\n";
		print "<li>";
		/* Print plus or minus */
		$imagedir = $this->ImageDir;
		if ($this->ExpandedIrns["$TreeElement->IRN"] == "e")
		{
			$link = $this->BuildURL() . "&" . $TreeElement->IRN . "=n" . "#" . $TreeElement->IRN ;
			print "<a name=\"$TreeElement->IRN\" href=\"$link\"><img alt=\"-\" src=\"$imagedir/minus.jpg\" onmouseover=\"this.src='$imagedir/minushover.jpg'\"; onmouseout=\"this.src='$imagedir/minus.jpg'\" border=\"0\"></a> ";
		}
		else
		{
			$link = $this->BuildURL() . "&" . $TreeElement->IRN . "=e" . "#" . $TreeElement->IRN;
			print "<a name=\"$TreeElement->IRN\" href=\"$link\"><img alt=\"-\" src=\"$imagedir/plus.jpg\" onmouseover=\"this.src='$imagedir/plushover.jpg'\"; onmouseout=\"this.src='$imagedir/plus.jpg'\" border=\"0\"></a> ";
		}
		
		
		/* Make bold if record is selected */
		if ($TreeElement->IRN == $this->SelectedRecord)
			print "<b>";
		print $TreeElement->Data;
		if ($TreeElement->IRN == $this->SelectedRecord)
			print "</b>";

		if (!empty($TreeElement->ChildTree))
			$this->PrintTree($TreeElement->ChildTree);
		elseif ($this->ExpandedIrns["$TreeElement->IRN"] == "e")
		{
			print"<ul><li><i>";//... no children</i></li></ul>\n";
			$this->Details($TreeElement->IRN);
			print"</i></li></ul>\n";
		}
		print "</li>\n";
		print "</ul>\n";
		if ($this->UseStyle == "1")
			print "</div>";
	}

	function
	PrintTree(&$tree)
	{
		foreach ($tree as $element)
			$this->PrintElement($element);
	}

	function
	BuildURL()
	{
		$url = WebSelf();
		$url .= "?m=" . $this->Tree->IRN;
		
		foreach ($this->ExpandedIrns as $key => $val)
		{
			if ($val == "e")
			{
				$url .= "&" . $key . "=e";
			}

		}

		if (isset($this->SelectedRecord))
			$url .= "&s=" . $this->SelectedRecord;

		return $url;
	}
	
	function
	Details($DetIRN)
	{
		/*
		 * You can override this if you want to show more stuff
		 */
		
		/*Get some data form the record
		*/
		$extractor = new RecordExtractor;
		$extractor->IRN = $DetIRN;
		$extractor->Database = $this->Database;
		$extractor->ExtractFields(array('irn_1'));
		
		//See if there is any multimedia 
		$imagecount = $extractor->MediaCount();
		
		//Build a link to a narratives display page 
		$NarURL = '<a href="' . $this->DisplayPage . '?irn=' . $DetIRN . '">View full details...</a>';

		//if there is an image display
		if($imagecount > 0)
			$extractor->PrintImage(90, 90, 1);

		//Display Link to Narrative Display
		print  $NarURL;
	
	}
}
?>
