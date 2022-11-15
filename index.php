<?php session_start();
    include("Donnees.inc.php"); 
    // On inclu le fichier contenant des fonctions utiles (ex : searchSousCategorie, intialisationRecettePourCategorie)
    include("functions.php");
    include("donneeFav.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>index</title>
	<meta charset="utf-8" />
    <link rel="stylesheet"  href="style.css" type="text/css"  media="screen" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>

<body>
    <?php
    if(!isset($_GET['chemin']) || $_GET['chemin'] == null) {
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
        <button onclick="window.location.href = '?page=Accueil&chemin=Aliment'">Navigation</button>
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

      <script>
      function fav(numeroDeRecette){  
        if(document.getElementById(numeroDeRecette).value=="🖤"){           //on change les emoji si besoins
            document.getElementById(numeroDeRecette).value ="❤️";
        }else{
            document.getElementById(numeroDeRecette).value ="🖤";
        }
                
            
            $.ajax({
            url:"actionFav.php",    
            type: "post",    
            data:{"num" : numeroDeRecette}
        });
      }
      </script>
        
   <?php  
            function affichageRecette($recettesPourCategorie){
                include("donneeFav.php") ;

                foreach($recettesPourCategorie as $numeroDeRecette=>$recette){

                    ?>
                    <div class="inner"> 
                        <h2><?php echo $recette['titre']?></h2>
                        <p><?php echo $recette['ingredients'] ?></p>
                        <p><?php echo $recette['preparation'] ?></p>
                            <input id="<?php echo $numeroDeRecette?>" value="🖤"type="button" onclick="fav(this.id)"></input>
                            <?php 
                            if(isset($utilisateur)){
                                foreach($utilisateur as $nomEtRecette){
                                    if($_SESSION["login"]==$nomEtRecette[0]){
                                        if(in_array($numeroDeRecette,$nomEtRecette[1])){ ?>
                                            <script>document.getElementById(<?php echo $numeroDeRecette?>).value ="❤️";</script>
                                      <?php  }
                                }
                            }
                               
                            
                        }?>
                      </div>
                    <?php
                }
            }
         if(isset($_GET['nom'])){
         include("affichageRecettesFav.php");
          }
        else{
         include("affichageRecettes.php");
        }
        ?>
<?php 
        if(isset($_GET['page'])){
            if($_GET['page']=='Accueil'){
                include("affichageRecettesSynthetique.php"); 
            }
            if($_GET['page']=='Profil'){
                include("profil.php");
            }
            if($_GET['page']==='RecetteDetaillee'){
                include("affichageRecetteDetaillee.php");
            }
        }
        else{
            include("affichageRecettesSynthetique.php");
        }?>
    </main>
</body>
</html>