<?php
	session_start();
	
	if (isset($_GET['deco']))
	{
		setcookie("stayc", "", time()-3600, "/");
		setcookie("identnom","",time()-3600, "/");
		setcookie("ident", "",time()-3600, "/");
	}
	
	if (isset($_COOKIE['stayc']) && $_COOKIE['stayc'] == "true") {
		include_once '/modele/bdd.php';
		$bdd = Bdd::getInstance();
		
		$sql = $bdd->prepare("SELECT * FROM salarie WHERE mdp = :mdp AND mail = :mail");
		$sql->bindValue(':mdp', $_COOKIE['ident']);
		$sql->bindValue(':mail', $_COOKIE['identnom']);
		$sql->execute();
		
		$donnees = $sql;
		if ($donnees->rowCount() > 0) {
			$donnee = $donnees->fetch();
			$_SESSION['name'] = $donnee['nom'];
			$_SESSION['fname'] = $donnee['prenom'];
			$_SESSION['connecte'] = 1;

		}
	}
?>

<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
		M2L Formation
	</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script type="text/javascript">
	$(function () {
		  $('[data-toggle="popover"]').popover()
		})
	</script>
</head>

<body>

<?php
include_once "include/header.inc.php";
?>
<div class='container-fluid' id='maincontent'>
<?php

include_once "controleur/generale.php";

if(!isset($_GET["page"]) && !isset($_SESSION['connecte']))
{
	include_once "include/index.inc.php";
}
elseif (isset($_SESSION['connecte']) && !isset($_GET["page"]))
{
	include 'vue/accueil.php';
}
else
{
	if(file_exists("vue/".$_GET["page"].".php"))
	{
		include "vue/".$_GET["page"].".php";
	}
	else
	{
		include_once "include/error.inc.php";
	}
}
?>
</div>
<?php
include_once "include/footer.inc.php";
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>