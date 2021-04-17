<?php
    session_start();
    if (!isset($_SESSION['log']) ){
        header('location: ../index.php');
    }
    include '../ConnexionBDD.php';
    include './fonction_sql.php';
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
    <div>
    <table>
        <tr>
            <td><a href="./admin.php?montre=admin">Administrateurs</a></td>
            <td><a href="./admin.php?montre=client">Clients</a></td>
            <td><a href="./admin.php?montre=chalet">Mobil-Home</a></td>
            <td><a href="./admin.php?montre=reserv">Réservation</a></td>
        </tr>
    </table>
    <?php
    if (!isset($_GET['montre'])) {
        die();
    }
    switch ($_GET['montre']){
        case "admin":
            
            switch ((isset($_GET['fait']) ? $_GET['fait'] : "lire")){
                case "lire":
                    echo "<a href='./admin.php?montre=admin&fait=ajout'>Ajouter</a>";
                    ?>
                    <table>
                        <tr>
                            <td>Login</td>
                            <td>Mot de Passe</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    global $conn;
                    $effet = $conn->query('select * from Administrateur');
                    while($ligne = $effet->fetch()){
                        echo "<tr><td>" . $ligne['login_administrateur'] . "</td>";
                        echo "<td>" . $ligne['mdp_administrateur'] . "</td>";
                        echo "<td><a href='./admin.php?montre=admin&fait=modif&i=". $ligne['id'] ."'>Modifier</a></td>";
                        echo "<td><a href='./admin.php?montre=admin&fait=suppr&i=". $ligne['id'] ."'>Supprimer</a></td></tr>"; 
                    }
                    echo "</table>";
                    break;
                
                case "ajout":
                    ?>
                    <form action="./add_admin.php" method="post">
                        <label for="nom">Login :</label>
                        <input type="text" id="log" name="log"><br><br>
                        <label for="nom">Mot de Passe :</label>
                        <input type="text" id="mdp" name="mdp"><br><br>
                        <input type="submit" value="Envoyer">
                    </form>
                    <?php
                    break;

                case "suppr":
                    suppr_admin($_GET['i']);
                    break;

                case "modif":
                    $effet = $conn->query('select * from Administrateur where id = '. $_GET['i'] . ';');
                    $ligne = $effet->fetch();
                    ?>
                    <form action="./modif_admin.php" method="post">
                        Login : <?php echo $ligne['login_administrateur']; ?><br><br>
                        <label for="nom">Mot de Passe :</label>
                        <input type="text" id="mdp" name="mdp" value= "<?php echo $ligne['mdp_administrateur']; ?>" ><br><br>
                        <input type="hidden" name="id" value="<?php echo $_GET['i'];?>">
                        <input type="submit" value="Envoyer">
                    </form>
                    <?php
                    
                    break;
            }
            break;

        case "client":
            switch ((isset($_GET['fait']) ? $_GET['fait'] : "lire")){
                case "lire":
                    echo "<a href='./admin.php?montre=client&fait=ajout'>Ajouter</a>";
                    ?>
                    <table>
                        <tr>
                            <td>Nom</td>
                            <td>Prenom</td>
                            <td>Date de Naissance</td>
                            <td>Telephone</td>
                            <td>Mail</td>
                            <td>Mot de Passe</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    global $conn;
                    $effet = $conn->query('select nom, prenom, date_naissance, mail, mdp_client, telephone from Client;');
                    while($ligne = $effet->fetch()){
                        echo "<tr><td>" . $ligne['nom'] . "</td>";
                        echo "<td>" . $ligne['prenom'] . "</td>";
                        echo "<td>" . $ligne['date_naissance'] . "</td>";
                        echo "<td>" . $ligne['telephone'] . "</td>";
                        echo "<td>" . $ligne['mail'] . "</td>";
                        echo "<td>" . $ligne['mdp_client'] . "</td>";
                        echo "<td><a href='./admin.php?montre=client&fait=modif'>Modifier</a></td>";
                        echo "<td><a href='./admin.php?montre=client&fait=suppr'>Supprimer</a></td>";
                    }
                    break;
            }  
            break;

        case "chalet": 
            switch ((isset($_GET['fait']) ? $_GET['fait'] : "lire")){
                case "lire":
                    echo "<a href='./admin.php?montre=chalet&fait=ajout'>Ajouter</a>";
                    ?>
                    <table>
                        <tr>
                            <td>Numéro</td>
                            <td>Type</td>
                            <td>Prix</td>
                            <td>Etat</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                break;
            }
            break;
    }
    ?>
    </div>
</body>