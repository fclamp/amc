<?php
require_once(dirname(__FILE__) . "/../common.php");
require_once("$WEB_ROOT/tables/objects.php");


// Header and footer
function objectStyles()
{
	global $urlRoot;
	global $WEB_ROOT;
	$css = "$urlRoot/objects/styles.css";
	$js = "$WEB_ROOT/objects/script.js";
?>
<link rel="stylesheet" type="text/css" href="<?php echo $css ?>" />
<!--
<script type="text/javascript" src="<?php echo $js ?>"></script>
-->
<script type="text/javascript">
<?php
include($js);
?>
</script>
<?php
}

function objectHeader($title)
{
	pageHeaderBegin($title);
	objectStyles();
	pageHeaderEnd();
}

function objectFooter()
{
	pageFooter();
}


// Form
function showFormBegin()
{
if (false)
{
?>
<form name="cartForm" class="ObjectForm" action="update.php" method="get">
<input type="hidden" name="cart" />
<?php
}
}

function showFormEnd()
{
if (false)
{
?>
</form>
<?php
}
}


// Carts
if (false)
{
require_once("$WEB_ROOT/object/carts.php");
$Carts = new Carts;
}

function getCarts()
{
	global $Carts;
	return $Carts;
}

function getCart()
{
	return getCarts()->getDefault();
}

function showCarts($index = 0)
{
if (false)
{
	$carts = getCarts();
?>
<!-- Carts -->
<div class="ObjectCarts">
	Your&nbsp;current&nbsp;list:
	<select onchange="CartChange(this)">
<?php
	$index = 0;
	foreach ($carts->array as $cart)
	{
		$name = $cart->name;
		$value = $index;
		if ($index == $carts->default)
			$selected = "selected=\"selected\"";
		else
			$selected = "";
?>
			<option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $name ?></option>
<?php
		$index++;
	}
?>
	</select>
	<input type="submit" value="Update" />
	<input type="submit" value="-" />
</div>
<?php
}
}

function showStatus()
{
?>
<!-- Status -->
<div class="ObjectStatus">
<?php
if (false)
{
	if (! is_null($object))
		showTrails($object);
	showCarts();
}
?>
</div>
<?php
}

// Check box
function showCheckbox($index, $irn)
{
if (false)
{
	$checked = "";
	if (getCart()->includes($irn))
		$checked="checked=\"checked\"";
?>
<!-- Checkbox -->
<td class="Control" id="<?php echo $id ?>">
	<input name="irn<?php echo $index ?>" type="hidden" value="<?php echo $irn ?>" />
	<input class="Control" name="choice<?php echo $index ?>" type="checkbox" <?php echo $checked ?> />
</td>
<?php
}
}
?>
