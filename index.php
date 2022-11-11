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
        <button onclick="window.location.href = '?chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=rubrique&nom=fav'">Recette coeur</button>
        <form method="post" action="">
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
        </form>
    </div>

    <nav>
        <?php include("navigation.php"); ?>
    </nav>
    <main>
        <?php
            // Fonction qui affiche les recettes par rapport à la catégorie
            function affichageRecette($recettes){?>
                <div id='recette'>
                    <div class='outer'><?php
                    foreach($recettes as $recette){
                        ?>
                        <div class="inner">
                            <h2><?php echo $recette['titre'] ?></h2>
                            <img src="Photos/cocktail.png" alt="image de <?php echo $recette['titre'] ?>" />
                            <p><?php echo $recette['ingredients'] ?></p>
                            <p><?php echo $recette['preparation'] ?></p>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div><?php
            }
        ?>
        <?php include("affichageListeRecettes.php"); ?>
    </main>
</body>
</html>