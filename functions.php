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

    function verifierMdp(){
         //verification si le user existe grace au nom du fichier
         if (file_exists("DonneesUtilisateur/".$_POST['login'].".txt"))
         {
             $_SESSION['user']['login']	=$_POST["login"];
             $_SESSION['user']['mdp']	=$_POST["mdp"];
             //ouverture du fichier
             $fichier = fopen("DonneesUtilisateur/".$_SESSION['user']['login'].".txt", "r");
             //lecture du fichier
             $ligne = fgets($fichier);
             //fermeture du fichier
             fclose($fichier);
             //decoupage de la ligne
             $tab = explode("&", $ligne);
             //verification du mot de passe
             $tab1 = explode("=", $tab[1]);
             if (password_verify($_POST["mdp"], $tab1[1]))
             {
                 //si le mot de passe est bon on ouvre la session
                 $_SESSION['user']['login'] = $_POST["login"];
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
        //verification du mot de passe
        $tab2 = explode("=", $tab[2]);
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
    //verification du mot de passe
    $tab2 = explode("=", $tab[3]);
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
    //verification du mot de passe
    $tab2 = explode("=", $tab[4]);
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
    //verification du mot de passe
    $tab2 = explode("=", $tab[5]);
    $_SESSION['user']['date']=$tab2[1];
}

?>