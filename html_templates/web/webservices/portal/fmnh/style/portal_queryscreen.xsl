<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!DOCTYPE stylesheet [
<!ENTITY nbsp "&#160;">
<!ENTITY rtrif "&#x25B8;">
<!ENTITY deg "&#xB0;">
]>
<!-- (C) 2000-2004 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:html="http://www.w3.org/TR/html401"
	xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0"
	exclude-result-prefixes="html">

<xsl:output method='html' indent='yes' />

<xsl:variable name="maxOrTerms" select="5" />
<xsl:variable name="maxPerSource" select="//suggestedParameters/maxPerSource" />
<xsl:variable name="timeoutPerSource" select="//suggestedParameters/timeoutSeconds" />

<xsl:variable name="systemName" select="//queryScreen/@name" />
<xsl:variable name='dbAccess' select="//queryScreen/@localDbAccess"/>
<xsl:variable name="url" select="//queryScreen/@destinationUrl" />
<xsl:variable name="queryableFieldCount" select="count(//queryableFields/field)" />
<xsl:variable name="mapAvailable" select="//queryScreen/@statusMapAvailable" />
<xsl:variable name="sourceCount" select="count(//source)" />
<xsl:variable name="maxRecords" select="number($sourceCount)*number($maxPerSource)" />
<xsl:variable name="schema" select="//suggestedParameters/dataSchema" />
<xsl:variable name="image" select="//suggestedParameters/image" />
<xsl:variable name="stylesheet" select="//suggestedParameters/displayStylesheet" />


<xsl:template match='/'>
	<html>
	<head>
		<title><xsl:value-of select='$systemName'/> powered by KE EMu</title>
		<style type="text/css">
			@import url("./portal/fmnh/style/fmnh.css");
		</style>
		<script type="text/javascript" src="./lib/style/scripts/prototype.js"></script>
		<script type="text/javascript" src="./lib/style/scripts/builder.js"></script>
		<script type="text/javascript" src="./lib/style/scripts/effects.js"></script>
		<script type="text/javascript" src="./lib/style/scripts/dragdrop.js"></script>
		<script type="text/javascript" src="./lib/style/scripts/controls.js"></script>
		<script type="text/javascript" src="./lib/style/scripts/slider.js"></script>
		<script type="text/javascript" src="./lib/style/scripts/behaviour.js"></script>

		<script type="text/javascript" src="./lib/style/scripts/kexslt.js"></script>
		<script type="text/javascript" src="./portal/style/scripts/keportalquery.js"></script>
	</head>
	<body>
	<img  src="http://search.fieldmuseum.org/images/search_hdr.gif" border="0" 
		alt="Search The Field Museum"/>	<br/>
	<h4><xsl:value-of select='$systemName'/></h4>
	<!--<img src="http://www.fieldmuseum.org/research_collections/page_images/research_hdr.gif" border="0" 
			alt="Research and Collections Header"/>-->
	<form method='POST'>
		<xsl:attribute name='action'><xsl:value-of select='$url'/></xsl:attribute>
<div>
	<table class='unbordered'>
		<tbody>
		<tr class='bordered'>
			<td class='bordered'> 
				Status
			</td>
			<td class='bordered'>
				<div>
					<xsl:attribute name='class'>
					<xsl:choose>
						<xsl:when test="$dbAccess='on'">
							<xsl:text>statusOK</xsl:text>	
						</xsl:when>
						<xsl:otherwise>
							<xsl:text>statusError</xsl:text>	
						</xsl:otherwise>
					</xsl:choose>
					</xsl:attribute>
					Local Database Access: <xsl:value-of select="$dbAccess"/>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				Data Source(s)
			</td>
			<td style='text-align: left;'>	
				<xsl:call-template name='drawFetchers'/>
			</td>
		</tr>
		<tr>
			<td class='bordered'>Records</td>
			<td style='text-align: left;' class='bordered'>
				Max records to display
				<input type='input' id='limit' name='limit' 
					style='background-color: #e0e0e0;'
					value='1000' size='2'>
					<xsl:attribute name='value'><xsl:value-of select='$maxRecords'/></xsl:attribute>
				</input>
			</td>
		</tr>
		<tr class='bordered'>
			<td class='bordered'>Record Distribution</td>
			<td style='text-align: left;' class='bordered'>
				<input type='radio' name='scatter' id='scatterTrue' value='true' checked='true' />
					Get records from as many sources as possible<br/>
				<input type='radio' name='scatter' id='scatterFalse' value='false'/>
					Get records from sources in priority order
			</td>
		</tr>
		<tr>
			<td class='bordered'>Timeout Per Source</td>
			<td style='text-align: left;' class='bordered'>
				<input type='input' id='timeout' name='timeout' size='2' OnChange='changeTimeout(this);'	>
					<xsl:attribute name='value'><xsl:value-of select='$timeoutPerSource'/></xsl:attribute>
				</input> 
				Seconds &nbsp; <span id='remaining' style='visibility: hidden;'>
						(<span type='text' name='timer' id='timer' style='color:red'>-</span> remaining)
					</span>
			</td>
		</tr>
		<tr>
			<td>
				Query Terms<br/><i>blank terms ignored</i>
			</td>
			<td>
				<table class='unbordered'>
				<tbody>
					<tr>
					<!-- headers -->
					<xsl:for-each select='//field'>
						<th><xsl:value-of select='./@displayName'/></th>
					</xsl:for-each>
					</tr>
					<xsl:call-template name='queryRow'>
						<xsl:with-param name='i' select='$maxOrTerms'/>
					</xsl:call-template>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<td class='bordered'>Sort</td>
			<td class='bordered'>
				By <select name='sortby'>
					<xsl:for-each select='//queryableFields/field'>
						<option>
							<xsl:attribute name='value'>
								<xsl:value-of select='./@displayName'/>
							</xsl:attribute>
							<xsl:value-of select='./@displayName'/>
						</option>
					</xsl:for-each>
				</select>
				in
				<select name='order'>
					<option value='ascending'>Ascending</option>
					<option value='descending'>Descending</option>
				</select>
				order
			</td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type='button' class='makeStructuredRequest' value='Search' />
				<input type='button' class='sampleValues' name='SampleValues' 
					value='Fill With Example Values'>
						<xsl:attribute name='orTermsCount'><xsl:value-of select='$maxOrTerms'/></xsl:attribute>
						<xsl:attribute name='andTerms'>
							<xsl:for-each select='//field'>
								<xsl:value-of select='./@name'/><xsl:text>,</xsl:text>
							</xsl:for-each>
						</xsl:attribute>
						<xsl:attribute name='andSources'>
							<xsl:for-each select='//sources/source'>
								<xsl:value-of select='./@name'/><xsl:text>~</xsl:text>
							</xsl:for-each>
						</xsl:attribute>
				</input>	
				<input type='button' class='clear' value='Clear'/>
				<input type='button' class='queryHelp' value='Help' />
			</td>
		</tr>
		<tr>
			<td colspan='2'>&nbsp;</td>
		</tr>
		</tbody>
	</table>
</div>

		<!-- hidden variables used by javascript to generate calling
		     parameters -->
		<input type='hidden' name='dataSetDescription' id='dataSetDescription' value='' />
		<input type='hidden' name='start' id='start' value='1' />
		<input type='hidden' name='structuredQuery' id='structuredQuery' value='' />
		<input type='hidden' name='stylesheet' id='stylesheet'>
			<xsl:attribute name='value'><xsl:value-of select='$stylesheet'/></xsl:attribute>
		</input>

	</form>

	<xsl:call-template name='storeExamples'/>
	<div class='centred'>
		<img border="0" alt="KE EMu" src="./images/productlogo.gif" width="134" height="48"
			style="background-color: #ffffff"/>
		<img border="0" alt="KE Software" src="./images/companylogo.gif" width="60" height="50"
			style="background-color: #ffffff"/>
	</div>
	</body>
	</html>
</xsl:template>

<xsl:template name='drawFetchers'>
	<table class='unbordered'>
		<tbody>
		<tr>
			<th class='bordered'>POTENTIAL (select in priority order)</th>
			<th>&#160;</th>
			<th class='bordered'>ACTUAL (in priority order)</th>
		</tr>
		<tr>
			<td>
			<table>	
			<tbody id='potential'>
				<xsl:for-each select='//source'>

				<!-- ****** this bit can move to other table ******  -->
				<tr class='potential' style='text-align: left'>
					<xsl:attribute name='srcName'>
						<xsl:value-of select='./@name'/>
					</xsl:attribute>

					<td style='text-align: left'>
						<xsl:attribute name='bgcolor'>
							<xsl:value-of select='./@backgroundRGB'/>
						</xsl:attribute>

						<input type='checkbox' readonly='true'>
							<xsl:attribute name='name'>
								<xsl:value-of select='./@name'/>
							</xsl:attribute>
							<xsl:attribute name='id'>
								<xsl:text>chk_</xsl:text><xsl:value-of select='./@name'/>
							</xsl:attribute>
						</input>
						<xsl:value-of select='./@displayName'/>
					</td>

				</tr>
				<!-- ************************************************ -->

				</xsl:for-each>
			</tbody>
			</table>	
			</td>
			<td>&#160;</td>
			<td>
			<table>
			<tbody id='actual'>
			</tbody>
			</table>
			</td>
		</tr>
	</tbody>
	</table>
</xsl:template>

<xsl:template name='queryRow'>
	<xsl:param name="i"/>
	<xsl:if test="number($i) > 0">
		<tr>
		<xsl:attribute name='id'>
			<xsl:text>qryRow_</xsl:text>
			<xsl:value-of select='number($i) - 1'/>
		</xsl:attribute>
		<xsl:for-each select='//field'>
			<xsl:variable name='id'>
				<xsl:text>qry_field:</xsl:text>
				<xsl:value-of select='./@name'/>
				<xsl:text>_</xsl:text>
				<xsl:value-of select='$i - 1'/>
			</xsl:variable>
			<xsl:variable name='field' select='./@displayName'/>
			<xsl:variable name='type' select='./@type'/>
			<td>
				<input type='text'>
					<xsl:attribute name='id'><xsl:value-of select='$id'/></xsl:attribute>
					<xsl:attribute name='field'><xsl:value-of select='$field'/></xsl:attribute>
					<xsl:attribute name='value'></xsl:attribute>
					<xsl:attribute name='datatype'><xsl:value-of select='$type'/></xsl:attribute>
				</input>
			</td>
		</xsl:for-each>
		</tr>
		<xsl:call-template name="queryRow">
			<xsl:with-param name="i" select="number($i) - 1"/>
		</xsl:call-template>
	</xsl:if>
</xsl:template>

<xsl:template name='storeExamples'>		
	<xsl:for-each select='//queryableFields/field'>
		<input type='hidden'>
			<xsl:attribute name='name'><xsl:value-of select='./@name'/>_examples</xsl:attribute>
			<xsl:attribute name='id'><xsl:value-of select='./@name'/>_examples</xsl:attribute>
			<xsl:attribute name='value'>
			<xsl:for-each select='./example'>
				<xsl:value-of select='.'/><xsl:text>:</xsl:text>
			</xsl:for-each>
			</xsl:attribute>
		</input>
	</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
