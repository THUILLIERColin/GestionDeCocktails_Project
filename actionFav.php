<?php
session_start();
$_SESSION["user"]["login"] = "nom";
 fav();
 function fav(){  
            include("donneeFav.php");
            $numeroDeRecetteFav = $_POST['num'];
            $trouve = false;

        if(isset($_SESSION["user"]["login"])){                //Si l'utilisateur est connecté alors

            if(file_exists("donneeFav.php")&&(filesize("donneeFav.php"))){  //Si le fichier contenant les recettes aimée existe et n'est pas vide on récupere l'aaray des reecttes aimée de l'utilisateur dans un array 
                
                foreach($utilisateur as $posUtilisateur=>$nomEtRecetteFav){
                    if($_SESSION["user"]["login"]==$nomEtRecetteFav[0]){    //si le login == nom de l'utilisateur
                        $posUtilisateurLog=$posUtilisateur;
                        $recetteFavorite = $utilisateur[$posUtilisateurLog][1];                //si le login correspond au nom, on stock dans notre array les recettes fav de cet utilisateur
                        $trouve=true;
                    }
                if(in_array($numeroDeRecetteFav,$recetteFavorite)){
                         unset($recetteFavorite[array_search($numeroDeRecetteFav,$recetteFavorite)]);
                 }
                 else{
                    array_push($recetteFavorite,$numeroDeRecetteFav);          //Si on ajoute a notre array recetteFav la recette qui vient d'être aimé
                 }
                 if($trouve){
                    $utilisateur[$posUtilisateurLog][1]=$recetteFavorite;
                 }
                }

                if(!$trouve){
                    $recetteFavorite= array();
                    array_push($recetteFavorite,$numeroDeRecetteFav);
                    array_push($utilisateur,array(0 => $_SESSION["user"]["login"],$recetteFavorite));
                }   
            }else
            {        
                //Si le fichier et vide ou inexistant
                $recetteFavorite = array();
                array_push($recetteFavorite,$numeroDeRecetteFav);
                $utilisateur= array();             
                array_push($utilisateur,array(0=>$_SESSION["user"]["login"],1=>$recetteFavorite));
            }
        file_put_contents("donneeFav.php",'<?php $utilisateur = '.var_export($utilisateur, true).';'.'?>'); // on crée/ajoute au fichier notre array de recette favorite 
        }
        else{                                                               //COOKIE 
            //array_push($utilisateur,array()) ;
        }
    }
?>