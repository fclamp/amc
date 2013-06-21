<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>JMFE Archives - Advanced Search</title>
</head>

<body bgcolor="#FFFFFF">
<a href="http://www.jimmoranfoundation.org/"><img border="0" src="images/JimMoranLogo.jpg" ></a>

<table border="0" width="100%" cellspacing="0" cellpadding="8">
  <tr>
    <tr width="45%"><font face="Times New Romans" color="black" size="4"><b>Advanced Search<br>
      </b></font><font color="black" size = "3" face="Times New Roman">Enter any terms in the
      boxes below and click on the "Search" button.<br>For other search types, select one of the options beneath the search
      box.<br><br></font></tr>

  </tr>
</table>
<div align="left">
<?php
require_once('../../objects/jmfe/QueryForms.php');
$queryform = new jmfeDetailedQueryForm;
$queryform->FontFace = 'Times New Romans';
$queryform->BodyTextColor = 'black';
$queryform->TitleTextColor = 'white';
$queryform->BorderColor = 'black';
$queryform->BodyColor = 'white';
$queryform->Show();
?>
</div>
<p align="left"><font color="#336699" face="Times New Romans"><a href="Query.php">Basic search</a> 
</font></p>

</body>

</html>
