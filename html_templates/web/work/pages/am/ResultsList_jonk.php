<html>
<head>
	<meta charset="ISO-8859-1">
	<title>Australian Museum Search results</title>
	<style type="text/css">
		@import url("./css/amemu.css");
	</style>
</head>

<body>
	<?php
		require_once('../../objects/am/ResultsLists.php');
		$resultlist = new AmStandardResultsList;
	?>

	<div id='header'>Search results...</div>
	<div id='nav'>
		<ul>
			<li><a href='<?php print($resultlist->queryPageLink()); ?>'>New Search</a><li>
			<li><?php $resultlist->printRedisplay($resultlist->ContactSheetPage, "Contact Sheet");?></li>
			<li><a href='javascript:history.go(-1)' class='noul'><i>&lt;Back</i></a></li>
		</ul>
	</div>

	<div class='emuWebObject'>
	<?php
		$resultlist->Show();

	?>
	</div>

	<div class='branding'>
		Powered by:<img src="images/productlogo.gif">
		<!-- <a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif"></a> -->
		<br/>
		Copyright © 2000-2009 KE Software.
	</div>

</body>

</html>

