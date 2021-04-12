<?php
require('fonctions.php');

	
#si tous les champs sont initialisés
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date']) && isset($_POST['mail']) && isset($_POST['telephone']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['mdp']) && isset($_POST['ville'])) {
	#si tous les champs obligatoires contiennent une valeur
	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date']) && !empty($_POST['mail']) && !empty($_POST['cp']) && !empty($_POST['mdp']) && !empty($_POST['ville'])) {
		#bonne taille des String
		if (strlen($_POST['mail'])<=150 && strlen($_POST['telephone'])<=50 && strlen($_POST['cp'])<=50 && strlen($_POST['mdp'])<=30 && strlen($_POST['ville'])<=58) {
			#si la date est conforme
			if (verifDate($_POST['date'])) {
				#Verifie l'âge minimal
				if (verifAge($_POST['date'])) {
						#bon format du mail
					if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
						$message = ajoutClient($_POST['nom'],$_POST['prenom'],$_POST['date'],$_POST['mail'],$_POST['telephone'],$_POST['adresse'],$_POST['cp'],$_POST['mdp'],$_POST['ville']);
					} else {
						$message = "Mail invalide";
					}
				} else {
					$message = "Age erroné (16 ans minimum)";
				}
			} else {
				$message ="Date erronée";	
			}
		} else {
			$message = "Probleme de taille d'un des champs";
		}
	} else {
		$message = "Un ou plusieurs champs obligatoires vides";
	}
}

?>
<html>
	<!--PARTIE HTML


	#method du formalire en POST et action sur cette page.
	-->
</html>


