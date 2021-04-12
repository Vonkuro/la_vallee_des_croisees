<?php

function ajoutClient($nom,$prenom,$date_naissance,$mail,$telephone,$adresse,$cp_ville,$mdp_client,$ville) {
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

function verifDate($date) {
	$dateTab=explode('-',$date);
	if (count($dateTab)==3) {
		return checkdate(intval($dateTab[1]),intval($dateTab[2]),intval($dateTab[0]));	
	} else {
		return false;
	}
}

function verifAge($date) {
	$today=date_create(date("Y-m-d"));
	$dateFormat=date_create($date);
	$age=date_diff($today,$dateFormat);
	return intval($age->format('%y'))>=16;
}

