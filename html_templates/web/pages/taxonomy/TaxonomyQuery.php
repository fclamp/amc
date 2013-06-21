<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>KE EMu Standard Taxonomy Search</title>
</head>

<body bgcolor="#FFFFE8">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<td width="10%" nowrap>
			<p align="center"><font face="Tahoma"><img border="0" src="images/column.jpg" width="171" height="242"></font></td>	
		<td width="70%" valign="top"><font face="Tahoma" size="5" color="#336699"><b>Search
			Taxonomy Database...</b></font>
			<p><font color="#336699" size="2" face="Tahoma">Welcome to the KE Software live 
			Taxonomy search page. </font></p>
			<p><font color="#336699" size="2" face="Tahoma">Popular searches are
			available in the Quick Browse section to the right.</font></p>
			<p><font color="#336699" size="2" face="Tahoma">Key word searches can be
			performed in the main search box below.&nbsp;</font></p>
		</td>
		<td width="20%" valign="middle" bgcolor="#336699"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick
			Browse</font>
		</b>
			<table border="0" width="98%" cellspacing="1" cellpadding="5">
				<tr>
					<td width="50%" bgcolor="#FFFFE8">
						<font face="Tahoma">

	<!-- ***************** PHP to make image request ************* -->
							<a href="<?php 
          require_once('../../objects/common/TaxonomyPreConfiguredQuery.php');
	$MediaLink = new TaxonomyPreConfiguredQueryLink;
	$MediaLink->ResultsListPage = 'TaxonomyResultsList.php';
	$MediaLink->LimitPerPage = 20;
	$MediaLink->Where = "MulHasMultiMedia = 'y'";
	$MediaLink->Description = "Taxa with Images";
	$MediaLink->PrintRef();
?>">
	<!-- ***************** end PHP to make image request ************* -->

								<img border="0" src="images/disk.jpg" width="63" height="64"></a></font></td>
					<td width="50%" bgcolor="#FFFFE8" nowrap>
						<font color="#336699" face="Tahoma" size="2">Taxa with images</font>
					</td>
				</tr>
				<tr>
					<td width="50%" bgcolor="#FFFFE8">
						<font face="Tahoma">

	<!-- ***************** PHP to make random search ************* -->
							<a href="<?php
      require_once('../../objects/common/TaxonomyPreConfiguredQuery.php');
	$MediaLink = new TaxonomyPreConfiguredQueryLink;
	$MediaLink->ResultsListPage = 'TaxonomyResultsList.php';
	$MediaLink->LimitPerPage = 20;
	$irn = array();
	// some dicky stuff to make a range of irns
	for ($i=1; $i < 5; $i++)
	{
		$irn[] = rand(2,2000);
	}
	for ($i=1; $i < 5; $i++)
	{
		$irn[] = rand(2000,10000);
	}
	for ($i=1; $i < 5; $i++)
	{
		$irn[] = rand(10000,200000);
	}
	while (count($irn) < 20)
	{
		$irn[] = rand();
	}
	$irns = implode($irn,' or irn = ');
	$MediaLink->Where = "irn = $irns";
	$MediaLink->Description = "Random Taxa";
	$MediaLink->PrintRef();
?>">
	<!-- ***************** end PHP to make some random numbers ************* -->

								<img border="0" src="images/face.jpg" width="62" height="65"></a></font></td>
					<td width="50%" bgcolor="#FFFFE8" nowrap>
						<font face="Tahoma" color="#336699" size="2">Random taxa</font>
					</td>
				</tr>
				<tr>
					<td width="50%" bgcolor="#FFFFE8">
						<font face="Tahoma">

	<!-- ***************** PHP to make interesting search ************* -->
							<a href="<?php
require_once('../../objects/common/TaxonomyPreConfiguredQuery.php');
	$MediaLink = new TaxonomyPreConfiguredQueryLink;
	$MediaLink->Where  = <<< SQL
	(ClaGenus = 'Architeuthis') OR
	(ClaGenus = 'Bathyteuthis') OR
	(ClaGenus = 'Acacia' AND ClaSpecies = 'longifolia' )
SQL;
	$MediaLink->ResultsListPage = 'TaxonomyResultsList.php';
	$MediaLink->Description = "Taxonomy Recent Additions";
	$MediaLink->PrintRef();
	?>">
	<!-- ***************** end PHP to make interesting search ************* -->
								<img border="0" src="images/world.jpg" width="64" height="63"></a></font></td>
					<td width="50%" bgcolor="#FFFFE8" nowrap>
						<font face="Tahoma" color="#336699" size="2">
							Interesting Distributions
						</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<div align="center">
	<center>

<!-- ************* Start TaxonomyBasicQueryForm Object ********************* -->
<?php
      require_once('../../objects/taxonomy/TaxonomyQueryForms.php');

	$queryform = new TaxonomyBasicQueryForm;
	$queryform->ResultsListPage = "TaxonomyResultsList.php";
	$queryform->DisplayPage = "TaxonomyDisplay.php";
	$queryform->FontFace = 'Tahoma, Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->BodyTextColor = '#336699';
	$queryform->Title = "Search For Taxon...";
	$queryform->BorderColor = '#336699';
	// $queryform->BodyColor = '#FFF3DE';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Language = '0';
	$queryform->Show();
?>
<!-- ************* End TaxonomyBasicQueryForm Object ********************* -->

	</center>
</div>

<p align="center"><u><a href="TaxonomyAdvQuery.php"><font face="Tahoma">Advanced search</font></a></u> <font color="#336699" face="Tahoma"> |
</font><u><a href="TaxonomyDtlQuery.php"><font face="Tahoma">Detailed search</font></a></u></p>

<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
	<tr>
		<td width="10%" align="center"></td>
		<td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
		<td width="40%" valign="middle">
			<p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2007 KE Software.&nbsp;</font></font></td>
		<td width="10%"></td>
	</tr>
</table>

</body>

</html>
