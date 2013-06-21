<?php include "header-small-mammals.html"?> <html>
<body>
	<h4>
		<font face="Tahoma" color="#013567" size="2">
			Search results in our prototype display...<br>
  			Click on "Detailed View" (under the image) for detailed record information or click on the image for a larger version.<br>
			Over time more data and images will be made available.<br>
		</font> 
	</h4>
	<center>
	<?php
		require_once('../../../objects/nmnh/vz/ResultsLists.php');

		if ($ALL_REQUEST['QueryName'] == 'MSW')
		{
			$where_request = array();
		
			if (isset($_REQUEST['Genus']))
			{
				array_push($where_request, "IdeFiledAsGenus = '" . $_REQUEST['Genus'] . "'");
			}
			if (isset($_REQUEST['Species']))
		        {
        		        array_push($where_request, "IdeFiledAsSpecies = '" . $_REQUEST['Species'] . "'");
        		}
        		if (isset($_REQUEST['Subspecies']))
        		{
                		array_push($where_request, "IdeFiledAsSubSpecies = '" . $_REQUEST['Subspecies'] . "'");
        		}

			if (count($where_request))
			{
				$resultlist = new NmnhVzMammalsContactSheet;
				$resultlist->DisplayPage = 'DisplayMammals.php';
				$resultlist->ResultsListPage = 'ResultsListMammals.php';
				$resultlist->BodyColor = '#FFF3DE';
				$resultlist->Width = '80%';
				$resultlist->HighlightTextColor = '#DDDDDD';
				$resultlist->FontFace = 'Arial';
				$resultlist->FontSize = '2';
				$resultlist->TextColor = '#013567';
				$resultlist->HeaderColor = '#013567';
				$resultlist->BorderColor = '#013567';
				$resultlist->HeaderTextColor = '#013567';
				$resultlist->Where = implode(" AND ", $where_request);
				$resultlist->Restriction = "CatDepartment = 'Vertebrate Zoology' AND CatDivision = 'Mammals'";
        			$resultlist->Show();
			}
        		else
			{
        		        message();
			}
		}
		else
		{
			$resultlist = new NmnhVzMammalsContactSheet;
			$resultlist->DisplayPage = 'DisplayMammals.php';
			$resultlist->ResultsListPage = 'ResultsListMammals.php';
			$resultlist->BodyColor = '#FFF3DE';
			$resultlist->Width = '80%';
			$resultlist->HighlightTextColor = '#DDDDDD';
			$resultlist->FontFace = 'Arial';
			$resultlist->FontSize = '2';
			$resultlist->TextColor = '#013567';
			$resultlist->HeaderColor = '#013567';
			$resultlist->BorderColor = '#013567';
			$resultlist->HeaderTextColor = '#013567';
			if ($ALL_REQUEST['ImagesOnly'] == "true")
        		{
                		if ($resultlist->Restriction != '')
                		        $resultlist->Restriction .= " AND MulHasMultimediaInternet = \'y\'";
                		else
                		        $resultlist->Restriction = "MulHasMultimediaInternet = \'y\'";
        		}
			$resultlist->Show();
		}

		function
		message()
		{
       			print '<a href="#" onclick="javascript:history.back()">';
        		print '<font FACE="Tahoma" color="#013567" SIZE="4"><b>Please go back and enter a search term</b></font></a>';
		}
	?> 
	</center>
	
	<p align="left">
		<?php include "footerMammals.php"?>
	</p>

</body>
</html>
