<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
	<!-- <meta charset="ISO-8859-1" /> -->	
	<title>Australian Museum Collections</title>
	<meta name="Description" content="Australian Museum Collections" />
	<meta name="keywords" content="Australian Museum Collections" />
	<meta name="Distribution" content="global" />
	<meta name="robots" content="index, follow, noodp, noydir" />
	<link rel="SHORTCUT ICON" href="/favicon.ico" />

	<link rel="stylesheet" href="./stylesheets/am.css" type="text/css" media="screen, projection" />
	<link rel="stylesheet" href="./stylesheets/print.css" type="text/css" media="print" />
	<link rel="stylesheet" href="./stylesheets/am-emu.css" type="text/css" media="screen" />

	<script type='text/javascript'>
		/* very simple form validation */
		function validateInput()
		{
			var value = document.forms[0].QueryTerms.value;
			
			// remove punctuation
			value = value.replace(/[ -/]/g, ' ');
			value = value.replace(/[{-~]/g, ' ');

			document.forms[0].QueryTerms.value = value;


			if (value.match(/^\s*$/))
			{
				alert("please enter something to search for");
				return false;
			}

			return true;
		}

	</script>
</head>

<body class="yui-skin-sam">
<div id="primary-container">
	<div id="header" class="vcard">
		<h1>
			<a href="/" class="url"><img src="./images/am-logo.gif" alt="Australian Museum - nature, culture, discover" class="logo" /></a>
		</h1>
		<ul>
			<li><a href="#content-start">Skip to content</a></li>
		</ul>
		<a class="include" href="#footer-address"></a>
	</div>
	<!-- primary navigation starts here -->
	<div id="primary-navigation">
		<h3>
			Site navigation
		</h3>
		<ul>
			<li><a href="http://www.australianmuseum.net.au/">Home</a></li>
			<li><a href="http://www.australianmuseum.net.au/about-us/">About us</a></li>
			<li><a href="http://www.australianmuseum.net.au/whatson/">What&#8217;s on</a></li>
			<li><a href="http://www.australianmuseum.net.au/research-and-collections/">Our research &amp; collections</a></li>
			<li><a href="http://www.australianmuseum.net.au/education-services/">Education services</a></li>
			<li><a href="http://www.australianmuseum.net.au/news-blogs/">News &amp; blogs</a></li>
			<li><a href="http://www.australianmuseum.net.au/animals/">Animals</a></li>
			<li><a href="http://www.australianmuseum.net.au/minerals-and-fossils/">Minerals &amp; fossils</a></li>
			<li><a href="http://www.australianmuseum.net.au/cultures/">Cultures</a></li>
			<li><a href="http://www.australianmuseum.net.au/join"> My museum</a></li>
		</ul>
	</div>
       <!-- banner starts here -->
	<div id="banner-asset">
	</div>
	<div id="content-container">
		<div id="content-wide">
			<a name="content-start"></a> 
			<div id="content">
				<div id="emu-title">
					<img src="images/emu-header.jpg" alt="Australian Museum Collection Search" />
				</div>
				<div id="emu-content">
					<h2>
						About the collections
					</h2>
					<p id="emu-intro">
						The Australian Museum holds natural science and cultural collections comprising many millions of specimens and objects. The Natural Science collections date from 1828 and document the biodiversity and geodiversity of the region. The Cultural collections include significant ethnographic and archaeological materials representing Aboriginal and Torres Strait Islander cultures as well as Pacific Islander, Asian, African and American cultures. 
					</p>
					<p>
						These collections existed long before computer databases and adding our collections to the database and photographing them is an ongoing process. We will be continually updating the number of specimens and objects which will be available for you to view online. Search or browse the collections, associated data and stories.  
					</p>
					<div id="emu-search">
						<h3>
							Search
						</h3>
						<?php
							require_once('../../objects/am/QueryForms.php');
	
							$queryform = new AmBasicQueryForm;
							$queryform->ResultsListPage = "ResultsList.php";
							$queryform->formAttributes = "onsubmit='return validateInput()'";
							$queryform->imageCheckId = "emu-search-one2";
							$queryform->fieldInputBlockId = "emu-search-one";
							$queryform->advancedSearchLinkId = "emu-search-one3";
							$queryform->submitId = "emu-search-two";
							$queryform->searchRestrictedTo = "anywhere";
	
							$queryform->Show();
						?>
					</div>
					<div id="emu-browse">
						<h3>
							Browse
						</h3>
						<ul>
						<?php
							require_once('../../objects/am/PreConfiguredNarrativeList.php');
							$narSpecialList = new PreConfiguredNarrativeList();
							$narSpecialList->query = "(exists (DesIntendedAudience_tab where (DesIntendedAudience CONTAINS 'featured'))) AND AdmPublishWebNoPassword CONTAINS 'Yes'"; # All Narratives where Intended Audience = featured and Internet Publish is Yes
							$narSpecialList->queryPage = "./NarrativeQuery.php";
							$narSpecialList->displayPage = "./NarrativeDisplay.php";
	
							$specialLinks = $narSpecialList->getArrayOfLinks();
							foreach ($specialLinks as $title => $link)
							{
								print "<li><a href='$link'>$title</a></li>\n";
							}
						?>		
							<!-- <li><a href="#">Archaeology Narratives</a></li>
							<li><a href="#">Art</a></li>
							<li><a href="#">Body Accessoriea</a></li>
							<li><a href="#">Torres Strait Islands</a></li>
							<li><a href="#">Aboriginal Bark Paintings</a></li>
							<li><a href="#">Malagan Masks</a></li>
							<li><a href="#">Cook Collection</a></li>
							<li><a href="#">Transport</a></li>
							<li><a href="#">Toy</a></li>
							<li><a href="#">Tool</a></li>
							<li><a href="#">Textile and Equipment</a></li>
							<li><a href="#">Sound and Music</a></li>
							<li><a href="#">Raw Material</a></li>
							<li><a href="#">Leisure</a></li>
							<li><a href="#">Hunting</a></li>
							<li><a href="#">Household</a></li>
							<li><a href="#">Container</a></li>
							<li><a href="#">Communication and Exchange</a></li>
							<li><a href="#">Clothing</a></li>
							<li><a href="#">Narratives with Images</a></li>-->
						</ul>
					</div>
				</div>
				<div id="emu-sidebar">
					<h3>
						<a href="http://www.biomaps.net.au/biomaps2/">Biomaps</a>
					</h3>
					<p>
						<!-- Search biodiversity data held by Australian Natural History Institutions, compile maps and model potential distributions of species. -->
						Mapping australia's biodiversity
					</p>
					<h3>
						<a href="http://ozcam.org/">OZCAM</a>
					</h3>
					<p>
						Online Zoological Collections of Australian Museums
					</p>
					<h3>
						<a href="http://www.ala.org.au/">Atlas of Living Australia</a>
					</h3>
					<p>
						Sharing biodiversity knowledge.
						<!-- ALA brings together records from Natural History Collections and field observations to provide a detailed view of the past and present distribution of species found in Australia. -->
					</p>
					<h3>
						<a href="http://www.gbif.org/">Global Biodiversity Information Facility</a>
					</h3>
					<p>
						Your gateway to the worlds biodiversity data
						<!-- GBIF is an international organisation working to make the world's biodiversity data accessible. -->
					</p>
				</div>					
			</div>
		</div>
	</div>
	<div id="footer-primary">
		<h3>
			Quick links 
		</h3>
		<ul>
			<li class="nsw-government"><a href="http://www.nsw.gov.au/">NSW Government</a></li>
			<li><a href="/about-the-site" rel="help">About the site</a></li>
			<li><a href="/accessibility">Accessibility</a></li>
			<li><a href="/Sitemap">Site map</a></li>
			<li><a href="/privacy">Privacy</a></li>
			<li><a href="/copyright" rel="license">Copyright</a></li>
			<li><a href="/Contact/Website">Feedback</a></li>
		</ul>
	</div>
</div>
</body>
</html>
