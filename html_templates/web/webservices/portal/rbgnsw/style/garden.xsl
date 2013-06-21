<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!DOCTYPE stylesheet [
<!ENTITY nbsp "&#160;">
<!ENTITY rtrif "&#x25B8;">
<!ENTITY deg "&#xB0;">
]>
<!-- (C) 2000-2008 KE Software -->
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:html="http://www.w3.org/TR/html401" xmlns:darwin="http://digir.net/schema/conceptual/darwin/2003/1.0" version="1.0" exclude-result-prefixes="html">

<xsl:variable name="description" select="//statusBlock/description"/>
<xsl:variable name="instance" select="//statusBlock/instance"/>
<xsl:variable name="currentSort" select="//records/@sortBy"/>
<xsl:variable name="currentOrder" select="//records/@sortOrder"/>
<xsl:variable name="currentCount" select="//records/@count"/>

<xsl:variable name="texqlMapArgs">
	<xsl:text>&amp;texql=SELECT+ALL+FROM+ecatalogue+WHERE+</xsl:text>
	<xsl:for-each select="//record">
		<xsl:text>irn=</xsl:text>
		<xsl:value-of select="./group[@name='irn']"/>
		<xsl:text>+OR+</xsl:text>
	</xsl:for-each>
	<xsl:text>+false</xsl:text>
</xsl:variable>	
<xsl:variable name="mapArgs">
	<xsl:text>source[]=GardenTexxml&amp;mapfile=garden.map</xsl:text>
</xsl:variable>	

<xsl:template name="sourceHeader">
	<!--<table class="status">
		<tr><th>Source</th><th>Records</th><th>Status</th></tr>
		<xsl:for-each select="//sources/source">

			<xsl:variable name="status" select="./@status"/>
			<xsl:variable name="colour" select="./@foregroundRGB"/>
			<xsl:variable name="bgColour" select="./@backgroundRGB"/>
			<xsl:variable name="icon" select="./@icon"/>

			<tr>
				<xsl:attribute name="style">
					<xsl:text>color:</xsl:text>
					<xsl:value-of select="$colour"/>
					<xsl:text>;background-color:</xsl:text>
					<xsl:value-of select="$bgColour"/>
					<xsl:text>;</xsl:text>
				</xsl:attribute>
				<td> <xsl:value-of select="./@displayName"/></td>
				<td><xsl:value-of select="./@recordsUsed"/></td>
				<td class="ok">
					<xsl:if test="not($status = &quot;completed&quot;)">
						<xsl:attribute name="class">
							<xsl:text>notice</xsl:text>
						</xsl:attribute>
					</xsl:if>	
				<xsl:value-of select="./@status"/>
				</td>
			</tr>
		</xsl:for-each>
	</table>-->
	<span class="status">
		<xsl:value-of select="$description"/>
		, sorted in <xsl:value-of select="$currentOrder"/>
		order by
		<xsl:value-of select="$currentSort"/>
		<br/>
		(<xsl:value-of select="//sources/source/@recordsUsed"/> records found)
		<br/>
		<span class='emphasis'>Click on Column Headings to Re-Sort</span>
	</span>
</xsl:template>

<xsl:template name="drawColumnHeader">
	<xsl:param name="header"/>
	<th class='dataHeader'>
		<!--<img src="./portal/rbgnsw/images/sortIcon.jpg"/>
		<br/>-->
		<a method="get" class="columnHeader"> 
			<xsl:attribute name="href">
				<xsl:text>portal.php?instance=</xsl:text>
				<xsl:value-of select="$instance"/>
				<xsl:text>&amp;sortby=</xsl:text>
				<xsl:value-of select="$header"/>
				<xsl:text>&amp;type=Garden</xsl:text>
				<xsl:text>&amp;order=</xsl:text>
				<xsl:choose>
					<xsl:when test="($header = $currentSort) and ($currentOrder = &quot;ascending&quot;)">
						<xsl:text>descending</xsl:text>
					</xsl:when>
					<xsl:otherwise>
						<xsl:text>ascending</xsl:text>
					</xsl:otherwise>
				</xsl:choose>
				<xsl:text>&amp;stylesheet=portal/rbgnsw/style/garden.xsl</xsl:text>
				</xsl:attribute>
				
				<xsl:call-template name="headerTranslate">
					<xsl:with-param name="term" select="$header"/>
				</xsl:call-template>
		</a>
	</th>
</xsl:template>

<xsl:template name="headerTranslate">
	<xsl:param name="term"/>
	<xsl:choose>
		<xsl:when test="$term = &quot;ScientificName&quot;">
			Scientific<br/>Name
		</xsl:when>
		<xsl:when test="$term = &quot;CommonName&quot;">
			Common<br/>Name
		</xsl:when>
		<xsl:when test="$term = &quot;NativeExotic&quot;">
			Native/<br/>Exotic
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="$term"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template match="/">
<html>
<head>
	<title>
		RBG NSW Garden Results List
	</title>
	<style type="text/css">
       		@import url("./lib/rbgnsw/style/garden.css");
       		@import url("./portal/rbgnsw/style/garden.css");
		@import url("./lib/rbgnsw/style/style.css");
	</style>
        <script type="text/javascript" src="./lib/style/scripts/prototype.js"/>
        <script type="text/javascript" src="./lib/style/scripts/builder.js"/>
        <script type="text/javascript" src="./lib/style/scripts/effects.js"/>
        <script type="text/javascript" src="./lib/style/scripts/dragdrop.js"/>
        <script type="text/javascript" src="./lib/style/scripts/controls.js"/>
        <script type="text/javascript" src="./lib/style/scripts/slider.js"/>
        <script type="text/javascript" src="./lib/style/scripts/behaviour.js"/>

        <script type="text/javascript" src="./lib/style/scripts/kexslt.js"/>
        <script type="text/javascript" src="./portal/rbgnsw/style/scripts/garden.js"/>
</head>
<body>  

	<div id="banner">
		<h1>RBG NSW Garden Results List</h1>
	</div>
		<xsl:call-template name="sourceHeader"/>
	<br/>
			<ul class="tablist">
				<li><a href="./portal.php?type=Garden&amp;queryScreen=portal/rbgnsw/style/garden_termQueryscreen.xsl">
					Search by Terms</a></li>
				<li><a href="mapper.php?type=Garden&amp;mapfile=garden.map&amp;stylesheet=mapper/rbgnsw/style/garden_mapQueryscreen.xsl">
					Search Using Map</a></li>
				<li class="active">Results List Display</li>
				<li><xsl:call-template name='mapDisplayUrl'/></li>
				<li><a onClick='history.go(-1)'>Previous Page</a></li>
			</ul>
	<table class="tablistTable">		
	<tbody>
	<tr>
	<xsl:choose>
		<xsl:when test="//sources/source/@recordsUsed = 0">
			<td id="dataArea">
				<h1>No Matches Found</h1>
				<p class='dontStandOut'>
					Either no records matched your search criteria or the search was cancelled as it was taking too long.
				</p>
				<p>
					Search Response : <span class='emphasis'><xsl:value-of select="//sources/source/@status"/>,
					<xsl:value-of select="//sources/source/@recordsUsed"/> records found
					</span>
				</p>
			</td>
			<td id="mapArea">
				<xsl:call-template name="showSimpleMap"/>
			</td>	
		</xsl:when>
		<xsl:otherwise>
			<td id="dataArea">
				<xsl:call-template name="dataSet"/>
			</td>
			<td id="mapArea">
				<xsl:call-template name="showSimpleMap"/>
			</td>	
		</xsl:otherwise>
	</xsl:choose>
	</tr>
	</tbody>
	</table>
	<div style='clear:both'>
	<br/>
	<div id='footer'>
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

<xsl:template name="mapDisplayUrl">
	<a method="get">
		<xsl:attribute name="href">
			<xsl:text>mapper.php?type=Garden&amp;action=&amp;dataSetDescription=selected+specimens&amp;limit=50&amp;order=ascending&amp;start=1&amp;stylesheet=mapper/rbgnsw/style/garden.xsl&amp;timeout=25</xsl:text>
			<xsl:text>&amp;sortby=</xsl:text><xsl:value-of select="$currentSort"/>
			<xsl:value-of select="$texqlMapArgs"/>
			<xsl:text>&amp;</xsl:text>
			<xsl:value-of select="$mapArgs"/>
		</xsl:attribute>
		Detailed Map Display
	</a>
</xsl:template> 

<xsl:template name="showSimpleMap">
	<div id='mapHolder'>
		<xsl:attribute name='texqlMapArgs'>
			<xsl:value-of select="$texqlMapArgs"/>
		</xsl:attribute>
		<xsl:attribute name='mapArgs'>
			<xsl:value-of select="$mapArgs"/>
		</xsl:attribute>
		<xsl:attribute name='mapWidth'>250</xsl:attribute>
		<xsl:attribute name='mapHeight'>400</xsl:attribute>
		<xsl:attribute name='minlong'>151.212</xsl:attribute>
		<xsl:attribute name='minlat'>-33.871</xsl:attribute>
		<xsl:attribute name='maxlong'>151.223</xsl:attribute>
		<xsl:attribute name='maxlat'>-33.856</xsl:attribute>
	</div>
	<!-- <xsl:call-template name="mapDisplayUrl"/> -->
</xsl:template> 

<xsl:template name="dataSet">
	<table class="dataTable">
		<tr class="header">
			<th class='dataHeader' width='100px' height='66px'>
                                <xsl:text>Image</xsl:text>
			</th>	
                        <xsl:for-each select="//statusBlock/groups/group[@type='base']">
				<xsl:variable name="header" select="."/>
				<xsl:if test="$header != 'description'">
					<xsl:call-template name="drawColumnHeader">
						<xsl:with-param name="header" select="."/>
					</xsl:call-template>
				</xsl:if>
                        </xsl:for-each>
                        <xsl:for-each select="//statusBlock/groups/group[@type='extended']">
				<xsl:variable name="header" select="."/>
				<xsl:if test="($header != 'recordSource') and ($header != 'MultimediaIrn')">
					<xsl:call-template name="drawColumnHeader">
						<xsl:with-param name="header" select="."/>
					</xsl:call-template>
				</xsl:if>
                        </xsl:for-each>
		</tr>
		<xsl:apply-templates select="//records">
			<xsl:with-param name="groups" select="//statusBlock/groups"/>
		</xsl:apply-templates>
	</table>
</xsl:template>

<xsl:template match="records">
        <xsl:param name="groups"/>
        <xsl:for-each select="./record">
                <xsl:variable name="record" select="."/>
                <xsl:variable name="irn" select="./@irn"/>
                <xsl:variable name="source" select="./@sourceName"/>
		<xsl:variable name="colour" select="./@foregroundRGB"/>
		<xsl:variable name="bgColour" select="./@backgroundRGB"/>
		<xsl:variable name="icon" select="./@icon"/>
		<xsl:variable name="multimediaIrn" select="$record/group[@name=&quot;MultimediaIrn&quot;]"/>
		<xsl:variable name="recordIrn" select="$record/group[@name=&quot;irn&quot;]"/>

			<xsl:text>
</xsl:text>			
                <tr class="zebraOdd">
			<xsl:attribute name="irn"><xsl:value-of select="$recordIrn"/></xsl:attribute>
			<xsl:choose>
				<xsl:when test="position() mod 2 = 0">
					<xsl:attribute name="class">
						<xsl:text>zebraEven</xsl:text>
					</xsl:attribute>
				</xsl:when>	
				<xsl:otherwise>
					<xsl:attribute name="class">
						<xsl:text>zebraOdd</xsl:text>
					</xsl:attribute>
				</xsl:otherwise>
			</xsl:choose>
                        <td class='dataCell'>
				<xsl:choose>
					<xsl:when test="string-length($multimediaIrn) &gt; 0">
						<img width='100px' height='66px'>
							<xsl:attribute name="src">../objects/common/webmedia.php?irn=<xsl:value-of select="$multimediaIrn"/>&amp;thumb=yes</xsl:attribute>
						</img>
					</xsl:when>
					<xsl:otherwise>
						<xsl:text>No Image Recorded</xsl:text>
					</xsl:otherwise>
				</xsl:choose>
                        </td>
			<xsl:text>
</xsl:text>			
                <xsl:for-each select="$groups/group[@type='base']">
                        <xsl:variable name="group" select="."/>
			<xsl:if test="$record/*[name()!=description]">
                        	<td class='dataCell'>
                               		<xsl:value-of select="$record/*[name()=$group]"/>
                        	</td>
			</xsl:if>
                </xsl:for-each>
                <xsl:for-each select="$groups/group[@type='extended']">
                        <xsl:variable name="group" select="."/>
			<xsl:if test="($group != 'recordSource') and ($group != 'MultimediaIrn')">
				<xsl:variable name="data" select="$record/group[@name=$group]"/>
                        	<td class='dataCell'>
					<xsl:choose>
						<xsl:when test="$group = &quot;NativeExotic&quot;">
							<xsl:choose>
								<xsl:when test="$data = &quot;N&quot;">
									<xsl:text>Native</xsl:text>
								</xsl:when>
								<xsl:when test="$data = &quot;E&quot;">
									<xsl:text>Exotic</xsl:text>
								</xsl:when>
								<xsl:when test="$data = &quot;?&quot;">
									<xsl:text>Unknown</xsl:text>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="$data"/>
								</xsl:otherwise>
							</xsl:choose>
						</xsl:when>
						<xsl:otherwise>
                                			<xsl:value-of select="$record/group[@name=$group]"/>
						</xsl:otherwise>
					</xsl:choose>
                        	</td>
			</xsl:if>
                </xsl:for-each>
                </tr>
        </xsl:for-each>


</xsl:template>

</xsl:stylesheet>
