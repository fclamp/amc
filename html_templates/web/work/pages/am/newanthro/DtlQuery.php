<html>

<head>
	<meta charset="ISO-8859-1" />
	<title>Australian Museum Collection Search [ detailed ]</title>
	<style type="text/css">
		@import url("./css/amemu.css");
	</style>
</head>

<body>

	<div id='header'>Detailed Search...</div>
	<div id='nav'>
		<ul>
			<li><a href="Query.php">Basic search</a><li>
			<li><a href="AdvQuery.php">Advanced search</a></li>
		</ul>
	</div>

	<p class='clearBoth'>
		<h2>
			Welcome to the Australian Museum's Collection, Detailed Search Page
		</h2>
	</p>


	<div class='pageDescription'>
		<p>
		This page enables you to search for specimens in the Australian Museum.
		By looking for records using more specific criteria
		</p>
		<p>
		The collection includes more than 5,000,000 insects, 3,000,000
		molluscs, 1,000,000 fishes, 1,000,000 archaeological objects, 111,000
		anthropological objects and 70,000 rocks and minerals.
		Whilst not all specimens in the collection are available for public
		access (for various reasons including privacy, cultural
		reasons or due to issues with the data) a very large number are.</p>
		<p>
		Enter any terms in the boxes below, select an area to search,
		then click the "Search" button
		</p>
	</div>

	<div class='prebuiltSearches'>
    		<b>Quick Search Links</b>
		<p>find...</p>
		<ul>
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
				$MediaLink->Where = "MulHasMultiMedia = 'y'";
				$MediaLink->PrintRef();
			?>">

          	Items with images
	  		</a>
			</li>
			<li>
	  		<a href="<?php

			require_once('../../objects/common/RandomQuery.php');
				$RandomQry = new RandomQuery;
				$RandomQry->LowerIRN = 1;
				$RandomQry->UpperIRN = 12000;
				$RandomQry->MaxNumberToReturn = 50;
				$RandomQry->PrintRef();
			?> ">

          	Random pieces
	  		</a>
			</li>
			<li>
          		<a href="
			<?php
				// make a date
				$withinMonths = 3;
				$recentTime = time() - ($withinMonths * 2592000) ;
				$recentDate = date('dmY', $recentTime);

				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->Where = "AdmDateInserted > date '$recentDate'";
				$MediaLink->PrintRef();

			?> ">
        	Recent Registrations
	  		</a>
			</li>
		</ul>	
	</div>

	<p class='clearBoth'/>

	<div class='searchBlock'>
		<br/>
		<br/>

		<!-- EMuWeb Detailed Query Object -->
		<?php
			require_once('../../objects/am/QueryForms.php');
			$queryform = new AmDetailedAnthQueryForm;
			$queryform->Show();
		?>
		<!-- ---------------------------- -->
	</div>


	<div class='branding'>
    		Powered by
		<br/>
		<img src="images/productlogo.gif">
      		<!-- <a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif"></a> -->
		<br/>
		Copyright © 2000-2009 KE Software.
	</div>

</body>

</html>
