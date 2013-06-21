<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Association Browse...</title>
</head>
<Table width = 65%>
<TR>
<TD> Instructions on how to use this perhaps here </TD>
<TD align="left">
<body bgcolor="#E0F5DF">
<div align="left">
<H3>Association Title here</H3>
<BR>
<?php
require_once('../../objects/common/Explorer.php');

$assocExplorer = new Explorer;
$assocExplorer->FontFace = 'Tahoma';
$assocExplorer->TextColor = '#013567';
$assocExplorer->FontSize = '2';
$assocExplorer->LookupListName = 'Association Names';
$assocExplorer->Field = "AssAssociationNameRef_tab->eparties->SummaryData";
$assocExplorer->Show();



?>
</div>
</TD>
</TR>
</TABLE>
<br>
<br>
<center>
<a href="SimpleQuery.php">
<img src="images/search.gif">
</a>
<a href="DtlQuery.php">
<img src="images/research.gif">
</a>
</center>


</body>

</html>
