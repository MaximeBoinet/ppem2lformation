<?php
require_once '/modele/bdd.php';

function RecupMesFormationEnCours($bdd)
{
	$sql = $bdd->prepare("SELECT * 
							FROM formation 
							WHERE id IN (SELECT formation_id 
										FROM formationencours
										WHERE salarie_id = (SELECT id
															FROM salarie
															WHERE nom = :nom
															AND prenom = :prenom) 
										AND etat = 1 AND annulée = 0)");
										
	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	
	$sql->execute();
	
	return $sql;
}

function RecupMesFormationAttenteInscription($bdd)
{
	$sql = $bdd->prepare("SELECT *
							FROM formation
							WHERE id IN (SELECT formation_id
										FROM formationencours
										WHERE salarie_id = (SELECT id
															FROM salarie
															WHERE nom = :nom
															AND prenom = :prenom)
										AND etat = 0
										AND annulée = 0)");

	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);

	$sql->execute();

	return $sql;
}

function RecupMesFormationAnnulees($bdd)
{
	$sql = $bdd->prepare("SELECT *
							FROM formation
							WHERE id IN (SELECT formation_id
										FROM formationencours
										WHERE salarie_id = (SELECT id
															FROM salarie
															WHERE nom = :nom
															AND prenom = :prenom)
										AND annulée = 1)");

	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);

	$sql->execute();

	return $sql;
}

function RecupMesSalaries($bdd)
{
	$sql = $bdd->prepare("SELECT * 
							FROM salarie
							WHERE salarie_id = (SELECT id
												FROM salarie
												WHERE nom = :nom
												AND prenom = :prenom)");
	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	
	$sql->execute();
	
	return $sql;
}

function RecupUnSalarie($bdd, $id)
{
	$sql = $bdd->prepare("SELECT * FROM salarie WHERE id = :id");
	
	$sql->bindValue(':id', $id);
	
	$sql->execute();
	
	return $sql;
}

function RecupPresta($bdd, $id){
	$sql = $bdd->prepare("SELECT * FROM prestataire WHERE id = :id");

	$sql->bindValue(':id', $id);

	$sql->execute();

	return ($sql);
}

function RecupLesFormationDeMonSalarie($bdd)
{
	$sql = $bdd->prepare("SELECT etat, annulée, S.id, contenu, nbrJours, prestataire_id, typeFormation_labelle, S.nom, S.prenom, P.id AS pid , F.id AS fid, formation_id
							FROM formation F, formationencours FTC, prestataire P, salarie S
							WHERE FTC.salarie_id = :id AND S.salarie_id = (SELECT id FROM salarie WHERE nom = :nom AND prenom = :prenom)
					AND F.id = formation_id AND annulée = 0 
			 AND etat = 1 Group by contenu");
							
	$sql->bindValue(':id', $_GET['id']);
	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	$sql->execute();
	
	return $sql;
}

function RecupLesFormationDeMonSalarieAttente($bdd)
{
	$sql = $bdd->prepare("SELECT etat, annulée, S.id, contenu, nbrJours, prestataire_id, typeFormation_labelle, S.nom, S.prenom, P.id AS pid , F.id AS fid, formation_id
							FROM formation F, formationEnCours FTC, prestataire P, salarie S
							WHERE FTC.salarie_id = :id AND S.salarie_id = (SELECT id FROM salarie WHERE nom = :nom AND prenom = :prenom)
					AND F.id = formation_id AND annulée = 0
			  AND etat = 0 Group by contenu");
		
	$sql->bindValue(':id', $_GET['id']);
	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	$sql->execute();

	return $sql;
}

function RecupLesFormationDeMonSalarieAnnulée($bdd)
{
	$sql = $bdd->prepare("SELECT etat, annulée, S.salarie_id, contenu, nbrJours, prestataire_id, typeFormation_labelle, S.nom, S.prenom, P.id AS pid , F.id AS fid, formation_id
							FROM formation F, formationEnCours FTC, prestataire P, salarie S
							WHERE FTC.salarie_id = :id AND S.salarie_id = (SELECT id FROM salarie WHERE nom = :nom AND prenom = :prenom)
					AND F.id = formation_id AND annulée = 1
			   Group by contenu");

	$sql->bindValue(':id', $_GET['id']);
	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	$sql->execute();

	return $sql;
}

function RecupLesFormationDeMonSalarieAchevée($bdd)
{
	$sql = $bdd->prepare("SELECT etat, annulée, S.salarie_id, contenu, nbrJours, prestataire_id, typeFormation_labelle, S.nom, S.prenom, P.id AS pid , F.id AS fid, formation_id
							FROM formation F, formationEnCours FTC, prestataire P, salarie S
							WHERE FTC.salarie_id = :id AND S.salarie_id = (SELECT id FROM salarie WHERE nom = :nom AND prenom = :prenom)
					AND F.id = formation_id AND annulée = 0
			AND etat = 2
			   Group by contenu");

	$sql->bindValue(':id', $_GET['id']);
	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	$sql->execute();

	return $sql;
}

function RecupMesFormationAchevée($bdd)
{
	$sql = $bdd->prepare("SELECT etat, annulée, S.salarie_id, contenu, nbrJours, prestataire_id, typeFormation_labelle, S.nom, S.prenom, P.id AS pid , F.id AS fid, formation_id
							FROM formation F, formationEnCours FTC, prestataire P, salarie S
							WHERE FTC.salarie_id = (SELECT id FROM salarie WHERE nom = :nom AND prenom = :prenom)
					AND F.id = formation_id AND annulée = 0
			AND etat = 2
			   Group by contenu");

	$sql->bindValue(':nom', $_SESSION['name']);
	$sql->bindValue(':prenom', $_SESSION['fname']);
	$sql->execute();

	return $sql;
}