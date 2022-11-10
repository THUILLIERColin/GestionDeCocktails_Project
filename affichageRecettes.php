<?php include("donnees.inc.php");?>
    <?php 

    function intialisationRecettePourCategorie($recettes){
        foreach($recettes as $recette){
            echo 'recette'; print_r($recette); echo '<br/>';
            if($recette['categorie']==$_GET['categorie']){
                $recettesPourCategorie[$recette['nom']] = $recette;
            }
        }
    }

    function affichageRecette($recettesPourCategorie){
        echo '<div class="outer">';
        foreach($recettesPourCategorie as $recette){
            ?>
            <div class="inner">
                <h2><?php echo $recette['titre'] ?></h2>
                <p><?php echo $recette['ingredients'] ?></p>
                <p><?php echo $recette['preparation'] ?></p>
            </div>
            <?php
        echo '</div>';
        }
    }
    // Il faut parcourir toutes les sous catégories (même des sous catégories)
    /*
    if(isset($hierarchie[end($_SESSION['historique'])]['sous-categorie'])){
        foreach($hierarchie[end($_SESSION['historique'])]['sous-categorie'] as $ingredient){
            echo $ingredient. '<br/>';
            if(isset($hierarchie[$ingredient]['sous-categorie'])){
                foreach($hierarchie[$ingredient]['sous-categorie'] as $sousIngredient){
                    ?>
                    <li> <?php echo $sousIngredient ?> </li>
                    <?php
                }
            }
        }
    }
    $indiceRecette = array_keys($recettes);
    echo "Affichage indiceRecette"; print_r($indiceRecette); echo '<br/>';
    foreach($indiceRecette as $m => $n){
        echo "n =".$n. '<br/>';
        echo "m =".$m . '</br>';
    }
    */
    ?>

    <?php 
    // Parcours des recettes : ?>
    <div id='recette'>
            <?php 
            affichageRecette($recettes);
            ?>
    </div>
    