<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Page qui ser à tester</title>
</head>
<body>
    <form action="./verif_login.php" method="get">
        <input type="hidden" name="log" value="Robert">
        <input type="hidden" name="mdp" value="Vert">
        <input type="submit" value="Envoyer">
    </form>
    <?php 
    $date_now = new DateTime("now");
    $today_string = $date_now->format("Y-m-d");
    echo $today_string;
    ?>
</body>