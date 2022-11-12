<?php   

    /* 
    *  Fonction qui cherche les sous catégories de la catégorie actuelle
    *  Return un tableau de toutes les sous sous catégories de la catégorie actuelle 
    *  mais il ne contient pas la catégories actuelle
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
    
    // Il faut créer un fichier de données avec les fruits en entrée puis chaque 
    // fruit est un tableau contenant les recettes qui match avec les fruits

    // Créer un fichier de données avec les recettes pour chaque categorie
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
                    $sousCategories = searchSousCategorie($categorie); // On cherche les sous sous categories de la categorie actuelle
                    foreach($sousCategories as $sousCategorie){
                        if(in_array($sousCategorie,$recettes[$recette]['index']) && !in_array($recette,$tableInit[$categorie])){
                            $tableInit[$categorie][] = $recette;
                        }
                    }
                }
            }
        }
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
    
    // Fonction qui affiche les recettes par rapport à la catégorie
    function affichageRecette($categorieCourante){
        global $recettes;
        global $recettesParCategorie;?>
        <div id='recette'>
            <div class='outer'><?php
            foreach($recettes as $indiceRecette => $recette){
                if(in_array($indiceRecette, $recettesParCategorie[$categorieCourante])){
                    $img = searchImageRecette($recette)?>
                    <div class="inner">
                        <h2><a href="?page=RecetteDetaillee&recette=<?php echo $indiceRecette ?>" > <?php echo $recette['titre'] ?></a></h2>
                        <img src=<?php echo '"'.$img.'"'?> alt="image de <?php echo $img ?>" />
                        <br/>
                        <div class="ingredientsRecetteSynthetique">
                            <?php
                            foreach($recette['index'] as $ingredient){
                                echo $ingredient."<br/>";
                            }?>
                        </div>
                    </div><?php
                }
            }?>
            </div>
        </div><?php
    }?>

<?php
    // Verifie si le fichier existe si non il le crée 
    // Le fichier contiendra un tableau avec les recettes par catégorie
    if(!file_exists('initialisation.inc.php')){
        intialisationRecettePourCategorie();
    }
    else {
        include('initialisation.inc.php');
    }?>

<?php affichageRecette(end($chemin)); ?>