<?php

require_once('../modele/bdd.php');

function RecupSalarie ($bdd, $nom,$prenom){
	$sql = $bdd->prepare("SELECT * FROM salarie WHERE nom = :nom AND prenom = :prenom");
	
	$sql->bindValue(':nom', $nom);
	$sql->bindValue(':prenom', $prenom);
	
	$sql->execute();

	return ($sql);
}

function RecupPrerequis($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM prérequis WHERE formation_id = :id");

	$sql->bindValue(':id', $id);

	$sql->execute();

	return ($sql);
}

function RecupMesFormationEnCours($bdd)
{
	$sql = $bdd->prepare("SELECT *
							FROM formation
							WHERE id IN (SELECT formation_id
										FROM formationencours
										WHERE salarie_id = (SELECT id
															FROM salarie
															WHERE nom = :nom
															AND prenom = :prenom))");

	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);

	$sql->execute();

	return $sql;
}

function ALesPrerequis($bdd,$nom,$prenom,$id)
{
	$prerequis = RecupPrerequis($bdd, $id);
	if ($prerequis->rowCount() < 1) {
		return true;
	}

	$lesFormations = RecupMesFormationEnCours($bdd)->fetchAll();
	while ($prerequi = $prerequis->fetch()) {
		$in = false;
		foreach ($lesFormations as $key => $value){
			foreach ($value as $key2 => $value2){
				if ($key2 == "id" && $value2 == $prerequi['formation_id1']) {
					$etat = RecupEtatFormation($bdd, $id, $prerequi['formation_id1'])->fetch();

					$in =  ($etat == 2);
				}
			}
		}
		if (!$in) {
			return false;
		}
	}
	return true;
}

function RecupEtatFormation($bdd, $id, $iddeux)
{
	$sql = $bdd->prepare("SELECT etat FROM formationEnCours WHERE salarie_id = :id
			AND formation_id = :iddeux");
	$sql->bindValue(":id", $id);
	$sql->bindValue(":iddeux", $iddeux);
	$sql->execute();
	return $sql;
}

function Inscription($bdd, $nom, $prenom, $id){
	$salarie = RecupSalarie($bdd, $nom, $prenom)->fetch();
	$sid = $salarie['id'];
	if (VerifPresenceFormationAnnulée($bdd, $sid, $id)) {
		$sql = $bdd->prepare("UPDATE formationencours
			SET `annulée` = 0
			WHERE formation_id = :id
			AND salarie_id = (SELECT id 
							FROM salarie
							WHERE nom = :nom
							AND prenom = :prenom)");
		$sql->bindValue(":id", $id);
		$sql->bindValue(":nom", $nom);
		$sql->bindValue(":prenom", $prenom);
	}
	else{
		$sql= $bdd->prepare("INSERT INTO `formationencours`(`formation_id`, `salarie_id`, `etat`, `annulée`,`evalué`)
			VALUES (:fid,:sid,0,0,0)");
		$sql->bindValue(":fid", $id);
		$sql->bindValue(":sid", $sid);
	}
	return $sql->execute();
	
}

function VerifPresenceFormationAnnulée($bdd, $sid, $id)
{
	$sql = $bdd->prepare("SELECT * FROM formationencours WHERE
			salarie_id = :sid AND formation_id = :fid AND `annulée` = 1");
	$sql->bindValue(':sid', $sid);
	$sql->bindValue(':fid', $id);
	$sql->execute();
	return $sql->rowCount() > 0;
}

function VerifDéjaInscrit($bdd, $nom, $prenom, $id)
{
	$salarie = RecupSalarie($bdd, $nom, $prenom)->fetch();
	$sid = $salarie['id'];
	$sql = $bdd->prepare("SELECT * FROM formationEnCours WHERE
			AND salarie_id = :sid AND formation_id = :fid AND annulée = 0");
	$sql->bindValue(':sid', $sid);
	$sql->bindValue(':fid', $id);
	$sql->execute();
	return $sql->rowCount() > 0;
}