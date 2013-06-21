<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>KE EMu Standard Taxonomy Search</title>
</head>

<body background="images/nybgbackground.jpg" bgcolor="#ffffff">
<div align="center"><img border="0" src="images/nybglogo.gif" width="499" height="30"></div>



<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <p align="center">
        <font face="Tahoma">
          <img border="0" src="images/nybg.jpg" width="387" height="276" />
        </font>
    </td>
    <td width="70%" valign="top"><font face="Tahoma"><b>Search Taxonomy Database...</b></font>
      <p>
      <blockquote><font face="Tahoma">Welcome to the New York Botanical Gardens live Taxonomy search page. </font></p>
	<p><font face="Tahoma">Popular searches are available in the Quick Browse section to the right.</font></p>
	    <p><font face="Tahoma">Key word searches can be performed in the main search box below.&nbsp;</font></blockquotep>

    </td>
    <td width="20%" valign="middle" bgcolor="#006400">
      <b>
        <font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#FFFFE8">
            <font face="Tahoma">

    <!-- ***************** PHP to make image request ************* -->        
              <a href="<?php 
          require_once('../../objects/common/TaxonomyPreConfiguredQuery.php');
      $MediaLink = new TaxonomyPreConfiguredQueryLink;
      $MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
      $MediaLink->LimitPerPage = 20;
      $MediaLink->Where = "MulHasMultiMedia = 'y'";
      $MediaLink->Description = "Taxa with Images";
      $MediaLink->PrintRef();
      ?>">
    <!-- ***************** end PHP to make image request ************* -->        

              <img border="0" src="images/nybgweb1.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#FFFFE8" nowrap>
            <font color="#006400" face="Tahoma" size="2">Taxa with images</font>
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
      $MediaLink->Where = "irn = $irns";
      $MediaLink->Description = "Random Taxa";
      $MediaLink->PrintRef();
          ?>">
    <!-- ***************** end PHP to make some random numbers ************* -->        

                <img border="0" src="images/nybgweb2.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#FFFFE8" nowrap>
            <font face="Tahoma" color="#006400" size="2">Random taxa</font>
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
       	(ClaGenus = 'Athrotaxis' AND ClaSpecies = 'cupressoides' ) OR
	(ClaGenus = 'Usnea' AND ClaSpecies = 'amblyoclada' ) OR
	(ClaGenus = 'Calycularia' AND ClaSpecies = 'crispula' ) OR
	(ClaGenus = 'Acacia' AND ClaSpecies = 'longifolia' )
SQL;
      $MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
      $MediaLink->Description = "Taxonomy Recent Additions";
      $MediaLink->PrintRef();
      ?>">
    <!-- ***************** end PHP to make interesting search ************* -->        
                <img border="0" src="images/nybgweb3.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#FFFFE8" nowrap>
            <font face="Tahoma" color="#006400" size="2">
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
      require_once('../../objects/common/TaxonomyQueryForms.php');

      $queryform = new TaxonomyBasicQueryForm;
      $queryform->ResultsListPage = "TaxonomyBrowserResultsList.php";
      $queryform->DisplayPage = "TaxonomyDisplayPage.php";
      $queryform->FontFace = 'Arial';
      $queryform->FontSize = '2';
      $queryform->TitleTextColor = '#FFFFFF';
      $queryform->Title = "Search For Taxon...";
      $queryform->BorderColor = '#006400';
      // $queryform->BodyColor = '#FFF3DE';
      $queryform->BodyColor = '#FFFFE8';
      $queryform->Language = '0';
      $queryform->Show();
?>
<!-- ************* End TaxonomyBasicQueryForm Object ********************* -->




  </center>
</div>
<p align="center">
  <font face="Tahoma">
  <u>
    <font color="#0000FF">
      <a href="TaxonomyAdvancedQuery.php">Advanced search</a>
    </font>
  </u>
    <font color="#006400"> 
      | 
    </font>
    <font color="#0000FF">
      <u>
        <a href="TaxonomyDetailedQuery.php">Detailed search</a>
      </u>
    </font>
  </font>
</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center">
      <font face="Tahoma">
        <font color="#006400" size="1">
          Powered by:&nbsp;
        </font>
        <font size="2">&nbsp; 
        </font>
        <img border="0" src="images/productlogo.gif"
          align="absmiddle" width="134" height="48">
      </font>
    </td> 
    <td width="40%" valign="middle">
      <p align="center">
        <font face="Tahoma">
          <a href="http://www.kesoftware.com/">
            <img alt="KE Software"
              src="images/companylogo.gif"
              border="0" align="absmiddle"
              width="60"
              height="50">
          </a>
          <font size="1" color="#006400">
            Copyright (c) 1998-2009 KE Software Pty Ltd
          </font>
        </font>
      </p>
    </td>
    <td width="10%"></td> 
  </tr>
</table>

</body>

<!--*
    *
    * $Revision: 1.2 $
    * $Date: 2009/01/28 22:04:03 $
    *
    *-->

</html>
