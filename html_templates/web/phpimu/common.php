<?php
require_once(dirname(__FILE__) ."/globals.php");

function pageHeaderBegin($title)
{
	global $urlRoot;
	global $WEB_ROOT;
	$stylecss = "$urlRoot/style.css";
	$js = "$WEB_ROOT/script.js";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $stylecss ?>" />
<script type="text/javascript">
<?php
include($js);
?>
</script>
<?php
}

function pageHeaderEnd()
{
	global $urlRoot;
	$home = "$urlRoot/index.php";
	$browse = "$urlRoot/narratives/details.php";
	$search = "$urlRoot/search.php";
	$collection = "$urlRoot/narratives/collections.php";
	$banner = "$urlRoot/banner.gif";
?>
</head>

<body>
<div id="container">

<div id="header">
<div id="menubartop">
  <div id="menutop">
    <ul id="navtop">
      <li><a href="<?php print $home; ?>">Home</a></li>
      <li>|</li>
      <li><a href="<?php print $browse; ?>">Browse Collection</a></li>
      <li>|</li>
      <li><a href="<?php print $search; ?>">Search Collection</a></li>
      <li>|</li>
      <li><a href="<?php print $collection; ?>">My Collections</a></li>
    </ul>
  </div>
</div>

  <div id="companylogo">
    <div id="companylogoimage">
      <img src="<?php print $urlRoot; ?>/images/structure/tnmlogo.gif" alt="The National Museum" width="580" height="94" />    
    </div>
    <div id="changingheaderimage"><img src="<?php print $urlRoot; ?>/images/home/small.jpg" alt="The National Museum" />
    </div>
  </div>
  <div id="contactdetails">
    <div id="leftcontactdetails">
      <h5>Mon-Sat.</h5>
      <h5>Sun.</h5>
      <h5>&nbsp;</h5>
      <h5>Tel.</h5>
      <h5>Fax.</h5>
    </div>
    <div id="rightcontactdetails">
      <h5 align="right">9am - 9pm</h5>
      <h5 align="right">10am - 4pm</h5>
      <h5>&nbsp;</h5>
      <h5 align="right">01223 556556</h5>
      <h5 align="right">01223 556557</h5>
    </div>
  </div>
</div>

<div id="menubar">
  <div id="menu">
    <ul id="nav">
      <li><a href="#">Plan Your Visit</a></li>
      <li>|</li>
      <li><a href="#">Exhibitions</a></li>
      <li>|</li>
      <li><a href="#">Calendar of Events</a></li>
      <li>|</li>
      <li><a href="#">Membership</a></li>
      <li>|</li>
      <li><a href="#">About Us</a></li>
      <li>|</li>
    </ul>
  </div>
  <div id="date">
  <h3>
	<script type="text/javascript">
	<!--
		var currentTime = new Date()
		/*
		var day = currentTime.getDate()
		var month = currentTime.getMonth() + 1
		var year = currentTime.getFullYear()
		document.write(day + "/" + month + "/" + year)
		*/
		document.write(currentTime.toLocaleDateString());
		//-->
		</script>
  </h3>
  </div>
</div>

<?php
}

function pageHeader($title)
{
	pageHeaderBegin($title);
	pageHeaderEnd();
}

function pageFooter()
{
?>
</div>
<!-- The following blank line is necessary for IE! -->

</body>
</html>
<?php
}

function pageTitle($title)
{
?>
<div class="PageTitle">
	<?php echo $title ?> 
</div>
<?php
}
?>
