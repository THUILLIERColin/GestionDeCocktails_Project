<?php   
    
    // Il faut créer un fichier de données avec les fruits en entrée puis chaque 
    // fruit est un tableau contenant les recettes qui match avec les fruits

    // utiliser strtr pour trouver les images correspondantes aux cocktails


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
    