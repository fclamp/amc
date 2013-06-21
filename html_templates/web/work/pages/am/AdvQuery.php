<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta charset="ISO-8859-1" />
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
				<ul id="emu-nav">
					<li><a href="Query.php">Collection home</a></li>
					<li><a href="AdvQuery.php">Advanced search</a></li>
					<li><a href="NarrativeQuery.php">Stories</a></li>
					<li><a href="http://australianmuseum.net.au/contact/general">Contact us</a></li>
				</ul>
			
				<div id='emu-advanced'>
						<h2>
							Advanced search
						</h2>
						<?php
							require_once('../../objects/am/QueryForms.php');
							$advQuery = new AmAdvancedQueryForm;
							$advQuery->imageCheckId = "emu-advanced2";
							$advQuery->fieldInputBlockId = "emu-advanced1";
							$advQuery->submitId = "emu-advanced3";
							$advQuery->Show();
						?>

 					<div id='emu-advanced4'>
                                        	<div id='emu-advanced5'>
							<h2>
								Natural Science Collections
							</h2>
							<?php
								require_once('../../objects/am/QueryForms.php');
								$natHistDetailedQuery = new AmDetailedQueryForm;
								$natHistDetailedQuery->imageCheckId = "emu-advanced5b";
								$natHistDetailedQuery->fieldInputBlockId = "emu-advanced5a";
								$natHistDetailedQuery->submitId = "emu-advanced5c";
								$natHistDetailedQuery->Show();
							?>
						</div>		
						<div id='emu-advanced6'>
							<h2>
								Cultural Collections
							</h2>
							<?php
								require_once('../../objects/am/QueryForms.php');
								$anthDetailedQuery = new AmDetailedAnthQueryForm;
								$anthDetailedQuery->imageCheckId = "emu-advanced6b";
								$anthDetailedQuery->fieldInputBlockId = "emu-advanced6a";
								$anthDetailedQuery->submitId = "emu-advanced6c";
								$anthDetailedQuery->Show();
							?>
						</div>	
					</div>	
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
