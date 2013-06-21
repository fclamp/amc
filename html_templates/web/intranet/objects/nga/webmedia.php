<?php

/*
*  Copyright (c) 1998-2009 KE Software Pty Ltd
*/

/*  Make sure we have all the right code available.
*/
if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(dirname(realpath(__FILE__)))));
require_once ($WEB_ROOT . '/objects/lib/webinit.php');
require_once ($LIB_DIR . 'common.php');
require_once ($LIB_DIR . 'media.php');

/*  Global variables.
*/
global $ALL_REQUEST;

/*  Load up the URL arguments so we can use them.
*/
$irn = $ALL_REQUEST['irn'];
if (isset($ALL_REQUEST['size']))
	$size = $ALL_REQUEST['size'];
if (isset($ALL_REQUEST['reftable']))
	$reftable = $ALL_REQUEST['reftable'];
if (isset($ALL_REQUEST['refirn']))
	$size = $ALL_REQUEST['refirn'];
if (isset($ALL_REQUEST['thumb']) && $ALL_REQUEST['thumb'] == 'yes')
	$size = 'thumb';

/*  If we do not have a reftable or refirn or we are showing a thumbnail
**  then we just show the image.
*/
if (! isset($reftable) || ! isset($refirn) || $size == 'thumb')
{
	$media = new MediaRetriever;
	$media->Intranet = 1;
	$media->ShowImage($irn, $size);
	return;
}

/*  We are showing the full media here so we need to figure out what
**  sort of media it is we are showing.
*/
$query = new Query;
$query->Select = array('MulMimeFormat');
$query->From = 'emultimedia';
$query->Where = "irn = $irn";
$matches = $query->Fetch();
if ($query->Matches == 0)
	WebDie("Cannot find media IRN $irn", 'webmedia.php');

/*  If the media is not an image then we just splat it at the screen
**  and let the browser handle it for us.
*/
if (! MediaRetriever::IsImage($matches[0]->MulMimeFormat))
{
	$media = new MediaRetriever;
	$media->Intranet = 1;
	$media->ShowImage($irn, $size);
	return;
}

/*  If we have an image we need to get the credit line for the image so
**  we can show it below the image. First we get the credit line.
*/
$query = new Query;
$query->Select = array('RigRightsRef_tab->erights->RigType',
                       'RigRightsRef_tab->erights->RigAcknowledgement');
$query->From = $reftable;
$query->Where = "irn = $refirn";
$matches = $query->Fetch();
if ($query->Matches == 0)
	WebDie("Cannot find $reftable IRN $refirn", 'webmedia.php');

/*  Now we have to go through each reference to see if there is a
**  credit lien to show.
*/
$index = 1;
$creditline = '';
while (isset($matches[0]->{'RigRightsRef:' . $index}))
{
	$reference = 'RigRightsRef:' . $index . '->erights';
	if (strtolower($matches[0]->{$reference . '->RigType'}) == 'web' &&
	    isset($matches[0]->{$reference . '->RigAcknowledgement'}))
	{
		if ($creditline != '')
			$creditline .= ' ';
		$creditline .= $matches[0]->{$reference . '->RigAcknowledgement'};
	}
	$index++;
}

/*  See if we have a credit line to show. If not then just splat the media
**  at the browser and let it handle it.
*/
if ($creditline == "")
{
	$media = new MediaRetriever;
	$media->Intranet = 1;
	$media->ShowImage($irn, $size);
	return;
}

/*  We have a credit line to show so we need a table to show it in. We
**  show the credit line below the image. First we show the image in a
**  table.
*/
Header('Content-type: text/html');
print "<TABLE border=0 cellpadding=1 cellspacing=0 width=\"1%\">\n";
print "<TR><TD>\n";
print "<IMG ";
print "src=\"/$WEB_DIR_NAME/intranet/objects/nga/webmedia.php";
print "?irn=" . $irn;
if ($size != '')
	print "&size=" . $size;
print "\" align=middle border=0>\n";
print "</TD></TR>\n";

/*  Now we can put out the credit line.
*/
print "<TR><TD>\n";
print "$creditline\n";
print "</TD></TR>\n";
print "</TABLE>\n";
?>
