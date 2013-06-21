<?php
require_once(dirname(__FILE__) . "/../common.php");
require_once("$WEB_ROOT/tables/narratives.php");


// Header and footer
function narrativeStyles()
{
	global $urlRoot;
	global $WEB_ROOT;
	$css = "$urlRoot/narratives/styles.css";
	$js = "$WEB_ROOT/narratives/script.js";
?>
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $css ?>" /> -->
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

function narrativeHeader($title)
{
	pageHeaderBegin($title);
	narrativeStyles();
	pageHeaderEnd();
}

function narrativeFooter()
{
	pageFooter();
}


// Form
function showFormBegin()
{
?>
<form name="cartForm" class="NarrativeForm" action="update.php" method="get">
<input type="hidden" name="cart" />
<?php
}

function showFormEnd()
{
?>
</form>
<?php
}


// Carts
require_once("$WEB_ROOT/narratives/carts.php");
$Carts = new Carts;

function showCarts($index = 0)
{
	global $Carts;
?>
<!-- Carts -->
<div class="NarrativeCarts">
<?php
	if ($Carts->visible)
	{
?>
	Your&nbsp;current&nbsp;list:
	<select onchange="CartChange(this)">
<?php
		$index = 0;
		foreach ($Carts->array as $cart)
		{
			$name = $cart->name;
			$value = $index;
			if ($index == $Carts->default)
				$selected = "selected=\"selected\"";
			else
				$selected = "";
?>
		<option value="<?php echo $value ?>" <?php echo $selected ?>>
			<?php echo $name ?>
		</option>
<?php
			$index++;
		}
?>
	</select>
  <input type="submit" name="update" value="Update" />

<?php

    $label = "-";
	}
	else
		$label = "+";
		
		
?>
	<input type="submit" name="visible" value="<?php echo $label ?>" style="width: 15px" />
</div>
<?php
}


// Trails
function showTrails($narrative)
{
	global $urlSelf;

	$trails = $narrative->trails();
	if (count($trails) == 0)
		return;
?>
<!-- Trails -->
<div class="NarrativeTrails">

<?php
	$count = 0;
	foreach ($trails as $trail)
	{
?>
	
<?php
		if ($count == 0)
		{
?>
			You&nbsp;are&nbsp;here:
<?php
		}
?>
		
<!-- <div id= ""> -->
<?php
		$index = 0;
		foreach ($trail as $parent)
		{
			$url = $urlSelf . "?irn=" . $parent->irn;
			$title = $parent->title;
			if ($index > 0)
			{
?>
			&nbsp;&gt;&nbsp;
<?php
			}
?>
			<a href="<?php echo $url ?>"><?php echo $title ?></a>
<?php
			$index++;
		}
?>
		
	
<?php
		$count++;
	}
?>

</div>
<?php
}

function showStatus($narrative = null)
{
?>
<!-- Status -->
<div class="NarrativeStatus">
<?php
	if (! is_null($narrative))
		showTrails($narrative);
	
  showCarts();
?>
</div>
<?php
}

// Check box
function showCheckbox($index, $irn)
{
	global $Carts;
	if ($Carts->visible)
	{
		$checked = "";
		if ($Carts->getDefault()->includes($irn))
			$checked="checked=\"checked\"";
?>
<!-- Checkbox -->
	<input name="irn<?php echo $index ?>"
		type="hidden"
		value="<?php echo $irn ?>"
	/>
	<input class="Control"
		name="choice<?php echo $index ?>"
		type="checkbox" <?php echo $checked ?>
	/>
<?php
	}
}
?>
