<?php session_start();
    include("donnees.inc.php"); 
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
</head>

<body>

<header>
    <h1>Navigation</h1>
</header>

    <div id="entete">
        <form method="post" action="">
        <button onclick="window.location.href = '?chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=rubrique&nom=fav'">Recette coeur</button>
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
        </form>
    </div>

    <nav>
        <?php include("navigation.php"); ?>
    </nav>
    <main>
        <?php include("affichageRecettes.php"); ?>
    </main>
</body>
</html>