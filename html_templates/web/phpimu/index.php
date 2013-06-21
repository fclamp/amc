<?php
if (! isset($WEB_ROOT))
	$WEB_ROOT = dirname(__FILE__);
include("$WEB_ROOT/common.php");

pageHeader("The National Museum");
?>	
<!-- Begin here -->

<div id="imagebar">
<div id="wideimageleft"><h1><img src="<?php print $urlRoot; ?>/images/home/leftwide.jpg" alt="The National Museum" /></h1>
  </div>
  <div id="wideimageright"><img src="<?php print $urlRoot; ?>/images/home/rightwide.jpg" alt="The National Museum" />
  </div>
</div>

<div id="homecontent">
  <div id="home-text">

<p>The National Museum was founded in 1901 and has a long and proud history of scientific and cultural research and collection development. Through innovative educational programs, special exhibitions and publications we promote the discovery, understanding and enjoyment of our Nation's natural and cultural history.</p>
<p> Our mission is to promote understanding of the scientific, cultural and historical significance of our collections through their imaginative use and interpretation. As an educational institution we provide many opportunities for informal and more struipctured public learning. Exhibits remain the primary means of informal education, but throughout our history we have supplemented this approach with innovative educational programs.</p>
<p>We invite you to visit our historic buildings and explore our world-class collections and fantastic exhibitions. Don't forget that you can plan your visit or further your knowledge of our collections by visiting our cutting-edge website. </p>

  </div>
  <div id="home-promos">
    <div id="home-promo1">
      <h2>What's On...</h2>
      <h4><a href="<?php print $urlRoot; ?>/narratives/details.php?irn=4"> History of Music tour </a></h4> 
      <h4>  The History of Music collection captures our nation's multi-cultural heritage.</h4>
    </div>
    <div id="home-promo2">
      <h2>Coming Soon...</h2>
      <h4>Our ancient peoples.</h4>
      <h4>Discover what researchers have learned about the people who lived here before us,  it's changing  everything we thought we knew!</h4>
    </div>
  </div>
</div>

<div id="copylogo">
  <div id="copy">
    <h6>&copy; The National Museum, All Rights Reserved |<a href="#">Copyright Information</a> | <a href="#">Linking Policy</a></h6>
  </div>
  <div id="logo">
    <a href="http://www.kesoftware.com/"><img src="images/structure/NB2.png" alt="KE Software" width="250" height="31" border="0" /></a>  </div>
  </div>
<!-- End here -->
<?php
pageFooter();
?>
