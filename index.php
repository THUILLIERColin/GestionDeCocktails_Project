<?php session_start(); $is_start = true; 
    include_once("Donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include_once("functions.php");
    include_once("donneeFav.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
        $(function(){
            $('.BoutonAjoutFavoris').on('click', function(){
                //on change les emoji si besoins
                if($(this).attr('value')=="🖤") $(this).attr('value',"❤️");
                else $(this).attr('value',"🖤");
                $.post("actionFav.php", {'num': this.id}, function(data){
                    console.log(data);
                });
            });
        });
     </script>
</head>

<body>
    <?php
    // Si la variable n'est pas initialiser ou vide on la met sur Aliment
    if(!isset($_GET['chemin']) || $_GET['chemin'] == null) {
        $_GET['chemin']='Aliment';
        $chemin = array( 0 => 'Aliment');
    }
    else{
        $chemin = explode(',', $_GET['chemin']); // On explose la variable chemin pour pouvoir la parcourir plus facilement
    }

    if(!isset($_GET["page"])) $_GET["page"] = "affichageRecettesSynthetique";

    /* 
    * Verifie si le fichier existe si oui il l'inclu, si non il le crée 
    * Le fichier contiendra un tableau
    * Le tableau contiendra les recettes qui match avec la catégorie
    */
    if(!file_exists('initialisation.inc.php')){
        intialisationRecettePourCategorie();
        include_once('initialisation.inc.php');
    }
    else {
        include_once('initialisation.inc.php');
    }
    
    ?>

<header>
    <h1>Bienvenue sur le site de cockails</h1>
</header>

    <div id="entete">
        <button onclick="window.location.href = '?page=Accueil&chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=RecettesFavorites&chemin=<?php echo $_GET["chemin"]; ?>'">Recette coeur</button>
        
        <form method="post" action="">
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
        </form>
    </div>

    <nav>
        <?php
        if(!empty($_POST['recherche'])) include("barreRecherche.php");
        else include('navigation.php');
        ?>
    </nav>
    <main>
        <body>
            <?php
                if(isset($_GET['page'])){
                    if($_GET['page']=='Accueil'){
                        include("affichageRecettesSynthetique.php"); 
                    }
                    if($_GET['page']=='Profil'){
                        include("sonProfil.php");
                    }
                    if($_GET['page']=='Inscription'){
                        include("inscription.php");
                    }
                    if($_GET['page']==='RecetteDetaillee'){
                        include("affichageRecetteDetaillee.php");
                    }
                    if($_GET['page']==='RecettesFavorites'){
                        include("affichageRecettesFav.php");
                    }
                    if($_GET['page']==='RecettesRecherchee'){
                        include("affichageRecettesRecherchee.php");
                    }
                }
                else{
                    include("affichageRecettesSynthetique.php");
                }
            ?>
        </body>
    </main>
</body>
</html>