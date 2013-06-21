<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->

<!--  this stylesheet has templates to assist in display of record data.
Typically shown as components of a page -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:variable name="datasetXsl">
	<xsl:value-of select='$styleBase'/>
	<xsl:text>portal_dataset.xsl?cacheFooler=</xsl:text>
	<xsl:value-of select='$randomStamp'/>
</xsl:variable>
<xsl:variable name="summaryXsl">
	<xsl:value-of select='$styleBase'/>
	<xsl:text>portal_summary.xsl?cacheFooler=</xsl:text>
	<xsl:value-of select='$randomStamp'/>
</xsl:variable>


<xsl:template name="recordDetail">
	<xsl:param name='dataset'/>
	<img id='activity' src='images/activity_ok.gif'/>
 	<span class='action' name='Show Selected' >
	 	<xsl:attribute name="activity" >activity</xsl:attribute>
		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
		<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$dataset'/></xsl:attribute>
 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
		<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$url'/>
				<xsl:text>&amp;Queried+Data-firstRec=0</xsl:text>
				<xsl:text>&amp;Queried+Data-extractedOnly=false</xsl:text>
			</xsl:attribute>		
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$url'/>
				<xsl:text>&amp;Queried+Data-firstRec=0</xsl:text>
				<xsl:text>&amp;Queried+Data-extractedOnly=false</xsl:text>
			</xsl:attribute>		
			Show All
	</span>
	<table cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td class='cell'>Source:</td>
			<xsl:for-each select='//records/record'>
				<td class='cell unmarked'><xsl:value-of select="./recordSource"/></td>
			</xsl:for-each>
		</tr>
		<xsl:for-each select='//groups/group'>
			<xsl:variable name="currentField" select="./@name"/>
			<tr>
				<td class='cell'><xsl:value-of select='$currentField' /></td>
				<xsl:for-each select='//records/record'>
					<xsl:variable name="currentElement" select="./group[@name=$currentField]"/>
					<td class='cell unmarked'>
						<xsl:value-of select='$currentElement'/>
					</td>
				</xsl:for-each>
			</tr>
		</xsl:for-each>
	</tbody>
	</table>
</xsl:template>


</xsl:stylesheet>
