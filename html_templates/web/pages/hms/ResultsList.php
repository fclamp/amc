<?php include("includes/header.inc"); ?>

<html>


<body bgcolor="#FFFFFF">
<img align=left border="0" src="images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#336699">&nbsp;Search results...</font></h3>

<center>
<?php
$preconf = $_REQUEST['preconf'];

require_once('../../objects/hms/ResultsLists.php');
error_reporting(E_ALL ^ E_NOTICE);

$resultlist = new HMSStandardResultsList;
$resultlist->BodyColor = '#F2F2F2';
$resultlist->Width = '80%';
$resultlist->HighlightColor = '#FFFFFF';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#336699';
$resultlist->HeaderColor = '#336699';
$resultlist->BorderColor = '#336699';
$resultlist->HeaderTextColor = '#F2F2F2';
if (!empty($Where))
{
//	$resultlist->Where = $Where;
}
if ($preconf == "Egyptian")
{
	$qry = new Query();
	$qry->From = 'elocations';
	$qry->Select = array('irn_1', 'SummaryData');
	$qry->Where = "SummaryData contains 'Hands on History - Egyptian Gallery'";
	$records = $qry->Fetch();
	$resultlist->Where = "LocCurrentLocationRef = " . $records[1]->{irn_1};
	for ($i=1; $i < count($records); $i++)
	{
		$resultlist->Where .= "OR (LocCurrentLocationRef = " . $records[$i]->{irn_1} . ")";
	}
}
if ($preconf == "Scrimshaw")
{
	$resultlist->Where = "TitObjectName contains 'scrimshaw'";
}
if ($preconf == "Guildhall")
{
	$resultlist->Where = "LocMuseum contains 'Guildhall'";
}
if ($preconf == "JohnWard")
{
	$resultlist->Where = "SummaryData contains 'John') and (SummaryData contains 'Ward'";
}	


$resultlist->Show();
?>
</center>
<br><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>

