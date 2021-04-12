<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
ajout_admin($_POST['log'],$_POST['mdp']);
header('location: ./admin.php?montre=admin"')

?>