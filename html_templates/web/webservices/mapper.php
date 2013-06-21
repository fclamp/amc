<?php

/**
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Mapper.proc
 *
 */

$serviceName = 'KE EMu Web Maps';
$mapperType = 'Standard';
$mapserverMapFile = 'standard.map';	// NB factory will take this from
					// client specific directory rather

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(realpath(__FILE__)));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . "/webservices/mapper/$BACKEND_TYPE/MapperFactory.php");
require_once ($WEB_ROOT . "/webservices/portal/$BACKEND_TYPE/FetcherDriverFactory.php");

if (isset($_REQUEST[mapfile]))
	$mapserverMapFile = $_REQUEST[mapfile];

if (isset($_REQUEST[type]))
{
	$mapperType = $_REQUEST[type];
	unset($_REQUEST[type]);
}

$factory = new mapperFactory();
if (! $mapper = $factory->getInstance($mapserverMapFile,$mapperType))
{
	WebServiceObject::errorResponse('Failure to get mapper instance in mapper.php');
}


if (! isset($_REQUEST['describe']))
{

	/*
 	* NB mapper can either be active or passive:
 	* - passive: mapper is passed record XML data to map 
 	* - active : mapper is responsible for finding data
 	*
 	* If active it will use a FetcherDriver object to get data
	*/

	if (isset($_REQUEST['passive']) && $_REQUEST['passive'] == 'true')
	{
		$fetcherDriver = null;
		$mapper->passive = true;
	}
	else
	{

		// if no parameters (or just a mapfile cookie) give a default queryscreen...
		if ($mapper->noArgsPassed())
		{
			$_REQUEST[queryScreen] = $mapper->defaultQueryScreen;
		}

		$factory = new FetcherDriverFactory();
		if (! $fetcherDriver = $factory->getInstance())
			WebServiceObject::errorResponse('Failure to get FetcherDriver instance in mapper.php');
		$mapper->passive = false;
	}

	print $mapper->request($fetcherDriver);

}	
else
{
	// generate and display useage info for this web service

	$mapper->useage(
		$serviceName,
		Array(
			'no options'     => "returns query-screen XML and a ".
				"default XSL stylesheet for HTML display",

			'describe=...'   => "show usage information",

			'instance=XXXXXX' => "XXXXXX = a string that can be ".
				"used to identify and maintain session. ".
				"Once a map has been drawn and an instance ".
				"created  you can call the mapper with just ".
				"the instance argument to generate a map based ".
				"on previous arguments - you don't need to ".
				"supply any other arguments (unless you want to ".
				"add new arguments or change previously set ".
				"ones).", 

			'queryScreen=XXXX.xsl' => "return query-screen XML. ".
				"and the passed XXXX.xsl stylesheet for ".
				"HTML display.",

			'passive=[true|false]'   => "sets mapper to passive ".
				"mode. If not specified assumes false. ".
				"In passive mode mapper will not query for ".
				"data but expects data to be supplied in ".
				"data=XXX parameter. ".
				"If active mode mapper will use any ".
				"configured FetcherDriver fetchers to get data.",

			'data=XXXX'      => "XML data to map (if in passive ".
				"mode eg when mapping data from EMu client)".
				"Requires a suitable translator to be ".
				"configured in the EMu webservices system ".
				"to handle this XML data",

			'translator=[emu|digir|...]' => "translator to use ".
				"for passed XML data.  (Only for use when ".
				"mapper in passive mode and data passed in ".
				"the data parameter).",

			'source[]=XXXX'     => "a data source when mapper in ".
				"active mode.  Corresponds to a FetcherDriver ".
				"fetcher (eg source=DefaultTexxml will use ".
				"the default EMu data source).  The system ".
				"will accept multiple sources providing they ".
				"are configured in the FetcherDriver fetcher system.",

			'search=XXX'      => "the search argument for FetcherDriver ".
				"fetcher queries (eg ".
				"SELECT ALL FROM ecatalogue WHERE SummaryData ".
				"CONTAINS 'foo' AND DarLatitude NOT NULL)",

			'sortby=FIELD'    => "FIELD to use as legend item (eg ".
				"sortby=Genus will display a legend of unique ".
				"generic terms and mark points appropriately)",

			'LAYER_NAME=[on|off]'  => "turn a specific map layer ".
				"on or off (eg LandSea_Topographic=on).  The ".
				"map layers on if no parameters set will ".
				"initially be those set on by default in the ".
				"map file or if passed an instance parameter, ".
				"those set in for that instance. May be many ".
				"LAYER_NAME= parameters.",

			'labels=[on|off]' => "show the label for mapped points",

			'minlat=NN'       => "minimum latitude of map to ".
				"display.  If not set uses default extent in ".
				"map file or previous value based on instance ".
				"Actual Map will adjust this value if ".
				"necessary to allow display to be the maps ".
				"configured extent however it will ensure the ".
				"region displayed will at least include all ".
				"the area specified by the minlat, minlong, ".
				"maxlat and maxlong extent",

			'minlong=NN'      => "minimum longitude of map to ".
				"display.  If not set uses default extent in ".
				"map file or previous value based on instance ".
				"Actual Map will adjust this value if ".
				"necessary to allow display to be the maps ".
				"configured extent however it will ensure the ".
				"region displayed will at least include all ".
				"the area specified by the minlat, minlong, ".
				"maxlat and maxlong extent",

			'maxlat=NN'       => "maximum latitude of map to ".
				"display.  If not set uses default extent in ".
				"map file or previous value based on instance ".
				"Actual Map will adjust this value if ".
				"necessary to allow display to be the maps ".
				"configured extent however it will ensure the ".
				"region displayed will at least include all ".
				"the area specified by the minlat, minlong, ".
				"maxlat and maxlong extent",

			'maxlong=NN'      => "maximum longitude of map to ".
				"display.  If not set uses default extent in ".
				"map file or previous value based on instance ".
				"Actual Map will adjust this value if ".
				"necessary to allow display to be the maps ".
				"configured extent however it will ensure the ".
				"region displayed will at least include all ".
				"the area specified by the minlat, minlong, ".
				"maxlat and maxlong extent",

			'action=[Query|Spatial|Map|ZoomIn|ZoomOut|Pan|ReDraw|]'
					=> "set mapper action mode. ".
				"Query = find points and display map, ".
				"Spatial = query for data from marked region".
				"Map = draw map (used with instance parameter ".
				"to return a map based on previous instance ".
				"settings).\n".
				"Other options not specifically used by Mapper ".
				"engine but will be returned in XML and can be ".
				"used to assist adding functionality to ".
				"user interface (eg selecting a tool based on ".
				"previous use)",

			'sessionCount=N'  => "parameter that can be used by ".
				"transformation to record history depth etc. ".
				"is echoed in map XML",

			'transform=[simpleTransformation|xslt|raw] '=> "method ".
				"to transform XML.  If raw or blank ".
				"returns raw XML.  simpleTranslation used with ".
				"HTML template stylesheets and done server side, ".
				"xslt for XSL stylesheets (in this case normal ".
				"action is to just includ the stylesheet with ".
				"XML for transformation browser side",

			'stylesheet=XXXX' => "XSLT page or HTML template ".
				"(to use with transform method)",

			'referer=XXXX'    => "will be echoed in XML.  (If not ".
				"set, XML referer element will contain web ".
				"server HTTP_REFERER environment parameter",

			'timeout'         => "maximum time mapper will allow ".
				"for any source to return data",

			'getPrevious'     => "return map display from history ".
				"of an instance. getPrevious=0 returns first ".
				"map displayed for this instance",

		),
		"\t\tThis service provides mapping of data points.\n".
		"\t\tIt can actively query for data using the FetcherDriver fetchers\n".
		"\t\tconfigured for this '$BACKEND_TYPE' EMu client or can map\n".
		"\t\tpassed XML record data.\n".
		"\t\tGenerates raw map XML than may then be styled server or\n".
		"\t\tbrowser side (or returned raw)".
		"\t\texamples:\n".
		"\tmapper.php?\n".
		"\t\t&amp;source=DefaultTexxml\n".
		"\t\t&amp;sortby=ScientificName\n".
		"\t\t&amp;timeout=25\n".
		"\t\t&amp;search=SELECT ALL FROM ecatalogue WHERE SummaryData CONTAINS 'Frog'\n".
		"\t\t&amp;stylesheet=/emuwebXXX/webservices/mapper/XXX/style/mapdisplay.html\n"

	);
}

?>
