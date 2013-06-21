<?php
require_once(dirname(__FILE__) . "/common.php");
require_once("$WEB_ROOT/narratives/query.php");

$narratives = new NarrativeItems;
$narratives->fetchWhere($where, $from, $to + 1);
$min = $from;
$max = $to;
if ($max > $narratives->matches)
	$max = $narratives->matches;
$irns = array();
for ($i = 0; $i < $narratives->count; $i++)
	$irns[] = $narratives->get($i)->irn;

require_once("$WEB_ROOT/../php5/sessions.php");
$session = new EMuWebSession;
$session->SaveVar("irns", $irns);

$urlSearch = "$urlRoot/search.php";
$urlSearch .= "?show=narratives";
$urlSearch .= "&$terms";

$urlPrev = "";
if ($min > $pageSize)
	$urlPrev = "$urlSelf?$terms&record=" . ($min - $pageSize);

$urlNext = "";
if ($narratives->count > $pageSize)
	$urlNext = "$urlSelf?$terms&record=" . ($min + $pageSize);

$title = "Search results";
narrativeHeader($title);
showFormBegin();
showStatus();

if ($narratives->matches == 0)
{
	$title = "No matching narratives";
	PageTitle($title);
}
else
{
	$title .= " $min to $max of {$narratives->matches}";
	pageTitle($title);
?>

<!-- Results -->
<div class="NarrativeSummary">
<?php
	if ($narratives->count > 0)
	{
?>
	
<?php
		$count = $narratives->count;
		if ($count > $pageSize)
			$count = $pageSize;
		for ($index = 0; $index < $count; $index++)
		{
			$item = $narratives->get($index);
			if (! isset($item))
				continue;

			if ($narratives->count == 1)
				$id = "only";
			elseif ($index == 0)
				$id = "first";
			elseif ($index == $count - 1)
				$id = "last";
			else
				$id = "other";

			$url = $urlRoot . "/narratives/details.php";
			$url .= "?$terms";
			$url .= "&record=" . ($min + $index);
			$url .= "&irn=" . $item->irn;
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
			showCheckbox($index, $item->irn);
?>
</div>

<h2 class="browsetitle" id=" <?php echo $id ?>">

<a href="<?php echo $url ?>"><?php echo $item->title ?></a></h2><p><?php echo $comment ?>
</p>
</div>
  

		
<?php
		}
?>
	
<?php
	}
?>
</div>
<?php
}

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
