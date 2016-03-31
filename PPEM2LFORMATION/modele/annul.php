<?php
require_once '../modele/bdd.php';

function AnnulerFormation($bdd, $nom, $prenom, $id) {
	$sql = $bdd->prepare("UPDATE formationEnCours
			SET annulée = 1
			WHERE formation_id = :id
			AND salarie_id = (SELECT id 
							FROM salarie
							WHERE nom = :nom
							AND prenom = :prenom)");
	$sql->bindValue(":id", $id);
	$sql->bindValue(":nom", $nom);
	$sql->bindValue(":prenom", $prenom);
	
	return $sql->execute();
}