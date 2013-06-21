<?php
/*
** Copyright (c) KE Software Pty. Ltd. 2008
*/
?>
  	<?php
	require_once('includes/index.php');
	include('includes/header.inc');
	?>
			<p class="relLinks">
			</p>
			<div id="siteproxy">
			<table class="component mcenter" width="60%" cellpadding="2" cellspacing="0" border="0">
				<tr class="componentHeader">
					<td align="center" colspan="7" class="componentHeaderText">Collection Search</td>
				</tr>
			<tr>
				<td height="4" />
			</tr>
			<tr>
				<td id="keywordtab" nowrap="nowrap" width="170" align="center" class="componentBody">
					<a href="javascript:SwitchSearchTabs('keywordsearchbody')" class="href=componentBodyHyperlink">
						<span class="componentBodyText">
							<strong>Search by keyword</strong>
						</span>
					</a>
				</td>
				<td height="4" />
				<td id="quicktab" nowrap="nowrap" width="170" align="center" class="componentBody2">
					<a href="javascript:SwitchSearchTabs('quicksearchbody')" class="href=componentBodyHyperlink">
						<span class="componentBodyText">
							<strong>Quick searches</strong>
						</span>
					</a>
				</td>
			
				<td height="4" />
			
				<td id="detailedtab" nowrap="nowrap" width="170" align="center" class="componentBody2">
					<a href="javascript:SwitchSearchTabs('detailedsearchbody')" class="href=componentBodyHyperlink">
						<span class="componentBodyText">
							<strong>Detailed search</strong>
						</span>
					</a>
				</td>
				<td height="4" />	
			</tr>	
		</table>
		<!-- Intranet Keyword Search -->
		<div id="keywordsearchbody">
		<form id="keywordsearch" action="results.php">
			<table class="component mcenter" width="60%" cellpadding="4" cellspacing="0" border="0">
				<tr class="componentBody">
					<td class="componentBodyText" align="left" colspan="7">	
						<label for= "keyword">Keywords</label>
					</td>	
					<td class="componentBodyText" align="left" colspan="7">
						<input id= "keyword" type="text" name="keyword"  style="width:206px" />
					</td>
				</tr>
				<tr class= "componentBody">
				<td class= "componentBodyText" align="left" colspan="7">
				</td>
				<td class= "componentBodyText" align="left" colspan="7">
					<input type="submit" value="Search" />
					<input type="reset" value="Reset" />
				</td>	
			</tr>
			</table>
		</form>	
		</div>	
		<!--Quick Searches -->
		<div id="quicksearchbody">
		<table class="component mcenter" width="60%" cellpadding="4" cellspacing="0" border="0">
			<?php
			foreach ($lutscolnamevals as $lutscolnameval)
			{ 
				if ($lutscolnameval != "Maps & Plans")
				{
			?>
					<tr class="componentBody">
						<td class= "componentBodyText" align="left" colspan="7">
							<a href="results.php?preconf=<?php print $lutscolnameval?>"><?php print htmlentities($lutscolnameval);?></a>
						</td>
					</tr>	
			<?php	
				}
			
				elseif ($lutscolnameval == "Maps & Plans")
				{
				?>
					<tr class="componentBody">
						<td class= "componentBodyText" align="left" colspan="7">
							<a href="results.php?preconf=Maps &amp;Plans"> Maps &amp; Plans</a>
						</td>
					</tr>
				<?php
				}
			}
			?>		
		</table>
		</div>
		
		<!-- Detailed Search -->
		<div id="detailedsearchbody">
		<form id="detailedsearch" action="results.php">
		<table class="component mcenter" width="60%" cellpadding="3" cellspacing="0" border="0">
			<tr class="componentBody">
				<td class="componentBodyText" align="left" colspan="7">
					<label for= "colcoll">Type of Collection</label>
				</td>
				<td>
				<select class="componentBodyText" name="colcoll" id= "colcoll" style="width:210px" onchange="FieldSelector();">
					<option></option>
						<?php
						foreach ($lutscolnamevals as $lutscolnameval)
						{ 
						
						?>
							<option value="<?php print htmlentities($lutscolnameval);?>"><?php print htmlentities($lutscolnameval);?></option>	
						<?php	
						}
						?>
					
				</select>
				</td>
			</tr>
			<tr id= "objNumLbl">	
				<td class= "componentBodyText" align="left" colspan="7">
					<label for= "objnum" id= "objNumCaption">Object Number</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">		
					<input id= "objnum" type="text" name="objnum" style="width:206px" />
				</td>
			</tr>
			<tr id= "specNameLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="specimenname">Specimen Name</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="specimenname" type="text" name="specimenname" style="width:206px" />
				</td>
			</tr>
			<tr id= "objNameLbl">	
				<td class= "objname" align="left" colspan="7">
					<label for= "objname" id= "objnameCaption">Object Name</label>
				</td>
				<td>		
					<input class="componentBodyText" id= "objname" type="text" name="objname" style="width:206px" />
				</td>
			</tr>
			<tr id= "mapTitleLbl">		
				<td class= "componentBodyText" align="left" colspan="7">
					<label for= "maptitle">Map Title</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="maptitle" type="text" name="maptitle" style="width:206px" />
				</td>	
			</tr>
			<tr id= "objFullNameLbl">	
				<td class= "componentBodyText" align="left" colspan="7">
					<label for= "objfullname">Object Full Name</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">		
					<input id= "objfullname" type="text" name="objfullname" style="width:206px" />
				</td>
			</tr>
			<tr id= "descriptionLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="description">Description</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="description" type="text" name="description" style="width:206px" />
				</td>
			</tr>
			<tr id= "obverseDescriptionLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="obvdescription">Obverse Description</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="obvdescription" type="text" name="obvdescription" style="width:206px" />
				</td>
			</tr>
			<tr id= "reverseDescriptionLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="revdescription">Reverse Description</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="revdescription" type="text" name="revdescription" style="width:206px" />
				</td>
			</tr>
			<tr id= "periodLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for= "period">Associated Period</label>
				</td>	
				<td class= "componentBodyText" align="left" colspan="7">
					<input id= "period" type="text" name="period" style="width:206px" />
				</td>
			</tr>
			<tr id= "adateLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for= "adate">Associated Date</label>
				</td>	
				<td class= "componentBodyText" align="left" colspan="7">
					<input id= "adate" type="text" name="adate" style="width:206px" />
				</td>
			</tr>
			<tr id= "aplaceLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for= "aplace">Associated Place</label>
				</td>	
				<td class= "componentBodyText" align="left" colspan="7">
					<input id= "aplace" type="text" name="aplace" style="width:206px" />
				</td>
			</tr>
			<tr id= "associatedEventLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="assocevent">Associated Event</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="assocevent" type="text" name="assocevent" style="width:206px" />
				</td>
			</tr>
			<tr id= "associatedPersonLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="assocpersonorg" id="assocPersonLabel">Associated Person/Organisation</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="assocpersonorg" type="text" name="assocpersonorg" style="width:206px" />
				</td>
			</tr>
			<tr id= "preciseLocationLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for= "plocation">Precise Location</label>
				</td>	
				<td class= "componentBodyText" align="left" colspan="7">
					<input id= "plocation" type="text" name="plocation" style="width:206px" />
				</td>
			</tr>
			<tr id= "collEventLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="collevent">Collection Event</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="collevent" type="text" name="collevent" style="width:206px" />
				</td>
			</tr>
			<tr id= "otherNumTypeLbl">
               	<td class= "componentBodyText" align="left" colspan="7">
                         <label for="othernumtype">Other Number Type</label>
               </td>
               <td class= "componentBodyText" align="left" colspan="7">
                    <input id="othernumtype" type="text" name="othernumtype" style="width:206px" />
               </td>
               </tr>
          	<tr id= "otherNumLbl">
                    <td class= "componentBodyText" align="left" colspan="7">
                         <label for="othernum">Other Number</label>
                    </td>
                    <td class= "componentBodyText" align="left" colspan="7">
                         <input id="othernum" type="text" name="othernum" style="width:206px" />
                    </td>
               </tr>

			<tr id= "bibliographyLbl">
                    <td class= "componentBodyText" align="left" colspan="7">
                         <label for="bibliography">Bibliography</label>
                    </td>
                    <td class= "componentBodyText" align="left" colspan="7">
                         <input id="bibliography" type="text" name="bibliography" style="width:206px" />
                    </td>
               </tr>
               <tr id= "siteCodeLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="sitecode">Site Code</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="sitecode" type="text" name="sitecode" style="width:206px" />
				</td>
			</tr>
			<tr id= "projectNameLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="projectname">Project Name</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="projectname" type="text" name="projectname" style="width:206px" />
				</td>
			</tr>
			<tr id= "archSiteNameLbl">
                    <td class= "componentBodyText" align="left" colspan="7">
                         <label for="archsitename">Archaeological Site Name</label>
                    </td>
                    <td class= "componentBodyText" align="left" colspan="7">
                         <input id="archsitename" type="text" name="archsitename" style="width:206px" />
                    </td>
               </tr>
			<tr id= "chronsgraphyLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="chronsgraphy">Chronostratigraphy</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="chronsgraphy" type="text" name="chronsgraphy" style="width:206px"/>
				</td>
			</tr>
			<tr id= "lithosgraphyLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="lithosgraphy">Lithostratigraphy</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="lithosgraphy" type="text" name="lithosgraphy" style="width:206px" />
				</td>
			</tr>
			<tr id= "localityLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="locality">Locality</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="locality" type="text" name="locality" style="width:206px" />
				</td>
			</tr>
			<tr id= "preservationLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="preservation">Preservation Technique</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="preservation" type="text" name="preservation" style="width:206px" />
				</td>
			</tr>
			<tr id= "creditLineLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="assoccreditline">Credit Line</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="assoccreditline" type="text" name="assoccreditline" style="width:206px" />
				</td>
			</tr>
			<tr id= "subClassLbl">
				<td class= "subclassification" align="left" colspan="7">	
					<label for="subclassification">Subject Classification</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="subclassification" type="text" name="subclassification" style="width:206px" />
				</td>
			</tr>	
			<tr id= "familyLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="family">Family</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="family" type="text" name="family" style="width:206px" />
				</td>
			</tr>
			<tr id= "genusLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="genus">Genus</label>
				</td>
				<td class= "componentBodyText">	
					<input id="genus" type="text" name="genus" style="width:206px" />
				</td>
			</tr>
			<tr id= "orderLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="order">Order</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="order" type="text" name="order" style="width:206px" />
				</td>
			</tr>
			<tr id= "speciesLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="species">Species</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="species" type="text" name="species" style="width:206px"/>
				</td>
			</tr>
			<tr id= "culturalGroupLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="culturalgroup">Cultural Group</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="culturalgroup" type="text" name="culturalgroup" style="width:206px" />
				</td>
			</tr>
			<tr id= "titleLbl">
				<td class= "componentBodyText" align="left" colspan="7">
					<label for= "title">Title</label>
				</td>	
				<td class= "componentBodyText" align="left" colspan="7">
					<input id= "title" type="text" name="title" style="width:206px" />
				</td>	
			</tr>
			<tr id= "artistLbl">
				<td class= "componentBodyText" align="left" colspan="7">
					<label for= "artist">Artist</label>
				</td>	
				<td class= "componentBodyText" align="left" colspan="7">
					<input id= "artist" type="text" name="artist" style="width:206px" />
				</td>
			</tr>
			<tr id= "makerLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="manmaker">Manufacturer/Maker</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="manmaker" type="text" name="manmaker" style="width:206px"/>
				</td>
			</tr>
			<tr id= "productionPlaceLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="pproduction">Place of Production</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="pproduction" type="text" name="pproduction" style="width:206px" />
				</td>
			</tr>
			<tr id= "productionDateLbl">
				<td class= "componentBodyText" align="left" colspan="7">	
					<label for="dproduction">Date of Production</label> 
				</td>
				<td class= "componentBodyText" align="left" colspan="7">	
					<input id="dproduction" type="text" name="dproduction" style="width:206px" />
				</td>
			</tr>
			<tr class= "componentBody">
				<td class= "componentBodyText" align="left" colspan="7">
					<label for="itemsimgcheck">Only items with images</label>
				</td>
				<td class= "componentBodyText" align="left" colspan="7">
					<input type="checkbox" name="itemsimgcheck" id="itemsimgcheck" />
				</td>
			</tr>
			<tr class= "componentBody">
				<td class= "componentBodyText" align="left" colspan="7">
				</td>
				<td class= "componentBodyText" align="left" colspan="7">
					<input type="submit" value="Search" />
					<input type="reset" value="Reset" />
				</td>		
			</tr>
		</table>
		</form>
	</div>												
</div>

<script type="text/javascript">
	SwitchSearchTabs('keywordsearchbody');
	FieldSelector();

</script>



<?php
include('includes/footer.inc');
?>
	
