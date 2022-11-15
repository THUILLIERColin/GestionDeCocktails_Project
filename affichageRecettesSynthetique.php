<?php 
    
    /*
    * Fonction qui affiche toutes les recettes par rapport à la catégorie courante
    */

    // Je dois garder une fonction ou bien c'est mieux de juste mettre le code brut ?
    function affichageRecettesSynthetique(){
        global $recettes;  // Tableau qui contient toutes les recettes
        global $recettesParCategorie; // Tableau qui contient les recettes pour chaque categorie
        global $chemin; $categorieCourante = end($chemin); // On récupère la catégorie courante ?>
        <div id='recette'>
            <div class='outer'><?php
            foreach($recettes as $indiceRecette => $recette){ 
                if(in_array($indiceRecette, $recettesParCategorie[$categorieCourante])){ // On affiche les recettes qui match avec la catégorie courante 
                    $img = searchImageRecette($recette) // On cherche l'image correspondante à la recette ?>
                    <div class="inner">
                        <h2><a href="?page=RecetteDetaillee&chemin=<?php echo $_GET['chemin']; ?>&recette=<?php echo $indiceRecette ?>" > <?php echo $recette['titre'] ?></a></h2> 
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
    }
?>  

<?php affichageRecettesSynthetique(); ?>