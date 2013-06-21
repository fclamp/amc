<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/objects/query.php");

$objects = new ObjectItems;

// Look for an irn
$irn = "";
if (! empty($_REQUEST['irn']))
	$irn = $_REQUEST['irn'];

require_once("$WEB_ROOT/../php5/sessions.php");
$session = new EMuWebSession;
if (! isset($_SESSION['irns']))
	$irns = array();
else
	$irns = $_SESSION['irns'];

// Run the search
if ($irn != "")
{
	// Find by IRN
	$objects->fetchIRN($irn);
	$object = $objects->get(0);
}
else
{
	// Find by query terms
	$objects->fetchWhere($where, $from, $to + 1);
	$irns = array();
	for ($i = 0; $i < $objects->count; $i++)
		$irns[] = $objects->get($i)->irn;
	$session->SaveVar("irns", $irns);
	$object = $objects->get($offset);
}
$irn = $object->irn;

// Build previous and next URLs
$pos = array_search($irn, $irns);
if ($pos === false)
{
	$irns = array();
	$session->SaveVar("irns", $irns);
}

$urlSummary = "";
$urlPrev = "";
$urlNext = "";
if (count($irns) > 0)
{
	$urlSummary = "$urlRoot/objects/results.php";
	$urlSummary .= "?$terms";
	$urlSummary .= "&record=" . $from;

	if ($record > 1)
	{
		$urlPrev = $urlSelf;
		$urlPrev .= "?$terms";
		$urlPrev .= "&record=" . ($record - 1);
		if ($pos !== false && $pos > 0)
			$urlPrev .= "&irn=" . $irns[$pos - 1];
	}

	if ($pos !== false && $pos < count($irns) - 1)
	{
		$urlNext = $urlSelf;
		$urlNext .= "?$terms";
		$urlNext .= "&record=" . ($record + 1);
		$pos = array_search($irn, $irns);
		if ($pos < count($irns) - 2)
			$urlNext .= "&irn=" . $irns[$pos + 1];
	}
}

$title = "Object Details";
objectHeader($title);

showFormBegin();
showStatus($object);
//pageTitle($title);
?>



<!-- Main -->
<div class="ObjectDetails">
	
		<div class="Image">
				<img src="<?php echo $object->imageURL("width=350") ?>"
					alt="<?php echo $object->imageAlt ?>"
				/>
			
    </div>

<div class= "librarydetails">
<table>

		<tr class="Title">
			<td class="Label">
				Main Title:
			</td>
			<td class="Data">
				<?php echo $object->title ?>
			</td>
		</tr>
		<tr class="Category">
			<td class="Label">
				Category:
			</td>
			<td class="Data">
				<?php echo $object->category ?>
			</td>
		</tr>
		<tr class="AccessionNo">
			<td class="Label">
				Accession No.:
			</td>
			<td class="Data">
				<?php echo $object->accessionNo ?>
			</td>
		</tr>
		<tr class="AccessionDate">
			<td class="Label">
				Accession Date:
			</td>
			<td class="Data">
				<?php echo $object->accessionDate ?>
			</td>
		</tr>
		<tr class="Creators">
			<td class="Label">
				Creators:
			</td>
			<td class="Data">
<?php
$string = "";
foreach ($object->creators as $creator)
{
	if ($string != "")
		$string .= "; ";
	$string .= $creator->name;
	if ($creator->role != "")
		$string .= ", " . $creator->role;
}
?>
				<?php echo $string ?>
			</td>
		</tr>
		<tr class="CreationDate">
			<td class="Label">
				Date Created:
			</td>
			<td class="Data">
				<?php echo $object->creationDate ?>
			</td>
		</tr>
		<tr class="CreationPlace">
			<td class="Label">
				Place of Creation:
			</td>
			<td class="Data">
<?php
$string = "";
foreach ($object->creationPlaces as $place)
{
	if ($string != "")
		$string .= "; ";
	$string .= $place->text;
}
?>
				<?php echo $string ?>
			</td>
		</tr>
		<tr class="Description">
			<td class="Label">
				Description:
			</td>
			<td class="Data">
				<?php echo $object->description ?>
			</td>
		</tr>
		<tr class="Technique">
			<td class="Label">
				Technique:
			</td>
			<td class="Data">
<?php
$string = "";
foreach ($object->technique as $technique)
{
	if ($string != "")
		$string .= ", ";
	$string .= $technique;
}
?>
				<?php echo $string ?>
			</td>
		</tr>
		<tr class="Medium">
			<td class="Label">
				Medium:
			</td>
			<td class="Data">
<?php
$string = "";
foreach ($object->medium as $medium)
{
	if ($string != "")
		$string .= ", ";
	$string .= $medium;
}
?>
				<?php echo $string ?>
			</td>
		</tr>
		<tr class="Measurements">
			<td class="Label">
				Measurements:
			</td>
			<td class="Data">
<?php
$string = "";
foreach ($object->measurements as $measurement)
{
	if ($string != "")
		$string .= "; ";
	$string .= $measurement->text;
}
?>
				<?php echo $string ?>
			</td>
		</tr>
		<tr class="Location">
			<td class="Label">
				Location:
			</td>
			<td class="Data">
				<?php echo $object->location ?>
			</td>
		</tr>
	</table>
 </div>
</div>
<?php
showStatus();
showFormEnd();
?>

<div class="ObjectNavigation">
<?php
if ($urlPrev != "")
{
?>
	<a href="<?php echo $urlPrev ?>">&lt;&nbsp;Previous</a>
<?php
}
if ($urlSummary != "")
{
?>
	<a href="<?php echo $urlSummary ?>">Summary</a>
<?php
}
if ($urlNext != "")
{
?>
	<a href="<?php echo $urlNext ?>">Next&nbsp;&gt;</a>
<?php
}
?>


<?php
objectFooter();
?>




<div id="copylogo">
  <div id="copyred">
    <h6>&copy; The National Museum, All Rights Reserved |<a href="#">Copyright Information</a> | <a href="#">Linking Policy</a></h6>
  </div>
  <div id="redlogo">
    <a href="http://www.kesoftware.com/"><img src="../images/structure/AB2.png" alt="KE Software" width="250" height="23" border="0" /></a>  
  
  </div>
</div>
</div>
