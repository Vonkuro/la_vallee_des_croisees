<?php

function ajoutClient($nom,$prenom,$date_naissance,$mail,$telephone,$adresse,$cp_ville,$mdp_client,$ville) {
		include('./connexionBDD_Denis.php');
		$sql = "INSERT INTO Client (nom, prenom, date_naissance, mail, telephone, adresse, cp_ville, mdp_client, ville) VALUES (?,?,?,?,?,?,?,?,?)";
		$resultat = $conn->prepare($sql);
		$resultat->execute(array($nom, $prenom, $date_naissance, $mail, $telephone, $adresse, $cp_ville, $mdp_client,$ville));
		if ($resultat==FALSE) {
			echo "probleme de la requete sql";
		} else {
			$message="Inscription effectuée";
			return $message;
		}
	}

function nonUniqueMail($mail) {
	include('./connexionBDD_Denis.php');
	$sql = "SELECT * FROM Client WHERE mail=?";
	$resultat=$conn->prepare($sql);
	$resultat->execute(array($mail));
	return $resultat;
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

function ajoutReservation($idClient, $idChalet, $idSemaine) {
	include('./connexionBDD_Denis.php');
	$sql = "INSERT INTO Reservation (id_client, id_chalet, id_semaine, valide, date_reservation) VALUES (:id_client, :id_chalet, :id_semaine, :valide, :date_reservation)";
	$resultat=$conn->prepare($sql);
	$resultat->execute(array('idclient' => $idClient, 'id_chalet' => $idChalet, 'id_semaine' => $idSemaine, 'valide' => 'false', 'date_reservation' => date("Y-m-d")));
	if ($resultat==FALSE) {
		echo "probleme de la requete sql";
	} else {
		echo "La réservation a été ajoutée";
	}
}


