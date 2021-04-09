<?php


	function verificationDate(date $date) {
	}

	function inscription($nom,$prenom,$date_naissance,$mail,$telephone,$adresse,$cp_ville,$mdp_client,$ville) {
		include('./connexionBDD_Denis.php');
		$sql = "INSERT INTO Client (nom, prenom, date_naissance, mail, telephone, adresse, cp_ville, mdp_client, ville) VALUES (:nom, :prenom, :date_naissance, :mail, :telephone, :adresse, :cp_ville, :mdp_client, :ville)";
		$resultat = $conn->prepare($sql);
		$resultat->execute(array('nom' => $nom, 'prenom' => $prenom, 'date_naissance' => $date_naissance, 'mail' => $mail, 'telephone' => $telephone, 'adresse' => $adresse, 'cp_ville' => $cp_ville, '$mdp_client' => $mdp_client, 'ville' => $ville));
		if ($resultat==FALSE) {
			echo "probleme de la requete sql";
		} else {
			$message="Inscription effectuée";
			return $message;
		}
	}

	#si tous les champs sont initialisés
	if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date']) && isset($_POST['mail']) && isset($_POST['telephone']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['mdp']) && isset($_POST['ville'])) {
		#si tous les champs obligatoires contiennent une valeur
		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date']) && !empty($_POST['mail']) && !empty($_POST['cp']) && !empty($_POST['mdp']) && !empty($_POST['ville'])) {
			#bonne taille des String
			if (strlen($_POST['mail'])<=150 && strlen($_POST['telephone'])<=50 && strlen($_POST['cp'])<=50 && strlen($_POST['mdp'])<=30 && strlen($_POST['ville'])<=58) {
	
				#on verra plus tard (trouver une librairie ou créer une fonction)
				if (date_diff($_POST['date'],date('y-m-j'))->format('%a')<1) {
 					
 					#bon format du mail
					if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
						$message = inscription($_POST['nom'],$_POST['prenom'],$_POST['date'],$_POST['mail'],$_POST['telephone'],$_POST['adresse'],$_POST['cp'],$_POST['mdp'],$_POST['ville']);
					} else {
						$message = "Mail invalide";
					}
				} else {
					$message = "Date incorrecte";
				}
			} else {
				$message = "Probleme de taille d'un des champs";
			}
		} else {
			$message = "Un ou plusieurs champs obligatoires vides";
		}
	} else {
?>
<html>
	<!--PARTIE HTML


	#method du formalire en POST et action sur cette page.
	-->
</html>

<?php
	}
?>

