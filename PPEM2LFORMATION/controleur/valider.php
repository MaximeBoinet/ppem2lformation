<?php
session_start();
require_once '../modele/valider.php';
$bdd = Bdd::getInstance();

if (isset($_GET['sid']) && isset($_GET['fid'])) {
	if (isset($_GET['act'])) {
		if ($_GET['act'] == "insc") {
			InscrireFormation($bdd, $_GET['sid'], $_GET['fid']);
		}
		elseif ($_GET['act'] == "val"){
			ValiderFormation($bdd, $_GET['sid'], $_GET['fid']);
		}
		else{
			$_SESSION['error'] = "Une erreur est survennu de maniere inopiné";
		}
		
	}
	else{
		$_SESSION['error'] = "Arretez de trifouiller l'url";
	}
}
else{
	$_SESSION['error'] = "Une erreur est survennu de maniere inopiné";
}

header("location: ../index.php?page=perso&act=det&id=".$_GET['sid']);