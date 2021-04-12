<?php
//Fonction sql
/* Les tableaux interactions :
    list des administrateur
        ajout x
        modification x
        suppression x
        lire 
    liste des chalets
        ajout x
        suppression x
        lire
    liste des clients
        ajout x
        modification x
        suppression x
        lire
    liste des semaines
    liste des reservation
    liste des prix_spéciaux par chalet par semaine
*/
include 'Connexion_Gaetan.php';

function ajout_admin($login,$mdp) //testé (vérifié les log existant)
{
    global $conn;
    $requette ="INSERT into Administrateur(login_administrateur, mdp_administrateur) values (?, ?);";
    $effet = $conn->prepare($requette);
    $effet->execute(array($login,$mdp));
}

function suppr_admin($id) //testé
{
    global $conn;
    $requette="DELETE from Administrateur where id = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($id));
}

function modif_admin($id,$mdp) //testé
{
    global $conn;
    $requette="UPDATE Administrateur set mdp_administrateur = ? where id = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($mdp,$id));
}

function ajout_chalet($type) //testé
{
    global $conn;
    $requette ="select id_type_chalet from type_chalet where libelle = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($type));
    $ligne =$effet->fetch();
    $requette ="INSERT into Chalet(id_type_chalet) values (?);";
    $effet = $conn->prepare($requette);
    $effet->execute(array($ligne['id_type_chalet']));
}

function suppr_chalet($id) //testé
{
    global $conn;
    $requette="DELETE from Chalet where id_chalet = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($id));
}

function ajout_client($nom, $prenom, $date_naissance, $mail, $telephone, $adresse, $cp_ville, $mdp_client, $ville) //testé
{
    global $conn;
    $requette="INSERT into Client(nom, prenom, date_naissance, mail, telephone, adresse, cp_ville, mdp_client, ville) values (?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $effet = $conn->prepare($requette);
    $effet->execute(array($nom, $prenom, $date_naissance, $mail, $telephone, $adresse, $cp_ville, $mdp_client, $ville));

}

function modif_client($mail, $nom, $prenom, $date_naissance, $telephone, $adresse, $cp_ville, $mdp_client, $ville) //testé
{
    global $conn;
    $requette="UPDATE Client set nom = ? , prenom = ? , date_naissance = ? , telephone = ?, adresse = ? , cp_ville = ?, mdp_client = ?, ville = ? where mail = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($nom, $prenom, $date_naissance, $telephone, $adresse, $cp_ville, $mdp_client, $ville, $mail));
}

function suppr_client($mail) //testé
{
    global $conn;
    $requette="DELETE Client where mail = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($mail));
}

suppr_client("aurelien@epsi.fr");

?>
