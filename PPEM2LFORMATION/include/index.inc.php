<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h1>Bienvenue dans le site de gestion des formations de la maison des ligues</h1>
	</div>
</div>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<form method="post" action="controleur/connection.php">
			 <div class="form-group">
				<label for="identifiant">Identifiant :</label>
				<input type="text" class="form-control" name="identifiant" id="identifiant" placeholder="Votre email">
			</div>
			<div class="form-group">
				<label for="pswd">Mot de Passe :</label>
				<input type="password" class="form-control" name="pswd" id="pswd" placeholder="Mot de Passe">
			</div>
			<div class="checkbox">
				<label><input type="checkbox" name="stayc" id="stayc">Se souvenir de moi</label>
			</div>
				<input type="hidden" name="connection" value="true">
				<button type="submit" class="btn btn-default">Connection</button>
		</form>
	</div>
</div>