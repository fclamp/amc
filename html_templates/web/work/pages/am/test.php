<html>
	<head>
		<title>Simple Example</title>
	</head>
	<body>
		<h1>Simple Test Example</h1>
		<div>
			<p>
				A simple example demonstrating using the EMuWeb
				PHP5 Query and Media classes
			</p>
			<p>
				Example of a Static Image
				<img src=
				  "../../php5/media.php?irn=1043&image=yes&height=300&width=300"/>
			</p>
		</div>

		<div>
			<hr/>
			<form method='get' action="./test.php">
				<i>enter a term to search for...</i>
				<br/>
				Search for: <input type='text' name='input'/>
				<input type='submit' value='Search' />
			</form>	
			<hr/>
		</div>

		<div>
			<p>
				<?php
				/****** Use Query and Media Object to display Matches ******/

				require_once(dirname(realpath(__FILE__)) . "/../../php5/query.php");
				if (isset($_REQUEST['input']))
				{

					$search = $_REQUEST['input'];
					print "\n<h1>you want <i>$search</i> ??</h1>\n";


					// make and configure query object
					$query = new Query();
					$query->Select("SummaryData");
					$query->Select("MulMultiMediaRef_tab");
					$query->Table = "ecatalogue";
					$query->Where = "SummaryData CONTAINS '$search'";

					
					// run query
					$results = $query->Fetch();


					print "<h4>query status: <i>" .
							$query->Status .
						"!</i></h4>\n";

					$count = $query->Matches;


					// process results
					if ($count > 0)
					{
						print "<h2>I know of $count record(s) about $search !!</h2>\n";

						print "<ul>\n";

						// iterate over results
						for ( $i=0; $i < $count; $i++)
						{

							$image = "no picture - sorry";
							if (count($results[$i]->MulMultiMediaRef_tab) > 0)
							{
								// have image(s) - display the first one
								$image = "<img src='../../php5/media.php?irn=" .
									$imageIrn = $results[$i]->MulMultiMediaRef_tab[0] .
									"&image=yes&height=300&width=300' />";	
							}

							// display record and image...
							print   "\t<li>\n" .
									"\t\t" . $results[$i]->SummaryData . "\n" .
									"\t\t$image\n" .
								"\t</li>\n";
						}

						print "</ul>\n";
					}
					else
					{
						print "<h2>Nope - sorry I don't know about $search - try something else...</h2>\n";
					}
				}
				/***********************************************************/
				?>

			</p>
		</div>

	</body>
</html>
