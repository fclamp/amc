<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<!-- **************** Generate a useful title using PHP *************  -->
<title>
	<?php
		require_once('../../objects/dpiq/MapEnabledBaseDisplayObjects.php');
		$resultListTitle = new MapEnabledDisplayObjectTitle('Record Display');
		$resultListTitle->Show();
	?>
</title>
<!-- **************** end Generate a useful title using PHP *************  -->
<style>
	.linkLikeButton {
		border: none;
		cursor: pointer;
		cursor: hand;
		text-decoration: underline;
		color: #336699;
		background-color: transparent;
		font-family: Tahoma, Arial, sans-serif;
		font-size: smaller;
	}
</style>

</head>

<body bgcolor="#FFFFE8">
<img align=left border="0" src="images/column.jpg" width="84" height="120">
      <h3><font face="Tahoma" color="#336699">&nbsp;Our Collection...</font></h3>

<center>
<table width="80%" cellpadding="2" cellspacing="0" border="0">
<tr><td align="left">
<h3><br><font face="Tahoma" color="#336699"><b>QUEENSLAND PLANT DISEASE DATABASE</b></font></h3><br></td>


<!--  *********************** Display Object ********************************* -->
<?php
	require_once('../../objects/dpiq/DisplayObjects.php');
	$display = new DpiqStandardDisplay;
	$display->mapperUrl = '/cgi-bin/emu-webmap/emu-webmap.cgi';
	$display->mapperDataSource = 'DPIQ';
	$display->mapDisplay = 1;
	$display->FontFace = 'Tahoma';
	$display->FontSize = '2';
	$display->BodyTextColor = '#336699';
	$display->BorderColor = '#336699';
	$display->HeaderTextColor = '#FFFFFF';
	$display->BodyColor = '#FFFFE8';
	$display->HighlightColor = '#FFFFFF';
	$display->DisplayImage = 0;
	$display->Show();
?>
<!--  ******************* end Display Object ********************************* -->

</p>
<br>

<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1" face="Tahoma">Powered
      by: </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      � 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

</body>

</html>
