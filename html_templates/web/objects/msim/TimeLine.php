<?php
/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(realpath(__FILE__))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($COMMON_DIR . 'PreConfiguredQuery.php');

/*
** MSIM Time Query.
**	this just simply encaptulates a preconfigured query
**	in a global function.
*/
function
MsimTimeQuery($lowerYear, $upperYear, $resultspage)
{
	$preqry = new PreConfiguredQueryLink;
	$preqry->ResultsListPage = $resultspage;
	$preqry->Where = "
	(
	exists (
		AssAssociationEarliestDate0 
		where AssAssociationEarliestDate >= DATE '$lowerYear' 
		)
	AND
	exists (
		AssAssociationEarliestDate0
		where AssAssociationEarliestDate <= Date '$upperYear'
		)
	)
	OR
	(
	exists (
		AssAssociationLatestDate0
		where AssAssociationLatestDate >= DATE '$lowerYear'
		)
	AND
	exists (
		AssAssociationLatestDate0
		where AssAssociationLatestDate0 <= DATE '$upperYear'
		)
	)";
	$preqry->PrintRef();
}


?>
