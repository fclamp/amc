
function
SwitchSearchTabs(divname)
{		
	$("#keywordtab").removeClass();
	$("#quicktab").removeClass();
	$("#detailedtab").removeClass();

	if (divname == "keywordsearchbody")
	{
		$("#keywordtab").addClass("componentBody");
		$("#quicktab").addClass("componentBody2");
		$("#detailedtab").addClass("componentBody2");

		$("#keywordsearchbody").fadeIn();
		$("#quicksearchbody").css("display", "none");
		$("#detailedsearchbody").css("display", "none");
		/*document.getElementById("keywordtab").className = "componentBody";
		document.getElementById("quicktab").className = "componentBody2";
		document.getElementById("detailedtab").className = "componentBody2";

		document.getElementById("keywordsearchbody").style.display = "block";
		document.getElementById("quicksearchbody").style.display = "none";
		document.getElementById("detailedsearchbody").style.display = "none";*/
	}
	if (divname == "quicksearchbody")
	{
		$("#keywordtab").addClass("componentBody2");
		$("#quicktab").addClass("componentBody");
		$("#detailedtab").addClass("componentBody2");

		$("#keywordsearchbody").css("display", "none");
		$("#quicksearchbody").fadeIn();
		$("#detailedsearchbody").css("display", "none");

		/*document.getElementById("keywordtab").className = "componentBody2";
		document.getElementById("quicktab").className = "componentBody";
		document.getElementById("detailedtab").className = "componentBody2";

		document.getElementById("keywordsearchbody").style.display = "none";
		document.getElementById("quicksearchbody").style.display = "block";
		document.getElementById("detailedsearchbody").style.display = "none";*/
	}
	if (divname == "detailedsearchbody")
	{
		$("#keywordtab").addClass("componentBody2");
		$("#quicktab").addClass("componentBody2");
		$("#detailedtab").addClass("componentBody");

		$("#keywordsearchbody").css("display", "none");
		$("#quicksearchbody").css("display", "none");
		$("#detailedsearchbody").fadeIn();

		/*document.getElementById("keywordtab").className = "componentBody2";
		document.getElementById("quicktab").className = "componentBody2";
		document.getElementById("detailedtab").className = "componentBody";
		
		document.getElementById("keywordsearchbody").style.display = "none";
		document.getElementById("quicksearchbody").style.display = "none";
		document.getElementById("detailedsearchbody").style.display = "block";*/
	}
}


function 
FieldSelector()
{
	var arrayindex = document.forms['detailedsearch'].colcoll.selectedIndex;
	var arrayvalue = document.forms ['detailedsearch'].colcoll.options[arrayindex].text;
	
	document.getElementById("objStatusLbl").style.display = "none";
	document.getElementById("objNameLbl").style.display = "none";
	document.getElementById("subClassLbl").style.display = "none";
	document.getElementById("objFullNameLbl").style.display = "none";
	document.getElementById("mapTitleLbl").style.display = "none";
	document.getElementById("publisherLbl").style.display = "none";
	document.getElementById("objNumLbl").style.display = "none";
	document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
	document.getElementById("specNameLbl").style.display = "none";
	document.getElementById("familyLbl").style.display = "none";
	document.getElementById("genusLbl").style.display = "none";
	document.getElementById("orderLbl").style.display = "none";
	document.getElementById("speciesLbl").style.display = "none";
	document.getElementById("otherNumTypeLbl").style.display = "none";
	document.getElementById("otherNumLbl").style.display = "none";
	document.getElementById("bibliographyLbl").style.display = "none";
	document.getElementById("culturalGroupLbl").style.display = "none";
	document.getElementById("nameCollLbl").style.display = "none";
	document.getElementById("makerLbl").style.display = "none";	
	document.getElementById("productionPlaceLbl").style.display = "none";
	document.getElementById("productionDateLbl").style.display = "none";
	document.getElementById("creditLineLbl").style.display = "none";
	document.getElementById("associatedEventLbl").style.display = "none";
	document.getElementById("associatedPersonLbl").style.display = "none";
	document.getElementById("assocPersonLabel").innerHTML="Associated Person/Organisation";
	document.getElementById("descriptionLbl").style.display = "none";
	document.getElementById("obverseDescriptionLbl").style.display = "none";
	document.getElementById("reverseDescriptionLbl").style.display = "none";
	document.getElementById("chronsgraphyLbl").style.display = "none";
	document.getElementById("lithosgraphyLbl").style.display = "none";
	document.getElementById("localityLbl").style.display = "none";
	document.getElementById("archSiteNameLbl").style.display = "none";
	document.getElementById("titleLbl").style.display = "none";
	document.getElementById("artistLbl").style.display = "none";
	document.getElementById("periodLbl").style.display = "none";
	document.getElementById("adateLbl").style.display = "none";
	document.getElementById("aplaceLbl").style.display = "none";
	document.getElementById("preciseLocationLbl").style.display = "none";
	document.getElementById("collEventLbl").style.display = "none";
	document.getElementById("locLevel1Lbl").style.display = "none";
	document.getElementById("locLevel2Lbl").style.display = "none";
	document.getElementById("siteCodeLbl").style.display = "none";
	document.getElementById("projectNameLbl").style.display = "none";
	
	switch (arrayvalue)
	{
		case 'Mineralogy':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			document.getElementById("specNameLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("nameCollLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("chronsgraphyLbl").style.display = "";
			document.getElementById("lithosgraphyLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			
		break;	
		
		case 'Petrology':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			document.getElementById("specNameLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("nameCollLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("chronsgraphyLbl").style.display = "";
			document.getElementById("lithosgraphyLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
	
		break;
	
		case 'Palaeontology':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			document.getElementById("specNameLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("nameCollLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("chronsgraphyLbl").style.display = "";
			document.getElementById("lithosgraphyLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			
		break;	
		
		case 'Maps & Plans':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("mapTitleLbl").style.display = "";		
			document.getElementById("publisherLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("aplaceLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
		
		break;	
			
		case 'Biology':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";	
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("specNameLbl").style.display = "";
			document.getElementById("familyLbl").style.display = "";
			document.getElementById("genusLbl").style.display = "";
			document.getElementById("orderLbl").style.display = "";
			document.getElementById("speciesLbl").style.display = "";
			document.getElementById("nameCollLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
		
		break;
			
		case 'Social History':	
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("objFullNameLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("nameCollLbl").style.display = "";	
			document.getElementById("makerLbl").style.display = "";
			document.getElementById("productionPlaceLbl").style.display = "";
			document.getElementById("productionDateLbl").style.display = "";	
			document.getElementById("associatedPersonLbl").style.display = ""; 
			document.getElementById("assocPersonLabel").innerHTML="Associated Person/Organisation";
			document.getElementById("associatedEventLbl").style.display = "";
			document.getElementById("aplaceLbl").style.display = "";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
		
		break;	
		
		case 'Industrial and Maritime History':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("objFullNameLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("nameCollLbl").style.display = "";	
			document.getElementById("makerLbl").style.display = "";
			document.getElementById("productionPlaceLbl").style.display = "";
			document.getElementById("productionDateLbl").style.display = "";	
			document.getElementById("associatedPersonLbl").style.display = ""; 
			document.getElementById("assocPersonLabel").innerHTML="Associated Person/Organisation";
			document.getElementById("associatedEventLbl").style.display = "";
			document.getElementById("aplaceLbl").style.display = "";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
		
		break;	
		
		case 'Fine Art':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("titleLbl").style.display = "";		
			document.getElementById("artistLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("aplaceLbl").style.display = "";
			document.getElementById("associatedPersonLbl").style.display = "";
			document.getElementById("assocPersonLabel").innerHTML="Associated Person";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("makerLbl").style.display = "";
			document.getElementById("productionPlaceLbl").style.display = "";
			document.getElementById("productionDateLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
		
		break;
		
		case 'Applied Art':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("titleLbl").style.display = "";		
			document.getElementById("artistLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("aplaceLbl").style.display = "";
			document.getElementById("associatedPersonLbl").style.display = "";
			document.getElementById("assocPersonLabel").innerHTML="Associated Person";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("makerLbl").style.display = "";
			document.getElementById("productionPlaceLbl").style.display = "";
			document.getElementById("productionDateLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = ""; 
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
		
		break;
		
		case 'Eastern Art':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("titleLbl").style.display = "";		
			document.getElementById("artistLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("aplaceLbl").style.display = "";
			document.getElementById("associatedPersonLbl").style.display = "";
			document.getElementById("assocPersonLabel").innerHTML="Associated Person";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("makerLbl").style.display = "";
			document.getElementById("productionPlaceLbl").style.display = "";
			document.getElementById("productionDateLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = ""; 
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			
		break;	
		
		case 'Archaeology':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("subClassLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";	
			document.getElementById("adateLbl").style.display = "";		
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("collEventLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("bibliographyLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
		
		break;
		
		case 'Foreign Archaeology':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("subClassLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";	
			document.getElementById("adateLbl").style.display = "";		
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("collEventLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("bibliographyLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = ""; 
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
		
		break;
		
		case 'Ethnography':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("subClassLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";	
			document.getElementById("adateLbl").style.display = "";		
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("collEventLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("bibliographyLbl").style.display = "";
			document.getElementById("culturalGroupLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = ""; 
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
		
		break;
		
		case 'Numismatics':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";
			document.getElementById("objFullNameLbl").style.display = "";
			document.getElementById("subClassLbl").style.display = "";	
			document.getElementById("descriptionLbl").style.display = "";	
			document.getElementById("obverseDescriptionLbl").style.display = "";
			document.getElementById("reverseDescriptionLbl").style.display = "";	
			document.getElementById("nameCollLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("collEventLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("bibliographyLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			document.getElementById("objNumLbl").style.display = "";
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			
		break;
		
		case 'Maps':
			document.getElementById("objStatusLbl").style.display = "";
			document.getElementById("objNameLbl").style.display = "";	
			document.getElementById("mapTitleLbl").style.display = "";
			document.getElementById("publisherLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			document.getElementById("objNumLbl").style.display = ""; 
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
			document.getElementById("objNumCaption").innerHTML="Object Number";
		
		break;
		
		case 'Site Archive':
			document.getElementById("descriptionLbl").style.display = "";
			document.getElementById("periodLbl").style.display = "";
			document.getElementById("adateLbl").style.display = "";
			document.getElementById("localityLbl").style.display = "";
			document.getElementById("preciseLocationLbl").style.display = "";
			document.getElementById("collEventLbl").style.display = "";
			document.getElementById("otherNumTypeLbl").style.display = "";
			document.getElementById("otherNumLbl").style.display = "";
			document.getElementById("bibliographyLbl").style.display = "";
			document.getElementById("locLevel1Lbl").style.display = "";
			document.getElementById("locLevel2Lbl").style.display = "";
			document.getElementById("siteCodeLbl").style.display = "";
			document.getElementById("projectNameLbl").style.display = "";
			document.getElementById("archSiteNameLbl").style.display = "";
			document.getElementById("objNumLbl").style.display = ""; 
			document.getElementById("objNumCaption").innerHTML="Site Archive Accession Number";
	
			
			
	}
	
}
