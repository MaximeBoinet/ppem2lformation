<?php
session_start();

if (isset($_POST['stayc'])) {
	setcookie("stayc", "true", time()+365*24*3600,"/");
	setcookie("identnom", $_POST['identifiant'], time()+365*24*3600,"/");
	setcookie("ident", $_POST['pswd'], time()+365*24*3600,"/");
	
}

if (!empty($_POST['identifiant']) && !empty($_POST['pswd'])){
	if (!filter_var($_POST['identifiant'], FILTER_VALIDATE_EMAIL))
		$error = "Votre identifiant doit être un email valide";
}
else{
	$error = "Veuillez remplir correctement le formulaire";
}
	
if (isset($error))
{
	$_SESSION['error'] = $error;
	header('Location: ../index.php');
}
else
{
	include_once '../modele/connection.php';
	$bdd = Bdd::getInstance();
	$donnees = VerifId($bdd,$_POST['pswd'],$_POST['identifiant']);
	if ($donnees->rowCount() > 0) {
		$donnee = $donnees->fetch();
		$_SESSION['name'] = $donnee['nom'];
		$_SESSION['fname'] = $donnee['prenom'];
		$_SESSION['connecte'] = 1;
		header( "Location: ../index.php?page=accueil" );
	}
	else {
		$error = "Identifiant incorrect";
		$_SESSION['error'] = $error;
		header('Location: ../index.php');
	}
}