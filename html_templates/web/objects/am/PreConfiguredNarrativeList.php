<?php

require_once(dirname(realpath(__FILE__)) . "/../../objects/lib/texquery.php");


class PreConfiguredNarrativeList
{
	var $query = "";
	var $queryPage = "";
	var $displayPage = "";


	var $_currentResults = array();

	function
	PreConfiguredNarrativeList()
	{
		if ($this->queryPage == "")
		{
			$this->queryPage = "./NarrativeQuery.php";
		}
		if ($this->displayPage == "")
		{
			$this->displayPage = "./NarrativeDisplay.php";
		}
	}

	function _getNarratives()
	{
		$query = new Query();

		$query->Select = array("irn", "NarTitle");
		$query->From = "enarratives";
		$query->Where = "TRUE";
		$query->Limit = "";

		$this->currentResults = array();
		if ($this->query != "")
		{
			$query->Where = $this->query;
		}
		$this->_currentResults = $query->fetch();
	}

	function getArrayOfLinks()
	{
		$this->_getNarratives();

		$links = array();
		foreach ($this->_currentResults as $result)
		{
			$irn = $result->irn_1;
			$qp = $this->queryPage;
			$title = $result->NarTitle;

			$links[$title] = $this->displayPage . "?irn=$irn&QueryPage=$qp'";

		}
		ksort($links);
		return $links;
	}
}


?>

