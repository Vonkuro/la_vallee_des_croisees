<?php
    echo "Page administration";
    session_start();
    if (!isset($_SESSION['log']) ){
        header('location: ../index.php');
    }
    include 'Connexion_Gaetan.php';
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Administration de la vallée des croisés</title>
</head>
<body>
    <div>
        <p>Connecté en tant que : <?php echo $_SESSION['log']; ?></p>
        <p><a href="./logout.php">se déconnecter</a> </p>
    </div>
</body>