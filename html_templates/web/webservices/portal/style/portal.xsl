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

<xsl:variable name='description' select='//statusBlock/description'/>
<xsl:variable name='instance' select='//statusBlock/instance'/>
<xsl:variable name='currentSort' select='//records/@sortBy'/>
<xsl:variable name='currentOrder' select='//records/@sortOrder'/>
<xsl:variable name='currentCount' select='//records/@count'/>

<xsl:template name='sourceHeader'>
	<div class='status'>
		<a href='./portal.php'>Search Again</a>
		<br/>
		<table class='status'>
			<tr><th>Source</th><th>Records</th><th>Status</th></tr>
		<xsl:for-each select="//sources/source">

			<xsl:variable name='status' select='./@status'/>
			<xsl:variable name='colour' select='./@foregroundRGB'/>
			<xsl:variable name='bgColour' select='./@backgroundRGB'/>
			<xsl:variable name='icon' select='./@icon'/>

			<tr>
				<xsl:attribute name='style'>
					<xsl:text>color:</xsl:text>
					<xsl:value-of select='$colour'/>
					<xsl:text>;background-color:</xsl:text>
					<xsl:value-of select='$bgColour' />
					<xsl:text>;</xsl:text>
				</xsl:attribute>
				<td> <xsl:value-of select='./@displayName'/></td>
				<td><xsl:value-of select='./@recordsUsed'/></td>
				<td class='ok'>
					<xsl:if test='not($status = "completed")'>
						<xsl:attribute name='class'>
							<xsl:text>notice</xsl:text>
						</xsl:attribute>
					</xsl:if>	
				<xsl:value-of select='./@status'/>
				</td>
			</tr>
		</xsl:for-each>
		</table>
		<span class='status'><xsl:value-of select='$description'/>
			, sorted in <xsl:value-of select='$currentOrder'/>
			order by
			<xsl:value-of select='$currentSort'/>
		</span>
	</div>	
</xsl:template>

<xsl:template match="/">
<html>
<head>
	<title>
		KE EMu Generic Results List
	</title>
	<style type="text/css">
       		@import url("./portal/style/kesimple.css");
	</style>
</head>
<body>

	<div class='header'>
		<h3>KE EMu Generic Results List</h3>
	</div>
	<div class='display' >
		<xsl:call-template name='sourceHeader'/>
		<hr/>
		<xsl:call-template name='dataSet' />
	</div>
	<div class='footer'>
		(C)2007 KE Software
	</div>

</body>
</html>
</xsl:template> 

<xsl:template name="dataSet">
	<table class='fineDisplay'>
                        <tr class='header'>
				<th>
				<a method='get'>
					<xsl:attribute name='href'>
						<xsl:text>?instance=</xsl:text>
						<xsl:value-of select='$instance'/>
						<xsl:text>&amp;sortby=recordSource</xsl:text>
						<xsl:text>&amp;order=</xsl:text>
						<xsl:choose>
							<xsl:when test='("recordSource" = $currentSort) and ($currentOrder = "ascending")'>
								<xsl:text>descending</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>ascending</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
						</xsl:attribute>
                                	<xsl:text>Source</xsl:text>
				</a>
				</th>	
                        <xsl:for-each select="//statusBlock/groups/group[@type='base']">
				<xsl:variable name='header' select='.'/>
				<th>
				<a method='get'>
					<xsl:attribute name='href'>
						<xsl:text>?instance=</xsl:text>
						<xsl:value-of select='$instance'/>
						<xsl:text>&amp;sortby=</xsl:text>
						<xsl:value-of select='$header'/>
						<xsl:text>&amp;order=</xsl:text>
						<xsl:choose>
							<xsl:when test='($header = $currentSort) and ($currentOrder = "ascending")'>
								<xsl:text>descending</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>ascending</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
						</xsl:attribute>
                                	<xsl:value-of select="$header"/>
				</a>	
				</th>
                        </xsl:for-each>
                        <xsl:for-each select="//statusBlock/groups/group[@type='extended']">
				<xsl:variable name='header' select='.'/>
                                <th>
				<a method='get'>
					<xsl:attribute name='href'>
						<xsl:text>?instance=</xsl:text>
						<xsl:value-of select='$instance'/>
						<xsl:text>&amp;sortby=</xsl:text>
						<xsl:value-of select='$header'/>
						<xsl:text>&amp;order=</xsl:text>
						<xsl:choose>
							<xsl:when test='($header = $currentSort) and ($currentOrder = "ascending")'>
								<xsl:text>descending</xsl:text>
							</xsl:when>
							<xsl:otherwise>
								<xsl:text>ascending</xsl:text>
							</xsl:otherwise>
						</xsl:choose>
						</xsl:attribute>
					<xsl:value-of select="$header"/>
				</a>
				</th>
                        </xsl:for-each>
                        </tr>
                        <xsl:apply-templates select='//records'>
                                <xsl:with-param name="groups" select="//statusBlock/groups" />
                        </xsl:apply-templates>
	</table>
</xsl:template>

<xsl:template match="records">
        <xsl:param name="groups"/>
        <xsl:for-each select="./record">
                <xsl:variable name="record" select="."/>
                <xsl:variable name="source" select="./@sourceName"/>
		<xsl:variable name='colour' select='./@foregroundRGB'/>
		<xsl:variable name='bgColour' select='./@backgroundRGB'/>
		<xsl:variable name='icon' select='./@icon'/>

			<xsl:text>
</xsl:text>			
                <tr class="zebraOdd">
			<xsl:if test="position() mod 2 = 0">
				<xsl:attribute name="class">
					<xsl:text>zebraEven</xsl:text>
				</xsl:attribute>
			</xsl:if>	
                        <td>
				<xsl:attribute name='style'>
					<xsl:text>color:</xsl:text>
					<xsl:value-of select='$colour'/>
					<xsl:text>;background-color:</xsl:text>
					<xsl:value-of select='$bgColour' />
					<xsl:text>;</xsl:text>
				</xsl:attribute>
                               	<xsl:value-of select="$source" />
                        </td>
			<xsl:text>
</xsl:text>			
                <xsl:for-each select="$groups/group[@type='base']">
                        <xsl:variable name="group" select="."/>
                        <td>
                               	<xsl:value-of select="$record/*[name()=$group]" />
                        </td>
                </xsl:for-each>
                <xsl:for-each select="$groups/group[@type='extended']">
                        <xsl:variable name="group" select="."/>
                        <td>
                                <xsl:value-of select="$record/group[@name=$group]" />
                        </td>
                </xsl:for-each>
                </tr>
        </xsl:for-each>


</xsl:template>

</xsl:stylesheet>

