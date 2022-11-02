<?php 
    include("donnees.inc.php");
    
    foreach($hierarchie as $categorie => $ssCategorie)
    {
        echo 'categorie = '. $categorie ."\n";
        echo 'sousCategorie = '. $ssCategorie[0] ."\n";

     }
?>
