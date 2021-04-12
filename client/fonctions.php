<?php

function ajoutClient($nom,$prenom,$date_naissance,$mail,$telephone,$adresse,$cp_ville,$mdp_client,$ville) {
		include('../connexionBDD.php');
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
	include('../connexionBDD.php');
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
	include('../connexionBDD.php');
	$sql = "INSERT INTO Reservation (id_client, id_chalet, id_semaine, valide, date_reservation) VALUES (?,?,?,?,?)";
	$resultat=$conn->prepare($sql);
	$resultat->execute(array($idClient, $idChalet, $idSemaine, 'false', date("Y-m-d")));
	if ($resultat==FALSE) {
		echo "probleme de la requete sql";
	} else {
		echo "La réservation a été ajoutée";
	}
}


function Prix_total($idChalet) {
	include('../connexionBDD.php');
	$sql = "SELECT type_chalet.prix_base*Saison.taux+Prix_special.prix_modifie as prix_total FROM type_chalet INNER JOIN chalet ON type_chalet.id_type_chalet=chalet.id_type_chalet INNER JOIN Prix_special ON Chalet.id_chalet=Prix_special.id_chalet INNER JOIN Semaine ON Prix_special.id_semaine=Semaine.id_semaine INNER JOIN Saison ON Semaine.id_saison=Saison.id_saison WHERE id_chalet=?";
	$resultat = $conn ->prepare($sql);
	if ($resultat==FASE) {
		echo "probleme de requete sql";
	} else {
		$donnee=$resultat->fetch();
		return $donnee[0];
	}
}

function listChaletRech($date_debut,$date_fin,$nbrePlace) {
	include('../connexionBDD.php');
	$sql = "SELECT chalet.id_chalet, type_chalet.libelle FROM type_chalet INNER JOIN chalet ON type_chalet.id_type_chalet=chalet.id_type_chalet INNER JOIN Prix_special ON Chalet.id_chalet=Prix_special.id_chalet INNER JOIN Semaine ON Prix_special.id_semaine=Semaine.id_semaine INNER JOIN Saison ON Semaine.id_saison=Saison.id_saison WHERE Semaine.date_debut>? AND Semaine.date_fin<? AND nb_place>?";
	$resultat = $conn->prepare($sql);
	$resultat 
	if ($resultat==FALSE {
		echo "probleme de requete sql";
	} else {
		return $resultat;
	}
}