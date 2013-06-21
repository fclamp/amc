<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/narratives/query.php");

$narratives = new NarrativeItems;

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
	$narratives->fetchIRN($irn);
	$narrative = $narratives->get(0);
}
elseif ($terms != "")
{
	// Find by query terms
	$narratives->fetchWhere($where, $from, $to + 1);
	$irns = array();
	for ($i = 0; $i < $narratives->count; $i++)
		$irns[] = $narratives->get($i)->irn;
	$session->SaveVar("irns", $irns);
	$narrative = $narratives->get($offset);
}
else
{
	// Fetch master narrative
	$narratives->fetchMaster();
	$narrative = $narratives->get(0);
}
$irn = $narrative->irn;

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
	$urlSummary = "$urlRoot/narratives/results.php";
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

narrativeHeader($narrative->title);
?>
 <!--<div id="imagebar">
  <div id="wideimageleft"><h1><img src="../images/browse/leftwide.jpg" alt="The National Museum :: Browse" /></h1>
  </div>
  <div id="wideimageright"><img src="../images/browse/rightwide.jpg" alt="The National Museum :: Browse" />
  </div>
</div> -->

<div id="pagetitle">
<?php
/*pageTitle($narrative->title);*/ 
?>
</div>



<!-- Main -->
<div class="homecontent">	

<?php
showFormBegin();
showStatus($narrative);
?>

 
 <div id="browse-descr">
    <div class="listcheck">

<?php
      showCheckbox(0, $narrative->irn);
?>

    </div>
	<p>
    <img src="<?php echo $narrative->imageURL("width=300") ?>"
	alt="<?php echo $narrative->imageAlt ?>" />
    <?php print $narrative->narrative ?></p>



 </div>
</div>
 
 
<!-- Sub-narratives -->
<?php
$assocs = $narrative->associated();
if (count($assocs) > 0)
{
	$type = "Sub-narratives";
	$item = $assocs[0]->item;
	if (count($item->types) > 0)
	{
		$type = $item->types[0];
		// NASTY
		if ($type == "Category")
			$type = "Categories";
		elseif ($type == "Story")
			$type = "Stories";
		else
			$type .= "s";
	}
	if ($Carts->showAssocs)
		$label = "-";
	else
		$label = "+";
?>
	<div class="homecontent">
		<input type="submit" name="showAssocs" value="<?php echo $label ?>" style="width: 15px" /> 
		<?php echo $type ?>

<?php
	if ($Carts->showAssocs)
	{
  
		$index = 0;
		foreach ($assocs as $assoc)
		{
			$item = $assoc->item;

			// Ignore any associations without an attached item
			// This can happen if the associated record is not published
			if (! isset($item))
				continue;

			if (count($assocs) == 1)
				$id = "only";
			elseif ($index == 0)
				$id = "first";
			elseif ($index == count($assocs) - 1)
				$id = "last";
			else
				$id = "other";

			$url = $urlSelf . "?irn=" . $item->irn;
			$comment = $assoc->comment;
			if (empty($comment))
				$comment = strip_tags($item->narrative);
			$maxlen = 400;
			if (strlen($comment) > $maxlen)
			{
				$comment = substr($comment, 0, $maxlen - 3);
				$comment = preg_replace("/\s+(\S*)$/", "...", $comment);
			}
?> 

		<!-- <?php echo $index + 1 ?> -->
			<!-- Image -->
      <div class="browse-image browse
      <?php
         if ($index % 2 == 0)
			   {
         ?>
            browse-dark			   
         <?php
         }
         else
         {
         ?>
            browse-light
         <?php
         }
         ?>
         " style="background-image: url(<?php print $item->imageURL("width=100"); ?>);" >
				 <!--<a href="<?php echo $url ?>">
					<img src="<?php echo $item->imageURL("width=100") ?>"
						alt="<?php echo $item->imageAlt ?>"
					/> 
				</a>-->
			&nbsp;</div>

			<!-- Title and Summary -->
			<?php
			   if ($index % 2 == 0)
			   {
         ?>
            <div class="browse-text browse-dark browse">			   
         <?php
         }
         else
         {
         ?>
            <div class="browse-text browse-light browse">
         <?php
         }
      ?>
        <div class="listcheckmain">
<?php
			     showCheckbox($index + 1, $item->irn);
?>
        </div>
        <h2 class="browsetitle"><a href="<?php echo $url ?>"><?php echo htmlentities(utf8_encode($item->title)); ?></a></h2>
        
        <p><?php echo $comment; ?></p>
			


</div>



<?php
			$index++;
		}
	}
}
?>

<!-- Narrative Objects -->
<div class ="NarrativeObjects">
<?php
$objects = $narrative->objects();
if (count($objects) > 0)
{
	if ($Carts->showObjects)
		$label = "-";
	else
		$label = "+";
?>
	<div class="NarrativeSection">
		<input type="submit" name="showObjects" value="<?php echo $label ?>" style="width: 15px" />
		Associated Objects
	</div>
<?php
	if ($Carts->showObjects)
	{
?>
	
<?php
		$index = 0;
		foreach ($objects as $object)
		{
			$item = $object->item;

			// Ignore any associations without an attached item
			// This can happen if the associated record is not published
			if (! isset($item))
				continue;

			if (count($objects) == 1)
				$id = "only";
			elseif ($index == 0)
				$id = "first";
			elseif ($index == count($objects) - 1)
				$id = "last";
			else
				$id = "other";

			$url = "$urlRoot/objects/details.php?irn=" . $item->irn;
			$note = $object->note;
			if ($note == "")
				$note = $item->summary;
?>

		<!-- <?php echo $index + 1 ?> -->
		
			<!-- Title and Summary -->
			<div class="Content" id="<?php echo $id ?>">
				<a href="<?php echo $url ?>"><?php echo $item->title ?></a>
				<?php echo $note ?>
			</div>
			
				<!-- Needed -->
			
		
<?php
			$index++;
		}
	}
}
?>

</div>


<?php
showStatus();
showFormEnd();
?>

<div class="NarrativeNavigation">
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
narrativeFooter();
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

