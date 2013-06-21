<?php include "header-small-birds.html" ?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Search the NMNH Division of Birds Collections</title>
</head>

<body bgcolor="#AAC1C0">
<h4><font face="Tahoma" color="#013567" size="2"><b>Search results </b> in our prototype 
  display... <br>
  <font size="2">Click on "Detailed View" for detailed record information.<br>
  Over time more data and images will be made available.</font></font></h4>

<center>
<?php
require_once('../../../objects/nmnh/vz/ResultsLists.php');
if ($ALL_REQUEST['QueryName'] == 'BasicQuery')
{
        if ($ALL_REQUEST['QueryTerms'] != '')
                callobj($ALL_REQUEST['ImagesOnly']);
        else
                message();
}
elseif ($ALL_REQUEST['QueryName'] == 'DetailedQuery')
{
        $keys = array_keys($ALL_REQUEST);
        $terms = 0;
        $i=0;
        // first check to see if images checkbox is true
        if ($ALL_REQUEST['ImagesOnly'] == 'true')
        {
                         $terms = 1;
        }
        else // run through columns to check for values
        {
		foreach($keys as $key)
		{
			// if the element is a column name
			if (preg_match('/^col_/', $keys[$i]))
			{
				if ($ALL_REQUEST[$keys[$i]] != '')
				{
					$terms = 1;
				}
			}
			$i++;
		}
	}
        if ($terms)
                callobj($ALL_REQUEST['ImagesOnly']);
        else
                message();
}
elseif ($ALL_REQUEST['QueryName'] == 'AdvancedQuery')
{
        $keys = array_keys($ALL_REQUEST);
        $terms = 0;
        if ($ALL_REQUEST['AllWords'] != '')
                $terms = 1;
        elseif ($ALL_REQUEST['Phrase'] != '')
                $terms = 1;
        elseif ($ALL_REQUEST['AnyWords'] != '')
                $terms = 1;
        elseif ($ALL_REQUEST['WithoutWords'] != '')
                $terms = 1;
        elseif ($ALL_REQUEST['SoundsLikeWords'] != '')
                $terms = 1;
        elseif ($ALL_REQUEST['ImagesOnly'] == 'true')
                $terms = 1;

        if ($terms)
                callobj($ALL_REQUEST['ImagesOnly']);
        else
                message();
}
else
{
        callobj($ALL_REQUEST['ImagesOnly']);

}

function
callobj($ImagesOnly)
{
        $resultlist = new NmnhVzBirdsStandardResultsList;
        $resultlist->DisplayThumbnails = 0;
        $resultlist->DisplayPage = "DisplayBirds.php";
        $resultlist->ContactSheetPage = "ContactSheetBirds.php";
        $resultlist->BodyColor = '#FFF3DE';
        $resultlist->Width = '90%';
        $resultlist->HighlightColor = '#FFFFFF';
        $resultlist->HighlightTextColor = '#DDDDDD';
        $resultlist->FontFace = 'Arial';
        $resultlist->FontSize = '2';
        $resultlist->TextColor = '#013567';
        $resultlist->HeaderColor = '#013567';
        $resultlist->BorderColor = '#013567';
        $resultlist->HeaderTextColor = '#FFFFFF';
	$resultlist->websection = 'vzbirds';
	if ($ImagesOnly == "true")
        {
                if ($resultlist->Restriction != '')
                        $resultlist->Restriction .= " AND MulHasMultimediaInternet = \'y\'";
                else
                        $resultlist->Restriction = "MulHasMultimediaInternet = \'y\'";
        }
        $resultlist->Show();

}
function
message()
{
        //print '<align=left>';
        print '<a href="#" onclick="javascript:history.back()">';
        print '<font FACE="Tahoma" color="#013567" SIZE="4"><b>Please go back and enter a search term</b></font></a>';
}
?>
</center>
<blockquote>
	<p>
		<br>
		<font face="Tahoma" color="#0000FF">
			<a href="QueryBirds.php"><b>Basic Search</b></a>
		</font>
		<font color="#000000">
			&nbsp; |&nbsp;&nbsp;
		</font>
		<font face="Tahoma" color="#0000FF">
			<a href="DtlQueryBirds.php"><b>Detailed Search</b></a>
		</font>
	</p>
</blockquote>


<?php include "footerBirds.php" ?>



</body>

</html>

