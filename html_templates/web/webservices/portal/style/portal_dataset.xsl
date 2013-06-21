<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:include href='Common.xsl' />
<xsl:include href='DisplayListDataSet.xsl' />

<xsl:template match='/'>
	<!-- if service called with parameter "onlyStyleDataset=XXXX" then
		only act on dataset elements matching XXXXX.
		otherwise act on all datasets
	-->	
	<xsl:variable name="datasetTrigger">
		<xsl:call-template name='extractUrlParameter'>
			<xsl:with-param name='url'><xsl:value-of select="$queryString"/></xsl:with-param>
			<xsl:with-param name='field'>onlyStyleDataset</xsl:with-param>
		</xsl:call-template>
	</xsl:variable>

	<xsl:choose>
		<xsl:when test='string($datasetTrigger)'>
			<xsl:for-each select='//dataSet' >
				<xsl:variable name='dataset' select='./@name'/>
				<xsl:if test='$datasetTrigger=$dataset'>
					<h1>alert("url="+<xsl:value-of select='$queryString'/>)</h1>
					<xsl:call-template name='dataSet'/>
				</xsl:if>
			</xsl:for-each>
		</xsl:when>
		<xsl:otherwise>
			<xsl:for-each select='//dataSet' >
				<xsl:call-template name='dataSet'/>
			</xsl:for-each>
		</xsl:otherwise>
	</xsl:choose>

</xsl:template>

</xsl:stylesheet>

