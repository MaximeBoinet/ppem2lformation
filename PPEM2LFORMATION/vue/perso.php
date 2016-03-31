<?php
require '/controleur/perso.php';
?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
	<h1>Ma Page Perso</h1>
<?php
if (isset($_GET['act']) && $_GET['act'] == "det"){
//Affiche les details d'un salarié
	?><h2>Les Détails de <?php $leSalarie = $monSalarie->fetch(); echo $leSalarie['nom']." ".$leSalarie['prenom'];?></h2><?php 
	//Affiche les demande de formation a accepter du salarié dont la demande de détail a été faite
	if ($formationsMonSalarieAttentes->rowCount() > 0) {
		?><h3>Les Formations en attente d'inscription </h3> <?php
		echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</td><th>Valider</th></tr>");
		while ($formationMonSalarieAttente = $formationsMonSalarieAttentes->fetch()) {
			echo ("<tr>
					<td>".$formationMonSalarieAttente['typeFormation_labelle']."</td><td>".$formationMonSalarieAttente['contenu']."</td><td>".$formationMonSalarieAttente['nom']."
					".$formationMonSalarieAttente['prenom']."</td><td>".$formationMonSalarieAttente['nbrJours']."</td>
					<td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$formationMonSalarieAttente['fid']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td>
					<td id=\"formation\" onclick=\"location.href='controleur/valider.php?sid=".$_GET['id']."&fid=".$formationMonSalarieAttente['fid']."&act=insc';\"><img id=\"annul\" src=\"img/valider.jpg\" alt=\"Image non dispo\"></td></tr>");
		}
		echo ("</table>");
	}
	//Affiche les formation en cours du salarié dont la demande de détail a été faite
	?><h3>Les Formations en cours</h3> <?php 
	if ($lesFormationsDeMonSalarie->rowCount() > 0) {
		echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th><th>FinirLaFormation</th></tr>");
		while ($uneFormationDeMonSalarie = $lesFormationsDeMonSalarie->fetch()) {
			echo ("<tr>
					<td>".$uneFormationDeMonSalarie['typeFormation_labelle']."</td><td>".$uneFormationDeMonSalarie['contenu']."</td><td>".$uneFormationDeMonSalarie['nom']."
					".$uneFormationDeMonSalarie['prenom']."</td><td>".$uneFormationDeMonSalarie['nbrJours']."</td>
					<td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$uneFormationDeMonSalarie['fid']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td>
					<td id=\"formation\" onclick=\"location.href='controleur/valider.php?sid=".$_GET['id']."&fid=".$uneFormationDeMonSalarie['fid']."&act=val';\"><img id=\"annul\" src=\"img/valider.jpg\" alt=\"Image non dispo\"></td><td>");
		}
		echo ("</table>");
	}
	else{
		echo ("Ce salarié n'a suivit aucune formation et n'a aucune formation en cours.");
	}
	//Affiche les annulée salarié dont la demande de détail a été faite
	if ($formationsMonSalarieAnnulées->rowCount() > 0) {
		?><h3>Les Formations recement annulées </h3><?php
		echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Etat</th><th>Détails</th></tr>");
		while ($formationMonSalarieAnnulée = $formationsMonSalarieAnnulées->fetch()) {
			echo ("<tr id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$formationMonSalarieAnnulée['fid']."';\">
					<td>".$formationMonSalarieAnnulée['typeFormation_labelle']."</td><td>".$formationMonSalarieAnnulée['contenu']."</td><td>".$formationMonSalarieAnnulée['nom']."
					".$formationMonSalarieAnnulée['prenom']."</td><td>".$formationMonSalarieAnnulée['nbrJours']."</td><td>Non Validé</td>
					<td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$formationMonSalarieAnnulée['fid']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td></tr>");
		}
	}
	echo ("</table>");
	//Affiche les formation achevée du salarié dont la demande de détail a été faite
	if ($formationsMonSalarieAchevées->rowCount() > 0) {
		?><h3>Les Formations Achevée </h3><?php
				echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th></tr>");
				while ($formationMonSalarieAchevée = $formationsMonSalarieAchevées->fetch()) {
					echo ("<tr id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$formationMonSalarieAchevée['fid']."';\">
							<td>".$formationMonSalarieAchevée['typeFormation_labelle']."</td><td>".$formationMonSalarieAchevée['contenu']."</td><td>".$formationMonSalarieAchevée['nom']."
							".$formationMonSalarieAchevée['prenom']."</td><td>".$formationMonSalarieAchevée['nbrJours']."</td>
							<td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$formationMonSalarieAchevée['fid']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td></tr>");
				}
			}
	echo ("</table>");
}
else{
	
	//Affiche les formation de la personne connecté
	?><h2>Mes formation en cours</h2> <?php
	if ($donnees->rowCount() > 0) {
		echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th></tr>");
	
		while ($donnee = $donnees->fetch()) {
	
			$presta = RecupPresta($bdd, $donnee['prestataire_id'])->fetch();
				
			echo ("<tr><td>".$donnee['typeFormation_labelle']."</td><td>".$donnee['contenu']."</td><td>".$presta['nom']."
					".$presta['prenom']."</td><td>".$donnee['nbrJours']."</td><td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$donnee['id']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td></tr>");
		}
		echo ("</table>");
	}
	else
	{
		echo ("Vous n'êtes incrit à aucune formation.\t\n");
	}
	//Affiche les formation non encore accepté de la personne connecté
	if ($donnees3->rowCount() > 0) {
		?><h2>Mes formations en attente d'inscription</h2> <?php
		echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th><th>Annuler</th></tr>");
	
		while ($donnee3 = $donnees3->fetch()) {
	
			$presta = RecupPresta($bdd, $donnee3['prestataire_id'])->fetch();
				
			echo ("<tr><td>".$donnee3['typeFormation_labelle']."</td><td>".$donnee3['contenu']."</td><td>".$presta['nom']."
					".$presta['prenom']."</td><td>".$donnee3['nbrJours']."</td><td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$donnee3['id']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td>
					<td id=\"formation\" onclick=\"location.href='controleur/annul.php?id=".$donnee3['id']."';\"><img id=\"annul\" src=\"img/annuler.jpg\" alt=\"Image non dispo\"></td></tr>");
		}
		echo ("</table>");
	}
	//Affiche les formation recement annulée de la personne connecté
	if ($donnees4->rowCount() > 0) {
		?><h2>Mes formations recement annulée</h2> <?php
			echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th><th>Se reinscrire</th></tr>");
		
			while ($donnee4 = $donnees4->fetch()) {
		
				$presta = RecupPresta($bdd, $donnee4['prestataire_id'])->fetch();
					
				echo ("<tr><td>".$donnee4['typeFormation_labelle']."</td><td>".$donnee4['contenu']."</td><td>".$presta['nom']."
						".$presta['prenom']."</td><td>".$donnee4['nbrJours']."</td><td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$donnee4['id']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td>
						<td id=\"formation\" onclick=\"location.href='\controleur/inscription.php?inscription=true&from=p&id=".$donnee4['id']."';\"><img id=\"icod\" src=\"img/Icone-sinscrire.jpg\" alt=\"Image non dispo\"></td></tr>");
			}
			echo ("</table>");
		}
	if ($donnees5->rowCount() > 0) {
		?><h3>Mes Formations Achevée </h3><?php
					echo ("<table class=\"table table-hover\"><tr><th>Type</th><th>Contenu</th><th>Prestataire</th><th>Durée(j)</th><th>Détails</th></tr>");
					while ($donnee5 = $donnees5->fetch()) {
						echo ("<tr id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$donnee5['fid']."';\">
								<td>".$donnee5['typeFormation_labelle']."</td><td>".$donnee5['contenu']."</td><td>".$donnee5['nom']."
								".$donnee5['prenom']."</td><td>".$donnee5['nbrJours']."</td>
								<td id=\"formation\" onclick=\"location.href='\?page=accueil&act=det&id=".$donnee5['fid']."';\"><img id=\"icod\" src=\"img/bouton_detail.gif\" alt=\"Image non dispo\"></td></tr>");
					}
				}
	echo ("</table>");
	//Affiche les salariées de la personne connecté
	?><h2>Vos salariés</h2> <?php
	if ($donnees2->rowCount() > 0) {
	
		echo ("<table class=\"table table-hover\"> <tr><th>Nom</th><th>Prenom</th><th>Mail</th></tr>");
	
		while ($donnee2 = $donnees2->fetch()) {
				
			echo ("<tr id=\"formation\" onclick=\"location.href='\?page=perso&act=det&id=".$donnee2['id']."';\">
					<td>".$donnee2['nom']."</td><td>".$donnee2['prenom']."</td>
					<td>".$donnee2['mail']."</td></tr>");
		}
		echo ("</table>");
	}
	else
	{
		echo ("Vous ne gerez pas de salarié.");
	}
}
?>
	</div>
</div>