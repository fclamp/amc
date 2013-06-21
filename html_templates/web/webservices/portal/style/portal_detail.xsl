<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:include href='Common.xsl' />
<xsl:include href='DetailView.xsl' />


<xsl:template match='/'>
	<div class='dataGrid'>
		<xsl:call-template name='recordDetail'>
			<xsl:with-param name='dataset'><xsl:value-of select='//dataSet[1]/@name' /></xsl:with-param>
		</xsl:call-template>
	</div>
</xsl:template>

</xsl:stylesheet>

