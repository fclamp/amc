<?php
/*
** Copyright (c) KE Software Pty. Ltd. 2008
*/
?>
  	<?php
	require_once('./includes/index.php');
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
			<table class="component mcenter" width="60%" cellpadding="3" cellspacing="0" border="0">
				<tr class="componentBody">
					<td class="componentBodyText" align="left" colspan="7">	
						<label for= "keyword">Keywords</label>
					</td>	
					<td class="componentBodyText" align="left" colspan="7">
						<input id= "keyword" type="text" name="keyword"  style="width:210px" />
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
				<td class="componentBodyText" >
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
			<tr class="componentBody" id= "objStatusLbl">
				<td class= "objstatus" >	
					<label for= "objstatus">Object Status</label>
				</td>	
				<td>
					<select class="componentBodyText" name="objstatus" id="objstatus" style="width:210px">	
					<option></option>
					<?php
					foreach ($lutsobjsvals as $lutsobjsval)
					{ 
					?>
						<option value="<?php print htmlentities($lutsobjsval); ?>"><?php print htmlentities($lutsobjsval);?></option>	
					<?php	
					}
					?>
					</select>
				</td>
			</tr>
				<tr id= "objNumLbl" class="componentBody" >	
				<td class= "componentBodyText" >
					<label for= "objnum" id= "objNumCaption">Object Number</label> <!--On Archaeological Site Archives Intranet this field is called Site Archive Accession Number-->
				</td>
				<td class= "componentBodyText" >		
					<input id= "objnum" type="text" name="objnum" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "objNameLbl">	
				<td class= "objname" >
					<label for= "objname">Object Name</label>
				</td>
				<td>		
					<input class="componentBodyText" id= "objname" type="text" name="objname" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "subClassLbl">
				<td class= "subclassification" >	
					<label for="subclassification">Subject Classification</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="subclassification" type="text" name="subclassification" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "objFullNameLbl">	
				<td class= "componentBodyText" >
					<label for= "objfullname">Object Full Name</label>
				</td>
				<td class= "componentBodyText" >		
					<input id= "objfullname" type="text" name="objfullname" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "mapTitleLbl">		
				<td class= "componentBodyText" >
					<label for= "maptitle">Map Title</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="maptitle" type="text" name="maptitle" style="width:206px" />
				</td>	
			</tr>
			<tr class="componentBody" id= "publisherLbl">		
				<td class= "componentBodyText" >
					<label for= "publisher">Publisher</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="publisher" type="text" name="publisher" style="width:206px" />
				</td>	
			</tr>
			<tr class="componentBody" id= "specNameLbl">
				<td class= "componentBodyText" >	
					<label for="specimenname">Specimen Name</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="specimenname" type="text" name="specimenname" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "familyLbl">
				<td class= "componentBodyText" >	
					<label for="family">Family</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="family" type="text" name="family" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "genusLbl">
				<td class= "componentBodyText" >	
					<label for="genus">Genus</label>
				</td>
				<td class= "componentBodyText">	
					<input id="genus" type="text" name="genus" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "orderLbl">
				<td class= "componentBodyText" >	
					<label for="order">Order</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="order" type="text" name="order" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "speciesLbl">
				<td class= "componentBodyText" >	
					<label for="species">Species</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="species" type="text" name="species" style="width:206px"/>
				</td>
			</tr>
			<tr class="componentBody" id= "otherNumTypeLbl">
				<td class= "componentBodyText" >	
					<label for="othernumtype">Other Number Type</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="othernumtype" type="text" name="othernumtype" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "otherNumLbl">
				<td class= "componentBodyText" >	
					<label for="othernum">Other Number</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="othernum" type="text" name="othernum" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "bibliographyLbl">
				<td class= "componentBodyText" >	
					<label for="bibliography">Bibliography</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="bibliography" type="text" name="bibliography" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "culturalGroupLbl">
				<td class= "componentBodyText" >	
					<label for="culturalgroup">Cultural Group</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="culturalgroup" type="text" name="culturalgroup" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "nameCollLbl">
				<td class= "componentBodyText" >	
					<label for="namecoll">Named Collection</label> <!--On Social History Intranet label is "Named Collection Person/Organisation"-->
				</td>
				<td class= "componentBodyText" >	
					<input id="namecoll" type="text" name="namecoll" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "makerLbl">
				<td class= "componentBodyText" >	
					<label for="manmaker">Manufacturer/Maker</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="manmaker" type="text" name="manmaker" style="width:206px"/>
				</td>
			</tr>
			<tr class="componentBody" id= "productionPlaceLbl">
				<td class= "componentBodyText" >	
					<label for="pproduction">Place of Production</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="pproduction" type="text" name="pproduction" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "productionDateLbl">
				<td class= "componentBodyText" >	
					<label for="dproduction">Date of Production</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="dproduction" type="text" name="dproduction" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "creditLineLbl">
				<td class= "componentBodyText" >	
					<label for="assoccreditline">Credit Line</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="assoccreditline" type="text" name="assoccreditline" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "associatedEventLbl">
				<td class= "componentBodyText" >	
					<label for="assocevent">Associated Event</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="assocevent" type="text" name="assocevent" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "associatedPersonLbl">
				<td class= "componentBodyText" >	
					<label for="assocpersonorg" id="assocPersonLabel">Associated Person/Organisation</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="assocpersonorg" type="text" name="assocpersonorg" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "descriptionLbl">
				<td class= "componentBodyText" >	
					<label for="description">Description</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="description" type="text" name="description" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "obverseDescriptionLbl">
				<td class= "componentBodyText" >	
					<label for="obvdescription">Obverse Description</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="obvdescription" type="text" name="obvdescription" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "reverseDescriptionLbl">
				<td class= "componentBodyText" >	
					<label for="revdescription">Reverse Description</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="revdescription" type="text" name="revdescription" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "chronsgraphyLbl">
				<td class= "componentBodyText" >	
					<label for="chronsgraphy">Chronostratigraphy</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="chronsgraphy" type="text" name="chronsgraphy" style="width:206px"/>
				</td>
			</tr>
			<tr class="componentBody" id= "lithosgraphyLbl">
				<td class= "componentBodyText" >	
					<label for="lithosgraphy">Lithostratigraphy</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="lithosgraphy" type="text" name="lithosgraphy" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "localityLbl">
				<td class= "componentBodyText" >	
					<label for="locality">Locality</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="locality" type="text" name="locality" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "archSiteNameLbl">
				<td class= "componentBodyText" >	
					<label for="archsitename">Archaeological Site Name</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="archsitename" type="text" name="archsitename" style="width:206px" />
				</td>
			</tr>	
			<tr class="componentBody" id= "titleLbl">
				<td class= "componentBodyText" >
					<label for= "title">Title</label>
				</td>	
				<td class= "componentBodyText" >
					<input id= "title" type="text" name="title" style="width:206px" />
				</td>	
			</tr>
			<tr class="componentBody" id= "artistLbl">
				<td class= "componentBodyText" >
					<label for= "artist">Artist</label>
				</td>	
				<td class= "componentBodyText" >
					<input id= "artist" type="text" name="artist" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "periodLbl">
				<td class= "componentBodyText" >	
					<label for= "period">Associated Period</label>
				</td>	
				<td class= "componentBodyText" >
					<input id= "period" type="text" name="period" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "adateLbl">
				<td class= "componentBodyText" >	
					<label for= "adate">Associated Date</label>
				</td>	
				<td class= "componentBodyText" >
					<input id= "adate" type="text" name="adate" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "aplaceLbl">
				<td class= "componentBodyText" >	
					<label for= "aplace">Associated Place</label>
				</td>	
				<td class= "componentBodyText" >
					<input id= "aplace" type="text" name="aplace" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "preciseLocationLbl">
				<td class= "componentBodyText" >	
					<label for= "plocation">Precise Location</label>
				</td>	
				<td class= "componentBodyText" >
					<input id= "plocation" type="text" name="plocation" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "collEventLbl">
				<td class= "componentBodyText" >	
					<label for="collevent">Collection Event</label> 
				</td>
				<td class= "componentBodyText" >	
					<input id="collevent" type="text" name="collevent" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "locLevel1Lbl">
				<td class= "componentBodyText" >	
					<label for="loclevel1">Location Level 1 (Museum/Venue name)</label>
				</td>
				<td class= "componentBodyText" >	
					<select name="loclevel1" id= "loclevel1" style="width:210px;">	
					<option></option>
						<?php
						foreach ($lutsloc1vals as $lutsloc1val)
						{ 
						?>
							<option value="<?php print htmlentities($lutsloc1val);?>"><?php print htmlentities($lutsloc1val);?></option>	
						<?php	
						}
						?>
					</select>
				</td>
			</tr>
			<tr class="componentBody" id= "locLevel2Lbl">
				<td class= "componentBodyText" >	
					<label for="loclevel2">Location Level 2 (Room/Gallery name</label>
				</td>
				<td class= "componentBodyText" >	
					<select name="loclevel2" id= "loclevel2" style="width:210px;">	
						<option></option>
						<?php
						foreach ($lutsloc2vals as $lutsloc2val)
						{ 
						?>
							<option value="<?php print htmlentities($lutsloc2val);?>"><?php print htmlentities($lutsloc2val);?></option>	
						<?php	
						}
						?>
					</select>
				</td>
			</tr>
			<tr class="componentBody" id= "siteCodeLbl">
				<td class= "componentBodyText" >	
					<label for="sitecode">Site Code</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="sitecode" type="text" name="sitecode" style="width:206px" />
				</td>
			</tr>
			<tr class="componentBody" id= "projectNameLbl">
				<td class= "componentBodyText" >	
					<label for="projectname">Project Name</label>
				</td>
				<td class= "componentBodyText" >	
					<input id="projectname" type="text" name="projectname" style="width:206px" />
				</td>
			</tr>
			<tr class= "componentBody">
				<td class= "componentBodyText" >
					<label for="itemsimgcheck">Only items with images</label>
				</td>
				<td class= "componentBodyText" >
					<input type="checkbox" name="itemsimgcheck" id="itemsimgcheck"/>
				</td>
			</tr>
			<tr class= "componentBody">
				<td class= "componentBodyText" >
				</td>
				<td class= "componentBodyText" >
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
	
