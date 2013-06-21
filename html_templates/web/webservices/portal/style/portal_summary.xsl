<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:include href='Common.xsl' />
<xsl:include href='DisplayListSummary.xsl' />

<xsl:template match="/">
	<xsl:call-template name='Summary' />
</xsl:template>

</xsl:stylesheet>

