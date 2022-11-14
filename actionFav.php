<<<<<<< Updated upstream
<?php file_put_contents("donneeFav.php","ouiouinon",FILE_APPEND); ?>
=======
<?php

 fav();
 function fav(){  
            include("donneeFav.php");
            $numeroDeRecetteFav = $_POST['num'];

            if(file_exists("donneeFav.php")&&filesize("donneeFav.php")){  //Si le fichier contenant les recettes aimée existe et n'est pas vide on récupere dans un array
                 $recetteFavorite = $recettesFavoris;       
           }else{
              $recetteFavorite = array();                                    //Sinon on crée un array vide
           }
               
           
           array_push($recetteFavorite,$numeroDeRecetteFav);          //on ajoute a notre array recetteFav la recette qui vient d'être aimé
        
           
              //$index = array_search($numeroDeRecetteFav,$recetteFav);
               //unset($recetteFav[$index]);    //on retire de notre array recetteFav la recette qui n'ai plus aimée

          
            file_put_contents("donneeFav.php",'<?php $recettesFavoris = '.var_export($recetteFavorite, true).';'.'?>'); // on crée/ajoute au fichier notre array de recette favorite 
        }
        ?>
>>>>>>> Stashed changes
