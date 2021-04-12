<?php
session_start();
include '../ConnexionBDD.php';
function verification($user, $pwd)
{
    global $conn;
    $requette="select mail, mdp_client from Client where mail = ? and mdp_client = ?;";
    $effet = $conn->prepare($requette);
    $effet->execute(array($user, $pwd));
    $ligne = $effet->fetch();
    if(isset($ligne['mail'])){
        return "client";
    }
    else{
        $requette="select login_administrateur, mdp_administrateur from Administrateur where login_administrateur = ? and mdp_administrateur = ?;";
        $effet = $conn->prepare($requette);
        $effet->execute(array($user, $pwd));
        $ligne = $effet->fetch();
        if(isset($ligne['login_administrateur'])){
            return "admin";
        } else{
            return "inconnu";
        }
    }
}

$verif = verification($_GET["log"], $_GET["mdp"]);
if ($verif == "inconnu"){
    header('location: ../index.php');
}elseif($verif == "client"){
    $_SESSION["mail"]= $_GET["log"];
    header('location: ../index.php');
}elseif($verif == "admin"){
    $_SESSION["log"]= $_GET["log"];
    header('location: ./admin.php');
}

?>