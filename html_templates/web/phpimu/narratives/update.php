<?php
require_once(dirname(__FILE__) . "/common.php");

if (isset($_REQUEST['cart']) && $_REQUEST['cart'] != "")
	$Carts->setDefault($_REQUEST['cart']);
elseif (isset($_REQUEST['visible']) && $_REQUEST['visible'] != "")
	$Carts->visible = ! $Carts->visible;
elseif (isset($_REQUEST['showAssocs']) && $_REQUEST['showAssocs'] != "")
	$Carts->showAssocs = ! $Carts->showAssocs;
elseif (isset($_REQUEST['showObjects']) && $_REQUEST['showObjects'] != "")
	$Carts->showObjects = ! $Carts->showObjects;
else
{
	$cart = $Carts->getDefault();
	$index = 0;
	for (;;)
	{
		if (! isset($_REQUEST["irn$index"]))
			break;
		$irn = $_REQUEST["irn$index"];
		if (isset($_REQUEST["choice$index"]))
			$cart->add($irn);
		else
			$cart->remove($irn);
		$index++;
	}
}
$Carts->save();

Header("Location: " . $_SERVER['HTTP_REFERER']);
?>
