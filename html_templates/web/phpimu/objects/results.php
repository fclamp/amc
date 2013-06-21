<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/objects/query.php");

$objects = new ObjectItems;
$objects->fetchWhere($where, $from, $to + 1);
$min = $from;
$max = $to;
if ($max > $objects->matches)
	$max = $objects->matches;
$irns = array();
for ($i = 0; $i < $objects->count; $i++)
	$irns[] = $objects->get($i)->irn;

require_once("$WEB_ROOT/../php5/sessions.php");
$session = new EMuWebSession;
$session->SaveVar("irns", $irns);

$urlSearch = "$urlRoot/search.php";
$urlSearch .= "?show=objects";
$urlSearch .= "&$terms";

$urlPrev = "";
if ($min > $pageSize)
	$urlPrev = "$urlSelf?$terms&record=" . ($min - $pageSize);

$urlNext = "";
if ($objects->count > $pageSize)
	$urlNext = "$urlSelf?$terms&record=" . ($min + $pageSize);

$title = "Search results";
objectHeader($title);
showFormBegin();
showStatus();

if ($objects->matches == 0)
{
	$title = "No matching objects";
	PageTitle($title);
}
else
{
	$title .= " $min to $max of {$objects->matches}";
	pageTitle($title);
?>

<!-- Results -->



<?php
	if ($objects->count > 0)
	{
?>
	
<?php
		$count = $objects->count;
		if ($count > $pageSize)
			$count = $pageSize;
		for ($index = 0; $index < $count; $index++)
		{
			$item = $objects->get($index);
			if (! isset($item))
				continue;

			if ($objects->count == 1)
				$id = "only";
			elseif ($index == 0)
				$id = "first";
			elseif ($index == $count - 1)
				$id = "last";
			else
				$id = "other";

			$url = $urlRoot . "/objects/details.php";
			$url .= "?$terms";
			$url .= "&record=" . ($min + $index);
			$url .= "&irn=" . $item->irn;
			$summary = $item->summary;
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
	
  <h2 class="browsetitle" id=" <?php echo $id ?>">
<a href="<?php echo $url ?>"><?php echo $summary ?></a></h2>
      </div>  



<?php
			showCheckbox($index, $item->irn);
?>

<?php
		}
?>

<?php
	}
?>


<?php
}

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
if ($urlSearch != "")
{
?>
	<a href="<?php echo $urlSearch ?>">Search</a>
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
  <div id="copy">
    <h6>&copy; The National Museum, All Rights Reserved |<a href="#">Copyright Information</a> | <a href="#">Linking Policy</a></h6>
  </div>
  <div id="logo">
    <a href="http://www.kesoftware.com/"><img src="../images/structure/NB2.png" alt="KE Software" width="250" height="31" border="0" /></a>  
  
  </div>
</div>
</div>
