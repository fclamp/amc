<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2006 KE Software -->
<!-- this stylesheet used to generate simple test pages from DiGIR XML -->

<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:digir='http://digir.net/schema/protocol/2003/1.0'
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html digir darwin">

<xsl:output method="html"/>


<xsl:template name='itemDisplay'>
	<xsl:param name='field'/>
	<b><xsl:value-of select="name($field)"/>: </b><xsl:value-of select="$field"/>
</xsl:template>

<xsl:variable name='type'>
	<xsl:value-of select="//digir:response/digir:header/digir:type"/>
</xsl:variable>

<xsl:variable name="resource">
	<xsl:value-of select="/processing-instruction('suggestedResource')"/>
</xsl:variable>

<xsl:variable name="suggestedQuery">
	<xsl:choose>
		<xsl:when test="/processing-instruction('suggestedQuery') != ''">
			<xsl:value-of select="/processing-instruction('suggestedQuery')"/>
		</xsl:when>
		<xsl:otherwise>Species=gracilis</xsl:otherwise>
	</xsl:choose>
</xsl:variable>

<xsl:variable name="suggestedQueryValue">
	<xsl:value-of select="substring-after($suggestedQuery,'=')"/>
</xsl:variable>

<xsl:variable name="suggestedQueryField">
	<xsl:value-of select="substring-before($suggestedQuery,'=')"/>
</xsl:variable>

<xsl:template name='makeSearchFilter'>
	<xsl:param name='field'/>
	<xsl:param name='value'/>
	<xsl:text>&lt;request&gt;</xsl:text> 
		<xsl:text>&lt;header&gt;</xsl:text>
			<xsl:text>&lt;destination resource="</xsl:text>
				<xsl:value-of select="$resource"/><xsl:text>"&gt;</xsl:text> 
			<xsl:text>&lt;/destination&gt;</xsl:text>
			<xsl:text>&lt;type&gt;search&lt;/type&gt;</xsl:text>
		<xsl:text>&lt;/header&gt;</xsl:text>
		<xsl:text>&lt;search&gt;</xsl:text>
		<xsl:text>&lt;filter&gt;</xsl:text>
				<xsl:text>&lt;equals&gt;</xsl:text>
					<xsl:text>&lt;darwin:</xsl:text><xsl:value-of select="$suggestedQueryField"/><xsl:text>&gt;</xsl:text>
						<xsl:value-of select="$suggestedQueryValue"/>
					<xsl:text>&lt;/darwin:</xsl:text><xsl:value-of select="$suggestedQueryField"/><xsl:text>&gt;</xsl:text>
				<xsl:text>&lt;/equals&gt;</xsl:text>
		<xsl:text>&lt;/filter&gt;</xsl:text>
		<xsl:text>&lt;records limit='200' start='0'&gt;</xsl:text>
				<xsl:text>&lt;structure schemaLocation='http://digir.net/schema/conceptual/darwin/result/full/2003/darwin2resultfull.xsd'/&gt;</xsl:text>
		<xsl:text>&lt;/records&gt;</xsl:text>
		<xsl:text>&lt;count&gt;true&lt;/count&gt;</xsl:text>
		<xsl:text>&lt;/search&gt;</xsl:text>
	<xsl:text>&lt;/request&gt;</xsl:text>
</xsl:template>
<xsl:template name='makeInventoryFilter'>
	<xsl:param name='field'/>
	<xsl:param name='value'/>
	<xsl:text>&lt;request&gt;</xsl:text> 
		<xsl:text>&lt;header&gt;</xsl:text>
			<xsl:text>&lt;destination resource="</xsl:text>
				<xsl:value-of select="$resource"/><xsl:text>"&gt;</xsl:text> 
			<xsl:text>&lt;/destination&gt;</xsl:text>
				<xsl:text>&lt;type&gt;inventory&lt;/type&gt;</xsl:text>
		<xsl:text>&lt;/header&gt;</xsl:text>
		<xsl:text>&lt;inventory&gt;</xsl:text>
		<xsl:text>&lt;filter&gt;</xsl:text>
				<xsl:text>&lt;equals&gt;</xsl:text>
					<xsl:text>&lt;darwin:</xsl:text><xsl:value-of select="$suggestedQueryField"/><xsl:text>&gt;</xsl:text>
						<xsl:value-of select="$suggestedQueryValue"/>
					<xsl:text>&lt;/darwin:</xsl:text><xsl:value-of select="$suggestedQueryField"/><xsl:text>&gt;</xsl:text>
				<xsl:text>&lt;/equals&gt;</xsl:text>
		<xsl:text>&lt;/filter&gt;</xsl:text>
		<xsl:text>&lt;darwin:</xsl:text><xsl:value-of select="$suggestedQueryField"/><xsl:text>/&gt;</xsl:text>
		<xsl:text>&lt;count&gt;true&lt;/count&gt;</xsl:text>
		<xsl:text>&lt;/inventory&gt;</xsl:text>
	<xsl:text>&lt;/request&gt;</xsl:text>
</xsl:template>

<xsl:template name='makeInventoryUnfiltered'>
	<xsl:text>&lt;request&gt;</xsl:text> 
		<xsl:text>&lt;header&gt;</xsl:text>
			<xsl:text>&lt;destination resource="</xsl:text>
				<xsl:value-of select="$resource"/><xsl:text>"&gt;</xsl:text> 
			<xsl:text>&lt;/destination&gt;</xsl:text>
				<xsl:text>&lt;type&gt;inventory&lt;/type&gt;</xsl:text>
		<xsl:text>&lt;/header&gt;</xsl:text>
		<xsl:text>&lt;inventory&gt;</xsl:text>
		<xsl:text>&lt;darwin:</xsl:text><xsl:value-of select="$suggestedQueryField"/><xsl:text>/&gt;</xsl:text>
		<xsl:text>&lt;count&gt;true&lt;/count&gt;</xsl:text>
		<xsl:text>&lt;/inventory&gt;</xsl:text>
	<xsl:text>&lt;/request&gt;</xsl:text>
</xsl:template>

<xsl:template name="testLinks">
	<table>
	  <td>Simple Tests&#160;(<xsl:value-of select="$suggestedQuery" />):&#160;</td>
	  <td> <a href="./digir.php">Metadata</a></td>
	  <td>&#160;|&#160;</td>
	  <td><a>
	 			<xsl:attribute name="href"> 
					<xsl:text>./digir.php?doc=</xsl:text>
					<xsl:call-template name="makeSearchFilter">
						<xsl:with-param name="field">Species</xsl:with-param>
						<xsl:with-param name="value">gracilis</xsl:with-param>
					</xsl:call-template>
	 			</xsl:attribute> 
				Search
			</a></td>
	  <td>&#160;|&#160;</td>
	  			
	  <td><a>
	 			<xsl:attribute name="href"> 
					<xsl:text>./digir.php?doc=</xsl:text>
					<xsl:call-template name="makeInventoryFilter">
						<xsl:with-param name="field">Species</xsl:with-param>
						<xsl:with-param name="value">gracilis</xsl:with-param>
					</xsl:call-template>
	 			</xsl:attribute>Filtered Inventory

			</a></td>
	  <td>&#160;|&#160;</td>
	  <td><a>
	 			<xsl:attribute name="href"> 
					<xsl:text>./digir.php?doc=</xsl:text>
					<xsl:call-template name="makeInventoryUnfiltered"/>
	 			</xsl:attribute>Unfiltered Inventory

			</a></td>
	</table>
			<hr/>
</xsl:template>

<xsl:template match="/">
    <html>
      <head>
        <title>
		<xsl:value-of select="//digir:header/digir:version"/>
        </title>
	<style type="text/css">
                @import url("./digir/style/digir.css");
        </style>
      </head>
      <body>
        <div class="header">
	  <img src="images/productlogo.gif" alt="EMu"/>
	  &#160;
          <xsl:value-of select="//digir:header/digir:version"/>
        </div>

	<div class='status'>
	  <span style="font-size:smaller">This HTML display generated by
	  passing an XSL stylesheet with the DiGIR XML response.
	  To remove any browser styling and processing commands,  set the
	  "xslSheet" property in the client specific DigirProvider to false.<br/>
	  Use browser "View Source" to view XML
	  </span> </div>

	<div class='display'>
		<xsl:call-template name="testLinks"/>
	  	Source: <b><xsl:value-of select="//digir:header/digir:source"/></b><br/>
	  	Send Time: <b><xsl:value-of select="//digir:header/digir:sendTime"/></b><br/>
	  	Destination: <b><xsl:value-of select="//digir:header/digir:destination"/></b><br/>
	  	Request Type: <b><xsl:value-of select="$type"/></b><br/>
	  	<xsl:apply-templates select="//digir:diagnostics"/>
		<hr/>
        	<xsl:apply-templates select="//digir:content" />
	</div>

        <div class="footer">
	<center>
	(c)2005-2008 KE Software
	</center>
        </div>

      </body>

    </html>
  </xsl:template>

  <xsl:template match="digir:metadata">
        <xsl:apply-templates select="//digir:provider" />
  </xsl:template>

  <xsl:template match="digir:provider">
	<b><xsl:value-of select="name(.)" /></b>
  	<ul>
	  <li>
	  	<xsl:call-template name="itemDisplay">
	  		<xsl:with-param name='field' select="./digir:name"/>
	  	</xsl:call-template>
	  </li>	
	  <li>
	  	<xsl:call-template name="itemDisplay">
	  		<xsl:with-param name='field' select="./digir:accessPoint"/>
	  	</xsl:call-template>
	  </li>	
	  <li>
	  	<xsl:call-template name="itemDisplay">
	  		<xsl:with-param name='field' select="./digir:implementation"/>
	  	</xsl:call-template>
	  </li>	
	  <li>
		<xsl:for-each select="./digir:host">
			<xsl:apply-templates select="."/>
		</xsl:for-each>
	  </li>	
	  <li>
		<xsl:for-each select="./digir:resource">
			<xsl:apply-templates select="."/>
		</xsl:for-each>
	  </li>	
  	</ul>
  </xsl:template>

  <xsl:template match="digir:host">
	<b><xsl:value-of select="name(.)" /></b>
	<ul>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:name"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:code"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:relatedInformation"/>
	  		</xsl:call-template>
		</li>
	  	<li>
			<xsl:for-each select="./digir:contact">
				<xsl:apply-templates select="."/>
			</xsl:for-each>
	  	</li>	
	</ul>
  </xsl:template>

  <xsl:template match="digir:resource">
	<b><xsl:value-of select="name(.)" /></b>
	<ul>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:name"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:code"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:relatedInformation"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:abstract"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:keywords"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:citation"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:useRestrictions"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:conceptualSchema"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:recordIdentifier"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:recordBasis"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:numberOfRecords"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:dateLastUpdated"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:minQueryTermLength"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:maxSearchResponseRecords"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:maxInventoryResponseRecords"/>
	  		</xsl:call-template>
		</li>
	  	<li>
			<xsl:for-each select="./digir:contact">
				<xsl:apply-templates select="."/>
			</xsl:for-each>
	  	</li>	
	</ul>
  </xsl:template>

  <xsl:template match="digir:contact">
	<b><xsl:value-of select="name(.)" /></b>
	<ul>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:name"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:title"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:emailAddress"/>
	  		</xsl:call-template>
		</li>
		<li>
	  		<xsl:call-template name="itemDisplay">
	  			<xsl:with-param name='field' select="./digir:phone"/>
	  		</xsl:call-template>
		</li>
	</ul>
  </xsl:template>

  <xsl:template match="digir:record">
  	<xsl:choose>
		<xsl:when test="$type='inventory'">
  			<xsl:for-each select="./darwin:*">
	  			<xsl:call-template name="itemDisplay">
  					<xsl:with-param name='field' select="."/>
  				</xsl:call-template>
				<xsl:text> Count=</xsl:text><xsl:value-of select="./@count"/>
				<br/>
  			</xsl:for-each><hr/>
		</xsl:when>
		<xsl:otherwise>
  			<xsl:for-each select="./darwin:*">
	  			<xsl:call-template name="itemDisplay">
  					<xsl:with-param name='field' select="."/>
  				</xsl:call-template><br/>
  			</xsl:for-each><hr/>
		</xsl:otherwise>
  	</xsl:choose>
  </xsl:template>

  <xsl:template match="digir:diagnostics">
	<div class='status'>
	<span style="font-size:smaller">
  	<xsl:if test="./digir:diagnostic">
		<b><xsl:value-of select="name(.)" /></b>
  		<table>
			<tr>
				<th>Code</th><th>Severity</th><th>Value</th>
			</tr>
  		<xsl:for-each select="digir:diagnostic">
			<tr>
				<td><xsl:value-of select="./@code" /></td>
				<td><xsl:value-of select="./@severity" /></td>
				<td><xsl:value-of select="." /></td>
			</tr>
  		</xsl:for-each>
  		</table>
	</xsl:if>	
	</span>
	</div>
  </xsl:template>

</xsl:stylesheet>
