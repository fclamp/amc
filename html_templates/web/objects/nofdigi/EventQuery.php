<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'texquery.php');
require_once($WEB_ROOT . '/objects/common/PreConfiguredQuery.php');

function
PrintEventQueryLink($resultspage)
{
	$query = new Query;
	$query->Select = array('ObjAttachedObjectsRef_tab');
	$query->From = 'eevents';

	$now = date("d M Y");
	$query->Where = "EveTypeOfEvent contains 'Exhibition'
			AND DatCompletionDate > DATE '$now' 
			AND DatCommencementDate < DATE '$now'";
	$query->All = 1;
	$query->Limit = 20;

	$results = $query->Fetch();

	$j = $i = 1;
	$where='';
	foreach($results as $rec)
	{
		$i = 1;
		while ($rec->{"ObjAttachedObjectsRef:$i"} != '')
		{
			if ($j>1)
				$where .=' OR ';
			$where .= "irn=" . $rec->{"ObjAttachedObjectsRef:$i"};
			$j++;
			$i++;
		}
	}

	if ($where !='')
		$where = "($where)";
	else
		$where = "false";

	$eventQuery = new PreConfiguredQueryLink;
	$eventQuery->Where = $where;
	$eventQuery->Limit = 20;
	$eventQuery->ResultsListPage = $resultspage;
	$eventQuery->PrintRef();
}

?>
