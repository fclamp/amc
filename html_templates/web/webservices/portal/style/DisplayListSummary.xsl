<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:template name="Summary">
	<div id='Summary' class='summary'>
		<table class='dataGrid' cellspacing="0" cellpadding="0">
			<tbody>
			<tr>
				<td class='cell'>Source</td>
				<xsl:for-each select='//dataSet' >
					<xsl:variable name="setname" select="./@name"/>
						<td class='cell unmarked'><xsl:value-of select='$setname'/></td>
				</xsl:for-each>
			</tr>
			<tr>
				<td class='cell'>SortedBy</td>
				<xsl:for-each select='//dataSet' >
					<xsl:variable name="sortby" select="./@sortBy"/>
						<td class='cell unmarked'><xsl:value-of select='$sortby'/></td>
				</xsl:for-each>
			</tr>
			<tr>
				<td class='cell'>Total</td>
				<xsl:for-each select='//dataSet' >
					<xsl:variable name="count" select="./@fullSetCount"/>
						<td class='cell unmarked'><xsl:value-of select='$count'/></td>
				</xsl:for-each>
			</tr>
			<tr>
				<td class='cell'></td>
				<xsl:for-each select='//dataSet/images/map' >
					<td class='cell unmarked'>
						<xsl:if test='string(.)'>
							<img width="127" height='64'>
								<xsl:attribute name="src">
									<xsl:value-of select="."/>
								</xsl:attribute>
							</img>
						</xsl:if>
					</td>
				</xsl:for-each>
			</tr>
			</tbody>
		</table>
	</div>

</xsl:template> 

</xsl:stylesheet>

