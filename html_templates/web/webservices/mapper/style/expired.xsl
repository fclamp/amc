<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!DOCTYPE stylesheet [
<!ENTITY nbsp "&#160;">
]>
<!-- (C) 2000-2008 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:output method='html' indent='yes' />

<xsl:variable name="systemName" select="//systemName" />

<xsl:template match='/'>
	<html>
	<head>
		<title><xsl:value-of select='$systemName'/> powered by KE EMu</title>
		<style type="text/css">
			@import url("./portal/style/webservices.css");
		</style>
	</head>
	<body>
	<h2 align='center' class='centred'>Default <xsl:value-of select='$systemName'/></h2>
	<p>It appears your Map session data has expired (normally this is due
	to a period of display inactivity).  Please try re-doing your map
	query</p> <p>Map Query Screen <a
	href='./mapper.php'>Standard Map Query Page</a></p>
	</body>
	</html>
</xsl:template>


</xsl:stylesheet>

