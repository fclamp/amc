<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Search results</title>
</head>

<body bgcolor="#0080C0">
<img align=left border="0" src="images/Beryl4-small.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#FFFF99">&nbsp;Search results...</font></h3>
<?php
$Where = "";
if ($_REQUEST['preconf'] == "buildingwithimage")
{
	$Where = "MinGroup contains 'Building Stones' and MulHasMultiMedia contains 'Y'";
}
elseif ($_REQUEST['preconf'] == "kimberlites")
{
	$Where = "AdmWebMetadata contains '\"kimberlite record\"'";
}
elseif ($_REQUEST['preconf'] == "minondisplay")
{
	$Where = "MinGroup contains 'Minerals' AND ".
		"(LocCurrentLocationLevel8Local contains '\"On display\"')";
}
elseif ($_REQUEST['preconf'] == "carbonatites")
{
	require_once('../../../objects/lib/texquery.php');
	$qry = new Query();
	$qry->Select = array('irn_1');
	$qry->From = "etaxonomy";
	$qry->Where = "ClaPetRootName contains 'Carbonatite'";
	$qry->All = 1;
	$qry->Limit = 0;
	$results = $qry->Fetch();
	$Where = "MinGroup contains 'Petrology' AND (";
	foreach ($results as $result)
	{
		$Where .= "(MinIdentificationRef=" . $result->{irn_1};
		$Where .= ") OR ";
	}
	$Where = preg_replace("/ OR $/", "", $Where);
	$Where .= ")";
}
?>

<p>&nbsp;</p>

<center>
<?php
require_once('../../objects/nhm/MineralogyResultsLists.php');
$resultlist = new MineralogyStandardResultsList();
if ($Where != "")
	$resultlist->Where = $Where;
$resultlist->ContactSheetPage = "ContactSheet.php";
$resultlist->DisplayPage = "Display.php";
$resultlist->Intranet = 1;
$resultlist->BodyColor = '#FFFFCC';
$resultlist->Width = '80%';
$resultlist->HighlightColor = '#FFFFFF';
$resultlist->HighlightTextColor = '#DDDDDD';
$resultlist->FontFace = 'Tahoma';
$resultlist->FontSize = '2';
$resultlist->TextColor = '#003399';
$resultlist->HeaderColor = '#003399';
$resultlist->BorderColor = '#003399';
$resultlist->HeaderTextColor = '#FFFFFF';
if (isset($_REQUEST['preconf']))
{
	$resultlist->AdditionalTransferVariables = array('preconf'=>$_REQUEST['preconf']);
}
$resultlist->Show();

?>
</center>
<br><br>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#FFFFFF" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#FFFFFF">Copyright
      © 2000-2005 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>

