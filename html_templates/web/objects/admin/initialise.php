<?php
/*
** Copyright (c) 1998-2012 KE Software Pty Ltd
*/

/*
*  This file is run after system install or when settings have
*  changed and the cache needs regenerating.
*/

if (!isset($WEB_ROOT))
	$WEB_ROOT = dirname(dirname(dirname(__FILE__)));
require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($LIB_DIR . 'texquery.php');

global $ALL_REQUEST;
if ($ALL_REQUEST['cryptpasswd'] != md5($GLOBALS['ADMIN_PASSWORD']))
{
	print "<H1>Access Denied</H1>";
	Die();
}


// Cache Important system values form both luts and the registry
$SYSTEM_CACHE_FILE = $CACHE_DIR . 'system.php';

// Query on eluts and extract System default values
$qry = new Query();
$qry->Select = array('Value000', 'Value001', 'Value002', 'Name');
$qry->From = 'eluts';
$qry->All = 1;
$qry->Limit = 0;
$qry->Where = "Name contains '^system' and SummaryData contains 'system'";
$lutsrecords = $qry->Fetch();
if (count($lutsrecords) < 1)
	WebDie("Error... Could not find system records in 'eluts'");

// Query on registry and extract important keys 
// (at the moment only language settings)
$qry = new Query();
$qry->Select = array('Key1', 'Key2', 'Key3', 'Key4', 'Key5', 'Value');
$qry->From = 'eregistry';
$qry->All = 1;
$qry->Limit = 0;
$qry->Where = "	Key1 	 = 'System' 
		and Key2 = 'Setting'
		and Key3 = 'Language'";
$registryrecords = $qry->Fetch();
if (count($registryrecords) < 1)
	WebDie("Error... Could not find system records in 'eluts'");

$fp = fopen($SYSTEM_CACHE_FILE, 'w');
if (!$fp)
{
	WebDie("Can't write to the cache.  Please check the permissions on the cache directory and its files.\n");
}
fwrite($fp, "<?php\n\n");
fwrite($fp, "// ATTENTION: This file is automatically generated.\n");
fwrite($fp, "// DO NOT MODIFY.\n\n");

fwrite($fp, 'global $LUTS_CACHE;' . "\n");
fwrite($fp, 'global $REGISTRY_CACHE;' . "\n\n");

foreach($lutsrecords as $rec)
{
	$out = '$LUTS_CACHE["' . strtolower($rec->Name) . '"]';
	fwrite($fp, $out);
	fwrite($fp, ' = "');
	fwrite($fp, $rec->Value000);
	for($i = 1; $rec->{"Value00$i"}; $i++)
	{
		fwrite($fp, ';:;' . $rec->{"Value00$i"});
	}
	fwrite($fp, "\";\n");
}
fwrite($fp, "\n");

foreach($registryrecords as $rec)
{
	$keyid = strtolower($rec->Key1);
	if ($rec->Key2 != "")
		$keyid .= "-" . strtolower($rec->Key2);
	if ($rec->Key3 != "")
		$keyid .= "-" . strtolower($rec->Key3);
	if ($rec->Key4 != "")
		$keyid .= "-" . strtolower($rec->Key4);
	if ($rec->Key5 != "")
		$keyid .= "-" . strtolower($rec->Key5);

	fwrite($fp, '$REGISTRY_CACHE["' . $keyid . "\"]");
	fwrite($fp, ' = "');
	fwrite($fp, $rec->Value);
	fwrite($fp, "\";\n");
}


fwrite($fp, "\n?>\n");
fclose($fp);

print "<H1>Initialise Complete</H1>\n";
?>
