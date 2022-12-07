<?php 
    
    /*
    * Fonction qui affiche toutes les recettes par rapport à la catégorie courante
    */
    $_SESSION["favTemp"]=array();

    // Je dois garder une fonction ou bien c'est mieux de juste mettre le code brut ?
    function affichageRecettesSynthetique(){
        include("donneeFav.php") ;
        global $recettes;  // Tableau qui contient toutes les recettes
        global $recettesParCategorie; // Tableau qui contient les recettes pour chaque categorie
        global $chemin; $categorieCourante = end($chemin); // On récupère la catégorie courante ?>
        <div id='recette'>
            <div class='outer'><?php $compteurDeTuile = 0;
            foreach($recettes as $recette => $tabRecette){ 
                if(in_array($recette, $recettesParCategorie[$categorieCourante])){ // On affiche les recettes qui match avec la catégorie courante 
                    AffichageRecette($recette);
                }
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

?>  

<?php affichageRecettesSynthetique(); ?>