<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>KE EMu Advanced Taxonomy Search</title>
</head>

<body bgcolor="#ffffe8" text='336699'>


<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <p align="center">
        <font face="Tahoma">
          <img border="0" src="images/column.jpg" width="171" height="242" />
        </font>
    </td>
    <td width="70%" valign="top">
      <p>
      <blockquote><font face="Tahoma">Welcome to our Collection's Advanced Live Taxonomy search page. </font></p>
	<p><font face="Tahoma">Popular searches are available in the Quick Browse section to the right.</font></p>
	    <p><font face="Tahoma">Key word searches can be performed in the main search box below.&nbsp;</font></blockquotep>

      </p>
    </td>
    <td width="20%" valign="middle" bgcolor="#336699">
      <b>
        <font size="2" face="Tahoma" color="#FFFFE8">&nbsp;Quick Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#FFFFE8">
            <font face="Tahoma">

              <a href="<?php 
          require_once('../../objects/common/TaxonomyPreConfiguredQuery.php');
      $MediaLink = new TaxonomyPreConfiguredQueryLink;
      $MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
      $MediaLink->LimitPerPage = 20;
      $MediaLink->Where = "MulHasMultiMedia = 'y'";
      $MediaLink->Description = "Taxa with Images";
      $MediaLink->PrintRef();
      ?>">

		<img border="0" src="images/face.jpg" width="63" height="64">
              </a>
            </font>
          </td>
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
      $MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
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
      $MediaLink->Where = 
      "irn = $irns";
      $MediaLink->Description = "Random Taxa";
      $MediaLink->PrintRef();
          ?>">
    <!-- ***************** end PHP to make some random numbers ************* -->        

		<img border="0" src="images/disk.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#FFFFE8" nowrap>
            <font face="Tahoma" color="#336699" size="2">Random taxa</font>
          </td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8">
            <font face="Tahoma">
	<!--***************** PHP to make interesting search ************* -->
			<a href="<?php
		require_once('../../objects/common/TaxonomyPreConfiguredQuery.php');
		$MediaLink = new TaxonomyPreConfiguredQueryLink;
		$MediaLink->Where  = <<< SQL
			(ClaGenus = 'Athrotaxis' AND ClaSpecies = 'cupressoides' ) OR
			(ClaGenus = 'Usnea' AND ClaSpecies = 'amblyoclada' ) OR
			(ClaGenus = 'Calycularia' AND ClaSpecies = 'crispula' ) OR
			( ClaGenus = 'Acacia' AND ClaSpecies = 'longifolia' )
SQL;
		$MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
		$MediaLink->Description = "Taxonomy Intersting Distributions";
		$MediaLink->PrintRef();
		?>">
	<!-- ***************** end PHP to make interesting search ************* -->
		<img border="0" src="images/world.jpg" width="63" height="64">
              </a>
            </font>
          </td>
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

<br />
<div align="center">
  <center>



<!-- ************* Start TaxonomyAdvancedQueryForm Object ********************* -->
<?php
	require_once('../../objects/common/TaxonomyQueryForms.php');

	$queryform = new TaxonomyAdvancedQueryForm;

	$queryform->showSummary = 0;
	$queryform->ResultsListPage = "TaxonomyBrowserResultsList.php";
	$queryform->DisplayPage = "TaxonomyDisplayPage.php";
	$queryform->FontFace = 'Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFE8';
	$queryform->Title = "Search For Taxon...";
	$queryform->BorderColor = '#336699';
	$queryform->BodyColor = '#FFFFE8';
	$queryform->Language = '0';
	$queryform->Show();
?>
<!-- ************* End TaxonomyAdvancedQueryForm Object ********************* -->




  </center>
</div>
<p align="center"><font face="Tahoma">
	<u>
		<font color="#0000FF">
			<a href="TaxonomyQuery.php">Basic search</a>
		</font>
	</u>
	<font color="#336699"> | </font>
	<font color="#0000FF">
	<u>
		<a href="TaxonomyDetailedQuery.php">Detailed search</a>
	</u>
	</font></font></p>

</body>

<!--*
    *
    * $Revision: 1.2 $
    * $Date: 2004/06/10 04:03:26 $
    *
    *-->

</html>

