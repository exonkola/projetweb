<!DOCTYPE >

<html >

    <head>

        <title>Mon blog</title>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <link href="style.css" rel="stylesheet" type="text/css" /> 

    </head>

         

    <body>

        <h1>Mon blog !</h1>

        <p>Derniers billets du blog :</p>

  

<?php

// Connexion à la base de données

try

{

    $bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

}

catch(Exception $e)

{

        die('Erreur : '.$e->getMessage());

}

 

// On récupère les 5 derniers billets

$req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

 

while ($donnees = $req->fetch())

{

?>

<div class="news">

    <h3>

        <?php echo htmlspecialchars($donnees['titre']); ?>

        <em>le <?php echo $donnees['date_creation_fr']; ?></em>

    </h3>

     

    <p>

    <?php

    // On affiche le contenu du billet

    echo nl2br(htmlspecialchars($donnees['contenu']));

    ?>

    <br />

    <em><a href="commentaire.php?billet=<?php echo $donnees['id']; ?>">Commentaire</a></em>

    </p>

</div>

<?php

} // Fin de la boucle des billets

$req->closeCursor();

?>

</body>

</html>