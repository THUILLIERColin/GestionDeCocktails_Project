<?php 
    
    /*
    * Fonction qui affiche toutes les recettes par rapport à la catégorie courante
    */

    // Je dois garder une fonction ou bien c'est mieux de juste mettre le code brut ?
    function affichageRecettesSynthetique(){
<<<<<<< Updated upstream
=======
        if(file_exists("donneeFav.php")){
            include("donneeFav.php") ;
        }
>>>>>>> Stashed changes
        global $recettes;  // Tableau qui contient toutes les recettes
        global $recettesParCategorie; // Tableau qui contient les recettes pour chaque categorie
        global $chemin; $categorieCourante = end($chemin); // On récupère la catégorie courante ?>
        <div id='recette'>
            <div class='outer'><?php $compteurDeTuile = 0;
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
<<<<<<< Updated upstream
=======
                        <input id="<?php echo $indiceRecette?>" value="🖤"type="button" onclick="fav(this.id)"></input>
                        <?php
                        if(isset($_SESSION["user"]["login"])){
                           if(isset($utilisateur)){
                            foreach($utilisateur as $nomEtRecette){
                                if($_SESSION["user"]["login"]==$nomEtRecette[0]){
                                    if(in_array($indiceRecette,$nomEtRecette[1])){ ?>
                                        <script>document.getElementById(<?php echo $indiceRecette?>).value ="❤️";</script><?php
                                    }
                                }
                            }
                        } 
                        }else{
                        
                            if(in_array($indiceRecette,$_SESSION["favTemp"])){ ?>
                                <script>document.getElementById(<?php echo $indiceRecette?>).value ="❤️";</script><?php
                            }
                        
                        }
                        ?>
>>>>>>> Stashed changes
                    </div><?php
                $compteurDeTuile++;}
                if($compteurDeTuile == 3){
                    if(isset($recettes[$indiceRecette+1])&&in_array($indiceRecette, $recettesParCategorie[$categorieCourante])){
                        echo ("</div><div class='outer'>");
                      }else{
                        echo("</div>");
                      
                      }
                   $compteurDeTuile = 0;
                }
            }?>
            </div>
        </div><?php
    }
?>  

<?php affichageRecettesSynthetique(); ?>