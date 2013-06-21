<?php
require_once(dirname(__FILE__) . "/common.php");

$prompt = "(enter new list name)";

// House keeping
$rename = false;
if (isset($_REQUEST['type']))
{
	$type = $_REQUEST['type'];

	$index = -1;
	if (isset($_REQUEST['index']))
		$index = $_REQUEST['index'];

	$value = "";
	if (isset($_REQUEST['value']))
		$value = $_REQUEST['value'];

	if ($type == "create")
	{
		if ($value != "" && $value != $prompt)
			$Carts->add($value);
	}
	elseif ($type == "remove")
	{
			if ($index >= 0)
				$Carts->remove($index);
	}
	elseif ($type == "default")
	{
		if ($index >= 0)
			$Carts->setDefault($index);
	}
	elseif ($type == "rename")
	{
		if ($index >= 0)
			$rename = true;
	}
	elseif ($type == "reset")
		$Carts->clear();
	elseif ($type == "title")
	{
		if ($index >= 0 && $value != "")
			$Carts->array[$index]->name = $value;
	}
}
$Carts->save();

// Build list of all available publications
$allPublications = array();
function
addPublication($name)
{
	global $WEB_ROOT;
	global $allPublications;
	include("$WEB_ROOT/narratives/publications/$name.php");
	$allPublications[] = $Publication;
}
addPublication('videotour');
addPublication('nanotour');
addPublication('instructions');
addPublication('videoplaylist');
addPublication('nanoplaylist');


$title = "My Collection";
narrativeHeader($title);
?>
<div id="imagebar">
  <div id="wideimageleft"><h1><img src="../images/collections/leftwide.jpg" alt="The National Museum :: Collections" /></h1>
  </div>
  <div id="wideimageright"><img src="../images/collections/rightwide.jpg" alt="The National Museum :: Collections" />
  </div>
</div>

<?php
/*pageTitle($title);*/
?>

<form name="submitter" method="get">
	<input type="hidden" name="type" />
	<input type="hidden" name="index" />
	<input type="hidden" name="value" />
</form>
<script type="text/javascript">
function doCreate()
{
	document.submitter.action = '';
	document.submitter.type.value = 'create';
	document.submitter.value.value = document.main.createName.value;
	document.submitter.submit();
}

function doDefault(index)
{
	document.submitter.action = '';
	document.submitter.type.value = 'default';
	document.submitter.index.value = index;
	document.submitter.submit();
}

function doFocus(text)
{
	if (text.value == '<?php echo $prompt ?>')
		text.value = '';
}

function doModify(index)
{
	document.submitter.action = '';
	var id = "modify" + index;
	var element = document.getElementById(id);
	document.submitter.type.value = element.value;
	document.submitter.index.value = index;
	document.submitter.submit();
}

function doPublish(index)
{
	document.submitter.action = 'publish.php';
	var id = "publish" + index;
	var element = document.getElementById(id);
	document.submitter.type.value = element.value;
	document.submitter.index.value = index;
	document.submitter.submit();
}

function doReset()
{
	document.submitter.action = '';
	document.submitter.type.value = 'reset';
	document.submitter.submit();
}

function doTitle(index)
{
	document.submitter.action = '';
	var id = "title" + index;
	var element = document.getElementById(id);
	document.submitter.type.value = 'title';
	document.submitter.index.value = index;
	document.submitter.value.value = element.value;
	document.submitter.submit();
}
</script>

<div id="collectionstable">
<form name="main" method="get">

	<table class="ListsTable" cellspacing= "10">
	<tbody>
		<tr>
			<td>List</td>
			<td>Records</td>
			<td>On Display</td>
			<td>Default</td>
			<td>Modify</td>
			<td>Publish</td>
		</tr>
	
<?php
$row = 0;
foreach ($Carts->array as $cart)
{
	$title = $cart->name;

	$count = count($cart->irns);
	if ($count > 0)
		// TODO: mark up cart as href
		;

	if ($row == $Carts->default)
		$defaultOn = "checked=\"checked\"";
	else
		$defaultOn = "";

	if ($count == 0)
		$publishDisabled = "disabled=\"disabled\"";
	else
		$publishDisabled = "";

	$publishable = array();
	foreach ($allPublications as $publication)
	{
		if ($publication->canPublish($cart))
			$publishable[] = $publication;
	}
?>
		<tr>
			<td>	
			
<?php
	if ($rename && $row == $index)
	{
?>
				<input type="text"
					value="<?php echo $title ?>"
					id="title<?php echo $row ?>"
				/>
				<input type="button"
					value="Save"
					onclick="doTitle(<?php echo $row ?>)"
				/>
<?php
	}
	else
	{
?>
				<?php echo $title ?>
<?php
	}
?>
			
			</td>
			
			<td class="Records">
				<?php echo $count ?>
			</td>
			
			<td class="On Display" />

			<td>			
				<input type="radio"
					id="default<?php echo $row ?>"
					onclick="doDefault(<?php echo $row ?>)"
					<?php echo $defaultOn ?>
				/>
			</td>

			<td>
				<select id="modify<?php echo $row ?>"
					onchange="doModify(<?php echo $row ?>)"
				>
					<option value="rename">
						Rename
					</option>
<?php
	if ($Carts->count > 1)
	{
?>
					<option value="remove">
						Remove
					</option>
<?php
	}
?>
				</select>
				<input type="button"
					value="Go"
					onclick="doModify(<?php echo $row ?>)"
				/>
			</td>

			<td>
<?php
	if (count($publishable) > 0)
	{
?>
				<select
					id="publish<?php echo $row ?>"
					onchange="doPublish(<?php echo $row ?>)"
					<?php echo $publishDisabled ?>
				>
<?php
		foreach ($publishable as $publication)
		{
			$name = $publication->name;
			$title = $publication->title;
?>
					<option value="<?php echo $name ?>">
						<?php echo $title ?>
					</option>
<?php
		}
?>
				</select>
				<input type="button"
					value="Go"
					onclick="doPublish(<?php echo $row ?>)"
					<?php echo $publishDisabled ?>
				/>
<?php
	}
?>
			</td>
		</tr>
<?php

	$row++;
}
if (! $rename)
{
?>
		
    <tr>
			<td>
				<input type="text" name="createName" value="<?php echo $prompt ?>" onfocus="doFocus(this)" />
			</td>
			<td>
				<input type="button" value="Create" onclick="doCreate()" />
			</td>
		
<?php
}
?>
	
			<td>
				<span style="float: right">
				<input type="button" value="Reset" onclick="doReset()"
					style="font-size: 11px;"/>
				</span>
			</td> 
		</tr>
	</tbody>
	</table>
	<div>
		&nbsp;
	</div>
</form>
</div>

<div id="copylogo">
  <div id="copyred">
    <h6>&copy; The National Museum, All Rights Reserved |<a href="#">Copyright Information</a> | <a href="#">Linking Policy</a></h6>
  </div>
  <div id="redlogo">
    <a href="http://www.kesoftware.com/"><img src="../images/structure/AB3.png" alt="KE Software" width="250" height="23" border="0" /></a>  
  
  </div>
</div>

<?php
narrativeFooter();
?>
