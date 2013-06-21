<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!DOCTYPE stylesheet [
<!ENTITY nbsp "&#160;">
<!ENTITY rtrif "&#x25B8;">
<!ENTITY deg "&#xB0;">
]>
<!-- (C) 2000-2006 KE Software -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:variable name='emuweblink'>
	<xsl:text>../pages/nmnh/iz/</xsl:text>
</xsl:variable>

<xsl:template name='emuWebListRef'>
	<xsl:param name='dataset'/>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="$emuweblink" />
			<xsl:text>ResultsList.php?Where=false</xsl:text>
			<xsl:for-each select='$dataset/records/record/group[@name="irn"]'>
				<xsl:text>+OR+irn=</xsl:text>
				<xsl:value-of select='.' />
			</xsl:for-each>
			<xsl:text>&amp;</xsl:text>
			<xsl:text>QueryPage=</xsl:text>
			<xsl:value-of select="$emuweblink" /><xsl:text>Query.php</xsl:text>
			<xsl:text>&amp;</xsl:text>
			<xsl:text>LimitPerPage=100</xsl:text>
		</xsl:attribute>
		Plotted Records
	</a>
</xsl:template>

<xsl:template name='emuWebRecordRef'>
	<xsl:param name='irn'/>
	<a>
		<xsl:attribute name="href">
			<xsl:value-of select="$emuweblink" /><xsl:text>Display.php?irn=</xsl:text>
			<xsl:value-of select='$irn' />
			<xsl:text>&amp;</xsl:text>
			<xsl:text>QueryPage=</xsl:text>
			<xsl:value-of select="$emuweblink" /><xsl:text>Query.php</xsl:text>
		</xsl:attribute>
		<xsl:value-of select='$irn'/>
	</a>
</xsl:template>


<xsl:template match="/">
<html>
<head>
	<title>
		KE EMu Mapper Region Query
	</title>
	<style type="text/css">
       		@import url("./mapper/style/kesimple.css");
	</style>
</head>
<body>

	<div class='header'>
		<h3>NMNH Region Query</h3>
	</div>
	<div class='display' >
		<ul>
			<xsl:apply-templates select='//dataSet' />
		</ul>
	</div>
	<div class='footer'>
		(C)2006 KE Software
	</div>

</body>
</html>
</xsl:template> 

<xsl:template match="dataSet">
	<xsl:variable name="name" select="./@name"/>
	<xsl:variable name="dsid" select="./@id"/>
	<xsl:variable name="datasetId"><xsl:value-of select='$name'/></xsl:variable>

        <li>
		<xsl:choose>
			<xsl:when test="$name = 'Mapped Records'">
				<xsl:call-template name='emuWebListRef'>
					<xsl:with-param name="dataset" select="."/>
				</xsl:call-template>
			</xsl:when>
			<xsl:otherwise>
                		<h3><xsl:value-of select="./@name"/></h3>
			</xsl:otherwise>
		</xsl:choose>
                <ul style="font-size:80%">
                        <table border='0'>
                        <tr>
                        <xsl:for-each select="./groups/group/@name">
                                <th><xsl:value-of select="."/></th>
                        </xsl:for-each>
                        </tr>
                        <xsl:apply-templates select='./records'>
                                <xsl:with-param name="groups" select="./groups" />
                        </xsl:apply-templates>
                        </table>
                </ul>
        </li>
</xsl:template>

<xsl:template match="records">
        <xsl:param name="groups"/>
        <xsl:for-each select="./record">
                <tr>
                <xsl:variable name="record" select="."/>
                <xsl:for-each select="$groups/group/@name">
                        <xsl:variable name="group" select="."/>
                        <td>
				<xsl:choose>
					<xsl:when test="$group='irn'">
						<xsl:call-template name="emuWebRecordRef">
							<xsl:with-param name='irn' select="$record/group[@name=$group]"/>
						</xsl:call-template>
					</xsl:when>
					<xsl:otherwise>
                                		<xsl:value-of select="$record/group[@name=$group]" />
					</xsl:otherwise>
				</xsl:choose>
                        </td>
                </xsl:for-each>
                </tr>
        </xsl:for-each>


</xsl:template>

</xsl:stylesheet>

