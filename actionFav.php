<?php
    //on demarre une session 
    session_start();                    
    //on lance notre fonction qui gère les fav 
    fav();                                 
 function fav(){  
           //on récupere le numéro de la recette qu'on vient d'aimer
            $numeroDeRecetteFav = $_POST['num'];        
            //variable qui indique si l'utilisateur est déjà dans le fichier
            $trouve = false;                            
             //Si l'utilisateur est connecté alors
            if(isset($_SESSION["user"]["login"])){                
            //Si le fichier contenant les recettes aimée existe et n'est pas vide 
            //normalement il existe et est rempli (lors de la connexion et donc de l'importation de nos )
            if(file_exists("donneeFav.php")&&filesize("donneeFav.php")){  
                //on inclu le fichier contenant les recettes favorites des utilisateur
                include("donneeFav.php");                                    
                //on parcourt tout les utilisateurs de notre fichier donneeFav.php (contenu dans $utilisateur)
                foreach($utilisateur as $posUtilisateur=>$nomEtRecetteFav){ 
                    //si le login == nom de l'utilisateur
                    if($_SESSION["user"]["login"]==$nomEtRecetteFav[0]){    
                        //on enregistre la position dans le fichier de l'utilisateur connecté
                        $posUtilisateurLog=$posUtilisateur;                        
                        //si le login correspond au nom, on stock dans notre array "recetteFavorite"
                        $recetteFavorite = $utilisateur[$posUtilisateurLog][1];     
                        //   les recettes fav de cet utilisateur provenant du fichier et on indique qu'on a trouvé l'utilisateur
                        $trouve=true;                                              
                    }
                }
                //si la recette est déjà dans le fichier on l'enlève de notre tableau "recetteFavorite"
                if(in_array($numeroDeRecetteFav,$recetteFavorite)){                  
                         unset($recetteFavorite[array_search($numeroDeRecetteFav,$recetteFavorite)]);
                 }
                 //Sinon ajoute a notre array recetteFav la recette qui vient d'être aimé
                 else{
                    array_push($recetteFavorite,$numeroDeRecetteFav);          
                 }
                 //si on a trouvé l'utilisateur dans notre fichier, on remet a sa place l'array utilisateur contenant les recettes de l'utilisateur mises à jour
                 if($trouve){                                                   
                    $utilisateur[$posUtilisateurLog][1]=$recetteFavorite;      
                 }
                
                //si on a pas trouver l'utilisateur dans le fichier 
                if(!$trouve){            
                    //on lui crée un array de recettes preferée                                                               
                    $recetteFavorite= array(); 
                     //on lui ajoute sa recette                                                         
                    array_push($recetteFavorite,$numeroDeRecetteFav);
                     //et on ajoute a l'array d'utilisateur le nouvel utilisateur ainsi que ses recettes favorites
                    array_push($utilisateur,array(0 => $_SESSION["user"]["login"],$recetteFavorite));   
                                                                                                        
                }   
            }else
                //Si le fichier n'existe pas ou est vide
            {        
                
                //on crée un array de recette preferées
                $recetteFavorite = array();     
                // on ajoute sa recette liké dedant
                array_push($recetteFavorite,$numeroDeRecetteFav);  
                //on crée l'array qui contient tout les utilisateurs
                $utilisateur= array();                                                    
                //et on ajoute dedant notre nouvel utilisateur ainsi que son array de recette liké avec sa recette precedemment liké
                array_push($utilisateur,array(0=>$_SESSION["user"]["login"],1=>$recetteFavorite));          
            }                                                                                               
        // on crée si le fichier n'existe pas et on ajoute au fichier notre array de recette favorite 
        file_put_contents("donneeFav.php",'<?php $utilisateur = '.var_export($utilisateur, true).';'.'?>');                                                                                                
        }
        //si l'utilisateur n'est pas connecté alors on va enregistrer ses likes dans une session 
        else{     
             //on recupere l'array des like enregistré dans la session et on le met dans "recetteFavoriteTemp"
                     $recetteFavoriteTemp = $_SESSION["favTemp"];              
                    //si la recette qu'on vient de liker est déjà dedant on l'enlève de notre array
                    if(in_array($numeroDeRecetteFav,$recetteFavoriteTemp)){     
                        unset($recetteFavoriteTemp[array_search($numeroDeRecetteFav,$recetteFavoriteTemp)]);
                    }//sinon on l'ajoute 
                    else{                                                       
                        array_push($recetteFavoriteTemp,$numeroDeRecetteFav);            
                    }
                    //on met a jour la session avec notre array de recettes mis à jour
                $_SESSION['favTemp']=$recetteFavoriteTemp;   
        }                                                
    }
?>