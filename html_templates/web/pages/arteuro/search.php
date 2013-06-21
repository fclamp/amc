<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
  		<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  		<link type="text/css" rel="stylesheet" href="css/style.css" />
  		<title> La collection et la photothèque de la Fondation Cartier </title>
  	</head>
	<body>
		<h1>
			Œuvres de la collection 
		</h1>
		<div id= "searcharea">
			<div id= "topband">
				Rechercher une œuvre de la collection
			</div>
			<div id= "collectionform">
				
				<form action= "results.php" />
					<input type="hidden" name="objecttype" value="Oeuvre" />
					<div class="form-field">
						<label for="artiste">Artiste</label> 
						<input id= "artiste" type="text" name="creatorname" />
					</div>
					
					<div class="form-field">
						<label for="titre">Titre</label>
						<input id="titre" type="text" name="maintitle" />
					</div>
					
					<div class="form-field">
						<label for="date">Date</label>
						<input id="date" type="text" name="datecreated" />
					</div>
				
					<div class="form-field">
						<label for="domaine">Domaine</label>
						<input id="domaine" type="text" name="objecttype" />
					</div>
					
					<div class="form-field">
						<label for= "descriptif">Descriptif</label>
						<input id="descriptif" type="text" name="description" />
					</div>
					
					<div class="form-field">
						<label for= "acquisition">Année d’Acquisition</label>
						<input id= "acquisition" type="text" name="accessiondate" />
					</div>
						
					<div id="formcontrols">
						<div class="form-field">
							<label for= "results">Nombre de Résultats par page</label>
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
			<a href="index.html"> Retour à l’accueil </a>
			<img src="images/logo.jpg" alt="Fondation Cartier pour l'art contemporain" />
		</div>
	</body>
</html>
