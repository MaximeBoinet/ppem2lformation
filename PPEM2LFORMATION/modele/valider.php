<?php
require_once '../modele/bdd.php';

function InscrireFormation($bdd, $sid, $fid) {
	$sql = $bdd->prepare("UPDATE formationEnCours
			SET etat = 1
			WHERE formation_id = :fid
			AND salarie_id = :sid");
	$sql->bindValue(":sid", $sid);
	$sql->bindValue(":fid", $fid);

	return $sql->execute();
}

function ValiderFormation($bdd, $sid, $fid) {
	$sql = $bdd->prepare("UPDATE formationEnCours
			SET etat = 2
			WHERE formation_id = :fid
			AND salarie_id = :sid");
	$sql->bindValue(":sid", $sid);
	$sql->bindValue(":fid", $fid);

	return $sql->execute();
}