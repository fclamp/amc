<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!DOCTYPE stylesheet [
<!ENTITY nbsp "&#160;">
<!ENTITY rtrif "&#x25B8;">
<!ENTITY deg "&#xB0;">
]>
<!-- (C) 2000-2008 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:html="http://www.w3.org/TR/html401" xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0" exclude-result-prefixes="html">

<xsl:output method="html" indent="yes"/>

<xsl:variable name="maxOrTerms" select="5"/>
<xsl:variable name="mapfile">garden.map</xsl:variable>
<xsl:variable name="type">Garden</xsl:variable>

<xsl:variable name="maxPerSource" select="//suggestedParameters/maxPerSource"/>
<xsl:variable name="timeoutPerSource" select="//suggestedParameters/timeoutSeconds"/>

<xsl:variable name="systemName" select="//queryScreen/@name"/>
<xsl:variable name="dbAccess" select="//queryScreen/@localDbAccess"/>
<xsl:variable name="url" select="//queryScreen/@destinationUrl"/>
<xsl:variable name="queryableFieldCount" select="count(//queryableFields/field)"/>
<xsl:variable name="mapAvailable" select="//queryScreen/@statusMapAvailable"/>
<xsl:variable name="sourceCount" select="count(//source)"/>
<xsl:variable name="maxRecords" select="number($sourceCount)*number($maxPerSource)"/>
<xsl:variable name="schema" select="//suggestedParameters/dataSchema"/>
<xsl:variable name="image" select="//suggestedParameters/image"/>
<xsl:variable name="stylesheet" select="//suggestedParameters/displayStylesheet"/>


<xsl:template match="/">
	<html>
	<head>
		<title><xsl:value-of select="$systemName"/> powered by KE EMu</title>
		<style type="text/css">
			@import url("./lib/rbgnsw/style/garden.css");
			@import url("./portal/rbgnsw/style/garden.css");
			@import url("./lib/rbgnsw/style/style.css");
		</style>
		<script type="text/javascript" src="./lib/style/scripts/prototype.js"/>
		<script type="text/javascript" src="./lib/style/scripts/behaviour.js"/>
		<script type="text/javascript" src="./lib/style/scripts/kexslt.js"/>
		<script type="text/javascript" src="./portal/rbgnsw/style/scripts/gardenQuery.js"/>
	</head>
	<body id="body">
	<form method="GET">
		<div id="banner">
			<h1>Trees In The Garden Prototype</h1>
			<span class="rightLinks">
				<a href="http://www.rbgsyd.nsw.gov.au" class="rbgLink">BGT Home</a> | 
				<a href="search/simple.htm" class="rbgLink">Quick Search</a> |
				<a href="mailto:botanical.is@rbgsyd.nsw.gov.au" class="rbgLink">Contact Us</a> &nbsp;
			</span>
		</div>

		<br/>
		<xsl:attribute name="action"><xsl:value-of select="$url"/></xsl:attribute>

			<ul class="tablist">
				<li class="active">Search By Terms</li>
				<li><a href="mapper.php?type=Garden&amp;mapfile=garden.map&amp;stylesheet=mapper/rbgnsw/style/garden_mapQueryscreen.xsl">Search Using Map</a></li>
				<li><a onClick="history.go(-1)">Previous Page</a></li>
			</ul>
	<table class="tablistTable">
		<tbody>
		<tr>
			<td>
				<span class="emphasis">Find records with<br/>these values:</span>
			</td>
			<td>
				<table style="float:left; margin-left: 5%; margin-right: 10%">
				<tbody id="query_terms">
					<tr>
						<th>Field</th>
						<th>
							Value
						</th>
						<th style="width:5em">
							&nbsp;
							<span id="spinner" style="display: inline">
								<img src="./portal/rbgnsw/images/spinner.gif" alt="Working..."/>
							</span>
						</th>
					</tr>
					<xsl:call-template name="queryTerms"/>
				</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type="button" class="makeStructuredRequest" value="Search"/>
				<input type="button" class="clear" value="Clear"/>
				<!-- <input type="button" class="queryHelp" value="Help"/> -->
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td><span class="emphasis">Sort by</span></td>
			<td>
				<select name="sortby">
					<xsl:for-each select="//queryableFields/field">
						<xsl:variable name="field" select="./@displayName"/>
						<xsl:if test="($field != 'irn') and (contains($field,'Flower') != 'true')">
						<option>
							<xsl:attribute name="value">
								<xsl:value-of select="./@displayName"/>
							</xsl:attribute>
							<xsl:if test="./@displayName = 'CommonName'">
							<xsl:attribute name="selected">true</xsl:attribute>
							</xsl:if>
							<xsl:value-of select="./@displayName"/>
						</option>
						</xsl:if>
					</xsl:for-each>
				</select>
				in
				<select name="order">
					<option value="ascending">Ascending</option>
					<option value="descending">Descending</option>
				</select>
				order
			</td>
		</tr>
		<tr>
				
			<td><span class="emphasis">Max records to display</span></td>
			<td style="text-align: left;">
				<input type="input" id="limit" name="limit" value="1000" size="2">
					<xsl:attribute name="value"><xsl:value-of select="$maxRecords"/></xsl:attribute>
				</input>
			</td>
		</tr>
		<tr>
			<td><span class="emphasis">Timeout</span></td>
			<td style="text-align: left;">
				<input type="input" id="timeout" name="timeout" size="2" OnChange="changeTimeout(this);" readOnly="true" style="background-color: #e0e0e0;">
					<xsl:attribute name="value"><xsl:value-of select="$timeoutPerSource"/></xsl:attribute>
				</input> 
				Seconds &nbsp; <span id="remaining" style="visibility: hidden;">
						(<span type="text" name="timer" id="timer" style="color:red">-</span> remaining)
					</span>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>
				Data Source(s)
			</td>
			<td style="text-align: left;">	
				<xsl:call-template name="drawFetchers"/>
			</td>
		</tr>
		<tr>
			<td> 
				Status
			</td>
			<td>
				<div>
					<xsl:attribute name="class">
					<xsl:choose>
						<xsl:when test="$dbAccess='on'">
							<xsl:text>statusOK</xsl:text>	
						</xsl:when>
						<xsl:otherwise>
							<xsl:text>notice</xsl:text>	
						</xsl:otherwise>
					</xsl:choose>
					</xsl:attribute>
					<xsl:choose>
						<xsl:when test="$dbAccess = 'off'">
							Error - Status checks says Database Texxml connection is '<xsl:value-of select="$dbAccess"/>'
						</xsl:when>
						<xsl:otherwise>
							Local Database Access:  <xsl:value-of select="$dbAccess"/>
						</xsl:otherwise>
					</xsl:choose>
				</div>
			</td>
		</tr>
		</tbody>
	</table>

		<!-- hidden variables used by javascript to generate calling
		     parameters -->
		<input type="hidden" name="source[]">
			<xsl:attribute name="value"><xsl:value-of select="//sources/source/@name"/></xsl:attribute>
		</input>

		<input type="hidden" name="dataSetDescription" id="dataSetDescription" value=""/>
		<input type="hidden" name="start" id="start" value="1"/>
		<input type="hidden" name="structuredQuery" id="structuredQuery" value=""/>
		<input type="hidden" name="stylesheet" id="stylesheet">
			<xsl:attribute name="value"><xsl:value-of select="$stylesheet"/></xsl:attribute>
		</input>
		<input type="hidden" name="mapfile" id="mapfile">
			<xsl:attribute name="value"><xsl:value-of select="$mapfile"/></xsl:attribute>
		</input>
		<input type="hidden" name="type" id="type">
			<xsl:attribute name="value"><xsl:value-of select="$type"/></xsl:attribute>
		</input>



	</form>
	<div style="clear: both;">
	<br/>
	<div id="footer">
		<!-- **************** KE EMu Branding, Copyright etc **********************-->
		<div>
			<a href="http://www.rbgsyd.nsw.gov.au"><img src="http://plantnet.rbgsyd.nsw.gov.au/images/bgt_logo.jpg" border="0"/></a>
			<br/>
			<img alt="KE EMu" src="../webservices/images/productlogo.gif"/>
			<div id="KE_IP">&#xA9; 2000-2008 KE Software</div>
		</div>
	</div>	
	</div>
	</body>
	</html>
</xsl:template>

<xsl:template name="drawFetchers">
	<xsl:for-each select="//source">
		<span>
			<xsl:attribute name="bgcolor">
				<xsl:value-of select="./@backgroundRGB"/>
			</xsl:attribute>
		<input type="hidden" readonly="true" value="true">
			<xsl:attribute name="name">
				<xsl:value-of select="./@name"/>
			</xsl:attribute>
			<xsl:attribute name="id">
				<xsl:text>chk_</xsl:text><xsl:value-of select="./@name"/>
			</xsl:attribute>
		</input>
		<xsl:value-of select="./@displayName"/>
		</span>
	</xsl:for-each>
</xsl:template>

<xsl:template name="queryTerms">
	<!-- draw the query boxes -->
		<xsl:attribute name="id">
			<xsl:text>qryRow_</xsl:text>
			<xsl:value-of select="0"/>
		</xsl:attribute>
		<xsl:for-each select="//field">
			<xsl:variable name="id">
				<xsl:text>qry_field:</xsl:text>
				<xsl:value-of select="./@name"/>
				<xsl:text>_</xsl:text>
				<xsl:value-of select="0"/>
			</xsl:variable>
			<xsl:variable name="field" select="./@displayName"/>
			<xsl:variable name="type" select="./@type"/>

			<!-- draw input boxes for fields -->
			<xsl:choose>
				<!-- drop unwanted query fields -->
				<xsl:when test="$field = 'irn'">
					<!-- don't query on irn -->
				</xsl:when>
				<xsl:when test="$field = 'Genus'">
					<!-- don't query on Genus -->
				</xsl:when>
				<xsl:when test="$field = 'Species'">
					<!-- don't query on Species -->
				</xsl:when>


				<!-- skip special case query fields -->
				<xsl:when test="(        (contains($field,'Flower') != 'true')       and        (contains($field,'Native') != 'true')       )">

		<tr>
			<td>
				<xsl:value-of select="$field"/>
			</td>
			<td>
				<div class="comboBox">
					<xsl:attribute name="id">combo_<xsl:value-of select="$field"/></xsl:attribute>
					<xsl:attribute name="field"><xsl:value-of select="$field"/></xsl:attribute>
					<input type="text" class="comboInputText">
						<xsl:attribute name="id">input_<xsl:value-of select="$field"/></xsl:attribute>
						<xsl:attribute name="field"><xsl:value-of select="$field"/></xsl:attribute>
					</input>
					<input type="button" class="comboDropButton" hidefocus="1" value="&#x25BC;">
						<xsl:attribute name="id">button_<xsl:value-of select="$field"/></xsl:attribute>
					</input>
					<div class="comboSelectHolder">
						<xsl:attribute name="id">selectHolder_<xsl:value-of select="$field"/></xsl:attribute>
   						<select class="comboDropList" size="5">
							<xsl:attribute name="id">select_<xsl:value-of select="$field"/></xsl:attribute>
							<xsl:attribute name="field"><xsl:value-of select="$field"/></xsl:attribute>
							<option value="" selected="true" class="comboSelectOption"/>
   						</select>
					</div>
				</div>
			</td>
			<td>
				&#xA0;
			</td>
		</tr>
				</xsl:when>
				<xsl:otherwise>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
		<tr>
			<td>
				Native or Exotic
			</td>
			<td>
				<div class="comboBox">
					<input type="text" class="comboInputText">
						<xsl:attribute name="id">input_NativeExotic</xsl:attribute>
						<xsl:attribute name="field">NativeExotic</xsl:attribute>
					</input>
					<input type="button" class="comboDropButton" hidefocus="1" value="&#x25BC;">
						<xsl:attribute name="id">button_NativeExotic</xsl:attribute>
					</input>
					<div class="comboSelectHolder">
						<xsl:attribute name="id">selectHolder_NativeExotic</xsl:attribute>
   						<select class="comboDropList" size="3">
							<xsl:attribute name="id">select_NativeExotic</xsl:attribute>
							<xsl:attribute name="field">NativeExotic</xsl:attribute>
							<option value="" selected="true" class="comboSelectOption"/>
							<option value="N" class="comboSelectOption">Native</option>
							<option value="E" class="comboSelectOption">Exotic</option>
   						</select>
					</div>
				</div>
			 </td>	
		</tr>	 
		<tr>
			<td>
				Flower Colour
			</td>
			<td>
				<input class="comboInputText">
					<xsl:attribute name="id">qry_FlowerColour</xsl:attribute>
					<xsl:attribute name="field">FlowerColour</xsl:attribute>
					<xsl:attribute name="value"/>
					<xsl:attribute name="datatype">String</xsl:attribute>
					<xsl:attribute name="type">text</xsl:attribute>
				</input>
			</td>	
		</tr>		
		<!-- <tr>
			<td>
				Flowering Month(s)
			</td>
			<td>
				<input size="40">
					<xsl:attribute name="id">qry_FlowerMonth</xsl:attribute>
					<xsl:attribute name="field">FlowerMonth</xsl:attribute>
					<xsl:attribute name="value"/>
					<xsl:attribute name="datatype">String</xsl:attribute>
					<xsl:attribute name="type">text</xsl:attribute>
				</input>
			</td>
		</tr>-->
</xsl:template>

</xsl:stylesheet>
