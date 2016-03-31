<?php
require '/modele/perso.php';

$bdd = Bdd::getInstance();
if (isset($_GET['act']) && $_GET['act'] == "det" && isset($_GET['id'])){
	$lesFormationsDeMonSalarie = RecupLesFormationDeMonSalarie($bdd);
	$monSalarie = RecupUnSalarie($bdd, $_GET['id']);
	$formationsMonSalarieAttentes = RecupLesFormationDeMonSalarieAttente($bdd);
	$formationsMonSalarieAnnulées = RecupLesFormationDeMonSalarieAnnulée($bdd);
	$formationsMonSalarieAchevées = RecupLesFormationDeMonSalarieAchevée($bdd);
}
else {
	$donnees = RecupMesFormationEnCours($bdd);
	$donnees2 = RecupMesSalaries($bdd);
	$donnees3 = RecupMesFormationAttenteInscription($bdd);
	$donnees4 = RecupMesFormationAnnulees($bdd);
	$donnees5 = RecupMesFormationAchevée($bdd);
}