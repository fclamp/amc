<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>The Jim Moran Foundation - Search Archives</title></head>
<body bgcolor="#FFFFFF">

<table width = 100%>
	<tr><td width = "10%"></td>
	<td width = "90%" align = "left"><img border="0" src="images/JimMoranLogo.jpg" ><br><br></td>
	</tr>
</table>
<table>
	<tr>
	<td width = "10%" rowspan = "2"></td>
	<td width = "30%" rowspan = "2"><font face="Times New Roman"><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$ThemeLink = new PreConfiguredQueryLink;
$ThemeLink->QueryTerms= "ContactSheet.php";
$ThemeLink->LimitPerPage = 12;
$ThemeLink->ResultsListPage = "ContactSheet.php";
$ThemeLink->Where = "ThemeWebMetaData contains 'holy cross' ";
$ThemeLink->PrintRef();
?>
	"><img border = "0" src = "images/Theme.jpg" valign = "top" width = "172" height = "210"></a><br><br>
	</td>
	<td width = "10%">&nbsp;</td>
	<td align = "center" width = "50%"><font size = "4" color = "red">GIVING BACK TO<br>HOLY CROSS HOSPITAL
		<br>FORT LAUDERDALE, FLORIDA</font>
	</tr><tr><td>&nbsp;</td><td align = "Left" valign = "top">
		Jim Moran has a relationship with Holy Cross Hospital
		that has spanned more than 30 years, including a $1
		million donation in 1988 to establish the hospital's Cardiovascular 
		Intensive Care Unit and a $6 million challenge
		gift announced in 2000, the largest single gift the hospital
		has ever received from a living donor.  For items related
		to the Holy Cross relationship, click the image at the left.
	</td></tr>
	<tr><td>&nbsp;</td><td><a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$ThemeLink = new PreConfiguredQueryLink;
$ThemeLink->LimitPerPage = 12;
$ThemeLink->ResultsListPage = "ContactSheet.php";
$ThemeLink->Where = "ThemeWebMetaData contains 'holy cross' ";
$ThemeLink->PrintRef();
?>
		"><font size =-1 face="Times New Roman" >Click here</a> or the above image for <br>more  related items.</font>
		</td></tr>
	<tr><td>&nbsp;</td><td colspan = "3" ><br>
	<a href="http://www.jimmoranfoundation.org/">Welcome</a> to The Jim Moran Foundation Archives interactive search page.<br>
		To <a href="
<?php
require_once('../../objects/common/PreConfiguredQuery.php');
$ThemeLink = new PreConfiguredQueryLink;
$ThemeLink->LimitPerPage = 12;
$ThemeLink->ResultsListPage = "ContactSheet.php";  
$ThemeLink->Where = "ThemeWebMetaData contains 'holy cross' ";
$ThemeLink->PrintRef();
?>
		">browse</a><font color = "black" > the current theme, please click on the image above.<br>
		Key word searches on all available fields can be performed in the main search box below.<br>
		<a href="DtlQuery.php">Advanced searches</a> and searches on values in specific fields are 
		available on the link below.</td>
	</tr>
	<tr><td colspan = "4" align = "center"><br><br>
<?php
require_once('../../objects/jmfe/QueryForms.php');

$queryform = new jmfeBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->Title = "Enter search term(s)...";
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderSize = "2";
$queryform->BorderColor = '#000000';
$queryform->BodyColor = '#FFFFFF';
$queryform->Width = "500";
$queryform->$helplink = 0;
$queryform->Show();
?>
		<br><br></td>
	</tr>
	<tr><td align = "center" colspan = "4"><u><a href="DtlQuery.php">Advanced search</a></u></td>
	</tr>
	<td colspan = "4" align = "center">Please note: We constantly add new data and correct records.<br>If you 
			see an error, please <a href = "mailto:information@jimmoranfoundation.org" >email</a> The Foundation.
		</td>
	</tr>
</table>
<table>
	<tr><td width = "10%"></td><td align = "center"><font size=+1><br><br><b>THE JIM MORAN FOUNDATION ARCHIVES MISSION STATEMENT</b><br></font>
		Our primary mission is to preserve and share the story of Jim Moran, the organizations he created, his vision, his philosophies, 
		and his philanthropic contributions, through the identification, collection and cataloging of memorabilia and other property 
		(both physical and intellectual) of historical significance. Furthermore, we will create an environment that will provide for 
		the proper display and protection of items related to the lifetime achievements of this extraordinary man.<br><br>
		<td width= "10%"></td>
	</tr>
	<tr><td><br></td>
	</tr>
</table>

<table>
	
	<tr><td width = "10%"></td><td align = "center"><a href="http://www.jimmoranfoundation.org/">Return to Foundation Home Page</a><br><br><br><br>
		</td><td width = "10%"></td>
		
	</tr>	
	<tr><td width = "10%"></td><td><font size =-1>COPYRIGHT: Digital Millennium Copyright Act of 1998; Copyright Act of 1976; The Copyright Law 
		 of the United States is Title 17 of the United States Code.</font>
		</td><td width = "10%"></td>

</table>

</body>
</html>
	
