<?php

/**
 *  Copyright (c) 1998-2012 KE Software Pty Ltd
 *
 * @package EMuWebServices
 * @tutorial EMuWebServices/Mapper.proc
 *
 */


$serviceName = 'KE EMu Web Maps (Simple)';
$mapserverMapFile = 'simple.map';	// NB factory will take this from
					// client specific directory if it
					// exists
$extent = array(-180,-90,180,90);
$id = "main";

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(realpath(__FILE__)));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($WEB_ROOT . "/webservices/mapper/Mapper.php");
require_once ($WEB_ROOT . "/webservices/portal/$BACKEND_TYPE/FetcherDriverFactory.php");


// set parameters based on passed requests
if (isset($_REQUEST[id]))
	$id = $_REQUEST[id];
if (isset($_REQUEST[mapfile]))
	$mapserverMapFile = $_REQUEST[mapfile];
if (isset($_REQUEST[minlong]))
	$extent[0] = $_REQUEST[minlong];
if (isset($_REQUEST[minlat]))
	$extent[1] = $_REQUEST[minlat];
if (isset($_REQUEST[maxlong]))
	$extent[2] = $_REQUEST[maxlong];
if (isset($_REQUEST[maxlat]))
	$extent[3] = $_REQUEST[maxlat];

$htmlComplete = false;
if (isset($_REQUEST[htmlComplete]))
{
	$wantFullHtml = $_REQUEST[htmlComplete];
	if (preg_match('/Y|T|1/i',$wantFullHtml))
		$htmlComplete = true;
	else	
		$htmlComplete = false;
}

if (isset($_REQUEST[width]))
	$width = $_REQUEST[width];
else
	$width = 256;

if (isset($_REQUEST[height]))
	$height = $_REQUEST[height];
else
	$height = 128;


$xmlData = "<records>";
if (isset($_REQUEST[point]))
{
	foreach ($_REQUEST[point] as $point)
	{
		list($description,$lat,$long) = preg_split("/,/",$point,3); 
		$xmlData .= "<record><description>$description</description>" .
			"<latitude>$lat</latitude>" .
			"<longitude>$long</longitude>" .
			"</record>" ;
	}
}
$xmlData .= "</records>";

$_REQUEST['ForceExtent'] = true;
// make and set up mapper 
$mapper = new Mapper($mapserverMapFile);

$mapper->setMinResolution(0.02);
$mapper->allowExtentExpansion(false);
$mapper->showLabels(false);
$mapper->setExtent($extent[0],$extent[1],$extent[2],$extent[3]);

$mapper->setSize($width,$height);

// create fetcher to get data
$factory = new FetcherDriverFactory();
if (! $fetcherDriver = $factory->getInstance())
	WebServiceObject::errorResponse('Failure to get FetcherDriver instance in mapper.php');


$mapper->passive = false;

// get data
$mapper->request($fetcherDriver);

// make html response
header("Content-Type: text/html");

$map = $mapper->makeHtmlImageMap("${id}_map",$width,$height,25);
$html = "<div id='$id'>\n" .
	"\t<img src='$mapper->mapUrl' usemap=\"#${id}_map\"/ style='border: 0px'>\n" .
	"\t$map\n" .
	"</div>\n";
HTML;

if ($htmlComplete)
{
	$html = " <html>\n" .
		"\t<head><title>Simple Map</title></head>\n" .
		"\t<body style=\"border:0;overflow:hidden\">\n" .
		"$html\n" .
		"\t</body>\n" .
		"</html>";
}

print $html;

?>
