<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!DOCTYPE stylesheet [
<!ENTITY nbsp "&#160;">
<!ENTITY rtrif "&#x25B8;">
<!ENTITY deg "&#xB0;">
]>
<!-- (C) 2000-2005 KE Software -->

<!-- This stylesheet displays a complete display list page consisting of
headers/footers/datasets/summaries etc.   -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:include href='DisplayListDataSet.xsl' />
<xsl:include href='DisplayListSummary.xsl' />

<xsl:template name='displayListPage'>
<html>
<head>
	<title>
		<xsl:value-of select='//statusBlock/systemName'/>
	</title>
	<style type="text/css">
		@import url("./portal/style/webservices.css");
	</style>
	<script type="text/javascript" src="./lib/style/scripts/prototype.js"></script>
	<script type="text/javascript" src="./lib/style/scripts/builder.js"></script>
	<script type="text/javascript" src="./lib/style/scripts/effects.js"></script>
	<script type="text/javascript" src="./lib/style/scripts/dragdrop.js"></script>
	<script type="text/javascript" src="./lib/style/scripts/controls.js"></script>
	<script type="text/javascript" src="./lib/style/scripts/slider.js"></script>
	<script type="text/javascript" src="./lib/style/scripts/behaviour.js"></script>

	<script type="text/javascript" src="./lib/style/scripts/kexslt.js"></script>
	<script type="text/javascript" src="./portal/style/scripts/kewebservices.js"></script>
</head>
<body>

	<div id='header' name='header'>
		<div id='heading' name='heading'>
			<xsl:value-of select='//statusBlock/systemName'/> (Standard)
		</div>
		<div id='controls' name='controls' url='x'>
			<span class='searchAgain' name='Search Again' >
				<xsl:attribute name='url'><xsl:value-of select='$returnCall' /></xsl:attribute>
				Search Again
			</span>
			<span class='help' name='Help'  >
				Help
			</span>
		</div>
	</div> <!-- end header -->

	<div id='body' name='body'>

	<xsl:for-each select='//dataSet' >
		<xsl:variable name="name" select="./@name"/>
		<div class='dataset'>
			<xsl:attribute name="id">dataset_<xsl:value-of select='$name'/></xsl:attribute>
			<xsl:call-template name='dataSet'/>
		</div>
	</xsl:for-each>
	<xsl:call-template name='Summary'/>

	</div> <!-- end body -->
	<script type="text/javascript">
		/* set body id to be dragNdrop sortable on div's */
		Sortable.create('body',{tag:'div', constraint:false});
	</script>

	<div id='footer' name='footer'>
		<div id='branding' name='branding'>
			(c)2005-2006 KE Software
		</div>
		<div id='debugDiv'>
			DEBUG:
			<p id='debug'>
			</p>
		</div>	
	</div>
</body>
</html>
</xsl:template> 

</xsl:stylesheet>

