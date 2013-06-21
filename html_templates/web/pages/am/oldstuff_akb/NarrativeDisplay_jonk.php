<html>

<head>
	<meta charset="ISO-8859-1" />
	<title>Australian Museum Record Display</title>
	<style type="text/css">
		@import url("./css/amemu.css");
	</style>
</head>

<body>
	<?php require_once('../../objects/am/DisplayObjects.php');
			$display = new AmNarrativeStandardDisplay;
	?>
	<div id='header'>Item Display</div>
	<div id='nav'>
		<ul>
			<li><a href='<?php print($display->queryPageLink()); ?>'>New Search</a><li>
			<li><a href='javascript:history.go(-1);')>Search Results</a></li>
		</ul>
	</div>

	<br/>
	<br/>

	<?php
			$display->Show();
	?>

      <br/>

	<div class='branding'>
		Powered by:<img src="images/productlogo.gif">
		<!-- <a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif"></a> -->
		<br/>
		Copyright © 2000-2009 KE Software.
	</div>

</body>

</html>
