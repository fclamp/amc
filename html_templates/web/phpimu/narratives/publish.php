<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = realpath(dirname(__FILE__) . "/..");

require_once("$WEB_ROOT/narratives/common.php");

$type = $_REQUEST['type'];
$index = $_REQUEST['index'];
$Carts = new Carts;
$cart = $Carts->array[$index];

require_once("$WEB_ROOT/narratives/publications/$type.php");

$title = "Publishing {$cart->name} collection as {$Publication->title}";
?>

<?php
narrativeHeader($title);
?>

<div id="imagebar">
  <div id="wideimageleft"><h1><img src="../images/collections/leftwide.jpg" alt="The National Museum :: Collections" /></h1>
  </div>
  <div id="wideimageright"><img src="../images/collections/rightwide.jpg" alt="The National Museum :: Collections" />
  </div>
</div>

<div id="collectionstable">
	<div id= "PublishBody">
		<?php
		$Publication->publish($index, $cart);
		?>
	</div>
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