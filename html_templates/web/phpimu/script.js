function SwitchSearchTabs(id)
{
	if (id == "objects")
	{
		document.getElementById('tab1').className = "SearchActive";	
		document.getElementById('tab2').className= "";	
		document.getElementById('objectsearch').style.display = "block";	
		document.getElementById('narrativesearch').style.display = "none";	
	}
	else if (id == "narratives")
	{
		document.getElementById('tab1').className = "";	
		document.getElementById('tab2').className = "SearchActive";	
		document.getElementById('objectsearch').style.display = "none";	
		document.getElementById('narrativesearch').style.display = "block";	
	}
}
