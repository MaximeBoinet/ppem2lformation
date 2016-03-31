<?php

include_once '/modele/accueil.php';
$bdd = Bdd::getInstance();

if (isset($_GET['act']) && $_GET['act'] == "det") {
	$sessions = RecupSession($bdd, $_GET['id']);
	$prerequis = RecupPrerequis($bdd, $_GET['id']);
	$formationsencours = RecupFormationEnCours($bdd);
}
else {
	$formations = RecupFormations($bdd);
	$formationsencours = RecupFormationEnCours($bdd);
}
