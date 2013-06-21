<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link REL="stylesheet" TYPE="text/css" href="amnh.css">
<title>KE EMu Advanced Taxonomy Search</title>
</head>

<body bgcolor="#F1EFE2">
<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <td width="10%" nowrap>
      <p align="center"><img border="0" src="images/molossus1.jpeg" width="84"><!-- height="123"-->
    </td>
    <td width="45%"><font face="Arial" color="#660000" size="4"><b>&nbsp;Advanced Taxonomy Search<br>
      </b></font><font color="#660000" face="Arial">Enter any terms in the boxes below, select an area to search, then click the "Search" button.&nbsp;</font> </td>
    <td width="45%">
      <p align="right">
      	 <img border="0" src="images/boxbox2.jpg" width="100">
    </td>
  </tr>
</table>


<br>
<div align="center">
  <center>



<!-- ************* Start TaxonomyAdvancedQueryForm Object ********************* -->
<?php
	require_once('../../../objects/amnh/mammalogy/AmnhTaxonomyQueryForms.php');

	$queryform = new AmnhTaxonomyAdvancedQueryForm;

	$queryform->showSummary = 0;
	$queryform->ResultsListPage = "TaxonomyBrowserResultsList.php";
	$queryform->DisplayPage = "TaxonomyDisplayPage.php";
	$queryform->FontFace = 'Arial';
	$queryform->FontSize = '2';
	$queryform->TitleTextColor = '#FFFFFF';
	$queryform->Title = "Search For Taxa...";
	$queryform->BorderColor = '#660000';
	$queryform->BodyColor = '#F1EFE2';
	$queryform->Language = '0';
	$queryform->Show();
?>
<!-- ************* End TaxonomyAdvancedQueryForm Object ********************* -->




  </center>
</div>
<p align="center"><font face="Arial">
	<u>
		<font color="#0000FF">
			<a href="TaxonomyQuery.php">Basic search</a>
		</font>
	</u>
	<font color="#660000"> | </font>
	<font color="#0000FF">
	<u>
		<a href="TaxonomyDetailedQuery.php">Detailed search</a>
	</u>
	</font></font></p>
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
          <font size="1" color="#660000">
            Copyright (c) 1998-2009 KE Software Pty Ltd
          </font>
        </font>
      </p>
    </td>
    <td width="10%"></td> 
  </tr>
</table>

</body>
</html>

