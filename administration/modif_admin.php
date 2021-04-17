<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
modif_admin($_POST['id'],$_POST['mdp']);
header('location: ./admin.php?montre=admin"')

?>