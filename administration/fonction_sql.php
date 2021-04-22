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
include '../ConnexionBDD.php';

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
    $requette ="select id_type_chalet from type_chalet where id_type_chalet = ?;";
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

//ajout_client("Najare", "Aya", "2001-01-01", "fun@prout.com", '0107080905', "572 avenue du mal à la tête", "59126", "rose", "Joie");

function ajout_semaine($numero, $date_d, $date_f, $annee, $saison)//testé
{
    global $conn;
    $requette = "insert into Semaine(numero_semaine, date_debut, date_fin, annee, id_saison) values (?, ?, ?, ?, ?);";
    $effet = $conn->prepare($requette);
    $effet->execute(array($numero, $date_d, $date_f, $annee, $saison));
}

function suppr_semaine($id) //testé
{
    global $conn;
    $requette="DELETE Semaine where id_semaine = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($id));
}

function modif_semaine($numero, $date_d, $date_f, $annee, $saison, $id)
{
    global $conn;
    $requette = "Update Semaine set numero_semaine = ? , date_debut = ?, date_fin = ? , annee = ?, id_saison = ? where id_semaine = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($numero, $date_d, $date_f, $annee, $saison, $id));
}



function date_futur($date_string)
{
    $date_time = new DateTime($date_string);
    $date_now = new DateTime("now");
    if ($date_now <= $date_time) {
        return TRUE;
    }
    return FALSE;
}

function modif_prix($id_chalet, $id_semaine, $prix)
{
    global $conn;
    $requette = "select prix_modifie from prix_special where id_chalet = ? and id_semaine = ? ;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($id_chalet, $id_semaine));
    //$ligne = $effet->fetch();
    if ($effet->rowCount() != 0){
        $requette = "update prix_special set prix_modifie = ? where id_chalet = ? and id_semaine = ? ;";
        $effet = $conn->prepare($requette);
        $effet->execute(array($prix, $id_chalet, $id_semaine));
    }else{
        $requette = "insert into prix_special(prix_modifie,id_chalet,id_semaine) values(?,?,?);";
        $effet = $conn->prepare($requette);
        $effet->execute(array($prix, $id_chalet, $id_semaine));
    }
}

?>

