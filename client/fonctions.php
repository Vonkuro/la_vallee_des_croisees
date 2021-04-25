<?php

function ajoutClient($nom,$prenom,$date_naissance,$mail,$telephone,$adresse,$cp_ville,$mdp_client,$ville) {
		include('../connexionBDD.php');
		$sql = "INSERT INTO Client (nom, prenom, date_naissance, mail, telephone, adresse, cp_ville, mdp_client, ville) VALUES (?,?,?,?,?,?,?,?,?)";
		$resultat = $conn->prepare($sql);
		$resultat->execute(array($nom, $prenom, $date_naissance, $mail, $telephone, $adresse, $cp_ville, $mdp_client,$ville));
		if ($resultat==FALSE) {
			die("probleme de requete sql");
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

function ajoutReservation($mailClient, $idChalet, $idSemaine) {
	include('../connexionBDD.php');
	$sql = "SELECT id_client FROM Client WHERE mail=?";
	$resultatId= $conn->prepare($sql);
	$resultatId->execute(array($mailClient));
	$id = $resultatId->fetch();
	$sql = "INSERT INTO Reservation (id_client, id_chalet, id_semaine, valide, date_reservation) VALUES (?,?,?,?,?)";
	$resultat=$conn->prepare($sql);
	$resultat->execute(array($id[0], $idChalet, $idSemaine, 'false', date("Y-m-d")));
	if ($resultat==FALSE) {
		die("probleme de requete sql");
	} else {
		echo "La réservation a été ajoutée";
	}
}


function prix_total($idChalet) {
	include('../connexionBDD.php');
	$sql = "SELECT type_chalet.prix_base*Saison.taux+Prix_special.prix_modifie as prix_total FROM type_chalet INNER JOIN chalet ON type_chalet.id_type_chalet=chalet.id_type_chalet INNER JOIN Prix_special ON Chalet.id_chalet=Prix_special.id_chalet INNER JOIN Semaine ON Prix_special.id_semaine=Semaine.id_semaine INNER JOIN Saison ON Semaine.id_saison=Saison.id_saison WHERE chalet.id_chalet=?";
	$resultat = $conn ->prepare($sql);
	$resultat->execute(array($idChalet));
	if ($resultat==FALSE) {
		die("probleme de requete sql");
	} else {
		$donnee=$resultat->fetch();
		
		return $donnee[0];
	}
}

function listChaletRech($date_debut,$date_fin,$nb_place) {
	include('../connexionBDD.php');
	$sql = "SELECT Semaine.date_debut, Semaine.date_fin, chalet.id_chalet, type_chalet.libelle, type_chalet.id_type_chalet, Semaine.id_semaine FROM type_chalet INNER JOIN Chalet ON type_chalet.id_type_chalet=chalet.id_type_chalet INNER JOIN Prix_special ON Chalet.id_chalet=Prix_special.id_chalet INNER JOIN Semaine ON Prix_special.id_semaine=Semaine.id_semaine INNER JOIN Saison ON Semaine.id_saison=Saison.id_saison WHERE nb_place>=:nb_place AND ((Semaine.date_debut<=:date_debut1 AND Semaine.date_fin>=:date_fin1) OR (Semaine.date_debut<=:date_debut2 AND Semaine.date_fin>=:date_debut3) OR (Semaine.date_debut>=:date_debut4 AND Semaine.date_fin<=:date_fin2) OR (Semaine.date_debut<=:date_fin3 AND Semaine.date_fin>=:date_fin4))";
	$resultat = $conn->prepare($sql);
	$resultat->execute(array('nb_place' => $nb_place, 'date_debut1' => $date_debut, 'date_fin1' => $date_fin, 'date_debut2' => $date_debut, 'date_debut3' => $date_debut, 'date_debut4' => $date_debut,'date_fin2' => $date_fin, 'date_fin3' => $date_fin, 'date_fin4' => $date_fin));
	if ($resultat==FALSE) {
		die("probleme de requete sql");
	} else {
		return $resultat;
	}
}

function descriptionChalet($idTypeChalet) {
	if ($idTypeChalet==1) {
		echo "description 1";
 	} elseif ($idTypeChalet==2) {
 		echo "description 2";
 	} elseif ($idTypeChalet==3) {
 		echo "description 3";
 	} else {
 		echo "Id type chalet $idTypeChalet non présent";
 	}
}

function reservationdejafaite($mailClient, $idChalet, $idSemaine) {
	include('../connexionBDD.php');

	$sql = "SELECT id_client FROM Client WHERE mail=?";
	$resultatId= $conn->prepare($sql);
	$resultatId->execute(array($mailClient));
	$id = $resultatId->fetch();
	$sql = "SELECT * FROM Reservation where id_chalet=? AND id_client=? AND id_semaine=?";
	$resultat=$conn->prepare($sql);

	$resultat->execute(array($idChalet,$id[0],$idSemaine));
	if ($resultat==FALSE) {
		die("probleme de requete sql");
	} else {
		$donnees=$resultat->fetch();
		if ($donnees==FALSE) {
			return $donnees;
		} else {
			return TRUE;
		}
	}
}

function chaletReserve($idChalet, $idSemaine) {
	include('../connexionBDD.php');
	$sql = "SELECT * FROM Reservation WHERE id_chalet= ? AND id_semaine=?";
	$resultat=$conn->prepare($sql);
	$resultat->execute(array($idChalet, $idSemaine));
	if ($resultat==FALSE) {
		die("probleme de requete sql");
	} else {
		$donnees=$resultat->fetch();
		if ($donnees==FALSE) {
			return $donnees;
		} else {
			return TRUE;
		}
	}
}

function etatChalet($mail_client, $idChalet, $idSemaine) {
	#verifier si le chalet est déja réservé
	if (!chaletreserve($idChalet,$idSemaine)) {
		return True;
	} else {
		#Verifier si c'est le client qui l'a réservé
		if (reservationdejafaite($mail_client,$idChalet,$idSemaine)) {

			echo "Vous avez déjà réservé le chalet";
			return False;
		} else {

			echo "Le chalet a déja été réservé";
			return False;
		}
	}
}