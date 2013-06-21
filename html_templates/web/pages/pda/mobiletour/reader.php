<html>
<head>


<SCRIPT LANGUAGE="javascript">

var isNN = document.layers ? true : false;
var isIE = document.all ? true : false;

function init() {

if ( isNN )

	document.captureEvents(Event.MOUSEMOVE)
	document.onmousemove = handleMouseMove;

}

function handleMouseMove(evt) {

	mouseX = isNN ? evt.pageX : window.event.clientX;
	mouseY = isNN ? evt.pageY : window.event.clientY;


	theForm.QueryTerms.value = mouseX;
	theForm.Label.value = mouseY;

	return false;

}


</SCRIPT>

</head>


<body bgcolor="#EOF5DF" onLoad="init()">
<h1><center><b><FONT face="tahoma" color="#013567">KE Mobile Tour</font></b><center></h1>

<!-- Begin simple query form - query forms are very basic HTML forms so no need for PHP.  Just use static html -->

<center>


<form method="post" name="theForm" action="pdaresults.php">

	<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr align="center"><td valign="top">
	<b>Reading Tag Label ...</b></td></tr>

	<tr align="center"><td valign="top">
	<input type="text" name="Label" />
	</td></tr>
	


	<tr align="center"><td valign="top">
		<b>Reading Tag ID ...</b></td></tr>


		<tr align="center"><td valign="top">

		<input type="hidden" name="QueryName" value="BasicQuery" />
		<input type="hidden" name="QueryPage" value="/web/pages/gallery/Query.php" />
		<input type="hidden" name="Restriction" value="" />

		<input type="hidden" name="StartAt" value="1" />
		<input type="hidden" name="any" value="SummaryData" />
		<input type="hidden" name="QueryOption" value="any">

		<input class="WebInput" type="text" name="QueryTerms" /></td></tr>
		<tr align="center"><td valign="top">
		<input class="WebInput" type="submit" name="Submit" value="Search" />
	</td></tr>

	</table>
</form>



</center>




<center>
<br />
<b>Or select to browse:</b><br />
<a href="index.php">Basic Search Page</a><center>
<br>


<center>
<font face="helvetica, arial, sans-serif" size="1">(C) KE Software 2000-04</font>
</center>

<br />
(Note: currently this page retreives the mouse co-ordinates... this must be replaced by the 
communications device return id value and label name)

</body>
</html>
