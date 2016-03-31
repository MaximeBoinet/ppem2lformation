<?php
require_once('/modele/bdd.php');

function RecupFormations($bdd) {
	$sql = $bdd->query("SELECT * FROM formation ");

	return ($sql);
}

function RecupFormationEnCours($bdd){
	$sql = $bdd->prepare("SELECT * 
						FROM formationencours 
						WHERE salarie_id = 
								(SELECT id 
								FROM salarie 
								WHERE nom = :nom
								AND prenom = :prenom)
						AND annulée = 0");
	
	$sql->bindValue(':nom',$_SESSION['name']);
	$sql->bindValue(':prenom',$_SESSION['fname']);
	
	$sql->execute();
	
	return ($sql);
}

function RecupPresta($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM prestataire WHERE id = :id");
	
	$sql->bindValue(':id', $id);
	
	$sql->execute();
	
	return ($sql);
}

function RecupSession($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM session WHERE formation_id = :id");
	
	$sql->bindValue(':id', $id);
	
	$sql->execute();
	
	return ($sql);
}

function RecupPrerequis($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM prérequis WHERE formation_id = :id");
	
	$sql->bindValue(':id', $id);
	
	$sql->execute();
	
	return ($sql);
}

function RecupFormationPrerequis($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM formation WHERE id = :id");

	$sql->bindValue(':id', $id);

	$sql->execute();

	return ($sql);
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

					$in = ($etat == 2);
				}
			}
		}
		if (!$in) {
			return false;
		}
	}
	return true;
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

function RecupEtatFormation($bdd, $id, $iddeux)
{
	$sql = $bdd->prepare("SELECT etat FROM formationencours WHERE salarie_id = :id
			AND formation_id = :iddeux");
	$sql->bindValue(":id", $id);
	$sql->bindValue(":iddeux", $iddeux);
	$sql->execute();
	return $sql;
}

function RecupLieu($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM lieu WHERE id = :id");

	$sql->bindValue(':id', $id);

	$sql->execute();

	return ($sql);
}