<?php

/**
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Portal.proc
 *
 */

$serviceName = 'KE EMu Web Portal';

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(realpath(__FILE__)));

require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . "/webservices/portal/$BACKEND_TYPE/PortalFactory.php");

/*  Create the portal handler and invoke the request. Note
 *  you need to change the class created for other protocols.
 */
$factory = new portalFactory();
if (! $portal = $factory->getInstance())
	Portal::errorResponse('Failure to get portal instance in portal.php');

/* if no args - display a query screen */
if ($portal->noArgsPassed())
{
	$portal->_request[queryScreen] = $portal->defaultQueryScreen;
}

if (! isset($_REQUEST['describe']))
{
	print $portal->request();
}
else
{
	// generate and display useage info for
	// this web service - remove if necessary

	$portal->useage(
		$serviceName,
		Array(
			'describe=...   ' => "this page",
			'queryScreen=...' => "show a query screen for driving the portal (initiates an active portal on submition)",
			'instance=XXXXXX' => "XXXXXX = string used to identify and maintain session (typically with portal query settings)",
			'source=XXXXXX' => "use portal source XXXXXX - source parameter can occur multiple times",
			'selected=N1,N2,N3...' => "mark records as selected",
			'selectByValue=FIELD:VALUE' => "mark as selected records with field FIELD = VALUE  - parameter can occur multiple times",
			'firstRec=N'	=> 'first record to display',
			'extractedOnly' => "",
			'forceSelected' => "",
			'timeout=N' => "max time in seconds to allow for query",
			'action' => "",
			'allStart' => "",
			'allLimit' => "maximum records in total to retrieve",
			'scatter=[true|false]' => "should portal get records across all sources or in order of sources (effects records where allLimit set below actual records available)",
			'sortby=FIELD' => "sort records by FIELD",
			'order' => "",
			'recordsPerPage' => "",
			'scrollLeft' => "",
			'scrollTop' => "",
			'search' => "the query",
			'transform=[simpleTransformation|xslt] ' => "method to transform XML.  If blank return raw XML",
			'stylesheet=XXXX' => "XSLT page or HTML template (to use with transform method)",
		),
		"\t\tThis service provides a data portal Service.\n".
		"\t\tIt can actively query for data using the portal sources\n".
		"\t\tconfigured for this '$BACKEND_TYPE' EMu client.\n".
		"\t\tGenerates raw XML than may then be styled server or\n".
		"\t\tbrowser side (or returned raw)"
	);
}

?>
