<?xml version="1.0"?>
<?xml-stylesheet type='text/xsl' ?>
<!-- (C) 2000-2005 KE Software -->

<!--  this stylesheet has templates to assist in display of data sets.
Typically these shown as components of a page -->

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
<xsl:variable name="detailViewXsl">
	<xsl:value-of select='$styleBase'/>
	<xsl:text>portal_detail.xsl?cacheFooler=</xsl:text>
	<xsl:value-of select='$randomStamp'/>
</xsl:variable>

<xsl:template name='makeUrl'>
	<xsl:param name='link'/>
	<xsl:param name='nameSpace'/>
	<xsl:param name='firstRec'/>
	<xsl:param name='sortBy'/>
	<xsl:param name='order'/>
	<xsl:param name='extractedOnly'/>
	<xsl:value-of select='$link'/>
	<xsl:text>&amp;</xsl:text>
	<xsl:value-of select='$nameSpace'/><xsl:text>-firstRec=</xsl:text><xsl:value-of select='$firstRec'/>
	<xsl:text>&amp;</xsl:text>
	<xsl:value-of select='$nameSpace'/><xsl:text>-sortby=</xsl:text><xsl:value-of select='$sortBy'/>
	<xsl:text>&amp;</xsl:text>
	<xsl:value-of select='$nameSpace'/><xsl:text>-order=</xsl:text><xsl:value-of select='$order'/>
	<xsl:text>&amp;</xsl:text>
	<xsl:value-of select='$nameSpace'/><xsl:text>-extractedOnly=</xsl:text><xsl:value-of select='$extractedOnly'/>
	<xsl:text>&amp;</xsl:text>
	<xsl:text>dataset=</xsl:text><xsl:value-of select='$nameSpace'/>
</xsl:template>

<xsl:template name='dataControlsTop'>
	<xsl:param name='set'/>
	<xsl:variable name="name" select="$set/@name"/>
	<xsl:variable name="dsid" select="$set/@id"/>

	<xsl:variable name="startRec" select="$set/@subsetStart"/>
	<xsl:variable name="subsetCount" select="$set/@subsetCount"/>
	<xsl:variable name="fullSetCount" select="$set/@fullSetCount"/>
	<xsl:variable name="startRecAddOne" select="$startRec + 1"/>
	<xsl:variable name="startRecSubOne" select="$startRec - 1"/>
 	<xsl:variable name="startRecAddPage" select="$startRec + $subsetCount"/>
	<xsl:variable name="startRecSubPage" select="$startRec - $subsetCount"/>
	<xsl:variable name="last" select="$fullSetCount - $subsetCount"/>

	<xsl:variable name="sortby" select="$set/@sortBy"/>
	<xsl:variable name="sortOrder" select="$set/@sortOrder"/>
	<xsl:variable name="extractedOnly" select="$set/@returnMarkedOnly"/>

	<xsl:variable name="datasetId"><xsl:value-of select='$name'/></xsl:variable>
	<xsl:variable name="datagridId">dataGrid_<xsl:value-of select='$name'/></xsl:variable>

	<xsl:variable name="activity">dataset_<xsl:value-of select='$name'/>_activity</xsl:variable>

	<!-- control action url's -->
	<xsl:variable name="urlActionFirst">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>0</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionPageUp">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>
				<xsl:value-of select='$startRecSubPage'/>
			</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionPageDown">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>
				<xsl:value-of select='$startRecAddPage'/>
			</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionOneUp">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>
				<xsl:value-of select='$startRecSubOne'/>
			</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionOneDown">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>
				<xsl:value-of select='$startRecAddOne'/>
			</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionLast">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>
				<xsl:value-of select='$last'/>
			</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionReverse">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>0</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'>
			<xsl:choose>
				<xsl:when test="$sortOrder = 'descending'">
					<xsl:text>ascending</xsl:text>
				</xsl:when>
				<xsl:otherwise>
					<xsl:text>descending</xsl:text>
				</xsl:otherwise>
			</xsl:choose>
			</xsl:with-param>
			<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="urlActionViewDetails">
		<xsl:call-template name='makeUrl'>
			<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
			<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
			<xsl:with-param name='firstRec'>0</xsl:with-param>
			<xsl:with-param name='sortBy'><xsl:value-of select='$sortby'/></xsl:with-param>
			<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
			<xsl:with-param name='extractedOnly'>true</xsl:with-param>
		</xsl:call-template>
	</xsl:variable>


	<div class='datasetControls'>
		<div class='datasetHeading'><xsl:value-of select='$name'/></div>
	 	<span class='action' name='First'>
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>

			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionFirst'/>
			</xsl:attribute>		

			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionFirst'/>
			</xsl:attribute>		
			|&lt;&lt;
		</span>
	 	<span class='action' name='SubPage'> 
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionPageUp'/>
			</xsl:attribute>		

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionPageUp'/>
			</xsl:attribute>		
			&lt;&lt;	
		</span> 
	 	<span class='action' name='Sub1' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionOneUp'/>
			</xsl:attribute>		

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionOneUp'/>
			</xsl:attribute>		
					-1
		</span> 
	 	<span class='action' name='Add1' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionOneDown'/>
			</xsl:attribute>

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionOneDown'/>
			</xsl:attribute>		
			+1
		</span>
	 	<span class='action' name='AddPage' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionPageDown'/>
			</xsl:attribute>		

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionPageDown'/>
			</xsl:attribute>		
			&gt;&gt;	
		</span>
	 	<span class='action' name='Last' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionLast'/>
			</xsl:attribute>		

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionLast'/>
			</xsl:attribute>		
			&gt;&gt;|
		</span>
	 	<span class='action' name='Reverse Sort' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionReverse'/>
			</xsl:attribute>		

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionReverse'/>
			</xsl:attribute>		
			Reverse Sort
		</span>

	 	<span class='action'>
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 		<xsl:attribute name="xslurl_0" ><xsl:value-of select="$detailViewXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionViewDetails'/>
			</xsl:attribute>		
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionViewDetails'/>
			</xsl:attribute>
			View Details
		</span>
	 	<span class='hide'>
			<xsl:attribute name="control"><xsl:value-of select='$datagridId'/></xsl:attribute>
			Hide
		</span>
		<img src='images/activity_ok.gif'>
	 		<xsl:attribute name="id" ><xsl:value-of select="$activity"/></xsl:attribute>
		</img>
	</div>
</xsl:template>

<xsl:template name="dataSet">
	<xsl:variable name="name" select="./@name"/>
	<xsl:variable name="dsid" select="./@id"/>
	<xsl:variable name="groups" select="./groups/group"/>
	<xsl:variable name="start" select="./@subsetStart"/>
	<xsl:variable name="datasetId"><xsl:value-of select='$name'/></xsl:variable>

	<xsl:variable name="sortby" select="./@sortBy"/>
	<xsl:variable name="sortOrder" select="./@sortOrder"/>
	<xsl:variable name="extractedOnly" select="./@returnMarkedOnly"/>

	<xsl:variable name="activity">dataset_<xsl:value-of select='$name'/>_activity</xsl:variable>


		<xsl:call-template name='dataControlsTop'>
			<xsl:with-param name='set' select='.'/>
		</xsl:call-template>
		<div class='dataGrid'>
			<xsl:attribute name="id">dataGrid_<xsl:value-of select='$name'/></xsl:attribute>
			<table cellspacing="0" cellpadding="0">
				<tbody>
				<tr>
					<th class='action'>#</th>
					<!-- <th class='action'>Source</th> -->
					<xsl:for-each select='$groups'>

						<xsl:variable name="urlActionSortBy">
							<xsl:call-template name='makeUrl'>
								<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
								<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
								<xsl:with-param name='firstRec'>0</xsl:with-param>
								<xsl:with-param name='sortBy'>
 									<xsl:value-of select='./@name'/>
								</xsl:with-param>
								<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
								<xsl:with-param name='extractedOnly'><xsl:value-of select='$extractedOnly'/></xsl:with-param>
							</xsl:call-template>
						</xsl:variable>

						<th class='action'>
	 						<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 						<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
	 						<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
							<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
							<xsl:attribute name='xmlurl_0'>
 								<xsl:value-of select='$urlActionSortBy'/>
							</xsl:attribute>		

	 						<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
							<xsl:attribute name="destination_1">Summary</xsl:attribute>
							<xsl:attribute name='xmlurl_1'>
 								<xsl:value-of select='$urlActionSortBy'/>
							</xsl:attribute>		
 						<xsl:value-of select='./@name'/> </th>
					</xsl:for-each>
				</tr>
				<xsl:for-each select='./records/record'>
					<xsl:variable name='marked' select='./@marked'/>
					<xsl:variable name='index' select='./@index'/>
					<xsl:variable name="position" select="position() + $start"/>
					<tr>
						<xsl:attribute name='id'><xsl:value-of select='$name'/>_idx_<xsl:value-of select='$index'/> </xsl:attribute>
						<xsl:attribute name='index'><xsl:value-of select='$name'/>_idx_<xsl:value-of select='$index'/> </xsl:attribute>
						<xsl:choose>
							<xsl:when test="$marked='true'">
								<xsl:attribute name='class'>dataRow marked</xsl:attribute>
							</xsl:when>
							<xsl:otherwise>
								<xsl:attribute name='class'>dataRow unmarked</xsl:attribute>
							</xsl:otherwise>
						</xsl:choose>
						<td class='cell'><xsl:value-of select="$position"/></td>
						<!-- <td class='cell'><xsl:value-of select="./recordSource"/></td> -->
							<xsl:variable name="currentRecord" select="."/>
							<xsl:for-each select='$groups'>
								<xsl:variable name="currentField" select="./@name"/>
								<xsl:variable name="currentElement" select="$currentRecord/group[@name=$currentField]"/>
								<td class='cell'>
									<xsl:value-of select='$currentElement'/>
								</td>
							</xsl:for-each>

					</tr>
				</xsl:for-each>
				</tbody>
			</table>
		</div>
		<xsl:call-template name='Uniques'>
			<xsl:with-param name='set' select='.'/>
		</xsl:call-template>
</xsl:template>

<xsl:template name="Uniques">
	<xsl:param name='set'/>
	<xsl:variable  name='name' select='$set/@name'/>
	<xsl:variable name="dsid" select="$set/@id"/>
	<xsl:variable name="activity">dataset_<xsl:value-of select='$name'/>_activity</xsl:variable>

	 <div>
	  	<xsl:attribute name="id">selectors_<xsl:value-of select='$name'/></xsl:attribute>
	
		<xsl:variable name="startRec" select="$set/@subsetStart"/>
		<xsl:variable name="subsetCount" select="$set/@subsetCount"/>
		<xsl:variable name="fullSetCount" select="$set/@fullSetCount"/>
		<xsl:variable name="startRecAddOne" select="$startRec + 1"/>
		<xsl:variable name="startRecSubOne" select="$startRec - 1"/>
 		<xsl:variable name="startRecAddPage" select="$startRec + $subsetCount"/>
		<xsl:variable name="startRecSubPage" select="$startRec - $subsetCount"/>
		<xsl:variable name="last" select="$fullSetCount - $subsetCount"/>
	
		<xsl:variable name="sortby" select="$set/@sortBy"/>
		<xsl:variable name="sortOrder" select="$set/@sortOrder"/>
		<xsl:variable name="extractedOnly" select="$set/@returnMarkedOnly"/>
	
		<xsl:variable name="datasetId"><xsl:value-of select='$name'/></xsl:variable>
		<xsl:variable name="datagridId">dataGrid_<xsl:value-of select='$name'/></xsl:variable>
		<xsl:variable name='markedOnly' select='$set/@returnMarkedOnly'/>

		<xsl:variable name="urlActionShowAll">
			<xsl:call-template name='makeUrl'>
				<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
				<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
				<xsl:with-param name='firstRec'>0</xsl:with-param>
				<xsl:with-param name='sortBy'>
					<xsl:value-of select='$sortby'/>
				</xsl:with-param>
				<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
				<xsl:with-param name='extractedOnly'>false</xsl:with-param>
			</xsl:call-template>
		</xsl:variable>
		<xsl:variable name="urlActionShowMarked">
			<xsl:call-template name='makeUrl'>
				<xsl:with-param name='link'><xsl:value-of select='$url'/></xsl:with-param>
				<xsl:with-param name='nameSpace'><xsl:value-of select='$name'/></xsl:with-param>
				<xsl:with-param name='firstRec'>0</xsl:with-param>
				<xsl:with-param name='sortBy'>
					<xsl:value-of select='$sortby'/>
				</xsl:with-param>
				<xsl:with-param name='order'><xsl:value-of select='$sortOrder'/></xsl:with-param>
				<xsl:with-param name='extractedOnly'>true</xsl:with-param>
			</xsl:call-template>
		</xsl:variable>


	 	<span class='action' name='Show Selected' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
			<xsl:attribute name="xslurl_0" ><xsl:value-of select="$datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:choose>
				<xsl:when test="$markedOnly='true'">
					<xsl:attribute name='xmlurl_0'>
						<xsl:value-of select='$urlActionShowAll'/>
					</xsl:attribute>		
					<xsl:attribute name='xmlurl_1'>
						<xsl:value-of select='$urlActionShowAll'/>
					</xsl:attribute>		
					Show All
				</xsl:when>
				<xsl:otherwise>
					<xsl:attribute name='xmlurl_0'>
						<xsl:value-of select='$urlActionShowMarked'/>
					</xsl:attribute>		
					<xsl:attribute name='xmlurl_1'>
						<xsl:value-of select='$urlActionShowMarked'/>
					</xsl:attribute>
					Only Show Marked
				</xsl:otherwise>
			</xsl:choose>
		</span>

	 	<span class='action' name='Select None' >
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name"/></xsl:attribute>
	 		<xsl:attribute name="activity" ><xsl:value-of select="$activity"/></xsl:attribute>
			<xsl:attribute name="xslurl_0" ><xsl:value-of select="datasetXsl" /></xsl:attribute>
			<xsl:attribute name="destination_0">dataset_<xsl:value-of select='$datasetId'/></xsl:attribute>
			<xsl:attribute name='xmlurl_0'>
				<xsl:value-of select='$urlActionShowAll'/>
			</xsl:attribute>		

	 		<xsl:attribute name="xslurl_1" ><xsl:value-of select="$summaryXsl" /></xsl:attribute>
			<xsl:attribute name="destination_1">Summary</xsl:attribute>
			<xsl:attribute name='xmlurl_1'>
				<xsl:value-of select='$urlActionShowAll'/>
			</xsl:attribute>		
			Clear Marks
		</span>

		<script type="text/javascript">
		<xsl:text>function addSelectors_</xsl:text>
			<xsl:value-of select="$dsid"/>
			<xsl:text>(){</xsl:text>
		<xsl:for-each select='//dataSet[@name=$name]/groups/group'>
			<xsl:variable name="field" select="./@name"/>
			<xsl:for-each select='./value'>
				<xsl:variable name="value" select="./@data"/>
				<xsl:variable name="recordIndexes" select="./recordIndexes"/>
				<xsl:text>   addToValues("</xsl:text>
					<xsl:value-of select='$name'/>
					<xsl:text>","</xsl:text>
					<xsl:value-of select='$field'/>
					<xsl:text>","</xsl:text>
					<xsl:value-of select='$value'/>
					<xsl:text>","</xsl:text>
					<xsl:value-of select='$recordIndexes'/>
				<xsl:text>");</xsl:text>
			</xsl:for-each>
		</xsl:for-each>
		<xsl:text>}</xsl:text>
		</script>

		<xsl:text>Mark All Fields: </xsl:text>
		<select class='nestedSelect'>
	 		<xsl:attribute name="name" ><xsl:value-of select="$name" />FieldControl</xsl:attribute>
	 		<xsl:attribute name="id" ><xsl:value-of select="$name" />FieldControl</xsl:attribute>
	 		<xsl:attribute name="nestedField" ><xsl:value-of select="$name" />FieldValue</xsl:attribute>
	 		<xsl:attribute name="onClick" >addSelectors_<xsl:value-of select="$dsid"/>();</xsl:attribute>
	
			<option> --Select Field-- </option>
			<xsl:for-each select='//dataSet[@name=$name]/groups/group'>
				<xsl:variable name="field" select="./@name"/>
				<option>
					<xsl:attribute name='value'><xsl:value-of select='$field'/></xsl:attribute>
					<xsl:value-of select='$field'/>
				</option>
			</xsl:for-each>
		</select>
		<xsl:text> = </xsl:text>
		<select  class='selectAction'  width='40' size='1'>
	 		<xsl:attribute name="name" ><xsl:value-of select="$name" />FieldValue</xsl:attribute>
	 		<xsl:attribute name="id" ><xsl:value-of select="$name" />FieldValue</xsl:attribute>
			<option> --Select Value-- </option>
		</select>
	

	 	<span class='selectors'>
	 		<xsl:attribute name="nameSpace" ><xsl:value-of select="$name" /></xsl:attribute>
	 		<xsl:attribute name="fieldControl" ><xsl:value-of select="$name" />FieldControl</xsl:attribute>
	 		<xsl:attribute name="valueControl" ><xsl:value-of select="$name" />FieldValue</xsl:attribute>
			Add to Marked
		</span>

	</div>	
	<div>
		<pre>
			<!--<xsl:copy-of select='/'/>-->
		</pre>
	</div>
</xsl:template> 

</xsl:stylesheet>
