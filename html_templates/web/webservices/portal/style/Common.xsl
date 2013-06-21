<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->

<!-- This stylesheet has common variables and templates that are used by other
stylesheets when processing ke portal xml -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">


<xsl:variable name="styleBase">
	<xsl:text>/</xsl:text>
	<xsl:value-of select="//statusBlock/emuwebBase"/>
	<xsl:text>/webservices/portal/style/</xsl:text>
</xsl:variable>

<xsl:variable name="instance" select="//statusBlock/instance"/>

<xsl:variable name="returnCall" select="//statusBlock/returnUrl"/>

<xsl:variable name="randomStamp" select="//statusBlock/randomStamp"/>

<xsl:variable name="url">
	<xsl:text>?instance=</xsl:text><xsl:value-of select="$instance"/>
	<xsl:text>&amp;transform=raw&amp;cacheReadOnly=true</xsl:text>
</xsl:variable>

<xsl:variable name="queryString" select="//statusBlock/generatingParameters"/>

<xsl:template name='extractUrlParameter'>
	<xsl:param name='url'/>
	<xsl:param name='field'/>
	<xsl:variable name='parameter'><xsl:value-of select='$field'/>=</xsl:variable>
	<xsl:variable name="start" select="substring-after($url,$parameter)"/>
	<xsl:choose>
		<xsl:when test="contains($start,'&amp;')">
			<xsl:value-of select="substring-before($start,'&amp;')"/>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="$start" />
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="escapeAChar">
	<!-- prepends chars (like ' or ") in string with backslash -->
 	<xsl:param name="string" />
	<xsl:param name="symbol" />
	<xsl:if test="contains($string, $symbol)">
		<xsl:value-of select="substring-before($string, $symbol)" />
		<xsl:text>\"</xsl:text>
		<xsl:call-template name="escapeAChar">
			<xsl:with-param name="string">
				<xsl:value-of select="substring-after($string, $symbol)" />
			</xsl:with-param>
			<xsl:with-param name='symbol'>
				<xsl:value-of select="$symbol" />
			</xsl:with-param>
		</xsl:call-template>
	</xsl:if>
	<xsl:if test="not(contains($string, $symbol))">
		<xsl:value-of select="$string" />
	</xsl:if>
</xsl:template>


</xsl:stylesheet>
