<?php
session_start();

if (isset($_GET['id'])) {
	require_once '../modele/annul.php';
	$bdd = Bdd::getInstance();
	if (AnnulerFormation($bdd, $_SESSION['name'], $_SESSION['fname'], $_GET['id'])) {
		$_SESSION['succes'] = "Votre formation à ete annulé avec succes";
	}
	else{
		$_SESSION['error'] = "Une arreur est survenu lors de l'annulation de votre formation";
	}
}

header("location: ../index.php?page=perso");