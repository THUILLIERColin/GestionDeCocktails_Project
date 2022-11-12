<?php 
    /* 
    * Fonction qui affiche la recette en détail
    * Il l'obtient grâce à l'indice de la recette dans $_GET['recette']
    */

    // Je dois garder une fonction ou bien c'est mieux de juste mettre le code brut ?
    function affichageRecettesDetaillee(){ 
        global $recettes;
        if(isset($_GET['recette'])){
            $tableIngredients = explode("|", $recettes[$_GET['recette']]['ingredients']);
            $img = searchImageRecette($recettes[$_GET['recette']])?>
            <div class="recette">
                <h1><?php echo $recettes[$_GET['recette']]['titre'] ?></h1><?php 
                if($img != 'Photos/cocktail.png'){?>
                    <img src=<?php echo '"'.$img.'"'?> alt="image de <?php echo $img ?>" />
                    <br/><?php 
                }?>
                <ul><?php 
                    foreach($tableIngredients as $ingredient){
                        ?>
                        <li><?php echo $ingredient ?></li>
                        <?php
                    }
                ?></ul>
                <p><?php echo $recettes[$_GET['recette']]['preparation'] ?></p>   
            </div>
        <?php
        }
        else {
            echo 'Erreur : Aucune recette sélectionnée'; 
        }
    }

    affichageRecettesDetaillee();
?>