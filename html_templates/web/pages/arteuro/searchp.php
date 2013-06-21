<?php
/*
** Copyright (c) 1998-2009 KE Software Pty Ltd
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
  		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  		<link type="text/css" rel="stylesheet" href="css/style.css" />
  		<title> La collection et la phototh�que de la Fondation Cartier </title>
  	</head>
	<body>
		<h1>
			Phototh�que
		</h1>
		<div id= "searcharea">
			<div id= "topband">
				Rechercher un visuel
			</div>
		<div id= "collectionform">
			<form action= "resultsp.php" />
			<input type="hidden" name="objecttype" value="phototheque" />
			<div class="form-field">
				<label for="identifier">Identifiant</label> 
				<input id= "identifier" type="text" name="identifier" />
			</div>
			<div class="form-field">
				<label for="captionfrench">L�gende fran�aise</label>
				<input id="captionfrench" type="text" name="captionfrench" />
			</div>
			<div class="form-field">
				<label for="captionenglish">L�gende anglaise</label>
				<input id="captionenglish" type="text" name="captionenglish" />
			</div>
			<div class="form-field">
				<label for="description">Description</label>
				<input id="descriptioninf" type="text" name="descriptioninf" />
			</div>
			<div class="form-field">
				<label for= "datecreatedvue">Date de prise de vue</label>
				<input id="datecreatedvue" type="text" name="datecreated" />
			</div>
			<br />
			<div class= "photosearchtext">
				Dimensions de la photographie :
			</div>
			<div class="form-field">
				<label for= "dimensionshauteur">Hauteur</label>
				<input id="dimensionshauteur" type="text" name="dimensionshauteur" />
			</div>
			<div class="form-field">
				<label for= "dimensionslargeur">Largeur</label>
				<input id="dimensionslargeur" type="text" name="dimensionslargeur" />
			</div>
			<div class="form-field">
				<div class= "underline">
					<label for= "chromie">Chromie :</label>
				</div>
				<input type="checkbox" name="chromiecolour" value="true"/> Couleur
				<input type="checkbox" name="chromienoiretblanc" value="true"/> Noir et blanc	
			</div>
			<div class="form-field">
				<div class= "underline">
					<label for= "presence">Pr�sence d'un public :</label>
				</div>
				<input type="checkbox" name="presencedunpublicoui" value="true"/> Oui
				<input type="checkbox" name="presencedunpublicnon" value="true"/> Non	
			</div>
			<div class="form-field">
				<div class= "underline">
					<label for= "vue">Vue :</label>
				</div>
				<input type="checkbox" name="vuedejour" value="true"/> De jour
				<input type="checkbox" name="vuedenuit" value="true"/> De nuit	
			</div>
			<br />
			<div class= "photosearchtext">
				Historique des publications :
			</div>
			<div class="form-field">
				<label for= "titrecat">Titre catalogue</label>
				<input id="titrecat" type="text" name="titrecat" />
			</div>
			<div class="form-field">
				<label for= "page">Page</label>
				<input id="page" type="text" name="page" />
			</div>
			<div class="form-field">
				<label for= "credphoto">Cr�dit photographe</label>
				<input id="credphoto" type="text" name="credphoto" />
			</div>
			<div class="form-field">
				<label for= "credartist">Cr�dit artiste</label>
				<input id="credartist" type="text" name="credartist" />
			</div>
			<br />
			<div class= "photosearchtext">
				Objet repr�sent�:
			</div>
			<div class="form-field">
				<div class="underline">
					<label for= "repobject">�uvre de la collection</label>
				</div>
				<input type="checkbox" name="repobjectoui" value="true"/> Oui
				<input type="checkbox" name="repobjectnon" value="true"/> Non	
			</div>
			<br />
			<div class="form-field">
				<div class="underline">
					<label for= "repevent">Ev�nement</label>
				</div>
				<input type="checkbox" name="repeventoui" value="true"/> Oui
				<input type="checkbox" name="repeventnon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "phoeveex">Exposition</label>
				<input type="checkbox" name="expositionoui" value="true"/> Oui
				<input type="checkbox" name="expositionnon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "travevent">Soir�e nomade</label>
				<input type="checkbox" name="soireenomadeoui" value="true"/> Oui
				<input type="checkbox" name="soireenomadenon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "evepreview">Vernissage</label>
				<input type="checkbox" name="vernissageoui" value="true"/> Oui
				<input type="checkbox" name="vernissagenon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "eveworkshop">Atelier</label>
				<input type="checkbox" name="atelieroui" value="true"/> Oui
				<input type="checkbox" name="ateliernon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "childwshop">Atelier pour enfant</label>
				<input type="checkbox" name="atelierpourenfantoui" value="true"/> Oui
				<input type="checkbox" name="atelierpourenfantnon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "evelecture">Cour conf�rence</label>
				<input type="checkbox" name="phoevelectureoui" value="true"/> Oui
				<input type="checkbox" name="phoevelecturenon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "relevants">Titre �v�nement</label>
				<input id="titreevenement" type="text" name="titreevenement" />
			</div>	
			<br />	
			<div class="form-field">
				<div class="underline">
					<label for= "batiment">B�timent</label>
				</div>
				<input type="checkbox" name="batimentoui" value="true"/> Oui
				<input type="checkbox" name="batimentnon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "batimentbou">B�timent Boulevard Raspail</label>
				<input type="checkbox" name="batimentbououi" value="true"/> Oui
				<input type="checkbox" name="batimentbounon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "batimentjardin">Jardin Boulevard Raspail</label>
				<input type="checkbox" name="batimentjardinoui" value="true"/> Oui
				<input type="checkbox" name="batimentjardinnon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "batimentjen">B�timent Jouy-en-Josas </label>
				<input type="checkbox" name="batimentjouyoui" value="true"/> Oui
				<input type="checkbox" name="batimentjouynon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "batimentjenj">Jardin Jouy-en-Josas</label>
				<input type="checkbox" name="batimentjouyenjosasoui" value="true"/> Oui
				<input type="checkbox" name="batimentjouyenjosasnon" value="true"/> Non	
			</div>
			<br />
			<div class="form-field">
				<div class="underline">
					<label for= "portraitartist">Portrait d'artiste</label>
				</div>
				<input type="checkbox" name="portraitartisteoui" value="true"/> Oui
				<input type="checkbox" name="portraitartistenon" value="true"/> Non	
			</div>
			<div class="form-field">
				<label for= "nomlast">Nom</label>
				<input id="nomlast" type="text" name="nomlast" />
			</div>	
			<div id="formcontrols">
				<div class="form-field">
					<label for= "results">Nombre de R�sultats par page</label>
					<select id= "results" name= "results">
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
					</select>
					<input type="submit" value="Rechercher" />
					<input type="reset" value="Effacer" />
				</div>
			</div>
		</div>
		</div>			
	<div id="bottomnav">
		<a href="index.html"> Retour � l�accueil </a>
		<img src="images/logo.jpg" alt="Fondation Cartier pour l'art contemporain" />
	</div>
	</body>
</html>
