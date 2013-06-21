<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title>Australian Museum Record Display</title>

	<link rel="stylesheet" href="./stylesheets/am.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="./stylesheets/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="./stylesheets/am-emu.css" type="text/css" media="screen" />

</head>

<body>
	<?php require_once('../../objects/am/DisplayObjects.php');
				$display = new AmStandardDisplay;
	?>
	<div id='header'>Item Display</div>
	<div id='nav'>
		<ul>
			<li><a href='<?php print($display->queryPageLink()); ?>'>New Search</a><li>
			<li><a href='javascript:history.go(-1);')>Search Results</a></li>
			<li><a href='javascript:history.go(-1)' class='noul'><i>&lt;Back</i></a></li>
		</ul>
	</div>

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
