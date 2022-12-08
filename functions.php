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
    function verifierMdp(){
        //verification si le user existe grace au nom du fichier
        if (file_exists("DonneesUtilisateur/".$_POST['loginConnexion'].".txt"))
        {
            //ouverture du fichier
            $fichier = fopen("DonneesUtilisateur/".$_POST['loginConnexion'].".txt", "r");
            //lecture du fichier
            $ligne = fgets($fichier);
            //fermeture du fichier
            fclose($fichier);
            //decoupage de la ligne
            $tab = explode("&", $ligne);
            //verification du mot de passe
            $tab1 = explode("=", $tab[1]);
            if (verifyHashMDP($_POST["mdpConnexion"], $tab1[1]))
            {
                //si le mot de passe est bon on ouvre la session
                $_SESSION['user']['login'] = $_POST["loginConnexion"];

                importationTempsVersFichier();

                //on redirige vers la page d'accueil
                header("Location: index.php");
            }
            else
            {
                //si le mot de passe est mauvais on affiche un message d'erreur
                echo "Mot de passe incorrect";
            }
        }
        else
        {
            //si le nom d'utilisateur n'existe pas on affiche un message d'erreur
            echo "Nom d'utilisateur incorrect";
        }
   }

   function retrouverDonneeUserNom(){
       //ouverture du fichier
       $fichier = fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt", "r");
       //lecture du fichier
       $ligne = fgets($fichier);
       //fermeture du fichier
       fclose($fichier);
       //decoupage de la ligne
       $tab = explode("&", $ligne);
       //decoupage du $tab
       $tab2 = explode("=", $tab[2]);
       //on stocke le nom dans la session
       $_SESSION['user']['nom']=$tab2[1];

   }
   
   function retrouverDonneeUserPrenom(){
       //ouverture du fichier
       $fichier = fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt", "r");
       //lecture du fichier
       $ligne = fgets($fichier);
       //fermeture du fichier
       fclose($fichier);
       //decoupage de la ligne
       $tab = explode("&", $ligne);
       //decoupage du $tab
       $tab2 = explode("=", $tab[3]);
       //on stocke le prenom dans la session
       $_SESSION['user']['prenom']=$tab2[1];
   }

   function retrouverDonneeUserSexe(){
       //ouverture du fichier
       $fichier = fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt", "r");
       //lecture du fichier
       $ligne = fgets($fichier);
       //fermeture du fichier
       fclose($fichier);
       //decoupage de la ligne
       $tab = explode("&", $ligne);
      //decoupage du $tab
       $tab2 = explode("=", $tab[4]);
       //on stocke le sexe dans la session
       $_SESSION['user']['sexe']=$tab2[1];
   }

   function retrouverDonneeUserDate(){
       //ouverture du fichier
       $fichier = fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt", "r");
       //lecture du fichier
       $ligne = fgets($fichier);
       //fermeture du fichier
       fclose($fichier);
       //decoupage de la ligne
       $tab = explode("&", $ligne);
       //decoupage du $tab
       $tab2 = explode("=", $tab[5]);
       //on stocke la date dans la session
       $_SESSION['user']['date']=$tab2[1];
   }

   /*
   *  Fonction verifie si l'alliment est reconnu dans la hierarchie
   */
   function estReconnue($alimentDeRecherche){
       global $recettesParCategorie;
       foreach($recettesParCategorie as $aliment => $recettes){
           // On compare les deux chaines de caractères
           if(strcmp($alimentDeRecherche,$aliment)==0){
               return true;
           }
       }
       return false;
   }
   //ecriture de la fonction de cryptage password_hash($mdp,$algo)
   function hashageMDP($password){
        return md5($password); //on retourne le mot de passe crypté
             
   }



    function verifyHashMDP($nouveauMDP, $ancienMDP) {
            $new_hash = hashageMDP($nouveauMDP); //on crypte le nouveau mot de passe
            return ($new_hash == $ancienMDP); //on compare le nouveau mot de passe crypté avec l'ancien mot de passe crypté
    }

?>