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

    // Fonction qui affiche les recettes
    function AffichageRecette($recette){
        global $recettes;
        $img = searchImageRecette($recettes[$recette]) // On cherche l'image correspondante à la recette ?>
        <div class="inner">
            <h2><a href="?page=RecetteDetaillee&chemin=<?php echo $_GET['chemin']; ?>&recette=<?php echo $recette ?>" > <?php echo $recettes[$recette]['titre'] ?></a></h2> 
            <img src=<?php echo '"'.$img.'"'?> alt="image de <?php echo $img ?>" />
            <br/>
                <div class="ingredientsRecetteSynthetique"><?php
                    foreach($recettes[$recette]['index'] as $ingredient){
                        echo $ingredient."<br/>";
                    }?>
                </div>
                <input id="<?php echo $recette?>" value="🖤"type="button" class='BoutonAjoutFavoris'></input>
                <?php
                    if(isset($_SESSION["user"]["login"])){
                        if(isset($utilisateur)){
                            foreach($utilisateur as $nomEtRecette){
                                if($_SESSION["user"]["login"]==$nomEtRecette[0]){
                                    if(in_array($recette,$nomEtRecette[1])){ ?>
                                        <script>document.getElementById(<?php echo $recette ?>).value ="❤️";</script><?php
                                    }
                                }
                            }
                        } 
                    }
                    else {
                        if(isset($_SESSION["favTemp"])){
                            if(in_array($recette,$_SESSION["favTemp"])){ ?>
                                <script>document.getElementById(<?php echo $recette ?>).value ="❤️";</script><?php
                            }
                        }
                    }
                    ?>
        </div><?php
    }


?>