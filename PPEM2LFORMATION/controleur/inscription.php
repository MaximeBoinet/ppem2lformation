<?php
session_start();

if (isset($_GET['inscription']) && isset($_GET['id'])) {
	include_once '../modele/inscription.php';
	$bdd = Bdd::getInstance();
	if (!VerifDéjaInscrit($bdd, $_SESSION['name'], $_SESSION['fname'], $_GET['id'])) {
		if (ALesPrerequis($bdd, $_SESSION['name'], $_SESSION['fname'], $_GET['id'])){
			if (Inscription($bdd, $_SESSION['name'], $_SESSION['fname'], $_GET['id']))
			{
				$_SESSION['succes'] = "Inscription reussite";
			}
			else{
				$_SESSION['error'] = "Votre inscription n'a pu aboutir, une erreur est survennu";
			}
		}
		else{
			$_SESSION['error'] = "Votre inscription n'a pu aboutir, veuillez vérifier vos prérequis";
		}
	}
	else
	{
		$_SESSION['error'] = "Vous êtes deja inscript à cette formation";
	}
	
	
}
if (isset($_GET['from']) && $_GET['from'] == "p") {
	header('Location: ../index.php?page=perso');
}
else{
	header('Location: ../index.php?page=accueil');
}
