<html xsl:version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<!-- (C) 2000-2007 KE Software -->

	<!-- Variables -->
<xsl:variable name='referenceMap'>
	<xsl:value-of select="/mapper/referenceMap"/>
</xsl:variable>

	<head>
		<!-- <meta http-equiv="pragma" content="no-cache"></meta>
		<meta http-equiv="cache-control" content="no-cache"></meta> -->
		<meta http-equiv="imagetoolbar" content="no"></meta>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"></meta>

	<title>Distribution Map</title>

	<link rel="stylesheet" type="text/css" href="mapper/style/mapper.css" />
	<link rel="stylesheet" type="text/css" href="mapper/style/mapper_print.css" media='print' />

	<script type="text/javascript" src="./lib/style/scripts/prototype.js" />
	<script type="text/javascript" src="./lib/style/scripts/behaviour.js" />

	<!-- globals need by javascript.
	Values for these set from the XML when processed by the HTML
	template mechanism (DO NOT REMOVE WITHOUT ADJUSTING JAVASCRIPT FILE(S)) -->
	<script type="text/javascript" id='preload'>

		// globals need by javascript.
		// Values for these set from the XML when processed by the HTML
		// template mechanism
		var MapProjection = "<xsl:value-of select="/mapper/mapProjection"></xsl:value-of>";
		var MapUnits = "<xsl:value-of select="/mapper/projectionUnits"></xsl:value-of>";
		var ImgHeight = <xsl:value-of select="/mapper/displayParameters/imgHeight"></xsl:value-of>;
		var ImgWidth = <xsl:value-of select="/mapper/displayParameters/imgWidth"></xsl:value-of>;
		var Map = "<xsl:value-of select="/mapper/map"></xsl:value-of>";
		var ReferenceMap = "<xsl:value-of select="/mapper/referenceMap"></xsl:value-of>";
		var Scalebar = "<xsl:value-of select="/mapper/scalebar"></xsl:value-of>";
		var Referer = "<xsl:value-of select="/mapper/displayParameters/referer"></xsl:value-of>";
		var MapperUrl = "<xsl:value-of select="/mapper/displayParameters/mapperUrl"></xsl:value-of>?instance=<xsl:value-of select="/mapper/displayParameters/instance"></xsl:value-of>&amp;referer="+ Referer;
		var MapExtent = "<xsl:value-of select="/mapper/extent"></xsl:value-of>".split(/\s+/);
		var Passive =  <xsl:value-of select="/mapper/passive"></xsl:value-of>;
		var ActionRequested = "<xsl:value-of select="/mapper/displayParameters/actionRequested"></xsl:value-of>";
		var QueryDataStylesheet = "<xsl:value-of select="/mapper/displayParameters/queryDataStylesheet"></xsl:value-of>";
		var ReferredArguments = "<xsl:value-of select="/mapper/displayParameters/referredArguments"></xsl:value-of>";
		var PointExtents = "<xsl:value-of select="/mapper/displayParameters/pointExtents"></xsl:value-of>".split(/\s+/);
		var MapfileExtents = "<xsl:value-of select="/mapper/displayParameters/mapfileExtents"></xsl:value-of>".split(/\s+/);

		var EmuBackendType = "<xsl:value-of select="/mapper/displayParameters/emuBackendType"></xsl:value-of>";
		var EmuWebBase = "<xsl:value-of select="/mapper/displayParameters/emuWebBase"></xsl:value-of>";
		var WebSection = "<xsl:value-of select="/mapper/displayParameters/websection"></xsl:value-of>";
		var Sources = new Array();

		<xsl:for-each select="/mapper/dataSource">
			Sources.push("<xsl:value-of select="."></xsl:value-of>");
		</xsl:for-each>
	</script>

	<script type='text/javascript'  src="mapper/style/scripts/mapdisplay.js" />

    </head>

<body>

	<div id='xHairH'></div>
	<div id='xHairV'></div>
	<div id="rubberBand"> </div>

	<div id="banner">
		<h1>Distribution Map</h1>
	</div>

	<form id='form' method='post' action=''>
		<table id="MapTable">
			<tbody>
				<tr>

					<td id='leftPanel'>
						<!-- ***************** DYNAMIC STATUS MESSAGES ********** -->
						<div id="ControlsHelp" class='hideOnPrint'>
						<span>KE Software Mapper</span>
						</div>
						
						<!-- ***************** THE STATUS MAP ******************* -->
						<div id="StatusMap" class='hideOnPrint'>
						<img>
						<xsl:attribute name="src"><xsl:value-of select="$referenceMap"/></xsl:attribute>
						</img>
						</div>
						<div id="LatLongDisplay" class='hideOnPrint'>Coordinates</div>
						<div id="Legend">
							<h3>Legend</h3>
							<xsl:for-each select="/mapper/displayParameters/warnings">
								<xsl:if test="normalize-space(.)">
								<span class="alert">
									<xsl:value-of select="."/>
								</span>
								</xsl:if>
							</xsl:for-each>
							<xsl:for-each select="/mapper/layers/dynamicLayer">
								<div class="LegendItem">
									<input type="checkbox" value="on" style="vertical-align: top; letter-spacing: 0">
										<xsl:attribute name="name">
											<xsl:value-of select="./layerName"/>
										</xsl:attribute>
										<xsl:if test="contains(./status,'true')">
											<xsl:attribute name="checked">true</xsl:attribute>
										</xsl:if>
									</input>
									<img src="">
										<xsl:attribute name="src">
											<xsl:value-of select="./icon"/>
										</xsl:attribute>
									</img>
									<xsl:value-of select="./name"/>
								</div>
							</xsl:for-each>
							<xsl:value-of select='//recordsPassed'/> specimens to map<br/>
							<xsl:value-of select='//missingLatLongs'/> of which have no lat/long
						</div>
					</td>

					<td id='centrePanel'>
						<div id="mainMapPanel">
						<!-- **************** Map Controls **************** -->
							<div id="Controls" class='hideOnPrint'>
								<img src="mapper/images/whatis.gif"
									coldsrc="mapper/images/whatis.gif"
									hotsrc="mapper/images/whatisactive.gif"
									toolHint="get details of a specimen by pointing at it"
									id="Pointer"
									name="Pointer"
									value="Pointer"
									alt="Pointer"
									class="controlButton"
									selected="true"
									title="Pointer"/>
		
								<img src="mapper/images/zoomin.gif"
									coldsrc="mapper/images/zoomin.gif"
									hotsrc="mapper/images/zoominactive.gif"
									toolHint="Zoom in to an area by clicking it on the map or drawing a box around it"
									id="ZoomIn"
									name="ZoomIn"
									value="Zoom In"
									alt="Zoom In"
									class="controlButton"
									title="Zoom In"/>
		
								<img src="mapper/images/zoomout.gif"
									coldsrc="mapper/images/zoomout.gif"
									hotsrc="mapper/images/zoomoutactive.gif"
									toolHint="Zoom out by clicking the map"
									id="ZoomOut"
									name="ZoomOut"
									value="Zoom Out"
									alt="Zoom Out"
									class="controlButton"
									title="Zoom Out"/>
		
								<img src="mapper/images/pan.gif"
									coldsrc="mapper/images/pan.gif"
									hotsrc="mapper/images/panactive.gif"
									toolHint="Centre the map on a location by clicking that location on the map"
									id="Pan"
									name="Pan"
									value="Pan"
									alt="Pan"
									class="controlButton"
									title="Pan"/>
		
								<img src="mapper/images/query.gif"
									coldsrc="mapper/images/query.gif"
									hotsrc="mapper/images/queryactive.gif"
									toolHint="Query specimens by clicking the map and dragging a box around their icons"
									id="Query"
									name="Query"
									value="Query"
									alt="Query Items"
									class="controlButton"
									title="Query"/>
		
								<!-- <img src="mapper/images/areaquery.gif"
									coldsrc="mapper/images/areaquery.gif"
									hotsrc="mapper/images/areaqueryactive.gif"
									toolHint="Draw a box and find what specimens may be in that area"
									id="Spatial"
									name="Spatial"
									value="Find Records"
									alt="Spatial"
									class="controlButton"
									title="Find Specimens in an Area"/> -->
		
								<img src="mapper/images/reset.gif"
									coldsrc="mapper/images/reset.gif"
									hotsrc="mapper/images/reset.gif"
									toolHint="Zoom back out to initial extent"
									id="Reset"
									name="Reset"
									value="Reset Map"
									alt="Reset Map"
									class="controlButton"
									title="Reset map"/>

								<img src="mapper/images/expand.gif"
									coldsrc="mapper/images/expand.gif"
									hotsrc="mapper/images/expand.gif"
									toolHint="Expand Extent to Find All Points"
									id="Expand"
									name="Expand"
									value="Expand Extent"
									alt="Expand Extent"
									class="controlButton"
									title="Expand Extent"/>

								<img src="mapper/images/redraw.gif"
									coldsrc="mapper/images/redraw.gif"
									hotsrc="mapper/images/redrawactive.gif"
									toolHint="Refresh the map with new settings by clicking the map"
									id="ReDraw"
									name="ReDraw"
									value="Re Draw"
									alt="Redraw"
									class="controlButton"
									title="Apply new settings"/>
							</div>
							<!-- ***************** THE MAIN MAP IMAGE *************** -->
							<!-- need to use a div not an img to allow mouse drag events to be handled gracefully in IE.
							     IE thinks you want to drag image to another application, not draw a rubber band :-(

							     This means we need to set map image as background.
							     Problem then is
							     failure to print as most browsers by default don't print background images,
							     so add a temporary image as well (hidden) that can be made visible for printing
							  -->
							<div id="Map"> 
								<xsl:attribute name='style'>
									<xsl:text>background-image: url("</xsl:text>
										<xsl:value-of select="/mapper/map"/>
										<xsl:text>");</xsl:text>
									<xsl:text>height:</xsl:text>
										<xsl:value-of select="/mapper/displayParameters/imgHeight"></xsl:value-of>
										<xsl:text>px;</xsl:text>
									<xsl:text>width:</xsl:text>
										<xsl:value-of select="/mapper/displayParameters/imgWidth"></xsl:value-of>
										<xsl:text>px;</xsl:text>
								</xsl:attribute>
								
								<!-- add 'hot spot' divs for each point -->
								<xsl:for-each select="//imageMap/area">
									<xsl:variable name="xpos" select="substring-before(./@coords,',')"/>
									<xsl:variable name="ypos" select="substring-after(./@coords,',')"/>
									<xsl:variable name="data" select="./@data"/>
									<xsl:variable name="key" select="./@key"/>
								<div class="hotSpot">
									<xsl:attribute name="style">
										left: <xsl:value-of select="$xpos - 7"/>px; 
										top: <xsl:value-of select="$ypos - 7"/>px; 
										z-index: 3;
									</xsl:attribute>
									<xsl:attribute name="id">
										<xsl:value-of select="position()"/>
									</xsl:attribute>
									<xsl:attribute name="data">
										<xsl:value-of select="$data"/>
									</xsl:attribute>
									<xsl:attribute name="key">
										<xsl:value-of select="$key"/>
									</xsl:attribute>
								</div>		
								</xsl:for-each>
								<xsl:if test="//mapper/@status = 'fail'">
									<span class="alert">
									<xsl:value-of select="//mapper/diagnostics"/>
									</span>
								</xsl:if>

								<!--  put 'hidden' image here for printing -->
								<div id="tempMap" style='visibility: hidden;'>
									<img>
									<xsl:attribute name="src"><xsl:value-of select="/mapper/map"/></xsl:attribute>
									</img>
								</div>

							</div>
		
							<!-- **************** SCALEBAR **********************-->
							<div id="ScaleBar">
								<img src="">
									<xsl:attribute name="src">
										<xsl:value-of select="/mapper/scalebar"/>
									</xsl:attribute>
								</img>
							</div>
						</div>
					</td>



					<td id='rightPanel' class='hideOnPrint'>
						<!-- ***************** MAP CONTENT CONTROLS ************* -->
						<div id="ContentControls">
							<div class='hideOnPrint'>
							<xsl:choose>
								<xsl:when test="/mapper/displayParameters/availableProjections">
									&#160;<span class="labels">Map Style:</span> <br/>
									<xsl:for-each select="/mapper/displayParameters/availableProjections/availableProjection">
										&#160;<input type='radio' name='mapfile' class='projection' value="">
											<xsl:attribute name="value">
												<xsl:value-of select="./mapfile"></xsl:value-of>
											</xsl:attribute>
										</input><xsl:value-of select="./name"></xsl:value-of><br/>
									</xsl:for-each>
									<br/>&#160;
		<!--							<input type='button' name='save' value='Save Preferences' onClick='savePreferences()'/>
									<br/>&#160; -->
		
									<span class="labels">Show by:</span> <br/>
										&#160;<input type='radio' name='showby' id='sortby_ScientificName' value='ScientificName'/>Scientific Name<br/>
										&#160;<input type='radio' name='showby' id='sortby_Family' value='Family'/>Family<br/>
										&#160;<input type='radio' name='showby' id='sortby_Genus' value='Genus'/>Genus<br/>
										&#160;<input type='radio' name='showby' id='sortby_Species' value='Species'/>Species<br/>
									<br/>&#160;
									<span class="labels">Label Points:</span><br/>
									<input type='radio' name='labels' id='labels' value='on' onClick='selectTool("ReDraw");'/>
										Show
									<input type='radio' name='labels' id='labelsoff' value='off' checked='true' onClick='selectTool("ReDraw");'/>
										Hide<br/>
									<br/>&#160;
									<span class="labels">Layer Labels:</span><br/>
									<input type='radio' name='labelall' id='labelall' value='true' onClick='selectTool("ReDraw");'/>
										Show
									<input type='radio' name='labelall' id='labelalloff' value='false' checked='true' onClick='selectTool("ReDraw");'/>
										Hide<br/>
									<br/>
								</xsl:when>
								<xsl:otherwise>
									&#160;<span class="labels">Show by:</span> <br/>
										&#160;<input type='radio' name='showby' id='sortby_ScientificName' value='ScientificName'/>Scientific Name<br/>
		
										&#160;<input type='radio' name='showby' id='sortby_Family' value='Family'/>Family<br/>
										&#160;<input type='radio' name='showby' id='sortby_Genus' value='Genus'/>Genus<br/>
										&#160;<input type='radio' name='showby' id='sortby_Species' value='Species'/>Species<br/>
										&#160;<input type='radio' name='showby' id='sortby_Source' value='source'/>Source<br/>
										<br/>&#160;<input type='radio' name='labels' id='labels' value='on' 
										onClick='selectTool("ReDraw");'/> Show<input type='radio' name='labels' id='labelsoff' value='off' checked='true'
										onClick='selectTool("ReDraw");'/>Hide&#160; Scientific Name<br/>
									<br/>
								</xsl:otherwise>
							</xsl:choose>
							</div>
		
							&#160;<span class="labels">Map Layers:</span><br/>
							<xsl:for-each select="/mapper/layers/staticLayer">
								<input type='checkbox' value='on' >
									<xsl:attribute name="name">
										<xsl:value-of select="./layerName" />
									</xsl:attribute>
									<xsl:if test="contains(./status,'true')">
										<xsl:attribute name="checked">true</xsl:attribute>
									</xsl:if>
								</input>
								<xsl:value-of select="./name"/>
								<span class="FootnoteNumber"><xsl:value-of select="./noteId"/></span>
								<br/>
							</xsl:for-each>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</form>	

	<div style='clear: both;'>
		<div id="footer">
        	<br/>
				<div id="Footnotes" class='hideOnPrint'>
					<xsl:for-each select="/mapper/layers/layerNotes">
						<div>
							<span class="FootnoteNumber"><xsl:value-of select="./id"/>.</span>&#160;
							<span class="FootnoteText"><xsl:copy-of select="./notes"/></span>
						</div>
					</xsl:for-each>
				</div>
			<!--<img alt="KE EMu" src="../webservices/images/productlogo.gif"/>-->
			<div id="KE_IP">&#xA9; 2000-2008 KE Software</div>
		</div>
	</div>

</body>

</html>
