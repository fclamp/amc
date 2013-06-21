<html xsl:version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

	<!-- (C) 2000-2007 KE Software -->

	<!-- Variables-->
<xsl:variable name='emuwebBase'>
	<xsl:value-of select="//statusBlock/emuwebBase"></xsl:value-of>
</xsl:variable>
<xsl:variable name='emuBackendType'>
	<xsl:value-of select="//statusBlock/emuBackendType"></xsl:value-of>
</xsl:variable>
<xsl:variable name='referer'>
	<xsl:value-of select="//statusBlock/referer"></xsl:value-of>
</xsl:variable>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"></meta>
	<title>Search results</title>
	<link rel="stylesheet" type="text/css" href="mapper/style/mapper.css"/>

	<script type='text/javascript'>
		var Referer = "<xsl:value-of select="$referer"></xsl:value-of>";
	</script>

	<script type='text/javascript'  src="mapper/style/scripts/mapdisplay.js">
	</script>
</head>

<body gbcolor = "#336699">
	<div id="banner">
		<h1>Results List</h1>
	</div>
<p>&#160;</p>

<center>

<!--START OBJECT-->
<xsl:if test="not(//records/record)">
	<h2>Sorry... No specimens in the selected area</h2>
	<h3><a id="Text" href="javascript:history.go(-1)">Return to distribution map</a></h3>
</xsl:if>

<xsl:if test="boolean(//records/record)">


	<table id="LayoutTable">
		<tr>
			<td>
				<a href="javascript:history.go(-1)" class="Href">Go Back</a>
			</td>
		</tr>
		<tr>
			<td>
				<!--START RESULTS TABLE-->			
				<xsl:choose>
					<xsl:when test="boolean(//records/record)">
						<table id="ResultsTable" border='1'>
							<tr>
							<!--START HEADER CELL ROW-->
						<xsl:for-each select="//groups/group">
							<xsl:variable name='group' select='.'/>

							<xsl:choose>
								<xsl:when test="$group = 'recordSource'" />
								<xsl:when test="$group = 'keDescription'" />
								<xsl:when test="$group = 'Latitude'" />
								<xsl:when test="$group = 'Longitude'" />
								<xsl:when test="$group = 'group'" />
								<xsl:when test="contains($group,'keLayer')" />
								<xsl:when test="$group='record'" />
								<xsl:otherwise>
									<xsl:choose>
										<xsl:when test="$group = 'description'" >
										<th class='ResultsListHeaderCell'>
											<xsl:text>Summary</xsl:text>
										</th>
										</xsl:when>
										<xsl:otherwise>
										<th class='ResultsListHeaderCell'>
											<xsl:value-of select="."/>
										</th>
										</xsl:otherwise>
									</xsl:choose>
								</xsl:otherwise>
							</xsl:choose>
						</xsl:for-each>
							<!--END HEADER CELL ROW-->
						</tr>
						<!--START RECORD-->
						<xsl:for-each select="//records/record">
						<tr>
							<xsl:choose>
								<xsl:when test="position() mod 2 = 0">
									<xsl:attribute name="class">
										<xsl:text>ResultsListTextCellEven</xsl:text>
									</xsl:attribute>
								</xsl:when>
								<xsl:otherwise>
									<xsl:attribute name="class">
										<xsl:text>ResultsListTextCell</xsl:text>
									</xsl:attribute>
								</xsl:otherwise>
							</xsl:choose>
							<xsl:variable name='record' select='.'/>
							<!--START RECORD ROW-->
							<xsl:for-each select="//groups/group">
								<xsl:variable name='group' select='.'/>
								<xsl:choose>
									<xsl:when test="$group = 'recordSource'" />
									<xsl:when test="$group = 'keDescription'" />
									<xsl:when test="$group = 'Latitude'" />
									<xsl:when test="$group = 'Longitude'" />
									<xsl:when test="$group = 'group'" />
									<xsl:when test="contains($group,'keLayer')" />
									<xsl:when test="$group='record'" />
									<xsl:otherwise>
									<xsl:choose>
										<xsl:when test="$group = 'description'" >
											<td class='ResultsListFatCell'>
												<xsl:value-of select="$record/group[@name=$group]"/>
											</td>
										</xsl:when>
										<xsl:otherwise>
											<td class='ResultsListCell'>
												<xsl:value-of select="$record/group[@name=$group]"/>
											</td>
										</xsl:otherwise>
									</xsl:choose>
									</xsl:otherwise>
								</xsl:choose>
							</xsl:for-each>
							<!--END RECORD ROW-->
						</tr>
						</xsl:for-each>
						<!--END RECORD-->
						</table>
					</xsl:when>
					<xsl:otherwise>
						<h3>Error</h3>
					</xsl:otherwise>
				</xsl:choose>
				<!--END RESULTS TABLE-->
			</td>
		</tr>
	</table>

</xsl:if>
<!--END OBJECT-->
</center>

	<div style='clear: both;'>
		<div id="footer">
        	<br/>
				<div id="Footnotes">
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
