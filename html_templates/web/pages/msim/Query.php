<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection...</title>
</head>

<body bgcolor="#E0F5DF">
<center><img src="images/title_welcome.gif"></center>
<br>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
      <td width="70%"  valign="top">
      <p><font color="#013567" size="4" face="Tahoma">Welcome to our
      collection's live search page.&nbsp; Here you can find out everything you want to
      know our collection and its contents.</font></p>
      <p><font color="#013567" size="4" face="Tahoma">Popular searches are
      available in the Quick Browse section to the right.</font></p>
      <p><font color="#013567" size="4" face="Tahoma">Key word searches can be
      performed by clicking on one of the searches below.&nbsp;</font></p>

<br>
<br>
<p><center><font face="Tahoma"><font color="#0000FF"><a href="SimpleQuery.php"><img src="images/search.gif">
</a></font><font color="#336699">
   </font><font color="#0000FF"><a href="DtlQuery.php"><img src="images/research.gif"></a></font>
   </p></center>
   
    </td>
    <td width="20%" valign="middle" bgcolor="#013567"><b><font size="2" face="Tahoma" color="#DFF5E0">&nbsp;Quick
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/disk.jpg" width="63" height="64"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font color="#336699" face="Tahoma" size="2">Items
            with images</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 9000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/face.jpg" width="62" height="65"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font face="Tahoma" color="#336699" size="2">Random
            pieces</font></td>
        </tr>
     	<tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="time.php">
	  <img border="0" src="images/timer.jpg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font face="Tahoma" color="#336699" size="2">Timeline</font></td>
        <tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="Associations.php">
	  <img border="0" src="images/timer.jpg" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font face="Tahoma" color="#336699" size="2">Association Index</font></td>
	   <tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="subject/SubjectQuery.php">
	  <img border="0" src="images/plane.gif" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font face="Tahoma" color="#336699" size="2">Subject Browse</font></td>

	  	   <tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="museum_loc/MuseumQuery.php">
	  <img border="0" src="images/MsimLogo.gif" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font face="Tahoma" color="#336699" size="2">Museum Locations</font></td>


	   <tr>
          <td width="50%" bgcolor="#DFF5E0"><font face="Tahoma"><a href="GeoLoc.php">
	  <img border="0" src="images/UK.gif" width="64" height="63"></a></font></td>
          <td width="50%" bgcolor="#DFF5E0" nowrap><font face="Tahoma" color="#336699" size="2">Geographic Location</font></td>


    </table>
    </td>
  </tr>
</table>

</body>

</html>
