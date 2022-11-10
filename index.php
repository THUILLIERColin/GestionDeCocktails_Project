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
    <h1>Navigation prout</h1>
</header>

    <div id="entete">
        <form method="post" action="?paf=pif">
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