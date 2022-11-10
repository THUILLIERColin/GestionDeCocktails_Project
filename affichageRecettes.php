<?php include("donnees.inc.php");?>
    <?php 
    // Il faut parcourir toutes les sous catégories (même des sous catégories)
    
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
    
    ?>


    <div id='recette'>

    <?php 
    // Parcours des recettes : 
    foreach($recettes as $numeroRecette => $recette)
    {?>

    <table class="infobox" style="width:22em;border-spacing: 2px 5px; float: right;">
        <tbody>
            <tr>
                <th colspan="2">
                    <?php echo $recette['titre']."\n"; ?>
                </th>
            </tr>
        </tbody>
    </table>
                
    <?php  
    } ?>

    </div>