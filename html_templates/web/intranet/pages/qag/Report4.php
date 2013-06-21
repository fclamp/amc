<?php
require_once('../../objects/qag/QagSessions.php');
$sess = new QagSession;
$SessionsWorking = $sess->GetVar("SessionsOn");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<link rel="stylesheet" type="text/css" href="Query.css">
	<title>QAG Search Results</title>
</head>

<body>

	<?php
		require_once('../../objects/qag/ResultsLists.php');
		$resultlist = new QagReport4ResultsList;
		$resultlist->Intranet = 1; 
		$resultlist->FontFace = 'Tahoma';
		$resultlist->FontSize = '2';
		$resultlist->Show();
		if ($SessionsWorking)
		{
			$IrnList = $sess->GetVar("IrnList");
			$RList = $sess->GetVar("RList");
		}
?>

</body>

</html>
