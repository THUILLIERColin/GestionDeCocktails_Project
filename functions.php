<?php 

    /* 
    *  Fonction qui cherche les sous catégories de la catégorie courante
    *  Return un tableau de toutes les sous sous catégories de la catégorie courante 
    *  mais il ne contient pas la catégories courante
    */
    function searchSousCategorie($categorieCourante){
        global $hierarchie;
        $resulat = array();
        if(isset($hierarchie[$categorieCourante]['sous-categorie'])){
            foreach($hierarchie[$categorieCourante]['sous-categorie'] as $sousCategories){
                if(isset($hierarchie[$sousCategories]['sous-categorie'])){
                    $resulat[] = $sousCategories;
                    $resulat = array_merge($resulat, searchSousCategorie($sousCategories));
                }
                else {
                    $resulat[] = $sousCategories;
                }
                ?>

                <?php
            }
        }
        return $resulat;
    }

    // Créer un fichier de données contenant les recettes par categorie (ex : Épice[0] => 4)
    function intialisationRecettePourCategorie(){
        global $hierarchie;
        global $recettes;
        $tableInit = array(); // Tableau qui contient les recettes pour chaque categorie
        foreach($hierarchie as $categorie => $sousSupCategories){ // On parcours le tableau hierarchie
            foreach($recettes as $recette => $ingredient){
                if(in_array($categorie,$recettes[$recette]['index'])){
                    $tableInit[$categorie][] = $recette;
                }
                else {
                    if(!isset($tableInit[$categorie])) $tableInit[$categorie] = array();
                    $sousCategories = searchSousCategorie($categorie); // On cherche les sous sous categories de la categorie courante
                    foreach($sousCategories as $sousCategorie){
                        if(in_array($sousCategorie,$recettes[$recette]['index']) && !in_array($recette,$tableInit[$categorie])){
                            $tableInit[$categorie][] = $recette;
                        }
                    }
                }
            }
        }
        // On écrit notre tableau final dans le fichier initialisation.inc.php
        file_put_contents('initialisation.inc.php', '<?php $recettesParCategorie = '.var_export($tableInit, true).';'); 
    }


    // utiliser strtr pour trouver les images correspondantes aux cocktails
    // Fonction qui cherche les images correspondantes aux recettes
    function searchImageRecette($recette){
        $image = "Photos/cocktail.png";
        $nomImage = str_replace(' ', '_', $recette['titre']);
        if(file_exists("Photos/".$nomImage.".jpg")){
            $image = "Photos/".$nomImage.".jpg";
        }
        return $image;
    }



    //---------------------------------------------------------------------------------------------------------------------------
    //          Fonction qui importe les favoris temporaires dans le fichier donneeFav.php a l'indice de l'utilisateur
    //                                         quand l'utilisateur se connecte.
    //---------------------------------------------------------------------------------------------------------------------------

    function importationTempsVersFichier(){
        if(file_exists("donneeFav.php")&&filesize("donneeFav.php")){  //Si le fichier contenant les recettes aimée existe et n'est pas vide
            include("donneeFav.php");                                 //on inclu donneeFav.php pour recuperer l'array $utilisateur qui contient nos données
            foreach($utilisateur as $posUtilisateur=>$nomEtRecetteFav){  //on parcourt tout les utilisateurs( en fonction du login )
                if($_SESSION["user"]["login"]==$nomEtRecetteFav[0]){    // quand on trouve le login de l'utilisateur connecté
                    $posUtilisateurLog=$posUtilisateur;                     //on sauvegarde sa position dans $posUtilisateurLog
                    $recetteFavorite = $utilisateur[$posUtilisateurLog][1];         // on stock dans notre array $recetteFavorite les recettes fav                          
                    $trouve=true;                                                   //  de cet utilisateur et on dit qu'on a trouvé l'utilisateur
                }
            }
            foreach($_SESSION["favTemp"] as $numeroDeRecetteFav){               //Pour chaque numero de recette liké dans la session favTemp
                if(!in_array($numeroDeRecetteFav,$recetteFavorite)){                  //si la recette n'est pas déjà dans le fichier 
                    array_push($recetteFavorite,$numeroDeRecetteFav);          // on ajoute a notre array $recetteFavorite la recette
                }    
            }    
            
             if($trouve){                                                       //si son nom est dans le fichier ( donc il a une liste de recettes)
                $utilisateur[$posUtilisateurLog][1]=$recetteFavorite;           //          on rajoute a son nom les recettes favorites à l'array $utilisateur
             }
             else{                                                             // sinon  (donc il n'y a pas de liste de recettes pour cet utilisateur)
                $recetteFavorite= array();                                             //on crée un array de recetteFvorite
                foreach($_SESSION["favTemp"] as $numeroDeRecetteFav){                   //on met toute les recettes favorites de la session favTemp dans notre array $recettesFavorite
                    array_push($recetteFavorite,$numeroDeRecetteFav);  
                }
                array_push($utilisateur,array(0 => $_SESSION["user"]["login"],$recetteFavorite)); //on ajoute a notre 
             }   
        }
        else { ///si le fichier n'existe pas ou est vide
            $utilisateur = array();     //on crée notre array qui contiendra les utilisateurs
            $recetteFavorite = array(); //on crée notre array qui contiendra les recettes favorites
            foreach($_SESSION["favTemp"] as $numeroDeRecetteFav){   //pour chaque numero de recette favorite contenue dans la session favtemp
                 array_push($recetteFavorite,$numeroDeRecetteFav);          //on les ajoutes à notre array de recettes favorites  
             }
            array_push($utilisateur,array(0 => $_SESSION["user"]["login"],$recetteFavorite));//a la fin on ajoute l'array de recettes
        }                                                                                    // dans l'array utilisateur avec son login

        file_put_contents("donneeFav.php",'<?php $utilisateur = '.var_export($utilisateur, true).';'.'?>'); // on crée/ajoute au fichier notre array de nom + recette favorite 
    }
?>