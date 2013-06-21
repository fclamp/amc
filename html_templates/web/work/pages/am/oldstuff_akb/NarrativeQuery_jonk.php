<html>

<head>
	<meta charset="ISO-8859-1" />
	<title>Australian Museum Collection Search...</title>
	<style type="text/css">
		@import url("./css/amemu.css");
	</style>

</head>

<body>

	<div id='header'>Search Our Collection...</div>

	<div id='nav'>
		<ul>
			<li><a href="Query.php">Object Search</a><li>
		</ul>
	</div>

	<p class='clearBoth'>
		<h2>
			Welcome to the Australian Museum's Collection, Live Search Page.
		</h2>
	</p>

	<div class='pageDescription'>
		<p>
		This page enables you to search for narratives in the Australian Museum.
		</p>
		<p>
		Narratives contain stories, information and explanatory details
		about specimens and areas of study the museum focuses on</p>
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
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Archaeology') " .
					"or (NarNarrative contains 'Archaeology') or " .
					"(NarTitle contains 'Archaeology') or (SummaryData contains 'Archaeology')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">

          	Archaeology Narratives</a>

			</li>
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
				"exists 
					(DesSubjects_tab where DesSubjects contains 'Art' or DesSubjects  contains 'Architecture' 
					or DesSubjects  contains 'Carved Tree') or
					(NarNarrative contains 'Art' or NarNarrative contains 'Architecture' or NarNarrative contains 'Carved Tree') or 
					(NarTitle contains 'Art' or NarTitle contains 'Architecture' or NarTitle contains 'Carved Tree') or 
					(SummaryData contains 'Art' or SummaryData contains 'Architecture' or SummaryData contains 'Carved Tree')";
								$MediaLink->ResultsListPage = "NarrativeResultsList.php";
								$MediaLink->PrintRef();
							?>">
				Art</a>
			</li>

			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists 
					(DesSubjects_tab where DesSubjects contains 'Body Accessories' or DesSubjects  contains 'Body Enhancement') or
					(NarNarrative contains 'Body Accessories' or NarNarrative contains 'Body Enhancement') or 
					(NarTitle contains 'Body Accessories' or NarTitle contains 'Body Enhancement') or 
					(SummaryData contains 'Body Accessories' or SummaryData contains 'Body Enhancement')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
			Body Accessories</a>
			</li>


			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Torres') 
					or (NarNarrative contains 'Torres') or 
					(NarTitle contains 'Torres') or (SummaryData contains 'Torres')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Torres Strait Islands</a>
			</li>
        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Aboriginal') 
					or (NarNarrative contains 'Aboriginal') or 
					(NarTitle contains 'Aboriginal') or (SummaryData contains 'Aboriginal')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Aboriginal Bark Paintings</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Malagan') 
					or (NarNarrative contains 'Malagan') or (NarTitle contains 'Malagan') or (SummaryData contains 'Malagan')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Malagan Masks</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Cook') 
					or (NarNarrative contains 'Cook') or (NarTitle contains 'Cook') or (SummaryData contains 'Cook')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Cook Collection</a>
			</li>


        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Transport') 
					or (NarNarrative contains 'Transport') or (NarTitle contains 'Transport') or 
					(SummaryData contains 'Transport')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Transport</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Toy') 
					or (NarNarrative contains 'Toy') or (NarTitle contains 'Toy') or 
					(SummaryData contains 'Toy')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Toy</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Tool') 
					or (NarNarrative contains 'Tool') or (NarTitle contains 'Tool') or 
					(SummaryData contains 'Tool')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Tool</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists 
					(DesSubjects_tab where DesSubjects contains 'Textile' or DesSubjects  contains 'Equipment') or
					(NarNarrative contains 'Textile' or NarNarrative contains 'Equipment') or 
					(NarTitle contains 'Textile' or NarTitle contains 'Equipment') or 
					(SummaryData contains 'Textile' or SummaryData contains 'Equipment')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Textile and Equipment</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists 
					(DesSubjects_tab where DesSubjects contains 'Sound' or DesSubjects  contains 'Music') or
					(NarNarrative contains 'Sound' or NarNarrative contains 'Music') or 
					(NarTitle contains 'Sound' or NarTitle contains 'Music') or 
					(SummaryData contains 'Sound' or SummaryData contains 'Music')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Sound and Music</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Raw Material') 
					or (NarNarrative contains 'Raw Material') or (NarTitle contains 'Raw Material') or 
					(SummaryData contains 'Raw Material')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Raw Material</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Pastime') 
					or (NarNarrative contains 'Pastime') or (NarTitle contains 'Pastime') or (SummaryData contains 'Pastime')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Leisure</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists 
					(DesSubjects_tab where DesSubjects contains 'Hunting' or DesSubjects  contains 'Fishing' 
					or DesSubjects  contains 'Weapon') or
					(NarNarrative contains 'Hunting' or NarNarrative contains 'Fishing' 
					or NarNarrative contains 'Weapon') or 
					(NarTitle contains 'Hunting' or NarTitle contains 'Fishing' or NarTitle contains 'Weapon') or 
					(SummaryData contains 'Hunting' or SummaryData contains 'Fishing' 
					or SummaryData contains 'Weapon')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Hunting</a>
			</li>


        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Household') 
					or (NarNarrative contains 'Household') or (NarTitle contains 'Household') or (SummaryData contains 'Household')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Household</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists (DesSubjects_tab where DesSubjects contains 'Container') 
					or (NarNarrative contains 'Container') or (NarTitle contains 'Container') or (SummaryData contains 'Container')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Container</a>
			</li>

        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists 
					(DesSubjects_tab where DesSubjects contains 'Communication' or DesSubjects  contains 'Currency' 
					or DesSubjects  contains 'Measurement') or
					(NarNarrative contains 'Communication' or NarNarrative contains 'Currency' 
					or NarNarrative contains 'Measurement') or 
					(NarTitle contains 'Communication' or NarTitle contains 'Currency' or NarTitle contains 'Measurement') or 
					(SummaryData contains 'Communication' or SummaryData contains 'Currency' 
					or SummaryData contains 'Measurement')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Communication and Exchange</a>
			</li>


        
			<li>
          		<a href="
			<?php require_once('../../objects/common/PreConfiguredQuery.php');
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->LimitPerPage = 20;
        			$MediaLink->Where = 
					"exists 
					(DesSubjects_tab where DesSubjects contains 'Clothing') or
					(NarNarrative contains 'Clothing') or 
					(NarTitle contains 'Clothing') or 
					(SummaryData contains 'Clothing')";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?>">
				Clothing</a>
			</li>

        
			<li>
          		<a href="

			<?php
				$MediaLink = new PreConfiguredQueryLink;
				$MediaLink->Where = "MulHasMultiMedia = 'y'";
				$MediaLink->ResultsListPage = "NarrativeResultsList.php";
				$MediaLink->PrintRef();
			?> ">

          	Narratives with Images
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
			$queryform = new AmNarrativeBasicQueryForm;
			$queryform->ResultsListPage = "NarrativeResultsList.php";
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
