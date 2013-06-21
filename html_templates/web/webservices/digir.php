<?php
### Copyright (c) 1998-2012 KE Software Pty Ltd
### @package EMuWebServices

### SET LARGE MEMORY LIMIT & LONG EXECUTION TIME LIMIT
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '-1');

if (!isset($WEB_ROOT))
        $WEB_ROOT = dirname(dirname(realpath(__FILE__)));
require_once($WEB_ROOT . '/objects/lib/webinit.php');
require_once($WEB_ROOT . '/webservices/digir/DigirProvider.php');

$start = time();
$provider = new DigirProvider();
$provider->log('Begin DiGIR Request');
if ($provider->configure() !== false && $provider->request() !== false)
{
	$provider->response();
}
else
{
	$provider->errorResponse();
}
$provider->log('Request took ' . (time() - $start) . ' second(s) to process');
$provider->log('End DiGIR Request');
exit(0);
?>
