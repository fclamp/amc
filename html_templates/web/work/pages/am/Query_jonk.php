<html>

<head>
	<meta charset="ISO-8859-1" />
	<title>Australian Museum Collection Search...</title>
	<style type="text/css">
		@import url("./css/amemu.css");
	</style>
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

<body>

	<div id='header'>Search Our Collection...</div>

	<div id='nav'>
		<ul>
			<li><a href="AdvQuery.php">Advanced search</a><li>
			<li><a href="DtlQuery.php">Detailed search</a></li>
			<li><a href="NarrativeQuery.php">Narrative search</a></li>
		</ul>
	</div>

	<p class='clearBoth'>
		<h2>
			Welcome to the Australian Museum's Collection, Live Search Page.
		</h2>
	</p>

	<div class='pageDescription'>
		<p>
		This page enables you to search for specimens in the Australian Museum.
		</p>
		<p>
		The collection includes more than 5,000,000 insects, 3,000,000
		molluscs, 1,000,000 fishes, 1,000,000 archaeological objects, 111,000
		anthropological objects and 70,000 rocks and minerals.
		Whilst not all specimens in the collection are available for public
		access (for various reasons including privacy, cultural
		reasons or due to issues with the  data) a very large number are.</p>
		<p>
		Enter terms to search for below, or click on of the quick
		search links to the right.
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
				$RandomQry->UpperIRN = 12920;
				$RandomQry->MaxNumberToReturn = 50;
				$RandomQry->PrintRef();
			?> ">

          	Random Items
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
		<!-- EMuWeb Basic Query Object -->
		<?php
			require_once('../../objects/am/QueryForms.php');
			$queryform = new AmBasicQueryForm;
			$queryform->formAttributes = "onsubmit='return validateInput()'";
			$queryform->Show();
		?>
		<!-- ------------------------- -->
	</div>

	</p>

	<br/>

	<br/>

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
