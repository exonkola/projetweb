<!DOCTYPE ">

<html >

    <head>

        <title>Mon blog</title>

        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <link href="style.css" rel="stylesheet" type="text/css" /> 

    </head>

         

    <body>

        <h1>Mon super blog !</h1>

        <p><a href="index.php">liste des billets</a></p>

  

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

 

// Récupération du billet

$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets WHERE id = ?');

$req->execute(array($_GET['billet']));

$donnees = $req->fetch();

?>

 

<div class="news">

    <h3>

        <?php echo htmlspecialchars($donnees['titre']); ?>

        <em>le <?php echo $donnees['date_creation_fr']; ?></em>

    </h3>

     

    <p>

    <?php

    echo nl2br(htmlspecialchars($donnees['contenu']));

    ?>

    </p>

</div>

<form method="POST">
	   
	   <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
	   <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
	</form>

 

<h2>Commentaires</h2>

 

<?php

$req->closeCursor(); 

 

// Récupération des commentaires

$req = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM commentaires WHERE id_billet = ? ORDER BY date_commentaire');

$req->execute(array($_GET['billet']));

 

while ($donnees = $req->fetch())

{

?>

<p><strong><?php echo htmlspecialchars($donnees['auteur']); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>

<p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>

<?php

} // Fin de la boucle des commentaires

$req->closeCursor();

?>

</body>

</html>