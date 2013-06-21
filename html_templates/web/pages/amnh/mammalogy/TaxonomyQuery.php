<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" href="amnh.css">
<title>KE EMu Standard Taxonomy Search</title>
</head>

<body bgcolor="#F1EFE2">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" nowrap>
      <table>
      <tr> <td><img border="0" src="images/boxbox2.jpg" width="171"> </td> </tr>
      <tr> <td><img border="0" src="images/molossus1.jpeg" width="171"><!--height="242"--> </td> </tr>
      </table>
    </td>
    <td width="70%" valign="top"><font face="Arial" size=5 color=#660000><b>Search Taxonomy Database...</b></font>
      <p> <font color="#660000" size="2" face="Arial">Welcome our search page. </font></p>
	<p><font color="#660000" size="2" face="Arial">Popular searches are available in the Quick Browse section to the right.</font></p>
	    <p><font color="#660000" size="2" face="Arial">Key word searches can be performed in the main search box below.&nbsp;</font></p>

    </td>
    <td width="20%" valign="middle" bgcolor="#660000">
      <b>
        <font size="2" face="Arial" color="#FFFFFF">&nbsp;Quick Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#F1EFE2">
            <font face="Arial">

    <!-- ***************** PHP to make image request ************* -->        
              <a href="<?php 
          require_once('../../../objects/common/TaxonomyPreConfiguredQuery.php');
      $MediaLink = new TaxonomyPreConfiguredQueryLink;
      $MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
      $MediaLink->LimitPerPage = 20;
      $MediaLink->Where = "MulHasMultiMedia = 'y'AND EXISTS (SecDepartment_tab where SecDepartment = 'Mammalogy')";
      $MediaLink->Description = "Taxa with Images";
      $MediaLink->PrintRef();
      ?>">
    <!-- ***************** end PHP to make image request ************* -->        

              <img border="0" src="images/lion.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#F1EFE2" nowrap>
            <font color="#660000" face="Arial" size="2">Taxa with images</font>
          </td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#F1EFE2">
            <font face="Arial">

    <!-- ***************** PHP to make random search ************* -->        
              <a href="<?php 
      require_once('../../../objects/common/TaxonomyPreConfiguredQuery.php');
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
      $MediaLink->Where = "(irn = $irns) AND EXISTS (SecDepartment_tab where SecDepartment = 'Mammalogy')";
      $MediaLink->Description = "Random Taxa";
      $MediaLink->PrintRef();
          ?>">
    <!-- ***************** end PHP to make some random numbers ************* -->        

                <img border="0" src="images/leopard.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#F1EFE2" nowrap>
            <font face="Arial" color="#660000" size="2">Random taxa</font>
          </td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#F1EFE2">
            <font face="Arial">
  
    <!-- ***************** PHP to make interesting search ************* -->        
			<a href="<?php
		require_once('../../../objects/common/TaxonomyPreConfiguredQuery.php');
		$numDays = 7;
		$conJun = " OR ";
		$queryString = "";
		$field = "AdmDateModified=date'"; // so can change to other fields easier.
		$fEnd = "'";		// if field not date, should be empty string.
		for($i = 0; $i < $numDays; $i++)
		{
			$date=date('m/d/Y', strtotime('-' . $i . 'days'));
			if ($queryString == "")
				$queryString = $field . $date . $fEnd;
			else
				$queryString = $queryString . $conJun . $field . $date . $fEnd;
		}
		$queryString = "(" . $queryString . ") AND EXISTS(SecDepartment_tab where SecDepartment = 'Mammalogy')";
		$MediaLink = new TaxonomyPreConfiguredQueryLink;
		$MediaLink->Where = $queryString;
		$MediaLink->ResultsListPage = 'TaxonomyBrowserResultsList.php';
		$MediaLink->Description = "Taxa last $numDays day modifations";
		$MediaLink->PrintRef();
		?>">
    <!-- ***************** end PHP to make interesting search ************* -->        
                <img border="0" src="images/marten.jpg" width="63" height="64">
              </a>
            </font>
          </td>
          <td width="50%" bgcolor="#F1EFE2" nowrap>
            <font face="Arial" color="#660000" size="2">
              Taxa: <br> Last 7 day modifications
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
      require_once('../../../objects/amnh/mammalogy/AmnhTaxonomyQueryForms.php');

      $queryform = new AmnhTaxonomyBasicQueryForm;
      $queryform->ResultsListPage = "TaxonomyBrowserResultsList.php";
      $queryform->DisplayPage = "TaxonomyDisplayPage.php";
      $queryform->FontFace = 'Arial';
      $queryform->FontSize = '2';
      $queryform->TitleTextColor = '#FFFFFF';
      $queryform->Title = "Search For Taxa...";
      $queryform->BorderColor = '#660000';
      // $queryform->BodyColor = '#FFF3DE';
      $queryform->BodyColor = '#F1EFE2';
      $queryform->Language = '0';
      $queryform->Show();
?>
<!-- ************* End TaxonomyBasicQueryForm Object ********************* -->




  </center>
</div>
<p align="center">
  <font face="Arial">
  <u>
    <font color="#0000FF">
      <a href="TaxonomyAdvancedQuery.php">Advanced search</a>
    </font>
  </u>
    <font color="#660000"> 
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
      <font face="Arial">
        <font color="#660000" size="1">
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
        <font face="Arial">
          <a href="http://www.kesoftware.com/">
            <img alt="KE Software"
              src="images/companylogo.gif"
              border="0" align="absmiddle"
              width="60"
              height="50">
          </a>
          <font size="1" color="#660000">Copyright (c) 1998-2009 KE Software Pty Ltd
          </font>
        </font>
      </p>
    </td>
    <td width="10%"></td> 
  </tr>
</table>

</body>
</html>
