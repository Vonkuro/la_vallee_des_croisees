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
            <td><a href="./admin.php?montre=semmaine">Semmaines</a></td>
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
                        <label for="log">Login :</label>
                        <input type="text" id="log" name="log"><br><br>
                        <label for="mdp">Mot de Passe :</label>
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
                    $effet = $conn->query('select nom, prenom, date_naissance, mail, mdp_client, telephone, id_client from Client;');
                    while($ligne = $effet->fetch()){
                        echo "<tr><td>" . $ligne['nom'] . "</td>";
                        echo "<td>" . $ligne['prenom'] . "</td>";
                        echo "<td>" . $ligne['date_naissance'] . "</td>";
                        echo "<td>" . $ligne['telephone'] . "</td>";
                        echo "<td>" . $ligne['mail'] . "</td>";
                        echo "<td>" . $ligne['mdp_client'] . "</td>";
                        echo "<td><a href='./admin.php?montre=client&fait=modif&i=". $ligne['id_client'] ."'>Modifier</a></td>";
                        echo "<td><a href='./admin.php?montre=client&fait=suppr&i=". $ligne['id_client'] ."'>Supprimer</a></td>";
                    }
                    break;

                case "ajout":
                    ?>
                    <form action="./add_client.php" method="post">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom"><br><br>

                        <label for="prenom">Prenom :</label>
                        <input type="text" id="prenom" name="prenom"><br><br>

                        <label for="date">Date de Naissance :</label>
                        <input type="date" id="date" name="date"><br><br>

                        <label for="tel">Telephone :</label>
                        <input type="text" id="tel" name="tel"><br><br>

                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="adresse"><br><br>

                        <label for="cp">Code Postal :</label>
                        <input type="text" id="cp" name="cp"><br><br>

                        <label for="ville">Ville :</label>
                        <input type="text" id="ville" name="ville"><br><br>

                        <label for="mail">Mail :</label>
                        <input type="text" id="mail" name="mail"><br><br>

                        <label for="mdp">Mot de Passe :</label>
                        <input type="text" id="mdp" name="mdp"><br><br>
                        <input type="submit" value="Envoyer">
                    </form>
                    <?php
                    break;
                case "suppr":
                    suppr_client($_GET['i']);
                    break;

                case "modif":
                    $effet = $conn->query('select * from Client where id_client = '. $_GET['i'] . ';');
                    $ligne = $effet->fetch();
                     ?>
                    <form action="./modif_client.php" method="post">
                        

                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" value= "<?php echo $ligne['nom']; ?>" ><br><br>

                        <label for="prenom">Prenom :</label>
                        <input type="text" id="prenom" name="prenom" value= "<?php echo $ligne['prenom']; ?>" ><br><br>

                        <label for="date">Date de Naissance:</label>
                        <input type="date" id="date" name="date" value= "<?php echo $ligne['date_naissance']; ?>" ><br><br>

                        <label for="telephone">Telephone :</label>
                        <input type="text" id="telephone" name="telephone" value= "<?php echo $ligne['telephone']; ?>" ><br><br>

                        Mail : <?php echo $ligne['mail']; ?><br><br>
                        <input type="hidden" id="mail" name="mail" value= "<?php echo $ligne['mail']; ?>" >

                        <label for="adresse">Adresse :</label>
                        <input type="text" id="adresse" name="adresse" value= "<?php echo $ligne['adresse']; ?>" ><br><br>

                        <label for="ville">Ville :</label>
                        <input type="text" id="ville" name="ville" value= "<?php echo $ligne['ville']; ?>" ><br><br>

                        <label for="cp">Code Postal :</label>
                        <input type="text" id="cp" name="cp" value= "<?php echo $ligne['cp_ville']; ?>" ><br><br>

                        <label for="nom">Mot de Passe :</label>
                        <input type="text" id="mdp" name="mdp" value= "<?php echo $ligne['mdp_client']; ?>" ><br><br>
                        
                        <input type="submit" value="Envoyer">
                    </form>
                    <?php
                        
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
                    /*
                    global $conn;
                    $list_Id_Chalet = [];
                    $effet = $conn->query('select Chalet.id_chalet, libelle, prix_base from Chalet, type_chalet where Chalet.id_chalet = type_chalet.id_chalet ;');
                    while($ligne = $effet->fetch()){
                        echo "<tr><td>" . $ligne['id_chalet'] . "</td>";
                        echo "<td>" . $ligne['libelle'] . "</td>";
                        $prix_sql = 'select prix_modifie, taux from  ;'
                        echo "<td><a href='./admin.php?montre=client&fait=modif&i=". $ligne['id_client'] ."'>Modifier</a></td>";
                        echo "<td><a href='./admin.php?montre=client&fait=suppr&i=". $ligne['id_client'] ."'>Supprimer</a></td>";
                    }*/
                break;
            }
            break;

        case "semmaine":
            switch ((isset($_GET['fait']) ? $_GET['fait'] : "lire")){
                case "lire":
                    echo "<a href='./admin.php?montre=semmaine&fait=ajout'>Ajouter</a>";
                    ?>
                    <table>
                        <tr>
                            <td>Numéro</td>
                            <td>Date Début</td>
                            <td>Date Fin</td>
                            <td>Saison</td>
                            <td>Année</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php
                    global $conn;
                    $effet = $conn->query('select id_semaine, numero_semaine, date_debut, date_fin, annee, type from Semaine, Saison where Semaine.id_saison = Saison.id_saison;');
                    while($ligne = $effet->fetch()){
                        echo "<tr><td>" . $ligne['numero_semaine'] . "</td>";
                        echo "<td>" . $ligne['date_debut'] . "</td>";
                        echo "<td>" . $ligne['date_fin'] . "</td>";
                        echo "<td>" . $ligne['type'] . "</td>";
                        echo "<td>" . $ligne['annee'] . "</td>";
                        echo "<td><a href='./admin.php?montre=semmaine&fait=modif&i=". $ligne['id_semaine'] ."'>Modifier</a></td>";
                        echo "<td><a href='./admin.php?montre=semmaine&fait=suppr&i=". $ligne['id_semaine'] ."'>Supprimer</a></td>";
                     }
                    break;
                case "ajout":
                    ?>
                    <form action="./add_semaine.php" method="post">
                        <label for="numero">Numéro :</label>
                        <input type="text" id="numero" name="numero"><br><br>

                        <label for="date_d">Date Début :</label>
                        <input type="date" id="date_d" name="date_d"><br><br>

                        <label for="date_f">Date Fin :</label>
                        <input type="date" id="date_f" name="date_f"><br><br>

                        <label for="saison">Saison :</label><?php //faire une requête ici si saison dynamique ?>
                        <select id="saison" name="saison">
                            <option value="1"> Basse </option>
                            <option value="2"> Moyenne </option> 
                            <option value="3"> Haute </option> 
                        </select><br><br>

                        <label for="annee">Année :</label>
                        <input type="text" id="annee" name="annee"><br><br>

                        <input type="submit" value="Envoyer">
                    </form>
                    <?php
                    break;
                case "suppr":
                    suppr_semaine($_GET['i']);
                    break;

                case "modif":
                    $effet = $conn->query('select id_semaine, numero_semaine, date_debut, date_fin, annee, id_saison from Semaine where id_semaine = '. $_GET['i'] . ';');
                    $ligne = $effet->fetch();
                    ?>
                    <form action="./modif_semaine.php" method="post">
                        <label for="numero">Numéro :</label>
                        <input type="text" id="numero" name="numero" value = <?php echo $ligne["numero_semaine"]; ?>><br><br>

                        <label for="date_d">Date Début :</label>
                        <input type="date" id="date_d" name="date_d" value = <?php echo $ligne["date_debut"]; ?>><br><br>

                        <label for="date_f">Date Fin :</label>
                        <input type="date" id="date_f" name="date_f" value = <?php echo $ligne["date_fin"]; ?>><br><br>

                        <label for="saison">Saison :</label><?php //faire une requête ici si saison dynamique ?>
                        <select id="saison" name="saison" value="selectionner à nouveau la saison">
                            <option value="1" <?php if ($ligne['id_saison'] == 1) {echo "selected='selected'";}?> > Basse </option> 
                            <option value="2" <?php if ($ligne['id_saison'] == 2) {echo "selected='selected'";}?>> Moyenne </option> 
                            <option value="3" <?php if ($ligne['id_saison'] == 3) {echo "selected='selected'";}?>> Haute </option> 
                        </select><br><br>

                        <label for="annee">Année :</label>
                        <input type="text" id="annee" name="annee" value = <?php echo $ligne["annee"]; ?>><br><br>

                        <input type="submit" value="Envoyer">
                    </form>
                    <?php
                    break;
                
            }
            break;
                
    }
    ?>
    </div>
</body>