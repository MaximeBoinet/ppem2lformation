<?php
require_once 'controleur/accueil.php';

?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
	
<?php 
if (isset($_GET['act']) && $_GET['act'] == "det" && isset($_GET['id'])) {
	?><h1>Detail</h1>
	<div class="row">
		<div class="col-md-6 col-md-offset-4">
			<a href="controleur/inscription.php?inscription=true&id=<?php echo $_GET['id'] ?>">
				<img id="icog" src="img/Icone-sinscrire.jpg" alt="Image non dispo">
			</a>
		</div>
	</div><?php	
	//Affiche les sessions lors de la demande de détails
	if ($sessions->rowCount() > 0) {
		echo ("<table class=\"table table-hover\"><tr><th>Date</th><th>Heure Debut</th><th>Heure Fin</th><th>Lieu</th><th>Salle</th></tr>");
		
		while ($session = $sessions->fetch()) {
			$lieu = RecupLieu($bdd, $session['lieu_id'])->fetch();
			
			echo ("<tr><td>".$session['intervalle_date']."</td><td>".$session['intervalle_heureDebut1']."</td>
					<td>".$session['intervalle_heureFin']."</td><td><p>".$lieu['rue']."</p><p>".$lieu['codePostal']."
					 ".$lieu['ville']."</p></td><td>".$session['salleSessions_labelle']."</td></tr>");
		}
		echo ("</table>");
	}
	else{
		echo ("Auncune session n'est disponible pour le moment");
	}
	
	//Affiche les prérequis lors de la demande de détails
	if ($prerequis->rowCount() > 0) {
		?><h2>Les Prérequis</h2><?php
		$formationencours = $formationsencours->fetchAll();
		echo ("<table class=\"table table-hover\"> <tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th></tr>");
		
		while ($prerequi = $prerequis->fetch()) {
			$in = false;
			foreach ($formationencours as $key => $value){
				foreach ($value as $key2 => $value2){
					if ($key2 == 'formation_id' && $value2 == $prerequi['formation_id1']) {
						$in = true;
					}
				}
			}

			$presta = RecupPresta($bdd, $prerequi['formation_id1'])->fetch();
			$session4 = RecupFormationPrerequis($bdd, $prerequi['formation_id1'])->fetch();

			echo ("<tr id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$session4['id']."';\"");
			if ($in) {
				echo("class=\"info\"");
			}
			elseif (!ALesPrerequis($bdd,$_SESSION['name'], $_SESSION['fname'],$session4['id']))
			{
				echo(" class=\"danger\"");
			}
			echo ("><td>".$session4['typeFormation_labelle']."</td><td>".$session4['contenu']."
					</td><td>".$presta['nom']."".$presta['prenom']."</td><td>".$session4['nbrJours']."</td></tr>");
		}
		echo ("</table>");
	}
	
}
else{
	//Affiche toute les formations sur la page d'accueil
	?><h1>Toutes les formations</h1><?php
	if ($formations->rowCount() > 0) {
		$formationencours = $formationsencours->fetchAll();
		echo ("<table class=\"table table\"> <tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th><th>S'inscrire</th></tr>");
		
		while ($formation = $formations->fetch()) {
			$in = false;
			foreach ($formationencours as $key => $value){
				foreach ($value as $key2 => $value2){
					if ($key2 == 'formation_id' && $value2 == $formation['id']) {
						$in = true;
					}
				}
			}
			$presta = RecupPresta($bdd, $formation['prestataire_id'])->fetch();
			
			echo ("<tr");
			if ($in) {
				echo(" class=\"info\"");
			}
			elseif (!ALesPrerequis($bdd,$_SESSION['name'], $_SESSION['fname'],$formation['id']))
			{
				echo(" class=\"danger\"");
			}
			echo ("><td>".$formation['typeFormation_labelle']."</td><td>".$formation['contenu']."
					</td><td>".$presta['nom']."".$presta['prenom']."</td><td>".$formation['nbrJours']."</td>
					<td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$formation['id']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td>
					<td id=\"formation\" onclick=\"location.href='\controleur/inscription.php?inscription=true&id=".$formation['id']."';\"><img id=\"icod\" src=\"img/Icone-sinscrire.jpg\" alt=\"Image non dispo\"></td></tr>");
		}
		echo ("</table>");
	}
	else
	{
		echo ("Auncune formation n'est disponible pour le moment");
	}
}

?>
	</div>
</div>