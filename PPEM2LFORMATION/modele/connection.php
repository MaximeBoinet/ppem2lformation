<?php

require_once('../modele/bdd.php');

function VerifId($bdd, $pswd, $identifiant) {
	$sql = $bdd->prepare("SELECT * FROM salarie WHERE mdp = :mdp AND mail = :mail");
	
	$sql->bindValue(':mdp', $pswd);
	$sql->bindValue(':mail', $identifiant);
	
	$sql->execute();

	return ($sql);
}
