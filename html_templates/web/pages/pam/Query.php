<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Search Our Collection...</title>
</head>

<SCRIPT LANGUAGE="JavaScript">
<!--
var numImages
var dimages
var target
var widthfactor

widthfactor = 325 * (screen.width / 1280)
dimages = new Array()

numImages = 10
var curImage

curImage = 0

function setimagedim(i) {
	i++
	if (i >= numImages)
		i = 0

	w = dimages[i].width
	h = dimages[i].height

	if (document.images.myimg && document.images.myimg.style && document.images.myimg.style.filters)
	{
		canBeFiltered = true;
		target = document.images.myimg;
	}
	if (document.getElementById("myimg"))
	{
		target = document.getElementById("myimg");
		canBeFiltered = true;
	}
}

function preload()
{
	for (i = 0; i < numImages; i++)
	{
		dimages[i] 	= new Image()
		dimages[i].src 	= "images/image" + (i + 1) + ".jpg"
	}
}

function transformPicture(filterFunction)
{
	if (document.images)
	{
		curImage++;
	    	if (curImage >= numImages)
			curImage=0;

		if (filterFunction == null)
			filterFunction="blendTrans(duration=2.0)"

//		target = document.getElementById("myimg")
//		target.style.filter = "blendTrans(duration=2)"
//		if (target.filters.blendTrans.status != 2)
//		{
//			target.filters.blendTrans.apply()
//			target.style.visibility = "hidden"
//			target.filters.blendTrans.play()
//		}
//		target.src = dimages[curImage].src
//		target.style.visibility = "visible"
//		setTimeout("transformPicture()", 10000)
//		dimages[i].src 	= "images////image" + (i + 1) + ".jpg"
//		alert(target)
//		return

		var canBeFiltered=false;
		if (document.images.myimg && document.images.myimg.style && document.images.myimg.style.filters)
		{
			canBeFiltered=true;
			target=document.images.myimg;
		}
		if (document.getElementById("myimg"))
		{
			target= document.getElementById("myimg");
			canBeFiltered=true;
		}

		if (dimages[curImage].complete)
		{
			// SET, APPLY, PLAY FILTER
			if (canBeFiltered)
			{
				target.style.filter = filterFunction;
				if (target.filters && target.filters[0])
				{
					target.filters[0].Apply();
					target.filters[0].Play();
				}
			} 
			// SWAP IMAGE
			document.images.myimg.src = dimages[curImage].src;
		}
	}
	setTimeout("transformPicture()", 10000)
}
//
-->
</SCRIPT>

<body bgcolor="#FFFFE8">

<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%" height=700 valign=top align=left nowrap rowspan=2>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		document.write("<p align=\"center\"><font face=\"Tahoma\"><img id=\"myimg\" name=\"myimg\" border=\"0\" src=\"images/image1.jpg\" width=\"" + widthfactor + "\" ></font></td>")
	-->
	</SCRIPT>
    <td width="70%" valign="top">
    <font face="Tahoma" size="5" color="#336699"><b><center>Search Our Collection...</center></b></font>
      <p><font color="#336699" size="2" face="Tahoma"><blockquote>Welcome to the Art Centre's Performing Arts Collection live search page.<p>
Popular searches are available in the Quick Browse section to the right.<p>
Key word searches can be performed in the main search box below.</blockquote>
      </font></p>
      </td>
      <!-- Was here -->
    <td rowspan=2 width="20%" valign="top" bgcolor="#336699"><b><font size="2" face="Tahoma" color="#FFFFFF">&nbsp;Quick
      Browse</font>
      </b>
      <table border="0" width="98%" cellspacing="1" cellpadding="5">
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="<?php
require_once('../../objects/common/PreConfiguredQuery.php');

$MediaLink = new PreConfiguredQueryLink;
$MediaLink->LimitPerPage = 20;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>">
	  <img border="0" src="images/itemswithimages.jpg" width="120"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" align=center nowrap><font color="#336699" face="Tahoma" size="2">Items<br>
            with<br>images</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
require_once('../../objects/common/RandomQuery.php');
$RandomQry = new RandomQuery;
$RandomQry->LowerIRN = 1;
$RandomQry->UpperIRN = 12000;
$RandomQry->MaxNumberToReturn = 50;
$RandomQry->PrintRef();
?>
	  ">
	  <img border="0" src="images/randompieces.jpg" width="120"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" align=center nowrap><font face="Tahoma" color="#336699" size="2">Random<br>
            pieces</font></td>
        </tr>
        <tr>
          <td width="50%" bgcolor="#FFFFE8"><font face="Tahoma"><a href="
<?php
$MediaLink = new PreConfiguredQueryLink;
$MediaLink->Where = "MulHasMultiMedia = 'y'";
$MediaLink->PrintRef();
?>
	  ">
	  <img border="0" src="images/newrecords.jpg" width="120"></a></font></td>
          <td width="50%" bgcolor="#FFFFE8" nowrap align=center><font face="Tahoma" color="#336699" size="2">Recent<br>
            acquisitions</font></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
<td height=100% width=100% valign=bottom>
<div valign=bottom align=right>
<?php
require_once('../../objects/lib/common.php');
$LangSelector = new LanguageSelector;
$LangSelector->FontFace = 'Tahoma, Arial';
$LangSelector->FontSize = '2';
$LangSelector->FontColor = '#336699';
$LangSelector->Show();
?>
</div>
<div align="center">
  <center>
<!-- HERE -->
<?php
require_once('../../objects/pam/QueryForms.php');

$queryform = new GalleryBasicQueryForm;
$queryform->FontFace = 'Tahoma, Arial';
$queryform->FontSize = '2';
$queryform->TitleTextColor = '#FFFFFF';
$queryform->BorderColor = '#336699';
$queryform->BodyColor = '#ffffe8';
$queryform->HelpPage = '/emuwebpam/pages/examples/shared/help/GalleryBasicQueryHelp.php';
$queryform->Show();
?>
  </center>
</div>
<p align="center"><font face="Tahoma"><u><font color="#0000FF"><a href="AdvQuery.php">Advanced
search</a></font></u><font color="#336699">
| </font><font color="#0000FF"><u><a href="DtlQuery.php">Detailed search</a></u></font></font></p>
    </td>
</table>

<p align="center">&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="4">
  <tr>
    <td width="10%" align="center"></td>
    <td width="40%" valign="middle" align="center"><font face="Tahoma"><font color="#336699" size="1">Powered
      by:&nbsp;</font><font size="2">&nbsp; </font><img border="0" src="images/productlogo.gif" align="absmiddle" width="134" height="48"></font></td>
    <td width="40%" valign="middle">
      <p align="center"><font face="Tahoma"><a href="http://www.kesoftware.com/"><img alt="KE Software" src="images/companylogo.gif" border="0" align="absmiddle" width="60" height="50"></a><font size="1" color="#336699">Copyright
      © 2000-2003 KE Software.&nbsp;</font></font></td>
    <td width="10%"></td>
  </tr>
</table>

<SCRIPT LANGUAGE="JavaScript">
<!--
	preload()
	setTimeout("transformPicture()", 10000)
</SCRIPT>

</body>

</html>
