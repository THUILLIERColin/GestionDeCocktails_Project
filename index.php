<?php session_start();
    include("donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include("functions.php");  ?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
</head>

<body>
    <?php
    if(empty($_GET['chemin'])){
        // Si la variable n'est pas initialiser ou vide on la met sur Aliment
        $_GET['chemin']='Aliment';
        $chemin = array( 0 => 'Aliment');
    }
    else{
        // On explose la variable chemin pour pouvoir la parcourir plus facilement
        $chemin = explode(',', $_GET['chemin']);
        // $chemin = preg_split("/,+/",$_GET['chemin']);
    }

    /* 
    * Verifie si le fichier existe si oui il l'inclu, si non il le crée 
    * Le fichier contiendra un tableau
    * Le tableau contiendra les recettes qui match avec la catégorie
    */
    if(!file_exists('initialisation.inc.php')){
        intialisationRecettePourCategorie();
    }
    else {
        include('initialisation.inc.php');
    }
    
    ?>

<header>
    <h1>Bienvenue sur le site de cockails</h1>
</header>

    <div id="entete">
        <button onclick="window.location.href = '?page=Acceuil&chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=Profil&nom=fav'">Recette coeur</button>
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
        if(isset($_GET['page'])){
            if($_GET['page']=='Acceuil'){
                include("affichageRecettesSynthetique.php"); 
            }
            if($_GET['page']=='Profil'){
                include("profil.php");
            }
            if($_GET['page']=='RecetteDetaillee'){
                include("affichageRecetteDetaillee.php");
            }
        }
        else{
            include("affichageRecettesSynthetique.php");
        }
        // truc de pierre -> 
        /*
         if(isset($_GET['nom'])){
         include("recetteFav.php");
          }
        else{
         include("recette.php");
        }
           */?>
    </main>
</body>
</html>