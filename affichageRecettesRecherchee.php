<?php
    if(!empty($alimentsSouhaites) || !empty($alimentsNonSouhaites)){
        // Calcul le nombre de critères
        $nbCriteres = count($alimentsSouhaites) + count($alimentsNonSouhaites);

        // On crée un tableau qui contient les recettes et on calcul leur score
        foreach($recettes as $recette => $tabRecette){
            $tabRecetteScore[$recette] = 0;
            // 2 si c'est dans fruit et pas dans cannelle
            // 1 si c'est un cocktail qui n'a pas de cannelle et qui n'a pas dans fruit

            if(!empty($alimentsSouhaites)){
                foreach($alimentsSouhaites as $aliment){
                    if(in_array($recette, $recettesParCategorie[$aliment])){
                        $tabRecetteScore[$recette]++;
                    }
                }
            }
            if(!empty($alimentsNonSouhaites)){
                foreach($alimentsNonSouhaites as $aliment){
                    if(!in_array($recette, $recettesParCategorie[$aliment])){
                        $tabRecetteScore[$recette]++;
                    }
                    else $tabRecettesAEnlever[$recette] = $recette;
                }
            }
        }

        // On enlève les recettes qui ne contiennent les aliments non souhaités
        if(!empty($tabRecettesAEnlever)){
            foreach($tabRecettesAEnlever as $recette){
                unset($tabRecetteScore[$recette]);
            }
        }

        // On trie le tableau par ordre décroissant
        arsort($tabRecetteScore);

        // Affichage des recettes correspondantes aux contraintes 
        foreach($tabRecetteScore as $recette => $score){
            if($score > 0) {
                $img = searchImageRecette($recettes[$recette]) ?>
                <div class="inner">
                    <span class="score"><?php echo 'Score : '.round(100*($score/$nbCriteres),2).'%'; ?></span>
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
        }
    }
    else echo 'Problème dans votre requête : recherche impossible. <br/>';
?>