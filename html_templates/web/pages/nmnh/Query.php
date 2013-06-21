<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search the Natural History Collections</title>
</head>

<body bgcolor="#AAC1C0">


<table border="0" Summary="" width="545" cellspacing="0" cellpadding="0" bgcolor="ffffff">

        <tr>
	
<td WIDTH="160" rowspan="2" VALIGN="top" ALIGN="center" height="89">

&nbsp;&nbsp;<img BORDER="0" SRC="images/intra_si_rc_logo_sm2.gif" alt="" HSPACE="2" WIDTH="137" HEIGHT="93"></td>

<td WIDTH="268" VALIGN="top" ALIGN="left" BGCOLOR="#FFFFFF" HEIGHT="66">

<img border="0" src="images/master_rc_half_2_crop.gif" alt="" width="281" height="60"></td>
	
	</tr>
	
	<tr>
			
<td WIDTH="368" VALIGN="middle" ALIGN="left" BGCOLOR="#FFF3DE" HEIGHT="28">

 <b>

<font face="Arial" size="3">&nbsp;&nbsp;&nbsp;Search the Natural History Collections

</font></b></td>

	</tr>

	</table>

<br>
<table border="0" width="625" summar=""  cellspacing="3" cellpadding="2" height="0">
	<tr> 
	 <td colspan="2" valign=top rowspan="5"> 
	<img src="images/main_nmnh_mall.jpg" width="149" height="118" alt="" align="left" vspace="2" hspace="6" border="1"> 
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366"><b>Welcome 
	to the NMNH collections' live search page.</b> </font><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366">Key 
	word searches on all available fields can be performed in the main search 
	box below. One or more terms may be entered (e.g., Eunice Mexico). </font> 

	<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366"> 
	Advanced searches and searches on values in specific fields are available 
	via the links below the main search box. </font>

	<p> <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366"><i>Please 
	Note: </i> Please be patient while we add collections. Currently only 
	the Invertebrate Zoology (all invertebrates except insects and spiders) 
	collections are available via this interface. </font>
	<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366"> 
	We have electronic data for less than 10% of our collections and images 
	for even fewer. We constantly add new and correct records. If you see 
	errors please let us know.</font></p>
	<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366">By 
	accessing or using these data, you agree to the conditions as<br>
	outlined in the <a href="http://www.mnh.si.edu/rc/db/2data_access_policy.html">NMNH 
	Research &amp; Collections Data Access Policy</a>. </font></p>
      
<?php
require_once('../../objects/nmnh/QueryForms.php');

$queryform = new NmnhBasicQueryForm;
$queryform->ResultsListPage = 'ResultsList.php';
$queryform->Title = 'Enter search term(s)...';
$queryform->FontFace = 'Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#013567';
$queryform->BodyColor = '#FFF3DE';
$queryform->Show();
?><font color="#013567" size="2" face="Tahoma"> </font></p>
      <p><font face="Tahoma"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced 
        search</a></font></u> <font color="#336699"> | </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed 
        search</a></u></font></font></p>
    </td>
    <td width="128" valign="middle" bgcolor="#003366" align="center" height="32"> 
      <b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick Browse</font> 
      <br>
      </b> </td>
  </tr>
  <tr> 
    <td width="128" valign="middle" bgcolor="#FFF3DE" align="center" height="7"> 
      <div align="center"><font face="Tahoma"><a href="



<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->ResultsListPage = 'ContactSheet.php';
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  "><img src="images/heterocentrotus_mammillatus.jpg" width="65" height="66"><br>
        </a></font><font color="#336699" face="Tahoma" size="2">Items with images<br>
        </font></div>
    </td>
  </tr>
  <tr> 
    <td width="128" valign="middle" bgcolor="#FFF3DE" align="center" height="21"> 
      <div align="center"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');

$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 787000;
$RandomQry->MaxNumberToReturn = 20;
$RandomQry->ResultsListPage = "ResultsList.php";
$RandomQry->PrintRef();

?>"><img src="images/bollandia_antipathicola.jpg" width="65" height="68"></a><br>
        </font><font face="Tahoma" color="#336699" size="2">Random items</font><font face="Tahoma"><br>
        </font></div>
    </td>
  </tr>
  <tr> 
    <td width="128" valign="middle" bgcolor="#FFF3DE" align="center" height="102"> 
      <div align="center"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$holidayset = new PreConfiguredQueryLink;
//$holidayset->Where = "irn = 1000000 or irn = 1000004";
$holidayset->
Where = "
irn = 536025 or 
irn = 536030 or 
irn = 426041 or
irn = 543885 or
irn = 437625 or
irn = 414813 or 
irn = 435836 or
irn = 442270 or
irn = 446531 or
irn = 387538 or
irn = 452816 or
irn = 426876 or
irn = 578753 or
irn = 296359 or
irn = 1000000 or
irn = 1000004";

$holidayset->ResultsListPage = 'ResultsList.php';
$holidayset->PrintRef();
?>
          "><img src="images/cowr_sm_quick.jpg" width="65" height="68" border="2"></a><br>
        </font><font face="Tahoma" color="#336699" size="2">Holiday Card<br>
        Quick Browse<br>
        </font></div>
    </td>
  </tr>
  <tr> 
    <td width="128" valign="top" align="left" height="2">&nbsp;</td>
  </tr>
</table>

<br>
<BLOCKQUOTE>
<p> <font face="Tahoma"><u><font color="#0000FF"> </font></u></font></p>


</BLOCKQUOTE>





<? include "nmnh_mcs_footer.html" ?>



</body>

</html>
