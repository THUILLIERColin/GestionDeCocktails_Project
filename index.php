<?php session_start();
    include("Donnees.inc.php"); 
<<<<<<< Updated upstream
    include("donneeFav.php");
=======
>>>>>>> Stashed changes
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
        <button onclick="window.location.href = '?page=rubrique&nom=fav'">Recette coeur</button>
        <input type="text" name="recherche" placeholder="Rechercher un produit" />
        <input type="submit" value="Rechercher" />
    </div>

    <nav>
        <?php include("navigation.php"); ?>
    </nav>
    <main>
      

        <?php /*function fav($value,$titre,$ing,$prep){  
            
            if(file_exists("donneeFav.php")&&filesize("donneeFav.php")){  //Si le fichier contenant les recettes aimée existe et n'est pas vide on récupere dans un array
                                                                          
               $recetteFav = unserialize(file_get_contents("donneeFav.php"));           
           }else{
              $recetteFav = array();                                    //Sinon on crée un array vide
           }

            $cmp = array (                                              //on remet sous forme d'array nos arguments de notre recette aimée
            'titre' => $titre,
            'ingredients' => $ing,
            'preparation' => $prep,
          ) ;  

            if($value){
               array_push($recetteFav,$cmp);          //on ajoute a notre array recetteFav la recette qui vient d'être aimé
            }
            else{
               $index = array_search($cmp,$recetteFav);
               unset($recetteFav[$index]);    //on retire de notre array recetteFav la recette qui n'ai plus aimée
            }
        
            file_put_contents("donneeFav.php",serialize($recetteFav)); // on crée/ajoute au fichier notre array de recette favorite 
      }
      
        */?>


      <script>  function fav(numeroDeRecette){  
            alert("recette "+numeroDeRecette+" ajoutée au like");
            document.cookie ='recetteFav='+numeroDeRecette;
<<<<<<< Updated upstream
=======
            $.ajax({
            url:"actionFav.php",    //the page containing php script
            type: "post",    //request type,
            data:{"num" : numeroDeRecette}
        });
>>>>>>> Stashed changes
      }
      </script>
        
   <?php  
            function affichageRecette($recettesPourCategorie){
                foreach($recettesPourCategorie as $numeroDeRecette=>$recette){

                    ?>
                    <div class="inner"> 
                        <h2><?php echo $recette['titre']?></h2>
                        <p><?php echo $recette['ingredients'] ?></p>
                        <p><?php echo $recette['preparation'] ?></p>
                            <input id="<?php echo $numeroDeRecette?>" value="&#10084;"type="button" onclick="fav(this.id)"></input>
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