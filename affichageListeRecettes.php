<?php   
    
    // Il faut créer un fichier de données avec les fruits en entrée puis chaque 
    // fruit est un tableau contenant les recettes qui match avec les fruits

    // Créer un fichier de données avec les recettes pour chaque categorie
    function intialisationRecettePourCategorie($hierarchie, $recettes){
        $tableInit = array();
        foreach($hierarchie as $categorie => $sousSupCategories){
            foreach($recettes as $indiceRecette => $ingredients){
                if(in_array($categorie, $recettes[$indiceRecette]['index'])){
                    $tableInit[$categorie][] = $indiceRecette;
                }
            }
        }
        file_put_contents('initialisation.inc.php', '<?php $recettesParCategorie = '.var_export($tableInit, true).';');
    }

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
    function affichageRecette($recettes){
        /*$chemin = $_GET['chemin'];
                echo "chemin : ".$chemin; echo "<br>";
                include("initialisation.inc.php");
                print_r($recettesParCategorie[$chemin]);
                foreach($recettesParCategorie[$chemin] as $recetteCat){
                    $recette = $recettes[$recetteCat];*/
    ?>
        <div id='recette'>
            <div class='outer'><?php
            foreach($recettes as $recette){
    
                /* A supprimer qaund fini */
                $image = str_replace(' ', '_', $recette['titre']);
                echo "image = ".$image; echo "<br>";
                
                ?>
                <div class="inner">
                    <h2><?php echo $recette['titre'] ?></h2>
                    <img src=<?php echo '"'.searchImageRecette($recette).'"'?> alt="image de <?php echo searchImageRecette($recette) ?>" />
                    <p><?php echo $recette['ingredients'] ?></p>
                    <p><?php echo $recette['preparation'] ?></p>
                </div><?php
            }?>
            </div>
        </div><?php
    }?>
<?php
    // utiliser strtr pour trouver les images correspondantes aux cocktails

    if(!file_exists('initialisation.inc.php')){
        intialisationRecettePourCategorie($hierarchie, $recettes);
    }
    else {
        include('initialisation.inc.php');
    }


?>
<?php 
// Parcours des recettes :   
affichageRecette($recettes);
?>
    