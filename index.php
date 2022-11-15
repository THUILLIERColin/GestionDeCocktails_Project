<?php session_start();
    include("Donnees.inc.php");
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

<header>
    <h1>Navigation </h1>
   
</header>

    <div id="entete">
        <button onclick="window.location.href = '?chemin=Aliment'">Navigation</button>
        <button onclick="window.location.href = '?page=rubrique&nom=fav'">❤️</button>
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
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
    </main>
</body>
</html>